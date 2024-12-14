<?php
include_once '../../src/controllers/LoginController.php';

// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];

// Create the controller instance
$loginController = new LoginController();

// Login the user and get the result
$result = $loginController->login($email, $password);

// Check if the login was successful
if ($result == "Login successful!") {
    // Start a session and store the user session if needed
    session_start();
    $_SESSION['user_email'] = $email;  // Store the user's email in the session or other identifiers

    // Redirect to the dashboard after successful login
    header('Location: ../../public/view/Dashboard.php');
    exit();  // Make sure to exit after redirection to stop further script execution
} else {
    // If login fails, show an error message (optional)
    echo $result;
}
?>
