<?php
include "db.php";
// Retrieve product name and price from query parameters
$productName = $_GET['productName'] ?? '';
$UserName = $_GET['UserName'] ?? '';
$brand =  $_GET['brand'] ?? '';

// Prepare SQL query
$sql = "SELECT ProductID FROM clothingwear2 WHERE ProductName = ?";

// Prepare statement
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameters
    $stmt->bind_param("s", $productName);

    // Execute statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($productId);

    // Fetch result
    $stmt->fetch();

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing SQL statement: " . $conn->error;
}

// Prepare SQL query
$sql2 = "SELECT id FROM users WHERE username = ?";

// Prepare statement
$stmt = $conn->prepare($sql2);
if ($stmt) {
    // Bind parametersx
    $stmt->bind_param("s", $UserName);

    // Execute statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($UserID);

    // Fetch result
    $stmt->fetch();

    // Close statement
    $stmt->close();

} else {
    echo "Error preparing SQL statement: " . $conn->error;
}
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data submitted through the form
    $rating = $_POST['rating']; // Assuming you have a form field named 'rating'
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $user_name = $_POST['user_name'];
    $product_name = $_POST['product_name'];
    $product_brand = $_POST['brand'];


    // Now you can use the $rating variable to process or store the data as needed

    // SQL query to insert a new row into the table
    $sql = "INSERT INTO userrating2 (ProductID, UserID, UserRating) VALUES ('$product_id', '$user_id', '$rating')";
    echo $productbrand . "<br>";
    $sql2 = "INSERT INTO purchasehistory (userName,productID,item,rating,brand) VALUES ('$user_name','$product_id','$product_name', '$rating','$product_brand')";
    // Execute the query
    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE ) {
        echo "New record created successfully";
        header("Location: home.php?success=true");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Handle the case where the form has not been submitted
    echo "Form not submitted.";
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Rating Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    input[readonly] {
        background-color: #f0f0f0;
    }

    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M5.3 6.7l4.9 4.9 4.9-4.9c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-5.3 5.3c-.2.2-.4.3-.7.3s-.5-.1-.7-.3L3.9 8.1c-.4-.4-.4-1 0-1.4.4-.4 1-.4 1.4 0z'/%3E%3C/svg%3E") no-repeat right 10px center/15px auto;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Rate the Product</h2>
    <form action="Rating.php" method="POST">

        <input type="text" id="user_id" name="user_name" readonly value=<?php echo $UserName ?>>
        <input type="text" id="user_id" name="user_id" readonly value=<?php echo $UserID ?> hidden>
        <h3>Items</h3>
        <input type="text" id="product_id" name="product_name"  readonly value=<?php echo $productName ?>>
        <input type="text" id="product_id" name="product_id"  readonly value=<?php echo $productId ?> hidden>
        <input type="text" id="brand" name="brand" readonly value="<?php echo $brand ?>" hidden>


        
        <label for="rating">Rating:</label>
        <select id="rating" name="rating" required>
            <option value="">Select Rating</option>
            <option value="1">1 (Poor)</option>
            <option value="2">2 (Fair)</option>
            <option value="3">3 (Average)</option>
            <option value="4">4 (Good)</option>
            <option value="5">5 (Excellent)</option>
        </select>

        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>