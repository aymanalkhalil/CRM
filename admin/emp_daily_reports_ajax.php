<?php include '../includes/config.php';

$date = $_GET['date'];
$emp_id = $_GET['emp'];

?>

<div class="table-responsive">
    <table id="bootstrap-data-table" class="table table-striped table-bordered table-sm">
        <div class="form-group">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Total Calls Created</th>
                    <th>Social Media Activities(Links & Comments Created)</th>
                    <th>Selected Date </th>


                </tr>
            </thead>

            <tbody>
                <?php
                  $query2="SELECT * FROM social_media where emp_id=$emp_id AND activity_date='$date'";
                  $result2 = mysqli_query($con, $query2);

                $query = " SELECT lead_calls.call_lead_id,lead.lead_id,lead.lead_emp_id,substring(lead_calls.call_date_time,1,10) FROM lead inner join lead_calls
                            on lead.lead_id=lead_calls.call_lead_id where lead.lead_emp_id=$emp_id AND
                            substring(lead_calls.call_date_time,1,10)='$date'";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) == 0 && mysqli_num_rows($result2)==0) {
                    echo "<tr><td colspan='8' style='text-align:center;color:#fff;font-size:20px;background-color:#dc3545;'>No Activity In This Day</td></tr>";
                } else {
                    $i = 1;
                    // while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo mysqli_num_rows($result) > 0  ? mysqli_num_rows($result) : "0" ?></td>
                            <td><?php echo mysqli_num_rows($result2) > 0  ? mysqli_num_rows($result2) : "0" ?></td>
                            <td><?php echo  $date  ?></td>


                        </tr>
                <?php
                        $i++;
                    // }
                }
                ?>
            </tbody>


        </div>
    </table>
</div>