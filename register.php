<?php
session_start();
include "db.php"; // DB connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $upline   = trim($_POST["upline"]);
    $phone    = trim($_POST["phone"]);
    $pass     = $_POST["password"];
    $pass2    = $_POST["password2"];

    if ($pass !== $pass2) {
        echo "Passwords do not match";
        exit;
    }

    // Check if phone OR username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE phone=? OR username=?");
    $check->bind_param("ss", $phone, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "User with this phone/username already exists";
        exit;
    }

    // Hash password
    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    // Insert into DB
    $insert = $conn->prepare("INSERT INTO users (username, upline, phone, password) VALUES (?,?,?,?)");
    $insert->bind_param("ssss", $username, $upline, $phone, $hashed);

    if ($insert->execute()) {
        // AUTO LOGIN
        $_SESSION["eulo_user"] = $username;
        $_SESSION["eulo_phone"] = $phone;

        echo "success"; // JS will redirect to dashboard
    } else {
        echo "Error saving user";
    }
}
?>
