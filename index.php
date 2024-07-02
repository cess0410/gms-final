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


<!DOCTYPE html>
<html data-theme="light">

<head>
    <link href="/gms-final/assets/css/daisy.css" rel="stylesheet" type="text/css" />
    <script src="/gms-final/assets/js/tailwind.js"></script>
    <script src="/gms-final/assets/js/sweetalert.js"></script>
    <title>Login</title>
</head>


<body class="bg-base-200">
    <?php if ($errmsg) echo '<div role="alert" class="alert alert-error text-white my-3 px-3">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0 stroke-current"
                fill="none"
                viewBox="0 0 24 24">
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>' . $errmsg . '.</span>
            </div>'; ?>
    <div class="hero  min-h-screen">
        <div class="hero-content flex-col lg:flex-row-reverse">

            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <h1 class="text-5xl font-bold mx-36 my-5">GMS</h1>
                <form method="POST" class="card-body">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="text" id="name" autofocus="" name="username" class="input input-bordered" required />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="text" id="subject" name="password" class="input input-bordered" required />
                        <label class="label">
                            <a href="#" class="label-text-alt link link-hover">Forgot password?</a>
                        </label>
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-success">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
