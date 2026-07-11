<?php
include __DIR__ . '/../db_connection.php'; // Include your database connection file

$id = $_GET['id'];
$sql = "SELECT * FROM `products` WHERE id=$id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $image_path = $_POST['image_path']; // <-- Get image path
    $quantity = $_POST['quantity'];     // <-- Get quantity
    $info = $_POST['info'];           // <-- Get info
    $category = $_POST['category'];
    $description = $_POST['description'];

    $updateSql = "UPDATE `products` SET 
                    name='$name', 
                    image_path='$image_path', 
                    price='$price', 
                    quantity='$quantity',
                    info='$info', 
                    category='$category',
                    description='$description'
                  WHERE id=$id";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: manage_products.php");
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Edit Product</h1><a href="manage_products.php" class="btn btn-secondary mb-3">Back</a>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= $product['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (Rs)</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img src="<?= $product['image_path']; ?>" width="100" style="margin-bottom:10px;"><br>
                <label class="form-label">Image Path</label>
                <input type="text" name="image_path" class="form-control" value="<?= $product['image_path']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Info</label>
                <input type="text" name="info" class="form-control" value="<?= $product['info']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= $product['quantity']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="Chair" <?= $product['category'] == 'Chair' ? 'selected' : ''; ?>>Chair</option>
                    <option value="Sofa" <?= $product['category'] == 'Sofa' ? 'selected' : ''; ?>>Sofa</option>
                    <option value="Bed" <?= $product['category'] == 'Bed' ? 'selected' : ''; ?>>Bed</option>
                    <option value="Carpet" <?= $product['category'] == 'Carpet' ? 'selected' : ''; ?>>Carpet</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= $product['description']; ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update Product</button>
            <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>