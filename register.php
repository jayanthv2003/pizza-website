<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $address  = trim($_POST["address"]);
    $password = trim($_POST["password"]);

    // Check empty fields
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    // Validate phone (basic 10-digit check)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "Invalid phone number!";
        exit;
    }

    // Hash password (bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email already registered!";
    } else {
        // Insert user with phone & address
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashedPassword);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Registration failed!";
        }
    }
}
?>
