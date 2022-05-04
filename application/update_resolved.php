<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$myupdate = establish_conn();
$qid = $_POST['qid'];
$p_user = $_POST['p_user'];
$c_user = $_SESSION['username'] ?? "";

if ($c_user == "") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

if ($c_user != $p_user) {
//    echo "<script>alert('You cannot set resolved because you are not the owner of this question!')</script>";
    return;
}

$sql = "select status 
        from Questions
        where qid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $qid);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

if ($status == "unsolved") {
    $mysqli->query("drop procedure if exists update_resolved_0");
    $mysqli->query("create procedure 
            update_resolved_0(in id int) 
            begin 
            select * from questions where qid = id for update; 
            update questions
            set status = 'resolved'
            where qid = id; end;");
    $update = $myupdate->prepare("call update_resolved_0(?)");
    $update->bind_param("i", $qid);
    $update->execute();
    $update->close();
//    $sql = "update Questions
//            set status = 'resolved'
//            where qid = ?";
} else {
    $mysqli->query("drop procedure if exists update_resolved_1");
    $mysqli->query("create procedure 
            update_resolved_1(in id int) 
            begin 
            select * from questions where qid = id for update; 
            update questions
            set status = 'unsolved'
            where qid = id; end;");
    $update = $myupdate->prepare("call update_resolved_1(?)");
    $update->bind_param("i", $qid);
    $update->execute();
    $update->close();
//    $sql = "update Questions
//            set status = 'unsolved'
//            where qid = ?";
}

$res = $status === "resolved" ? "unsolved" : "resolved";
echo "<script>alert('Mark question as $res')</script>";

//$lock = $myupdate->prepare($sql_lock);
//$lock->bind_param("i", $qid);
//$lock->execute();
//$lock->close();

//$update = $myupdate->prepare($sql);
//$update->bind_param("i", $qid);
//$update->execute();

//$update->close();
//$stmt->close();
$myupdate->close();
$mysqli->close();
?>