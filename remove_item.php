<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// if (isset($_GET['id'])) {
    //     $productId = intval($_GET['id']);
    
    //     // Check if the item exists in the cart before removing
    //     if (isset($_SESSION['cart'][$productId])) {
        //         unset($_SESSION['cart'][$productId]);
        //     } else {
            //         // Optional: Handle if the product doesn't exist in the cart
            //         echo "Product not found in the cart.";
//         exit();
//     }
// }



// session_start();

$response = ['status' => 'error', 'message' => 'Something went wrong'];

if (!isset($_SESSION['username'])) {
    $response['message'] = 'You are not logged in.';
    echo json_encode($response);
    exit();
}

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Check if the item exists in the cart before removing
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        $response['status'] = 'success';
        $response['message'] = 'Item removed from cart successfully.';
    } else {
        $response['message'] = 'Product not found in the cart.';
    }
} else {
    $response['message'] = 'Product ID not specified.';
}

echo json_encode($response);
exit();

// Redirect back to the cart page
// header('Location: cart_onclick.php');
// exit();
?>