<?php
require 'inc/header.php';
if (!isset($_SESSION['USER']) || !$isAdmin) {
    header('location: ' . ROOT . '/index.php');
    exit;
}

if (isset($_GET['id'])) {
    $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $currentUserId = $_SESSION['USER']['user_id'];

    // Prevent admin from blocking themselves
    if ($user_id === $currentUserId) {
        $_SESSION['block_error'] = "لا يمكنك حظر نفسك";
        header('location: ' . ROOT . '/manage-users.php');
        exit;
    }

    // Get current block status
    $check_query = "SELECT blocked FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    // Toggle block status
    $new_status = $user['blocked'] ? '0' : '1';
    //show($new_status);
    $update_query = "UPDATE users SET blocked = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['block_success'] = $new_status ? "تم حظر المستخدم بنجاح" : "تم إلغاء حظر المستخدم بنجاح";
    } else {
        $_SESSION['block_error'] = "حدث خطأ أثناء تحديث حالة الحظر";
    }
}

header('location: ' . 'manage-users.php');
exit;