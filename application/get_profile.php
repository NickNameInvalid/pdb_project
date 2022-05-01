<?php
include('mysqlidb.php');
session_start();
$mysqli = establish_conn();
$c_user = $_SESSION['username'] ?? "";
$p_user = $_GET['p_user'] ?? "dft";

if ($p_user == "dft") {
    return;
}

$sql = "select firstname, lastname, phone, email, city, state, country, profile, karma_points
        from Users
        where username = ?";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $p_user);
    $stmt->execute();
    $stmt->bind_result($fn, $ln, $ph, $em, $ci, $st, $co, $pf, $kp);

    if ($c_user == $p_user) {
        $hd = "";
    } else {
        $hd = "hidden";
    }

    while($stmt->fetch()) {
        echo <<< heredoc
        <form id="editable" action="../application/update_profile.php", method="post">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="$fn">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="$ln">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="text" class="form-control" id="email" name="email" value="$em">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="$ph">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="$ci">
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="$st">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="$co">
            </div>
            <div class="mb-3">
                <label for="profile" class="form-label">Profile</label>
                <input type="text" class="form-control" id="profile" name="profile" value="$pf">
            </div>
            <button type="submit" class="btn btn-primary" $hd>Update</button>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Karma Points</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <h6 class="mb-0">$kp</h6>
                    </div>
                </div>
            </div>
        </div>
        heredoc;
    }

    $stmt->close();
    $mysqli->close();
}

