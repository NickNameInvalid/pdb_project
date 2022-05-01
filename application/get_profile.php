<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$c_user = $_SESSION['username'] ?? "";
$p_user = $_GET['p_user'] ?? "user1";

if ($p_user == "dft") {
    return;
}

$sql = "select firstname, lastname, phone, email, city, state, country, profile, karma_points, statusname
        from Users natural join userstatus natural join status
        where username = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $p_user);
    $stmt->execute();
    $stmt->bind_result($fn, $ln, $ph, $em, $ci, $st, $co, $pf, $kp, $stn);

    if ($c_user == $p_user) {
        $hd = "";
    } else {
        $hd = "hidden";
    }
    $stmt->fetch();
    $res = Array();
    $res['editable'] = $c_user == $p_user;
    $res['username'] = $p_user;
    $res['firstname'] = $fn;
    $res['lastname'] = $ln;
    $res['phone'] = $ph;
    $res['email'] = $em;
    $res['city'] = $ci;
    $res['state'] = $st;
    $res['country'] = $co;
    $res['profile'] = $pf;
    $res['karma_point'] = $kp;
    $res['status'] = $stn;

    $stmt->close();
    $mysqli->close();

    echo json_encode($res);
}
return;
?>