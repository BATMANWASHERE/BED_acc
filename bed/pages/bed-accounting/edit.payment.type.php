<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';
session_start();
ob_start();

$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];


require '../../includes/bed-session.php';
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Change Payment Type | SFAC Bacoor</title>
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
                    <a href="#" class="nav-link disabled text-light">Change Payment Type</a>
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
                                    <div class="card-header">
                                        <h3 class="card-title">Payment Type
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <form action="" method="POST">
                                        <div class="card-body">
                                            <?php
                                            $total_paid = 0;
                                            $total_unpaid = 0;

                                            $select_user = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE payment = 'trimestral' AND tbl_assessed_tf.ay_id = '$ay_id'"); //nag pass na sa due

                                            $date_array = [];

                                            if (mysqli_num_rows($select_user) != 0) {

                                            while ($row = mysqli_fetch_array($select_user)) {

                                                $date_array[] = ($row['date_tri_1']);
                                                $date_array[] = ($row['date_tri_2']);

                                                $current_date = new DateTime(date('d-m-Y'));

                                                foreach  ($date_array as $date_value) {
                                                    $date = new DateTime($date_value);
                                                    $date_z = date_format($date,'z');
                                                    $current_z = date_format($current_date,'z');
                                                
                                                    if ($current_z <= $date) {

                                                        $select_unpaid = mysqli_query($acc, "SELECT * FROM tbl_payments_status WHERE stud_id ='$row[stud_id]' AND payment_date = '$date_value'");
                                                        if (mysqli_num_rows($select_unpaid) != 0) {
                                                            $total_paid++;
                                                        } else {
                                                            $total_unpaid++;
                                                        }
                                                        break;
                                                    } else {
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <p>Trimestral Basis</p>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Paid Students</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_desc" id="discount_desc" value="<?php echo $total_paid?> students" disabled>

                                                </div>
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Unpaid Students</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_desc" id="discount_desc" value="<?php echo $total_unpaid?> students" disabled>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-4 mb-2">
                                                    <?php
                                                        if (($current_z - $date_z) >= 1 && $total_unpaid != 0) {
                                                    ?>
                                                    <p><small>Unpaid since <b><?php echo $current_z - $date_z;?> days</b> after due date.</small></p>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <a class="btn bg-navy"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Change remaining unpaid students' payment type to Quarterly" href="userData/ctrl.editPayment.type.php?action=change_type" disabled>
                                                        <i class="fas fa-cog"></i> Change Payment Type</a>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <a class="btn bg-navy"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Set remaining unpaid student's fees as unsettled fees" href="userData/ctrl.editPayment.type.php?action=trimestral_unsettled" disabled>
                                                        <i class="fas fa-cog"></i> Set as Unpaid for <?php echo $_SESSION['active_acadyears']?></a>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            }
                                            $total_paid = 0;
                                            $total_unpaid = 0;

                                            $select_user = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE payment = 'quarterly' AND tbl_assessed_tf.ay_id = '$ay_id'"); //nag pass na sa due

                                            $date_array = [];

                                            if (mysqli_num_rows($select_user) != 0) {

                                            while ($row = mysqli_fetch_array($select_user)) {

                                                $date_array[] = ($row['date_quar_1']);
                                                $date_array[] = ($row['date_quar_2']);
                                                $date_array[] = ($row['date_quar_3']);
                                                $date_array[] = ($row['date_quar_4']);

                                                $current_date = new DateTime(date('d-m-Y'));

                                                foreach  ($date_array as $date_value) {
                                                    $date = new DateTime($date_value);
                                                    $date_z = date_format($date,'z');
                                                    $current_z = date_format($current_date,'z');
                                                
                                                    if ($current_z <= $date) {

                                                        $select_unpaid = mysqli_query($acc, "SELECT * FROM tbl_payments_status WHERE stud_id ='$row[stud_id]' AND payment_date = '$date_value'");
                                                        if (mysqli_num_rows($select_unpaid) != 0) {
                                                            $total_paid++;
                                                        } else {
                                                            $total_unpaid++;
                                                        }
                                                        break;
                                                    } else {
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <p>Quarterly Basis</p>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Paid Students</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_desc" id="discount_desc" value="<?php echo $total_paid?> students" disabled>

                                                </div>
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Unpaid Students</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_desc" id="discount_desc" value="<?php echo $total_unpaid?> students" disabled>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-4 mb-2">
                                                    <?php
                                                        if (($current_z - $date_z) >= 1 && $total_unpaid != 0) {
                                                    ?>
                                                    <p><small>Unpaid since <b><?php echo $current_z - $date_z;?> days</b> after due date.</small></p>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <a class="btn bg-navy"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Set remaining unpaid student's fees as unsettled fees" href="userData/ctrl.editPayment.type.php?action=quarterly_unsettled" disabled>
                                                        <i class="fas fa-cog"></i> Set as Unpaid for <?php echo $_SESSION['active_acadyears']?></a>
                                                </div>
                                            </div>
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
                                    </form>
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