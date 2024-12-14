<?php
include_once __DIR__ . '/../models/StudentModel.php';
include_once '../../backup/api/DatabaseBackup.php'; // Include the DatabaseBackup class

class StudentController {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new StudentModel();
    }

    // Add a new student
    public function addStudent($first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status) {
        // Backup the database before adding the student
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->studentModel->addStudent($first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status);
    }

    // Fetch all students
    public function getAllStudents() {
        return $this->studentModel->getStudents();
    }

    // Update an existing student
    public function updateStudent($id, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status) {
        // Backup the database before updating the student
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->studentModel->updateStudent($id, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status);
    }

    // Delete a student
    public function deleteStudent($id) {
        // Backup the database before deleting the student
        $backupResult = DatabaseBackup::backup('localhost', 'root', '', 'student_lists', '../../backup/database');
        echo $backupResult;  // Display backup result

        return $this->studentModel->deleteStudent($id);
    }
}
?>
