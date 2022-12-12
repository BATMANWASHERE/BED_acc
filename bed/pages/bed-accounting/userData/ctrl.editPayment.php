<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$payment_id = $_GET['payment_id'];

if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);

    $payment = mysqli_real_escape_string($conn, $_POST['payment']);
    $ay_id = mysqli_real_escape_string($conn, $_POST['ay_id']);



        $check_payment = mysqli_query($acc, "SELECT * FROM tbl_payments WHERE ay_id = '$ay_id' AND payment = '$payment'") or die(mysqli_error($acc));

        $result = mysqli_num_rows($check_payment);

        if ($result > 0) {
            $_SESSION['payment_existing'] = true;
            header('location: ../edit.payment.php?payment_id=' . $payment_id);

        } else {
            $update_payment = mysqli_query($acc, "UPDATE tbl_payments SET ay_id = '$ay_id', payment = '$payment' WHERE payment_id = '$payment_id'") or die(mysqli_error($acc));
            $_SESSION['success'] = true;
            header('location: ../edit.payment.php?payment_id=' . $payment_id);

        }



        
}