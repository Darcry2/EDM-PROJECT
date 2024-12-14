<?php
class DatabaseBackup {
    public static function backup($host, $username, $password, $dbname, $backupDir) {
        // Define the backup file name (timestamped)
        $backupFile = $backupDir . $dbname . '_backup_' . date('Y-m-d_H-i-s') . '.sql';
        
        // MySQL dump command to export the database using the full path to mysqldump
        $command = "C:\\xampp\\mysql\\bin\\mysqldump --host=$host --user=$username --password=$password $dbname > $backupFile 2>&1";
        
        // Debugging: Log the command for troubleshooting
        error_log("Executing command: $command");
        
        // Execute the command and capture the output and error
        $output = null;
        $resultCode = null;
        exec($command, $output, $resultCode);
        
        // Log the result of the exec() function for better debugging
        error_log("Command result code: $resultCode");
        error_log("Command output: " . implode("\n", $output));

        // Check if the backup was successful
        if ($resultCode === 0) {
            return "Backup completed successfully. File saved to: $backupFile";
        } else {
            return "Backup failed. Error code: $resultCode. Output: " . implode("\n", $output);
        }
    }
}
?>
