<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$qid = $_GET['qid'] ?? "dft";

$qid = 7;

if ($qid == "dft") {
    return;
}

$sql = "select aid, a_username, a_body, thumb_ups, answer_time, best_answer 
        from answers natural join questions
        where qid = ? and a_visible_status = 1
        order by answer_time desc";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $stmt->bind_result($aid, $a_user, $a_body, $thumb_ups, $a_time, $best);

    while($stmt->fetch()) {
        if ($best == 1) {
            $hd = "hidden";
        } else {
            $hd = "";
        }
        echo <<< heredoc
            <div class="card mb-3">
                <div class="card-body">
                    <p class="p-2 aid" hidden>$aid</p>
                    <p class="card-text">$a_body</p>
                    <div class="post_time d-flex gap-lg-5">
                        <div class="p-2 user_post">$a_user</div>
                        <div class="p-2 time_post">$a_time</div>
                        <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#post_question_model" title="Post a new question" id="post_float_btn" style="height: 40px;vertical-align:middle;">
                            <div class="d-flex gap-1">
                                <img src="../framework/bootstrap-icons-1.8.1/hand-thumbs-up.svg" alt="like number">
                                <div class="p-0">$thumb_ups</div>
                            </div>
                        </button>
                        <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#post_question_model" title="Post a new question" id="post_float_btn" style="height: 40px;vertical-align:middle;">
                                <img src="../framework/bootstrap-icons-1.8.1/trophy.svg" alt="best answer status">
                                <div class="p-0 best_tip" hidden></div>
                        </button>
                    </div>
                </div>
            </div>
        heredoc;
    }

    $stmt->close();
    $mysqli->close();
}