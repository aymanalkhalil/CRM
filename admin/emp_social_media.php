<?php
include '../includes/header_admin.php';
include '../includes/config.php';

$date = date("Y-m-d");
?>
<div class='container'>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- display Social Media -->
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header bg-primary">
                        <div class="row">
                            <div class="col-12 text-light">
                                <strong class="card-title m-0">View Social Media Activity</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class='row'>
                            <div class='col-6'>

                                <div class="form-group">
                                    <label for="employee">Choose Employee </label>
                                    <select class="form-control" name="emp_id" id="employee_choose" required>
                                        <?php

                                        $sql = "SELECT emp_id,emp_name FROM employee";
                                        $res = mysqli_query($con, $sql);
                                        echo "<option disabled selected value='-1'>Choose Employee</option>";
                                        while ($row = mysqli_fetch_assoc($res)) {

                                            echo "<option value='{$row['emp_id']}'>" . $row['emp_name'] . "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class='col-6'>

                                <div class="form-group">
                                    <label for="Date">Choose Date </label>
                                    <input type='date' name="date" id='date' value='<?php echo $date ?>' class="form-control">
                                </div>

                            </div>

                            <div class='col-12'>
                                <div id='row2'>
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
                                                    echo  "<tr><td colspan='8' style='text-align:center;color:#000;font-size:20px;background-color:#17a2b8;'>
                                                                Please Choose Date & Employee To View His/Her Activity </td></tr>";
                                                    ?>
                                                </tbody>



                                            </div>
                                        </table>

                                    </div>




                                </div>
                            </div>









                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br>
            </div>

        </div>
    </div>

</div>
                                    </div>





<?php include '../includes/footer.php' ?>
<script>
    $(document).ready(function() {
        $("#date").change(function() {
            var emp = $("#employee_choose").val();
            var date = $("#date").val();
            $.ajax({
                type: "GET",
                url: "emp_social_media_ajax.php?emp=" + emp +
                    "&date=" + date,
                cache: false,
                success: function(data) {
                    $("#row2").html(data);


                }

            });



        });

    });
</script>