<?php
include('mysqlidb.php');
session_start();
if (!isset($_SESSION['username']))
{
    echo "<script>alert('You have not login in!')</script>";
    return;
}

$mysqli = establish_conn();
$qid = $_POST['qid'];
$user = $_SESSION['username'];
$body = $_POST['body'];

if ($body == null) {
    echo "<script>alert('You must set an answer body!')</script>";
    return;
}

$sql = "INSERT INTO Answers (qid, a_username, a_body) VALUES (?, ?, ?)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iss", $qid, $user, $body);
try
{
    $stmt -> execute();
    echo "<script>alert('Posted a new answer!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}

?>