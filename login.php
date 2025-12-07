<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST["user"]);
    $pass = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, phone, password FROM users WHERE username=? OR phone=? LIMIT 1");
    $stmt->bind_param("ss", $user, $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo "Invalid username/phone";
        exit;
    }

    $stmt->bind_result($id, $username, $phone, $hash);
    $stmt->fetch();

    if (password_verify($pass, $hash)) {
        $_SESSION["eulo_user"] = $username;
        $_SESSION["eulo_phone"] = $phone;
        echo "success";
    } else {
        echo "Wrong password";
    }
}
?>

