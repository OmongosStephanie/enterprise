<?php
// register.php
// Include submit_registration.php code here
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure that the necessary form fields are set
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['contact_number'], $_POST['address'], $_POST['birthday'])) {
        // Sanitize and validate input data
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $contactNumber = trim($_POST['contact_number']);
        $address = trim($_POST['address']);
        $birthday = $_POST['birthday'];

        // Check if the user is 18 or older
        $birthDate = new DateTime($birthday);
        $age = $birthDate->diff(new DateTime())->y;
        
        if ($age < 18) {
            echo "<script>alert('You must be at least 18 years old to register.'); window.location.href='register.php';</script>";
            exit();
        }

        // Database connection
        $host = 'localhost';
        $dbname = 'user_db';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        // Prepare SQL query to insert data into the database
        $query = "INSERT INTO users (first_name, last_name, contact_number, address, birthday) 
                    VALUES (:first_name, :last_name, :contact_number, :address, :birthday)";
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':contact_number', $contactNumber);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':birthday', $birthday);
            
            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='register.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='register.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Create Account</h2>
        <form id="registerForm" action="register.php" method="POST">
            <div class="space-y-4">
                <div>
                    <input type="text" name="first_name" placeholder="First Name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-gray-700" required>
                </div>
                <div>
                    <input type="text" name="last_name" placeholder="Last Name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-gray-700" required>
                </div>
                <div>
                    <input type="text" name="contact_number" placeholder="Contact Number" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-gray-700" required>
                </div>
                <div>
                    <input type="text" name="address" placeholder="Address" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-gray-700" required>
                </div>
                <div>
                    <input type="date" name="birthday" id="birthday" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-gray-700" required>
                </div>
                <button type="submit" class="w-full py-2 rounded-md bg-indigo-500 text-white font-semibold hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-75">
                    Create Account
                </button>
            </div>
        </form>
        <div class="mt-4 text-center text-gray-600">
            Already have an account? <a href="index.php" class="text-blue-500 hover:text-blue-700 font-semibold">Login</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const birthdayInput = document.getElementById('birthday');
            const today = new Date();
            const minAge = 18;
            const minDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
            birthdayInput.setAttribute('max', minDate.toISOString().split('T')[0]);

            document.getElementById('registerForm').addEventListener('submit', function (e) {
                const birthDate = new Date(birthdayInput.value);
                if (birthDate > minDate) {
                    alert('You must be at least 18 years old to register.');
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
