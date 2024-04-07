-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 10:09 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fixerr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `cat_name`, `image`, `icon`, `status`) VALUES
(1, 'Appliance Repair', 'uploads/category/Appliance Repair.jpg', NULL, 1),
(2, 'Electrician', 'uploads/category/Electrician.jpg', NULL, 1),
(3, 'Plumbing', 'uploads/category/Plumbing.jpg', NULL, 1),
(4, 'Home Cleaning', 'uploads/category/Home Cleaning.jpg', NULL, 1),
(5, 'Taxes', 'uploads/category/Taxes.jpg', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_type` enum('customer','professional') DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `receiver_type` enum('customer','professional') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `service_id`, `sender_id`, `sender_type`, `receiver_id`, `receiver_type`, `message`, `sent_time`) VALUES
(45, NULL, 1, 'customer', 1, 'professional', 'Hiii', '2024-03-10 16:27:09'),
(46, NULL, 1, 'customer', 1, 'professional', 'I want to hire your service', '2024-03-10 16:27:23'),
(47, NULL, 1, 'professional', 1, 'customer', 'Hey, How I can help you.', '2024-03-10 16:31:19'),
(48, NULL, 1, 'customer', 2, 'professional', 'Hii, I want to repair my ac', '2024-03-10 17:04:51'),
(104, 1, 1, 'customer', 1, 'professional', 'Hello', '2024-03-12 22:48:58'),
(105, NULL, 1, 'professional', 1, 'customer', 'Hello... There', '2024-03-13 03:19:47'),
(107, 1, 1, 'customer', 1, 'professional', 'Hello', '2024-03-12 22:51:23'),
(109, NULL, 1, 'customer', 1, 'professional', 'Hello... There', '2024-03-13 14:20:46'),
(112, NULL, 1, 'professional', 1, 'customer', 'Hello... 1', '2024-03-13 14:42:50'),
(116, NULL, 1, 'customer', 1, 'professional', 'Hello... 2', '2024-03-13 16:28:06'),
(117, 2, 2, 'customer', 1, 'professional', 'Hiii… I want to repair my fans.', '2024-04-02 10:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `chat_status`
--

CREATE TABLE `chat_status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` enum('customer','professional') DEFAULT NULL,
  `is_typing` tinyint(1) DEFAULT 0,
  `last_active` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(125) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `subject` varchar(125) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `subject`, `message`) VALUES
(1, 'Thamal', 'thamal@gmail.com', '111111111', 'Hello World', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id ea mollitia, odit nostrum amet laudantium at, sapiente, officia aperiam quia illo fugiat vero nemo necessitatibus error ex quis? Optio, sed.'),
(2, 'Vishal', 'vishal@gmail.com', '22222222', 'Hello US', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id ea mollitia, odit nostrum amet laudantium at, sapiente, officia aperiam quia illo fugiat vero nemo necessitatibus error ex quis? Optio, sed.'),
(3, 'Russ', 'russ@gmail.com', '33333333', 'Hello World', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id ea mollitia, odit nostrum amet laudantium at, sapiente, officia aperiam quia illo fugiat vero nemo necessitatibus error ex quis? Optio, sed.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `add_no` varchar(10) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(15) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `lname`, `phone`, `add_no`, `address1`, `address2`, `city`, `zipcode`, `country`, `email`, `password`) VALUES
(1, 'Glen ', 'Max', '123456789', '2', 'AAAA', 'BBBB', 'CCCC', '22222', 'United States', 'glen@gmail.com', '123'),
(2, 'Peshan', 'Yasas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'peshan@gmail.com', '123'),
(3, 'Pavan', 'Sathsara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pavan@gmail.com', '123'),
(4, 'Himansu', 'Sankalya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'himansu@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `description` text DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `date`, `time`, `description`, `customer_id`, `service_id`) VALUES
(1, '2024-02-28', '14:35:04', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam similique quo, amet eum neque placeat aperiam laborum quaerat quod! Soluta hic laboriosam tenetur vero. Et explicabo enim ipsam id optio?', 1, 1),
(2, '2024-02-28', '16:09:01', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam?', 1, 2),
(3, '2024-02-28', '16:10:41', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam?', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `ref_id` varchar(45) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `professional`
--

CREATE TABLE `professional` (
  `id` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `add_no` varchar(10) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zipcode` varchar(15) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `professional`
--

INSERT INTO `professional` (`id`, `fname`, `lname`, `phone`, `add_no`, `address1`, `address2`, `city`, `zipcode`, `country`, `profession`, `email`, `password`) VALUES
(1, 'Harry', 'Tector', '123456789', '2', 'AAAA', 'BBBB', 'CCCC', '11111', 'United States', 'Electrician', 'harry@gmail.com', '123'),
(2, 'James', 'Williom', '', '', '', '', 'Washington', '333458', '', 'Appliance Repair', 'james@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `rate` float DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `message`, `rate`, `datetime`, `customer_id`, `service_id`) VALUES
(1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam similique quo, amet eum neque placeat aperiam laborum quaerat quod! Soluta hic laboriosam tenetur vero. Et explicabo enim ipsam id optio?', 3.5, '2024-02-14 13:40:15', 1, 1),
(2, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam similique quo, amet eum neque placeat aperiam laborum quaerat quod! Soluta hic laboriosam tenetur vero. Et explicabo enim ipsam id optio?', 4.5, '2024-02-15 06:10:44', 3, 1),
(3, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam similique quo, amet eum neque placeat aperiam laborum quaerat quod! Soluta hic laboriosam tenetur vero. Et explicabo enim ipsam id optio?', 5, '2024-02-15 06:24:22', 2, 1),
(4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam similique quo, amet eum neque placeat aperiam laborum quaerat quod! Soluta hic laboriosam tenetur vero. Et explicabo enim ipsam id optio?', 4, '2024-02-15 06:25:05', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `profession_name` varchar(100) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `professional_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `profession_name`, `description`, `image`, `price`, `status`, `professional_id`, `category_id`, `sub_category_id`) VALUES
(1, 'Electrician', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum!', 'uploads/service/Switchboard Repair.jpg', 150, '1', 1, 2, 5),
(2, 'Electrician 123', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum!', 'uploads/service/Fan Repair.jpg', 250, '1', 1, 2, 4),
(3, 'Appliance Repair', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum!', 'uploads/service/Air Conditioner.jpg', 200, '1', 2, 1, 1),
(4, 'Electrician', 'aajhja  ha  as  as k ska k sdc kaskckdshsj c nc sd nd cnscd c  d c dc d dcn dc d c cd c d cn dc sd cd c dcds c d csd cdn cn dcn ds dn cnd cnsd c d c d cds cdns cdcdn dsn d cd ', 'uploads/service/Switchboard Repair.jpg', 300, '1', 2, 2, 5),
(5, 'Fixing Mixer', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima architecto expedita culpa ipsa maxime harum corrupti, pariatur maiores quasi similique sit. Similique reprehenderit officiis nisi est cum rem quisquam? Nostrum!', 'uploads/service/Mixer Grinder.jpg', 350, '1', 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `sub_cat_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `sub_cat_name`, `image`, `icon`, `status`, `category_id`) VALUES
(1, 'Air Conditioner', 'uploads/sub_category/Air Conditioner.jpg', NULL, 1, 1),
(2, 'Microwave & Oven', 'uploads/sub_category/Microwave and Oven.jpg', NULL, 1, 1),
(3, 'Mixer Grinder', 'uploads/sub_category/Mixer Grinder.jpg', NULL, 1, 1),
(4, 'Fan Repair & Installation', 'uploads/sub_category/Fan Repair.jpg', NULL, 1, 2),
(5, 'Switchboard Repair & Installation', 'uploads/sub_category/Switchboard Repair.jpg', NULL, 1, 2),
(6, 'Fuse Repair & Installation', 'uploads/sub_category/Fuse Repair.jpg', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_price` float(10,2) NOT NULL,
  `item_price_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `paid_amount_currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `customer_name`, `customer_email`, `item_name`, `item_price`, `item_price_currency`, `paid_amount`, `paid_amount_currency`, `txn_id`, `payment_status`, `created`, `modified`, `order_id`) VALUES
(1, 'Thamalpath', 'thamalpath@gmail.com', 'Demo Product', 25.00, 'USD', 25.00, 'usd', 'pi_3Op5pOApWiL1TP370iYVyakl', 'succeeded', '2024-02-29 14:47:27', '2024-02-29 14:47:27', NULL),
(2, 'Thamalpath', 'thamalpath@gmail.com', 'Demo Product', 25.00, 'USD', 25.00, 'usd', 'pi_3Op5sAApWiL1TP371DDxBoX2', 'succeeded', '2024-02-29 14:50:04', '2024-02-29 14:50:04', NULL),
(3, 'Thamalpath', 'thamalpath1@gmail.com', 'Demo Product', 25.00, 'USD', 25.00, 'usd', 'pi_3Op60qApWiL1TP370im5pw3C', 'succeeded', '2024-02-29 14:59:09', '2024-02-29 14:59:09', NULL),
(4, 'Thamalpath', 'thamalpath2@gmail.com', 'Demo Service', 25.00, 'USD', 25.00, 'usd', 'pi_3Op7qkApWiL1TP371KEfnT2w', 'succeeded', '2024-02-29 16:57:13', '2024-02-29 16:57:13', NULL),
(22, '', '', 'Electrician', 150.00, 'USD', 150.00, 'usd', 'pi_3P2fj9ApWiL1TP3715M7RB2t', 'succeeded', '2024-04-06 22:13:28', '2024-04-06 22:13:28', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `chat_ibfk_1` (`service_id`);

--
-- Indexes for table `chat_status`
--
ALTER TABLE `chat_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_issue_service1_idx` (`service_id`),
  ADD KEY `fk_issue_book1_idx` (`book_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_customer1_idx` (`customer_id`),
  ADD KEY `fk_book_service1_idx` (`service_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professional`
--
ALTER TABLE `professional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_customer1_idx` (`customer_id`),
  ADD KEY `fk_review_service1_idx` (`service_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_professional_idx` (`professional_id`),
  ADD KEY `fk_service_category1_idx` (`category_id`),
  ADD KEY `fk_service_sub_category1_idx` (`sub_category_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_category_category1_idx` (`category_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transactions_order` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `chat_status`
--
ALTER TABLE `chat_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professional`
--
ALTER TABLE `professional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `chat_ibfk_3` FOREIGN KEY (`sender_id`) REFERENCES `professional` (`id`),
  ADD CONSTRAINT `chat_ibfk_4` FOREIGN KEY (`receiver_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `chat_ibfk_5` FOREIGN KEY (`receiver_id`) REFERENCES `professional` (`id`);

--
-- Constraints for table `chat_status`
--
ALTER TABLE `chat_status`
  ADD CONSTRAINT `chat_status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `chat_status_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `professional` (`id`);

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `fk_issue_book1` FOREIGN KEY (`book_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_issue_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_book_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_book_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_review_customer1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_review_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_service_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_professional` FOREIGN KEY (`professional_id`) REFERENCES `professional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_service_sub_category1` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `fk_sub_category_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
