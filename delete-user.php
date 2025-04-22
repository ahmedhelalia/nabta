<?php
include 'config/init.php';
if (isset($_GET['id'])) {
    $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $currentUserId = $_SESSION['USER']['user_id'];
    if ($user_id === $currentUserId) {
        $_SESSION['delete_user_error'] = "متعملش كده تاني";
        header('location:' . ROOT . "/manage-users.php");
        die();
    }
    $users_query = "SELECT * FROM `users` WHERE `id` = '$user_id'";
    $users_query_result = mysqli_query($conn, $users_query);
    $user_data = mysqli_fetch_assoc($users_query_result);
    if ($user_data) {
        // Unlink User Avatar
        $user_avatar = $user_data['user_avatar'];
        $user_avatar_path = "assets/images/" . $user_avatar;
        if ($user_avatar_path) {
            unlink($user_avatar_path);
            $sql = "DELETE FROM `users` WHERE `id` = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $_SESSION['user_deleted']  = " تم حذف المستخدم بنجاح";
            if ($result) {
                header('location:' . ROOT . '/manage-users.php');
                die();
            }
        }
    }
} else {
    header('location:' . ROOT . '/index.php');
    die();
}
