<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$myupdate = establish_conn();
$aid = $_POST['aid'];
$qid = $_POST['qid'];
$p_user = $_POST['p_user'];
$c_user = $_SESSION['username'] ?? "";

if ($c_user == "") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
//    echo "<script>alert('You cannot set best answer because you are not the owner of this question!')</script>";
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
    $sql_lock_0 = "select * from Answers where aid = ? for update";
    $sql = "update Answers 
            set best_answer = 0
            where aid = ?";

    $lock_0 = $myupdate->prepare($sql_lock_0);
    $lock_0->bind_param("i", $cur_best);
    $lock_0->execute();
    $lock_0->close();

    $update = $myupdate->prepare($sql);
    $update->bind_param("i", $cur_best);
    $update->execute();

}

// if we do not have a current best or the current best is not the clicked one, set the clicked one to 1
if ($cur_best == null || $cur_best != $aid) {
    $sql_lock_1 = "select * from Answers where aid = ? for update";
    $sql = "update Answers 
            set best_answer = 1
            where aid = ?";

    $lock_1 = $myupdate->prepare($sql_lock_1);
    $lock_1->bind_param("i", $aid);
    $lock_1->execute();
    $lock_1->close();

    $update = $myupdate->prepare($sql);
    $update->bind_param("i", $aid);
    $update->execute();
    echo "<script>alert('Set new best answer successfully!')</script>";
}

$update->close();
$stmt->close();
$myupdate->close();
$mysqli->close();

