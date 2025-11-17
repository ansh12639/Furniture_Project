<?php

header("Content-Type: application/json");

include "db_connection.php";
// else{
//     echo "Connection Successful";
// }

$sql = "SELECT `id`, `image_path`, `name`, `info`, `price` FROM `products` ORDER BY RAND() LIMIT 16";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
