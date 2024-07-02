<?php
include("include/config.php");

session_start();

if (isset($_SESSION['iuid'])) {
    header("Location: dashboard.php");
    exit();
}

$errmsg = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (!isset($_SESSION['logctr'])) {
        $_SESSION['logctr'] = 0;
    }

    if ($_SESSION['logctr'] > 10) {
        $errmsg = "Maximum login attempts exceeded";
    } else {
        $username = $db->real_escape_string($_POST['username']);
        $password = $db->real_escape_string($_POST['password']);

        $result = $db->query("SELECT * FROM users WHERE username='$username'");
        if ($result && $row = $result->fetch_assoc()) {
            if (password_verify($password, $row['userpass'])) {
                $_SESSION['iuid'] = $row['userid'];
                $_SESSION['ifname'] = $row['fname'];
                $_SESSION['ilname'] = $row['lname'];
                $_SESSION['iupriv'] = $row['userprivilege'];
                if (isset($_POST['chkremember']) && $_POST['chkremember'] == '1') {
                    $_SESSION['iremember'] = 1;
                    setcookie('hrem', $_SESSION['iuid'], time() + (3600 * 60), '/');
                    setcookie('hrei', base64_encode($_SESSION['ifname']), time() + (3600 * 60), '/');
                    setcookie('hrep', base64_encode($_SESSION['iupriv']), time() + (3600 * 60), '/');
                }
                header("Location: dashboard.php");
                exit();
            } else {
                $errmsg = "Incorrect password";
            }
        } else {
            $_SESSION['logctr']++;
            if ($_SESSION['logctr'] > 10) {
                $errmsg = "Maximum login attempts exceeded";
            } else {
                $errmsg = "Incorrect username";
            }
        }
    }
}
// include 'header.php'
?>

<head>
    <link rel="stylesheet" href="vendors/all.min.css">
    <link rel="stylesheet" href="vendors/bootstrap1.min.css">
    <link rel="stylesheet" href="vendors/themify-icons.css">
    <link rel="stylesheet" href="vendors/nice-select.css">
    <link rel="stylesheet" href="vendors/material-icons.css">

</head>
<style>
    .theme_bg_1 {
        background: #00A651 !important;
    }

    .form-check-input:checked {
        background-color: #00A651 !important;
        border-color: #00A651 !important;
    }
</style>

<body>
    <div class="col-lg-12">
        <div class="white_box mb_30 mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="modal-content cs_modal" style="border: none!important; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);">
                        <div class="modal-header justify-content-center theme_bg_1" style="padding: 20px!important">
                            <h5 class="modal-title text_white" style="color: white">GMS</h5>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="mb-5" style="text-align: center;">
                                    <img src="vendors/logo.png" alt="" style="width: 200px; filter: contrast(80%);">
                                </div>

                                <?php if (isset($_SESSION['ifname'])) : ?>
                                    <p class="nav-link" style="margin-top: 20px!important; color: green !important;text-align: center!important;">
                                        Welcome, <?= $_SESSION['ifname'] ?>
                                    </p>
                                <?php endif; ?>


                                <div class="heading">
                                    <?php if ($errmsg) echo '<p style="color: rgb(255,0,0);margin-top: 20px;font-size: 18px;font-weight: bold;">' . $errmsg . '</p>'; ?>
                                </div>
                                <form method="post">
                                    <div class="mb-3"><label class="form-label" for="name">Username</label><input class="form-control item" type="text" id="name" autofocus="" name="username"></div>
                                    <div class="mb-3"><label class="form-label" for="subject">Password</label><input class="form-control item" type="password" id="subject" name="password"></div>
                                    <div class="cs_check_box mb-3">
                                        <div class="form-check">
                                            <input class="common_checkbox form-check-input" type="checkbox" id="formCheck-1" name="chkremember" value="1" checked>
                                            <label class="form-check-label" for="formCheck-1">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="mb-3" style="margin-top: 50px!important; text-align: center;">
                                        <button class="btn btn-primary btn-lg d-block w-100" style="background: #00A651 !important; border-color: #00A651 !important;font-size: 15px!important; text-color: white!important" type="submit">Login</button>
                                    </div>

                                    <!-- <div class="text-center mb-3" style="padding-top: 15px;"><a href="forgotpassword">Forgot Password</a></div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="assets/js/vue.global.js"></script>

</body>

</html>