<?php
include "db.php";
header('Content-Type: application/json');
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if (!$name || !$email || !$message) {
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contacts (name, email, message, date) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save message"]);
}
?>
