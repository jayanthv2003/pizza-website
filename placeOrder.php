<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customer_id = intval($_POST["customer_id"]);
    $items = $_POST["items"];
    $total = floatval($_POST["total"]);

    $stmt = $conn->prepare("INSERT INTO orders (customer_id, items, total, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("isd", $customer_id, $items, $total);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
