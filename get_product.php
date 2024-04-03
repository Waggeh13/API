<?php
// Start or resume session
session_start();

// Retrieve product from request
$data = json_decode(file_get_contents("php://input"), true);
$product = $data['product'];

// Check if the product has already been selected
if (isset($_SESSION['selected_products']) && in_array($product, $_SESSION['selected_products'])) {
    $response = array(
        "success" => false,
        "error" => "You have already selected $product. Please choose a different product."
    );
} else {
    // Simulated database query based on product
    $products = array(
        "Potato" => array("quantity" => 10, "price" => 1.50),
        "Tomato" => array("quantity" => 5, "price" => 2.50),
        "Carrot" => array("quantity" => 8, "price" => 1.50),
        "Onion" => array("quantity" => 12, "price" => 0.80),
        "Cabbage" => array("quantity" => 3, "price" => 2.00),
        "Broccoli" => array("quantity" => 6, "price" => 1.75)
        // Add more products and their information as needed
    );

    // Check if the product exists
    if (array_key_exists($product, $products)) {
        // Add the selected product to session
        $_SESSION['selected_products'][] = $product;

        $response = array(
            "success" => true,
            "order" => array(
                "product" => $product,
                "quantity" => $products[$product]["quantity"],
                "price" => $products[$product]["price"]
            ),
            "message" => "Product information retrieved successfully."
        );
    } else {
        $response = array(
            "success" => false,
            "error" => "Product not found."
        );
    }
}

// Send response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
