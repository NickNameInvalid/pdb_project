<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$aid = $_POST['aid'];
$p_user = $_POST['p_user'];
$c_user = $_SESSION['username'] ?? "";

if (empty($c_user)) {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
    echo "<script>alert('You cannot delete this answer because you are not the owner of this answer!')</script>";
    return;
}

$sql = "update Answers 
        set a_visible_status = 0
        where aid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $aid);
try
{
    $stmt -> execute();
    echo "<script>alert('Save answer successfully!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}