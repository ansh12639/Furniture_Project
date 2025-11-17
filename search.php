<?php

header("Content-Type: application/json");

include "db_connection.php";

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if (empty($query)) {
    echo json_encode(["error" => "Empty search query"]);
    $conn->close();
    exit;
}

$data = [];

if ($stmt = $conn->prepare("SELECT `id`, `image_path`, `name`, `info`, `price` FROM `products` WHERE `name` LIKE CONCAT('%', ?, '%') OR `category` LIKE CONCAT('%', ?, '%') OR (? REGEXP '^[0-9]+(\\.[0-9]+)?$' AND `price` <= ?) LIMIT 50")) {
    $stmt->bind_param("ssdd", $query, $query, $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Failed to prepare statement"]);
    $conn->close();
    exit;
}

echo json_encode($data);
$conn->close();
?>