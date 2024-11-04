<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    // Insert task into the database
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, description, status, priority, due_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $task_name, $description, $status, $priority, $due_date);
    $stmt->execute();
    $stmt->close();

    // Redirect to the dashboard after adding task
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="task.css">
</head>
<body>
    <form class=task-container method="POST">
        <h2>Add Task</h2>
        <input type="text" name="task_name" placeholder="Task Name" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <label>Status:</label>
        <select name="status">
            <option value="Not Started">Not Started</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br>
        <label>Priority:</label>
        <select name="priority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select><br>
        <label>Due Date:</label>
        <input type="date" name="due_date"><br>
        <button type="submit">Add Task</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
