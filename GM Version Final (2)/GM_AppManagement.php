
<?php
    session_start();

    #consulto base de datos (clientes) y extraigo datos
    $conn = database_conn();

    #retorna el nombre del cliente.
    $client_name = sqlname($conn);


    //guardar el id del cliente de la sesión
    $idclient = $_SESSION['id_cliente'];    



    // Obtengo datos de tabla positions:

    $sql = "SELECT * FROM positions
    WHERE client_id = '$idclient' ";  

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $wallet = $row['pos_wallet'];


    // ==Obtengo datos por POST ==

    $buyValue = 0;
    $sellValue = 0;
    $productName = "";
    $buyQty = 0;
    $sellQty = 0;

    #obtengo valores del producto
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $buyValue = $_POST['buyPrice'];
        $sellValue = $_POST['sellPrice'];
        $productName = $_POST['productName'];
        $buyQty = $_POST['cantidad'];
        $sellQty = $_POST['cantidad2'];
    } 
    else{
        $cantidad = "input Error: variable not defined";
    }

    // Cargo datos a la base de datos "clientes":

    //operacion: vender
    if ($buyValue == 0 && $sellValue > 0){  // if Sell value is loaded
        $operation = "sell";
        if($sellValue <= $wallet){
            uploadProductData($conn, $sellValue, $productName, $operation, $sellQty, $wallet);
        }
        else{
            echo" <script type='text/javascript'> window.alert('ERROR: unable to complete operation'); </script>";
        }
    }

    //operacion: comprar
    if ($sellValue == 0 && $buyValue > 0){      //if buy value is loaded
        $operation = "buy";
        if($buyValue <= $wallet){
            uploadProductData($conn, $buyValue, $productName, $operation, $buyQty, $wallet);
        }
        else{
            echo" <script type='text/javascript'> window.alert('ERROR: unable to complete operation'); </script>";
        }
    }

//discon

    //-------- ----------------funciones----------------------------------


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

    function sqlname($conn){

        $emailVal = $_SESSION['email'];
        $psswVal = $_SESSION['password'];
        $returnVal = "";

        $sql = "SELECT * FROM clients
                WHERE email = '$emailVal' AND cl_password = '$psswVal' ";         

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                # PRUEBA:  echo "<br> id: ". $row["client_id"]. " - Name: ". $row["client_name"]. " " . $row["email"] . "<br>";
                $returnVal = $row["client_name"];
                $_SESSION['id_cliente'] = $row["client_id"];
            }
        } else {
            echo "0 results";
            $returnVal = "";
        }
        
        return $returnVal;
    }


    function uploadProductData($conn, $Value, $productName, $operation, $qty, $wallet){

        $idclient = $_SESSION['id_cliente'];

        //BUSCO EL PRODUCT ID DEL PRODUCTO

        $sql = "SELECT * FROM products
        WHERE pr_descr = '$productName' ";  

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $productId = $row["productId"];
            }
        }

        //INSERTO LOS PRODUCTOS EN ORDENES
        $orderStatus = 0;        // active=0 / closed=1;

        $sql = "INSERT INTO orders(or_clientId, or_prId, or_operation, or_qty ,or_totprice, or_status)
         VALUES ('$idclient', '$productId', '$operation', '$qty', '$Value', '$orderStatus') ";  

        $result = $conn->query($sql);

        //configurar WALLET despues de la compra:

        $wallet = $wallet - $Value;

        $sql = "UPDATE positions SET pos_wallet=$wallet WHERE client_id=$idclient ";
        $result = $conn->query($sql);


    }


    function disconnectdb($conn){

        $conn->close();
    }


