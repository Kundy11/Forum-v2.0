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
                if(isset($_SESSION["userid"])){
                    echo '<li><a href="profile.php">PROFILE PAGE</a></li>
                          <li><a href="includes/logout.inc.php">LOG OUT</a></li>';
                }
                else{
                    echo '<li><a href="signup.php">SIGN UP</a></li>
                          <li><a href="login.php">LOG IN</a></li>';
                }
            ?>
        </ul>
    </nav>
    <div class="login">
        <h2>Log In</h2>
        <form action="includes/login.inc.php" method="post">
            <input type="text" placeholder="Username/Email..." name="username">
            <input type="password" name="password" placeholder="Password...">
            <button type="submit" name="submit">Log In</button>
        </form>
        <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "emptyinputs"){
                echo '<p class="error">Fill in all inputs!</p></p>';
            }
            if($_GET["error"] == "wronglogin"){
                echo '<p class="error">Wrong username or password!</p></p>';
            }
            if($_GET["error"] == "wrong"){
                echo '<p class="error">Something went wrong</p>';
            }
        }
        ?>
    </div>
</body>
</html>