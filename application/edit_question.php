<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$qid = $_POST['qid'];
$p_user = $_POST['p_user'];
$title = $_POST['title'];
$body = $_POST['body'];
$c_user = $_SESSION['username'] ?? "dft";
$time = date('Y-m-d H:i:s');

if ($c_user == "dft") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
    echo "<script>alert('You cannot edit this question because you are not the owner of this question!')</script>";
    return;
}

$sql = "update Questions 
        set title = ?, q_body = ?, post_time = ?
        where qid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssi", $title, $body, $time, $qid);
try
{
    $stmt -> execute();
    echo "<script>alert('Edited a question!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}