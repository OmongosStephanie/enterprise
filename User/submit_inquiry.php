<?php
// submit_inquiry.php
session_start();

// Ensure the user is logged in before submitting an inquiry
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the inquiry from the form
$inquiry = trim($_POST['inquiry']);

// Validate the inquiry (ensure it's not empty)
if (!empty($inquiry)) {
    // Store the inquiry in the database
    require_once '../includes/db.php'; // Include the DB connection file

    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO customer_service_inquiries (user_id, inquiry, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $inquiry);

    if ($stmt->execute()) {
        echo "Thank you for contacting customer service. We will get back to you shortly.";
    } else {
        echo "Sorry, something went wrong. Please try again later.";
    }
} else {
    echo "Your inquiry cannot be empty. Please provide details about your issue.";
}
?>
