<?php
include '../includes/header_admin.php';
include '../includes/config.php';


if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = -1;
}
if (isset($_GET['emp_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_id'];
    echo '<script> window.top.location="lead_quality.php"; </script>';
}
$query="SELECT lead.lead_emp_id,lead_calls.call_result,COUNT(lead_calls.call_result) "
        . "FROM lead INNER JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id "
        . "WHERE lead.lead_emp_id={$_SESSION['emp_id']} GROUP BY lead.lead_emp_id,lead_calls.call_result";
$result=  mysqli_query($con, $query);


?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Call Status','Percentage'],
          <?php

          while($row=  mysqli_fetch_assoc($result)){
            echo "['{$row['call_result']}',{$row['COUNT(lead_calls.call_result)']}],";

           }

          ?>

        ]);

        var options = {
          title: 'Leads Quality According To Employee',
          is3D: true,
            animation: {
           		duration: 1500,
        		easing: 'in',
          		startup: true
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);

      }
    </script>
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
                            <div class="col-12 d-flex align-items-center text-light">
                                <strong class="card-title m-0 ">Leads Quality</strong>
                            </div>

                        </div>

                    </div>


                    <div class="card-body">
                        <div class='row'>
                            <div class='col-12'>

                                <div class="form-group">
                                    <label for="employee" >Select Employee</label>
                                    <select id="employee" name="employee" class="form-control">
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
                    </div>
                    <div id="piechart_3d" style="width: 900px; height: 500px; ">
                </div>
            </div>
        </div>
    </div>
</div>


</div>

</div>
<?php include '../includes/footer.php'; ?>
    <script>
      $(document).ready(function () {
        $('#employee').change(function () {
            window.top.location = "lead_quality.php?emp_id=" + $(this).val();
        });
    });
        </script>