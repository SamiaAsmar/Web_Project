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
-- Database: `SignUp`
--

-- --------------------------------------------------------

--
-- Table structure for table `User_Info`
--

CREATE TABLE `User_Info` (
  `User_Id` bigint(20) UNSIGNED NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Conf_Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `User_Info`
--

INSERT INTO `User_Info` (`User_Id`, `First_Name`, `Last_Name`, `Email`, `Pass`, `Conf_Pass`) VALUES
(1, 'Samia', 'Asmar', 'asmarsamia2003@gmail.com', '$2y$10$1gbP6RxJoihpBVdssfiNQuUBb79GFs70ihgPpLRex9Nhij7UQDEo2', '$2y$10$1gbP6RxJoihpBVdssfiNQuUBb79GFs70ihgPpLRex9Nhij7UQDEo2'),
(3, 'Shahd', 'Almasri', 'shahd.227.almasri@gmail.com', '$2y$10$DJRdlyRHos.aJQ//fo1Cxe1fNdMVvS0VfTNaw1RC.yBlQrEYk141.', '$2y$10$DJRdlyRHos.aJQ//fo1Cxe1fNdMVvS0VfTNaw1RC.yBlQrEYk141.'),
(5, 'Eman', 'Dajani', 'Eman123@gmai.com', '$2y$10$W.6jpVdK0vWafzMi3.nJL..hldwuNdn5BPzo1qPDNqBiLyP17x0AG', '$2y$10$W.6jpVdK0vWafzMi3.nJL..hldwuNdn5BPzo1qPDNqBiLyP17x0AG'),
(6, 'samia', 'mohammad', 'samia22@gmail.com', '$2y$10$KPkPr2./2NGPrhmKBClgsOk8ymkUiDv.nf0BXqwrRb6eaR7uUrKsy', '$2y$10$KPkPr2./2NGPrhmKBClgsOk8ymkUiDv.nf0BXqwrRb6eaR7uUrKsy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `User_Info`
--
ALTER TABLE `User_Info`
  ADD PRIMARY KEY (`User_Id`),
  ADD UNIQUE KEY `User_Id` (`User_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User_Info`
--
ALTER TABLE `User_Info`
  MODIFY `User_Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
