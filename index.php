<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="framework/jquery-3.6.0/jquery-3.6.0.min.js"></script>
    <title>Title</title>
</head>
<body>
<h1>Welcome to the forum!</h1>
<div id="g_topic_receiver"></div>
<?php
include('application/mysqlidb.php');
$mysqli = establish_conn();
$g_topic_query = $mysqli->prepare("select gtname from generaltopics");
$g_topic_query -> execute();
$g_topic_query->bind_result($gtname);
while ($g_topic_query->fetch()) {
    echo "<h3>$gtname</h3>";
}

$mysqli->close();
?>
</body>

<script type="text/javascript">
    $(document).ready(function (){
        $("#g_topic_receiver").load('templates/login.html');
    });


</script>

</html>

