<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$gtid = $_GET['gtid'] ?? "dft";
$stid = $_GET['stid'] ?? "dft";
$keywd = $_GET['key'] ?? "";
$stype = $_GET['stype'] ?? "dft";
$params = Array();
$param_type = "";
if(empty($keywd))
{
    if($stype == "dft" || $stype == "qs") {
        $sql_text = "select qid, q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status 
                from questions natural join subjecttopics natural join generaltopics 
                where q_visible_status = 1";

        if ($stid != "dft") {
            $param_type .= "i";
            $params[] = $stid;
            $sql_text .= " and stid = ?";
        } else if ($gtid != "dft") {
            $param_type .= "i";
            $params[] = $gtid;
            $sql_text .= " and gtid = ?";
        }

        $sql_text .= " order by post_time desc";
        $stmt = $mysqli->prepare($sql_text);
        if (count($params) != 0) {
            $stmt->bind_param($param_type, ...$params);
        }
        $stmt->execute();
        $stmt->bind_result($qid, $u, $tc, $tt, $bd, $pt, $st);
    }
    else if($stype == "as")
    {
        $sql_text = "select aid, qid, concat(gtname, ' / ', stname) as topics, a_username, title, a_body, thumb_ups, answer_time, best_answer 
                    from answers natural join questions natural join subjecttopics natural join generaltopics 
                    where q_visible_status = 1";

        if ($stid != "dft") {
            $param_type .= "i";
            $params[] = $stid;
            $sql_text .= " and stid = ?";
        } else if ($gtid != "dft") {
            $param_type .= "i";
            $params[] = $gtid;
            $sql_text .= " and gtid = ?";
        }

        $sql_text .= " order by answer_time desc";
        $stmt = $mysqli->prepare($sql_text);
        if (count($params) != 0) {
            $stmt->bind_param($param_type, ...$params);
        }
        $stmt->execute();
        $stmt->bind_result($aid, $qid, $tc, $au, $tt, $ab, $tu, $at, $ba);
    }
}
else
{
    if($stype == "dft" || $stype == "qs") {
        $sql_text = <<<dochere
        select qid, q_username, concat(gtname, ' / ', stname) as topics , title, q_body, post_time, status from(
        select qid, q_username, title, q_body, post_time, match (q_body) against (? with query expansion) as score, 0.0 as weight, stid, status, q_visible_status from questions
        union
        select qid, q_username, title, q_body, post_time, match (title) against (? with query expansion) as score, 0.0 as weight, stid, status, q_visible_status from questions
        union
        select qid, q_username, title, q_body, post_time, 0.0 as score, 0.6 as weight, stid, status, q_visible_status from questions where title like ?
        union
        select qid, q_username, title, q_body, post_time, 0.0 as score, 0.4 as weight, stid, status, q_visible_status from questions where q_body like ?
        ) as q natural join subjecttopics natural join generaltopics where q_visible_status = 1
        dochere;
        $param_type .= "ssss";
        $params[] = $keywd;
        $params[] = $keywd;
        $params[] = '%'.$keywd.'%';
        $params[] = '%'.$keywd.'%';

        if($stid != "dft")
        {
            $param_type .= "i";
            $params[] = $stid;
            $sql_text .= " and stid = ?";
        }
        else if ($gtid != "dft")
        {
            $param_type .= "i";
            $params[] = $gtid;
            $sql_text .= " and gtid = ?";
        }


        $sql_text .= " group by qid, q_username, topics, title, q_body, post_time, status having sum(weight) > 0 or sum(score) > 0 order by sum(weight) desc, sum(score) desc, post_time desc";
        $stmt = $mysqli->prepare($sql_text);
        $stmt->bind_param($param_type, ...$params);
        $stmt -> execute();
        $stmt->bind_result($qid, $u, $tc, $tt, $bd, $pt, $st);
    }
    else if ($stype == "as"){
        $sql_text = <<<dochere
        select aid, qid, concat(gtname, ' / ', stname) as topics, a_username, title, a_body, thumb_ups, answer_time, best_answer from(
        select aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer, match (a_body) against (? with query expansion) as score, 0.0 as weight, a_visible_status from answers
        union
        select aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer, 0.0 as score, 1.0 as weight, a_visible_status from answers where a_body like ?
        ) as a natural join questions natural join subjecttopics natural join generaltopics where a_visible_status = 1
        dochere;
        $param_type .= "ss";
        $params[] = $keywd;
        $params[] = '%'.$keywd.'%';

        if($stid != "dft")
        {
            $param_type .= "i";
            $params[] = $stid;
            $sql_text .= " and stid = ?";
        }
        else if ($gtid != "dft")
        {
            $param_type .= "i";
            $params[] = $gtid;
            $sql_text .= " and gtid = ?";
        }

        $sql_text .= " group by aid, qid, a_username, a_body, thumb_ups, answer_time, best_answer having sum(weight) > 0 or sum(score) > 0 order by sum(weight) desc, sum(score) desc, answer_time desc";
        $stmt = $mysqli->prepare($sql_text);
        $stmt->bind_param($param_type, ...$params);
        $stmt -> execute();
        $stmt->bind_result($aid, $qid, $tc, $au, $tt, $ab, $tu, $at, $ba);
    }

}

if(empty($stmt)) return;

while($stmt->fetch())
{
    if($stype == "dft" || $stype == "qs"){
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
    else if($stype == "as")
    {
        $ba_str = number_format($ba) == 1 ? "Best Answer" : "";
        echo <<<heredoc
            <div class="card mb-3" id="qid_$qid">
                <div class="card-body">
                    <p type="hidden" id="aid_$aid">
                    <h4 class="card-title">Q: {$tt}</h4>
                    <div class="dropdown-divider"></div>
                    <p class="card-text">A: {$ab}</p>
                    <div class="post_time d-flex gap-lg-5">
                        <div class="p-2 user_post">$au</div>
                        <div class="p-2 time_post">$at</div>
                        <div class="p-2 post_topics">$tc</div>
                        <div class="p-2 answer_likes">{$tu} Likes</div>
                        <div class="p-2 best_answer">$ba_str</div>
                    </div>
                </div>
            </div>
        heredoc;
    }

}
$stmt->close();
$mysqli->close();
?>