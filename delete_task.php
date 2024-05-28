<?php
session_start();
include('../dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        
        // Delete the task from the database based on task_id
        $delete_query = "DELETE FROM task WHERE task_id = '$task_id'";
        $delete_result = mysqli_query($conn, $delete_query);
        
        if ($delete_result) {
            // Redirect back to the dashboard after deletion
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error deleting task: " . mysqli_error($conn);
        }
    }
}
?>
