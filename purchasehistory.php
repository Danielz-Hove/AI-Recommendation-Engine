<?php
include "db.php";

$UserName = $_GET['UserName'] ?? '';

// SQL query
$sql = "SELECT * FROM purchasehistory WHERE userName = '$UserName' ORDER BY ID DESC";

// Execute query
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query failed
    echo "Error: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($result) > 0) {
        // Start table with CSS styling for border
        echo "<br><table style='width: 50%; border-collapse: collapse; border: 2px solid #ddd;'>";
        echo "<tr><th style='border: 2px solid #ddd;'>ID</th><th style='border: 2px solid #ddd;'>Name</th><th style='border: 2px solid #ddd;'>Item</th><th style='border: 2px solid #ddd;'>Rating</th><th style='border: 2px solid #ddd;'>Brand</th></tr>";

        // Fetch and display results
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td style='border: 2px solid #ddd;'>" . $row['ID'] . "</td>";
            echo "<td style='border: 2px solid #ddd;'>" . $row['userName'] . "</td>";
            echo "<td style='border: 2px solid #ddd;'>" . $row['item'] . "</td>";
            echo "<td style='border: 2px solid #ddd;'>" . $row['rating'] . "</td>";
            echo "<td style='border: 2px solid #ddd;'>" . $row['brand'] . "</td>";
            echo "</tr>";
        }

        // End table
        echo "</table>";
    } else {
        // No records found
        echo "No purchase history found for this user.";
    }
}

    // Free result set
    mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br><a href="home.php">back</a>
</body>
</html>