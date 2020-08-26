<?php
session_start();
include 'includes/config.php';
global $con;

if (isset($_SESSION['admin_id'])) {
    header('Location: admin/index.php');
}

if (isset($_SESSION['employee_id'])) {
    header('Location: employee/index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $type = $_POST['type'];
        $email    = $_POST['email'];
        $password = $_POST['password'];


        if ($type == 1) {
            $sql    = "SELECT * FROM admin WHERE admin_email='$email' AND admin_password='$password'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                $id = '';
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['admin_id'];
                    $name = $row['admin_name'];
                }
                $_SESSION['admin_id']   = $id;
                $_SESSION['admin_name']   = $name;
                header('Location: admin/index.php');
            } else {
                $error =  'Email or Password is incorrect';
            }
        } else {
            $sql1    = "SELECT * FROM employee WHERE emp_email='$email' AND emp_password='$password'";
            $result1 = mysqli_query($con, $sql1);
            if (mysqli_num_rows($result1) > 0) {
                $id = '';
                while ($row = mysqli_fetch_assoc($result1)) {
                    $id = $row['emp_id'];

                    $name = $row['emp_name'];
                }
                $_SESSION["emp_id"]   = $id;
                $_SESSION["emp_name"]   = $name;
                header('Location: employee/index.php');
            } else {
                $error =  'Email or Password is incorrect';
            }
        }
    }
}
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Dashboard</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/Logo-01.png" sizes="16x16">
    <!-- <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
</head>

<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">

                <div class="login-form">
                    <div class="login-logo">
                        <img class="align-content w-50  " style='height:100%' src="images/Logo-01.png" alt="">
                        <!-- <img class="align-content w-100" style='height:100%' src="images/logo.png" alt=""> -->
                    </div>
                    <?php if (isset($error)) {
                        echo "<div class='alert alert-danger' role='alert'>$error</div>";
                    } ?>

                    <form id="form" method="post" action="">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" placeholder="Email" name="email" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select Type</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="type" required>
                                <option value="1" selected>Admin</option>
                                <option value="2">Employee</option>
                            </select>
                        </div>
                        <!-- <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div> -->
                        <button type="submit" style='background-color:#FF6700' class="btn btn-success btn-flat m-b-30 m-t-30 text-light">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>