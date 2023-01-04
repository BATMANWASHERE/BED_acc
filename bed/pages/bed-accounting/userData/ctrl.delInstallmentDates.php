<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$installment_id = $_GET['installment_id'];

mysqli_query($acc, "DELETE FROM tbl_installment_dates WHERE installment_id = '$installment_id'");
$_SESSION['success-del'] = true;
header('location: ../list.installment.dates.php');