<?php
include '../includes/header_emp.php';
include '../includes/config.php';


$date=date("Y-m-d");
if (isset($_POST['send'])) {
    $activity   = $_POST['activity_type'];
    $fb_link    = $_POST['fb_link'];
    $message    = $_POST['message'];
    $page_name  = $_POST['page_name'];
    $group_name = $_POST['group_name'];
    $used_account = $_POST['used_account'];
    $activity_date=$_POST['activity_date'];
    if (!empty($page_name or $group_name)) {
        $query = "INSERT INTO social_media(activity_type,fb_link,message,page_name,group_name,fb_account,activity_date,emp_id)
        VALUES('$activity','$fb_link','$message','$page_name','$group_name','$used_account','$activity_date','{$_SESSION['emp_id']}')";
        $result = mysqli_query($con, $query);
    } else {
        $query = "INSERT INTO social_media(activity_type,fb_link,message,page_name,group_name,fb_account,activity_date,emp_id)
    VALUES('$activity','$fb_link','$message','لايوجد','لايوجد','$used_account','$activity_date','{$_SESSION['emp_id']}')";
        $result = mysqli_query($con, $query);
    }


    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Activity Saved Successfully - تم حفظ النشاط </div>";

        echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'social_media.php';
         }, 2000);</script>";
    } else {

        echo "Error In Saving Activity " . mysqli_error($con);
    }
}

if(isset($_POST['edit'])){
    $edit_activity_date = $_POST['edit_activity_date'];
    $edit_activity   = $_POST['edit_activity_type'];
    $edit_fb_link    = $_POST['edit_fb_link'];
    $edit_message    = $_POST['edit_message'];
    $edit_page_name  = $_POST['edit_page_name'];
    $edit_group_name = $_POST['edit_group_name'];
    $edit_used_account = $_POST['edit_used_account'];
    $social_id=$_POST['social_id'];

    if (!empty($edit_page_name or $edit_group_name)) {
    $update_q="UPDATE social_media SET activity_type='$edit_activity',fb_link='$edit_fb_link',message='$edit_message'
    ,page_name='$edit_page_name',group_name='$edit_group_name',fb_account='$edit_used_account',activity_date='$edit_activity_date',emp_id='{$_SESSION['emp_id']}' where social_id='$social_id'";
            $res_update = mysqli_query($con, $update_q);
    } else {
        $update_q="UPDATE social_media SET activity_type='$edit_activity',fb_link='$edit_fb_link',message='$edit_message'
        ,page_name='لايوجد',group_name='لايوجد',fb_account='$edit_used_account',activity_date='$edit_activity_date',emp_id='{$_SESSION['emp_id']}' where social_id='$social_id'";
        $res_update = mysqli_query($con, $update_q);

    }
    if ($res_update) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Activity Updated Successfully - تم تعديل النشاط </div>";

        echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'social_media.php';
         }, 2000);</script>";
    } else {

        echo "Error In Editing Activity " . mysqli_error($con);
    }



}
if (isset($_POST['remove'])) {
    $social_id=$_POST['delete_social_id'];

    $delete="DELETE FROM social_media where social_id=$social_id";
    $deleteSuccess = mysqli_query($con, $delete);

    if($deleteSuccess){
        echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>Activity Deleted Successfully - تم حذف النشاط </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'social_media.php';
             }, 2000);</script>";
    }else {

        echo "Error In Deleting Activity " . mysqli_error($con);
    }

    }




