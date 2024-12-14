<?php
include_once '../controllers/RegisterController.php';

// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$degree = $_POST['degree'];
$year = $_POST['year'];
$section = $_POST['section'];
$gender = $_POST['gender'];

// Create the controller instance
$registerController = new RegisterController();

// Register the user
$result = $registerController->register($email, $password, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender);

// Check if the registration was successful
if ($result == "Registration successful!") {
    // Redirect to the login page after successful registration
    header('Location: ../../public/view/Login.php');
    exit();  // Make sure to exit after redirection to stop further script execution
} else {
    // If registration fails, show an error message
    echo $result;
}
?>
