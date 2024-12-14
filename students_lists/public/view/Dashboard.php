<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // If not logged in, redirect to login page
    header('Location: Login.php');
    exit();
}

include_once '../../src/controllers/StudentController.php';
include_once '../../src/models/StudentModel.php';
include_once '../../src/routes/StudentRoute.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .modal-content {
            border-radius: 10px;
        }
        .btn {
            border-radius: 20px;
            font-weight: bold;
        }
        .modal-body {
            padding: 15px;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .modal-footer {
            justify-content: space-between;
        }
        .btn-sm {
            border-radius: 50px;
        }
        .text-primary {
            color: #007bff !important;
        }
        .btn-outline-danger {
            border-radius: 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to the Dashboard!</h1>
        <p class="text-center mt-3">You are logged in as: <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong></p>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
            <a href="Profile.php" class="btn btn-outline-success">Profile</a>
        </div>

        <!-- Add Student Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../../src/routes/StudentRoute.php" method="POST">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="degree" class="form-label">Degree</label>
                                <input type="text" class="form-control" id="degree" name="degree" required>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control" id="year" name="year" required>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <input type="text" class="form-control" id="section" name="section" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="other">Other</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select class="form-select" id="payment_status" name="payment_status" required>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="paid">Paid</option>
                                    <option value="not_paid">Not Paid</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="attendance_status" class="form-label">Attendance Status</label>
                                <select class="form-select" id="attendance_status" name="attendance_status" required>
                                    <option value="not_yet">Not Yet</option>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Students Table -->
        <h2 class="mt-5">List of Students</h2>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Degree</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Gender</th>
                    <th>Payment Status</th>
                    <th>Attendance Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['first_name']; ?></td>
                        <td><?php echo !empty($student['middle_name']) ? $student['middle_name'] : 'None'; ?></td>
                        <td><?php echo $student['last_name']; ?></td>
                        <td><?php echo $student['degree']; ?></td>
                        <td><?php echo $student['year']; ?></td>
                        <td><?php echo $student['section']; ?></td>
                        <td><?php echo $student['gender']; ?></td>
                        <td><?php echo $student['payment_status']; ?></td>
                        <td><?php echo $student['attendance_status']; ?></td>
                        <td>
                            <!-- Edit Button (Modal Trigger) -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal<?php echo $student['id']; ?>">Edit</button>

                            <!-- Edit Student Modal -->
                            <div class="modal fade" id="editStudentModal<?php echo $student['id']; ?>" tabindex="-1" aria-labelledby="editStudentModalLabel<?php echo $student['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editStudentModalLabel<?php echo $student['id']; ?>">Edit Student</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="../../src/routes/StudentRoute.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $student['first_name']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="middle_name" class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $student['middle_name']; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $student['last_name']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="degree" class="form-label">Degree</label>
                                                    <input type="text" class="form-control" id="degree" name="degree" value="<?php echo $student['degree']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="year" class="form-label">Year</label>
                                                    <input type="number" class="form-control" id="year" name="year" value="<?php echo $student['year']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="section" class="form-label">Section</label>
                                                    <input type="text" class="form-control" id="section" name="section" value="<?php echo $student['section']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <select class="form-select" id="gender" name="gender" required>
                                                        <option value="other" <?php echo ($student['gender'] == 'other' ? 'selected' : ''); ?>>Other</option>
                                                        <option value="male" <?php echo ($student['gender'] == 'male' ? 'selected' : ''); ?>>Male</option>
                                                        <option value="female" <?php echo ($student['gender'] == 'female' ? 'selected' : ''); ?>>Female</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_status" class="form-label">Payment Status</label>
                                                    <select class="form-select" id="payment_status" name="payment_status" required>
                                                        <option value="not_yet" <?php echo ($student['payment_status'] == 'not_yet' ? 'selected' : ''); ?>>Not Yet</option>
                                                        <option value="paid" <?php echo ($student['payment_status'] == 'paid' ? 'selected' : ''); ?>>Paid</option>
                                                        <option value="not_paid" <?php echo ($student['payment_status'] == 'not_paid' ? 'selected' : ''); ?>>Not Paid</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="attendance_status" class="form-label">Attendance Status</label>
                                                    <select class="form-select" id="attendance_status" name="attendance_status" required>
                                                        <option value="not_yet" <?php echo ($student['attendance_status'] == 'not_yet' ? 'selected' : ''); ?>>Not Yet</option>
                                                        <option value="present" <?php echo ($student['attendance_status'] == 'present' ? 'selected' : ''); ?>>Present</option>
                                                        <option value="absent" <?php echo ($student['attendance_status'] == 'absent' ? 'selected' : ''); ?>>Absent</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Button (Modal Trigger) -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteStudentModal<?php echo $student['id']; ?>">Delete</button>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteStudentModal<?php echo $student['id']; ?>" tabindex="-1" aria-labelledby="deleteStudentModalLabel<?php echo $student['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteStudentModalLabel<?php echo $student['id']; ?>">Delete Student</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this student?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="../../src/routes/StudentRoute.php?delete_id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
