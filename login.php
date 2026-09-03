<?php
include "db.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // ✅ Added phone, address
    $stmt = $conn->prepare("SELECT id, name, email, phone, address, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user["password"])) {
            unset($user["password"]); // don’t send hash back

            // Explicit check for admin role
            if ($user["role"] === "admin") {
                $user["message"] = "Welcome Admin!";
            } else {
                $user["message"] = "Welcome back, " . $user["name"];
            }

            echo json_encode($user);
        } else {
            echo json_encode(["error" => "Invalid password!"]);
        }
    } else {
        echo json_encode(["error" => "User not found!"]);
    }
}
?>
