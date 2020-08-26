<?php
include '../includes/header_emp.php';
include '../includes/config.php';
// if(strstr($_SERVER['HTTP_REFERER'],'index.php')){
//  var_dump($_SERVER['HTTP_REFERER']);
global $con;
$msg = "";


if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_id'];
}

if (!isset($_SESSION['num_rows'])) {
    $_SESSION['num_rows'] = 15;
}

if (isset($_POST['sub_num'])) {
    $_SESSION['num_rows'] = $_POST['num_row'];
    echo '<script>window.top.location = "called_leads.php"</script>';
}



if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * $_SESSION['num_rows']) - $_SESSION['num_rows'];
$totalLeadsSQL =     "SELECT lead.lead_id, MAX(lead.lead_emp_id) lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time) call_date_time,"
                   . "MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) "
                   . "call_note FROM lead LEFT JOIN lead_calls"
                   . " ON lead.lead_id=lead_calls.call_lead_id "
                   . "WHERE not lead_calls.call_note='Registered Successfully - تم التسجيل'"
                   . " AND lead.lead_emp_id={$_SESSION['emp_id']} GROUP BY lead.lead_id";

$allLeadsResult = mysqli_query($con, $totalLeadsSQL);
$totalLeads = mysqli_num_rows($allLeadsResult);
$lastPage = ceil($totalLeads / $_SESSION['num_rows']);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;

//if (!isset($_SESSION['cat_id'])) {
//    $_SESSION['cat_id'] = -1;
//}
//if (isset($_GET['cat_id'])) {
//    $_SESSION['cat_id'] = $_GET['cat_id'];
//
//    echo '<script> window.top.location="called_leads.php"; </script>';
//}


?>


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">


        <!-- display admin -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <strong class="card-title m-0">Called Leads</strong>
                            </div>
                        </div>
                    </div>



                    <div class="card-body">


                        <nav aria-label="Page navigation example">
                            <div class="row">

                                <?php
                                $retrieveData ="SELECT lead.lead_id, MAX(lead.lead_emp_id) lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time) call_date_time,MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) call_note FROM lead LEFT JOIN lead_calls"
                                               . " ON lead.lead_id=lead_calls.call_lead_id "
                                               . "WHERE not lead_calls.call_note='Registered Successfully - تم التسجيل' AND lead.lead_emp_id={$_SESSION['emp_id']} GROUP BY lead.lead_id ORDER BY lead.lead_id ASC LIMIT {$startFrom} ,{$_SESSION['num_rows']}";
                                $resultRetrieve = mysqli_query($con, $retrieveData);
                                ?>
                                <div class="col-6">
                                    <ul class="pagination justify-content-start">
                                        <?php if ($currentPage != $firstPage): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $firstPage ?>"  tabindex="-1">First Page</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($currentPage >= 2) : ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>">
                                                    <?php echo $previousPage ?></a>
                                            </li>
                                        <?php endif; ?>


                                        <li class="page-item"><a class="page-link" href="?page=<?php echo $currentPage ?>">
                                                <?php echo $currentPage ?></a></li>

                                        <?php if ($currentPage != $lastPage) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $lastPage ?>">Last Page</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>





                                <div class="col-6">
                                    <form action="" method="post" role="form">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group row">
                                                    <label for="num_row" class="col-sm-3 col-form-label">Rows</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="num_row" id="num_row">
                                                            <option <?php echo $_SESSION['num_rows'] == 10 ? 'selected' : ''; ?> value="10">10</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 15 ? 'selected' : ''; ?> value="15">15</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 20 ? 'selected' : ''; ?> value="20">20</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 50 ? 'selected' : ''; ?> value="50">50</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 100 ? 'selected' : ''; ?> value="100">100</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 250 ? 'selected' : ''; ?> value="250">250</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="submit" id="sub_num" name="sub_num" value="Submit" class="form-control btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </nav>


                                    <?php
//                                      $num_rows = "SELECT * FROM lead where lead_emp_id = {$_SESSION['emp_id']} ORDER BY lead.lead_id ASC";
//                                  $res=  mysqli_query($con, $num_rows);

                                  if(isset($totalLeads)){

                                     echo "<div class='col-11 text-center text-success' >Total Leads You Have Called : " . $totalLeads . "</div>";
                                  }  else{
                                    echo  "<div class='col-11 text-center text-danger'>You Didn't Called Any Lead Yet" . "</div>";
                                     }
                                ?>

                        <br>

                        <form action="" method="post">
                            <div class="table-responsive">
                                <div id="row">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>وقت وتاريخ المكالمة الاولى</th>
                                                <th> نتيجة المكالمة</th>
                                                <th> تاريخ المكالمة القادمة</th>
                                                <th> وقت المكالمة القادمة</th>
                                                <th> الملاحظة</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                                ?>

                                                <tr>

                                                    <td><?php echo $i ?></td>
                                                    <td><a class="btn-link" href='lead_profile.php?lead_id=<?php echo $row['lead_id']; ?>'> <?php echo $row['lead_name']; ?></a></td>
                                                    <td><?php echo $row['call_date_time']; ?></td>
                                                    <td><?php echo $row['call_result']; ?></td>
                                                    <td><?php echo isset($row['call_date']) ? $row['call_date'] : 'لا يوجد'; ?></td>
                                                    <td><?php echo isset($row['call_time']) ? date('h:i A ', strtotime($row['call_time'])) : 'لا يوجد' ?></td>
                                                    <td><?php echo $row['call_note']; ?></td>
                                                    </td>

                                                </tr>
                                                <?php
                                                $i++;
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="row2"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- / .display admin -->

        </div>
        <!-- / .Animated -->
    </div>
</div>





<!-- /.content -->
<?php include '../includes/footer.php'; ?>

<!--   <script>

     $("#search").keyup(function () {
      var search = $("#search").val();

      if (search !== "") {
          $("#row2").show();
          $("#row").hide();

          $.ajax(
          {
              type: "GET",
              url: "search_lead_ajax.php?search=" + search,
              cache: false,
              success: function (data)
              {
                  $("#row2").html(data);


              }

          });
      } else {
          $("#row").show();
          $("#row2").hide();

              //                 $("#row2").html("");
          }


      });

  </script>-->
</body>

</html>