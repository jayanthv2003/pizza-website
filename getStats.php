<?php
include "db.php";

header("Content-Type: application/json");

$stats = [];

// Total Orders
$res = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$stats["totalOrders"] = $res->fetch_assoc()["total_orders"];

// Revenue
$res = $conn->query("SELECT IFNULL(SUM(total),0) AS revenue FROM orders WHERE status='Delivered'");
$stats["revenue"] = $res->fetch_assoc()["revenue"];

// Customers
$res = $conn->query("SELECT COUNT(*) AS total_customers FROM users WHERE role='customer'");
$stats["totalCustomers"] = $res->fetch_assoc()["total_customers"];

echo json_encode($stats);
?>
