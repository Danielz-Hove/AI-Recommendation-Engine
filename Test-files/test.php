<?php 
require_once 'vendor/autoload.php';

use openCF\RecommenderService;


$dataset = [
    "squid" => [
        "user1" => 1,
        "user2" => 1,
        "user3" => 0.2,
    ],
    "cuttlefish" => [
        "user1" => 0.5,
        "user3" => 0.4,
        "user4" => 0.9,
    ],
    "octopus" => [
        "user1" => 0.2,
        "user2" => 0.5,
        "user3" => 1,
        "user4" => 0.4,
    ],
    "nautilus" => [
        "user2" => 0.2,
        "user3" => 0.4,
        "user4" => 0.5,
    ],
];

// Create an instance
$recommenderService = new RecommenderService($dataset);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<section class="products-section">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
                <h3><?= $product['ProductName'] ?></h3>
                <p>Lorem ipsum dolor sit amet.</p>
                <span>$<?= $product['price'] ?></span>
                <br><button>Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </section>