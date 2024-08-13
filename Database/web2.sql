-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 12:02 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GenerateRandomRatings` ()   BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE product_count INT DEFAULT 30;
    DECLARE user_count INT DEFAULT 10;
    DECLARE max_rating INT DEFAULT 5;
    DECLARE product_id INT;
    DECLARE user_id INT;
    DECLARE rating INT;
    
    WHILE i < product_count DO
        SET i = i + 1;
        SET product_id = i;
        SET user_id = 1;
        
        WHILE user_id <= user_count DO
            SET rating = FLOOR(RAND() * max_rating) + 1;
            INSERT INTO UserRatings (ProductID, UserID, UserRating) VALUES (product_id, user_id, rating);
            SET user_id = user_id + 1;
        END WHILE;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertRandomRatings` ()   BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE remaining INT DEFAULT 500;
    
    WHILE i < 500 DO
        INSERT INTO userrating2 (ProductID, UserID, UserRating)
        SELECT 
            cw.ProductID,
            FLOOR(RAND() * 100) + 1 AS UserID,
            FLOOR(RAND() * 5) + 1 AS UserRating
        FROM
            clothingwear2 cw
        LEFT JOIN (
            SELECT ProductID, COUNT(*) AS NumRatings
            FROM userrating2
            GROUP BY ProductID
        ) ur ON cw.ProductID = ur.ProductID
        WHERE
            ur.NumRatings < 5 OR ur.NumRatings IS NULL
        ORDER BY
            cw.ProductID
        LIMIT remaining; -- Limit to the remaining number of ratings to reach 500
        
        SET i = i + ROW_COUNT(); -- Update the counter with the number of rows inserted
        SET remaining = 500 - i; -- Update the remaining number of ratings
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `clothingwear`
--

