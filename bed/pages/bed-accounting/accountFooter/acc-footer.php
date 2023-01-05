<?php
 if (isset($_SESSION['tf_existing'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Tuition Fee is already existing.'
    });
});
</script>";
} elseif (isset($_SESSION['assessment_existing'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Assessment is already existing.'
    });
});
</script>";
} elseif (isset($_SESSION['no_enrolled_stud'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Error student ID number.'
    });
});
</script>";
} elseif (isset($_SESSION['no_payment_type'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'There is no payment type selected.'
    });
});
</script>";
} elseif (isset($_SESSION['payment_existing'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Payment already exists.'
    });
});
</script>";
} elseif (isset($_SESSION['no_tuition_fee'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'No tuition fee for grade level exists.'
    });
});
</script>";
} elseif (isset($_SESSION['discount_existing'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Discount is already existing.'
    });
});
</script>";
} elseif (isset($_SESSION['installment_existing'])) {
    echo "<script>
$(function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
    $('.swalDefaultError')
    Toast.fire({
        icon: 'error',
        title:  'Installment Dates is already existing.'
    });
});
</script>";
}

unset($_SESSION['tf_existing']);
unset($_SESSION['assessment_existing']);
unset($_SESSION['no_enrolled_stud']);
unset($_SESSION['no_payment_type']);
unset($_SESSION['payment_existing']);
unset($_SESSION['no_tuition_fee']);
unset($_SESSION['discount_existing']);
unset($_SESSION['installment_existing']);
?>