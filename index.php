<?php
include "db.php";
// Include the seasons.php file
require 'season.php';
require 'filter.php';
// Check if the user is logged in
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $login_status = 'Logged in as ' . $_SESSION['username'];
    $logout_link = '<a href="logout.php">Logout</a>';
} else {
    $login_status = 'Not logged in';
    $logout_link = '';
}


// Get the current month
$current_month = strtolower(date('F'));

// Determine the season using the function from seasons.php
$current_season = get_season($current_month);

$Seasonproducts = getProductsSeason($current_season);
$Femaleproducts = getProductsFemale();
$Maleproducts = getProductsMale();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <header>
        <h1>E-Sell</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li style="float:right;"><?php echo $login_status; ?></li>
                <li style="float:right;"><?php echo $logout_link; ?></li>

            </ul>
        </nav>
    </header>
    <style>
  .section {
    background: black;
    color: white;
    height: 250px;
    padding: 70px;
    margin: 0 auto; /* Centers the section horizontally */
    vertical-align: middle;
  }
  .banner_btn{
    color: white;
    background-color: red;
    padding: 10px;
    font-size: 16px;
    text-decoration: none;
  }
</style>
    <section class="section">
  <h1>Welcome New User</h1>
  <br><h3>Login to enhance your experience</h3><br>
  <a href="login.php" class="banner_btn">login</a>
  <a href="register.php" class="banner_btn">signup</a>
</section>
    <style>
    .product {
    display: inline-block;
    width: 20%; /* Adjust width as needed */
    margin: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
    }
    .product img {
        max-width: 100%;
        height: auto;
    }
    .product button{

        background-color: black;
        color: white;
        padding: 5px;
    }
    
    .carousel-container {
        width: 50%;
        float: left;
        overflow: hidden;
    }
    .carousel {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
    }
    .product {
        flex: 0 0 auto;
        margin-right: 20px;
        scroll-snap-align: start;
    }
    </style>
    <!--Season-->
    <br><br><h1 style="text-align: left; margin-left:10px"><?php echo $current_season ." Sales" ?></h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($Seasonproducts as $product): ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span>$<?= $product['price'] ?></span>
            <br><button>Add to Cart</button>
        </div>
        <?php $count++; ?>
        <?php if ($count % 4 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<!--Female-->
<br><br><h1 style="text-align: left; margin-left:10px">Female Sales</h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($Femaleproducts as $product): ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span>$<?= $product['price'] ?></span>
            <br><button>Add to Cart</button>
        </div>
        <?php $count++; ?>
        <?php if ($count % 4 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<!--Male-->
<br><br><h1 style="text-align: left; margin-left:10px">Male Sales</h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($Maleproducts as $product): ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span>$<?= $product['price'] ?></span>
            <br><button>Add to Cart</button>
        </div>
        <?php $count++; ?>
        <?php if ($count % 4 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<footer>
    <div class="footer-content">
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 E-Sell. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
