<?php
session_start();
include('../dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        
        // Retrieve task details from the database based on task_id
        $task_query = "SELECT * FROM task WHERE task_id = '$task_id'";
        $task_result = mysqli_query($conn, $task_query);
        $task_row = mysqli_fetch_assoc($task_result);

        // Display a form to edit the task details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Task</title>
        </head>
        <body>
            <h2>Edit Task</h2>
            <form action="update_task.php" method="post">
                <input type="hidden" name="task_id" value="<?php echo $task_row['task_id']; ?>">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $task_row['title']; ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required><?php echo $task_row['description']; ?></textarea>
                </div>
                <div>
                    <label for="due_date">Due Date:</label>
                    <input type="date" id="due_date" name="due_date" value="<?php echo $task_row['due_date']; ?>" class="date" required>
                </div>
                <div>
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="Pending" <?php if ($task_row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="In Progress" <?php if ($task_row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                        <option value="Completed" <?php if ($task_row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                    </select>
                </div>
                <button type="submit" name="update">Update Task</button>
            </form>
        </body>
        </html>
        <?php
    }
}
?>
