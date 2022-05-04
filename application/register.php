<?php
session_start();
include('mysqlidb.php');
$mysqli = establish_conn();
$username = $_POST['reg_user'];
$pword1 = hash('sha256', trim($_POST['reg_pass1']));
$pword2 = hash('sha256', trim($_POST['reg_pass2']));

if ($pword1 != $pword2) {
    echo "<script>alert('Password 1 must be the same as password 2')</script>";
    $mysqli->close();
    return;
}

$sql = $mysqli->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
$sql->bind_param("ss", $username, $pword1);
try
{
    $sql->execute();
    $_SESSION['username'] = $username;
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Account already exist!')</script>";
} finally {
    $sql->close();
    $mysqli->close();
}
