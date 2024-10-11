-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2024 at 06:38 PM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u702862677_ashps`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `ID` int(11) NOT NULL,
  `current_shift` varchar(255) NOT NULL,
  `shift_day` int(2) NOT NULL,
  `shift_month` int(2) NOT NULL,
  `shift_year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`ID`, `current_shift`, `shift_day`, `shift_month`, `shift_year`) VALUES
(1, 'one', 31, 3, 2023);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `ID` tinyint(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `single` tinyint(11) NOT NULL,
  `multi` tinyint(11) NOT NULL,
  `hour` int(11) NOT NULL,
  `minute` int(11) NOT NULL,
  `second` int(11) NOT NULL,
  `end-time` int(11) NOT NULL,
  `psversion` varchar(255) NOT NULL,
  `device_status` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`ID`, `Name`, `single`, `multi`, `hour`, `minute`, `second`, `end-time`, `psversion`, `device_status`, `type`) VALUES
(1, 'Device 1', 10, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(2, 'Device 2', 10, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(3, 'Device 3', 25, 40, 0, 0, 0, 0, 'PS5', 'off', ''),
(4, 'Device 4', 30, 50, 0, 0, 0, 0, 'PS5', 'off', ''),
(5, 'Device 5', 10, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(6, 'Device 6', 10, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(9, 'Device 7', 10, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(10, 'PS5', 25, 40, 0, 0, 0, 0, 'PS5', 'off', ''),
(11, 'Room 1', 15, 20, 0, 0, 0, 0, 'PS4', 'off', ''),
(12, 'Room 2', 15, 20, 0, 0, 0, 0, 'PS4', 'off', '');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`ID`, `name`) VALUES
(3, 'FIFA 18'),
(4, 'FIFA 19'),
(5, 'FIFA 20'),
(6, 'FIFA 21'),
(7, 'PES 18'),
(8, 'PES 19'),
(9, 'PES 20'),
(10, 'PES 21'),
(11, 'cold war'),
(12, 'nfs heat');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `ID` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `prim` varchar(255) NOT NULL,
  `secondry` varchar(255) NOT NULL,
  `game` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`ID`, `mail`, `prim`, `secondry`, `game`) VALUES
(1, 'ashraf.fathi109@yahoo.com', 'Device 2', 'Device 7', 'FIFA 20'),
(2, 'ashraf.fathi109@yahoo.com', 'Device 2', 'Device 7', 'FIFA 21'),
(6, 'ashraf.fathi1004@gmail.com', 'Device 7', 'Device 2', 'PES 19'),
(7, 'ashraf.fathi1004@gmail.com', 'Device 7', 'Device 2', 'FIFA 19'),
(10, 'ashraf.fathi106@yahoo.com', 'avail', 'Device 6', 'PES 20'),
(11, 'ashraf.fathi103@gmail.com', 'Room 1', 'Device 6', 'PES 19'),
(12, 'ashraf.fathi103@gmail.com', 'Room 1', 'Device 6', 'PES 21'),
(14, 'ahmed.ozoo109@gmail.com', 'Device 2', 'Device 7', 'PES 21'),
(16, 'ozoo.ozoo101@gmail.com', 'Room 1', 'Room 2', 'FIFA 20'),
(17, 'ozoo.ozoo101@gmail.com', 'Room 1', 'Room 2', 'FIFA 21'),
(19, 'ozoo.ozoo101@gmail.com', 'Room 1', 'Room 2', 'FIFA 19'),
(20, 'ashraf.fathi10103@gmail.com', 'Device 4', 'Room 2', 'PES 19'),
(21, 'ashraf.fathi107@gmail.com', 'avail', 'Device 1', 'FIFA 20'),
(22, 'ozoo.sharraf@gmail.com', 'Device 1', 'avail', 'PES 19'),
(23, 'ashraf.fathi102@yahoo.com', 'Device 6', 'avail', 'FIFA 21'),
(24, 'ahmed.fathi1004@gmail.com', 'avail', 'Device 3', 'PES 19'),
(25, 'ahmed.fathi1004@gmail.com', 'avail', 'Device 3', 'FIFA 19'),
(26, 'ozoo.ashraf8@yahoo.com', 'Device 3', 'avail', 'FIFA 20'),
(27, 'ozoo.sharraf2@gmail.com', 'Device 1', 'Device 4', 'PES 20'),
(28, 'ozoo.sharraf1@gmail.com', 'Device 4', 'Device 6', 'FIFA 19'),
(29, 'fifaash70@gmail.com', 'PS5', 'Device 1', 'FIFA 21'),
(30, 'fifaash70@gmail.com', 'PS5', 'Device 1', 'PES 21'),
(31, 'gamerszone363+286@gmail.com', 'avail', 'Room 1', 'PES 20'),
(32, 'ozoo.ashraf22@yandex.com', 'Device 5', 'Device 3', 'PES 21'),
(33, 'ozoo.ashraf23@yandex.com', 'avail', 'Device 4', 'FIFA 21'),
(34, 'ozoo.ashraf23@yandex.com', 'avail', 'Device 4', 'PES 21'),
(35, 'saeedfouad154@gmail.com', 'avail', 'Device 1', 'PES 18'),
(36, 'salehashraf263@gmail.com', 'avail', 'Device 3', 'PES 18'),
(37, 'salehashraf263@gmail.com', 'avail', 'Device 3', 'FIFA 18'),
(38, 'saeedfouad523@yopmail.com', 'avail', 'Device 3', 'PES 20'),
(39, 'pstruststore+coldwar6@gmail.com', 'avail', 'Device 5', 'cold war'),
(40, 'storetoxic000+fifa21@gmail.com', 'avail', 'Device 5', 'FIFA 21'),
(41, 'saeedfouad145@gmail.com', 'avail', 'Device 1', 'PES 18'),
(42, 'ozoo.sharraf3@gmail.com', 'avail', 'Device 6', 'FIFA 20');

-- --------------------------------------------------------

--
-- Table structure for table `ps_orders`
--

CREATE TABLE `ps_orders` (
  `ORDER_ID` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `order_num` int(11) NOT NULL,
  `order_price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `Reports_bill` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ps_orders`
--

INSERT INTO `ps_orders` (`ORDER_ID`, `device_id`, `s_id`, `order_name`, `order_num`, `order_price`, `total_price`, `status`, `Reports_bill`) VALUES
(131, 3, 2, 'Pepsi', 4, 7, 28, 'done', 2),
(132, 9, 6, 'Cappucino', 2, 8, 16, 'done', 16),
(133, 5, 2, 'Pepsi', 4, 7, 28, 'done', 18),
(134, 3, 5, 'Shipsy', 2, 5, 10, 'done', 17),
(135, 4, 8, 'Guava', 1, 10, 10, 'done', 23);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Reports_ID` int(11) NOT NULL,
  `Reports_bill` int(11) NOT NULL DEFAULT 1,
  `Device_ID` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `all_time` varchar(255) NOT NULL,
  `time_bill` int(11) DEFAULT NULL,
  `drinks_bill` int(11) NOT NULL DEFAULT 0,
  `total_bill` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `current_shift` varchar(255) NOT NULL,
  `shift_day` int(2) DEFAULT NULL,
  `shift_month` int(2) DEFAULT NULL,
  `shift_year` int(4) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`Reports_ID`, `Reports_bill`, `Device_ID`, `device_name`, `type`, `all_time`, `time_bill`, `drinks_bill`, `total_bill`, `start_date`, `start_time`, `end_date`, `end_time`, `current_shift`, `shift_day`, `shift_month`, `shift_year`, `status`) VALUES
(291, 1, 1, 'Device 1', 'single', '1', 1, 0, 1, '2021-06-04', '05:07:47', '2021-06-04', '05:07:52', 'two', 4, 6, 2021, 'link_done'),
(292, 1, 2, 'Device 2', 'single', '2', 1, 0, 1, '2021-06-04', '05:07:52', '2021-06-04', '05:08:00', 'two', 4, 6, 2021, 'link_done'),
(293, 1, 3, 'Device 3', 'single', '1', 1, 0, 1, '2021-06-04', '05:08:00', '2021-06-04', '05:10:31', 'two', 4, 6, 2021, 'link_done'),
(294, 1, 3, 'Device 3', 'multi', '2', 1, 0, 1, '2021-06-04', '05:10:31', '2021-06-04', '05:10:48', 'two', 4, 6, 2021, 'link_done'),
(295, 1, 4, 'Device 4', 'multi', '47283', 657, 0, 661, '2021-06-04', '05:10:48', '2021-06-04', '18:19:06', 'two', 4, 6, 2021, 'done'),
(296, 2, 1, 'Device 1', 'single', '113', 1, 0, 1, '2021-06-05', '17:25:13', '2021-06-05', '17:27:11', 'two', 4, 6, 2021, 'link_done'),
(297, 2, 1, 'Device 1', 'multi', '15', 1, 0, 1, '2021-06-05', '17:27:11', '2021-06-05', '17:27:30', 'two', 4, 6, 2021, 'link_done'),
(298, 2, 2, 'Device 2', 'multi', '2', 1, 0, 1, '2021-06-05', '17:27:30', '2021-06-05', '17:27:39', 'two', 4, 6, 2021, 'link_done'),
(299, 2, 2, 'Device 2', 'single', '3', 1, 0, 1, '2021-06-05', '17:27:39', '2021-06-05', '17:27:56', 'two', 4, 6, 2021, 'link_done'),
(300, 2, 3, 'Device 3', 'single', '49', 1, 28, 33, '2021-06-05', '17:27:56', '2021-06-05', '17:28:55', 'two', 4, 6, 2021, 'done'),
(301, 3, 1, 'Device 1', 'single', '1', 1, 0, 1, '2021-06-05', '17:40:29', '2021-06-05', '17:40:33', 'two', 4, 6, 2021, 'link_done'),
(302, 3, 1, 'Device 1', 'multi', '1', 1, 0, 1, '2021-06-05', '17:40:33', '2021-06-05', '17:40:36', 'two', 4, 6, 2021, 'link_done'),
(303, 3, 2, 'Device 2', 'multi', '675', 4, 0, 6, '2021-06-05', '17:40:36', '2021-06-05', '17:52:02', 'two', 4, 6, 2021, 'done'),
(304, 4, 5, 'Device 5', 'single', '1', 1, 0, 1, '2021-06-05', '17:55:07', '2021-06-05', '17:55:10', 'two', 4, 6, 2021, 'link_done'),
(305, 4, 5, 'Device 5', 'multi', '1', 1, 0, 1, '2021-06-05', '17:55:10', '2021-06-05', '17:55:16', 'two', 4, 6, 2021, 'link_done'),
(306, 4, 6, 'Device 6', 'multi', '2', 1, 0, 1, '2021-06-05', '17:55:16', '2021-06-05', '17:55:24', 'two', 4, 6, 2021, 'done'),
(307, 5, 3, 'Device 3', 'single', '1', 1, 0, 1, '2021-06-05', '17:56:56', '2021-06-05', '17:57:03', 'two', 4, 6, 2021, 'link'),
(308, 5, 4, 'Device 4', 'single', '1', 1, 0, 1, '2021-06-05', '17:57:03', '2021-06-05', '17:57:08', 'two', 4, 6, 2021, 'link'),
(309, 5, 5, 'Device 5', 'single', '2', 1, 0, 1, '2021-06-05', '17:57:08', '2021-06-05', '17:57:15', 'two', 4, 6, 2021, 'done'),
(310, 6, 1, 'Device 1', 'single', '1', 1, 0, 1, '2021-06-05', '18:06:49', '2021-06-05', '18:07:04', 'two', 4, 6, 2021, 'link_done'),
(311, 6, 1, 'Device 1', 'multi', '3', 1, 0, 1, '2021-06-05', '18:07:04', '2021-06-05', '18:07:11', 'two', 4, 6, 2021, 'done'),
(312, 7, 1, 'Device 1', 'single', '1', 1, 0, 1, '2021-06-05', '18:07:43', '2021-06-05', '18:07:46', 'two', 4, 6, 2021, 'link'),
(313, 7, 1, 'Device 1', 'multi', '170', 1, 0, 1, '2021-06-05', '18:07:46', '2021-06-05', '18:10:40', 'two', 4, 6, 2021, 'link'),
(314, 7, 2, 'Device 2', 'multi', '2', 1, 0, 1, '2021-06-05', '18:10:40', '2021-06-05', '18:10:44', 'two', 4, 6, 2021, 'done'),
(315, 8, 1, 'Device 1', 'single', '2', 1, 0, 1, '2021-06-05', '18:10:49', '2021-06-05', '18:10:53', 'two', 4, 6, 2021, 'link'),
(316, 8, 2, 'Device 2', 'single', '2', 1, 0, 1, '2021-06-05', '18:10:53', '2021-06-05', '18:10:59', 'two', 4, 6, 2021, 'link'),
(317, 8, 3, 'Device 3', 'single', '2', 1, 0, 1, '2021-06-05', '18:10:59', '2021-06-05', '18:11:04', 'two', 4, 6, 2021, 'done'),
(318, 9, 9, 'Device 7', 'single', '2', 1, 0, 1, '2021-06-05', '18:12:08', '2021-06-05', '18:12:15', 'two', 4, 6, 2021, 'link_done'),
(319, 9, 5, 'Device 5', 'single', '2', 1, 0, 1, '2021-06-05', '18:12:15', '2021-06-05', '18:12:20', 'two', 4, 6, 2021, 'link_done'),
(320, 9, 1, 'Device 1', 'single', '3', 1, 0, 1, '2021-06-05', '18:12:20', '2021-06-05', '18:12:25', 'two', 4, 6, 2021, 'done'),
(321, 10, 11, 'Room 1', 'single', '682', 3, 0, 3, '2021-06-06', '18:24:15', '2021-06-06', '18:35:58', 'two', 4, 6, 2021, 'link_done'),
(322, 10, 3, 'Device 3', 'single', '4', 1, 0, 1, '2021-06-06', '18:35:58', '2021-06-06', '18:36:05', 'two', 4, 6, 2021, 'link_done'),
(323, 10, 3, 'Device 3', 'multi', '7', 1, 0, 1, '2021-06-06', '18:36:05', '2021-06-06', '18:36:26', 'two', 4, 6, 2021, 'link_done'),
(324, 10, 10, 'PS5', 'multi', '8', 1, 0, 1, '2021-06-06', '18:36:26', '2021-06-06', '18:45:19', 'two', 4, 6, 2021, 'done'),
(325, 11, 9, 'Device 7', 'single', '3874', 11, 0, 11, '2021-06-07', '17:51:55', '2021-06-07', '18:56:32', 'two', 4, 6, 2021, 'done'),
(326, 12, 9, 'Device 7', 'single', '246', 1, 0, 1, '2021-06-11', '19:08:32', '2021-06-11', '19:13:00', 'one', 7, 6, 2021, 'link_done'),
(327, 12, 9, 'Device 7', 'multi', '240', 2, 0, 2, '2021-06-11', '19:13:00', '2021-06-11', '19:17:57', 'one', 7, 6, 2021, 'link_done'),
(328, 12, 1, 'Device 1', 'multi', '3', 1, 0, 1, '2021-06-11', '19:17:57', '2021-06-11', '19:18:10', 'one', 7, 6, 2021, 'done'),
(329, 13, 2, 'Device 2', 'single', '565', 2, 0, 2, '2021-06-16', '09:38:09', '2021-06-16', '09:47:39', 'one', 7, 6, 2021, 'link_done'),
(330, 13, 11, 'Room 1', 'single', '15', 1, 0, 1, '2021-06-16', '09:47:39', '2021-06-16', '09:47:58', 'one', 16, 6, 2021, 'done'),
(331, 14, 1, 'Device 1', 'single', '3', 1, 0, 1, '2021-07-09', '15:52:31', '2021-07-09', '15:52:37', 'one', 16, 6, 2021, 'done'),
(332, 15, 6, 'Device 6', 'single', '35', 1, 0, 1, '2021-07-25', '06:37:10', '2021-07-25', '06:37:49', 'one', 16, 6, 2021, 'done'),
(333, 16, 9, 'Device 7', 'multi', '10', 1, 16, 17, '2021-07-25', '06:37:18', '2021-07-25', '06:37:31', 'one', 16, 6, 2021, 'done'),
(334, 17, 3, 'Device 3', 'single', '181', 2, 10, 12, '2021-08-14', '00:50:22', '2021-08-14', '00:53:27', 'one', 14, 8, 2021, 'done'),
(335, 18, 5, 'Device 5', 'multi', '91', 1, 28, 29, '2021-08-14', '00:50:28', '2021-08-14', '00:52:04', 'one', 14, 8, 2021, 'done'),
(336, 19, 2, 'Device 2', 'single', '25721', 72, 0, 72, '2021-08-17', '08:53:16', '2021-08-17', '16:02:01', 'one', 14, 8, 2021, 'done'),
(337, 20, 1, 'Device 1', 'single', '432', 2, 0, 2, '2023-03-31', '17:03:36', '2023-03-31', '17:10:50', 'one', 31, 3, 2023, 'done'),
(338, 21, 6, 'Device 6', 'multi', '432', 3, 0, 3, '2023-03-31', '17:03:40', '2023-03-31', '17:10:55', 'one', 31, 3, 2023, 'done'),
(339, 22, 9, 'Device 7', 'multi', '430', 3, 0, 3, '2023-03-31', '17:03:46', '2023-03-31', '17:11:15', 'one', 31, 3, 2023, 'done'),
(340, 23, 10, 'PS5', 'single', '16', 1, 0, 1, '2023-03-31', '17:03:47', '2023-03-31', '17:04:11', 'one', 17, 8, 2021, 'link_done'),
(341, 23, 10, 'PS5', 'multi', '3', 1, 0, 1, '2023-03-31', '17:04:11', '2023-03-31', '17:04:22', 'one', 17, 8, 2021, 'link_done'),
(342, 23, 4, 'Device 4', 'multi', '96', 2, 10, 12, '2023-03-31', '17:04:22', '2023-03-31', '17:06:02', 'one', 17, 8, 2021, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `S_ID` int(11) NOT NULL,
  `s_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `s_price` int(11) NOT NULL,
  `s_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`S_ID`, `s_name`, `s_price`, `s_quantity`) VALUES
(1, 'Tea', 3, 81),
(2, 'Pepsi', 7, 65),
(3, 'Coffe', 6, 80),
(4, 'Coffe Milk', 10, 34),
(5, 'Shipsy', 5, 13),
(6, 'Cappucino', 8, 14),
(7, 'Indomy', 5, 84),
(8, 'Guava', 10, 60),
(9, 'Bananna Milk', 12, 88),
(10, 'Mango', 12, 14),
(11, 'Molto', 3, 85),
(12, 'Flamenko', 2, 69),
(13, 'Hohos', 2, 80),
(14, 'Coffe Hazzelnuts', 10, 90),
(15, 'Coffe Mix', 7, 93),
(16, 'Neschaffe', 7, 93),
(17, 'hohos & biscream & freska', 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` tinyint(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `RegStatus` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Pass`, `RegStatus`) VALUES
(1, 'Ashraf', '31910', 1),
(2, 'ahmed', '2241992', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ps_orders`
--
ALTER TABLE `ps_orders`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD UNIQUE KEY `ORDER_ID` (`ORDER_ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Reports_ID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`S_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `ID` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `ps_orders`
--
ALTER TABLE `ps_orders`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `Reports_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
