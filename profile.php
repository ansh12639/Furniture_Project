<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html?error=required");
    exit();
}

include "db_connection.php";

$username = $_SESSION['username'];
$userData = [];
$updateSuccess = false;

// Fetch user details
try {
    $stmt = $conn->prepare("SELECT `username`, `email`, `phone`, `address`, `created_at` FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        header("Location: logout.php");
        exit();
    }
} catch (Exception $e) {
    error_log("Profile load error: " . $e->getMessage());
    die("Unable to load profile at the moment.");
}

// Handle address and phone update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPhone = trim($_POST['phone']);
    $newAddress = trim($_POST['address']);

    try {
        $updateStmt = $conn->prepare("UPDATE `users` SET `phone` = ?, `address` = ? WHERE `id` = ?");
        $updateStmt->bind_param("ssi", $newPhone, $newAddress, $userData['id']);
        if ($updateStmt->execute()) {
            $updateSuccess = true;
            $userData['phone'] = $newPhone;
            $userData['address'] = $newAddress;
        }
    } catch (Exception $e) {
        error_log("Profile update error: " . $e->getMessage());
        die("Unable to update profile at the moment.");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - ShopNow</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .profile-container {
      max-width: 600px;
      margin: 50px auto;
      background: #f9f9f9;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .profile-container h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .profile-info {
      font-size: 18px;
      margin-bottom: 10px;
    }
    .profile-info strong {
      display: inline-block;
      width: 140px;
      color: #333;
    }
    .profile-form input, .profile-form textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0 20px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .profile-form button {
      background: #333;
      color: #fff;
      border: none;
      padding: 12px 25px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
      width: 100%;
    }
    .profile-form button:hover {
      background: #555;
    }
    .success-msg {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 6px;
      border: 1px solid #c3e6cb;
      text-align: center;
    }
    .back-link {
      display: block;
      margin-top: 30px;
      text-align: center;
      background: #333;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 6px;
      transition: background 0.3s;
    }
    .back-link:hover {
      background: #555;
    }
  </style>
</head>

<body>

<div class="profile-container">
  <h1>👤 Your Profile</h1>

  <?php if ($updateSuccess): ?>
    <div class="success-msg">✅ Profile updated successfully!</div>
  <?php endif; ?>

  
  <div class="profile-info">
    <strong>Username:</strong> <?= htmlspecialchars($userData['username']) ?>
  </div>
  <div class="profile-info">
    <strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?>
  </div>
  <div class="profile-info">
    <strong>Member Since:</strong> <?= htmlspecialchars($userData['created_at']) ?>
  </div>

  <form action="profile.php" method="POST" class="profile-form">
    <label><strong>Phone Number:</strong></label>
    <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" placeholder="Enter phone number">

    <label><strong>Address:</strong></label>
    <textarea name="address" rows="3" placeholder="Enter your address"><?= htmlspecialchars($userData['address']) ?></textarea>

    <button type="submit">Save Changes</button>
  </form>

  <a href="dashboard.php" class="back-link">🔙 Back to Dashboard</a>
</div>

</body>
</html>
