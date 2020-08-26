<?php
include '../includes/config.php';
$emp_id = $_GET['emp_id'];
$date = date("Y-m-d");
date_default_timezone_set('EET');
$date_time_check_in = date('Y-m-d H:i:s');

$check_in_validate = "SELECT substring(check_in,1,10) as day FROM check_time
            where check_emp_id=$emp_id and substring(check_in,1,10)='$date'";
$validate = mysqli_query($con, $check_in_validate);

$row=mysqli_fetch_assoc($validate);

if ($row['day'] == $date) {

    header("location:index.php?check_in_twice=true");


} else {
    $query2 = "INSERT INTO check_time(check_emp_id,check_in)VALUES($emp_id,'$date_time_check_in')";

    $result2 = mysqli_query($con, $query2);


    header("location:index.php?check_in=true");
}
