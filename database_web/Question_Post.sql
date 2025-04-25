-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2025 at 02:11 PM
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
-- Database: `Question_Post`
--

-- --------------------------------------------------------

--
-- Table structure for table `Answer_Q`
--

CREATE TABLE `Answer_Q` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Answer` varchar(255) DEFAULT NULL,
  `Time_A` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `selected_options` text DEFAULT NULL,
  `Votes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Answer_Q`
--

INSERT INTO `Answer_Q` (`Id`, `Answer`, `Time_A`, `file_path`, `Email`, `question_id`, `selected_options`, `Votes`) VALUES
(21, '', '2025-01-13 07:48:03', NULL, 'Eman123@gmail.com', 16, '[\"m1\"]', 1),
(23, '', '2025-01-13 10:30:02', 'uploads/6784eb2ac5d4f.pdf', 'Eman123@gmai.com', 18, '[]', 1),
(24, '', '2025-01-13 10:30:28', NULL, 'Eman123@gmai.com', 19, '[\"gtfrd\"]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Post_Q`
--

CREATE TABLE `Post_Q` (
  `Q_ID` int(10) UNSIGNED NOT NULL,
  `Text_Q` varchar(255) NOT NULL,
  `Time_Q` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Email` varchar(255) NOT NULL,
  `question_type` text NOT NULL,
  `options` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Post_Q`
--

INSERT INTO `Post_Q` (`Q_ID`, `Text_Q`, `Time_Q`, `Email`, `question_type`, `options`) VALUES
(15, 'File', '2025-01-13 07:47:24', 'Eman123@gmail.com', 'file', NULL),
(16, 'Mu', '2025-01-13 07:48:03', 'Eman123@gmail.com', 'multiple-choice', '[{\"id\":1,\"text\":\"m1\",\"votes\":1},{\"id\":2,\"text\":\"m2\"},{\"id\":3,\"text\":\"m3\"}]'),
(18, 'gf', '2025-01-13 10:29:53', 'Eman123@gmai.com', 'file', NULL),
(19, 'hgtfrde', '2025-01-13 10:30:28', 'Eman123@gmai.com', 'multiple-choice', '[{\"id\":1,\"text\":\"gtrf\"},{\"id\":2,\"text\":\"gtfrd\",\"votes\":1},{\"id\":3,\"text\":\"gtfrd\",\"votes\":1}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Answer_Q`
--
ALTER TABLE `Answer_Q`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `question_id` (`question_id`) USING BTREE;

--
-- Indexes for table `Post_Q`
--
ALTER TABLE `Post_Q`
  ADD PRIMARY KEY (`Q_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Answer_Q`
--
ALTER TABLE `Answer_Q`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `Post_Q`
--
ALTER TABLE `Post_Q`
  MODIFY `Q_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Answer_Q`
--
ALTER TABLE `Answer_Q`
  ADD CONSTRAINT `q_id_fk` FOREIGN KEY (`question_id`) REFERENCES `Post_Q` (`Q_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
