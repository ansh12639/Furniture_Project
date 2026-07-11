-- --------------------------------------------------------

-- Table: users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `address` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: admins
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: admin_users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: products
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `info` VARCHAR(255) NOT NULL DEFAULT '',
  `quantity` INT NOT NULL DEFAULT 0,
  `category` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` VARCHAR(255) NOT NULL PRIMARY KEY,
  `product_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: contact_messages
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `your_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Table: job_applications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `job_applications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `position` VARCHAR(255) NOT NULL,
  `resume_path` VARCHAR(255) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `user_id` INT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Seed Data: users, admins, admin_users
-- --------------------------------------------------------
INSERT IGNORE INTO `users` (`id`, `username`, `email`, `password`, `phone`, `address`) VALUES
(1, 'ansh1', 'ansh1@example.com', 'password123', '9876543210', 'Bandra, Mumbai'),
(2, 'shai', 'shai@example.com', 'shai123', '9876543211', 'Colaba, Mumbai'),
(3, 'halut', 'halut@example.com', 'halut123', '9876543212', 'Andheri, Mumbai');

INSERT IGNORE INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@elegantfurniture.com', 'admin123');

INSERT IGNORE INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$wB9dZ4KzB1g5FhT3l6KqIex/UfRjPjN.pS.v20lA47m0.D7DkC7yS');

