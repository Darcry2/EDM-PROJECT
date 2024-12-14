<?php
include_once '../models/RegisterModel.php';

class LoginController {
    private $registerModel;

    public function __construct() {
        $this->registerModel = new RegisterModel();
    }

    // Function to handle login
    public function login($email, $password) {
        // Hash password using md5
        $hashedPassword = md5($password);

        // Verify email and password
        $user = $this->registerModel->getUserByEmail($email);
        
        if ($user && $user['password'] === $hashedPassword) {
            return "Login successful!";
        } else {
            return "Invalid email or password!";
        }
    }
}
?>
