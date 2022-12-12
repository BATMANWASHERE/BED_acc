<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];

$get_sem_id = mysqli_query($conn,"SELECT * FROM tbl_active_semesters");
$row_sem = mysqli_fetch_array($get_sem_id);
$sem_id = $row_sem['semester_id'];

if (isset($_POST['submit_search'])) {


        $stud_no = mysqli_real_escape_string($conn, $_POST['stud_no']);
 

        $check_search = mysqli_query($conn, "SELECT * FROM tbl_schoolyears LEFT JOIN tbl_students ON tbl_students.student_id = tbl_schoolyears.student_id WHERE stud_no = '$stud_no' limit 1") or die(mysqli_error($conn));
        $check_grade = mysqli_fetch_array($check_search);
        
        $result = mysqli_num_rows($check_search);

        if ($result > 0) {

            if ($check_grade['grade_level_id'] == 14 || $check_grade['grade_level_id'] == 15) {

            $check_assessments = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf WHERE stud_no = '$stud_no' and ay_id = '$ay_id' and sem_id = '$sem_id'") or die(mysqli_error($acc));

            $result1 = mysqli_num_rows($check_assessments);

            } else {
            $check_assessments = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf WHERE stud_no = '$stud_no' and ay_id = '$ay_id'") or die(mysqli_error($acc));

            $result1 = mysqli_num_rows($check_assessments);
            }

            if ($result1 > 0) {

                $_SESSION['assessment_existing'] = true;
                header('location: ../add.assess.php');

            } else {

                header('location: ../add.assessment.php?stud_no=' . $stud_no);

            }

        } else {
            
            $_SESSION['no_enrolled_stud'] = true;
            header('location: ../add.assess.php');

        }



        
}
