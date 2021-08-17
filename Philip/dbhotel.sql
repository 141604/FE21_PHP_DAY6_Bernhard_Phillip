-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2021 at 03:49 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbhotel`
--
CREATE DATABASE IF NOT EXISTS `dbhotel` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dbhotel`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) UNSIGNED NOT NULL,
  `fk_hotel_id` int(11) UNSIGNED DEFAULT NULL,
  `fk_user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `fk_hotel_id`, `fk_user_id`, `date`) VALUES
(8, 1, 2, '2021-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) UNSIGNED NOT NULL,
  `room` varchar(100) NOT NULL,
  `floor` varchar(100) NOT NULL,
  `description` text DEFAULT '',
  `price` decimal(13,2) NOT NULL,
  `duration` int(10) DEFAULT 1,
  `picture` varchar(100) NOT NULL,
  `status` enum('available','booked') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`id`, `room`, `floor`, `description`, `price`, `duration`, `picture`, `status`) VALUES
(1, 'room A', '1', 'This is room A.', '400.00', 1, 'room1.webp', 'booked'),
(2, 'room B', '2', 'This is room B.', '700.00', 2, 'room2.webp', 'available'),
(3, 'room C', '3', 'This is room C.', '1500.00', 3, 'room3.jpg', 'available'),
(5, 'Test room', '6', 'Test room made from test material', '500.00', 1, 'product.png', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `status` enum('user','adm') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `password`, `date_of_birth`, `email`, `picture`, `status`) VALUES
(1, 'Philip', 'Mahlberg', '$2y$10$yH6798Q9O1HJ/Iqx7g7.tO/Z7Aam9.BIEnc.EdUxd6fM5fX1PvUVO', '1992-06-13', 'pm@mail.de', '611b7ba9f0ca2.png', 'adm'),
(2, 'John', 'Dorian', '$2y$10$cKX4fhhrmslv6Nm3NvgKIeLqI9iNc9pErCVjQZSEBnAUq5/0vmH8.', '1976-01-01', 'jd@mail.de', '611b7e1086593.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hotel_id` (`fk_hotel_id`),
  ADD KEY `fk_user_id` (`fk_user_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`fk_hotel_id`) REFERENCES `hotel` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
