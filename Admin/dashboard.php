<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Handle the request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Determine which data to fetch based on a parameter (e.g., 'type')
    $type = isset($_GET['type']) ? $_GET['type'] : 'all'; // Default to fetching all data

    $response = array();

    if ($type === 'all' || $type === 'cash_sales') {
        // Query to get the total sales for the last month
        $sql_last_month_sales = "SELECT SUM(amount) AS total_sales FROM sales WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $result_last_month_sales = $conn->query($sql_last_month_sales);

        $last_month_sales = 0;
        if ($result_last_month_sales->num_rows > 0) {
            $row = $result_last_month_sales->fetch_assoc();
            $last_month_sales = $row["total_sales"];
        }

        // Query to get the total sales for the month before last (for percentage calculation)
        $sql_previous_month_sales = "SELECT SUM(amount) AS total_sales FROM sales WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND sale_date < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $result_previous_month_sales = $conn->query($sql_previous_month_sales);

        $previous_month_sales = 0;
        if ($result_previous_month_sales->num_rows > 0) {
            $row = $result_previous_month_sales->fetch_assoc();
            $previous_month_sales = $row["total_sales"];
        }

        $percentage_change = 0;
        if ($previous_month_sales != 0) {
            $percentage_change = (($last_month_sales - $previous_month_sales) / $previous_month_sales) * 100;
        }

        // Add cash sales data to the response
        $response['cash_sales'] = array(
            'last_month_sales' => round($last_month_sales, 2),
            'percentage_change' => round($percentage_change, 2)
        );
    }

    if ($type === 'all' || $type === 'deposits') {
        // Query to get deposit amounts and dates for the last 7 days
        $sql_deposits = "SELECT DATE(deposit_date) AS deposit_day, SUM(amount) AS total_deposit FROM deposits WHERE deposit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(deposit_date) ORDER BY DATE(deposit_date)";
        $result_deposits = $conn->query($sql_deposits);

        $labels = [];
        $deposit_amounts = [];

        if ($result_deposits->num_rows > 0) {
            while ($row = $result_deposits->fetch_assoc()) {
                $labels[] = $row["deposit_day"];
                $deposit_amounts[] = $row["total_deposit"];
            }
        }

        // Add deposits data to the response
        $response['deposits'] = array(
            'labels' => $labels,
            'datasets' => array(
                array(
                    'label' => 'Deposits',
                    'data' => $deposit_amounts,
                    'borderColor' => 'green',
                    'fill' => false
                )
            )
        );
    }

    echo json_encode($response);
}

$conn->close();
?>