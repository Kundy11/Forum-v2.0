<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
}
include("includes/connection.php");
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
    <div class="articles">
        <?php
        $articles = mysqli_query($conn,"SELECT * FROM articles ORDER BY date DESC");
        foreach($articles as $a){
            echo ('<div class="article">
                    <div class="article-header">
                        <p class="author">' . htmlspecialchars($a["author"]) . '</p>
                        <p class="article-date">' . htmlspecialchars($a["date"]) . '</p>
                    </div>
                    <div class="article-title">' . $a["title"] . '</div>
                    <hr class="splitter">
                    <div class="article-content">
                        <p class="article-text">
                            <a href="article.php?id=' . $a["id"] . '">
                                ' . $a["content"] . '
                            </a>
                        </p>
                    </div>
                    <div class="article-footer">
                        <div class="article-interaction">
                            <form action="includes/interactions.inc.php" method="post">
                                <button type="submit" name="comment-before">Comment</button>
                                <button type="submit" name="save">Save</button>
                                <button type="submit" name="like">Like: ' . $a["likes"] . '</button>
                                <input type="hidden" name ="article_id" value="' . $a["id"] . '">
                            </form>');
                if($_SESSION["username"] == $a["author"]){
                    echo('<form action="includes/interactions.inc.php" method="post">
                            <button type="submit" name="delete">Delete</button>
                            <input type="hidden" name="article_id" value="' . htmlspecialchars($a["id"]) . '">
                            </form>');
                }
                echo('</div></div></div>'); 
        }    
        ?>
        
    </div>
</body>
</html>