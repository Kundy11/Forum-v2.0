<?php
include("connection.php");
include("functions.inc.php");

if(isset($_POST["submit"])){
    $username = $_POST['username'];
    $password = $_POST["password"];

    //error handling
    if(empty_input_login($username, $password) !== false){
        header("Location: ../login.php?error=emptyinputs");
        exit();
    }

    login_user($conn, $username, $password);
        
}
else {
    header("Location: ../login.php");
}