<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
}
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
    <div class="show-article">
    <?php
        if(isset($_GET["id"])){
            include("includes/connection.php");
            $id = $_GET["id"];
            $query = "SELECT * FROM articles WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            echo ('<div class="show-article-article">
                    <div class="show-article-header">
                        <p class="show-article-author">' . $row["author"] . '</p>
                        <p class="show-article-date">' . $row["date"] . '</p>
                    </div>
                    <div class="show-article-title">' . $row["title"] . '</div>
                    <hr class="splitter">
                    <div class="show-article-content">
                        <p class="show-article-text">
                            <a href="article.php?id=' . $row["id"] . '">
                                ' . $row["content"] . '
                            </a>
                        </p>
                    </div>
                    <div class="show-article-footer">
                        <div class="show-article-interaction">
                            <form action="includes/interactions.inc.php" method="post">
                                <button type="submit" name="comment">Comment</button>
                                <button type="submit" name="save">Save</button>
                                <button type="submit" name="like">Like: ' . $row["likes"] . '</button>
                                <input type="hidden" name ="article_id" value="' . $row["id"] . '">
                            </form>');
            if($_SESSION["username"] == $row["author"]){
                    echo('<form action="includes/interactions.inc.php" method="post">
                            <button type="submit" name="delete">Delete</button>
                            <input type="hidden" name="article_id" value="' . $row["id"] . '">
                            </form>');
                }
            echo('</div></div></div>'); 
        }
    ?>
    <div class="comment-section">
        <div class="add-comment">
            <h2 class="title-add-comment">Add a comment</h2>
            <form action="includes/interactions.inc.php" method="post">
                <textarea class="comment-textarea" name="content" cols="130" rows="2"></textarea>
                <input type="hidden" name="article_id" value="<?php echo $_GET["id"];?>">
                <button type="submit" name="comment">Comment</button>
            </form>
        </div>
        <div class="comments">
            <?php
            $id = $_GET["id"];
            $query = "SELECT * FROM comments WHERE id_article = '$id' ORDER BY date DESC";
            $comment = mysqli_query($conn, $query);
            foreach ($comment as $c) {
                $id_user = $c["id_user"];
                $result_user = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id_user'");
                $user = mysqli_fetch_assoc($result_user);
                echo('<div class="comment">
                        <div class="comment-head">
                            <div class="author-comment">' . $user["username"] . '</div>
                            <div class="date-comment">' . $c["date"] . '</div>
                        </div>
                        <div class="comment-content">
                            ' . $c["comment"] . '
                        </div>');
                        if($user["username"] == $_SESSION["username"]){
                            echo('<div class="comment-delete">
                                    <form action="includes/interactions.inc.php" method="post">
                                        <button type="submit" name="delete-comment">Delete</button>
                                        <input type="hidden" name="article_id" value ="' . $row["id"] . '">
                                        <input type="hidden" name="user_id" value ="' . $c["id"] . '">
                                    </form>
                                </div>');
                        }
                        echo('</div>');
            }
            ?>
        </div>
    </div>
    </div>
</body>
</html>