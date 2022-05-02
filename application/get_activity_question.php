<?php
include('mysqlidb.php');
session_start();
$user = $_GET['a_user'];
$mysqli = establish_conn();
$stmt = $mysqli->prepare("select qid, concat(gtname, ' \ ', stname) as topic, title, q_body, post_time, status from questions natural join subjecttopics natural join generaltopics where q_username = ? and q_visible_status = 1 order by post_time desc");
$stmt->bind_param("s", $user);
$stmt -> execute();
$stmt->bind_result($qid, $topic, $title, $body, $posttime, $status);
echo "<h4>Question Posted</h4>";
while($stmt->fetch())
{
    echo <<<dochere
        <div class="card mb-3" id="act_qid_$qid">
            <div class="card-body">
                <h4 class="card-title title_link">$title</h4>
                <div class="dropdown-divider"></div>
                <p class="card-text">$body</p>
                <div class="post_time d-flex gap-lg-5">
                    <div class="p-2 time_post">$posttime</div>
                    <div class="p-2 post_topics">$topic</div>
                    <div class="p-2 question_status">$status</div>
                </div>
            </div>
        </div>
    dochere;
}
$stmt->close();
$mysqli->close();
?>