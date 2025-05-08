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
        $dbname = 'online_shop';
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