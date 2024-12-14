<?php
class StudentModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=student_lists;charset=utf8mb4', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fetch all students (not deleted)
    public function getStudents() {
        $sql = "SELECT * FROM students WHERE is_delete = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new student
    public function addStudent($first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO students (first_name, middle_name, last_name, degree, year, section, gender, payment_status, attendance_status)
                                         VALUES (:first_name, :middle_name, :last_name, :degree, :year, :section, :gender, :payment_status, :attendance_status)");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':middle_name', $middle_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':degree', $degree);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':section', $section);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':payment_status', $payment_status);
            $stmt->bindParam(':attendance_status', $attendance_status);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Update an existing student
    public function updateStudent($id, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender, $payment_status, $attendance_status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE students SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, degree = :degree, 
                                         year = :year, section = :section, gender = :gender, payment_status = :payment_status, attendance_status = :attendance_status 
                                         WHERE id = :id AND is_delete = 0");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':middle_name', $middle_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':degree', $degree);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':section', $section);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':payment_status', $payment_status);
            $stmt->bindParam(':attendance_status', $attendance_status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Soft delete a student (set is_delete = 1)
    public function deleteStudent($id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE students SET is_delete = 1 WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
