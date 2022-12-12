<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$get_userID = $_GET['disc_id'];

mysqli_query($acc, "DELETE FROM tbl_discounts WHERE disc_id = '$get_userID'");
$_SESSION['success-del'] = true;
header('location: ../list.discount.php');