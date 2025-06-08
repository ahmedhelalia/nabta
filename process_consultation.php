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
    $price = filter_var($_POST['consultation_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $duration = filter_var($_POST['consultation_duration'], FILTER_SANITIZE_NUMBER_INT);
    // Verify price with database
    $verify_query = "SELECT id FROM consultation_prices 
                    WHERE expert_id = ? 
                    AND consultation_type = ? 
                    AND price = ? 
                    AND duration = ? 
                    AND is_active = 1";

    $stmt = mysqli_prepare($conn, $verify_query);
    mysqli_stmt_bind_param($stmt, "isdi", $expert_id, $consultation_type, $price, $duration);
    mysqli_stmt_execute($stmt);
    $price_result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($price_result) === 0) {
        $_SESSION['error_message'] = "حدث خطأ في التحقق من السعر";
        header('location: view-expert.php?id=' . $expert_id);
        exit;
    }
    
    $price_record = mysqli_fetch_assoc($price_result);
    $price_id = $price_record['id'];
        // Insert consultation into database
    $query = "INSERT INTO consultations (
        user_id, 
        expert_id, 
        consultation_type, 
        message, 
        phone, 
        price_id,
        amount,
        payment_status,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, 'payment_pending', 'pending')";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param(
        $stmt, 
        "iisssis", 
        $user_id, 
        $expert_id, 
        $consultation_type, 
        $message, 
        $phone, 
        $price_id,
        $price
    );
    
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
