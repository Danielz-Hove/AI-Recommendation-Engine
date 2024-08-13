<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
include "db.php";
/*
function getProducts() {
    global $db;
    $result = $db->query("SELECT * FROM products");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRecommendedProducts($userId) {
    $db = new mysqli('localhost', 'danielz', '1234', 'web2');
    // Simulated recommendation logic (replace this with a real recommendation engine)
    $recommendedIds = [1, 3]; // Example: Recommending products with IDs 1 and 3
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
*/

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
} else {
    $userlog_rating = 4;
    $userlog_item = "Coat";
}

// Predict future ratings
$ratings = $recommender->predict([ $userlog_item =>$userlog_rating]);

// Assuming you have already connected to your MySQL database

// Retrieve data from clothing_wear_2 table
$query = "SELECT ProductName, gender_category, season_category, brand, price FROM clothingwear2";
$result = mysqli_query($conn, $query);


// Process the results
if (mysqli_num_rows($result) > 0) {
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
            $rating = 2.1;
        }

        // Now you can use the retrieved data and the rating as needed
        echo "Product: $productName, Gender: $genderCategory, Season: $seasonCategory, Brand: $brand, Price: $price, Rating: $rating <br>";
    }
} else {
    echo "No results found";
}

// Free result set
mysqli_free_result($result);

// Sort the $results array based on the values
uasort($ratings, function($a, $b) {
    if ($a === $b) {
        return 0;
    }
    return ($a < $b) ? 1 : -1; // Sort in descending order
});

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
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
</style>
    <section class="section">
  <h1>Welcome User <?php echo $_SESSION['username']; ?> </h1>
  <br><h4>You get to browse through products catered just for you using our recommendation engine </h4><br>
  <a href="purchasehistory.php?UserName=<?php echo $_SESSION["username"]; ?>" class="banner_btn">Purchase History</a>

</section>

<br><br><h1 style="padding-left: 10px;">Recomended Products</h1><br><br>
<?php
        // Check if a success message exists in the URL (e.g., after redirection)
        if(isset($_GET['success']) && $_GET['success'] == 'true') {

            echo "<p style='color : green; padding-left : 10px';>Success</p>";
        }
        ?>
<!--Gender-->

<!--End-->
<footer>
        <p>&copy; 2024 E-commerce Website. All rights reserved.</p>
    </footer>
</body>
</html>
