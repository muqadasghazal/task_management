<?php
session_start();
include('../dbconnection.php');

// Check if user is logged in
if (!isset($_SESSION['userName'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

// Fetch tasks from the database based on user_email
$user_query = "SELECT user_id FROM user WHERE email = '$user_email'";
$user_result = mysqli_query($conn, $user_query);
$user_row = mysqli_fetch_assoc($user_result);
$user_id = $user_row['user_id'];

$task_query = "SELECT * FROM task WHERE user_id = '$user_id'";
$task_result = mysqli_query($conn, $task_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management Dashboard</title>
   
    
</head>
<body>
<h2>Task Management Dashboard</h2>
<a href="addtask.php"><button class="btn">ADD TASK</button></a>

    <div class="container">
       
        
        <div class="block">
            <h3>Pending</h3>
            <?php
            while ($task_row = mysqli_fetch_assoc($task_result)) {
                if ($task_row['status'] == 'Pending') {
                    echo "<div class='task'>
                            <h4>" . $task_row['title'] . "</h4>
                            <p>" . $task_row['description'] . "</p>
                            <p>Due Date: " . $task_row['due_date'] . "</p>
                         
                          </div>";
                }
            }
            ?>
        </div>

        <div class="block">
            <h3>In Progress</h3>
            <?php
            mysqli_data_seek($task_result, 0); // Reset the pointer to the beginning
            while ($task_row = mysqli_fetch_assoc($task_result)) {
                if ($task_row['status'] == 'In Progress') {
                    echo "<div class='task'>
                            <h4>" . $task_row['title'] . "</h4>
                            <p>" . $task_row['description'] . "</p>
                            <p>Due Date: " . $task_row['due_date'] . "</p>
                        
                          </div>";
                }
            }
            ?>
        </div>

        <div class="block">
            <h3>Completed</h3>
            <?php
            mysqli_data_seek($task_result, 0); // Reset the pointer to the beginning
            while ($task_row = mysqli_fetch_assoc($task_result)) {
                if ($task_row['status'] == 'Completed') {
                    echo "<div class='task'>
                            <h4>" . $task_row['title'] . "</h4>
                            <p>" . $task_row['description'] . "</p>
                            <p>Due Date: " . $task_row['due_date'] . "</p>
                           
                          </div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
