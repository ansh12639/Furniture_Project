<?php
session_start();

if (isset($_SESSION['checkout_data'])) {
    echo json_encode($_SESSION['checkout_data']);
} else {
    echo json_encode(null);
}
?>
