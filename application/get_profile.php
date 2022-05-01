<?php
include('mysqlidb.php');
include('get_current_user.php');
$mysqli = establish_conn();
$c_user = get_current_user();
$p_user = $_GET['p_user'] ?? "dft";

if ($p_user == "dft") {
    echo <<< heredoc
        <form id="editable">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" value="First Name">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" value="Last Name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="text" class="form-control" id="email" value="Email Address">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" value="Phone Number">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" value="City">
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" value="State">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="country" value="Country">
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Karma Points</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <h6 class="mb-0">NaN</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Profile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <p class="card-text">None</p>
                    </div>
                </div>
            </div>
        </div>
    heredoc;
    $mysqli->close();
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
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Profile</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <p class="card-text">$pf</p>
                    </div>
                </div>
            </div>
        </div>
        heredoc;
    }

    $stmt->close();
    $mysqli->close();
}

