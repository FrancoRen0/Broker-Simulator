<?php

#======================== function prototypes: =============================

#==========================================================================

#initializing session:
session_start();

$conn = connect_to_db();

$emailVal = $_POST["email"];
$psswVal = $_POST["pssw"];

$resultQuery = setQuery($conn, $emailVal, $psswVal);

if ($resultQuery->num_rows > 0) {
    // output data of a row
    if($row = $resultQuery->fetch_assoc()) {
        $_SESSION['email'] = $row["email"];
        $_SESSION['password'] = $row["cl_password"];
        header("location: GM_AppManagement.php");
    }
}
else{
    $userErr = " * Wrong username or password, try again.";
    #header("location: Go_Market_inicioV3.html");
}

$disconn = disconnectdb($conn);


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

function setQuery($conn, $emailVal, $psswVal){

    $sql = "SELECT * FROM clients
            WHERE email = '$emailVal' AND cl_password = '$psswVal' ";

    $result = $conn->query($sql);    

    return $result;

}


function disconnectdb($conn){

    $conn->close();
}

?>
<!DOCTYPE html>

<html>
<head> 
    <link rel="Stylesheet" href="GMStyle_Inicio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
- Go Market signup -
</title>
</head>

<body class="pageStyle">
    <div class="main">
        <a href="Go_Market_inicioV3.html" class="logo">
            <img src="SBicon_2.png" alt="SBicon" class="logoImg"> 
            <h1> Go Market</h1>
        </a>
        <div class="nav">
            <ul class="menu">
                <li ><a href="Go_Market_inicioV3.html">|Home|</a></li>
                <li ><a href="Go_Market_Form.html">|Create Account|</a></li>
                <li ><a href="#">|Country|</a></li> 
                <li ><a href="#">|Menu|</a>
                    <ul class="submenu">
                        <li><a href="#bottomSection">About us</a></li>
                        <li><a href="Go_Market_inicioV3.html">Sign in</a></li>
                        <li><a href="#bottomSection">Contact</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
                                <!--popup de mensaje de error al ingresar: -->

    <div class="userval" id="uservalid" method="post"  action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">
        <span class="signupErr"> <?php echo $userErr; ?> </span>
    </div>

    <div class="apartado0">
        <div class="back_settings"></div>
        <h2> Inicie sesion o cree una cuenta totalmente gratis y mantengase al tanto de sus inversiones!</h2>
        <div class="square"></div>  
        <div class="Acc_info">
            <h3> Iniciar Sesion</h3>
            <form class="contentInput" action="signup_form.php" method="post">  
                <label for="iemail"> E-mail: </label>
                <input id="iemail" type="email" name="email" required></br>
                <label for="ipass"> Password:</label>
                <input id="ipass" type="password" name="pssw" required></br>
                <input type="submit" value="ingresar"> </br>
            </form>
        </div>
    </div>

    <div class="apartado1">
        <div class="square3"> </div>
        <div class="pageStyle1"></div>
        <p1><b> Nuevas funciones: puede invertir directamente desde nuestra pagina y enterarse de lo que ocurre en el mercado!</b> </p1>
        <div class="square2">
            <table>
                <tr>
                    <td > FedEx </td>
                    <td> 160.38 </td>
                    <td > -21.36% </td>
                </tr>
                <tr>
                    <td > Meta </td>
                    <td> 145.76 </td>
                    <td> -2.18% </td>
                </tr>
                <tr>
                    <td > Amazon </td>
                    <td> 123.08 </td>
                    <td> -2.17% </td>
                </tr>
                <tr>
                    <td > Tesla </td>
                    <td> 302.09 </td>
                    <td> 0.17% </td>
                </tr>
                <tr>
                    <td > Nvidia </td>
                    <td> 131.48 </td>
                    <td> 2.08% </td>
                </tr>
                <tr>
                    <td > Tilray Brands </td>
                    <td> 3.82 </td>
                    <td style="background-color: red";> -5.75% </td>
                </tr>
                <tr>
                    <td > Uniper </td>
                    <td> 3.82 </td>
                    <td style> -1.28% </td>
                </tr>
            </table>
        </div>
        <div class="square4" >
            <ul class="inform1">
                <li ><a href="Go_Market_inicioV3.html" > Buy/Sell </a></li>
                <li><a href="Go_Market_inicioV3.html" > Lastest news </a></li>
                <li ><a href="Go_Market_inicioV3.html" > Follow & share </a></li>
            </ul>
        </div>
        <div class="pieDePagina">
            <p2 id="bottomSection">informacion de contacto:</p2>
            <ul class="contacto">
                <li> Ciudad de Buenos Aires </li>
                <li> Tel: +54 1001 1100 11</li>
                <li> Calle: Alicia Moreau de Justo 1300 </li>
            </ul>
        </div>
    </div>
</body>
</html> 