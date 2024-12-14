<?php
include_once __DIR__ . '/../controllers/StudentController.php';

$studentController = new StudentController();

// Handle form submission for adding a student
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'id' is set to decide whether we are adding or updating a student
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update student
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $degree = $_POST['degree'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $gender = $_POST['gender'];
        $payment_status = $_POST['payment_status'];
        $attendance_status = $_POST['attendance_status'];

        $result = $studentController->updateStudent($id, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status);
        if ($result) {
            header("Location: ../../public/view/Dashboard.php");
            exit();
        } else {
            echo "Failed to update student!";
        }
    } else {
        // Add student
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $degree = $_POST['degree'];
        $year = $_POST['year'];
        $section = $_POST['section'];
        $gender = $_POST['gender'];
        $payment_status = $_POST['payment_status'];
        $attendance_status = $_POST['attendance_status'];

        $result = $studentController->addStudent($first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status);
        if ($result) {
            header("Location: ../../public/view/Dashboard.php");
            exit();
        } else {
            echo "Failed to add student!";
        }
    }
}

// Handle student deletion
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $result = $studentController->deleteStudent($id);
    if ($result) {
        header("Location: ../../public/view/Dashboard.php");
        exit();
    } else {
        echo "Failed to delete student!";
    }
}

// Fetch all students
$students = $studentController->getAllStudents();
?>
