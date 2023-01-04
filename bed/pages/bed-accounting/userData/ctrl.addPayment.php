<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();


if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);

    $assessed_id = $_GET['assessed_id'];
    $stud_id = $_GET['stud_id'];
    $payment = $_GET['payment'];

    $payment_date = mysqli_real_escape_string($acc, $_POST['payment_date']);
    $payment_value = mysqli_real_escape_string($acc, $_POST['payment_value']);
    $updated_by = $row['fullname'] .' - '. $_SESSION['role'];

    $addPayment = mysqli_query($acc,"INSERT INTO tbl_payments_status (stud_id, assessed_id, payment_type, payment_date, payment_value, status, created_at, last_updated, updated_by) VALUES ('$stud_id', '$assessed_id', '$payment', '$payment_date', '$payment_value', 'Paid', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$updated_by')") or die (mysqli_error($acc));

    header('location: ../add.payment.php?stud_id='.$stud_id);


}