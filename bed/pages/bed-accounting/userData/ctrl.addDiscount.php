<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);

    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $discount_desc = mysqli_real_escape_string($conn, $_POST['discount_desc']);
    $ay_id = mysqli_real_escape_string($conn, $_POST['ay']);
    $percent = mysqli_real_escape_string($conn, $_POST['percent']);
    $discount_status = mysqli_real_escape_string($conn, $_POST['discount_status']);
    $updated_by = $row['fullname'] .' - '. $_SESSION['role'];




        $check_discount = mysqli_query($acc, "SELECT * FROM tbl_discounts WHERE ay_id = '$ay_id' AND discount = '$discount' AND discount_desc = '$discount_desc' AND percent = '$percent' AND discount_status = '$discount_status'") or die(mysqli_error($acc));

        $result = mysqli_num_rows($check_discount);

        if ($result > 0) {
            $_SESSION['tf_existing'] = true;
            header('location: ../add.discount.php');

        } else {
            $insert_discount = mysqli_query($acc, "INSERT INTO tbl_discounts (ay_id ,discount, discount_desc, percent, discount_status, created_at, last_updated, updated_by) VALUES ('$ay_id', '$discount', '$discount_desc', '$percent', '$discount_status', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$updated_by')") or die(mysqli_error($acc));
            $_SESSION['success'] = true;
            header('location: ../add.discount.php');

        }



        
}