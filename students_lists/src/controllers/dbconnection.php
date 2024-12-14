<?php
include_once '../../backup/api/DatabaseBackup.php';

// Database connection variables
$host = 'localhost';           // Database host
$dbname = 'student_lists';     // Database name
$username = 'root';            // Database username
$password = '';                // No password for root user
$charset = 'utf8mb4';          // Character set for connection

// Path for saving the backup files
$backupDir = '../../backup/database/';

// Backup the database first
$backupResult = DatabaseBackup::backup($host, $username, $password, $dbname, $backupDir);

// Show the result of the backup operation
echo $backupResult;  // Backup message (success or error)

// Proceed with the database connection if the backup was successful
if (strpos($backupResult, "Backup completed successfully") !== false) {
    try {
        // DSN (Data Source Name) for PDO connection
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        // Create a PDO instance
        $pdo = new PDO($dsn, $username, $password);
        
        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Success message (optional)
        echo "Connection successful!";
    } catch (PDOException $e) {
        // Catch and display any connection errors
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
