<?php
include_once __DIR__ . '/../models/ProfileModel.php';
include_once '../../backup/api/DatabaseBackup.php';  // Include the DatabaseBackup class

class ProfileController {
    private $profileModel;

    public function __construct() {
        $this->profileModel = new ProfileModel();
    }

    // Function to fetch user profile based on the email
    public function getProfile($email) {
        return $this->profileModel->getUserProfile($email);
    }

    // Function to update user profile (name, degree, etc.)
    public function updateProfile($email, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender) {
        // Backup the database before updating the profile
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->profileModel->updateUserProfile($email, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender);
    }

    // Function to update user email
    public function updateEmail($currentEmail, $newEmail) {
        // Backup the database before updating the email
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->profileModel->updateUserEmail($currentEmail, $newEmail);
    }

    // Function to update user password
    public function updatePassword($email, $currentPassword, $newPassword) {
        // Backup the database before updating the password
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->profileModel->updateUserPassword($email, $currentPassword, $newPassword);
    }

    // Function to delete user profile
    public function deleteProfile($email) {
        // Backup the database before deleting the profile
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->profileModel->deleteUserProfile($email);
    }
}
?>
