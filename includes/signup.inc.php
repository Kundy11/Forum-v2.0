<?php
include("connection.php");
include("functions.inc.php");

if(isset($_POST["submit"])){
    $username = $_POST['username'];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    //error handling
    if(username_exists($conn, $username, $email) !== false){
        header("Location: ../signup.php?error=usernametaken");
        exit();
    }
    if(empty_input_signup($username, $email, $password, $confirm_password) !== false){
        header("Location: ../signup.php?error=emptyinputs");
        exit();
    }
    if(invalid_username($username) !== false){
        header("Location: ../signup.php?error=invalidusername");
        exit();
     }
     if(invalid_email($email) !== false){
         header("Location: ../signup.php?error=invalidemail");
         exit();
     }
     if(password_match($password, $confirm_password) !== false){
        header("Location: ../signup.php?error=passwordsdontmatch");
        exit();
     }

     create_user($conn, $username, $email, $password);
        
}
else {
    header("Location: ../signup.php");
}