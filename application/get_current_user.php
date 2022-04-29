<?php
session_start();
$user = $_SESSION['username'] ?? "11111";
echo $user;
?>