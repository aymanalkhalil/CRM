<?php
session_start();
if (isset($_GET['logout'])) {
    session_unset();
}
if (!isset($_SESSION["emp_id"])) {
    header('Location: ../login.php');
    exit();
}
include '../includes/config.php';
$date=date('2019-12-04');
$query0 = "SELECT check_id FROM check_time WHERE check_emp_id='{$_SESSION['emp_id']}' ORDER BY check_id DESC";
$result11 = mysqli_query($con, $query0);
$row = mysqli_fetch_assoc($result11);


//retreive check_id to check out in a href and check date to compare
//if the date of the day is exist in the database to prevent inserting in every refresh of the page
// if($row['check_date']!=$date){
// $insert_date="INSERT INTO check_time(check_date,check_emp_id)VALUES('$date','{$_SESSION['emp_id']}')";
// $ex=mysqli_query($con,$insert_date);
// }


global $con;

$query = "select emp_img from employee where emp_id='{$_SESSION['emp_id']}'";
$result =  mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$useragent=$_SERVER['HTTP_USER_AGENT'];




?>
<style>
    #check-out {
        color: #000;
        font-size: 13px;

    }

    #check-out:hover {
        color: #ffc107;
        font-size: 13px;
    }

    #sign-out:hover {
        color: #dc3545;
    }

    #sign-out {
        color: #000;
    }

    #check-in {
        color: #000;
        font-size: 13px;
    }

    #check-in:hover {
        color: #28a745;
        font-size: 13px;
    }
</style>
<!doctype html>

<html class="no-js" lang="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Dashboard</title>
    <meta name="description" content="CRM - Employee Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="../images/Logo-01.png" sizes="16x16">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">


    <!-- <link href="../assets/css/notification.css" rel="stylesheet" type="text/css"/> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.0.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <!-- <script src="../assets/js/active.js" type="text/javascript"></script>

<script src="../assets/js/bootstrap-growl.js" type="text/javascript"></script>
<script src="../assets/js/notification-active.js" type="text/javascript"></script> -->

    <style>
        * {
            font-family: 'helvetica';
        }

        .fr-box.fr-basic {
            width: 100%;
            margin-bottom: 15px
        }

        .fr-quick-insert,
        #logo {
            display: none;
        }

        #weatherWidget .currentDesc {
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }

        .select2-container--classic .select2-selection--single {
            background-color: #FFFFFF;
            border: none;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            -o-border-radius: 4px;
            border-radius: 4px;
        }

        .select2-container--classic.select2-container--open .select2-dropdown {
            border-color: #007bff;
            z-index: 9999;
        }

        .select2-container .select2-selection--single {
            height: 40px;
        }

        .select2-container--classic .select2-selection--single {
            background-color: transparent;
            background-image: none;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #c8c8c8;
        }

        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            font-size: 16px !important;
            height: 40px;
            line-height: 36px;
            padding-left: 35px;
        }

        .select2-container--classic .select2-dropdown {
            border: 1px solid #c8c8c8;
        }

        .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #007bff transparent;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow b {
            border-color: #007bff transparent transparent transparent;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            top: 7px;
            background-color: transparent;
            background-image: none;
            border-style: none;
            right: 5px;
        }

        .select2-container--classic.select2-container--open .select2-selection--single {
            border: 1px solid #c8c8c8;
        }

        .select2-container--classic .select2-selection--single:focus {
            border: 1px solid #007bff;
        }

        .select2-container--classic .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
            color: #FFFFFF;
        }

        .custom-select {
            margin-bottom: 15px;
        }

        .select2-container--classic.select2-container--open.select2-container--below .select2-selection--single,
        .select2-container--classic.select2-container--open.select2-container--above .select2-selection--single {
            background-image: none;
        }

        .select2-results__options {
            padding: 0 4px;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow b,
        .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-width: 0;
        }
    </style>

</head>

<body>

    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="menu-title">Employee Dashboard</li><!-- /.menu-title -->
                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'index') echo 'class="active"'; ?>>
                        <a href="index.php"><i class="menu-icon fa fa-home"></i>Home</a>
                    </li>

                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'emp_tasks') echo 'class="active"'; ?>>
                        <a href="emp_tasks.php"><i class="menu-icon fa fa-tasks"></i>Tasks For You </a>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'add_leads_emp') echo 'class="active"'; ?>>
                        <a href="add_leads_emp.php"><i class="menu-icon fa fa-users"></i>Add leads By Employee</a>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'called_leads') echo 'class="active"'; ?>>
                        <a href="called_leads.php"><i class="menu-icon fa fa-phone-alt"></i>Called Leads </a>
                    </li>
                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'registered_leads') echo 'class="active"'; ?>>
                        <a href="registered_leads.php"><i class="menu-icon fa fa-edit"></i>Registered Students</a>
                    </li>

                    <!-- <li>
                            <a href="academy.php"><i class="menu-icon fa fa-book"></i>Academy</a>
                        </li> -->
                    <li <?php if (basename($_SERVER['PHP_SELF'], '.php') == 'social_media') echo 'class="active"'; ?>>
                        <a href="social_media.php"><i class="menu-icon fab fa-facebook-square"></i>Social Media Activity</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img src="../images/Logo-01.png" style='width:49px' alt="Logo"></a>
                    <!-- <a class="navbar-brand" href="./"><img src="../images/logo.png" alt="Logo"></a> -->
                    <!-- <a class="navbar-brand hidden" href="./"><img src="../images/logo2.png" alt="Logo"></a> -->
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
            <div class="top-right h-100">
                <div class="header-menu h-100">
                    <div class="header-right d-flex align-items-center">

                        <?php
                        if (isset($_SESSION['emp_name'])) {
                            echo "Welcome " . $_SESSION['emp_name'];
                        }
                        ?>

                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img style="height:40px;object-fit: cover;" class="user-avatar rounded-circle" src="<?php echo $row['emp_img']; ?>" alt="User Avatar">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a> -->
                            <!-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> -->

                            <?php
                            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {

                                ?>
                                <a class="nav-link" href="check-in.php?emp_id=<?php echo $_SESSION['emp_id'] ?>" id='check-in'><i class="fas fa-check"></i>
                                    تسجيل الدخول للدوام</a>


                                <a class="nav-link" href='check-out.php?check_id=<?php echo $row['check_id'] ?>' id='check-out'><i class="fas fa-sign-out-alt"></i>
                                    تسجيل خروج الدوام</a>

                            <?php } ?>
                            <a class="nav-link" id='sign-out' href="index.php?logout=1">
                                <i class="fa fa-power-off"></i>الخروج من النظام </a>
                        </div>
                    </div>



                </div>
            </div>
        </header>
        <!-- /#header -->