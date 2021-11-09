<?php

include("connection.php");

function empty_input_signup($username, $email, $password, $confirm_password){

    if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function empty_input_login($username, $password){

    if(empty($username) || empty($password)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function invalid_username($username){

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function invalid_email($email){

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function password_match($password, $confirm_password){

    if($password !== $confirm_password){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
function username_exists($conn, $username, $email){
    $query = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../signup.php?error=wrong");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $result_data = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result_data)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function create_user($conn, $username,$email, $password){
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$hash_password')";
    $sql = mysqli_query($conn, $query);
    if(!$sql){
        header("Location: ../signup.php?error=wrong");
        exit();
    }
    else{
        header("Location: ../signup.php?error=none");
    }
}
function login_user($conn, $username, $password){
    $exists = username_exists($conn, $username, $username);

    if($exists === false){
        header("Location: ../login.php?error=wronglogin");
        exit();
    }

    $password_hashed = $exists["password"];
    $check_password = password_verify($password, $password_hashed);

    if($check_password === false){
        header("Location: ../login.php?error=wronglogin");
        exit();
    }
    else if($check_password === true){
        session_start();
        $_SESSION["username"] = $exists["username"];
        header("Location: ../index.php");
        exit();
    }
}
function get_data($conn)
{

	if(isset($_SESSION["username"]))
	{

		$username = $_SESSION["username"];
		$query = "select * from users where username = '$username' limit 1";

		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	header("Location: login.php");
	die;

}