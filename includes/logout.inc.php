<?php
session_start();

if(isset($_SESSION["username"])){
    session_unset();         
    session_destroy();
    unset($_SESSION['username']);
    header("Location: ../login.php");
}