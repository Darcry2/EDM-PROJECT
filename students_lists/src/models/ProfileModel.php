<?php
class ProfileModel {
    private $pdo;

    public function __construct() {
        // Assuming you have a PDO connection already created
        $this->pdo = new PDO('mysql:host=localhost;dbname=student_lists;charset=utf8mb4', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Get user profile by email
    public function getUserProfile($email) {
        $stmt = $this->pdo->prepare("SELECT ui.first_name, ui.middle_name, ui.last_name, ui.degree, ui.year, ui.section, ui.gender 
                                     FROM user_authentication ua 
                                     JOIN user_information ui ON ua.id = ui.user_auth_id 
                                     WHERE ua.email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user profile (first_name, middle_name, last_name, degree, year, section, gender)
    public function updateUserProfile($email, $first_name, $middle_name, $last_name, $degree, $year, $section, $gender) {
        try {
            // Update user_information table
            $stmt = $this->pdo->prepare("UPDATE user_information ui 
                                         JOIN user_authentication ua ON ua.id = ui.user_auth_id
                                         SET ui.first_name = :first_name, ui.middle_name = :middle_name, ui.last_name = :last_name, 
                                             ui.degree = :degree, ui.year = :year, ui.section = :section, ui.gender = :gender
                                         WHERE ua.email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':middle_name', $middle_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':degree', $degree);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':section', $section);
            $stmt->bindParam(':gender', $gender);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Update user email
    public function updateUserEmail($currentEmail, $newEmail) {
        // Check if the new email already exists
        $stmt = $this->pdo->prepare("SELECT * FROM user_authentication WHERE email = :newEmail");
        $stmt->bindParam(':newEmail', $newEmail);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return false;  // Email already exists
        }

        // Update email in the user_authentication table
        $stmt2 = $this->pdo->prepare("UPDATE user_authentication SET email = :newEmail WHERE email = :currentEmail");
        $stmt2->bindParam(':currentEmail', $currentEmail);
        $stmt2->bindParam(':newEmail', $newEmail);
        $stmt2->execute();
        
        return true;
    }

    // Update user password
    public function updateUserPassword($email, $currentPassword, $newPassword) {
        // Verify the current password
        $stmt = $this->pdo->prepare("SELECT password FROM user_authentication WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && md5($currentPassword) == $user['password']) {
            // Hash the new password
            $newPasswordHash = md5($newPassword);

            // Update password in the user_authentication table
            $stmt2 = $this->pdo->prepare("UPDATE user_authentication SET password = :newPassword WHERE email = :email");
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':newPassword', $newPasswordHash);
            $stmt2->execute();
            return true;
        }
        return false;  // Incorrect current password
    }

    // Delete user profile (both user_authentication and user_information)
    public function deleteUserProfile($email) {
        try {
            // Start transaction
            $this->pdo->beginTransaction();
    
            // Get the user id based on email
            $stmt = $this->pdo->prepare("SELECT id FROM user_authentication WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                $userId = $user['id'];
    
                // Soft delete from user_information table (set is_delete = 1)
                $stmt1 = $this->pdo->prepare("UPDATE user_information SET is_delete = 1 WHERE user_auth_id = :user_id");
                $stmt1->bindParam(':user_id', $userId);
                $stmt1->execute();
    
                // Soft delete from user_authentication table (set is_delete = 1)
                $stmt2 = $this->pdo->prepare("UPDATE user_authentication SET is_delete = 1 WHERE id = :user_id");
                $stmt2->bindParam(':user_id', $userId);
                $stmt2->execute();
    
                // Commit transaction
                $this->pdo->commit();
                return true;
            }
    
            return false;
        } catch (PDOException $e) {
            $this->pdo->rollBack();  // Rollback transaction if something goes wrong
            return false;
        }
    }    
}
?>
