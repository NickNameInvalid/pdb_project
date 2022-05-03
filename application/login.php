<?php
session_start();
//error_reporting(0);
include('mysqlidb.php');
$mysqli = establish_conn();
$user = $_POST['login_user'];
if(isset($_SESSION['username']))
{
    echo "You've already login!";
    return;
}

$pass = hash('sha256', $_POST['login_pass']);
$user_check = $mysqli->prepare("select password from users where username = ?");
$user_check -> bind_param("s", $user);
$user_check -> execute();
$user_check->bind_result($password_hash);
$user_check -> store_result();
if(!$user_check->num_rows)
{
    echo "User Does not exist! Check your username!";
    $mysqli->close();
    $user_check->close();
//    header('Location: ../templates/login.html');
    return;
}

$user_check->fetch();
if($password_hash == $pass)
{
    $_SESSION['username'] = $user;
    echo "Success!";
//    header('Location: ../templates/main.html');
}
else
{
    echo "Password does not match! Try it again!";
//    header('Location: ../templates/login.html');
}

$mysqli->close();
$user_check->close();
?>