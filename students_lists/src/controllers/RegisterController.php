<?php
include_once '../models/RegisterModel.php';
include_once '../../backup/api/DatabaseBackup.php'; // Include the DatabaseBackup class

class RegisterController {
    private $registerModel;

    public function __construct() {
        $this->registerModel = new RegisterModel();
    }

    // Function to handle registration
    public function register($email, $password, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender) {
        // Backup the database before registration
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        // Check if the email already exists
        if ($this->registerModel->emailExists($email)) {
            return "Email already exists!";
        }

        // Hash password using md5
        $hashedPassword = md5($password);

        // Save the user information to the database
        $result = $this->registerModel->registerUser($email, $hashedPassword, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender);
        return $result ? "Registration successful!" : "Registration failed!";
    }
}
?>
