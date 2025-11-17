<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php'; // Include your database connection file

if (isset($_POST['add'])) {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $image_path = $_POST['image_path'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $insertSql = "INSERT INTO `products` (name, image_path, price, quantity, category, description) 
                  VALUES ('$name', '$image_path', '$price', '$quantity', '$category', '$description')";

    if ($conn->query($insertSql) === TRUE) {
        header("Location: manage_products.php");
    } else {
        echo "Error adding product: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #image-preview {
            max-width: 200px;
            margin-top: 10px;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Add New Product</h1>
        <a href="manage_products.php" class="btn btn-secondary mb-3">Back to Products</a>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price (Rs)</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Image Path (URL)</label>
                <input type="text" name="image_path" id="image-path" class="form-control" required oninput="updatePreview()">
                <img id="image-preview" src="" alt="Image Preview" style="display:none;">
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <option value="Chair">Chair</option>
                    <option value="Sofa">Sofa</option>
                    <option value="Bed">Bed</option>
                    <option value="Carpet">Carpet</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" name="add" class="btn btn-success">Add Product</button>
            <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        function updatePreview() {
            const imagePath = document.getElementById('image-path').value;
            const imagePreview = document.getElementById('image-preview');

            if (imagePath.trim() !== "") {
                imagePreview.src = imagePath;
                imagePreview.style.display = 'block';
            } else {
                imagePreview.style.display = 'none';
            }
        }
    </script>

</body>

</html>