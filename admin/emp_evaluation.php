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
                                    <strong class="card-title m-0 ">Employee Evaluation Based On Month</strong>
                                </div>

                            </div>

                        </div>


                        <div class="card-body">

                            <div class='row'>
                                <div class='col-12'>

                                    <div class="form-group">
                                        <label for="employee">Select Employee </label>
                                        <select class="form-control" id="employee">
                                            <?php
                                            $sql = "SELECT * FROM employee";
                                            $res = mysqli_query($con, $sql);
                                            echo "<option selected disabled value='-1'>Choose Employee</option>";
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $_SESSION['emp_name'] = $row['emp_name'];
                                                if ($_SESSION['emp_id'] == $row['emp_id']) {
                                                    echo '<option selected value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-6'>

                                    <div class="form-group">
                                        <label for="Month From">Select Date From </label>
                                        <input type="date" class="form-control" name="date_from" id="date_from">
                                    </div>
                                </div>


                                <div class='col-6'>

                                    <div class="form-group">
                                        <label for="Month To">Select Date To </label>
                                        <input type="date" class="form-control" name="date_to" id="date_to">
                                    </div>
                                </div>
                            </div>

                            <div id="columnchart_material"></div>
                        </div>

                    </div>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
        </div>


    </div>

</div>


<?php include '../includes/footer.php'; ?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    $(document).ready(function() {

        $("#date_to").change(function() {

            var Emp_Choosed = ($("#employee option:selected").val());
            var Date_From = ($("#date_from").val());
            var Date_To = ($("#date_to").val());

            $.ajax({
                url: "emp_evaluation_ajax.php?date_from=" + Date_From +
                    "&date_to=" + Date_To + "&employee=" + Emp_Choosed,
                type: "GET",
                cache: false,
                success: function(data)

                {
                    $("#columnchart_material").html(data);


                }

            });
        });
    });
</script>