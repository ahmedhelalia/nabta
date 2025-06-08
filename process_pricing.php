<?php
require_once 'inc/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_expert === 'expert') {
    $expert_id = $_SESSION['USER']['user_id'];
    $prices = $_POST['prices'];
    $durations = $_POST['duration'];

    // Deactivate all current prices
    $deactivate_query = "UPDATE consultation_prices SET is_active = 0 WHERE expert_id = ?";
    $stmt = mysqli_prepare($conn, $deactivate_query);
    mysqli_stmt_bind_param($stmt, "i", $expert_id);
    mysqli_stmt_execute($stmt);

    // Insert new prices
    $insert_query = "INSERT INTO consultation_prices (expert_id, consultation_type, price, duration) 
                     VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);

    $success = true;
    foreach ($prices as $type => $price) {
        $duration = $durations[$type];
        mysqli_stmt_bind_param($stmt, "isdi", $expert_id, $type, $price, $duration);
        if (!mysqli_stmt_execute($stmt)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $_SESSION['price_message'] = "تم تحديث الأسعار بنجاح";
        $_SESSION['price_status'] = "success";
    } else {
        $_SESSION['price_message'] = "حدث خطأ أثناء تحديث الأسعار";
        $_SESSION['price_status'] = "error";
    }

    header('location: expert-prices.php');
    exit;
}

header('location: ' . ROOT . '/index.php');
exit;
