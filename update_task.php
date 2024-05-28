<?php
session_start();
include('../dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $status = $_POST['status'];

        // Update the task in the database based on task_id
        $update_query = "UPDATE task SET title = '$title', description = '$description', due_date = '$due_date', status = '$status' WHERE task_id = '$task_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Redirect back to the dashboard after updating task
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error updating task: " . mysqli_error($conn);
        }
    }
}
?>
