<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "online_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $feedback = trim($_POST['feedback'] ?? '');
    $customer_name = $_SESSION['email'] ?? 'Anonymous';  // Or get from form if you allow

    if (empty($feedback)) {
        $_SESSION['error'] = "Feedback cannot be empty.";
        header("Location: feedback_form.php"); // Adjust to your feedback form page
        exit();
    }

    // Prepare and bind to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO feedback (customer_name, message, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $customer_name, $feedback);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Thank you for your feedback!";
        header("Location: dashboard.php");  // Or wherever you want to redirect
        exit();
    } else {
        $_SESSION['error'] = "Failed to submit feedback. Please try again.";
        header("Location: feedback_form.php");
        exit();
    }
} else {
    // If not a POST request, redirect somewhere safe
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>
