<?php
session_start();
include('mysqlidb.php');
$mysqli = establish_conn();
$user = $_POST['login_user'];
$pass = hash('sha256', $_POST['login_pass']);
$user_check = $mysqli->prepare("select * from users where username = ?");
$user_check -> bind_param("s", $user);
$user_check -> execute();
$user_check -> store_result();
if(!$user_check->num_rows)
{
    echo "User Does not exist! Check your username!";
    $mysqli->close();
    return;
}

$pword_check = $mysqli->prepare("select * from users where username = ? and password = ?");
$pword_check -> bind_param("ss", $user, $pass);
$pword_check -> execute();
$pword_check -> store_result();
if($pword_check->num_rows)
{
    echo "Success!";
    $_SESSION['username'] = $user;
    $_SESSION['login'] = True;
}
else
{
    echo "Password does not match! Try it again!";
}
$mysqli->close();
?>