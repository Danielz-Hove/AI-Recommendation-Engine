<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
include "db.php";
require 'season.php';

require_once 'vendor/autoload.php';

use OpenCF\RecommenderService;

use function PHPSTORM_META\type;


$db = new mysqli('localhost', 'danielz', '1234', 'web2');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// Assuming you have already connected to your database

// Execute SQL query
$sql = "SELECT cw.ProductName, ur.UserID, ur.UserRating
            FROM clothingwear2 cw
            LEFT JOIN userrating2 ur ON cw.ProductID = ur.ProductID
            ORDER BY cw.ProductID, ur.UserID, ur.UserRating";

$result = mysqli_query($db, $sql);
// Initialize associative array to store results
$productRatings = array();

// Fetch associative array
while ($row = mysqli_fetch_assoc($result)) {
    $productName = $row['ProductName'];
    $userID = $row['UserID'];
    $userRating = $row['UserRating'];
    
    // If the product is not already in the array, create a new sub-array
    if (!isset($productRatings[$productName])) {
        $productRatings[$productName] = array();
    }
    
    // Add user rating to the product's sub-array
    $productRatings[$productName][$userID] = $userRating;
}

// Free result set
mysqli_free_result($result);

// Close connection
//mysqli_close($db);

// Print the associative array for demonstration

// Create an instance
$recommenderService = new RecommenderService($productRatings);

// Retrieve a recommender (Weighted Slopeone)
$recommender = $recommenderService->weightedSlopeone();


// SQL query to retrieve the last entry
$sql = "SELECT * FROM purchasehistory ORDER BY ID DESC LIMIT 1";

// Execute query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the last entry as an associative array
    $row = $result->fetch_assoc();
    // Output the last entry
    $userlog_rating = $row['rating'];
    $userlog_item = $row['item'];
    $userlog_brand = $row['brand'];
} else {
    $userlog_rating = 2;
    $userlog_item = "Coat";
    $userlog_brand = "Adidas";
}

// Predict future ratings
$ratings = $recommender->predict([$userlog_item =>$userlog_rating]);

// Assuming you have already connected to your MySQL database

// Sort the $results array based on the values
uasort($ratings, function($a, $b) {
    if ($a === $b) {
        return 0;
    }
    return ($a < $b) ? 1 : -1; // Sort in descending order
});
// Retrieve data from clothing_wear_2 table
$query = "SELECT ProductName, gender_category, season_category, brand, price FROM clothingwear2";
$result = mysqli_query($conn, $query);
// Initialize an empty array to store products and ratings
$productsWithRatings = array();

// Process the results
if (mysqli_num_rows($result) > 0) {
    echo "<div class='product-container'>"; // Start container
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $productName = $row["ProductName"];
        $genderCategory = $row["gender_category"];
        $seasonCategory = $row["season_category"];
        $brand = $row["brand"];
        $price = $row["price"];

        // Check if the product name exists in the ratings array
        if (array_key_exists($productName, $ratings)) {
            $rating = $ratings[$productName];
        } else {
            $rating = 2.1; // Default rating if not found
        }

        // Store the product with its rating in the array
        $productsWithRatings[] = array(
            "ProductName" => $productName,
            "Gender" => $genderCategory,
            "Season" => $seasonCategory,
            "Brand" => $brand,
            "Price" => $price,
            "Rating" => $rating
        );
    }
}
// Define the comparison function
function sortByRating($a, $b) {
    return $a["Rating"] < $b["Rating"]; // Change the comparison operator according to your sorting preference
}

// Sort the array using the comparison function
usort($productsWithRatings, "sortByRating");

// Filters
$filteredProducts1 = []; // Initialize an array to store T-shirt products
$filteredProducts2 = [];
$filteredProducts3 = [];
$filteredProducts4 = [];

    // Get the current month
    $current_month = strtolower(date('F'));
    // Determine the season using the function from seasons.php
    $current_season = get_season($current_month);

