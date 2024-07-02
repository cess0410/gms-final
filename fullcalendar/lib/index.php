<?php
include("config.php");

session_start();

if (isset($_SESSION['iuid'])) {
    header("Location: inquiry.php");
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
                $_SESSION['iupriv'] = $row['userprivilege'];
                if (isset($_POST['chkremember']) && $_POST['chkremember'] == '1') {
                    $_SESSION['iremember'] = 1;
                    setcookie('hrem', $_SESSION['iuid'], time() + (3600 * 60), '/');
                    setcookie('hrei', base64_encode($_SESSION['ifname']), time() + (3600 * 60), '/');
                    setcookie('hrep', base64_encode($_SESSION['iupriv']), time() + (3600 * 60), '/');
                }
                header("Location: inquiry.php");
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/pikaday.min.css">
</head>

<body>
    <p class="nav-link" style="margin-top: 50px!important;">Welcome, <?= isset($_SESSION['ifname']) ? $_SESSION['ifname'] : '' ?></p>
    <div class="heading" style="margin-bottom: 50px;">
        <?php if ($errmsg) echo '<p style="color: rgb(255,0,0);margin-top: 20px;font-size: 18px;font-weight: bold;">' . $errmsg . '</p>'; ?>
    </div>
    <form method="post">
        <div class="mb-3"><label class="form-label" for="name">Username</label><input class="form-control item" type="text" id="name" autofocus="" name="username"></div>
        <div class="mb-3"><label class="form-label" for="subject">Password</label><input class="form-control item" type="password" id="subject" name="password"></div>
        <div class="mb-3">
            <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" name="chkremember" value="1" checked><label class="form-check-label" for="formCheck-1">Remember Me</label></div>
        </div>
        <div class="mb-3" style="padding-top: 15px;"><button class="btn btn-primary btn-lg d-block w-100" type="submit">Login</button></div>
        <!-- <div class="text-center mb-3" style="padding-top: 15px;"><a href="forgotpassword">Forgot Password</a></div> -->
    </form>
    <script src="assets/js/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
</body>

</html>