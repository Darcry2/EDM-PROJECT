<?php
include_once __DIR__ . '/../controllers/ProfileController.php';

// Start the session to access session variables
session_start();

// Ensure that the session email is available
if (isset($_SESSION['user_email'])) {
    // Fetch the email from the session
    $email = $_SESSION['user_email'];
} else {
    // If email is not in session, stop execution and show an error
    echo "User not logged in.";
    exit();  // Stop further execution if the user is not logged in
}

// Create ProfileController instance
$profileController = new ProfileController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // Update the profile (name, degree, etc.)
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $degree = $_POST['degree'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $gender = $_POST['gender'];

        // Pass the email along with the other profile data
        $result = $profileController->updateProfile($email, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender);

        if ($result) {
            header("Location: ../../public/view/Profile.php");
            echo "Profile updated successfully.";
        } else {
            echo "Failed to update profile.";
        }
    }

    if (isset($_POST['update_email'])) {
        // Update email
        $newEmail = $_POST['new_email'];

        $result = $profileController->updateEmail($email, $newEmail);
        if ($result) {
            // Update session email
            $_SESSION['user_email'] = $newEmail;
            header("Location: ../../public/view/Profile.php");
            echo "Email updated successfully.";
        } else {
            echo "Email already exists or invalid email.";
        }
    }

    if (isset($_POST['update_password'])) {
        // Update password
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $result = $profileController->updatePassword($email, $currentPassword, $newPassword);
        if ($result) {
            session_destroy();  // Log out the user after deletion            
            header("Location: ../../public/view/Login.php");
            echo "Password updated successfully.";
        } else {
            echo "Incorrect current password.";
        }
    }

    if (isset($_POST['delete'])) {
        // Soft delete the profile
        $result = $profileController->deleteProfile($email);
        if ($result) {
            session_destroy();  // Log out the user after deletion            
            header("Location: ../../public/view/Login.php");
            echo "Profile deleted successfully.";
        } else {
            echo "Failed to delete profile.";
        }
    }
}
?>
