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
    <link rel="stylesheet" href="css/newstyles.css">
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
    <div class="editor">
        <form action="includes/write_article.inc.php" method="post">
            <label for="title">Title</label>
            <textarea class="title" name="title" cols="150" rows="1"></textarea>
            <label for="content">Content</label>
            <textarea class="content" id="editor" name="content" cols="100" rows="20"></textarea>
            <div class="button">
                <button name="submit" type="submit" class="submit">Submit</button>
            </div>
            
        </form>
    </div>
    <script src="js/ckeditor5-build-classic\ckeditor.js"></script>
    <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
    </script>

</body>
</html>