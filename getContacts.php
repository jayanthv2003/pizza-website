<?php
include "db.php";
header('Content-Type: application/json');


$result = $conn->query("SELECT id, name, email, message, date FROM contacts ORDER BY id DESC");


$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

echo json_encode($contacts);
?>