CREATE TABLE `clothingwear` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `price` decimal(55,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clothingwear`
--

INSERT INTO `clothingwear` (`ProductID`, `ProductName`, `price`) VALUES
(1, 'T-shirt', '15'),
(2, 'Jeans', '20'),
(3, 'Sweater', '25'),
(4, 'Dress Shirt', '20'),
(5, 'Skirt', '15'),
(6, 'Jacket', '30'),
(7, 'Hoodie', '40'),
(8, 'Shorts', '15'),
(9, 'Dress', '20'),
(10, 'Blouse', '20'),
(11, 'Pants', '10'),
(12, 'Coat', '50'),
(13, 'Cardigan', '25'),
(14, 'Leggings', '10'),
(15, 'Vest', '15'),
(16, 'Sweatshirt', '20'),
(17, 'Suit', '100'),
(18, 'Tie', '5'),
(19, 'Scarf', '10'),
(20, 'Gloves', '10'),
(21, 'Socks', '5'),
(22, 'Hat', '10'),
(23, 'Shoe', '10'),
(24, 'Trousers', '15'),
(25, 'Pajamas', '20'),
(26, 'Swimsuit', '20'),
(27, 'Underwear', '10'),
(28, 'Robe', '20'),
(29, 'Tank Top', '10'),
(30, 'Polo Shirt', '15');

-- --------------------------------------------------------

--
-- Table structure for table `clothingwear2`
--

CREATE TABLE `clothingwear2` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `gender_category` enum('Male','Female','Unisex') NOT NULL,
  `season_category` enum('Spring','Summer','Fall','Winter') NOT NULL,
  `brand` enum('Nike','Adidas','Gucci','Zara') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clothingwear2`
--

INSERT INTO `clothingwear2` (`ProductID`, `ProductName`, `gender_category`, `season_category`, `brand`, `price`) VALUES
(1, 'T-Shirt', 'Male', 'Spring', 'Nike', '25.99'),
(2, 'Hoodie', 'Male', 'Fall', 'Adidas', '49.99'),
(3, 'Jeans', 'Male', 'Winter', 'Zara', '39.99'),
(4, 'Sneakers', 'Male', 'Summer', 'Nike', '79.99'),
(5, 'Dress', 'Female', 'Summer', 'Zara', '59.99'),
(6, 'Skirt', 'Female', 'Spring', 'Zara', '34.99'),
(7, 'Coat', 'Female', 'Winter', 'Gucci', '299.99'),
(8, 'Leggings', 'Female', 'Fall', 'Nike', '45.99'),
(9, 'Scarf', 'Unisex', 'Winter', 'Adidas', '19.99'),
(10, 'Beanie', 'Unisex', 'Fall', 'Nike', '15.99'),
(11, 'Tank Top', 'Unisex', 'Summer', 'Adidas', '29.99'),
(12, 'Shorts', 'Male', 'Summer', 'Zara', '39.99'),
(13, 'Jacket', 'Male', 'Fall', 'Nike', '89.99'),
(14, 'Sweater', 'Male', 'Winter', 'Adidas', '69.99'),
(15, 'Blouse', 'Female', 'Spring', 'Gucci', '89.99'),
(16, 'Pants', 'Female', 'Winter', 'Zara', '49.99'),
(17, 'Sandals', 'Female', 'Summer', 'Adidas', '39.99'),
(18, 'Cap', 'Unisex', 'Spring', 'Nike', '24.99'),
(19, 'Coat', 'Unisex', 'Winter', 'Zara', '179.99'),
(20, 'Gloves', 'Unisex', 'Fall', 'Gucci', '39.99'),
(21, 'Shirt', 'Male', 'Spring', 'Adidas', '35.99'),
(22, 'Dress', 'Female', 'Summer', 'Gucci', '179.99'),
(23, 'Skirt', 'Female', 'Fall', 'Nike', '44.99'),
(24, 'Jeans', 'Female', 'Winter', 'Zara', '54.99'),
(25, 'Sneakers', 'Female', 'Summer', 'Adidas', '69.99'),
(26, 'Hoodie', 'Male', 'Fall', 'Nike', '59.99'),
(27, 'T-Shirt', 'Male', 'Spring', 'Adidas', '29.99'),
(28, 'Jacket', 'Male', 'Winter', 'Zara', '99.99'),
(29, 'Coat', 'Female', 'Winter', 'Zara', '249.99'),
(30, 'Dress', 'Female', 'Spring', 'Zara', '69.99'),
(31, 'Blouse', 'Female', 'Summer', 'Nike', '49.99'),
(32, 'Jeans', 'Female', 'Fall', 'Adidas', '59.99'),
(33, 'Sneakers', 'Female', 'Winter', 'Gucci', '129.99'),
(34, 'Shorts', 'Male', 'Summer', 'Nike', '34.99'),
(35, 'T-Shirt', 'Male', 'Spring', 'Zara', '19.99'),
(36, 'Sweater', 'Male', 'Fall', 'Adidas', '79.99'),
(37, 'Pants', 'Male', 'Winter', 'Nike', '64.99'),
(38, 'Sneakers', 'Male', 'Summer', 'Gucci', '149.99'),
(39, 'Blouse', 'Female', 'Spring', 'Adidas', '54.99'),
(40, 'Skirt', 'Female', 'Fall', 'Zara', '39.99'),
(41, 'Coat', 'Female', 'Winter', 'Nike', '219.99'),
(42, 'Dress', 'Female', 'Summer', 'Nike', '79.99'),
(43, 'Jeans', 'Female', 'Fall', 'Gucci', '99.99'),
(44, 'Sneakers', 'Female', 'Winter', 'Zara', '89.99'),
(45, 'T-Shirt', 'Unisex', 'Spring', 'Nike', '27.99'),
(46, 'Hoodie', 'Unisex', 'Fall', 'Adidas', '69.99'),
(47, 'Jeans', 'Unisex', 'Winter', 'Zara', '49.99'),
(48, 'Sneakers', 'Unisex', 'Summer', 'Gucci', '159.99'),
(49, 'Dress', 'Unisex', 'Summer', 'Adidas', '99.99'),
(50, 'Skirt', 'Unisex', 'Spring', 'Nike', '49.99'),
(51, 'Coat', 'Unisex', 'Winter', 'Zara', '199.99'),
(52, 'Jeans', 'Unisex', 'Fall', 'Nike', '69.99'),
(53, 'Sneakers', 'Unisex', 'Winter', 'Adidas', '109.99'),
(54, 'Jacket', 'Male', 'Spring', 'Zara', '79.99'),
(55, 'Shorts', 'Male', 'Summer', 'Adidas', '29.99'),
(56, 'T-Shirt', 'Male', 'Fall', 'Gucci', '39.99'),
(57, 'Sweater', 'Male', 'Winter', 'Nike', '99.99'),
(58, 'Blouse', 'Female', 'Spring', 'Zara', '49.99'),
(59, 'Skirt', 'Female', 'Summer', 'Nike', '59.99'),
(60, 'Coat', 'Female', 'Fall', 'Adidas', '169.99');

-- --------------------------------------------------------

--
-- Table structure for table `purchasehistory`
--

CREATE TABLE `purchasehistory` (
  `ID` int(255) NOT NULL,
  `userName` text NOT NULL,
  `productID` int(11) NOT NULL,
  `item` text NOT NULL,
  `rating` int(11) NOT NULL,
  `brand` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchasehistory`
--

INSERT INTO `purchasehistory` (`ID`, `userName`, `productID`, `item`, `rating`, `brand`) VALUES
(1, 'danielz', 12, 'Shorts', 3, 'Zara'),
(2, 'danielz', 21, 'Shirt', 3, 'Adidas'),
(3, 'danielz', 4, 'Sneakers', 4, 'Gucci'),
(4, 'danielz', 12, 'Shorts', 4, 'Adidas'),
(5, 'danielz', 3, 'Jeans', 3, 'Zara');

-- --------------------------------------------------------

--
-- Table structure for table `userrating2`
--

CREATE TABLE `userrating2` (
  `ratingID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `UserRating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userrating2`
--

INSERT INTO `userrating2` (`ratingID`, `ProductID`, `UserID`, `UserRating`) VALUES
(1, 1, 41, 2),
(2, 2, 83, 3),
(3, 3, 11, 5),
(4, 4, 45, 2),
(5, 5, 64, 5),
(6, 6, 96, 5),
(7, 7, 56, 1),
(8, 8, 83, 5),
(9, 9, 75, 1),
(10, 10, 76, 1),
(11, 11, 64, 4),
(12, 12, 33, 4),
(13, 13, 35, 4),
(14, 14, 66, 1),
(15, 15, 43, 5),
(16, 16, 23, 3),
(17, 17, 43, 5),
(18, 18, 4, 3),
(19, 19, 86, 3),
(20, 20, 85, 4),
(21, 21, 40, 4),
(22, 22, 98, 5),
(23, 23, 89, 3),
(24, 24, 3, 3),
(25, 25, 53, 1),
(26, 26, 79, 4),
(27, 27, 26, 1),
(28, 28, 80, 4),
(29, 29, 87, 2),
(30, 30, 25, 1),
(31, 31, 83, 4),
(32, 32, 43, 4),
(33, 33, 66, 5),
(34, 34, 67, 3),
(35, 35, 68, 4),
(36, 36, 86, 5),
(37, 37, 26, 2),
(38, 38, 11, 2),
(39, 39, 63, 5),
(40, 40, 4, 2),
(41, 41, 100, 2),
(42, 42, 67, 2),
(43, 43, 64, 2),
(44, 44, 14, 1),
(45, 45, 90, 2),
(46, 46, 69, 3),
(47, 47, 91, 4),
(48, 48, 5, 5),
(49, 49, 77, 5),
(50, 50, 15, 1),
(51, 51, 89, 2),
(52, 52, 44, 3),
(53, 53, 33, 1),
(54, 54, 21, 5),
(55, 55, 7, 3),
(56, 56, 43, 3),
(57, 57, 42, 3),
(58, 58, 12, 1),
(59, 59, 48, 5),
(60, 60, 100, 2),
(64, 1, 69, 3),
(65, 2, 6, 5),
(66, 3, 82, 1),
(67, 4, 7, 1),
(68, 5, 84, 1),
(69, 6, 26, 5),
(70, 7, 44, 4),
(71, 8, 98, 5),
(72, 9, 68, 4),
(73, 10, 10, 3),
(74, 11, 61, 2),
(75, 12, 75, 4),
(76, 13, 73, 2),
(77, 14, 9, 4),
(78, 15, 99, 5),
(79, 16, 98, 5),
(80, 17, 59, 2),
(81, 18, 43, 3),
(82, 19, 89, 1),
(83, 20, 86, 5),
(84, 21, 36, 5),
(85, 22, 5, 4),
(86, 23, 62, 5),
(87, 24, 22, 4),
(88, 25, 50, 4),
(89, 26, 59, 1),
(90, 27, 70, 1),
(91, 28, 88, 4),
(92, 29, 37, 3),
(93, 30, 2, 5),
(94, 31, 9, 5),
(95, 32, 45, 3),
(96, 33, 76, 3),
(97, 34, 24, 4),
(98, 35, 80, 5),
(99, 36, 95, 1),
(100, 37, 78, 3),
(101, 38, 31, 5),
(102, 39, 81, 2),
(103, 40, 60, 2),
(104, 41, 99, 5),
(105, 42, 33, 1),
(106, 43, 41, 4),
(107, 44, 75, 2),
(108, 45, 59, 5),
(109, 46, 32, 1),
(110, 47, 83, 4),
(111, 48, 76, 5),
(112, 49, 98, 2),
(113, 50, 69, 3),
(114, 51, 35, 2),
(115, 52, 26, 3),
(116, 53, 88, 4),
(117, 54, 20, 4),
(118, 55, 94, 3),
(119, 56, 3, 3),
(120, 57, 98, 4),
(121, 58, 29, 3),
(122, 59, 68, 5),
(123, 60, 18, 2),
(127, 1, 23, 1),
(128, 2, 69, 2),
(129, 3, 7, 4),
(130, 4, 100, 1),
(131, 5, 31, 2),
(132, 6, 83, 1),
(133, 7, 100, 4),
(134, 8, 45, 1),
(135, 9, 57, 2),
(136, 10, 73, 4),
(137, 11, 77, 3),
(138, 12, 96, 3),
(139, 13, 29, 1),
(140, 14, 74, 2),
(141, 15, 49, 3),
(142, 16, 65, 5),
(143, 17, 81, 1),
(144, 18, 47, 5),
(145, 19, 70, 1),
(146, 20, 99, 5),
(147, 21, 46, 4),
(148, 22, 81, 1),
(149, 23, 15, 3),
(150, 24, 61, 5),
(151, 25, 20, 3),
(152, 26, 25, 3),
(153, 27, 92, 5),
(154, 28, 20, 1),
(155, 29, 44, 1),
(156, 30, 61, 3),
(157, 31, 51, 1),
(158, 32, 8, 1),
(159, 33, 95, 4),
(160, 34, 24, 2),
(161, 35, 7, 2),
(162, 36, 5, 3),
(163, 37, 22, 4),
(164, 38, 75, 4),
(165, 39, 12, 3),
(166, 40, 50, 4),
(167, 41, 36, 3),
(168, 42, 23, 4),
(169, 43, 7, 1),
(170, 44, 23, 5),
(171, 45, 73, 5),
(172, 46, 73, 4),
(173, 47, 19, 5),
(174, 48, 6, 3),
(175, 49, 43, 3),
(176, 50, 65, 3),
(177, 51, 31, 1),
(178, 52, 3, 3),
(179, 53, 81, 2),
(180, 54, 4, 2),
(181, 55, 37, 5),
(182, 56, 66, 3),
(183, 57, 17, 3),
(184, 58, 33, 5),
(185, 59, 61, 2),
(186, 60, 56, 5),
(190, 1, 12, 4),
(191, 2, 27, 1),
(192, 3, 98, 3),
(193, 4, 16, 3),
(194, 5, 19, 2),
(195, 6, 8, 3),
(196, 7, 87, 1),
(197, 8, 69, 2),
(198, 9, 26, 3),
(199, 10, 62, 4),
(200, 11, 48, 2),
(201, 12, 46, 1),
(202, 13, 30, 1),
(203, 14, 64, 5),
(204, 15, 29, 5),
(205, 16, 79, 1),
(206, 17, 40, 3),
(207, 18, 48, 4),
(208, 19, 47, 5),
(209, 20, 50, 3),
(210, 21, 31, 5),
(211, 22, 23, 4),
(212, 23, 62, 1),
(213, 24, 61, 4),
(214, 25, 90, 2),
(215, 26, 54, 5),
(216, 27, 20, 1),
(217, 28, 85, 5),
(218, 29, 24, 2),
(219, 30, 92, 3),
(220, 31, 24, 2),
(221, 32, 17, 4),
(222, 33, 97, 4),
(223, 34, 93, 2),
(224, 35, 85, 2),
(225, 36, 83, 2),
(226, 37, 95, 5),
(227, 38, 62, 2),
(228, 39, 10, 2),
(229, 40, 25, 2),
(230, 41, 81, 1),
(231, 42, 11, 2),
(232, 43, 76, 1),
(233, 44, 33, 2),
(234, 45, 35, 5),
(235, 46, 67, 3),
(236, 47, 47, 5),
(237, 48, 84, 4),
(238, 49, 69, 3),
(239, 50, 59, 2),
(240, 51, 87, 2),
(241, 52, 14, 4),
(242, 53, 85, 2),
(243, 54, 87, 3),
(244, 55, 73, 2),
(245, 56, 96, 1),
(246, 57, 65, 5),
(247, 58, 58, 1),
(248, 59, 23, 3),
(249, 60, 12, 5),
(253, 1, 8, 4),
(254, 2, 42, 5),
(255, 3, 31, 4),
(256, 4, 93, 2),
(257, 5, 94, 4),
(258, 6, 48, 2),
(259, 7, 58, 4),
(260, 8, 62, 1),
(261, 9, 55, 3),
(262, 10, 81, 3),
(263, 11, 40, 2),
(264, 12, 22, 2),
(265, 13, 57, 1),
(266, 14, 81, 4),
(267, 15, 30, 2),
(268, 16, 30, 4),
(269, 17, 89, 1),
(270, 18, 15, 2),
(271, 19, 83, 2),
(272, 20, 43, 5),
(273, 21, 63, 1),
(274, 22, 7, 4),
(275, 23, 61, 4),
(276, 24, 87, 1),
(277, 25, 8, 5),
(278, 26, 58, 5),
(279, 27, 27, 2),
(280, 28, 89, 3),
(281, 29, 48, 1),
(282, 30, 6, 5),
(283, 31, 75, 4),
(284, 32, 73, 2),
(285, 33, 12, 4),
(286, 34, 62, 4),
(287, 35, 60, 5),
(288, 36, 89, 4),
(289, 37, 42, 2),
(290, 38, 96, 1),
(291, 39, 49, 1),
(292, 40, 49, 5),
(293, 41, 97, 1),
(294, 42, 95, 2),
(295, 43, 24, 3),
(296, 44, 89, 5),
(297, 45, 84, 3),
(298, 46, 78, 3),
(299, 47, 19, 3),
(300, 48, 63, 4),
(301, 49, 10, 1),
(302, 50, 30, 1),
(303, 51, 78, 3),
(304, 52, 100, 4),
(305, 53, 3, 2),
(306, 54, 50, 3),
(307, 55, 11, 5),
(308, 56, 67, 2),
(309, 57, 58, 5),
(310, 58, 91, 4),
(311, 59, 3, 5),
(312, 60, 40, 2),
(317, 8, 1, 3),
(318, 1, 1, 3),
(319, 8, 1, 3),
(320, 10, 1, 1),
(321, 18, 1, 2),
(322, 3, 1, 3),
(323, 12, 1, 3),
(324, 16, 1, 4),
(325, 13, 1, 3),
(326, 14, 1, 3),
(327, 2, 1, 3),
(328, 12, 1, 3),
(329, 21, 1, 3),
(330, 4, 1, 4),
(331, 12, 1, 4),
(332, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `userratings`
--

CREATE TABLE `userratings` (
  `RatingID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `UserRating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userratings`
--

INSERT INTO `userratings` (`RatingID`, `ProductID`, `UserID`, `UserRating`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 1, 3, 5),
(4, 1, 4, 5),
(5, 1, 5, 5),
(6, 1, 6, 5),
(7, 1, 7, 4),
(8, 1, 8, 1),
(9, 1, 9, 3),
(10, 1, 10, 4),
(11, 2, 1, 2),
(12, 2, 2, 5),
(13, 2, 3, 2),
(14, 2, 4, 3),
(15, 2, 5, 5),
(16, 2, 6, 5),
(17, 2, 7, 3),
(18, 2, 8, 4),
(19, 2, 9, 2),
(20, 2, 10, 2),
(21, 3, 1, 5),
(22, 3, 2, 1),
(23, 3, 3, 1),
(24, 3, 4, 3),
(25, 3, 5, 1),
(26, 3, 6, 4),
(27, 3, 7, 1),
(28, 3, 8, 1),
(29, 3, 9, 4),
(30, 3, 10, 1),
(31, 4, 1, 4),
(32, 4, 2, 1),
(33, 4, 3, 2),
(34, 4, 4, 5),
(35, 4, 5, 5),
(36, 4, 6, 4),
(37, 4, 7, 5),
(38, 4, 8, 3),
(39, 4, 9, 3),
(40, 4, 10, 5),
(41, 5, 1, 1),
(42, 5, 2, 2),
(43, 5, 3, 4),
(44, 5, 4, 5),
(45, 5, 5, 5),
(46, 5, 6, 5),
(47, 5, 7, 5),
(48, 5, 8, 2),
(49, 5, 9, 1),
(50, 5, 10, 1),
(51, 6, 1, 4),
(52, 6, 2, 4),
(53, 6, 3, 1),
(54, 6, 4, 4),
(55, 6, 5, 1),
(56, 6, 6, 2),
(57, 6, 7, 3),
(58, 6, 8, 4),
(59, 6, 9, 4),
(60, 6, 10, 4),
(61, 7, 1, 5),
(62, 7, 2, 3),
(63, 7, 3, 5),
(64, 7, 4, 4),
(65, 7, 5, 2),
(66, 7, 6, 4),
(67, 7, 7, 5),
(68, 7, 8, 3),
(69, 7, 9, 1),
(70, 7, 10, 5),
(71, 8, 1, 2),
(72, 8, 2, 5),
(73, 8, 3, 3),
(74, 8, 4, 5),
(75, 8, 5, 2),
(76, 8, 6, 3),
(77, 8, 7, 2),
(78, 8, 8, 1),
(79, 8, 9, 4),
(80, 8, 10, 5),
(81, 9, 1, 5),
(82, 9, 2, 2),
(83, 9, 3, 2),
(84, 9, 4, 3),
(85, 9, 5, 5),
(86, 9, 6, 3),
(87, 9, 7, 3),
(88, 9, 8, 4),
(89, 9, 9, 2),
(90, 9, 10, 5),
(91, 10, 1, 2),
(92, 10, 2, 2),
(93, 10, 3, 1),
(94, 10, 4, 3),
(95, 10, 5, 2),
(96, 10, 6, 1),
(97, 10, 7, 2),
(98, 10, 8, 5),
(99, 10, 9, 2),
(100, 10, 10, 4),
(101, 11, 1, 4),
(102, 11, 2, 3),
(103, 11, 3, 2),
(104, 11, 4, 2),
(105, 11, 5, 5),
(106, 11, 6, 2),
(107, 11, 7, 3),
(108, 11, 8, 5),
(109, 11, 9, 4),
(110, 11, 10, 4),
(111, 12, 1, 2),
(112, 12, 2, 2),
(113, 12, 3, 5),
(114, 12, 4, 4),
(115, 12, 5, 3),
(116, 12, 6, 5),
(117, 12, 7, 3),
(118, 12, 8, 4),
(119, 12, 9, 5),
(120, 12, 10, 3),
(121, 13, 1, 1),
(122, 13, 2, 4),
(123, 13, 3, 3),
(124, 13, 4, 5),
(125, 13, 5, 2),
(126, 13, 6, 5),
(127, 13, 7, 1),
(128, 13, 8, 1),
(129, 13, 9, 4),
(130, 13, 10, 5),
(131, 14, 1, 4),
(132, 14, 2, 2),
(133, 14, 3, 4),
(134, 14, 4, 1),
(135, 14, 5, 1),
(136, 14, 6, 5),
(137, 14, 7, 4),
(138, 14, 8, 1),
(139, 14, 9, 3),
(140, 14, 10, 2),
(141, 15, 1, 4),
(142, 15, 2, 4),
(143, 15, 3, 3),
(144, 15, 4, 1),
(145, 15, 5, 1),
(146, 15, 6, 3),
(147, 15, 7, 2),
(148, 15, 8, 1),
(149, 15, 9, 2),
(150, 15, 10, 1),
(151, 16, 1, 3),
(152, 16, 2, 2),
(153, 16, 3, 3),
(154, 16, 4, 1),
(155, 16, 5, 4),
(156, 16, 6, 4),
(157, 16, 7, 5),
(158, 16, 8, 3),
(159, 16, 9, 2),
(160, 16, 10, 5),
(161, 17, 1, 2),
(162, 17, 2, 1),
(163, 17, 3, 2),
(164, 17, 4, 4),
(165, 17, 5, 2),
(166, 17, 6, 3),
(167, 17, 7, 2),
(168, 17, 8, 1),
(169, 17, 9, 2),
(170, 17, 10, 5),
(171, 18, 1, 1),
(172, 18, 2, 1),
(173, 18, 3, 5),
(174, 18, 4, 2),
(175, 18, 5, 4),
(176, 18, 6, 5),
(177, 18, 7, 1),
(178, 18, 8, 4),
(179, 18, 9, 3),
(180, 18, 10, 4),
(181, 19, 1, 3),
(182, 19, 2, 3),
(183, 19, 3, 1),
(184, 19, 4, 1),
(185, 19, 5, 2),
(186, 19, 6, 4),
(187, 19, 7, 4),
(188, 19, 8, 2),
(189, 19, 9, 5),
(190, 19, 10, 1),
(191, 20, 1, 2),
(192, 20, 2, 3),
(193, 20, 3, 2),
(194, 20, 4, 4),
(195, 20, 5, 2),
(196, 20, 6, 4),
(197, 20, 7, 3),
(198, 20, 8, 3),
(199, 20, 9, 2),
(200, 20, 10, 3),
(201, 21, 1, 5),
(202, 21, 2, 1),
(203, 21, 3, 5),
(204, 21, 4, 1),
(205, 21, 5, 4),
(206, 21, 6, 1),
(207, 21, 7, 4),
(208, 21, 8, 2),
(209, 21, 9, 4),
(210, 21, 10, 5),
(211, 22, 1, 1),
(212, 22, 2, 3),
(213, 22, 3, 5),
(214, 22, 4, 5),
(215, 22, 5, 2),
(216, 22, 6, 5),
(217, 22, 7, 2),
(218, 22, 8, 4),
(219, 22, 9, 1),
(220, 22, 10, 5),
(221, 23, 1, 2),
(222, 23, 2, 4),
(223, 23, 3, 5),
(224, 23, 4, 5),
(225, 23, 5, 5),
(226, 23, 6, 4),
(227, 23, 7, 4),
(228, 23, 8, 4),
(229, 23, 9, 1),
(230, 23, 10, 5),
(231, 24, 1, 2),
(232, 24, 2, 3),
(233, 24, 3, 2),
(234, 24, 4, 4),
(235, 24, 5, 1),
(236, 24, 6, 4),
(237, 24, 7, 5),
(238, 24, 8, 5),
(239, 24, 9, 2),
(240, 24, 10, 5),
(241, 25, 1, 2),
(242, 25, 2, 2),
(243, 25, 3, 1),
(244, 25, 4, 1),
(245, 25, 5, 2),
(246, 25, 6, 4),
(247, 25, 7, 1),
(248, 25, 8, 2),
(249, 25, 9, 3),
(250, 25, 10, 3),
(251, 26, 1, 5),
(252, 26, 2, 1),
(253, 26, 3, 4),
(254, 26, 4, 5),
(255, 26, 5, 4),
(256, 26, 6, 3),
(257, 26, 7, 3),
(258, 26, 8, 1),
(259, 26, 9, 4),
(260, 26, 10, 4),
(261, 27, 1, 5),
(262, 27, 2, 5),
(263, 27, 3, 2),
(264, 27, 4, 4),
(265, 27, 5, 3),
(266, 27, 6, 1),
(267, 27, 7, 2),
(268, 27, 8, 2),
(269, 27, 9, 3),
(270, 27, 10, 3),
(271, 28, 1, 1),
(272, 28, 2, 4),
(273, 28, 3, 3),
(274, 28, 4, 1),
(275, 28, 5, 2),
(276, 28, 6, 4),
(277, 28, 7, 5),
(278, 28, 8, 2),
(279, 28, 9, 3),
(280, 28, 10, 1),
(281, 29, 1, 4),
(282, 29, 2, 5),
(283, 29, 3, 5),
(284, 29, 4, 2),
(285, 29, 5, 2),
(286, 29, 6, 3),
(287, 29, 7, 2),
(288, 29, 8, 5),
(289, 29, 9, 4),
(290, 29, 10, 1),
(291, 30, 1, 5),
(292, 30, 2, 2),
(293, 30, 3, 3),
(294, 30, 4, 5),
(295, 30, 5, 2),
(296, 30, 6, 5),
(297, 30, 7, 1),
(298, 30, 8, 4),
(299, 30, 9, 1),
(300, 30, 10, 1),
(307, 7, 1, 3),
(308, 26, 1, 3),
(309, 4, 1, 1),
(310, 23, 1, 1),
(311, 23, 1, 1),
(312, 23, 1, 3),
(313, 4, 1, 4),
(314, 7, 1, 4),
(315, 8, 1, 5),
(316, 23, 1, 1),
(317, 7, 1, 3),
(318, 22, 3, 3),
(319, 14, 1, 3),
(320, 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `gender`, `password`, `email`) VALUES
(1, 'danielz', 'Male', '1234', 'hovedanielz@gmail.com'),
(4, 'k', 'Male', '1234', 'hovedanielz@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clothingwear`
--
ALTER TABLE `clothingwear`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `clothingwear2`
--
ALTER TABLE `clothingwear2`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userrating2`
--
ALTER TABLE `userrating2`
  ADD PRIMARY KEY (`ratingID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `userratings`
--
ALTER TABLE `userratings`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clothingwear`
--
ALTER TABLE `clothingwear`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `purchasehistory`
--
ALTER TABLE `purchasehistory`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `userrating2`
--
ALTER TABLE `userrating2`
  MODIFY `ratingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT for table `userratings`
--
ALTER TABLE `userratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `userrating2`
--
ALTER TABLE `userrating2`
  ADD CONSTRAINT `userrating2_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `clothingwear2` (`ProductID`);

--
-- Constraints for table `userratings`
--
ALTER TABLE `userratings`
  ADD CONSTRAINT `userratings_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `clothingwear` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
