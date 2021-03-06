<?php
include '../includes/header_admin.php';
include '../includes/config.php';



?>
<div class='container'>
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- display admin -->
            <div class="row-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <div class="row ">
                                <div class="col-4 d-flex align-items-center text-light">
                                    <strong class="card-title m-0 ">Employee Daily Activity Report</strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class='row'>
                                <div class='col-6'>

                                    <div class="form-group">
                                        <label for="employee">Select Employee </label>
                                        <select class="form-control" id="employee">
                                            <?php
                                            $sql = "SELECT * FROM employee";
                                            $res = mysqli_query($con, $sql);
                                            echo "<option selected disabled value='-1'>Choose Employee</option>";
                                            while ($row = mysqli_fetch_assoc($res)) {

                                                echo '<option value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-6'>

                                    <div class="form-group">
                                        <label for="employee">Select Date </label>
                                        <input type='date' class='form-control' id="date">
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
                                                            <th>Total Calls Created</th>
                                                            <th>Total Social Media Activities(Links & Comments Created)</th>
                                                            <th>Selected Date </th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        echo  "<tr><td colspan='8' style='text-align:center;color:#fff;font-size:20px;background-color:#007bff;'>
                                                                Please Choose Date & Employee To View His/Her Activity In Selected Date </td></tr>";
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
                </div>
            </div>
        </div>
    </div>
</div>












<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include '../includes/footer.php' ?>
<script>
    $(document).ready(function() {
        $("#date").change(function() {
            var emp = $("#employee").val();
            var date = $("#date").val();
            $.ajax({
                type: "GET",
                url: "emp_daily_reports_ajax.php?emp=" + emp +
                    "&date=" + date,
                cache: false,
                success: function(data) {
                    $("#row2").html(data);


                }

            });



        });

    });
</script>