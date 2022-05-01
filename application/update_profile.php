<?php
include('mysqlidb.php');
include('get_current_user.php');
$mysqli = establish_conn();
$user = get_current_user();
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$city = $_POST["city"];
$state = $_POST["state"];
$country = $_POST["country"];

$sql = "update Users
        set firstname=?, lastname=?, email=?, phone=?, city=?, state=?, country=?
        where username=?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $phone, $city, $state, $country, $user);
    $stmt->execute();

    $stmt->close();
    $mysqli->close();
}