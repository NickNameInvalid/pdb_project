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
    $sql_update_0 = "update Likes
            set like_status = 0
            where username = ? and aid = ?";

    $update = $myupdate->prepare($sql_update_0);
    $update->bind_param("si", $user, $aid);
    $update->execute();
} else if ($like_status == 0){
    $sql_update_1 = "update Likes
            set like_status = 1
            where username = ? and aid = ?";

    $update = $myupdate->prepare($sql_update_1);
    $update->bind_param("si", $user, $aid);
    $update->execute();
}

$stmt->close();
$update->close();
$mysqli->close();
$myupdate->close();