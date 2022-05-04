<?php
session_start();
//error_reporting(0);
include('mysqlidb.php');
$mysqli = establish_conn();
$user = $_POST['login_user'];
$pass = hash('sha256', $_POST['login_pass']);

if(isset($_SESSION['username']))
{
    echo "You've already login!";
    return;
}

$user_check = $mysqli->prepare("select username from Users where username = ? and password = ?");
$user_check -> bind_param("ss", $user, $pass);
$user_check -> execute();
$user_check->bind_result($has);
$user_check->fetch();

if($has == null) {
    echo "<script>alert('User Does not exist or password is incorrect!')</script>";
} else {
    $_SESSION['username'] = $user;
    echo 1;
}

$user_check->close();
$mysqli->close();

