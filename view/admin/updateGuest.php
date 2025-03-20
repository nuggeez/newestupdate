<?php
include("../../dB/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guest_id = intval($_POST['guest_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "UPDATE guests SET 
              name = '$name', 
              gender = '$gender', 
              phone_number = '$phone_number', 
              email = '$email' 
              WHERE guest_id = $guest_id";

    if (mysqli_query($conn, $query)) {
        header("Location: guestList.php?message=Guest updated successfully");
        exit();
    } else {
        header("Location: editGuest.php?id=$guest_id&error=Update failed");
        exit();
    }
} else {
    header("Location: guestList.php");
    exit();
}
?>
