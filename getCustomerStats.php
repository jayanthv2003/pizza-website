<?php
include "db.php";

if (isset($_GET['customer_id'])) {
    $customer_id = intval($_GET['customer_id']);

    // Total Orders + Spent
    $query = $conn->prepare("SELECT COUNT(*) as total_orders, SUM(total) as total_spent FROM orders WHERE customer_id=?");
    $query->bind_param("i", $customer_id);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    // Favorite Pizza (most ordered item)
    $favQuery = $conn->prepare("
        SELECT items, COUNT(*) as cnt 
        FROM orders 
        WHERE customer_id=? 
        GROUP BY items 
        ORDER BY cnt DESC LIMIT 1
    ");
    $favQuery->bind_param("i", $customer_id);
    $favQuery->execute();
    $favResult = $favQuery->get_result()->fetch_assoc();

    // Member Since (first order date or registration date)
    $dateQuery = $conn->prepare("SELECT MIN(order_date) as member_since FROM orders WHERE customer_id=?");
    $dateQuery->bind_param("i", $customer_id);
    $dateQuery->execute();
    $dateResult = $dateQuery->get_result()->fetch_assoc();

    echo json_encode([
        "total_orders" => $result['total_orders'] ?? 0,
        "total_spent" => $result['total_spent'] ?? 0,
        "favorite_pizza" => $favResult['items'] ?? "N/A",
        "member_since" => $dateResult['member_since'] ?? "N/A"
    ]);
}
?>
