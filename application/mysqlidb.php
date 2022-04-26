<?php
function establish_conn()
{
    $mysqli = new mysqli("localhost", "root", "123456", "project");

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    return $mysqli;
}
?>