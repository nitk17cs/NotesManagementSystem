-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2020 at 07:42 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(10) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `about` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `pwd`, `email`, `name`, `about`) VALUES
('admin', '12345', 'admin@cmrit.ac.in', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `admin_docs`
--

CREATE TABLE `admin_docs` (
  `sl` mediumint(9) NOT NULL,
  `filename` varchar(200) CHARACTER SET latin1 NOT NULL,
  `created` varchar(100) NOT NULL,
  `branch` varchar(3) NOT NULL,
  `semester` varchar(4) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`code`, `name`) VALUES
('ALL', 'All'),
('AGL', 'Applied Geology'),
('AGP', 'Applied Geophysics'),
('CME', 'Chemical Engineering'),
('CVE', 'Civil Engineering'),
('CSE', 'Computer Science and Engineering'),
('CSD', 'Computer Science and Engineering (Dual Degree)'),
('EE', 'Electrical Engineering'),
('ECE', 'Electronics and Communication Engineering'),
('EIE', 'Electronics and Instrumentation Engineering'),
('EP', 'Engineering Physics'),
('EVE', 'Environmental Engineering'),
('MNC', 'Mathematics and Computing'),
('MECH', 'Mechanical Engineering'),
('FME', 'Mineral Engineering'),
('ME', 'Mining Engineering'),
('MME', 'Mining Machinery Engineering'),
('PE', 'Petroleum Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE `docs` (
  `sl` mediumint(9) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `upvote` mediumint(9) DEFAULT 0,
  `created` varchar(100) NOT NULL,
  `branch` varchar(3) NOT NULL,
  `semester` varchar(4) NOT NULL,
  `uploader` varchar(10) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(10) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `about` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pwd`, `email`, `name`, `about`) VALUES
('shagilhmx', '9ee1c9f4191221747043466ffa6bdb52be5187df', 'shagilhmx@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `user_id` varchar(10) NOT NULL,
  `doc_id` mediumint(9) NOT NULL,
  `vote` mediumint(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_docs`
--
ALTER TABLE `admin_docs`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_docs`
--
ALTER TABLE `admin_docs`
  MODIFY `sl` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `docs`
--
ALTER TABLE `docs`
  MODIFY `sl` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
