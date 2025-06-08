<?php
require_once 'inc/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_expert === 'expert') {
    $consultation_id = filter_var($_POST['consultation_id'], FILTER_SANITIZE_NUMBER_INT);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $payment_status = filter_var($_POST['payment_status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $expert_id = $_SESSION['USER']['user_id'];

    // Validate status values
    $allowed_statuses = ['pending', 'approved', 'completed', 'cancelled'];
    $allowed_payment_statuses = ['payment_pending', 'payment_paid', 'payment_cancelled'];

    if (!in_array($status, $allowed_statuses) || !in_array($payment_status, $allowed_payment_statuses)) {
        $_SESSION['consultation-error_message'] = "قيمة غير صالحة للحالة";
        header('location: view-consultation.php?id=' . $consultation_id);
        exit;
    }

    // Verify consultation belongs to this expert
    $verify_query = "SELECT id FROM consultations 
                    WHERE id = ? AND expert_id = ?";

    $stmt = mysqli_prepare($conn, $verify_query);
    mysqli_stmt_bind_param($stmt, "ii", $consultation_id, $expert_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        $_SESSION['error_message'] = "غير مصرح لك بتحديث هذه الاستشارة";
        header('location: expert-consultations.php');
        exit;
    }

    // Update consultation status
    $update_query = "UPDATE consultations 
                    SET status = ?, 
                        payment_status = ?,
                        updated_at = CURRENT_TIMESTAMP 
                    WHERE id = ? AND expert_id = ?";

    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "ssii", $status, $payment_status, $consultation_id, $expert_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['consultation-success_message'] = "تم تحديث حالة الاستشارة بنجاح";
        header('location: view-consultation.php?id=' . $consultation_id);
        exit;
    } else {
        $_SESSION['consultation-error_message'] = "حدث خطأ أثناء تحديث حالة الاستشارة";
        header('location: view-consultation.php?id=' . $consultation_id);
        exit;
    }
} else {
    header('location: ' . ROOT . '/index.php');
    exit;
}
