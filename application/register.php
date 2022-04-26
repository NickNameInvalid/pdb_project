<?php
include('mysqlidb.php');
$mysqli = establish_conn();
$username = $_POST['reg_user'];
$pword1 = hash('sha256', trim($_POST['reg_pass1']));
$pword2 = hash('sha256', trim($_POST['reg_pass2']));
if($pword1 === $pword2)
{
    $sql = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $sql->bind_param("ss", $username, $pword1);
    try
    {
        $sql -> execute();
        echo "Success create a new account!";
    }
    catch (mysqli_sql_exception $e)
    {
        echo "account already exists!";

    } finally {
       $mysqli->close();
    }
}
?>