?>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- display Social Media -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="row pull-right">
                            <div class="col-12 text-light">
                                <strong class="card-title m-0"> نشاطات مواقع التواصل الاجتماعي</strong>
                            </div>
                        </div>
                    </div>



                    <form action='' method='POST'>
                        <div class="card-body">
                            <div class='row'>


                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="fb_link" class='pull-right'> رابط الفيسبوك</label>

                                        <input type="text" name="fb_link" autocomplete='off' placeholder='www.facebook.com/....' class="form-control" value="" required>

                                    </div>

                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="Activity" class='pull-right'> نوع النشاط</label>
                                        <select id="employee" dir='rtl' name="activity_type" class="form-control" required>
                                            <option selected disabled value='الرجاء اختيار نوع النشاط'>الرجاء اختيار نوع النشاط</option>
                                            <option value='رسالة'>رسالة</option>
                                            <option value='تعليق على منشور قديم'>تعليق على منشور قديم</option>
                                            <option value='التواصل مع الطلاب المسجلين والمستفسرين'>التواصل مع الطلاب المسجلين والمستفسرين</option>
                                            <option value='الاعلان عن الدورات'>الاعلان عن الدورات</option>
                                            <option value='الدخول الى مجموعات جديدة'>الدخول الى مجموعات جديدة</option>
                                            <option value='متابعة المجموعات القديمة'>متابعة المجموعات القديمة</option>
                                            <option value='ارسال طلبات صداقة جديدة'>ارسال طلبات صداقة جديدة</option>
                                        </select>
                                    </div>

                                </div>
                                <div class='col-12'>
                                    <div class="form-group">
                                        <label for="message" class='d-flex justify-content-center' class='pull-right'> الرسالة او التعليق</label>

                                        <textarea rows='4' dir='rtl' autocomplete='off' name="message" placeholder="مثال : تم التواصل مع اشخاص مشاركين على منشورات" class="form-control" required></textarea>

                                    </div>

                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="page_name" class='pull-right'> اسم الصفحة </label>

                                        <input type="text" dir='rtl' autocomplete='off' name="page_name" placeholder='مثال : نقابة المبرمجين الأردنيين' class="form-control">

                                    </div>

                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="group_name" class='pull-right'> اسم المجموعة </label>

                                        <input type="text" dir='rtl' autocomplete='off' name="group_name" placeholder='مثال : نقابة المبرمجين الأردنيين' class="form-control">

                                    </div>

                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="activity_date" class='pull-right'>تاريخ النشاط على مواقع التواصل </label>

                                    <input type="date" name="activity_date"  class="form-control" value="<?php echo $date ?>" required>

                                    </div>
                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="group_name" class='pull-right'>حساب الفيسبوك المستخدم</label>

                                        <select type="text" dir='rtl' name="used_account" class="form-control" value="" required>
                                            <option value='Lara UpSkills'>Lara UpSkills</option>
                                            <option value='Dana UpSkills'>Dana UpSkills</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" name="send" value="add">اضافة</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="row pull-right">
                            <div class="col-12 text-light">
                                <strong class="card-title m-0"> النشاطات</strong>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query_s = "SELECT * FROM social_media where emp_id='{$_SESSION['emp_id']}' order by social_id DESC";
                    $result_s = mysqli_query($con, $query_s);
                    $i = 1;

                        ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered table-sm">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نوع النشاط</th>
                                            <th>رابط الفيسبوك</th>
                                            <th>الرسالة او التعليق</th>
                                            <th>اسم المجموعة</th>
                                            <th>اسم الصفحة</th>
                                            <th>الحساب المستخدم</th>
                                            <th>تاريخ النشاط</th>
                                            <th>الخيارات</th>

                                        </tr>
                                    </thead>
                                    <?php while ($row = mysqli_fetch_assoc($result_s)) { ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['activity_type']; ?></td>
                                            <td><?php echo $row['fb_link']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <td><?php echo $row['group_name']; ?></td>
                                            <td><?php echo $row['page_name']; ?></td>
                                            <td><?php echo $row['fb_account']; ?></td>
                                            <td><?php echo $row['activity_date']; ?></td>
                                            <td>
                                                <!-- modal -->
                                                <!-- Button trigger modal -->
                                                <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal<?php echo $i; ?>'>
                                                    تعديل
                                                </button>

                                                <!-- Modal -->
                                                <div class='modal fade' id='modal<?php echo $i; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-primary text-light'>
                                                                <h5 class='modal-title d-inline pull-right' id='exampleModalLongTitle'>

                                                                    التعديل على النشاط
                                                                </h5>
                                                                <button type='button' class='close text-light pull-left' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body pb-0'>
                                                                <!-- form edit notification -->
                                                                <form action='' method='POST'>
                                                                    <input type='hidden' name='social_id' value='<?php echo $row['social_id']; ?>'>

                                                                    <div class="form-group">
                                                                        <label for="Activity" class='pull-right'>تعديل نوع النشاط </label>
                                                                        <select class="form-control" dir='rtl' name="edit_activity_type" required>
                                                                            <option selected disabled value='الرجاء اختيار نوع النشاط'>الرجاء اختيار نوع النشاط</option>
                                                                            <option <?php echo $row['activity_type'] == 'رسالة' ? 'selected' : '';  ?> value='رسالة'>رسالة</option<>
                                                                            <option <?php echo $row['activity_type'] == 'تعليق على منشور قديم' ? 'selected' : '';  ?> value='تعليق على منشور قديم'>تعليق على منشور قديم</option>
                                                                            <option <?php echo $row['activity_type'] == 'التواصل مع الطلاب المسجلين والمستفسرين' ? 'selected' : '';  ?> value='التواصل مع الطلاب المسجلين والمستفسرين'>التواصل مع الطلاب المسجلين والمستفسرين</option>
                                                                            <option <?php echo $row['activity_type'] == 'الاعلان عن الدورات' ? 'selected' : ''; ?> value='الاعلان عن الدورات'>الاعلان عن الدورات</option>
                                                                            <option <?php echo $row['activity_type'] == 'الدخول الى مجموعات جديدة' ? 'selected' : ''; ?> value='الدخول الى مجموعات جديدة'>الدخول الى مجموعات جديدة</option>
                                                                            <option <?php echo $row['activity_type'] == 'متابعة المجموعات القديمة' ? 'selected' : '';  ?> value='متابعة المجموعات القديمة'>متابعة المجموعات القديمة</option>
                                                                            <option <?php echo $row['activity_type'] == 'ارسال طلبات صداقة جديدة' ? 'selected' : '';  ?> value='ارسال طلبات صداقة جديدة'>ارسال طلبات صداقة جديدة</option>

                                                                        </select>

                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label for="fb_link" class='pull-right'> تعديل رابط الفيسبوك </label>

                                                                        <input type="text" name="edit_fb_link" autocomplete='off' class="form-control" value="<?php echo $row['fb_link'] ?>" required>

                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="message" class='d-flex justify-content-center' class='pull-right'> تعديل الرسالة او التعليق</label>

                                                                        <textarea rows='4' dir='rtl' autocomplete='off' name="edit_message" class="form-control" required><?php echo $row['message'] ?></textarea>


                                                                    </div>




                                                                    <div class="form-group">
                                                                        <label for="page_name" class='pull-right'> تعديل اسم الصفحة </label>

                                                                        <input type="text" dir='rtl' autocomplete='off' name="edit_page_name" value="<?php echo $row['page_name'] ?>" class="form-control">

                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="group_name" class='pull-right'> تعديل اسم المجموعة </label>

                                                                        <input type="text" dir='rtl' autocomplete='off' name="edit_group_name" value="<?php echo $row['group_name'] ?>" class="form-control">

                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="group_name" class='pull-right'> تعديل حساب الفيسبوك المستخدم</label>

                                                                        <select type="text" dir='rtl' name="edit_used_account" class="form-control" value="" required>
                                                                            <option <?php echo $row['fb_account'] == 'Lara UpSkills' ? 'selected' : ''; ?>value='Lara UpSkills'>Lara UpSkills</option>
                                                                            <option <?php echo $row['fb_account'] == 'Dana UpSkills' ? 'selected' : ''; ?> value='Dana UpSkills'>Dana UpSkills</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="edit_activity_date" class='pull-right'> تعديل تاريخ النشاط على مواقع التواصل </label>

                                                                      <input type='date' class='form-control' name='edit_activity_date' value='<?php echo $row['activity_date']?>'>
                                                                    </div>


                                                                    <div class='modal-footer'>
                                                                    <input type='hidden' name='social_id' value='<?php echo $row['social_id']; ?>'>
                                                                        <button type='submit' class='btn btn-warning' name="edit" value="edit">تعديل</button>
                                                                    </div>
                                                                </form>
                                                                <!-- end form -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end modal -->
                                                <form  action='social_media.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='delete_social_id' value='<?php echo $row['social_id']; ?>'>
                                                    <button class='btn btn-danger btn-sm' type='submit' name='remove' vlaue='remove'>حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                $i++;
                            }
                            ?>
                                </table>

                            </div>
                        </div>
                </div>
            </div>
        </div>






    </div>
    <!-- / .Animated -->
</div>


<?php include '../includes/footer.php'; ?>