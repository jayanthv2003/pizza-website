<?php
include "db.php";

header("Content-Type: application/json");

if (isset($_GET['customer_id'])) {
    $customer_id = intval($_GET['customer_id']);
    $stmt = $conn->prepare("SELECT id, items, total, status, order_date 
                            FROM orders 
                            WHERE customer_id=? 
                            ORDER BY order_date DESC");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT o.id, u.name AS customer, o.items, o.total, o.status, o.order_date
            FROM orders o
            JOIN users u ON o.customer_id = u.id
            ORDER BY o.order_date DESC";
    $result = $conn->query($sql);
}

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