-- --------------------------------------------------------
-- Seed Data: products
-- --------------------------------------------------------
INSERT IGNORE INTO `products` (`id`, `name`, `price`, `image_path`, `info`, `quantity`, `category`, `description`) VALUES
(1, 'Othello Lounge Chair', 12685, 'products/chair image/chair.jpg', 'Lilac Pink Velvet Premium Comfort', 10, 'chair', 'A luxury velvet lounge chair in lilac pink, designed for modern elegance and superior back support.'),
(2, 'Chair Chair1', 3499, 'products/chair image/chair1.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(3, 'Chair Chair10', 9999, 'products/chair image/chair10.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(4, 'Chair Chair11', 12685, 'products/chair image/chair11.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(5, 'Chair Chair12', 4999, 'products/chair image/chair12.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(6, 'Chair Chair13', 4499, 'products/chair image/chair13.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(7, 'Chair Chair14', 4999, 'products/chair image/chair14.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(8, 'Chair Chair15', 5999, 'products/chair image/chair15.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(9, 'Chair Chair16', 9999, 'products/chair image/chair16.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(10, 'Chair Chair17', 9999, 'products/chair image/chair17.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(11, 'Chair Chair18', 12685, 'products/chair image/chair18.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(12, 'Chair Chair19', 6999, 'products/chair image/chair19.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(13, 'Chair Chair2', 4499, 'products/chair image/chair2.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(14, 'Chair Chair20', 4999, 'products/chair image/chair20.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(15, 'Chair Chair21', 4499, 'products/chair image/chair21.png', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(16, 'Chair Chair22', 9999, 'products/chair image/chair22.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(17, 'Chair Chair23', 7999, 'products/chair image/chair23.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(18, 'Chair Chair24', 9999, 'products/chair image/chair24.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(19, 'Chair Chair25', 3499, 'products/chair image/chair25.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(20, 'Chair Chair26', 7999, 'products/chair image/chair26.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(21, 'Chair Chair27', 8999, 'products/chair image/chair27.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(22, 'Chair Chair28', 3499, 'products/chair image/chair28.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(23, 'Chair Chair29', 8999, 'products/chair image/chair29.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(24, 'Chair Chair3', 4999, 'products/chair image/chair3.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(25, 'Chair Chair30', 4999, 'products/chair image/chair30.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(26, 'Chair Chair31', 8999, 'products/chair image/chair31.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(27, 'Chair Chair32', 12685, 'products/chair image/chair32.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(28, 'Chair Chair33', 6999, 'products/chair image/chair33.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(29, 'Chair Chair34', 5999, 'products/chair image/chair34.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(30, 'Chair Chair35', 3999, 'products/chair image/chair35.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(31, 'Chair Chair36', 4999, 'products/chair image/chair36.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(32, 'Chair Chair37', 4499, 'products/chair image/chair37.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(33, 'Chair Chair38', 4999, 'products/chair image/chair38.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(34, 'Chair Chair39', 5999, 'products/chair image/chair39.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(35, 'Chair Chair4', 12685, 'products/chair image/chair4.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(36, 'Chair Chair40', 5999, 'products/chair image/chair40.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(37, 'Chair Chair41', 7999, 'products/chair image/chair41.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(38, 'Chair Chair42', 5999, 'products/chair image/chair42.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(39, 'Chair Chair43', 5999, 'products/chair image/chair43.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(40, 'Chair Chair44', 12685, 'products/chair image/chair44.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(41, 'Chair Chair45', 7999, 'products/chair image/chair45.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(42, 'Chair Chair46', 7999, 'products/chair image/chair46.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(43, 'Chair Chair47', 7999, 'products/chair image/chair47.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(44, 'Chair Chair48', 6999, 'products/chair image/chair48.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(45, 'Chair Chair5', 8999, 'products/chair image/chair5.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(46, 'Chair Chair6', 3999, 'products/chair image/chair6.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(47, 'Chair Chair7', 4499, 'products/chair image/chair7.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(48, 'Chair Chair8', 6999, 'products/chair image/chair8.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(49, 'Chair Chair9', 2999, 'products/chair image/chair9.jpg', 'Premium Comfort Accent', 10, 'chair', 'Ergonomically designed premium chair providing maximum comfort and modern style for your living space or office.'),
(50, 'Bed Bed  1 ', 49999, 'products/beds image/bed (1).png', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(51, 'Bed Bed  1 ', 27999, 'products/beds image/bed (1).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(52, 'Bed Bed  10 ', 19999, 'products/beds image/bed (10).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(53, 'Bed Bed  11 ', 54999, 'products/beds image/bed (11).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(54, 'Bed Bed  12 ', 39999, 'products/beds image/bed (12).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(55, 'Bed Bed  13 ', 44999, 'products/beds image/bed (13).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(56, 'Bed Bed  14 ', 24999, 'products/beds image/bed (14).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(57, 'Bed Bed  15 ', 54999, 'products/beds image/bed (15).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(58, 'Bed Bed  16 ', 54999, 'products/beds image/bed (16).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(59, 'Bed Bed  17 ', 54999, 'products/beds image/bed (17).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(60, 'Bed Bed  18 ', 24999, 'products/beds image/bed (18).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(61, 'Bed Bed  19 ', 19999, 'products/beds image/bed (19).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(62, 'Royal Oak King Bed', 45000, 'products/beds image/bed (2).webp', 'Solid Oak Premium King Size', 10, 'bed', 'Spacious and durable king-size bed crafted from premium solid oak wood with an elegant headboard.'),
(63, 'Bed Bed  20 ', 54999, 'products/beds image/bed (20).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(64, 'Bed Bed  21 ', 54999, 'products/beds image/bed (21).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(65, 'Bed Bed  22 ', 54999, 'products/beds image/bed (22).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(66, 'Bed Bed  23 ', 27999, 'products/beds image/bed (23).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(67, 'Bed Bed  24 ', 24999, 'products/beds image/bed (24).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(68, 'Bed Bed  25 ', 19999, 'products/beds image/bed (25).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(69, 'Bed Bed  26 ', 19999, 'products/beds image/bed (26).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(70, 'Bed Bed  27 ', 24999, 'products/beds image/bed (27).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(71, 'Bed Bed  28 ', 27999, 'products/beds image/bed (28).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(72, 'Bed Bed  29 ', 29999, 'products/beds image/bed (29).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(73, 'Minimalist Platform Queen Bed', 28000, 'products/beds image/bed (3).webp', 'Queen Size Platform Bed', 10, 'bed', 'Low profile platform bed in queen size with solid wood support slats and a contemporary grey finish.'),
(74, 'Bed Bed  30 ', 54999, 'products/beds image/bed (30).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(75, 'Bed Bed  31 ', 19999, 'products/beds image/bed (31).jpg', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(76, 'Bed Bed  32 ', 29999, 'products/beds image/bed (32).jpg', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(77, 'Classic Tufted Storage Bed', 35000, 'products/beds image/bed (4).webp', 'Queen Size Tufted Storage Bed', 10, 'bed', 'Features a gas-lift storage mechanism under the mattress base and a button-tufted headboard.'),
(78, 'Bed Bed  5 ', 44999, 'products/beds image/bed (5).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(79, 'Bed Bed  6 ', 27999, 'products/beds image/bed (6).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(80, 'Bed Bed  7 ', 29999, 'products/beds image/bed (7).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(81, 'Bed Bed  8 ', 34999, 'products/beds image/bed (8).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(82, 'Bed Bed  9 ', 39999, 'products/beds image/bed (9).webp', 'Solid Oak Wood Frame', 10, 'bed', 'Exquisite bed crafted with high-quality wood, designed for ultimate relaxation and long-lasting durability.'),
(83, 'Chesterfield Velvet Sofa', 55000, 'products/sofa image/Sofa (1).webp', '3-Seater Classic Velvet Chesterfield', 10, 'sofa', 'Classic tufted Chesterfield design 3-seater sofa upholstered in royal blue velvet fabric.'),
(84, 'Sofa Sofa  10 ', 39999, 'products/sofa image/Sofa (10).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(85, 'Sofa Sofa  11 ', 72000, 'products/sofa image/Sofa (11).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(86, 'Sofa Sofa  12 ', 39999, 'products/sofa image/Sofa (12).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(87, 'Sofa Sofa  13 ', 72000, 'products/sofa image/Sofa (13).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(88, 'Sofa Sofa  14 ', 34999, 'products/sofa image/Sofa (14).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(89, 'Sofa Sofa  15 ', 14999, 'products/sofa image/Sofa (15).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(90, 'Sofa Sofa  16 ', 19999, 'products/sofa image/Sofa (16).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(91, 'Sofa Sofa  17 ', 54999, 'products/sofa image/Sofa (17).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(92, 'Sofa Sofa  18 ', 49999, 'products/sofa image/Sofa (18).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(93, 'Sofa Sofa  19 ', 72000, 'products/sofa image/Sofa (19).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(94, 'Sofa Sofa  20 ', 14999, 'products/sofa image/Sofa (20).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(95, 'Sofa Sofa  21 ', 29999, 'products/sofa image/Sofa (21).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(96, 'Sofa Sofa  22 ', 39999, 'products/sofa image/Sofa (22).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(97, 'Sofa Sofa  23 ', 34999, 'products/sofa image/Sofa (23).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(98, 'Sofa Sofa  24 ', 39999, 'products/sofa image/Sofa (24).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(99, 'Sofa Sofa  25 ', 72000, 'products/sofa image/Sofa (25).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(100, 'Sofa Sofa  26 ', 49999, 'products/sofa image/Sofa (26).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(101, 'Sofa Sofa  27 ', 14999, 'products/sofa image/Sofa (27).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(102, 'Sofa Sofa  28 ', 14999, 'products/sofa image/Sofa (28).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(103, 'Sofa Sofa  29 ', 72000, 'products/sofa image/Sofa (29).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(104, 'L-Shape Sectional Sofa', 72000, 'products/sofa image/Sofa (3).webp', 'L-Shaped Fabric Sofa with Cushion Set', 10, 'sofa', 'Modern sectional sofa that fits snugly in corner layouts, complete with comfortable soft cushions.'),
(105, 'Sofa Sofa  30 ', 72000, 'products/sofa image/Sofa (30).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(106, 'Sofa Sofa  31 ', 72000, 'products/sofa image/Sofa (31).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(107, 'Sofa Sofa  32 ', 54999, 'products/sofa image/Sofa (32).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(108, 'Sofa Sofa  33 ', 29999, 'products/sofa image/Sofa (33).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(109, 'Sofa Sofa  34 ', 49999, 'products/sofa image/Sofa (34).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(110, 'Sofa Sofa  35 ', 34999, 'products/sofa image/Sofa (35).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(111, 'Sofa Sofa  36 ', 14999, 'products/sofa image/Sofa (36).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(112, 'Sofa Sofa  37 ', 39999, 'products/sofa image/Sofa (37).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(113, 'Sofa Sofa  38 ', 39999, 'products/sofa image/Sofa (38).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(114, 'Sofa Sofa  39 ', 44999, 'products/sofa image/Sofa (39).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(115, 'Sleek Loveseat Sofa', 24000, 'products/sofa image/Sofa (4).webp', '2-Seater Modern Minimalist Loveseat', 10, 'sofa', 'Compact 2-seater loveseat designed for smaller apartments and offices with modern design accents.'),
(116, 'Sofa Sofa  40 ', 24999, 'products/sofa image/Sofa (40).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(117, 'Sofa Sofa  41 ', 24999, 'products/sofa image/Sofa (41).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(118, 'Sofa Sofa  42 ', 19999, 'products/sofa image/Sofa (42).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(119, 'Sofa Sofa  43 ', 24999, 'products/sofa image/Sofa (43).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(120, 'Sofa Sofa  44 ', 34999, 'products/sofa image/Sofa (44).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(121, 'Sofa Sofa  45 ', 39999, 'products/sofa image/Sofa (45).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(122, 'Sofa Sofa  46 ', 19999, 'products/sofa image/Sofa (46).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(123, 'Sofa Sofa  47 ', 14999, 'products/sofa image/Sofa (47).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(124, 'Sofa Sofa  48 ', 34999, 'products/sofa image/Sofa (48).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(125, 'Sofa Sofa  49 ', 49999, 'products/sofa image/Sofa (49).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(126, 'Sofa Sofa  5 ', 14999, 'products/sofa image/Sofa (5).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(127, 'Sofa Sofa  50 ', 72000, 'products/sofa image/Sofa (50).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(128, 'Sofa Sofa  51 ', 34999, 'products/sofa image/Sofa (51).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(129, 'Sofa Sofa  52 ', 29999, 'products/sofa image/Sofa (52).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(130, 'Sofa Sofa  53 ', 14999, 'products/sofa image/Sofa (53).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(131, 'Sofa Sofa  54 ', 72000, 'products/sofa image/Sofa (54).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(132, 'Sofa Sofa  55 ', 54999, 'products/sofa image/Sofa (55).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(133, 'Sofa Sofa  6 ', 19999, 'products/sofa image/Sofa (6).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(134, 'Sofa Sofa  7 ', 34999, 'products/sofa image/Sofa (7).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(135, 'Sofa Sofa  8 ', 19999, 'products/sofa image/Sofa (8).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(136, 'Sofa Sofa  9 ', 39999, 'products/sofa image/Sofa (9).webp', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(137, 'Sofa Sofa  56 ', 29999, 'products/sofa image/sofa (56).jpg', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(138, 'Sofa Sofa  57 ', 54999, 'products/sofa image/sofa (57).jpg', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(139, 'Sofa Sofa2', 24999, 'products/sofa image/sofa2.jpg', 'Luxury Soft Cushion Sofa', 10, 'sofa', 'Upholstered in luxury fabric, this sofa blends modern aesthetics with soft support, perfect for your living room.'),
(140, 'Carina Persian Carpet', 15765, 'products/carpet image/carpet (10).jpg', 'Traditional Persian Motif Area Rug', 10, 'carpet', 'Intricately patterned area rug replicating traditional Persian motifs with high-density fibers.'),
(141, 'Carpet Carpet  11 ', 1200, 'products/carpet image/carpet (11).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(142, 'Carpet Carpet  12 ', 9999, 'products/carpet image/carpet (12).png', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(143, 'Carpet Carpet  13 ', 9999, 'products/carpet image/carpet (13).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(144, 'Carpet Carpet  14 ', 1999, 'products/carpet image/carpet (14).jpeg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(145, 'Carpet Carpet  14 ', 5999, 'products/carpet image/carpet (14).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(146, 'Carpet Carpet  15 ', 15765, 'products/carpet image/carpet (15).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(147, 'Carpet Carpet  16 ', 2999, 'products/carpet image/carpet (16).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(148, 'Carpet Carpet  17 ', 15765, 'products/carpet image/carpet (17).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(149, 'Carpet Carpet  18 ', 2499, 'products/carpet image/carpet (18).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(150, 'Carpet Carpet  19 ', 2999, 'products/carpet image/carpet (19).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(151, 'Carpet Carpet  2 ', 2499, 'products/carpet image/carpet (2).jpeg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(152, 'Bianka Premium Rug', 14181, 'products/carpet image/carpet (2).jpg', 'Hand-woven Woolen Area Rug', 10, 'carpet', 'Elegant hand-woven carpet made from 100% natural wool with beautiful contemporary patterns.'),
(153, 'Carpet Carpet  20 ', 4999, 'products/carpet image/carpet (20).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(154, 'Carpet Carpet  21 ', 1499, 'products/carpet image/carpet (21).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(155, 'Carpet Carpet  22 ', 7999, 'products/carpet image/carpet (22).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(156, 'Carpet Carpet  23 ', 14181, 'products/carpet image/carpet (23).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(157, 'Carpet Carpet  24 ', 14181, 'products/carpet image/carpet (24).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(158, 'Carpet Carpet  25 ', 2999, 'products/carpet image/carpet (25).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(159, 'Carpet Carpet  26 ', 1499, 'products/carpet image/carpet (26).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(160, 'Carpet Carpet  27 ', 9999, 'products/carpet image/carpet (27).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(161, 'Carpet Carpet  28 ', 7999, 'products/carpet image/carpet (28).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(162, 'Carpet Carpet  29 ', 7999, 'products/carpet image/carpet (29).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(163, 'Carpet Carpet  3 ', 9999, 'products/carpet image/carpet (3).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(164, 'Carpet Carpet  30 ', 4999, 'products/carpet image/carpet (30).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(165, 'Carpet Carpet  4 ', 1200, 'products/carpet image/carpet (4).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(166, 'Carpet Carpet  5 ', 5999, 'products/carpet image/carpet (5).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(167, 'Carpet Carpet  6 ', 9999, 'products/carpet image/carpet (6).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(168, 'Carpet Carpet  7 ', 4999, 'products/carpet image/carpet (7).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(169, 'Carpet Carpet  8 ', 1999, 'products/carpet image/carpet (8).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(170, 'Carpet Carpet  9 ', 14181, 'products/carpet image/carpet (9).jpg', 'Hand-woven Soft Area Rug', 10, 'carpet', 'Beautifully patterned carpet made from premium soft materials, offering warmth and style to any floor.'),
(171, 'Classic Floor Mat', 1200, 'products/carpet image/carpet.jpg', 'Anti-Slip Entrance Door Mat', 10, 'carpet', 'Durable, easy-to-clean floor mat designed for entryways with high absorption properties.');
