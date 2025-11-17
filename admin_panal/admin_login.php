<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
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
        <h3 class="text-center mb-4">Admin Login</h3>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
          echo '<div class="alert alert-danger" role="alert">
                  Invalid username or password.
                </div>';
        }
        ?>

        <form action="admin_login_handler.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="mb-3 password-toggle">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="admin-password" class="form-control" required>
            <i class="fa-solid fa-eye" id="admin-toggle-password"></i>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
          <small>Don't have an account? <a href="admin_signup.php">Register</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toggle script -->
<script>
  const toggleAdminPassword = document.getElementById("admin-toggle-password");
  const adminPassword = document.getElementById("admin-password");

  toggleAdminPassword.addEventListener("click", () => {
    const isHidden = adminPassword.type === "password";
    adminPassword.type = isHidden ? "text" : "password";
    toggleAdminPassword.classList.toggle("fa-eye");
    toggleAdminPassword.classList.toggle("fa-eye-slash");
  });
</script>

</body>
</html>
