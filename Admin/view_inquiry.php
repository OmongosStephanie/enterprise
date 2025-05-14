
### Step 4: Admin Panel to View Inquiries (`admin_view_inquiries.php`)

This is the backend for admins to view all inquiries.

```php
<?php
// admin_view_inquiries.php
require_once '../includes/db.php';

// Fetch all inquiries
$sql = "SELECT inquiries.id, customers.name, inquiries.inquiry, inquiries.created_at 
        FROM customer_service_inquiries AS inquiries 
        JOIN customers ON inquiries.user_id = customers.id 
        ORDER BY inquiries.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div><strong>User:</strong> " . htmlspecialchars($row['name']) . "</div>";
        echo "<div><strong>Inquiry:</strong> " . htmlspecialchars($row['inquiry']) . "</div>";
        echo "<div><strong>Date:</strong> " . htmlspecialchars($row['created_at']) . "</div><hr>";
    }
} else {
    echo "No inquiries yet.";
}
?>
