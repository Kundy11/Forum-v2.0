<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "forum-v2";

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname); 

if(!$conn)
{
	die("failed to connect!");
}