-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2025 at 06:39 AM
-- Server version: 8.0.44-0ubuntu0.24.04.1
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentlift`
--

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `city`, `street`, `created_at`, `updated_at`) VALUES
(1, 'Ermelo', 'Total, 96 Fourie Street', NULL, NULL),
(2, 'Middelburg', 'Shell Ultra City Middelburg N4', NULL, NULL),
(3, 'Pretoria', 'Pretoria Gas Station idk', NULL, NULL);

--
-- Dumping data for table `address_segments`
--

INSERT INTO `address_segments` (`id`, `start_address_id`, `end_address_id`, `distance`, `travel_time_minutes`) VALUES
(1, 1, 2, 103.00, 85),
(2, 2, 3, 140.00, 97),
(3, 3, 2, 140.00, 97),
(4, 2, 1, 103.00, 85);

--
-- Dumping data for table `path_pricing`
--

INSERT INTO `path_pricing` (`route_id`, `departure_address_id`, `arrival_address_id`, `price`) VALUES
(1, 1, 2, 400.00),
(1, 2, 3, 550.00),
(1, 1, 3, 750.00),
(1, 3, 1, 750.00),
(1, 2, 1, 400.00),
(1, 3, 2, 550.00),
(2, 1, 2, 400.00),
(2, 2, 3, 550.00),
(2, 1, 3, 750.00),
(2, 3, 1, 750.00),
(2, 2, 1, 400.00),
(2, 3, 2, 550.00);

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `start_time`, `created_at`, `updated_at`, `day_of_the_week`) VALUES
(1, '10:00:00', NULL, NULL, 'friday'),
(2, '17:00:00', NULL, NULL, 'sunday');

--
-- Dumping data for table `route_paths`
--

INSERT INTO `route_paths` (`id`, `route_id`, `address_segment_id`, `segment_order_number`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL),
(2, 1, 2, 2, NULL, NULL),
(3, 2, 3, 1, NULL, NULL),
(4, 2, 4, 2, NULL, NULL);

INSERT INTO `upsells` (`id`, `name`, `is_active`, `price`, `description`, `slug`, `created_at`, `updated_at`) VALUES (NULL, 'Direct Dropoff', '1', '70', NULL, 'direct-dropoff', NULL, NULL), (NULL, 'Uncapped Wifi', '1', '70', NULL, 'uncapped-wifi', NULL, NULL);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
