<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$myupdate = establish_conn();
$aid = $_POST['aid'];
$qid = $_POST['qid'];
$p_user = $_POST['p_user'];
$c_user = $_SESSION['username'] ?? "dft";

if ($c_user == "dft") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
    echo "<script>alert('You cannot set best answer because you are not the owner of this question!')</script>";
    return;
}

$sql = "select aid 
        from Answers natural join Questions
        where qid = ? and best_answer = 1";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $qid);
$stmt->execute();
$stmt->bind_result($cur_best);
$stmt->fetch();

// if we have a current best, set it to 0
if ($cur_best != null) {
    $sql = "update Answers 
            set best_answer = 0
            where aid = ?";
    $update = $myupdate->prepare($sql);
    $update->bind_param("i", $cur_best);
    $update->execute();
}

// if we do not have a current best or the current best is not the clicked one, set the clicked one to 1
if ($cur_best == null || $cur_best != $aid) {
    $sql = "update Answers 
            set best_answer = 1
            where aid = ?";
    $update = $myupdate->prepare($sql);
    $update->bind_param("i", $aid);
    $update->execute();
}

$update->close();
$stmt->close();
$myupdate->close();
$mysqli->close();

