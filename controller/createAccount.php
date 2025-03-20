<?php
include("../dB/config.php");
session_start();

if(isset($_POST['register'])){
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password']; 
$cpassword = $_POST['cpassword'];
$phoneNumber = $_POST['phoneNumber'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];

//check if password and confirm password match
if($password != $cpassword) {
    $_SESSION['status'] = "Password do not match!";
    $_SESSION['status_code'] = "error";
    header('Location: ../registration.php');
    exit(0);
}

//check if email address is already exists
$checkQuery = "SELECT * FROM `users` WHERE `email`= '$email'";
$result = mysqli_query($conn, $checkQuery);

if(mysqli_num_rows($result) > 0) {
    $_SESSION['status'] = "Email address is already taken!";
    $_SESSION['status_code'] = "error";
}

//insert into database
$query="INSERT INTO `users`(`firstName`, `lastName`, `email`, `password`, `phoneNumber`, `gender`, `birthday`)
VALUES ('$firstName','$lastName','$email','$password','$phoneNumber','$gender','$birthday')";

if(mysqli_query($conn, $query)){
    $_SESSION['message'] = "Account successfully created!";
    $_SESSION['code'] = "success";
    header('Location: ../login.php');
    exit(0);
}
else{
    echo "Error:" .mysqli_error($conn);
}
}
?>
