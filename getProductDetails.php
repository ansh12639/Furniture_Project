<?php
session_start();
include 'db_connection.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT * FROM `products` WHERE `id`= '$id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode(["error" => "Product not found"]);
  }
} else {
  echo json_encode(["error" => "No ID provided"]);
}

$conn->close();
?>
