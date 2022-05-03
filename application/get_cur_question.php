<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$qid = $_GET['qid'] ?? "";
$user = $_SESSION['username'] ?? "";

$sql = "select qid, q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status 
        from questions natural join subjecttopics natural join generaltopics 
        where qid = ? and q_visible_status = 1";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $stmt->bind_result($qid, $q_user, $q_topics, $q_title, $q_body, $q_time, $q_status);
    $stmt->fetch();

    $res = Array();
    $res['editable'] = $user == $q_user;
    $res['qid'] = $qid;
    $res['q_user'] = $q_user;
    $res['q_topics'] = $q_topics;
    $res['q_title'] = $q_title;
    $res['q_body'] = $q_body;
    $res['q_time'] = $q_time;
    $res['q_status'] = $q_status;


    $stmt->close();
    $mysqli->close();

    echo json_encode($res);
}