
<?php 

#=================Functions prototypes=========================:

main();

#===============================================================

function main(){

    $conn = connect_to_db();
    insert_to_db($conn);

    $disconn = disconnectdb($conn);

    header("location: Go_Market_inicioV3.html");
}


function connect_to_db(){

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

function insert_to_db($conn){

    $nameVal = $_POST["name"];
    $emailVal = $_POST["email"];
    $psswVal = $_POST["pssw"];

    $sql = "INSERT INTO clients (client_name, email, cl_password)
        VALUES ('$nameVal', '$emailVal', '$psswVal')";

    $conn->query($sql);

    //get the client ID:

    $sql = "SELECT client_id FROM clients WHERE client_name='$nameVal'AND email='$emailVal' AND cl_password='$psswVal' ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $clientId = $row['client_id'];

    //creating the account's 'positiions'

    $wallet = 5500;
    $totalPositions = 0;
    $position_pr = 0;
    $position_lo = 0;


    $sql = "INSERT INTO positions (client_id, pos_totactive, pos_wallet, pos_profit, pos_loss)
            VALUES('$clientId', '$totalPositions', '$wallet', '$position_pr' , '$position_lo') ";
    $result = $conn->query($sql);

    /*
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "
        <!DOCTYPE html>
        <html>
        <body>
            <p> Name:   $nameVal</p>
            <p> Email:   $emailVal</p>
        </body>
        </html>
        ";
    } 
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    */

}


function disconnectdb($conn){

    $conn->close();
}

?> 









