<?php

session_start();

#consulto base de datos (clientes) y extraigo datos
$conn = database_conn();

#retorna el nombre del cliente.
//$client_name = sqlname($conn);
$clientId = $_SESSION['id_cliente'];

$activePos = 0;
$closedPos = 0;
$resultOperation = 0;


    //get initial values from POSITIONS db:

    $sql = "SELECT * FROM positions
    WHERE client_id = '$clientId' ";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $totalPos = $row['pos_totactive'];
    $totalClosed = $row['pos_totclosed'];
    $wallet = $row['pos_wallet'];
    $prof = $row['pos_profit'];
    $loss = $row['pos_loss'];


// close position --> sent by post method

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $totalResult = 0;
    $startPrice = $_POST['initialPrice'];
    $startRate = $_POST['initialRate'];
    $currentPrice = $_POST['currentPrice'];
    $currentRate = $_POST['currentRate'];
    $resultOperation = $_POST['profitLoss'];
    $productName = $_POST['pr_title'];

    $addToWallet =  $startPrice + $resultOperation; // buy value + profit/loss

    //Searching for product id
    $sql = "SELECT * FROM products WHERE pr_descr='$productName' ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $productId = $row['productId'];

    //obtain ID of the chosen product
    $sql = "SELECT * FROM orders WHERE or_prId='$productId' AND or_status=0 AND or_clientId= '$clientId'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $orderId = $row['orderId'];

    sendClosedPositions( $conn,$clientId, $wallet, $addToWallet, $resultOperation, $orderId); //modify values "wallet" and "profitLoss" from positions
    updateOrders($conn, $orderId); //modify value "or_status" from orders
}


/* ============================Funciones PHP : ======================*/

function database_conn(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "clients_db";

    $dbConn = new mysqli( $servername, $username, $password, $dbname );

    if ($dbConn->connect_error){
        die("unable to connect to database".$dbconn->connect_error);
    }

    return $dbConn;
}

function loadingClientData( $conn, $orderId , $clientId, $activePos, $closedPos){

    $sql = "UPDATE positions SET pos_totactive=$activePos, pos_totclosed=$closedPos WHERE client_id=$clientId";

    $result = $conn->query($sql);
}


function sendClosedPositions($conn , $clientId ,$wallet, $addToWallet,$resultOperation , $orderId ){

    //UPDATE WALLET PRICE

    $totalPositions = $_SESSION['totalPos'];    //saves total active positions
    $totalClosed = $_SESSION['totalClosed'];    //saves total closed positions
    $wallet = $wallet + $addToWallet;       //update wallet price

    //Get elements from database (Positions)
    $sql = "SELECT * FROM positions WHERE client_id='$clientId' ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $position_pr = $row['pos_profit'];
    $position_lo = $row['pos_loss'];

    if($resultOperation > 0){
        $position_pr = $position_pr + $resultOperation;
        $position_lo = $position_lo;
    }
    else{
        $position_pr = $position_pr;
        $position_lo = $position_lo + $resultOperation;
    }  

    //count total open positions:
    $totalPositions = $totalPositions - 1;

    /* update table positions */
    $sql = "UPDATE positions SET pos_wallet='$wallet', pos_totactive='$totalPositions', pos_profit='$position_pr' , pos_loss='$position_lo'  WHERE client_id='$clientId' ";
    $result = $conn->query($sql);

}

// --Make an order active or closed
function updateOrders($conn, $orderId){

    $orderStatus = 1;    // active=0 / closed=1
    $sql = "UPDATE orders SET or_status='$orderStatus' WHERE orderId='$orderId' ";

    $result = $conn->query($sql);    

}


//=========================================================================================
?>


<!DOCTYPE html>
<html>
<head> 
    <link rel="Stylesheet" href="GMStyle_Account.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
- Go Market Create Account -
</title>
</head>

