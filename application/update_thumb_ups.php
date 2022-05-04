<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$myupdate = establish_conn();
$aid = $_POST['aid'];
$user = $_SESSION['username'] ?? "";

if ($user == "") {
//    echo "<script>alert('You have not logged in!')</script>";
    return;
}

$sql = "select like_status 
        from Likes
        where username = ? and aid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $user, $aid);
$stmt->execute();
$stmt->bind_result($like_status);
$stmt->store_result();
$stmt->fetch();

if ($stmt->num_rows == 0) {
    $sql_insert = "insert into Likes (username, aid) values (?, ?)";

    $update = $myupdate->prepare($sql_insert);
    $update->bind_param("si", $user, $aid);
    $update->execute();
} else if ($like_status == 1) {
    $mysqli->query("drop procedure if exists update_likes_0");
    $mysqli->query("create procedure 
            update_likes_0(in uname varchar(45), in id int) 
            begin 
            select * from likes where username = uname and aid = id; 
            update Likes
            set like_status = 0
            where username = uname and aid = id; end;");
    $update_stmt = $mysqli->prepare("call update_likes_0(?, ?)");
    $update_stmt->bind_param("si", $user, $aid);
    $update_stmt->execute();
    $update_stmt->close();
//    $sql_update_0 = "update Likes
//            set like_status = 0
//            where username = ? and aid = ?";
//
//    $update = $myupdate->prepare($sql_update_0);
//    $update->bind_param("si", $user, $aid);
//    $update->execute();
} else if ($like_status == 0){
//    $sql_lock_1 = "select * from likes where username = ? and aid = ? for update";
//    $sql_update_1 = "update Likes
//            set like_status = 1
//            where username = ? and aid = ?";

//    $lock_1 = $myupdate->prepare($sql_lock_1);
//    $lock_1->bind_param("si", $user, $aid);
//    $lock_1->execute();
//    $lock_1->close();
//
//    $update = $myupdate->prepare($sql_update_1);
//    $update->bind_param("si", $user, $aid);
//    $update->execute();

    $mysqli->query("drop procedure if exists update_likes_1");
    $mysqli->query("create procedure 
            update_likes_1(in uname varchar(45), in id int) 
            begin 
            select * from likes where username = uname and aid = id; 
            update Likes
            set like_status = 1
            where username = uname and aid = id; end;");
    $update_stmt = $mysqli->prepare("call update_likes_1(?, ?)");
    $update_stmt->bind_param("si", $user, $aid);
    $update_stmt->execute();
    $update_stmt->close();
}

$stmt->close();
//$update->close();
$mysqli->close();
$myupdate->close();