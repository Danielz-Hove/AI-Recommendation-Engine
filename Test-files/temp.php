<?php

    $db = new mysqli('localhost', 'danielz', '1234', 'web2');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    function getProducts() {
        global $db;
        $result = $db->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function getRecommendedProducts($userId) {
        $db = new mysqli('localhost', 'danielz', '1234', 'web2');
        // Simulated recommendation logic (replace this with a real recommendation engine)
        // Example: Recommending products with IDs 1 and 3
        $recommendedIds = [1, 3]; 
        $recommendedProducts = [];

        foreach ($recommendedIds as $productId) {

            $result = $db->query("SELECT * FROM products WHERE id = $productId");
            
            $recommendedProducts[] = $result->fetch_assoc();
        }
        return $recommendedProducts;
    }

    $products = getProducts();
    $userId = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
    $recommendedProducts = getRecommendedProducts($userId);


    $filteredProducts2 = []; // Initialize an array to store T-shirt products

foreach ($productsWithRatings as $product) {
        $productName = $product["ProductName"];
        $brand = $product["Brand"];
        $price = $product["Price"];
        $genderCategory = $product["Gender"];
        $seasonCategory = $product["Season"];
        $rating = $product["Rating"];

    if ($genderCategory === $_SESSION['user_gender']) {
        // Store the T-shirt product in the $tshirtProducts array
        $filteredProducts[] = [
            "ProductName" => $productName,
            "Brand" => $brand,
            "Price" => $price,
            "Gender" => $genderCategory,
            "Season" => $seasonCategory,
            "Rating" => $rating
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Platform</title>
</head>
<body>
    <h1>E-commerce Platform</h1>

    <h2>All Products</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li><?= $product['name'] ?> - $<?= $product['price'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Recommended Products</h2>
    <ul>
        <?php foreach ($recommendedProducts as $product): ?>
            <li><?= $product['name'] ?> - $<?= $product['price'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<main>
            <section class="products-section">
            <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/6.jpg" alt="Product 2">
                <h3><?= $product['name'] ?></h3>
                <p>Description of Product 2. Lorem ipsum dolor sit amet.</p>
                <span>$<?= $product['price'] ?></span>
                <button>Add to Cart</button>
            </div>
        <?php endforeach; ?>
            </section>
        </main>
