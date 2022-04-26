<?php
session_start();
include('mysqlidb.php');
$mysqli = establish_conn();
$user = $_POST['login_user'];
$pass = hash('sha256', $_POST['login_pass']);
$user_check = "select * from users where username = '{$user}'";
$try_user = mysqli_query($mysqli, $user_check);
if(!mysqli_num_rows($try_user))
{
    echo "User Does not exist! Check your username!";
    $mysqli->close();
    return;
}
$pword_check = "select * from users where username = '{$user}' and password = '{$pass}'";
$try_pword = mysqli_query($mysqli, $pword_check);
if(mysqli_num_rows($try_pword))
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