<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM tasks WHERE user_id = $user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-header">
        <h2>Welcome to Your Dashboard</h2>
    </div>
    <div class="dropdown">
    <button class="dropdown-btn">Menu</button>
    <div class="dropdown-content">
        <a href="account.php">Account</a>
        <a href="login.php">Logout</a>
    </div>
</div>

    <h2 class=heading>Dashboard</h2>
    <a href="add_task.php">Add New Task</a><br><br>
    <table>
        <tr>
            <th>Task</th>
            <th>Description</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
        <?php while($task = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $task['task_name']; ?></td>
                <td><?php echo $task['description']; ?></td>
                <td><?php echo $task['status']; ?></td>
                <td><?php echo $task['priority']; ?></td>
                <td><?php echo $task['due_date']; ?></td>
                <td>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