?>
    <!-- ==================================================================== HTML DINAMICO ==========================-->
    <!-- =============================================================================================================-->

    <div id="back2" class="back_settings2"></div>
        <div class="main" id="mainid">
            <a class="logo" href="#">
                <img src="SBicon_2.png" alt="SBicon" class="logoImg"> 
                <h1>Go Market</h1>
            </a>
            <ul class="opciones">
                <li> <p class="cl_name"> <?php echo $client_name; ?> </p></li>
                <li><a href="GM_AppManagement.php" class="home">|Home|</a></li>
                <li><a href="Go_Market_inicioV3.html" class="sign out">|Log out|</a></li> 
                <li><a href="#ToPieDePag" class="contact">|Contact|</a></li> 
                <li><a href="#" class="menu">|Menu|</a>
                    <ul class="submenu">
                        <li><a href="Go_Market_Account.php">Account</a></li>
                        <li><a href="#">Investments</a></li>
                        <li><a href="https://www.google.com/finance/?hl=es">Lastest News</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>


<!DOCTYPE html>
<html>
<head>
    <link rel="Stylesheet" href="GMStyle_app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        -Go Market App-
    </title>
</head>

<body id="bodySettings">

    <div class="back_settings" id="backSettings">
        <!-- ---------------------pie de pagina ---->
        <div id="ToPieDePag" class="pieDePagina">
            <p2 id="bottomSection">información de contacto:</p2>
            <ul class="contacto">
                <li> Ciudad de Buenos Aires </li>
                <li> Tel: +54 1001 1100 11</li>
                <li> Calle: Alicia Moreau de Justo 1300 </li>
            </ul>
        </div>
    </div>


    <div class="apartado_1" id = "apartado1">
        <h2> Encuentre el mercado en el que esté interesado: </h2>
        <p1> Puede buscar entre varias opciones, seleccione una para comenzar !</p1>

        <section class="slider">
            
            <div class="sliderContainer container">
                <input type="button" class="slideButton" value="<" id="before"> </input>

                <section class="apartado1_1 showApartado" data-id="1">
                    <div class="opcionesCompra">
                        <a href="#ToDivisas" class="divisasTxt" onclick="openInvestments()"> Divisas </a>
                        <a href="#ToDivisas" onclick="openInvestments()"> <img href="ToDivisas" src="currencies.jpg" alt="MoneyIcon" class="Divisas"></a>
                        <a href="#ToAcciones" class="accionesTxt" onclick="openInvestments()"> Acciones</a>
                        <a href="#ToAcciones" onclick="openInvestments()"> <img href="#ToAcciones" src="acciones.jpg" alt="empresasLogo" class="Acciones"></a>
                        <a href="#ToMaterias" class="materiasTxt" onclick="openInvestments()"> Materias primas</a>
                        <a href="#ToMaterias" onclick="openInvestments()"> <img src="materiasP.jpg" alt="Mat_primas" class="Materias"></a>
                    </div>
                </section>

                <section class="apartado1_1" data-id="2">
                    <div class="leaderboard">
                        <a href="#rankingList"><img src="leaderboard.png" alt="trophy" class="leadImg"></a>
                        <input type="button" class="rankingTitle" id="rankingT" value="Leaderboard" onclick="openRanking()"></button>
                    </div>
                    <h4 class="rankingTitle2">
                        Lidera el ranking de cada mes según sus ganancias!
                    </h4>
                </section>

                <input type="button" class="slideButton" value=">" id="next"> </input>
            </div>
        </section>
    </div>
    

    <!--------------------------------------------------------------- opcion: comprar-->
    <div class = "popupOperacion" id="popupOperacion">
        <input id="closeButton" value="X" type="button" name="closeBut" onclick="popupClose()"></br>
        <h4 class="hOperacion" id="operationTitle" name="product"> </h4>
        <form id="formDiv" class="formOperacion" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class= "listaOperacion">
                <input type="text" id="prName" name="productName" value=" " style="visibility: hidden; font-size: 1px;" ></br>
                <label for="cantidad">Cantidad:</label>
                <input type="text" id="cantidad" name="cantidad" value="1">
                <input type="button" value="-" class="bStyle" onclick="sub('precio')"></button>
                <input type="button" value="+" class="bStyle" onclick="add('precio')"></br>
            </div>
            <ul class="listaPrecio">
                <li for="precio">precio:</li>
                <li><input type="text" id="precio" name = "buyPrice" value="1" > </li>
            </ul>
            <input class="comprarButton" id="comprarDiv" type="submit" value="comprar" name="comprar"></br>
        </form>
    </div>
        <!--------------------------------------------------------------- opcion: vender-->
        <div class = "popupOperacion2" id="popupOperacion2">
        <input id="closeButton" value="X" type="button" name="closeBut" onclick="popupClose2()"></br>
        <h4 class="hOperacion" id="operationTitle2"> </h4>
        <form id="formDiv" class="formOperacion"  method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <div class="listaOperacion">
                <input type="text" id="prName2" name="productName" value=" " style="visibility: hidden; font-size: 1px;" ></br>
                <label for="cantidad">Cantidad:</label>
                <input type="text" id="cantidad2" name="cantidad2" value="1">
                <input type="button" value="-" class="bStyle" onclick="sub2('precio2')"></button>
                <input type="button" value="+" class="bStyle" onclick="add2('precio2')"></br>
            </div>
            <ul class="listaPrecio">
                <li for="precio">precio:</li>
                <li><input type="text" id="precio2" name="sellPrice" value="1" > </li>
            </ul>
            <input class="comprarButton" id="comprarDiv" type="submit" value="vender" name = "vender"></br>
        </form>
    </div>


    <!--========================== Leaderboard list ====================== -->
    <div class="leaderboardList" id="rankingList">
        <h3>Leaderboard</h3>
        <h4>Encuentra a los mejores inversores hasta el momento!</h4>
        <table class="rankingTable">
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Investments</th>
                <th>Total</th>
            </tr>
            <?php

            //---------------------------ordeno de "positions" el "pos_wallet" de mayor a menor-----------------------
            $wallet1 = 0;
            $cont = 1;

            $sql3 = "SELECT * FROM positions ORDER BY pos_wallet DESC";
            $result3 = $conn->query($sql3);

            
            if ($result3->num_rows > 0) {
                while ($row3 = $result3->fetch_assoc()) {
                    $wallet1 = $row3["pos_wallet"];
                    $posclosed = $row3["pos_totactive"];
                    $posactive =$row3["pos_totclosed"];
                    $result = $posactive + $posclosed; 
                    $clid = $row3['client_id'];

                    $sql4 = "SELECT * FROM clients WHERE client_id=$clid";
                    $result4 = $conn->query($sql4);
                    $row4 = $result4->fetch_assoc();
                    $clientN = $row4["client_name"];

            
                    echo "<tr>
                            <td id='rankPos'>{$cont}</td>
                            <td id='name'> $clientN </td>
                            <td id='totalInv'>$result</td>
                            <td id='wallet'>{$wallet1}</td>
                          </tr>";
            
                    $cont++;
                }
            }
            ?>
        </table>
    </div>

    <!-------------------------------OPERACIONES: DIVISAS----------------------------------->
    <!-------------------Agregar algoritmo para modificar precios de compra/venta------------>

    <div class="square"></div>
    <div id="ToDivisas" class="apartado2"> 
        <h3> Divisas </h3>
        <table class="CTable"> 
            <td><h4 class="tituloTabla"> Venta / Compra </h4></td>      
            <tr>
                <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="EUR/USD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_eurusd" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_eurusd" value="0" name="b_price">  </td>
                    <input id="openingPrice1" name="openingPrice1" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="eurusd" onclick="popupOpen2('EUR/USD','s_eurusd','b_eurusd')"></button> </li>
                        <li> <input type="button" value="Buy" name="eurusd" onclick="popupOpen('EUR/USD','s_eurusd','b_eurusd')"></button></li>
                        <li> <input type="button" value="+ info" onclick="showAlert('EUR/USD','openingPrice1')"></br> </li>
                    </ul>
                </td>
                </form>
            </tr>
            <tr>
                <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="USD/JPY" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_usdjpy" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_usdjpy" value="0" name="b_price">  </td>
                    <input id="openingPrice2" name="openingPrice2" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="usdjpy" onclick="popupOpen2('USD/JPY','s_usdjpy','b_usdjpy')"></button> </li>
                        <li> <input type="button" value="Buy" name="usdjpy" onclick="popupOpen('USD/JPY','s_usdjpy','b_usdjpy')"></button> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('USD/JPY','openingPrice2')" ></br> </li>
                    </ul>
                </td>
                </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="GBP/USD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_gbpusd" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_gbpusd" value="0" name="b_price">  </td>
                    <input id="openingPrice3" name="openingPrice3" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "gbpusd" onclick="popupOpen2('GBP/USD','s_gbpusd','b_gbpusd')"></br> </li>
                        <li> <input type="button" value="Buy" name = "gbpusd" onclick="popupOpen('GBP/USD','s_gbpusd','b_gbpusd')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('GBP/USD','openingPrice3')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>   
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="USD/TRY" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_usdtry" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_usdtry" value="0" name="b_price">  </td>
                    <input id="openingPrice4" name="openingPrice4" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "usdtry" onclick="popupOpen2('USD/TRY','s_usdtry','b_usdtry')"></br> </li>
                        <li> <input type="button" value="Buy" name = "usdtry" onclick="popupOpen('USD/TRY','s_usdtry','b_usdtry')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('USD/TRY','openingPrice4')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="USD/CAD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_usdcad" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_usdcad" value="0" name="b_price">  </td>
                    <input id="openingPrice5" name="openingPrice5" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "usdcad" onclick="popupOpen2('USD/CAD','s_usdcad', 'b_usdcad')"></br> </li>
                        <li> <input type="button" value="Buy" name = "usdcad" onclick="popupOpen('USD/CAD','s_usdcad', 'b_usdcad')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('USD/CAD','openingPrice5')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="EUR/JPY" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_eurjpy" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_eurjpy" value="0" name="b_price">  </td>
                    <input id="openingPrice6" name="openingPrice6" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "eurjpy" onclick="popupOpen2('EUR/JPY','s_eurjpy', 'b_eurjpy')"></br> </li>
                        <li> <input type="button" value="Buy" name = "eurjpy" onclick="popupOpen('EUR/JPY','s_eurjpy', 'b_eurjpy')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('EUR/JPY','openingPrice6')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="AUD/USD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_audusd" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_audusd" value="0" name="b_price">  </td>
                    <input id="openingPrice7" name="openingPrice7" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "audusd" onclick="popupOpen2('AUD/USD','s_audusd', 'b_audusd')"></br> </li>
                        <li> <input type="button" value="Buy" name = "audusd" onclick="popupOpen('AUD/USD','s_audusd', 'b_audusd')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('AUD/USD','openingPrice7')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="EUR/GBP" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_eurgbp" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_eurgbp" value="0" name="b_price">  </td>
                    <input id="openingPrice8" name="openingPrice8" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "eurgbp" onclick="popupOpen2('EUR/GBP','s_eurgbp', 'b_eurgbp')"></br> </li>
                        <li> <input type="button" value="Buy" name = "eurgbp" onclick="popupOpen('EUR/GBP','s_eurgbp', 'b_eurgbp')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('EUR/GBP','openingPrice8')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="GBP/NZD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_gbpnzd" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_gbpnzd" value="0" name="b_price">  </td>
                    <input id="openingPrice9" name="openingPrice9" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "gbpnzd" onclick="popupOpen2('GBP/NZD','s_gbpnzd', 'b_gbpnzd')"></br> </li>
                        <li> <input type="button" value="Buy" name = "gbpnzd" onclick="popupOpen('GBP/NZD','s_gbpnzd', 'b_gbpnzd')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('GBP/NZD','openingPrice9')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="GBP/CAD" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_gbpcad" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_gbpcad" value="0" name="b_price">  </td>
                    <input id="openingPrice10" name="openingPrice10" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "gbpcad" onclick="popupOpen2('GBP/CAD','s_gbpcad', 'b_gbpcad')"></br> </li>
                        <li> <input type="button" value="Buy" name = "gbpcad" onclick="popupOpen('GBP/CAD','s_gbpcad', 'b_gbpcad')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('GBP/CAD','openingPrice10')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="USDRUB" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_usdrub" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_usdrub" value="0" name="b_price">  </td>
                    <input id="openingPrice11" name="openingPrice11" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "usdrub" onclick="popupOpen2('USD/RUB','s_usdrub', 'b_usdrub')"></br> </li>
                        <li> <input type="button" value="Buy" name = "usdrub" onclick="popupOpen('USD/RUB','s_usdrub', 'b_usdrub')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('USD/RUB','openingPrice11')"></br> </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>

    <!-------------------------------OPERACIONES: ACCIONES------------------->



    <div id="ToAcciones" class="apartado3"> 
        <h3> Acciones </h3>
        <table class="CTable">
            <tr>                                  
            <td><h4 class="tituloTabla"> Venta / Compra </h4></td>  
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Tecent" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_tecent" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_tecent" value="0" name="b_price">  </td>
                    <input id="openingPrice12" name="openingPrice12" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "tecent" onclick="popupOpen2('Tencent','s_tecent', 'b_tecent')"></br> </li>
                        <li> <input type="button" value="Buy" name = "tecent" onclick="popupOpen('Tencent','s_tecent', 'b_tecent')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Tecent','openingPrice12')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Denso" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_denso" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_denso" value="0" name="b_price">  </td>
                    <input id="openingPrice13" name="openingPrice13" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "denso" onclick="popupOpen2('Denso','s_denso', 'b_denso')"></br> </li>
                        <li> <input type="button" value="Buy" name = "denso" onclick="popupOpen('Denso','s_denso', 'b_denso')"></br> </li>
                        <li> <input type="button" value="+ info"  onclick="showAlert('Denso','openingPrice13')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Xiaomi" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_xiaomi" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_xiaomi" value="0" name="b_price">  </td>
                    <input id="openingPrice14" name="openingPrice14" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "xiaomi" onclick="popupOpen2('Xiaomi','s_xiaomi', 'b_xiaomi')"></br> </li>
                        <li> <input type="button" value="Buy" name = "xiaomi" onclick="popupOpen('Xiaomi','s_xiaomi', 'b_xiaomi')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Xiaomi','openingPrice14')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr> 
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Bank of E.Asia" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_bea" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_bea" value="0" name="b_price">  </td>
                    <input id="openingPrice15" name="openingPrice15" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "bank of e. asia" onclick="popupOpen2('Bank_of_E_Asia','s_bea', 'b_bea')"></br> </li>
                        <li> <input type="button" value="Buy" name = "bank of e. asia" onclick="popupOpen('Bank_of_E_Asia','s_bea', 'b_bea')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Bank of E.Asia','openingPrice15')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Porsche AG" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_porsche" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_porsche" value="0" name="b_price">  </td>
                    <input id="openingPrice16" name="openingPrice16" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "porsche ag" onclick="popupOpen2('PorscheAG','s_porsche', 'b_porsche')"></br> </li>
                        <li> <input type="button" value="Buy" name = "porsche ag" onclick="popupOpen('PorscheAG','s_porsche', 'b_porsche')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('PorscheAG','openingPrice16')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Apple" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_apple" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_apple" value="0" name="b_price">  </td>
                    <input id="openingPrice17" name="openingPrice17" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "apple" onclick="popupOpen2('Apple','s_apple', 'b_apple')"></br> </li>
                        <li> <input type="button" value="Buy" name = "apple" onclick="popupOpen('Apple','s_apple', 'b_apple')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Apple','openingPrice17')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Tesla" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_tesla" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_tesla" value="0" name="b_price">  </td>
                    <input id="openingPrice18" name="openingPrice18" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "tesla" onclick="popupOpen2('Tesla','s_tesla', 'b_tesla')"></br> </li>
                        <li> <input type="button" value="Buy" name = "tesla" onclick="popupOpen('Tesla','s_tesla', 'b_tesla')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Tesla','openingPrice18')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Colruyt" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_colruyt" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_colruyt" value="0" name="b_price">  </td>
                    <input id="openingPrice19" name="openingPrice19" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "colruyt" onclick="popupOpen2('Colruyt','s_colruyt', 'b_colruyt')"></br> </li>
                        <li> <input type="button" value="Buy" name = "colruyt" onclick="popupOpen('Colruyt','s_colruyt', 'b_colruyt')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Colruyt','openingPrice19')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="NIO" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_nio" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_nio" value="0" name="b_price">  </td>
                    <input id="openingPrice20" name="openingPrice20" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "nio" onclick="popupOpen2('NIO','s_nio', 'b_nio')"></br> </li>
                        <li> <input type="button" value="Buy" name = "nio" onclick="popupOpen('NIO','s_nio', 'b_nio')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('NIO','openingPrice20')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Alphabet" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_alphabet" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_alphabet" value="0" name="b_price">  </td>
                    <input id="openingPrice21" name="openingPrice21" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "alphabet" onclick="popupOpen2('Alphabet','s_alphabet', 'b_alphabet')"></br> </li>
                        <li> <input type="button" value="Buy" name = "alphabet" onclick="popupOpen('Alphabet','s_alphabet', 'b_alphabet')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Alphabet','openingPrice21')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Amazon" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_amazon" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_amazon" value="0" name="b_price">  </td>
                    <input id="openingPrice22" name="openingPrice22" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name = "amazon" onclick="popupOpen2('Amazon','s_amazon', 'b_amazon')"></br> </li>
                        <li> <input type="button" value="Buy" name = "amazon" onclick="popupOpen('Amazon','s_amazon', 'b_amazon')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Amazon','openingPrice22')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
        </table>
    </div>


    <!-------------------------------OPERACIONES: MATERIAS PRIMAS------------------->

    <div id="ToMaterias" class="apartado4"> 
        <h3> Materias Primas </h3>
        <table class="CTable">
            <tr>
            <td><h4 class="tituloTabla"> Venta / Compra </h4></td>  
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Petroleo" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_oil" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_oil" value="0" name="b_price">  </td>
                    <input id="openingPrice23" name="openingPrice23" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="petroleo" onclick="popupOpen2('Petroleo','s_oil', 'b_oil')"></br> </li>
                        <li> <input type="button" value="Buy" name="petroleo" onclick="popupOpen('Petroleo','s_oil', 'b_oil')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Petroleo','openingPrice23')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Plata" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_plata" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_plata" value="0" name="b_price">  </td>
                    <input id="openingPrice24" name="openingPrice24" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="plata" onclick="popupOpen2('Plata','s_plata', 'b_plata')"></br> </li>
                        <li> <input type="button" value="Buy" name="plata" onclick="popupOpen('Plata','s_plata', 'b_plata')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Plata','openingPrice24')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Petroleo Brent" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_brent" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_brent" value="0" name="b_price">  </td>
                    <input id="openingPrice25" name="openingPrice25" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="petroleo brent" onclick="popupOpen2('Petroleo_Brent','s_brent', 'b_brent')"></br> </li>
                        <li> <input type="button" value="Buy" name="petroleo brent" onclick="popupOpen('Petroleo_Brent','s_brent', 'b_brent')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Petroleo_Brent','openingPrice24')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Oro" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_oro" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_oro" value="0" name="b_price">  </td>
                    <input id="openingPrice26" name="openingPrice26" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="oro" onclick="popupOpen2('Oro','s_oro', 'b_oro')"></br> </li>
                        <li> <input type="button" value="Buy" name="oro" onclick="popupOpen('Oro','s_oro', 'b_oro')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Oro','openingPrice26')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Azucar" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_azucar" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_azucar" value="0" name="b_price">  </td>
                    <input id="openingPrice27" name="openingPrice27" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="azucar" onclick="popupOpen2('Azucar','s_azucar', 'b_azucar')"></br> </li>
                        <li> <input type="button" value="Buy" name="azucar" onclick="popupOpen('Azucar','s_azucar', 'b_azucar')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Azucar','openingPrice27')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Cobre" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_cobre" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_cobre" value="0" name="b_price">  </td>
                    <input id="openingPrice28" name="openingPrice28" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="cobre" onclick="popupOpen2('Cobre','s_cobre', 'b_cobre')"></br> </li>
                        <li> <input type="button" value="Buy" name="cobre" onclick="popupOpen('Cobre','s_cobre', 'b_cobre')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Cobre','openingPrice28')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Paladio" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_paladio" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_paladio" value="0" name="b_price">  </td>
                    <input id="openingPrice29" name="openingPrice29" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="paladio" onclick="popupOpen2('Paladio','s_paladio', 'b_paladio')"></br> </li>
                        <li> <input type="button" value="Buy" name="paladio" onclick="popupOpen('Paladio','s_paladio', 'b_paladio')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Paladio','openingPrice29')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Cafe" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_cafe" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_cafe" value="0" name="b_price">  </td>
                    <input id="openingPrice30" name="openingPrice30" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="cafe" onclick="popupOpen2('Cafe','s_cafe', 'b_cafe')"></br> </li>
                        <li> <input type="button" value="Buy" name="cafe" onclick="popupOpen('Cafe','s_cafe', 'b_cafe')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Cafe','openingPrice30')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Gas natural" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_gasn" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_gasn" value="0" name="b_price">  </td>
                    <input id="openingPrice31" name="openingPrice31" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="gas natural" onclick="popupOpen2('Gas_Natural','s_gasn', 'b_gasn')"></br> </li>
                        <li> <input type="button" value="Buy" name="gas natural" onclick="popupOpen('Gas_Natural','s_gasn', 'b_gasn')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Gas_Natural','openingPrice31')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Gasolina" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_gasolina" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_gasolina" value="0" name="b_price">  </td>
                    <input id="openingPrice32" name="openingPrice32" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="gasolina" onclick="popupOpen2('Gasolina','s_gasolina', 'b_gasolina')"></br> </li>
                        <li> <input type="button" value="Buy" name="gasolina" onclick="popupOpen('Gasolina','s_gasolina', 'b_gasolina')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Gasolina','openingPrice32')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
            <tr>
            <form class="CForm" method="post" action="">
                    <td> <input type="text" id="prTitle" name="prTitle" value="Soja" style="color: blueviolet";> </td>
                    <td><input type="text" id="s_soja" value="0" name="s_price">  </td>
                    <td><input type="text" id="b_soja" value="0" name="b_price">  </td>
                    <input id="openingPrice33" name="openingPrice33" style="visibility:hidden; width:0.5px; height:0.5px; " value="0">
                <td class="positionLst">
                    <ul class="tableLst">
                        <li> <input type="button" value="Sell" name="soja" onclick="popupOpen2('Soja','s_soja', 'b_soja')"></br> </li>
                        <li> <input type="button" value="Buy" name="soja" onclick="popupOpen('Soja','s_soja', 'b_soja')"></br> </li>
                        <li> <input type="button" value="+ info" onclick="showAlert('Soja','openingPrice33')"></br> </li>
                    </ul>
                </td>
            </form>
            </tr>
        </table>

        <span id = "idDest"> </span>
    <!-- javascript here! -->
    <script src="GMScript_Leaderboard.js"> </script>
    <script src="GMScript_app.js"></script>
    <script src="cotizaciones.js"></script>
</body>
</html>

