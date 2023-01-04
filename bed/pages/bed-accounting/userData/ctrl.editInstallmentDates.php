<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();
$installment_id = $_GET['installment_id'];
if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);

    $ay_id = mysqli_real_escape_string($acc, $_POST['ay_id']);
    $first_semester = mysqli_real_escape_string($acc, $_POST['first_semester']);
    $second_semester = mysqli_real_escape_string($acc, $_POST['second_semester']);

    $first_quarter = mysqli_real_escape_string($acc, $_POST['first_quarter']);
    $second_quarter = mysqli_real_escape_string($acc, $_POST['second_quarter']);
    $third_quarter = mysqli_real_escape_string($acc, $_POST['third_quarter']);
    $fourth_quarter = mysqli_real_escape_string($acc, $_POST['fourth_quarter']);




        $check_discount = mysqli_query($acc, "SELECT * FROM tbl_installment_dates WHERE ay_id = '$ay_id' AND first_semester = '$first_semester' AND second_semester = '$second_semester' AND first_quarter = '$first_quarter' AND second_quarter = '$second_quarter'  AND third_quarter = '$third_quarter'  AND fourth_quarter = '$fourth_quarter'") or die(mysqli_error($acc));

        $result = mysqli_num_rows($check_discount);

        if ($result > 0) {
            $_SESSION['tf_existing'] = true;
            header('location: ../edit.installment.dates.php?installment_id='. $installment_id);

        } else {
            $insert_discount = mysqli_query($acc, "UPDATE tbl_installment_dates SET ay_id = '$ay_id',  first_semester = '$first_semester', second_semester = '$second_semester', first_quarter = '$first_quarter', second_quarter = '$second_quarter', third_quarter = '$third_quarter', fourth_quarter = '$fourth_quarter' WHERE installment_id = '$installment_id'") or die(mysqli_error($acc));
            $_SESSION['success'] = true;
            header('location: ../edit.installment.dates.php?installment_id='. $installment_id);

        }



        
}