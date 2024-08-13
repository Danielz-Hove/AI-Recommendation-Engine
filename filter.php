<?php 
function getProductsFemale() {
    global $conn;
    $gender = 'Female';
    $result = $conn->query("SELECT * FROM clothingwear2 WHERE gender_category = '$gender'");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductsSeason($currentSeason) {
    global $conn;
    $result = $conn->query("SELECT * FROM clothingwear2 WHERE season_category = '$currentSeason'");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductsMale() {
    global $conn;
    $gender = 'Male';
    $result = $conn->query("SELECT * FROM clothingwear2 WHERE gender_category = '$gender'");
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>