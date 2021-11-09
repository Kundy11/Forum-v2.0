<?php
session_start();
include("connection.php");
include("functions.inc.php");

$user_data = get_data($conn);

if(isset($_POST["submit"])){
    $author = $user_data["username"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $query = "INSERT INTO articles (author, title, content) VALUES ('$author','$title','$content')";
    $result = mysqli_query($conn, $query);
    header("Location: ../index.php");
}
else {
    header("Location: ../write_article.php");
    die();
}