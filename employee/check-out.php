<?php
session_start();
 include '../includes/config.php';
 $check_id=$_GET['check_id'];

 date_default_timezone_set('EET');
$date_time_check_out= date('Y-m-d H:i:s');

$query2="UPDATE check_time SET check_emp_id='{$_SESSION['emp_id']}',check_out='$date_time_check_out'
        where check_id=$check_id";

$result2=mysqli_query($con,$query2);

header("location:index.php?check_out=true");

?>
