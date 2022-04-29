<?php
include('mysqlidb.php');
$mysqli = establish_conn();
$gtid = number_format($_POST['gtid']);
$stmt = $mysqli->prepare("select concat('stid_', stid) as stid, stname from subjecttopics where gtid = ?");
$stmt->bind_param("i", $gtid);
$stmt -> execute();
$stmt->bind_result($stid, $stname);
echo "<option class='stid_dft' selected>Subject Topics</option>";
while ($stmt->fetch())
{
    echo <<<heredoc
    <option class="$stid">$stname</option>
    heredoc;
}
$stmt->close();
$mysqli->close();
?>