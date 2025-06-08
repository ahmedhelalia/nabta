<?php
require 'inc/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify user is logged in
    if (!isset($_SESSION['USER'])) {
        $_SESSION['error_message'] = "يجب تسجيل الدخول لحجز استشارة";
        header('location: login.php');
        exit;
    }

    $user_id = $_SESSION['USER']['user_id'];
    $expert_id = filter_var($_POST['expert_id'], FILTER_SANITIZE_NUMBER_INT);
    $consultation_type = filter_var($_POST['consultation_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Insert consultation into database
    $query = "INSERT INTO consultations (user_id, expert_id, consultation_type, message,phone, status) 
              VALUES (?, ?, ?,?, ?, 'pending')";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iisss", $user_id, $expert_id, $consultation_type, $message,$phone);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "تم إرسال طلب الاستشارة بنجاح";
        header('location: view-expert.php?id=' . $expert_id);
        exit;
    } else {
        $_SESSION['error_message'] = "حدث خطأ أثناء إرسال الطلب";
        header('location: view-expert.php?id=' . $expert_id);
        exit;
    }
}