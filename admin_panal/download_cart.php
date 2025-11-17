<?php
include 'C:\xampp\htdocs\Furniture_Project\db_connection.php';

if (isset($_POST['table_name'])) {
    $table = mysqli_real_escape_string($conn, $_POST['table_name']);
    $filename = $table . "_cart.csv";

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Product ID', 'Name', 'Price', 'Quantity', 'Total', 'Image']);

    $result = mysqli_query($conn, "SELECT * FROM `$table`");
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [$row['product_id'], $row['name'], $row['price'], $row['quantity'], $row['total'], $row['image']]);
    }
    fclose($output);
    exit();
}
?>
