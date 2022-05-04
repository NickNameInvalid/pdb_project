<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$user = $_SESSION['username'] ?? "";
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$city = $_POST["city"];
$state = $_POST["state"];
$profile = $_POST["profile"];
$country = $_POST["country"];


$sql_lock = "select * from users where username = ? for update";
$sql = "update Users
        set firstname=?, lastname=?, email=?, phone=?, city=?, state=?, country=?, profile=?
        where username=?";

try {
    $lock = $mysqli->prepare($sql_lock);
    $lock->bind_param("s", $user);
    $lock->execute();
    $lock->close();

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sssssssss", $firstname, $lastname, $email, $phone, $city, $state, $country, $profile, $user);
        $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }
    echo "Success update profile for " . $user;
}
catch (Exception $e) {
    echo "Some exception happened!";
} finally {
    return;
}
?>
