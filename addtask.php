<?php
session_start();
include('../dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['userName'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop further execution
}

if (isset($_POST['submit'])) {
    // Use $_SESSION['userName'] or $_SESSION['email'] to retrieve user data
    $user_email = $_SESSION['email'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
   
    $status = $_POST['status'];

    // Get user_id based on user_email
    $user_query = "SELECT user_id FROM user WHERE email = '$user_email'";
    $user_result = mysqli_query($conn, $user_query);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['user_id'];

    // Insert task data into the database
    $sql = "INSERT INTO task (user_id, title, description, due_date,  status)
            VALUES ('$user_id', '$title', '$description', '$due_date',  '$status')";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: dashboard.php"); // Redirect to the dashboard after successful insertion
        exit(); // Stop further execution
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>

    <link rel="stylesheet" href="styling.css">
   
</head>
<body>
<h2>Task Management System</h2>
    <div class="container">
      
        <form  method="post">
            
           
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date:</label>
                <input type="date" id="due_date" name="due_date" class="date" required>
            </div>
          
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <button type="submit" name="submit">Save Task</button>
        </form>
    </div>
    

</body>
</html>
