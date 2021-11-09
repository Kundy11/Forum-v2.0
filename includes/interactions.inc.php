<?php
session_start();

include("connection.php");
include("functions.inc.php");

$id_user = $_SESSION["username"];

if(isset($_POST["save"])){
    $id_article = $_POST["article_id"];
    $data = get_data($conn);
    $id_user = $data["id"];
    
    $query = "INSERT INTO favorites (id_user, id_article) VALUES ('$id_user','$id_article')";
    mysqli_query($conn, $query);
    header("Location: ../index.php");
}

if(isset($_POST["delete"])){
    $id_article = $_POST["article_id"];

    $query = "DELETE FROM articles WHERE id = '$id_article'";
    mysqli_query($conn, $query);
    header("Location: ../index.php");
}

if(isset($_POST["unsave"])){
    $id_article = $_POST["id_article"];
    $data = get_data($conn);
    $id_user = $data["id"];

    $query = "DELETE FROM favorites WHERE id_user =  '$id_user' AND id_article = '$id_article'";
    mysqli_query($conn, $query);
    header("Location: ../profile.php");
}

if(isset($_POST["like"])){
    $id_article = $_POST["article_id"];
    $query = "UPDATE articles SET likes = likes+1 WHERE id = '$id_article'";
    mysqli_query($conn, $query);
    header("Location: ../index.php");
}

if(isset($_POST["comment-before"])){
    $id = $_POST["article_id"];
    header('Location: ../article.php?id=' . $id . '');
}

if(isset($_POST["comment"])){
    $id_article = htmlspecialchars($_POST["article_id"]);
    $data = get_data($conn);
    $id_user = $data["id"];
    $content = htmlspecialchars($_POST["content"]);

    $query = "INSERT INTO comments (id_article,id_user,comment) VALUES ('$id_article','$id_user','$content')";
    mysqli_query($conn, $query);
    header('Location: ../article.php?id=' . $id_article . '');
}
if(isset($_POST["delete-comment"])){
    $id_article = $_POST["article_id"];
    $id_comment = $_POST["user_id"];

    $query = "DELETE FROM comments WHERE id_article = '$id_article' AND id = '$id_comment'";
    mysqli_query($conn, $query);
    header('Location: ../article.php?id=' . $id_article . '');
}