<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date']; // Capture the due date

    // Update the task in the database
    $query = "UPDATE tasks SET task_name = ?, description = ?, status = ?, priority = ?, due_date = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $task_name, $description, $status, $priority, $due_date, $task_id);

    if ($stmt->execute()) {
        // Redirect to dashboard or show success message
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating task: " . $stmt->error;
    }
}
?>
