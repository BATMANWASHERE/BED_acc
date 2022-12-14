<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';
session_start();
ob_start();

require '../../includes/bed-session.php';

if ($_SESSION['role'] == "Student" && $_GET['notif'] == 1) {
    
} elseif ($_SESSION['role'] != "Accounting" && $_SESSION['role'] != "Admission") {
    header('location: ../../pages/bed-404/page404.php');
} else {
    
}
$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];

$assessed_id = $_GET['assessed_id'];
date_default_timezone_set('Asia/Manila');

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
                    <a href="#" class="nav-link disabled text-light">Assessment Fee</a>
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
                            <div class="col-md-8">
                                <div class="card card-purple shadow-lg">
                                    <?php
                                        $get_tuitionInfo = mysqli_query($acc, "SELECT *, tbl_assessed_tf.last_updated, tbl_assessed_tf.created_at, tbl_assessed_tf.updated_by FROM tbl_assessed_tf
                                        LEFT JOIN tbl_tuition_fee ON tbl_assessed_tf.tf_id = tbl_tuition_fee.tf_id
                                        WHERE assessed_id = $assessed_id") or die(mysqli_error($acc));

                                        while ($row = mysqli_fetch_array($get_tuitionInfo)) {
                                            
                                            $discount_array = explode(",",$row['disc_id']);
                                            $created_at = new DateTime($row['created_at']);
                                            $last_updated = new DateTime($row['last_updated']);

                                            $get_studentInfo = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.student_lname, ', ', tbl_students.student_fname, ' ', tbl_students.student_mname) AS fullname FROM tbl_schoolyears
                                            LEFT JOIN tbl_students ON tbl_schoolyears.student_id = tbl_students.student_id
                                            WHERE tbl_schoolyears.student_id = '$row[stud_id]' and tbl_schoolyears.ay_id = '$row[ay_id]'") or die(mysqli_error($conn));

                                            while ($row3 = mysqli_fetch_array($get_studentInfo)) {
                                                $grade_ident = $row3['grade_level_id'];
                                                $stud_id = $row3['student_id'];
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title">Assessment Fee for <b><?php echo $row3['fullname'];?></b>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <?php
                                        
                                            
                                        ?>
                                    <form method="POST">
                                        <div class="card-body">
                                            
                                        <div>
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Tuition Breakdown</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <table class="table">
                                                    <thead>
                                                        <tr>
                                                        <th>Fees</th>
                                                        <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                        <td>Tuition Fee</td>
                                                        <td style="text-align: right;"><?php echo number_format($row['tuition_fee'], 2);?></td>
                                                        </tr>
                                                        <?php
                                                             if (!empty($row['disc_id'])) {
                                                                $tuition_fee = $row['tuition_fee'];
                                                        ?>
                                                                <tr>
                                                                <td>Discounts: </td>
                                                                <td></td>
                                                                </tr>
                                                        <?php
                                                        foreach ($discount_array as $discounts_value) { //repeats multiple times
                                                            $select_discount = mysqli_query($acc, "SELECT * FROM tbl_discounts WHERE disc_id = $discounts_value");
                                                            while ($row10 = mysqli_fetch_array($select_discount)) { //only repeats one time
                                                                if ($row10['discount_status'] == 1) {

                                                                } else {
                                                                    if ($row10['percent'] == 1) {
                                                                        $percent_value = number_format(floor((($row10['discount'] / 100) * $tuition_fee) * 100)/ 100, 2, '.', ''); //this took forever king ina
                                                                        $tuition_fee = $tuition_fee - $percent_value;
                                                                    } else {
                                                                        $tuition_fee = $tuition_fee - $row10['discount'];
                                                                    }
                                                                }
                                                        ?>
                                                        <tr>
                                                        <td> &emsp;&emsp;<?php echo $row10['discount_desc'];?>      <?php echo ($row10['discount_status']== 1 ? '<em><small>will reflect only.</small></em>' : '');?></td>
                                                        <?php
                                                            if ($row10['percent'] == '1') {
                                                        ?>
                                                        <td style="text-align: right;"><?php echo $row10['discount'];?>% <?php echo ($row10['discount_status']== 1 ? '' : '('.number_format($percent_value, 2).')');?> </td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                        <td style="text-align: right;"><?php echo number_format($row10['discount'], 2);?></td>
                                                        <?php
                                                            }
                                                        ?>
                                                        </tr>
                                                        <?php
                                                        } }
                                                        $total = $tuition_fee + $row['lms'] + $row['miscell_fee'] + $row['instruct_mat'];
                                                        ?>
                                                        <tr>
                                                        <td><b>Total Tuition Fee amount</b></td>
                                                        <td style="text-align: right;"><b><?php echo number_format($tuition_fee, 2);?></b></td>
                                                        </tr>
                                                        <?php
                                                        } else {
                                                            $total = $row['tuition_fee'] + $row['lms'] + $row['miscell_fee'] + $row['instruct_mat'];
                                                        }
                                                        ?>
                                                        <tr>
                                                        <td>Miscellaneous Fee</td>
                                                        <td style="text-align: right;"><?php echo number_format($row['miscell_fee'], 2);?></td>
                                                        </tr>
                                                        <tr>
                                                        <td>LMS</td>
                                                        <td style="text-align: right;"><?php echo number_format($row['lms'], 2);?></td>
                                                        </tr>
                                                        <tr>
                                                        <td>Instructional Materials Fee</td>
                                                        <td style="text-align: right;"><?php echo number_format($row['instruct_mat'], 2);?></td>
                                                        </tr>
                                                        <tr>
                                                        <td><b>TOTAL</b></td>
                                                        <td style="text-align: right;"><b><?php echo number_format($total, 2);?></b></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                        <?php
                                                            if ($_SESSION['role'] == "Accounting") {
                                                        ?>
                                                        <td>
                                                        <p><small> Created at: <?php echo $created_at->format('h:i a \o\n F d, Y');?>.<br>
                                                             Last Updated by: <?php echo $row['updated_by'];?>.<br>
                                                             Last updated at: <?php echo $last_updated->format('h:i a \o\n F d, Y');?>.</small></p>
                                                        </td>
                                                        <td style="text-align: right;">
                                                                <?php
                                                                    $history = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf WHERE status = 'Unpaid' AND stud_id = '$stud_id' AND NOT ay_id = '$ay_id' ORDER BY created_at DESC");
                                                                    while ($row1 = mysqli_fetch_array($history)) {
                                                                        $get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE ay_id = '$row1[ay_id]'");
                                                                        $row_ay = mysqli_fetch_array($get_ay_id);
                                                                        $academic_year = $row_ay['academic_year'];
                                                                ?>

                                                                    <a  class="btn bg-danger text-sm p-2 mb-md-2">Unpaid Account<br><?php echo $academic_year;?></a>

                                                                <?php
                                                                    }
                                                                ?>
                                                        </td>
                                                        <?php
                                                            }
                                                        ?>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                            
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <?php
                                                if ($_SESSION['role'] == "Accounting" || $_SESSION['role'] == "Admission") {
                                            ?>
                                            <a href="list.assess.php" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-check"></i>
                                                Finish
                                            </a>
                                            <a href="accountForms/all_forms_accSH.php?<?php echo 'stud_id=' . $stud_id . '&glvl_id=' . $grade_ident; ?>" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-file-pdf"></i>
                                                Reg Form
                                            </a>
                                            <?php
                                            if ($_SESSION['role'] == "Accounting") {
                                            ?>
                                            <a href="add.payment.php<?php echo '?stud_id=' . $stud_id; ?>" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-edit"></i>
                                                Add Payment Status
                                            </a>
                                            <?php
                                            }
                                            ?>
                                            <a href="edit.assessment.php<?php echo '?assessed_id=' . $assessed_id; ?>" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-edit"></i>
                                                Edit Assessment
                                            </a>
                                            <?php 
                                                } else {
                                            ?>
                                            <a href="../bed-dashboard/index.php" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-check"></i>
                                                Finish
                                            </a>
                                            <?php
                                                }
                                            ?>
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
    <?php include '../../includes/bed-footer.php'; ?>




</body>

</html>