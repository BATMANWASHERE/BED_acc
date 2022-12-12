<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$payment_id = $_GET['payment_id'];

mysqli_query($acc, "DELETE FROM tbl_payments WHERE payment_id = '$payment_id'");
$_SESSION['success-del'] = true;
header('location: ../list.payment.php');