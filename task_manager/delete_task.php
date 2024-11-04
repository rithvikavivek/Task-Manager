<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get task ID from URL
$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Delete task from the database
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$stmt->close();

// Redirect to dashboard after deletion
header("Location: dashboard.php");
exit();
?>
