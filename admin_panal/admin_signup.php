<?php
session_start();
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
        header("Location: admin_signup.php?error=password_mismatch");
        exit();
    } else {
        $checkStmt = $conn->prepare("SELECT `id` FROM `admins` WHERE `username` = ? OR `email` = ?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            header("Location: admin_signup.php?error=username_or_email_taken");
            exit();
        } else {
            $sql = "INSERT INTO `admins` (`username`, `email`, `password`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $_SESSION['admin_username'] = $username;
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin_dashboard.php?success=registration_successful");
                exit();
            } else {
                header("Location: admin_signup.php?error=registration_failed");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    .password-toggle {
      position: relative;
    }

    .password-toggle i {
      position: absolute;
      right: 10px;
      top: 70%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
    }
  </style>
</head>
<body class="bg-light">

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-4">
      <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Admin Signup</h3>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger">
            <?php
              switch ($_GET['error']) {
                case 'password_mismatch':
                  echo 'Passwords do not match!';
                  break;
                case 'username_or_email_taken':
                  echo 'Username or email already exists!';
                  break;
                case 'registration_failed':
                  echo 'Registration failed. Please try again.';
                  break;
              }
            ?>
          </div>
        <?php endif; ?>

        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3 password-toggle">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="admin-signup-password" class="form-control" required>
            <i class="fa-solid fa-eye" id="toggle-signup-password"></i>
          </div>

          <div class="mb-3 password-toggle">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="admin-confirm-password" class="form-control" required>
            <i class="fa-solid fa-eye" id="toggle-confirm-password"></i>
          </div>

          <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>

        <div class="text-center mt-3">
          <small>Already have an account? <a href="admin_login.php">Login here</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    icon.addEventListener("click", () => {
      const isHidden = input.type === "password";
      input.type = isHidden ? "text" : "password";
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
    });
  }

  togglePassword("admin-signup-password", "toggle-signup-password");
  togglePassword("admin-confirm-password", "toggle-confirm-password");
</script>

</body>
</html>
