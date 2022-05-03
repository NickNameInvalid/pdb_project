<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$qid = $_POST['qid'];
$p_user = $_POST['p_user'];
$c_user = $_SESSION['username'] ?? "dft";

if ($c_user == "dft") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
    echo "<script>alert('You cannot delete this question because you are not the owner of this question!')</script>";
    return;
}

$sql = "update Questions 
        set q_visible_status = 0
        where qid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $qid);

try
{
    $stmt -> execute();
    echo "<script>alert('Deleted a question!')</script>";
}
catch (mysqli_sql_exception $e)
{
    echo "<script>alert('Database error!')</script>";
} finally {
    $mysqli->close();
    $stmt->close();
}