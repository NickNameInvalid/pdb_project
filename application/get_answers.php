<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$check_like_sqli = establish_conn();
$qid = $_GET['qid'] ?? "";
$cur_user = $_SESSION['username'] ?? "";

if (empty($qid)) {
    return;
}


$sql = "select aid, a_username, a_body, thumb_ups, answer_time, best_answer 
        from answers natural join questions
        where qid = ? and a_visible_status = 1
        order by best_answer desc, answer_time desc, thumb_ups desc";


echo "<h4 class='mb-2'>Answers</h4>";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $stmt->bind_result($aid, $a_user, $a_body, $thumb_ups, $a_time, $best);
    $stmt->store_result();
    if($stmt->num_rows === 0)
    {
        echo "<h4 class='mb-2'>No answers posted for this question!</h4>";
    }

    while($stmt->fetch()) {
        $check_like = $check_like_sqli->prepare("select exists(select * from likes where username=? and aid=? and like_status = 1)");
        $check_like->bind_param("si", $cur_user, $aid);
        $check_like->execute();
        $check_like->bind_result($isliked);
        $check_like->fetch();
        $check_like->close();

        $like_img_path = $isliked ? "../framework/bootstrap-icons-1.8.1/hand-thumbs-up-fill.svg" : "../framework/bootstrap-icons-1.8.1/hand-thumbs-up.svg";

        if ($best == 1) {
            $hd = "hidden";
        } else {
            $hd = "";
        }

        $editable = $cur_user == $a_user ? "display:block;" : "display:none;";
        $best_answer = $best ? "../framework/bootstrap-icons-1.8.1/trophy-fill.svg" : "../framework/bootstrap-icons-1.8.1/trophy.svg";
        echo <<< heredoc
            <div class="card mb-3">
                <div class="card-body">
                    <p class="p-2 aid" hidden>$aid</p>
                    <p class="card-text detail_body preview_body" contenteditable="false" id="answer_body_$aid">$a_body</p>
                    <div class="post_time d-flex gap-lg-5">
                        <div class="p-2 user_post">$a_user</div>
                        <div class="p-2 time_post">$a_time</div>
                        <button type="button" class="btn btn-default like_btn" id="like_$aid" style="height: 40px;vertical-align:middle;">
                            <div class="d-flex gap-1">
                                <img src=$like_img_path alt="like number" id="like_img_$aid">
                                <div class="p-0" id="like_num_$aid">$thumb_ups</div>
                                <p class="p-2" id="is_liked_$aid" hidden>$isliked</p>
                            </div>
                        </button>
                        <button type="button" class="btn btn-default ba_btn" id="best_$aid" style="height: 40px;vertical-align:middle;">
                                <img src=$best_answer alt="best answer status" id="best_img_$aid">
                                <p class="p-2" id="is_best_$aid" hidden>$best</p>
                        </button>
                        <button type="button" class="btn btn-default a_edit_btn" id="edit_$aid" style="height: 40px;vertical-align:middle;$editable">
                            <img src="../framework/bootstrap-icons-1.8.1/pencil-square.svg" alt="edit answer" id="edit_img_$aid">
                            <p class="p-2" id="editting_$aid" hidden>0</p>
                        </button>
                        <button type="button" class="btn btn-default a_delete_btn" id="delete_$aid" style="height: 40px;vertical-align:middle;$editable" data-bs-target="#delcfmModel" data-bs-toggle="modal">
                            <img src="../framework/bootstrap-icons-1.8.1/trash.svg" alt="delete" id="delete_img_$aid">
                        </button>
                    </div>
                </div>
            </div>
        heredoc;
    }

    $stmt->close();
    $mysqli->close();
    $check_like_sqli->close();
}