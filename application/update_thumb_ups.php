<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$myupdate = establish_conn();
$aid = $_POST['aid'];
$user = $_SESSION['username'] ?? "dft";

if ($user == "dft") {
    echo "<script>alert('You have not logged in!')</script>";
    return;
}

$sql = "select like_status 
        from Likes
        where username = ? and aid = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $user, $aid);
$stmt->execute();
$stmt->bind_result($like_status);
$stmt->fetch();

if ($like_status == null) {
    $sql = "insert into Likes (username, aid) values (?, ?)";

    $update = $myupdate->prepare($sql);
    $update->bind_param("si", $user, $aid);
    $update->execute();
} else if ($like_status == 1) {
    $sql = "update Likes
            set like_status = 0
            where username = ? and aid = ?";

    $update = $myupdate->prepare($sql);
    $update->bind_param("si", $user, $aid);
    $update->execute();
} else {
    $sql = "update Likes
            set like_status = 1
            where username = ? and aid = ?";

    $update = $myupdate->prepare($sql);
    $update->bind_param("si", $user, $aid);
    $update->execute();
}

$stmt->close();
$update->close();
$mysqli->close();
$myupdate->close();