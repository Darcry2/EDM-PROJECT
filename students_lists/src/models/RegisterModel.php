<?php
class RegisterModel {
    private $pdo;

    public function __construct() {
        // Assuming you have a PDO connection already created as per the previous script
        $this->pdo = new PDO('mysql:host=localhost;dbname=student_lists;charset=utf8mb4', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Check if email already exists
    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_authentication WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Register a new user
    public function registerUser($email, $password, $first_name, $middle_name,$last_name, $degree, $year, $section, $gender) {
        try {
            // Insert into user_authentication table
            $stmt = $this->pdo->prepare("INSERT INTO user_authentication (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            
            // Get the last inserted user ID
            $user_auth_id = $this->pdo->lastInsertId();

            // Insert into user_information table
            $stmt2 = $this->pdo->prepare("INSERT INTO user_information (user_auth_id, first_name, middle_name ,last_name, degree, year, section, gender) VALUES (:user_auth_id, :first_name, :middle_name,:last_name, :degree, :year, :section, :gender)");
            $stmt2->bindParam(':user_auth_id', $user_auth_id);
            $stmt2->bindParam(':first_name', $first_name);
            $stmt2->bindParam(':middle_name', $middle_name);
            $stmt2->bindParam(':last_name', $last_name);
            $stmt2->bindParam(':degree', $degree);
            $stmt2->bindParam(':year', $year);
            $stmt2->bindParam(':section', $section);
            $stmt2->bindParam(':gender', $gender);
            $stmt2->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Get user by email
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_authentication WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
