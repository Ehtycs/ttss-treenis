-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2016 at 08:00 PM
-- Server version: 5.6.28-1
-- PHP Version: 5.6.19-2+b1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttss_tests`
--
CREATE DATABASE IF NOT EXISTS `ttss_tests` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ttss_tests`;

-- --------------------------------------------------------

--
-- Table structure for table `bands`
--

CREATE TABLE IF NOT EXISTS `bands` (
  `id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `bands`
--

INSERT INTO `bands` (`id`, `name`) VALUES
(1, 'Testjam');

-- --------------------------------------------------------

--
-- Table structure for table `bands_members`
--

CREATE TABLE IF NOT EXISTS `bands_members` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `band_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `const_reserv_accounts`
--

CREATE TABLE IF NOT EXISTS `const_reserv_accounts` (
  `id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `is_paid` int(1) DEFAULT NULL,
  `is_valid` int(1) DEFAULT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_accounts`
--

CREATE TABLE IF NOT EXISTS `login_accounts` (
  `id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `login_accounts`
--

INSERT INTO `login_accounts` (`id`, `band_id`, `member_id`, `username`, `password`, `admin`) VALUES
(1, NULL, 1, 'admin', '$2a$10$76G8Fd0ktlQjSEztxxWp0ODxkaGNjK2zXkTQ1tVXbm74QgKmXK0Bq', 1),
(2, 1, NULL, 'testjam', '$2a$10$a1dqWDO6mjuTe1zHCyxHxOQnrMqw3Oqn/DEj6rTpLyMsXKlPQVG7m', 0);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `first_name`, `last_name`, `email`, `access`) VALUES
(1, 'Admin', 'Admininen', 'admin@admin.fi', 0);

-- --------------------------------------------------------

--
-- Table structure for table `membership_fees`
--

CREATE TABLE IF NOT EXISTS `membership_fees` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `ttyy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_messages`
--

CREATE TABLE IF NOT EXISTS `reservation_messages` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `message` text COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reserv_accounts`
--

CREATE TABLE IF NOT EXISTS `reserv_accounts` (
  `id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `is_paid` int(1) DEFAULT NULL,
  `is_valid` int(1) DEFAULT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE IF NOT EXISTS `slots` (
  `id` int(11) NOT NULL,
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `day` int(2) DEFAULT NULL,
  `is_const_reserved` int(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `start`, `end`, `day`, `is_const_reserved`) VALUES
(1, '00:00:00', '05:59:00', 0, NULL),
(2, '06:00:00', '08:59:00', 0, NULL),
(3, '09:00:00', '11:59:00', 0, NULL),
(4, '12:00:00', '14:59:00', 0, NULL),
(5, '15:00:00', '17:59:00', 0, NULL),
(6, '18:00:00', '20:59:00', 0, NULL),
(7, '21:00:00', '23:59:00', 0, NULL),
(8, '00:00:00', '05:59:00', 1, NULL),
(9, '06:00:00', '08:59:00', 1, NULL),
(10, '09:00:00', '11:59:00', 1, NULL),
(11, '12:00:00', '14:59:00', 1, NULL),
(12, '15:00:00', '17:59:00', 1, NULL),
(13, '18:00:00', '20:59:00', 1, NULL),
(14, '21:00:00', '23:59:00', 1, NULL),
(15, '00:00:00', '05:59:00', 2, NULL),
(16, '06:00:00', '08:59:00', 2, NULL),
(17, '09:00:00', '11:59:00', 2, NULL),
(18, '12:00:00', '14:59:00', 2, NULL),
(19, '15:00:00', '17:59:00', 2, NULL),
(20, '18:00:00', '20:59:00', 2, NULL),
(21, '21:00:00', '23:59:00', 2, NULL),
(22, '00:00:00', '05:59:00', 3, NULL),
(23, '06:00:00', '08:59:00', 3, NULL),
(24, '09:00:00', '11:59:00', 3, NULL),
(25, '12:00:00', '14:59:00', 3, NULL),
(26, '15:00:00', '17:59:00', 3, NULL),
(27, '18:00:00', '20:59:00', 3, NULL),
(28, '21:00:00', '23:59:00', 3, NULL),
(29, '00:00:00', '05:59:00', 4, NULL),
(30, '06:00:00', '08:59:00', 4, NULL),
(31, '09:00:00', '11:59:00', 4, NULL),
(32, '12:00:00', '14:59:00', 4, NULL),
(33, '15:00:00', '17:59:00', 4, NULL),
(34, '18:00:00', '20:59:00', 4, NULL),
(35, '21:00:00', '23:59:00', 4, NULL),
(36, '00:00:00', '05:59:00', 5, NULL),
(37, '06:00:00', '08:59:00', 5, NULL),
(38, '09:00:00', '11:59:00', 5, NULL),
(39, '12:00:00', '14:59:00', 5, NULL),
(40, '15:00:00', '17:59:00', 5, NULL),
(41, '18:00:00', '20:59:00', 5, NULL),
(42, '21:00:00', '23:59:00', 5, NULL),
(43, '00:00:00', '05:59:00', 6, NULL),
(44, '06:00:00', '08:59:00', 6, NULL),
(45, '09:00:00', '11:59:00', 6, NULL),
(46, '12:00:00', '14:59:00', 6, NULL),
(47, '15:00:00', '17:59:00', 6, NULL),
(48, '18:00:00', '20:59:00', 6, NULL),
(49, '21:00:00', '23:59:00', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(11) NOT NULL,
  `first_day_of_year` date NOT NULL,
  `release_slots_days` int(11) NOT NULL,
  `release_slots_time` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `first_day_of_year`, `release_slots_days`, `release_slots_time`) VALUES
(1, '2016-01-17', 2, '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL,
  `vote_option` int(11) NOT NULL,
  `free_text` text COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `confirm_hash` varchar(20) COLLATE utf8_swedish_ci NOT NULL,
  `confirmed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bands`
--
ALTER TABLE `bands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bands_members`
--
ALTER TABLE `bands_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member` (`member_id`),
  ADD KEY `band` (`band_id`);

--
-- Indexes for table `const_reserv_accounts`
--
ALTER TABLE `const_reserv_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_accounts`
--
ALTER TABLE `login_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_fees`
--
ALTER TABLE `membership_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_messages`
--
ALTER TABLE `reservation_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reserv_accounts`
--
ALTER TABLE `reserv_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bands`
--
ALTER TABLE `bands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bands_members`
--
ALTER TABLE `bands_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `const_reserv_accounts`
--
ALTER TABLE `const_reserv_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_accounts`
--
ALTER TABLE `login_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `membership_fees`
--
ALTER TABLE `membership_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reservation_messages`
--
ALTER TABLE `reservation_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reserv_accounts`
--
ALTER TABLE `reserv_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
