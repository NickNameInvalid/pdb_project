<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();

$stmt = $mysqli->prepare("select q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status from questions natural join subjecttopics natural join generaltopics where q_visible_status = 1");
$stmt -> execute();
$stmt->bind_result($u, $tc, $tt, $bd, $pt, $st);
while($stmt->fetch())
{
    echo <<<heredoc
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">$tt</h4>
                <div class="dropdown-divider"></div>
                <p class="card-text">$bd</p>
                <div class="post_time d-flex gap-lg-5">
                    <div class="p-2 user_post">$u</div>
                    <div class="p-2 time_post">$pt</div>
                    <div class="p-2 post_topics">$tc</div>
                    <div class="p-2 question_status">$st</div>
                </div>
            </div>
        </div>
    heredoc;
}
$stmt->close();
$mysqli->close();
?>