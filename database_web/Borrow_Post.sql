-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2025 at 02:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Borrow_Post`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comment_B`
--

CREATE TABLE `Comment_B` (
  `Comment_Id` int(11) UNSIGNED NOT NULL,
  `Text_Comment` text NOT NULL,
  `image_Path_C` varchar(255) DEFAULT NULL,
  `Time_Comment` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Post_Id` int(10) UNSIGNED DEFAULT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Post_B`
--

CREATE TABLE `Post_B` (
  `Post_Id` int(10) UNSIGNED NOT NULL,
  `Text_Content` text NOT NULL,
  `image_Path` varchar(255) DEFAULT NULL,
  `Post_Time_B` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Post_B`
--

INSERT INTO `Post_B` (`Post_Id`, `Text_Content`, `image_Path`, `Post_Time_B`, `Email`) VALUES
(5, 'test', 'uploads/6784c5ac80ddc_4.jpeg', '2025-01-13 07:50:04', 'Eman123@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comment_B`
--
ALTER TABLE `Comment_B`
  ADD UNIQUE KEY `Comment_Id` (`Comment_Id`),
  ADD KEY `Post_Id` (`Post_Id`);

--
-- Indexes for table `Post_B`
--
ALTER TABLE `Post_B`
  ADD PRIMARY KEY (`Post_Id`),
  ADD UNIQUE KEY `Post_Id` (`Post_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comment_B`
--
ALTER TABLE `Comment_B`
  MODIFY `Comment_Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Post_B`
--
ALTER TABLE `Post_B`
  MODIFY `Post_Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comment_B`
--
ALTER TABLE `Comment_B`
  ADD CONSTRAINT `post_id_fk` FOREIGN KEY (`Post_Id`) REFERENCES `Post_B` (`Post_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
