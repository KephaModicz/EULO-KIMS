<?php
session_start();
if (!isset($_SESSION["eulo_user"])) {
    header("Location: index.html"); // send back to login
    exit;
}
$username = $_SESSION["eulo_user"];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>EULO-KIMS — Dashboard</title>

  <style>
    body{
      margin:0;
      font-family:Inter,Segoe UI,Roboto;
      background:#0f1724;
      color:#e6eef6;
      padding:30px;
    }
    .box{
      max-width:600px;
      margin:auto;
      background:rgba(255,255,255,0.05);
      padding:30px;
      border-radius:12px;
      text-align:center;
    }
  </style>
</head>
<body>

<div class="box">
  <h1>Welcome, <?= htmlspecialchars($username) ?></h1>
  <p>Your dashboard is active.</p>
</div>

</body>
</html>
