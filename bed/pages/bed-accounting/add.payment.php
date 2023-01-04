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

require '../../includes/bed-session.php';
$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];

$stud_id = $_GET['stud_id'];
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Add Payment | SFAC Bacoor</title>
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
                    <a href="#" class="nav-link disabled text-light">Add Payment</a>
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
                                        LEFT JOIN tbl_strands ON tbl_schoolyears.strand_id = tbl_strands.strand_id 
                                        LEFT JOIN tbl_grade_levels ON  tbl_schoolyears.grade_level_id = tbl_grade_levels.grade_level_id
                                        WHERE tbl_students.student_id = '$stud_id' AND ay_id = '$ay_id'") or die(mysqli_error($conn));

                                        while ($row3 = mysqli_fetch_array($get_studentInfo)) {
                                            $grade_ident = $row3['grade_level_id'];
                                            $stud_id = $row3['student_id'];
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title">Add Payment Status for <b><?php echo $row3['fullname'];?></b>
                                        </h3>
                                    </div>
                                    
                                    <!-- /.card-header -->

                                    <!-- form start -->
                                    <?php
                                        $get_tuitionInfo = mysqli_query($acc, "SELECT *, tbl_assessed_tf.last_updated, tbl_assessed_tf.created_at, tbl_assessed_tf.updated_by FROM tbl_assessed_tf
                                        LEFT JOIN tbl_tuition_fee ON tbl_assessed_tf.tf_id = tbl_tuition_fee.tf_id
                                        WHERE stud_id = '$stud_id' AND tbl_assessed_tf.ay_id = '$ay_id'") or die(mysqli_error($acc));

                                        while ($row = mysqli_fetch_array($get_tuitionInfo)) {

                                            $assessed_id = $row['assessed_id'];

                                            $date_array = [];
                                            $payment_array = [];

                                            if ($row['payment'] == 'trimestral') {
                                                $payment_array[] = number_format($row['first_tri'], 2);
                                                $payment_array[] = number_format($row['second_tri'], 2);

                                                $get_installment_dates = mysqli_query($acc, "SELECT * FROM tbl_installment_dates WHERE ay_id = '$ay_id'");
                                                while($row4 = mysqli_fetch_array($get_installment_dates)) {
                                                    $date_array[] = ($row4['first_semester']);
                                                    $date_array[] = ($row4['second_semester']);
                                                }

                                            } elseif ($row['payment'] == 'quarterly') {
                                                $payment_array[] = number_format($row['first_quar'], 2);
                                                $payment_array[] = number_format($row['second_quar'], 2);
                                                $payment_array[] = number_format($row['third_quar'], 2);
                                                $payment_array[] = number_format($row['fourth_quar'], 2);

                                                $get_installment_dates = mysqli_query($acc, "SELECT * FROM tbl_installment_dates WHERE ay_id = '$ay_id'") or die(mysqli_error($acc));
                                                while($row4 = mysqli_fetch_array($get_installment_dates)) {
                                                    $date_array[] = ($row4['first_quarter']);
                                                    $date_array[] = ($row4['second_quarter']);
                                                    $date_array[] = ($row4['third_quarter']);
                                                    $date_array[] = ($row4['fourth_quarter']);
                                                }

                                            }
                                    ?>
                                    
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mt-3 mb-2">
                                                    <p><b>Grade:</b> <?php echo ($row3['grade_level_id'] == 15 || 14 ? $row3['grade_level'] .' - '. $row3['strand_name'] : $row3['grade_level'])?></p>
                                                </div>
                                                <div class="col-md-4 mt-3 mb-2">
                                                    <p><b>Payment Type:</b> <?php echo ucfirst($row['payment']);?></p>
                                                </div>
                                            </div>
                                            <?php
                                                $i = 0;
                                                foreach ($payment_array as $payment) {
                                                    $date = new DateTime($date_array[$i]);

                                                    $paymentCheck = mysqli_query($acc,"SELECT * FROM tbl_payments_status
                                                    LEFT JOIN tbl_assessed_tf ON tbl_assessed_tf.assessed_id = tbl_payments_status.assessed_id
                                                    WHERE tbl_payments_status.stud_id = '$stud_id' and payment_value = '$payment' and payment_date = '$date_array[$i]' AND ay_id = '$ay_id'") or die (mysqli_error($acc));

                                                    $paymentCheck1 = mysqli_query($acc,"SELECT * FROM tbl_payments_status
                                                    LEFT JOIN tbl_assessed_tf ON tbl_assessed_tf.assessed_id = tbl_payments_status.assessed_id
                                                    WHERE tbl_payments_status.stud_id = '$stud_id' and tbl_payments_status.status = 'Paid' and payment_date = '$date_array[$i]' AND ay_id = '$ay_id'") or die (mysqli_error($acc));
                                                    
                                                    

                                                    if (mysqli_num_rows($paymentCheck) == 0 || mysqli_num_rows($paymentCheck1) == 0) {

                                            ?>
                                            <form action="userData/ctrl.addPayment.php?stud_id=<?php echo $stud_id?>&assessed_id=<?php echo $assessed_id;?>&payment=<?php echo $row['payment']?>" method="POST">
                                            <div class="row ">
                                                <input type="hidden" name="index" value="<?php echo $i;?>">
                                                <div class="input-group col-md-5 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Payment</span>
                                                    </div>
                                                    <input type="text" class="form-control" disabled value = "<?php echo $payment;?>">
                                                    <input type="hidden" name="payment_value" value="<?php echo $payment;?>">

                                                </div>
                                                <div class="input-group col-md-5 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Payment</span>
                                                    </div>
                                                    <input type="text" class="form-control" disabled value = "<?php echo $date->format('F d, Y'); ?>">
                                                    <input type="hidden"  name="payment_date" value="<?php echo $date_array[$i];?>">

                                                </div>
                                                <div class="input-group col-md-2 mb-2 justify-content-center">
                                                    <button type="submit" name="submit" class="btn bg-success"><i
                                                    class="fas fa-check"></i> Paid</button> 
                                                </div>
                                            </div>
                                            </form>
                                            <?php
                                            
                                                    } else {}
                                                    $i++;
                                                }
                                            ?>
                                            
                                            <?php
                                                $paymentCheck = mysqli_query($acc,"SELECT * FROM tbl_payments_status
                                                LEFT JOIN tbl_assessed_tf ON tbl_assessed_tf.assessed_id = tbl_payments_status.assessed_id
                                                WHERE tbl_payments_status.stud_id = '$stud_id' AND ay_id = '$ay_id'");

                                                if (mysqli_num_rows($paymentCheck) != 0) {
                                            ?>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 mt-3 mb-2">
                                                    <p><b>Paid Installments</b></p>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                                while ($row2 = mysqli_fetch_array($paymentCheck)) {
                                                    $date_payment = new DateTime($row2['created_at']);
                                                    $date = new DateTime($row2['payment_date']);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-4 mb-1">
                                                    <p><b>Payment Type:</b> <?php echo ucfirst($row2['payment_type']);?></p>
                                                </div>
                                                <div class="col-md-4 mb-1">
                                                    <p><b>Date of Payment:</b> <?php echo $date_payment->format('F d, Y'); ?></p>
                                                </div>
                                            </div>
                                            <form action="userData/ctrl.addPayment.php?stud_id=<?php echo $stud_id?>&assessed_id=<?php echo $assessed_id;?>" method="POST">
                                            <div class="row ">
                                                <input type="hidden" name="index" value="<?php echo $i;?>">
                                                <div class="input-group col-md-5 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Payment</span>
                                                    </div>
                                                    <input type="text" class="form-control" disabled value = "<?php echo $row2['payment_value'];?>">

                                                </div>
                                                <div class="input-group col-md-5 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Payment</span>
                                                    </div>
                                                    <input type="text" class="form-control" disabled value = "<?php echo $date->format('F d, Y'); ?>">

                                                </div>
                                                <div class="input-group col-md-2 mb-2 justify-content-center">
                                                    <button type="submit" name="submit" class="btn bg-success disabled" disabled><i
                                                    class="fas fa-check"></i> Paid</button> 
                                                </div>
                                            </div>
                                            </form>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <a href="assessment.fee.<?php echo $row['payment']?>.php?stud_id=<?php echo $stud_id?>" type="button" class="btn bg-purple text-sm p-2 mb-md-2">
                                                <i class="fa fa-check"></i>
                                                Finish
                                            </a>
                                        </div>
                                    
                                    <?php
                                        }
                                        }
                                    ?>
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