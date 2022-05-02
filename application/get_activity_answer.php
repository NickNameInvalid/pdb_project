<?php
include('mysqlidb.php');
session_start();
$user = $_GET['a_user'];
$mysqli = establish_conn();
$stmt = $mysqli->prepare("select qid, concat(gtname, ' \ ', stname) as topic, title, a_body, answer_time, thumb_ups, best_answer 
                                from answers natural join questions natural join subjecttopics natural join generaltopics 
                                where a_username = ? and a_visible_status = 1 order by answer_time");
$stmt->bind_param("s", $user);
$stmt -> execute();
$stmt->bind_result($qid, $topic, $title, $body, $answertime, $thumbups, $bestanswer);
echo "<h4>Answer Posted</h4>";
while($stmt->fetch())
{
    $ba_str = number_format($bestanswer) == 1 ? "Best Answer" : "";
    echo <<<dochere
        <div class="card mb-3" id="qid_$qid">
            <div class="card-body">
                <h4 class="card-title">Q: $title</h4>
                <div class="dropdown-divider"></div>
                <p class="card-text">A: $body</p>
                <div class="post_time d-flex gap-lg-5">
                    <div class="p-2 time_post">$answertime</div>
                    <div class="p-2 post_topics">$topic</div>
                    <div class="p-2 answer_likes">$thumbups Likes</div>
                    <div class="p-2 best_answer">$ba_str</div>
                </div>
            </div>
        </div>
    dochere;
}
$stmt->close();
$mysqli->close();
?>