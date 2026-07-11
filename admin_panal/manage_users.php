<?php
include __DIR__ . '/../db_connection.php';
session_start(); // Required to read session message

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search filters from the query string
$searchEmail = $_GET['search_email'] ?? '';
$searchRole = $_GET['search_role'] ?? '';

// Build the SQL query with UNION to combine users and admins
$sqlUsers = "SELECT id, username, email, 'user' AS role, 'user' AS source FROM users WHERE 1";
$sqlAdmins = "SELECT id, username, email, 'admin' AS role, 'admin' AS source FROM admins WHERE 1";

// Apply email filter to both tables
if (!empty($searchEmail)) {
    $escapedEmail = $conn->real_escape_string($searchEmail);
    $sqlUsers .= " AND email LIKE '%$escapedEmail%'";
    $sqlAdmins .= " AND email LIKE '%$escapedEmail%'";
}

// Apply role filter
if (!empty($searchRole)) {
    if ($searchRole === 'admin') {
        // Show only admins from the admins table
        $sqlUsers = "SELECT id, username, email, 'user' AS role, 'user' AS source FROM users WHERE 0";
    } elseif ($searchRole === 'user') {
        // Show only users from the users table
        $sqlAdmins = "SELECT id, username, email, 'admin' AS role, 'admin' AS source FROM admins WHERE 0";
    }
}

// Combine the queries with UNION
$sql = "($sqlUsers) UNION ($sqlAdmins)";
$result = $conn->query($sql);

// Check for query errors
if ($result === false) {
    die("SQL Error: " . $conn->error . "<br>Query: " . $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f1f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .lux-header {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b2f63;
        }
        .table-wrapper {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #3b2f63;
            color: white;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .table th {
            font-weight: bold;
        }
        .table td {
            font-size: 0.9rem;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-edit {
            background-color: #3b2f63;
            color: white;
            border: none;
        }
        .badge {
            padding: 0.4em 0.7em;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="lux-header mb-4">Manage Users</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="admin_dashboard.php" class="btn btn-secondary">Back</a>
    </div>

    <!-- Search/Filter Form -->
    <form method="GET" class="mb-4 row g-3">
        <div class="col-md-4">
            <input type="text" name="search_email" class="form-control" placeholder="Search by Email"
                   value="<?= htmlspecialchars($searchEmail) ?>">
        </div>
        <div class="col-md-4">
            <select name="search_role" class="form-select">
                <option value="">All Roles</option>
                <?php
                $roles = ['admin', 'user'];
                foreach ($roles as $role) {
                    $selected = ($searchRole === $role) ? 'selected' : '';
                    echo "<option value=\"$role\" $selected>" . ucfirst($role) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 d-flex">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="manage_users.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-wrapper">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <span class="badge 
                                <?= $row['role'] === 'admin' ? 'bg-primary' : 'bg-success' ?>">
                                <?= ucfirst(htmlspecialchars($row['role'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['source'] === 'user'): ?>
                                <a href="view_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark">View</a>
                                <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            <?php else: ?>
                                <a href="view_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-dark">View</a>
                                <a href="delete_admin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No users or admins found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Success Message Toast -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="liveToast" class="toast align-items-center text-white <?php echo $_SESSION['messageClass']; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('liveToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 3000
                });
                toast.show();
            }
        });
    </script>
    <?php unset($_SESSION['message'], $_SESSION['messageClass']); ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>