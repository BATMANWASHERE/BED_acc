<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';
session_start();
ob_start();


require '../../includes/bed-session.php';
$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];

$stud_id = $_GET['stud_id'];
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Assessment Fee | SFAC Bacoor</title>
    <?php include '../../includes/bed-head.php'; ?>
    

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Assess Fee</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Basic Education</a>
                </li>
            </ul>
            <?php include '../../includes/bed-navbar.php'; ?>

            <!-- sidebar menu -->
            <?php include '../../includes/bed-sidebar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper pt-4">

                <section class="content">
                    <div class="container-fluid pl-5 pr-5 pb-3">
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-12">
                                <div class="card card-purple shadow-lg">
                                    <?php
                                        $student_info = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.student_lname, ', ', tbl_students.student_fname, ' ', tbl_students.student_mname) AS fullname FROM tbl_schoolyears
                                        LEFT JOIN tbl_students ON tbl_schoolyears.student_id = tbl_students.student_id
                                        WHERE tbl_students.student_id = '$stud_id' AND ay_id = '$ay_id'") or die(mysqli_error($conn));

                                        while ($row1 = mysqli_fetch_array($student_info)) {
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title">Assessment Fee for <b><?php echo $row1['fullname']?></b>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <?php
                                        $tuition_info = mysqli_query($acc, "SELECT * FROM tbl_tuition_fee WHERE grade_level_id = $row1[grade_level_id] AND ay_id = '$ay_id'") or die (mysqli_error($acc));

                                        while ($row = mysqli_fetch_array($tuition_info)) {
        
                                        
                                        ?>

                                    <form action="userData/ctrl.addAssessment.php<?php echo '?stud_id=' . $stud_id; ?>" method="POST">
                                        <div class="card-body">
                                            <div class="row">
                                            <div class="col-6 justify-content-center">
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Grade</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Grade" name="grade" disabled>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_grade_levels WHERE grade_level_id = '$row[grade_level_id]'");
                                                        while($row2 = mysqli_fetch_array($query)) {
                                                            $grade = $row2['grade_level_id'];
                                                            echo '<option selected value="'.$row2['grade_level_id'].'">'.$row2['grade_level'].'</option>';
                                                        }
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_grade_levels WHERE NOT grade_level_id = '$row[grade_level_id]'");
                                                            while($row3 = mysqli_fetch_array($query)) {
                                                                echo '<option value="'.$row3['grade_level_id'].'">'.$row3['grade_level'].'</option>';
                                                            }
                                                        ?>
                                                        <input type="text" class="form-control" name="grade" value="<?php echo $grade;?>" hidden>
                                                    </select>
                                                    
                                                </div>
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Academic Year</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Year" name="ay" disabled>
                                                        <?php
                                                        $query_diffdb = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE ay_id = '$row[ay_id]'");
                                                        while($row4 = mysqli_fetch_array($query_diffdb)) {
                                                            $ay_value = $row4['ay_id'];
                                                            echo '<option selected value="'.$row4['ay_id'].'">'.$row4['academic_year'].'</option>';
                                                        }
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE NOT ay_id = '$row[ay_id]'");
                                                            while($row5 = mysqli_fetch_array($query2)) {
                                                                echo '<option value="'.$row5['ay_id'].'">'.$row5['academic_year'].'</option>';
                                                            }
                                                        ?>
                                                        <input type="text" class="form-control" name="ay_id" value="<?php echo $ay_value;?>" hidden>
                                                    </select>
                                                    
                                                </div>
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Semester</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Year" disabled>
                                                        <?php
                                                        if ($grade == 14 || $grade == 15) {
                                                            $sem = mysqli_query($conn,"SELECT semester_id FROM tbl_active_semesters");
                                                            $sem_id = mysqli_fetch_array($sem);
                                                            $query_diffdb = mysqli_query($conn, "SELECT * FROM tbl_semesters WHERE semester_id = '$sem_id[semester_id]'");
                                                            while($row4 = mysqli_fetch_array($query_diffdb)) {
                                                                $sem_value = $row4['semester_id'];
                                                                echo '<option selected value="'.$row4['semester_id'].'">'.$row4['semester'].'</option>';
                                                            }
                                                            $query2 = mysqli_query($conn, "SELECT * FROM tbl_semesters WHERE NOT semester_id = '$sem_id[semester_id]'");
                                                                while($row5 = mysqli_fetch_array($query2)) {
                                                                    echo '<option value="'.$row5['semester_id'].'">'.$row5['semester'].'</option>';
                                                                }
                                                            } else {
                                                                echo '<option>Not applicable for grade level</option>';
                                                            }
                                                        ?>
                                                        <input type="text" class="form-control" name="sem" value="<?php echo $sem_value;?>" hidden>
                                                    </select>
                                                    
                                                </div>
                                                <input type="text" class="form-control" name="tf_id" id="tuition_fee"value="<?php echo $row['tf_id']; ?>" hidden>
                                                
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Tuition Fee</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="tuition_fee" id="tuition_fee" value="<?php echo $row['tuition_fee']; ?>" disabled>
                                                        
                                                </div>
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Miscellaneous Fee</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="miscell_fee" id="miscell_fee" value="<?php echo $row['miscell_fee']; ?>" disabled>
                                                        
                                                </div>
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Learning Management System</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="lms" id="lms" value="<?php echo $row['lms']; ?>" disabled>
                                                        
                                                </div>
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Instructional Materials</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="instruct_mat" id="instruct_mat" value="<?php echo $row['instruct_mat']; ?>" disabled>
                                                        
                                                </div>
                                            
                                            </div>
                                            <div class="col-3 justify-content-center">
                                                <div class="input-group row mb-2">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Type of Payment</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple" name="payment"
                                                        data-placeholder="Select Year">
                                                        <option value="cash">Cash</option>
                                                        <option value="trimestral">Trimestral</option>
                                                        <option value="quarterly">Quarterly</option>
                                                    </select>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label>Discounts:</label>
                                                    <div class="form-group">
                                                        <?php
                                                            $discountSelect = mysqli_query($acc, "SELECT * FROM tbl_discounts WHERE ay_id = '$ay_id'") or die(mysqli_error($conn));
                                                            $index = 0;
                                                            while($row7 = mysqli_fetch_array($discountSelect)) {

                                                                if ($row7['percent'] == '1') {
                                                                    $discount_label = $row7['discount_desc'] .' - <b>'.$row7['discount'].'%</b>';
                                                                } else {
                                                                    $discount_label = $row7['discount_desc'] .' - <b>Php '.number_format($row7['discount']).'</b>';
                                                                }

                                                        ?>

                                                        <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="discounts_checkbox[]" value="<?php echo $row7['disc_id'];?>">
                                                        <label class="form-check-label"><?php echo $discount_label;?></label>
                                                        </div>
                                                        <?php

                                                            
                                                            $index++;}
                                                        ?>
                                                        <input type="text" name="index_value" id="index_value" value="<?php echo $index;?>" hidden>
                                                    </div>
                                                </div>
                                                           
                                            </div>
                                        </div>
                                        
                                            <hr class="bg-navy">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-3 mb-2">
                                                    <h7><b>Trimestral Basis</b></h7>
                                                </div>
                                                <?php
                                                $get_dates = mysqli_query($acc, "SELECT * FROM tbl_installment_dates WHERE ay_id = '$ay_id'");
                                                    while ($row1 = mysqli_fetch_array($get_dates)) {

                                                ?>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="first_semester" id="first_semester" placeholder="" value="<?php echo $row1['first_semester'];?>" disabled>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="second_semester" id="second_semester" placeholder="" value="<?php echo $row1['second_semester'];?>" disabled>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upon Enrollment</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="upon_enrollment_tri" id="upon_enrollment_tri" onkeyup="reSum1();" value="<?php echo $row['upon_enrollment_tri']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">1st Semester</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="first_tri" id="first_tri" onkeyup="reSum1();" value="<?php echo $row['first_tri']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Second Semester</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="second_tri" id="second_tri" onkeyup="reSum1();" value="<?php echo $row['second_tri']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Total</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="total_tri" id="total_tri" value="<?php echo $row['total_tri']; ?>" disabled>
                                                </div>
                                            </div>

                                            <hr class="bg-navy">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-2 mb-2">
                                                    <h7><b>Quarterly Basis</b></h7>
                                                </div>
                                                <?php
                                                $get_dates = mysqli_query($acc, "SELECT * FROM tbl_installment_dates WHERE ay_id = '$ay_id'");
                                                    while ($row1 = mysqli_fetch_array($get_dates)) {

                                                ?>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="first_quarter" id="first_quarter" value="<?php echo $row1['first_quarter']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="second_quarter" id="second_quarter" value="<?php echo $row1['second_quarter']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Dater</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="third_quarter" id="third_quarter" value="<?php echo $row1['third_quarter']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="fourth_quarter" id="fourth_quarter" value="<?php echo $row1['fourth_quarter']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upon Enrollment</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="upon_enrollment_quar" id="upon_enrollment_quar" onkeyup="reSum2();" value="<?php echo $row['upon_enrollment_quar']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">First Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="first_quar" id="first_quar" onkeyup="reSum2();" value="<?php echo $row['first_quar']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">2nd Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="second_quar" id="second_quar" onkeyup="reSum2();" value="<?php echo $row['second_quar']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">3rd Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="third_quar" id="third_quar" onkeyup="reSum2();" value="<?php echo $row['third_quar']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">4th Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="fourth_quar" id="fourth_quar" onkeyup="reSum2();" value="<?php echo $row['fourth_quar']; ?>" disabled>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Total</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="total_quar" id="total_quar" value="<?php echo $row['total_quar']; ?>" disabled>
                                                </div>
                                            </div>             
                                   
                                            
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn bg-purple"><i
                                                    class="fas fa-calendar-check m-1"> </i> Assess Fee</button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </section>
                <!-- Main content -->


            </div><!-- /.container-fluid -->

            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Footer and script -->
    <script>
        jQuery(function ($) {        
        $('form').bind('submit', function () {
            $(this).find(':select').prop('disabled', false);
        });
        });
    </script>
    <?php include '../../includes/bed-footer.php'; ?>




</body>

</html>