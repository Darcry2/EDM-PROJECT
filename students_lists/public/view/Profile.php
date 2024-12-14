<?php
session_start();

// Ensure that the session email is available
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
} else {
    echo "User not logged in.";
    exit();  // Stop further execution if the user is not logged in
}

// Include necessary files
include_once '../../src/controllers/ProfileController.php';
include_once '../../src/models/ProfileModel.php';

// Create ProfileController instance
$profileController = new ProfileController();

// Fetch the current user profile data
$currentProfile = $profileController->getProfile($email);

// Check if we got the profile data
if ($currentProfile) {
    $first_name = $currentProfile['first_name'];
    $middle_name = $currentProfile['middle_name'];
    $last_name = $currentProfile['last_name'];
    $degree = $currentProfile['degree'];
    $year = $currentProfile['year'];
    $section = $currentProfile['section'];
    $gender = $currentProfile['gender'];
} else {
    echo "Profile not found.";
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: /path/to/login.php"); // Redirect to the login page after logout
    exit();
}

// Redirect to the dashboard logic
if (isset($_POST['dashboard'])) {
    header("Location: /path/to/dashboard.php"); // Redirect to the dashboard page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Background Gradient */
        body {
            background-color: #ecf0f1;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Card Styling */
        .profile-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .profile-card h3 {
            font-size: 1.8rem;
            color: #333;
        }

        .form-control, .form-select {
            border-radius: 8px;
            box-shadow: none;
        }

        .btn-custom {
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-logout {
            background-color: #f44336;
            color: #fff;
        }

        .btn-dashboard {
            background-color: #2196F3;
            color: #fff;
        }

        .btn-update-profile {
            background-color: #4CAF50;
            color: #fff;
        }

        .btn-update-email {
            background-color: #ff9800;
            color: #fff;
        }

        .btn-change-password {
            background-color: #f44336;
            color: #fff;
        }

        .btn-delete-profile {
            background-color: #e91e63;
            color: #fff;
        }

        h2 {
            font-size: 2.5rem;
            color: #fff;
        }

        /* Button Hover Effects */
        .btn-custom:hover {
            opacity: 0.9;
        }

        /* Form spacing */
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <h2 class="text-center mb-5">Your Profile</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="text-center">
                        <img src="../images/avatar.png" heigh="150" width="150" alt="Profile Picture" class="rounded-circle mb-3">
                        <h3><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h3>
                        <p class="text-muted"><?php echo htmlspecialchars($degree . ' - ' . $year . ' ' . $section); ?></p>
                    </div>
                    
                    <!-- Logout Button -->
                        <a href="Logout.php"><button class="btn btn-custom btn-logout">Logout</button></a>
                    <!-- Dashboard Button -->
                        <a href="Dashboard.php"><button class="btn btn-custom btn-dashboard">Go to Dashboard</button></a>

                </div>

                <!-- Update Profile Form -->
                <div class="profile-card">
                    <form action="../../src/routes/ProfileRoute.php" method="POST">
                        <h3>Update Profile</h3>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="<?php echo htmlspecialchars($middle_name); ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="degree">Degree</label>
                            <input type="text" name="degree" class="form-control" value="<?php echo htmlspecialchars($degree); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" name="year" class="form-control" value="<?php echo htmlspecialchars($year); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" name="section" class="form-control" value="<?php echo htmlspecialchars($section); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="male" <?php if ($gender == 'male') echo 'selected'; ?>>Male</option>
                                <option value="female" <?php if ($gender == 'female') echo 'selected'; ?>>Female</option>
                                <option value="other" <?php if ($gender == 'other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <button type="submit" name="update" class="btn btn-custom btn-update-profile">Update Profile</button>
                    </form>
                </div>

                <!-- Update Email Form -->
                <div class="profile-card">
                    <form action="../../src/routes/ProfileRoute.php" method="POST">
                        <h3>Update Email</h3>
                        <div class="form-group">
                            <label for="new_email">New Email</label>
                            <input type="email" name="new_email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <button type="submit" name="update_email" class="btn btn-custom btn-update-email">Update Email</button>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="profile-card">
                    <form action="../../src/routes/ProfileRoute.php" method="POST">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" name="update_password" class="btn btn-custom btn-change-password">Change Password</button>
                    </form>
                </div>

                <!-- Delete Profile Form -->
                <div class="profile-card">
                    <form action="../../src/routes/ProfileRoute.php" method="POST">
                        <button type="submit" name="delete" class="btn btn-custom btn-delete-profile">Delete Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
