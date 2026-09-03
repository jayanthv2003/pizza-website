<?php
include "db.php";

header("Content-Type: application/json");

$sql = "SELECT 
            u.id, 
            u.name, 
            u.email, 
            u.phone, 
            u.address, 
            COUNT(o.id) AS orders, 
            IFNULL(SUM(o.total), 0) AS totalSpent
        FROM users u
        LEFT JOIN orders o ON u.id = o.customer_id
        WHERE u.role = 'customer'
        GROUP BY u.id";


$result = $conn->query($sql);

$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

echo json_encode($customers);
?>
