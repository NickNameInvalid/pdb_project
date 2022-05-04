<?php
include('mysqlidb.php');
session_start();
if (!isset($_SESSION['username']))
{
    echo "<script>alert('You have not login in!')</script>";
    return;
}

$mysqli = establish_conn();
$user = $_SESSION['username'];
$stid = number_format($_POST['stid']) ?? "dft";
$title = $_POST['title'] ?? "";
$body = $_POST['body'] ?? "System remind: This user did not set a question body!";
if($stid == "dft")
{
    echo "<script>alert('Please set a subject topic!')</script>";
    return;
}

$stmt = $mysqli->prepare("INSERT INTO Questions (q_username, stid, title, q_body) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $user, $stid, $title, $body);
try
{
    $stmt -> execute();
    echo "<script>alert('Posted a new question!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}
?>