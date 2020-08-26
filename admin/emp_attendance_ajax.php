<?php include '../includes/config.php';

$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$emp_id = $_GET['emp'];

// date_default_timezone_set('EET');
// date_default_timezone_set("Asia/Amman");

?>


<div class="table-responsive">
    <table id="bootstrap-data-table" class="table table-striped table-bordered table-sm">
        <div class="form-group">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Assumed Check-In Time </th>
                    <th>Check-In Time</th>
                    <th>Check-Out Time</th>
                    <th>Status</th>
                    <th>Period Of Late (Hours/Min/Seconds)</th>



                </tr>
            </thead>

            <tbody>
                <?php

                $query = " SELECT * From employee INNER JOIN check_time on employee.emp_id=check_time.check_emp_id
                where substring(check_in,1,10) BETWEEN '$date_from' AND '$date_to' and check_emp_id='$emp_id' ORDER BY check_in DESC";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='8' style='text-align:center;color:#fff;font-size:20px;background-color:#dc3545;'>No Result Found In These Dates</td></tr>";
                } else {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {

                        $Assumed_Check_in =  strtotime($row['work_from']);
                        $convert          = explode(" ",$row['check_in']);
                        $Actual_Check_in  = $convert[1];
                        $convert_to_unix  = strtotime($Actual_Check_in);
                        $result_diff      =  round(abs($Assumed_Check_in - $convert_to_unix));

                        if ($convert_to_unix <= strtotime($row['work_from'])) {
                            $status = "class='btn btn-success'";
                            $stat = 'In Time !';
                        } else {
                            $status = "class='btn btn-danger'";
                            $stat = 'Late !';
                        }

                        // else {
                        //     $status = "class='btn btn-dark'";
                        //     $stat = 'Absent !';
                        // }
                        ?>
                        <tr>
                            <td><?php echo  $i ?></td>
                            <td><?php echo isset($row['check_in'])  ? date('Y-m-d', strtotime($row['check_in'])) : "No Check-In" ?> </td>
                            <td><?php echo date('h:i A', strtotime($row['work_from'])) ?></td>
                            <td><?php echo isset($row['check_in'])  ? date('h:i:s A', strtotime($row['check_in'])) : "No Check-In" ?></td>
                            <td><?php echo isset($row['check_out'])  ? date('h:i:s A', strtotime($row['check_out'])) : "No Check-Out" ?></td>
                            <td style='width:75px' <?php echo $status ?>><?php echo $stat ?></td>
                            <td><?php  echo date("H",$result_diff)." Hours ".date("i",$result_diff)." Minutes ".date("s",$result_diff)." Seconds " ?></td>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </div>
    </table>
</div>