<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';
session_start();
ob_start();

require '../../includes/bed-session.php';

$stud_no = $_GET['stud_no'];

?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Edit Discount | SFAC Bacoor</title>
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
                    <a href="#" class="nav-link disabled text-light">Edit Discount</a>
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
                                        $get_studentInfo = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.student_lname, ', ', tbl_students.student_fname, ' ', tbl_students.student_mname) AS fullname FROM tbl_schoolyears
                                        LEFT JOIN tbl_students ON tbl_schoolyears.student_id = tbl_students.student_id
                                        WHERE tbl_students.stud_no = '$stud_no'") or die(mysqli_error($conn));

                                        while ($row3 = mysqli_fetch_array($get_studentInfo)) {
                                            $grade_ident = $row3['grade_level_id'];
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title">Assessment Fee for <b><?php echo $row3['fullname'];?></b>
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <?php
                                        $get_tuitionInfo = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf
                                        LEFT JOIN tbl_tuition_fee ON tbl_assessed_tf.tf_id = tbl_tuition_fee.tf_id
                                        LEFT JOIN tbl_discounts ON tbl_assessed_tf.disc_id = tbl_discounts.disc_id
                                        WHERE stud_no = '$stud_no' LIMIT 1") or die(mysqli_error($acc));

                                        while ($row = mysqli_fetch_array($get_tuitionInfo)) {

                                            if ($row['percent'] == 1) {

                                                $get_disc_id = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf
                                                LEFT JOIN tbl_discounts ON tbl_assessed_tf.disc_id = tbl_discounts.disc_id 
                                                WHERE stud_no = '$stud_no' ORDER BY percent") or die(mysqli_error($acc));

                                                $discount_array = [];

                                                while ($row1 = mysqli_fetch_array($get_disc_id)) {
                                                    if ($row1['disc_id'])

                                                    array_push($discount_array, $row1['disc_id']);
                                                }

                                            } else {

                                                $discount_array = [];
                                                
                                            }

                                            
                                        
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
                                                             if (!empty($discount_array)) {
                                                                $tuition_fee = $row['tuition_fee'];
                                                        ?>
                                                                <tr>
                                                                <td>Discounts: </td>
                                                                <td></td>
                                                                </tr>
                                                        <?php
                                                        foreach ($discount_array as $discounts_value) {

                                                            $select_discount = mysqli_query($acc, "SELECT * FROM tbl_discounts WHERE disc_id = $discounts_value");
                                                            while ($row10 = mysqli_fetch_array($select_discount)) {

                                                                if ($row10['percent'] == 1) {
                                                                    $percent_value = number_format(($row10['discount'] / 100) * $tuition_fee, 2);
                                                                    $tuition_fee = $tuition_fee - $percent_value;
        
                                                                } else {
                                                                    
                                                                    $tuition_fee = $tuition_fee - $row10['discount'];
        
                                                                }


                                                        ?>
                                                        <tr>
                                                        <td> &emsp;&emsp;<?php echo $row10['discount_desc'];?></td>

                                                        <?php
                                                            if ($row10['percent'] == '1') {
                                                        ?>

                                                        <td style="text-align: right;"><?php echo $row10['discount'];?>% (<?php echo $percent_value; ?>)</td>

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
                                                    </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                            
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <a href="list.assess.php" type="button" class="btn bg-green text-sm p-2 mb-md-2">
                                                <i class="fa fa-check"></i>
                                                Finish
                                            </a>
                                            <a href="edit.assessment.php<?php echo '?stud_no=' . $stud_no; ?>" type="button" class="btn bg-lightblue text-sm p-2 mb-md-2">
                                                <i class="fa fa-edit"></i>
                                                Edit Assessment
                                            </a>
                                            <a href="userData/ctrl.delAssessment.php<?php echo '?stud_no=' . $stud_no; ?>" type="button" class="btn bg-red text-sm p-2 mb-md-2">
                                                <i class="fa fa-trash"></i>
                                                Delete
                                            </a>
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