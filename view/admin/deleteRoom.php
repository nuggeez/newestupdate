<?php
include("../../dB/config.php");

if (isset($_GET['id'])) {
    $room_id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Validate and sanitize input as an integer
    
    if ($room_id) {
        $query = "DELETE FROM rooms WHERE room_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $room_id);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Room deleted successfully!";
            } else {
                $_SESSION['error'] = "Error deleting room!";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error'] = "Error preparing query!";
        }
    } else {
        $_SESSION['error'] = "Invalid room ID!";
    }
} else {
    $_SESSION['error'] = "Invalid request!";
}

header("Location: roomManage.php");
exit();
?>
