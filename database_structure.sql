-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 14.06.2015 klo 21:43
-- Palvelimen versio: 5.5.43-0+deb8u1
-- PHP Version: 5.6.9-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ttss`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `admin_accounts`
--

CREATE TABLE IF NOT EXISTS `admin_accounts` (
`id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `bands`
--

CREATE TABLE IF NOT EXISTS `bands` (
`id` int(11) NOT NULL,
  `name` varchar(60) COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `bands_members`
--

CREATE TABLE IF NOT EXISTS `bands_members` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `band_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `const_reserv_accounts`
--

CREATE TABLE IF NOT EXISTS `const_reserv_accounts` (
`id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `is_paid` int(1) DEFAULT NULL,
  `is_valid` int(1) DEFAULT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `login_accounts`
--

CREATE TABLE IF NOT EXISTS `login_accounts` (
`id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `members`
--

CREATE TABLE IF NOT EXISTS `members` (
`id` int(11) NOT NULL,
  `first_name` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=64 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `membership_fees`
--

CREATE TABLE IF NOT EXISTS `membership_fees` (
`id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `ttyy` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
`id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `reserv_accounts`
--

CREATE TABLE IF NOT EXISTS `reserv_accounts` (
`id` int(11) NOT NULL,
  `band_id` int(11) DEFAULT NULL,
  `is_paid` int(1) DEFAULT NULL,
  `is_valid` int(1) DEFAULT NULL,
  `year` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `slots`
--

CREATE TABLE IF NOT EXISTS `slots` (
`id` int(11) NOT NULL,
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `day` int(2) DEFAULT NULL,
  `is_const_reserved` int(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `system_settings`
--

CREATE TABLE IF NOT EXISTS `system_settings` (
`id` int(11) NOT NULL,
  `first_day_of_year` date NOT NULL,
  `release_slots_days` int(11) NOT NULL,
  `release_slots_time` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `id_usergroups` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_swedish_ci DEFAULT NULL,
  `rights` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL COMMENT 'user''s email, unique',
  `user_class` int(4) NOT NULL,
  `user_real_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=2 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bands`
--
ALTER TABLE `bands`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bands_members`
--
ALTER TABLE `bands_members`
 ADD PRIMARY KEY (`id`), ADD KEY `member` (`member_id`), ADD KEY `band` (`band_id`);

--
-- Indexes for table `const_reserv_accounts`
--
ALTER TABLE `const_reserv_accounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_accounts`
--
ALTER TABLE `login_accounts`
 ADD PRIMARY KEY (`id`);

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
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
 ADD PRIMARY KEY (`id_usergroups`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_name` (`user_name`), ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bands`
--
ALTER TABLE `bands`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `bands_members`
--
ALTER TABLE `bands_members`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `const_reserv_accounts`
--
ALTER TABLE `const_reserv_accounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `login_accounts`
--
ALTER TABLE `login_accounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `membership_fees`
--
ALTER TABLE `membership_fees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `reserv_accounts`
--
ALTER TABLE `reserv_accounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
