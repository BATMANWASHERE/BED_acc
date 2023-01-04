<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';
session_start();
ob_start();


require '../../includes/bed-session.php';

$disc_id = $_GET['disc_id'];
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
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Discount
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <?php 
                                    $get_discountInfo = mysqli_query($acc, "SELECT * FROM tbl_discounts WHERE disc_id = '$disc_id'");

                                    while ($row = mysqli_fetch_array($get_discountInfo)) {?>

                                    <form action="userData/ctrl.editDiscount.php<?php echo '?disc_id=' . $disc_id; ?>" method="POST">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-10 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Discount Description</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount_desc" id="discount_desc" placeholder="Discount Description" value="<?php echo $row['discount_desc']; ?>">

                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-sm"><b>
                                                                Academic Year</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Year" name="ay">
                                                        <?php
                                                        $query_diffdb = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE ay_id = '$row[ay_id]'");
                                                        while($row3 = mysqli_fetch_array($query_diffdb)) {
                                                            echo '<option selected value="'.$row3['ay_id'].'">'.$row3['academic_year'].'</option>';
                                                        }
                                                        $query2 = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE NOT ay_id = '$row[ay_id]'");
                                                            while($row2 = mysqli_fetch_array($query2)) {
                                                                echo '<option value="'.$row2['ay_id'].'">'.$row2['academic_year'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="input-group col-md-6 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Discount</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount Value" value="<?php echo $row['discount']; ?>">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <?php
                                                                if ($row['percent'] == 1) {
                                                            ?>
                                                            <input type="checkbox" name="percent" value="1" aria-label="Checkbox for following text input" checked>
                                                            <?php
                                                                } else {
                                                            ?>
                                                            <input type="checkbox" name="percent" value="1" aria-label="Checkbox for following text input">
                                                            <?php
                                                                }
                                                            ?>
                                                            <span class="text-sm" style="margin-left: 5px;"><b>  percent</b></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="form-group col-md-10 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1" name="discount_status" <?php echo ($row['discount_status']== 1 ? 'checked' : '');?>>
                                                        <label class="form-check-label">Reflect only in form</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn bg-purple"><i
                                                    class="fas fa-calendar-check m-1"> </i> Edit Discount</button>
                                        </div>
                                    </form>
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