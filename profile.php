<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
}

include("includes/connection.php");
include("includes/functions.inc.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>
    <nav>
        <a href="index.php" class="logo">Forum</a>
        <ul>
        <li><a href="index.php">HOME</a></li>
            <?php
                if(isset($_SESSION["username"])){
                    echo '<li><a href="profile.php">PROFILE PAGE</a></li>
                          <li><a href="write_article.php">ADD ARTICLE</a></li>
                          <li><a href="includes/logout.inc.php">LOG OUT</a></li>';
                }
                else{
                    echo '<li><a href="signup.php">SIGN UP</a></li>
                          <li><a href="login.php">LOG IN</a></li>';
                }
            ?>
        </ul>
    </nav>
    <div class="greeting"><p>Hello, <?php echo $_SESSION['username']; ?></p></div>
    <div class="profile">
        <h1 class="heading">Favorite Articles</h1>
        <div class="favorite-articles">
            <?php
                $data = get_data($conn);
                $id = $data["id"];
                $query = "SELECT * FROM favorites WHERE id_user = '$id'";
                $result = mysqli_query($conn, $query);
                foreach($result as $r){
                    $id_article = $r["id_article"];
                    $query = "SELECT * FROM articles WHERE id = '$id_article'";
                    $article = mysqli_query($conn, $query);
                    foreach($article as $a){
                        echo ('<div class="fav-article">
                                    <div class="fav-article-title"><a href="article.php">' . $a["title"] . '</a></div>
                                    <form action="includes/interactions.inc.php" method="post">
                                        <button type="submit" name="unsave">Unsave</button>
                                        <input type="hidden" name="id_article" value="' . $a["id"] . '">
                               </div>');
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>