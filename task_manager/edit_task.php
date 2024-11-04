<?php
// Retrieve task details from the database
include 'db.php';
$task_id = $_GET['id'];
$query = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();
?>
<link rel="stylesheet" href="task.css">
<form class=task-container action="update_task.php" method="post">
    <h2>Update Task</h2>
    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">

    <label for="task_name">Task Name:</label>
    <input type="text" name="task_name" value="<?php echo $task['task_name']; ?>" required>

    <label for="description">Description:</label>
    <input type="text" name="description" value="<?php echo $task['description']; ?>">

    <label for="status">Status:</label>
    <select name="status">
        <option value="Not Started" <?php if($task['status'] == 'Not Started') echo 'selected'; ?>>Not Started</option>
        <option value="In Progress" <?php if($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
        <option value="Completed" <?php if($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
    </select>

    <label for="priority">Priority:</label>
    <select name="priority">
        <option value="Low" <?php if($task['priority'] == 'Low') echo 'selected'; ?>>Low</option>
        <option value="Medium" <?php if($task['priority'] == 'Medium') echo 'selected'; ?>>Medium</option>
        <option value="High" <?php if($task['priority'] == 'High') echo 'selected'; ?>>High</option>
    </select>

    <!-- Due date field -->
    <label for="due_date">Due Date:</label>
    <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>" required>

    <button type="submit">Update Task</button>
</form>
<a class=update href="dashboard.php">Back to Dashboard</a>
