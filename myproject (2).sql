-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 04:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(15, 'divesh', 'divesh');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(10, 1, 9, 1),
(12, 3, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `Image`, `description`) VALUES
(3, 'Home Decor', '67347238d1224.jpeg', ' Discover unique, handcrafted artwork and crafts created with passion and skill. From vibrant paintings and intricate sculptures to charming pottery and delicate needlework, find one-of-a-kind pieces to add personality to your home or gift to someone spec'),
(4, 'Art & Craft', '6734728b2dcba.jpeg', ' Discover unique, handcrafted artwork and crafts created with passion and skill. '),
(5, 'Jewelry', '673472a3842b9.jpeg', ' Discover unique, handcrafted artwork and crafts created with passion and skill. ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `order_date`, `status`, `total_amount`) VALUES
(5, 4, 2, '2025-05-30 04:47:13', 'pending', 180.00),
(6, 5, 24, '2025-05-30 11:26:47', 'completed', 180.00),
(7, 7, 26, '2025-05-31 05:58:01', 'completed', 400.00),
(8, 8, 27, '2025-06-01 15:05:05', 'pending', 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_date`, `amount`, `payment_type`) VALUES
(5, 5, '2025-05-30 04:47:13', 180.00, 'Cash on Delivery'),
(6, 6, '2025-05-30 11:26:47', 180.00, 'Cash on Delivery'),
(7, 7, '2025-05-31 05:58:01', 400.00, 'Cash on Delivery'),
(8, 8, '2025-06-01 15:05:05', 300.00, 'Cash on Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock`, `Image`, `category_id`, `vendor_id`) VALUES
(1, 'Paper Flower Frame', 'Modern 3D paper art featuring elegant fan-folded orange flowers against a black frame. This contemporary piece includes 6 handcrafted paper flowers with curved stems, creating a stunning dimensional effect. Perfect for modern home decor. Frame size: 12\" x 18\".', 150.00, 13, 'uploads/products/6734762dcde03_1731491373.jpeg', 3, NULL),
(2, 'Navrang Matka', 'Yellow matka with blue rim and temple motif medallion.', 180.00, 9, 'uploads/products/673476ce2baea_1731491534.jpg', 4, NULL),
(3, 'Pink Chain Necklace', 'Delicate gold chain necklace with royal blue thread wrap and pink pom poms. Perfect for casual wear. Length: 18 inches.', 50.00, 12, 'uploads/products/673476f7d883b_1731491575.jpg', 5, NULL),
(7, 'Welcome Sign Wall Decor', 'cheerful three-tiered welcome sign reading \"Welcome to Our Happy Place\". Features hand-painted designs including birds, flowers, and bees with colorful tassels. Made with high-quality wood and weather-resistant paint. Perfect for entryways, porches, or living rooms.', 150.00, 12, 'uploads/products/6734789eb41ce_1731491998.jpeg', 3, NULL),
(8, 'Mandala Wall Hanging', 'Handcrafted geometric mandala wall hanging featuring intricate traditional designs in vibrant colors of blue, green, yellow, and pink. Adorned with colorful tassels in blue, pink, and yellow. Perfect for adding a bohemian touch to any room.', 180.00, 20, 'uploads/products/673478cf99d86_1731492047.jpeg', 3, NULL),
(9, 'Toran', 'Elegant rope art featuring handwoven leaf designs in natural earth tones and green. This unique piece combines traditional rope weaving techniques with modern design. Mounted in a light wooden frame, perfect for adding natural texture to any room. Size: 16\" x 24\".', 200.00, 14, 'uploads/products/673478ed77b56_1731492077.jpeg', 3, NULL),
(10, ' Necklace Set', 'Bohemian style necklace with colorful layered tassels in navy, red, and mustard. Includes matching earrings. Adorned with silver beads. Adjustable length.', 150.00, 10, 'uploads/products/67347920d6aef_1731492128.jpg', 5, NULL),
(11, 'Multi-Gemstone Bracelet', 'Adjustable macrame bracelet featuring mixed pastel gemstones and silver accents. Includes rose quartz, amazonite, and garnet beads.', 50.00, 4, 'uploads/products/6734794b9e9fb_1731492171.jpeg', 5, NULL),
(12, 'Earrings', 'Handcrafted ceramic tile design earrings with blue and turquoise patterns. Features golden-banded navy silk tassels. Length: 3 inches.', 80.00, 12, 'uploads/products/673479af63559_1731492271.jpg', 5, NULL),
(13, 'Kalash', 'Yellow hand-painted matka with meenakari style floral design.', 180.00, 2, 'uploads/products/673479e20a9f6_1731492322.jpeg', 4, NULL),
(14, 'Sanskritik Kalash', 'Cream-colored kalash set with black tribal art, ideal for traditional decor', 500.00, 21, 'uploads/products/67347a0f3f121_1731492367.jpg', 4, NULL),
(15, 'Neelam Gharha', 'Deep blue gharha with white paisley patterns.', 280.00, 8, 'uploads/products/67347a5659fcb_1731492438.jpg', 4, NULL),
(20, 'flower vase', 'beautiful', 180.00, 0, 'flowervase.jpeg', 0, 1),
(22, 'flower vase', 'good', 300.00, 0, 'flowervase.jpeg', 0, 1),
(24, 'flower vase', 'homedecor', 180.00, 9, 'uploads/products/683993ba0f01c_1748603834.jpeg', 3, 1),
(26, 'pots ', 'a set of 5 beautiful pots', 200.00, 13, 'uploads/products/683a99f461a12_1748670964.jpeg', 4, 3),
(27, 'handbags', 'a wool threaded bag', 300.00, 9, 'uploads/products/683c6bd47b7ca_1748790228.jpeg', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `ph_no` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `Address`, `ph_no`, `created_at`, `security_question`, `security_answer`) VALUES
(4, 'Gayatri27', 'chgayatridevi27@gmail.com', '$2y$10$PlpPJ3tHyI6G6k.j4SjwHuaTe2e6mKfNgWkX66gHgtYi0gnxgzfRm', 'Main Road', '9392932727', '2025-05-30 04:45:11', 'In which city were you born?', '$2y$10$1oHeViGTpmZRiIviNEEjueK.9XTy43YQdThEGxNr/bRDvNVhMrjFm'),
(5, 'devi', 'devi@gamil.com', '$2y$10$0bsGMRf1koogy4pJswClNe4Ywfgm51m5oaIbafMUbfuIeReuz7Xva', 'Main Road', '9392932726', '2025-05-30 11:25:37', 'What is your mother\'s maiden name?', '$2y$10$Dq8XJ5D1n0t.dvQCzqajyuRJmTAa9CNThs0QhOFPTO0OhzkJnoBkW'),
(7, 'ram27', 'ram@gmail.com', '$2y$10$r5C/jGvkwJCPOU4IQFk7AeKMZFnAD1rXko/Bf/0N8kxSb1TDMN0RS', 'Main Road', '9849843888', '2025-05-31 05:37:50', 'What was the name of your first pet?', '$2y$10$NaPAr/ngIPZeh2LG.sLcluXIy499V.csW3Bs4/u6kGxG9fxnpcysK'),
(8, 'dhana27', 'dhana@gmail.com', '$2y$10$5x4gIoB9GKtS6cdR2XVD8u8zROP5o2q1EUz/myF88m6JYLBbJntlS', 'Main Road', '9392932772', '2025-06-01 14:53:32', 'What was the name of your first pet?', '$2y$10$UzHiVUphGSq8iMpaAIURkOVwg1ulXoaD7d5DwINz32TkOCpbTnvQC');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `password`, `business_name`, `phone`, `address`, `status`, `created_at`) VALUES
(3, 'akhil', 'akhil@gmail.com', '$2y$10$X83BoBC94rNFcsmdyWHgxeW9t4ktNpPnMVByE84bbb/jVw6kDprb6', 'Akhil homedecor', '9985888277', 'Avidi,opposite Hanuman temple kothapeta,East godavari district,Andhra pradesh', 'approved', '2025-05-31 05:39:52'),
(4, 'dhanalakshmi', 'lakshmi@gmail.com', '$2y$10$XhK0zROd1NZ6idDJQjNfPecfeOjlkW9hxB/4sjAU50TcPfhqaxhLq', 'dhana decors', '09393212344', 'Avidi,opposite Hanuman temple kothapeta,East godavari district,Andhra pradesh', 'approved', '2025-06-01 14:59:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `Foreign Key` (`product_id`),
  ADD KEY `FK` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `foreign key` (`category_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
