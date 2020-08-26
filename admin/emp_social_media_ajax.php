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
                <th>Activity Type</th>
                <th>Facebook Link</th>
                <th>Comment Or Message </th>
                <th>Group Name</th>
                <th>Page Name</th>
                <th>Used Account</th>
                <th>Activity Date </th>


            </tr>
        </thead>

        <tbody>
                <?php
                // if(!isset($_GET['date']&&$_GET['emp'])){

                // }
                $query="SELECT * FROM social_media where activity_date='$date' AND emp_id='$emp_id'
                        ORDER BY social_id DESC";
                $result=mysqli_query($con,$query);

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan='8' style='text-align:center;color:#fff;font-size:20px;background-color:#dc3545;'>No Activity In This Day</td></tr>";
                }else{
                 $i=1;
                while($row=mysqli_fetch_assoc($result)){
                ?>
            <tr>
            <td><?php  echo   $i ?></td>
            <td><?php  echo  $row['activity_type']?></td>
            <td><?php  echo  $row['fb_link']  ?></td>
            <td><?php  echo  $row['message']  ?></td>
            <td><?php  echo  $row['group_name'] ?></td>
            <td><?php  echo  $row['page_name']  ?></td>
            <td><?php  echo  $row['fb_account'] ?></td>
            <td><?php  echo  $row['activity_date']  ?></td>

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
