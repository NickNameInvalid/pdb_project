<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$gtid = $_GET['gtid'] ?? "dft";
$stid = $_GET['stid'] ?? "dft";
$keywd = $_GET['key'] ?? "";
$stype = $_GET['stype'] ?? "dft";
$sql_text = "select qid, q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status 
                from questions natural join subjecttopics natural join generaltopics 
                where q_visible_status = 1";
if($stid != "dft")
{
    $stid_num = number_format($stid);
    $sql_text .= "and stid = ?";
}
else if ($gtid != "dft")
{
    $gtid_num = number_format($gtid);
    $sql_text .= "and gtid = ?";
}
$stmt = $mysqli->prepare($sql_text);
$stmt -> execute();
$stmt->bind_result($qid, $u, $tc, $tt, $bd, $pt, $st);
while($stmt->fetch())
{
    echo <<<heredoc
        <div class="card mb-3" id="qid_$qid">
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