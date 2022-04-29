<?php
include('mysqlidb.php');
$mysqli = establish_conn();

$stmt = $mysqli->prepare("select concat('gtid_', gtid) as gtid, gtname from generaltopics");
$stmt -> execute();
$stmt->bind_result($gtid, $gtname);
echo "<option selected>General Topics</option>";
while ($stmt->fetch())
{
    echo <<<heredoc
        <option class="$gtid">$gtname</option>
    heredoc;
}
$stmt->close();
$mysqli->close();
?>