foreach ($productsWithRatings as $product) {
        $productName = $product["ProductName"];
        $brand = $product["Brand"];
        $price = $product["Price"];
        $genderCategory = $product["Gender"];
        $seasonCategory = $product["Season"];
        $rating = $product["Rating"];

    if ($productName === $userlog_item) {
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
    if ($genderCategory === $_SESSION['user_gender'] || $genderCategory === "Unisex") {
        // Store the T-shirt product in the $tshirtProducts array
        $filteredProducts2[] = [
            "ProductName" => $productName,
            "Brand" => $brand,
            "Price" => $price,
            "Gender" => $genderCategory,
            "Season" => $seasonCategory,
            "Rating" => $rating
        ];
    }

    if ($genderCategory === $_SESSION['user_gender'] && $seasonCategory ===  $current_season) {
        // Store the T-shirt product in the $tshirtProducts array
        $filteredProducts3[] = [
            "ProductName" => $productName,
            "Brand" => $brand,
            "Price" => $price,
            "Gender" => $genderCategory,
            "Season" => $seasonCategory,
            "Rating" => $rating
        ];
    }
    if ($brand === $userlog_brand && $genderCategory === $_SESSION['user_gender']) {
        // Store the T-shirt product in the $tshirtProducts array
        $filteredProducts4[] = [
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
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <header>

        <h1>E-Sell</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Contact</a></li>
                <li style="float:right; font-size: 12px"><a href="logout.php">Logout</a></li>
                <li style="float:right;"><?php echo $_SESSION['username']; ?></li>
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
    <section class="section">
  <h1>Welcome User <?php echo $_SESSION['username']; ?> </h1>
  <br><h4>You get to browse through products catered just for you using our recommendation engine </h4><br>
  <a href="purchasehistory.php?UserName=<?php echo $_SESSION["username"]; ?>" class="banner_btn">Purchase History</a>

</section><br><br>
<?php
        // Check if a success message exists in the URL (e.g., after redirection)
        if(isset($_GET['success']) && $_GET['success'] == 'true') {

            echo "<p style='color : green; padding-left : 10px';>Success</p>";
        }
        ?>
<!--Item--> 
<br><br><h1 style="text-align: left; margin-left:10px; background-color: black; display:inline; color : white; padding : 5px;">Recommendations<span style="font-size: 12px; font-weight: 100;"> According to items last bought</span></h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($filteredProducts as $product): ?>
        <?php 
        
        $productName = $product["ProductName"];
        $ratings = $product["Rating"]; 
        $brand = $product["Brand"];
        ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['Brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span><?php echo "$".$product['Price'] ?></span><br>
            <?php 
                 $rating = round($ratings);
                 for ($i = 1; $i <= 5; $i++) {
                     if ($i <= $rating) {
                         echo '<span class="filled">&#9733;</span>'; // Filled star for rating
                     } else {
                             echo '<span>&#9734;</span>'; // Empty star for no rating
                      }
                   }
            ?>
            <?php 
                // Add to Cart button with product information
                echo "<br><a href='Rating.php?brand=$brand&productName=$productName&UserName=" . $_SESSION["username"] . "'><button>Add to Cart</button></a>";
            ?>
        </div>
        <?php $count++; ?>
        <?php if ($count % 8 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<!--Gender-->
<br><br><h1 style="text-align: left; margin-left:10px; background-color: black; display:inline; color : white; padding : 5px;"><?php echo $_SESSION['user_gender']?><span style="font-size: 12px; font-weight: 100;"> Cloths</span></h1><br><hr width="25%">

    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($filteredProducts2 as $product): ?>
        <?php 
        
        $productName = $product["ProductName"];
        $ratings = $product["Rating"]; 
        $brand = $product["Brand"];
        ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['Brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span><?php echo "$".$product['Price'] ?></span><br>
            <?php 
                 $rating = round($ratings);
                 for ($i = 1; $i <= 5; $i++) {
                     if ($i <= $rating) {
                         echo '<span class="filled">&#9733;</span>'; // Filled star for rating
                     } else {
                             echo '<span>&#9734;</span>'; // Empty star for no rating
                      }
                   }
            ?>
            <?php 
                // Add to Cart button with product information
                echo "<br><a href='Rating.php?brand=$brand&productName=$productName&UserName=" . $_SESSION["username"] . "'><button>Add to Cart</button></a>";
            ?>
        </div>
        <?php $count++; ?>
        <?php if ($count % 8 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<!--Season-->
<br><br><h1 style="text-align: left; margin-left:10px; background-color: black; display:inline; color : white; padding : 5px;">Season Wear<span style="font-size: 12px; font-weight: 100;"><?php echo $current_season ?></span></h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($filteredProducts3 as $product): ?>
        <?php 
        
        $productName = $product["ProductName"];
        $ratings = $product["Rating"];
        $brand = $product["Brand"];
        ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['Brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span><?php echo "$".$product['Price'] ?></span><br>
            <?php 
                 $rating = round($ratings);
                 for ($i = 1; $i <= 5; $i++) {
                     if ($i <= $rating) {
                         echo '<span class="filled">&#9733;</span>'; // Filled star for rating
                     } else {
                             echo '<span>&#9734;</span>'; // Empty star for no rating
                      }
                   }
            ?>
            <?php 
                // Add to Cart button with product information
                echo "<br><a href='Rating.php?brand=$brand&productName=$productName&UserName=" . $_SESSION["username"] . "'><button>Add to Cart</button></a>";
            ?>
        </div>
        <?php $count++; ?>
        <?php if ($count % 8 == 0): break; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
</main>
<!--End-->
<!--Brand-->
<br><br><h1 style="text-align: left; margin-left:10px; background-color: black; display:inline; color : white; padding : 5px;"><?php echo $userlog_brand ?> <span style="font-size: 12px; font-weight: 100;">Brand</span></h1><br><hr width="25%">
    <main>
    <section class="products-section">
    <?php $count = 0; ?>
    <?php foreach ($filteredProducts4 as $product): ?>
        <?php 
        
        $productName = $product["ProductName"];
        $ratings = $product["Rating"];
        $brand = $product["Brand"];
        ?>
        <div class="product">
            <img src="images/6.jpg" alt="<?= $product['ProductName'] ?>">
            <h3><sub style="font-size: 18px;"><?= $product['ProductName']?></sub><sup style="margin-left: 5px; background-color : blue ; padding : 5px; color : white"><?= $product['Brand']?></sup></h3>
            <p>Lorem ipsum dolor sit amet.</p>
            <span><?php echo "$".$product['Price'] ?></span><br>
            <?php 
                 $rating = round($ratings);
                 for ($i = 1; $i <= 5; $i++) {
                     if ($i <= $rating) {
                         echo '<span class="filled">&#9733;</span>'; // Filled star for rating
                     } else {
                             echo '<span>&#9734;</span>'; // Empty star for no rating
                      }
                   }
            ?>
            <?php 
                // Add to Cart button with product information
                echo "<br><a href='Rating.php?brand=$brand&productName=$productName&UserName=" . $_SESSION["username"] . "'><button>Add to Cart</button></a>";
            ?>
        </div>
        <?php $count++; ?>
        <?php if ($count % 8 == 0): break; ?>
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
