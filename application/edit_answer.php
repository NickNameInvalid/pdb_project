<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$aid = $_POST['aid'];
$p_user = $_POST['p_user'];
$body = $_POST['body'];
$c_user = $_SESSION['username'] ?? "";
$time = date('Y-m-d H:i:s');

if ($c_user == "") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
    echo "<script>alert('You cannot edit this answer because you are not the owner of this answer!')</script>";
    return;
}

$sql = "update Answers 
        set a_body = ?, answer_time = ?
        where aid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssi", $body, $time, $aid);
try
{
    $stmt -> execute();
    echo "<script>alert('Edited an answer!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}