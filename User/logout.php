<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session

// Display a "Thank You for Shopping" message
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Thank You for Shopping</title>
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' rel='stylesheet'>
    <script src='https://cdn.tailwindcss.com'></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .thank-you-message {
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>
<body class='bg-gray-100'>
    <div class='thank-you-message'>
        <h2 class='text-3xl font-semibold text-gray-800'>Thank You for Shopping with Us!</h2>
        <p class='mt-4 text-gray-600'>We hope you had a great shopping experience. Come back soon!</p>
        <a href='index.php' class='mt-6 inline-block text-blue-600 hover:text-blue-800'>Go Back to Home</a>
    </div>
</body>
</html>";

// Redirect after a few seconds
header("refresh:5; url=index.php"); // Redirects after 5 seconds (adjust if needed)
exit();
?>
