-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2018 at 12:23 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `contact_mgr`
--
CREATE DATABASE IF NOT EXISTS `contact_mgr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `contact_mgr`;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `city` varchar(10) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `d_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `d_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `fullname`, `mobile`, `email`, `company`, `street`, `city`, `state`, `birthday`, `user_id`, `d_modified`, `d_created`) VALUES
(1, 'Yomi Aledare', '08038078854', 'yaledare@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, '2018-12-02 17:10:20', '2018-12-02 18:09:03'),
(2, 'Eleojo Sunday', '09012345678', 'elesunday2015@gmail.com', '', '', '', 'Kogi', '', 1, '2018-12-05 12:39:03', '2018-12-03 11:14:11'),
(6, 'Yomi Paul', '09059985699', 'y.aledare@xlafricagroup.com', 'XL Africa Group', 'Plot 883, Samuel Man', 'Victoria I', 'Lagos', '2010-10-17', 1, NULL, '2018-12-03 13:11:23'),
(7, 'Tosin Bucknor', '07023456781', '', '', '', '', '', '', 1, '2018-12-04 21:50:30', '2018-12-04 09:59:08'),
(8, 'Femi Johnson', '08023078847', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2018-12-04 09:28:10', '2018-12-04 10:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `role` int(11) NOT NULL DEFAULT '2',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `password`, `status`, `role`, `date_created`) VALUES
(1, 'Yomi Aledare P', 'admin', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Active', 1, '2018-12-05 17:44:14'),
(2, 'Joy Audu', 'jaudu', '8cb2237d0679ca88db6464eac60da96345513964', 'Active', 2, '2018-12-05 18:32:12'),
(3, 'Saudi Mercy', 'smercy', '8cb2237d0679ca88db6464eac60da96345513964', 'Active', 2, '2018-12-05 18:32:37'),
(4, 'Ayo Kemi', 'akemi', '8cb2237d0679ca88db6464eac60da96345513964', 'Inactive', 2, '2018-12-05 18:33:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
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
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
