<?php include '../includes/header_admin.php'; ?>
<?php include '../includes/config.php'; ?>

<?php
if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = -1;
}
if (isset($_GET['emp_from_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_from_id'];
    echo '<script> window.top.location="transfer_lead.php"; </script>';
}

if (!isset($_SESSION['category_id'])) {
    $_SESSION['category_id'] = -1;
}
if (isset($_GET['cat_to_transfer'])) {
    $_SESSION['category_id'] = $_GET['cat_to_transfer'];
    echo '<script> window.top.location="transfer_lead.php"; </script>';
}
if (isset($_POST['transfer'])) {
    $lead_to_emp_transfer = $_POST['emp_name_to'];

    foreach ($_POST['checkbox2'] as $transfer) {
        $query = "UPDATE lead SET lead_emp_id='$lead_to_emp_transfer' where lead_id='$transfer'";
        $res = mysqli_query($con, $query);
    }
    if ($res) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Transfer Leads To Another Employee Completed  </div>";

        echo "<script type='text/Javascript'>
			window.setTimeout(function() {
			window.location.href = 'transfer_lead.php';
			}, 2000);</script>";
    } else {

         echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>ERROR In Transfer " . mysqli_error($con) . "</div>";
    }
}


?>
<div class='container'>
<div class="content">

    <div class="animated fadeIn">


        <div class="row-fluid">
            <div class="col-12">
                <div class="card">

                    <div class="card-header bg-primary text-light">
                        <strong class="card-title" >Transfer Leads</strong>
                    </div>

                    <div class="card-body card-block position-relative">
                        <form id="" action="" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Transfer leads from</label>

                                        <?php
                                        $query = "SELECT * FROM employee";

                                        $result = mysqli_query($con, $query);

                                        echo "<select required id='select_emp_from' name='emp_name_from' class='form-control' >";
                                        echo "<option disabled selected value=''>Select Employee </option>";
                                        while ($emp_data = mysqli_fetch_assoc($result)) {
                                            if ($_SESSION['emp_id'] == $emp_data['emp_id']) {

                                                echo "<option selected value='" . $emp_data['emp_id'] . "'>" . $emp_data['emp_name'] . "</option>";
                                            } else {
                                                echo "<option value='" . $emp_data['emp_id'] . "'>" . $emp_data['emp_name'] . "</option>";
                                            }
                                        }

                                        echo "</select>";
                                        ?>

                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Transfer To</label>

                                        <?php
                                        $query = "SELECT * FROM employee";

                                        $result = mysqli_query($con, $query);

                                        echo "<select required name='emp_name_to' class='form-control' >";
                                        echo "<option disabled selected value=''>Select Employee </option>";
                                        while ($emp_data = mysqli_fetch_assoc($result)) {

                                            echo "<option value='" . $emp_data['emp_id'] . "'>" . $emp_data['emp_name'] . "</option>";
                                        }

                                        echo "</select>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Basic Form-->

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Category</label>

                                        <?php
                                        $query = "SELECT * FROM categorie";

                                        $result = mysqli_query($con, $query);

                                        echo "<select required id='cat_to_transfer' name='cat_transfer' class='form-control' ><option value='-1'>All</option>";

                                        while ($transfer_data = mysqli_fetch_assoc($result)) {
                                            if ($_SESSION['category_id'] == $transfer_data['cat_id']) {

                                                echo "<option selected value='" . $transfer_data['cat_id'] . "'>" . $transfer_data['cat_name'] . "</option>";
                                            } else {

                                                echo "<option value='" . $transfer_data['cat_id'] . "'>" . $transfer_data['cat_name'] . "</option>";
                                            }
                                        }

                                        echo "</select>";
                                        ?>

                                    </div>

                                </div>





                                <div class="custom-control custom-checkbox" style="margin-left: 25px; margin-top: 25px;">
                                    <input type="checkbox" name="checkbox2" class="custom-control-input" value="selectalls" id="two">&nbsp;&nbsp;
                                    <label class="custom-control-label" for="two">Select All </label>&nbsp;&nbsp;

                                </div>
                                <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success btn-sm"
                                        name="transfer"  style="width: 120px; height: 40px; margin-left:120px;">Transfer Leads</button>
                                </div>




                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                            <thead>
                                                <tr>

                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                if ($_SESSION['category_id'] > 0) {

                                                    $query = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead_emp_id='{$_SESSION['emp_id']}'
                                                                AND lead_cat_id='{$_SESSION['category_id']}' AND call_lead_id is null";
                                                } else {
                                                    $query = "SELECT * from lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead_emp_id='{$_SESSION['emp_id']}'
                                                                 AND call_lead_id is null";
                                                }


                                                $result = mysqli_query($con, $query);

                                                $c = 0;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>

                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name='checkbox2[]' class="custom-control-input" value="<?php echo $row['lead_id']; ?>" id="lead<?php echo $c; ?>">&nbsp;&nbsp;
                                                                <label class="custom-control-label" for="lead<?php echo $c; ?>"><?php echo $row['lead_name']; ?></label>&nbsp;&nbsp;
                                                            </div>
                                                        </td>

                                                        <td> <?php echo $row['lead_email']; ?></td>
                                                        <td> <?php echo $row['lead_mobile']; ?></td>

                                                    </tr>
                                                    <?php
                                                    $c++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </form>
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

    $('#select_emp_from').change(function () {
            window.top.location = "transfer_lead.php?emp_from_id=" + $(this).val();
        });
        $('#cat_to_transfer').change(function () {
            window.top.location = "transfer_lead.php?cat_to_transfer=" + $(this).val();

        });

        $('#two').click(function () {
            $("input[id^=lead]").prop('checked', $(this).prop('checked'));
        });

});

    </script>