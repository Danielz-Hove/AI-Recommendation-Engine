CREATE TABLE userrating2 (
    ratingID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT,
    UserID INT,
    UserRating INT,
    FOREIGN KEY (ProductID) REFERENCES clothingwear2(ProductID)
);
/////

-- Set the minimum number of ratings you want
SET @min_ratings = 300;

-- Loop until the minimum number of ratings is reached
WHILE (SELECT COUNT(*) FROM userrating2) < @min_ratings DO
    -- Generate a single random rating
    INSERT INTO userrating2 (user_id, item_id, rating)
    SELECT 
        FLOOR(RAND() * 100) + 1 AS user_id,  -- Assuming user IDs range from 1 to 100
        FLOOR(RAND() * 50) + 1 AS item_id,   -- Assuming item IDs range from 1 to 50
        FLOOR(RAND() * 5) + 1 AS rating;
END WHILE;

//////

CREATE TABLE clothingwear2 (
    ProductID INT(11) PRIMARY KEY,
    ProductName VARCHAR(255) NOT NULL,
    gender_category ENUM('Male', 'Female', 'Unisex') NOT NULL,
    season_category ENUM('Spring', 'Summer', 'Fall', 'Winter') NOT NULL,
    brand ENUM('Nike', 'Adidas', 'Gucci', 'Zara') NOT NULL,
    price DECIMAL(10, 2),
);

///////
INSERT INTO clothingwear2 (ProductID, ProductName, gender_category, season_category, brand, price) 
VALUES 
(1, 'T-Shirt', 'Male', 'Spring', 'Nike', 25.99),
(2, 'Hoodie', 'Male', 'Fall', 'Adidas', 49.99),
(3, 'Jeans', 'Male', 'Winter', 'Zara', 39.99),
(4, 'Sneakers', 'Male', 'Summer', 'Nike', 79.99),
(5, 'Dress', 'Female', 'Summer', 'Zara', 59.99),
(6, 'Skirt', 'Female', 'Spring', 'Zara', 34.99),
(7, 'Coat', 'Female', 'Winter', 'Gucci', 299.99),
(8, 'Leggings', 'Female', 'Fall', 'Nike', 45.99),
(9, 'Scarf', 'Unisex', 'Winter', 'Adidas', 19.99),
(10, 'Beanie', 'Unisex', 'Fall', 'Nike', 15.99),
(11, 'Tank Top', 'Unisex', 'Summer', 'Adidas', 29.99),
(12, 'Shorts', 'Male', 'Summer', 'Zara', 39.99),
(13, 'Jacket', 'Male', 'Fall', 'Nike', 89.99),
(14, 'Sweater', 'Male', 'Winter', 'Adidas', 69.99),
(15, 'Blouse', 'Female', 'Spring', 'Gucci', 89.99),
(16, 'Pants', 'Female', 'Winter', 'Zara', 49.99),
(17, 'Sandals', 'Female', 'Summer', 'Adidas', 39.99),
(18, 'Cap', 'Unisex', 'Spring', 'Nike', 24.99),
(19, 'Coat', 'Unisex', 'Winter', 'Zara', 179.99),
(20, 'Gloves', 'Unisex', 'Fall', 'Gucci', 39.99),
(21, 'Shirt', 'Male', 'Spring', 'Adidas', 35.99),
(22, 'Dress', 'Female', 'Summer', 'Gucci', 179.99),
(23, 'Skirt', 'Female', 'Fall', 'Nike', 44.99),
(24, 'Jeans', 'Female', 'Winter', 'Zara', 54.99),
(25, 'Sneakers', 'Female', 'Summer', 'Adidas', 69.99),
(26, 'Hoodie', 'Male', 'Fall', 'Nike', 59.99),
(27, 'T-Shirt', 'Male', 'Spring', 'Adidas', 29.99),
(28, 'Jacket', 'Male', 'Winter', 'Zara', 99.99),
(29, 'Coat', 'Female', 'Winter', 'Zara', 249.99),
(30, 'Dress', 'Female', 'Spring', 'Zara', 69.99),
(31, 'Blouse', 'Female', 'Summer', 'Nike', 49.99),
(32, 'Jeans', 'Female', 'Fall', 'Adidas', 59.99),
(33, 'Sneakers', 'Female', 'Winter', 'Gucci', 129.99),
(34, 'Shorts', 'Male', 'Summer', 'Nike', 34.99),
(35, 'T-Shirt', 'Male', 'Spring', 'Zara', 19.99),
(36, 'Sweater', 'Male', 'Fall', 'Adidas', 79.99),
(37, 'Pants', 'Male', 'Winter', 'Nike', 64.99),
(38, 'Sneakers', 'Male', 'Summer', 'Gucci', 149.99),
(39, 'Blouse', 'Female', 'Spring', 'Adidas', 54.99),
(40, 'Skirt', 'Female', 'Fall', 'Zara', 39.99),
(41, 'Coat', 'Female', 'Winter', 'Nike', 219.99),
(42, 'Dress', 'Female', 'Summer', 'Nike', 79.99),
(43, 'Jeans', 'Female', 'Fall', 'Gucci', 99.99),
(44, 'Sneakers', 'Female', 'Winter', 'Zara', 89.99),
(45, 'T-Shirt', 'Unisex', 'Spring', 'Nike', 27.99),
(46, 'Hoodie', 'Unisex', 'Fall', 'Adidas', 69.99),
(47, 'Jeans', 'Unisex', 'Winter', 'Zara', 49.99),
(48, 'Sneakers', 'Unisex', 'Summer', 'Gucci', 159.99),
(49, 'Dress', 'Unisex', 'Summer', 'Adidas', 99.99),
(50, 'Skirt', 'Unisex', 'Spring', 'Nike', 49.99),
(51, 'Coat', 'Unisex', 'Winter', 'Zara', 199.99),
(52, 'Jeans', 'Unisex', 'Fall', 'Nike', 69.99),
(53, 'Sneakers', 'Unisex', 'Winter', 'Adidas', 109.99),
(54, 'Jacket', 'Male', 'Spring', 'Zara', 79.99),
(55, 'Shorts', 'Male', 'Summer', 'Adidas', 29.99),
(56, 'T-Shirt', 'Male', 'Fall', 'Gucci', 39.99),
(57, 'Sweater', 'Male', 'Winter', 'Nike', 99.99),
(58, 'Blouse', 'Female', 'Spring', 'Zara', 49.99),
(59, 'Skirt', 'Female', 'Summer', 'Nike', 59.99),
(60, 'Coat', 'Female', 'Fall', 'Adidas', 169.99);