<body>
    <header class="header">
        <div class="back_settings"></div>
        <div class="main">
            <a href="Go_Market_Account.html" class="logo">
                <img src="SBicon_2.png" alt="SBicon" class="logoImg"> 
                <h1> Go Market</h1>
            </a>
            <div class="nav">
                <a href="Go_Market_Account.php" class="IconRef">
                    <img src="ProfileIcon.jpg" class="IconImg">
                </a>
                <ul class="menu">
                    <li style=" margin: 0; padding: 1%;"><a href="GM_AppManagement.php">|Home|</a></li>
                    <li style="margin: 0; padding: 1%;"><a href="Go_Market_inicioV3.html">|Log Out|</a></li>
                    <li style="margin: 0; padding: 1%;"><a href="#">|Menu|</a></li>
                </ul>
            </div>
        </div>
    </header>


    <div class="divPag">
        <h2 class="cartTitle"> Your positions </h2>
        <ul class="profileStats">
            <li> Wallet:  $<input type="text" value=<?php echo $wallet ?> > </li>
            <li> Total profit:  $<input type="text" value=<?php echo $prof ?> > </li>
            <li> Total loss:  $<input type="text" value=<?php echo $loss ?> > </li>
        </ul>

    <ul class="viewPos">
        <li> <input type='button' value='Open positions' id='openButton' onclick='showOpenP()' disabled> </li>
        <li> <input type='button' value='Closed positions' id='closeButton' onclick='showClosedP()'> </li>
    </ul>

        <!-----------------------------------Form de posiciones abiertas--------------------------> 
        <form method="post" action="">
            <table class="cartTable" id="IdCartTable">
                <tr>    
                    <th> Order number </th>
                    <th> Product </th>
                    <th> Operation </th>
                    <th> Quantity </th>
                    <th> Price </th>
                </tr>

                <?php 
                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)  {
                        // check if state is active=0 / closed=1
                
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $status = $row['or_status'];
                            if($clientId == $row["or_clientId"] && $status == 0 ){

                                $productId = $row['or_prId'];

                                //hallar el nombre mediante el ID:
                                $sql2 = " SELECT pr_descr FROM products WHERE productId = '$productId' ";
                                $result2 = $conn->query($sql2);
                                $row2 = $result2->fetch_assoc();
                                    
                                $orderId = $row['orderId'];
                                $productName = $row2['pr_descr'];
                                $orOperation = $row['or_operation'];
                                $qty = $row['or_qty'];
                                $price = $row['or_totprice'];

                                //Display TABLE popup:
                                echo "<tr> 
                                    <td> N° ".$orderId." </td>
                                    <td><input type='text' id='$productName' value='$productName'>  </td>
                                    <td>".$orOperation." </td>
                                    <td><input type='text' id='$qty' value='$qty' style='width:21%; font-weight:300;'> </td>
                                    <td class='priceStyle'>$<input type='text' id='$price' value='$price'> </td>
                                    <td><input class='openDetails' type='button' value='details' onclick=openDetails('$productName','$price','$qty','$orOperation')> </td>
                                    </tr>";
                                
                                $activePos++;
                                $_SESSION['totalPos'] = $activePos;
                                
                            }
        
                        }
                        if($activePos == 0){
                            echo "<h4 class='cartMessage'>You have currently 0 investments</h4>";
                        }
                    }
                    else{
                        echo "<h4 class='cartMessage'>You have currently 0 investments</h4>";
                    }

                ?>

            </table>
        </form>

        <!-----------------------------------Form de posiciones cerradas--------------------------> 
        <form method="post" action="">
            <table class="cartTable2" id="IdcartTable2">
                <tr>    
                    <th> Order number </th>
                    <th> Product </th>
                    <th> Operation </th>
                    <th> Quantity </th>
                    <th> Price </th>
                </tr>

                <?php 
                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)  {
                        // check if state is active=0 / closed=1
                
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $status = $row['or_status'];
                            if($clientId == $row["or_clientId"] && $status == 1 ){

                                $productId = $row['or_prId'];

                                //hallar el nombre mediante el ID:
                                $sql2 = " SELECT pr_descr FROM products WHERE productId = '$productId' ";
                                $result2 = $conn->query($sql2);
                                $row2 = $result2->fetch_assoc();
                                    
                                $orderId = $row['orderId'];
                                $productName = $row2['pr_descr'];
                                $orOperation = $row['or_operation'];
                                $qty = $row['or_qty'];
                                $price = $row['or_totprice'];

                                //Display TABLE popup:
                                echo "<tr> 
                                    <td> N° ".$orderId." </td>
                                    <td><input type='text' id='$productName' value='$productName'>  </td>
                                    <td>".$orOperation." </td>
                                    <td><input type='text' id='$qty' value='$qty' style='width:21%; font-weight:300;'> </td>
                                    <td class='priceStyle'>$<input type='text' id='$price' value='$price'> </td>
                                    <td> Closed </td>
                                    </tr>";
                             
                                $closedPos++;
                                $_SESSION['totalClosed'] = $closedPos;
                                
                            }
        
                        }
                        if($activePos == 0){
                            echo "<h4 class='cartMessage'>You have currently 0 investments</h4>";
                        }
                    }
                    else{
                        echo "<h4 class='cartMessage'>You have currently 0 investments</h4>";
                    }

                ?>

            </table>
        </form>

        <?php

        //updating 'positions' -> active positions / closed positions
        if($orderId!=NULL){
            loadingClientData($conn, $orderId ,$clientId, $activePos, $closedPos);
        }

        ?>


        <div class="popupDetails" id="popupDetails">
            <input type="button" class="closeButton" value="X" onclick="popupClose()">
            <form class="detailsForm" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="text" class="detailsTitle" id="detailsTitle" value="details" name='pr_title' style="width: 28%;"></br>
                <label>Price  $ <input type="text" id="initialRate" name="initialRate" class="prDetails" value=0 style="width: 17%; left:5%"> = $
                <input type="text" id="detailsPrice" name="initialPrice" class="prDetails" value=0 style="width: 17%;"></label></br>
                <label> Current Price  $<input type="text" id="priceRate" name="currentRate" class="prDetails" value="0" style="width: 17%; left:5%"> = $
                <input type="text" id="currentPrice" name="currentPrice" class="prDetails" value="0" style="width: 17%;"> </label></br>
                
                <label> Profit/Loss  $<input type="text" id="profitLoss" name="profitLoss" class="prDetails" value=0 style="width: 18%; left:5%"></label></br>
                <input type="submit" value="Close position">
            </form>
        </div>

    </div>

<!--/*---------------------------------Javascript here------------------------*/-->
<script src="GMScript_Account.js"></script>

</body>

<?php $conn->close(); ?>
