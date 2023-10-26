-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2023 at 01:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `servicecentre`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bays`
--

CREATE TABLE `tbl_bays` (
  `bayid` int(11) NOT NULL,
  `bayname` varchar(16) NOT NULL,
  `baystatus` varchar(3) NOT NULL DEFAULT 'yes',
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `lagtime` varchar(64) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bays`
--

INSERT INTO `tbl_bays` (`bayid`, `bayname`, `baystatus`, `starttime`, `endtime`, `lagtime`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 'bayA', 'yes', '08:00:00', '17:00:00', '15 minute', 4, '2023-06-26', 0, '0000-00-00', 1),
(2, 'bayB', 'yes', '08:00:00', '17:00:00', '15 minute', 4, '2023-06-26', 0, '0000-00-00', 1),
(3, 'bayC', 'yes', '08:00:00', '17:00:00', '15 minute', 4, '2023-06-26', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billpayment`
--

CREATE TABLE `tbl_billpayment` (
  `billid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `customeruserid` int(11) NOT NULL,
  `servicepayment` decimal(18,2) NOT NULL,
  `itemtotalpayment` decimal(18,2) NOT NULL,
  `subservicetotalpayment` decimal(18,2) NOT NULL,
  `grosspayment` decimal(18,2) NOT NULL,
  `servicefreestatus` varchar(6) NOT NULL,
  `pendingpayment` decimal(18,2) NOT NULL DEFAULT 0.00,
  `releasedpayment` decimal(18,2) NOT NULL DEFAULT 0.00,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_billpayment`
--

INSERT INTO `tbl_billpayment` (`billid`, `jobcardid`, `serviceid`, `vehicleid`, `customeruserid`, `servicepayment`, `itemtotalpayment`, `subservicetotalpayment`, `grosspayment`, `servicefreestatus`, `pendingpayment`, `releasedpayment`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(13, 1, 1, 1, 16, '2600.00', '4700.00', '750.00', '8050.00', 'No', '0.00', '0.00', 24, '2023-07-18', 0, '0000-00-00', 1),
(14, 2, 1, 2, 16, '2600.00', '4700.00', '300.00', '7600.00', 'Yes', '0.00', '2600.00', 24, '2023-07-18', 0, '0000-00-00', 1),
(15, 3, 1, 3, 16, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-18', 0, '0000-00-00', 1),
(16, 4, 1, 4, 16, '3100.00', '4250.00', '800.00', '7350.00', 'Yes', '0.00', '3100.00', 24, '2023-07-18', 0, '0000-00-00', 1),
(17, 5, 2, 5, 16, '1650.00', '3250.00', '0.00', '4900.00', 'No', '0.00', '0.00', 24, '2023-07-19', 0, '0000-00-00', 1),
(18, 6, 3, 6, 16, '1450.00', '0.00', '0.00', '1450.00', 'No', '0.00', '0.00', 24, '2023-07-19', 0, '0000-00-00', 1),
(20, 7, 1, 12, 34, '3100.00', '3250.00', '450.00', '6800.00', 'No', '0.00', '0.00', 24, '2023-07-22', 0, '0000-00-00', 1),
(21, 8, 1, 1, 16, '0.00', '3250.00', '0.00', '3250.00', 'Yes', '3100.00', '0.00', 24, '2023-07-22', 0, '0000-00-00', 1),
(22, 9, 1, 17, 36, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-22', 0, '0000-00-00', 1),
(23, 10, 1, 38, 48, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-22', 0, '0000-00-00', 1),
(24, 11, 2, 13, 34, '1650.00', '3250.00', '0.00', '4900.00', 'No', '0.00', '0.00', 24, '2023-07-22', 0, '0000-00-00', 1),
(25, 12, 1, 5, 16, '2600.00', '4700.00', '300.00', '7600.00', 'No', '0.00', '0.00', 24, '2023-07-23', 0, '0000-00-00', 1),
(26, 13, 1, 35, 16, '0.00', '3250.00', '1150.00', '4400.00', 'Yes', '3100.00', '0.00', 24, '2023-07-23', 0, '0000-00-00', 1),
(27, 14, 1, 25, 16, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-23', 0, '0000-00-00', 1),
(28, 15, 1, 4, 16, '3100.00', '3250.00', '450.00', '6800.00', 'No', '0.00', '0.00', 24, '2023-07-23', 0, '0000-00-00', 1),
(29, 16, 1, 1, 16, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-24', 0, '0000-00-00', 1),
(30, 17, 1, 2, 16, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-24', 0, '0000-00-00', 1),
(31, 18, 1, 40, 49, '3100.00', '3250.00', '0.00', '6350.00', 'No', '0.00', '0.00', 24, '2023-07-26', 0, '0000-00-00', 1),
(32, 21, 1, 1, 16, '2600.00', '4700.00', '450.00', '7750.00', 'No', '0.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(33, 23, 1, 3, 16, '0.00', '4700.00', '450.00', '5150.00', 'Yes', '2600.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(34, 24, 1, 42, 52, '2600.00', '4700.00', '450.00', '7750.00', 'No', '0.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(35, 25, 1, 1, 16, '3100.00', '3250.00', '450.00', '6800.00', 'No', '0.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(36, 26, 1, 43, 53, '3100.00', '3250.00', '450.00', '6800.00', 'No', '0.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(37, 27, 1, 44, 54, '2600.00', '4700.00', '750.00', '8050.00', 'No', '0.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(38, 19, 1, 41, 51, '0.00', '3250.00', '0.00', '3250.00', 'Yes', '3100.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(39, 22, 1, 2, 16, '0.00', '3250.00', '0.00', '3250.00', 'Yes', '3100.00', '0.00', 24, '2023-07-27', 0, '0000-00-00', 1),
(40, 28, 1, 45, 55, '2600.00', '4700.00', '750.00', '8050.00', 'No', '0.00', '0.00', 24, '2023-07-28', 0, '0000-00-00', 1),
(41, 29, 1, 46, 56, '2600.00', '4700.00', '750.00', '8050.00', 'No', '0.00', '0.00', 24, '2023-07-28', 0, '0000-00-00', 1),
(42, 30, 1, 47, 57, '2600.00', '6950.00', '750.00', '10300.00', 'No', '0.00', '0.00', 24, '2023-07-28', 0, '0000-00-00', 1),
(43, 32, 1, 2, 16, '0.00', '3250.00', '450.00', '3700.00', 'Yes', '3100.00', '0.00', 24, '2023-07-29', 0, '0000-00-00', 1),
(44, 33, 1, 48, 62, '2600.00', '4700.00', '750.00', '8050.00', 'No', '0.00', '0.00', 24, '2023-07-29', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

CREATE TABLE `tbl_brands` (
  `brandid` int(11) NOT NULL,
  `brandname` varchar(32) NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_brands`
--

INSERT INTO `tbl_brands` (`brandid`, `brandname`, `deletestatus`, `adddate`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 'Yamaha', 0, '2023-02-27', 4, '0000-00-00', 0),
(2, 'Bajaj', 0, '2023-02-27', 4, '0000-00-00', 0),
(3, 'Honda', 1, '2023-02-28', 4, '2023-04-19', 4),
(4, 'Demakaa', 0, '2023-04-01', 3, '2023-04-18', 4),
(5, 'Hero', 0, '2023-04-05', 4, '0000-00-00', 0),
(6, 'Honda', 0, '2023-04-18', 4, '0000-00-00', 0),
(7, 'Honda', 0, '2023-04-18', 4, '0000-00-00', 0),
(8, 'test', 0, '2023-04-18', 4, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_centervehicles`
--

CREATE TABLE `tbl_centervehicles` (
  `vehicleid` int(11) NOT NULL,
  `color` varchar(32) NOT NULL,
  `brandid` int(11) NOT NULL,
  `modelid` int(11) NOT NULL,
  `vehicleimage` varchar(64) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_centervehicles`
--

INSERT INTO `tbl_centervehicles` (`vehicleid`, `color`, `brandid`, `modelid`, `vehicleimage`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 'Purple', 3, 6, '64a988098221c2.03678776.jpg', 4, '2023-04-04', 4, '2023-07-08', 1),
(2, 'Red', 3, 3, '642c86b66e4e38.51209721.jpg', 4, '2023-04-04', 0, '0000-00-00', 1),
(3, 'White', 3, 3, '642c86f1b9edc6.00810098.jpg', 4, '2023-04-04', 0, '0000-00-00', 1),
(4, 'Brown', 3, 3, '642c87471cf5b9.94144564.jpg', 4, '2023-04-04', 0, '0000-00-00', 1),
(5, 'Black', 3, 4, '64401575069524.87533502.jpg', 4, '2023-04-05', 4, '2023-04-19', 1),
(6, 'Red', 3, 4, '644005b7b2c347.17188656.jpg', 4, '2023-04-05', 4, '2023-04-20', 1),
(7, 'Black', 3, 5, '642d8225a0d330.36663008.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(8, 'Red', 3, 5, '642d83723036f6.75992337.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(9, 'White and Blue', 3, 2, '642d8447530af3.91878482.png', 4, '2023-04-05', 0, '0000-00-00', 1),
(10, 'Red and White', 3, 2, '642d95c27ffcd0.93040373.png', 4, '2023-04-05', 0, '0000-00-00', 1),
(11, 'Green and White', 3, 2, '642d95f7d80d96.66702692.png', 4, '2023-04-05', 0, '0000-00-00', 1),
(12, 'Black and White', 3, 2, '642d9682ae9946.56249429.png', 4, '2023-04-05', 0, '0000-00-00', 1),
(13, 'Purple', 3, 6, '642d97d441a358.86578923.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(14, 'Red', 3, 6, '642d97f0f255f0.53054053.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(15, 'White', 3, 6, '642d98057ed930.95334360.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(16, 'Black', 3, 7, '642d98e4211249.50768772.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(17, 'Red', 3, 7, '642d9900a78571.21472451.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(18, 'White', 3, 7, '642d99273bd906.98189315.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(19, 'Black', 3, 8, '642d9a0a574b17.98273785.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(20, 'Red', 3, 8, '642d9a1c494cb2.10471097.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(21, 'Black', 3, 9, '642d9aa6ab0fd0.69711870.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(22, 'Red', 3, 9, '642d9ab4e88b12.70415190.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(23, 'Black', 3, 10, '642d9b85d144d4.66852285.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(24, 'Red', 3, 10, '642d9baddd1400.02241655.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(25, 'Black', 3, 11, '642d9c8f0e0e11.25180404.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(26, 'Red', 3, 11, '642d9ca4080940.29931254.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(27, 'Black', 3, 12, '642d9dbab00593.03012912.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(28, 'White and Blue', 3, 12, '642d9df87ed240.51558068.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(29, 'Red', 3, 12, '642d9e095be114.69565807.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(30, 'Blue', 3, 13, '642d9ecddc0240.04234506.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(31, 'Red', 3, 13, '642d9eea7ebf92.72917930.jpg', 4, '2023-04-05', 0, '0000-00-00', 1),
(32, 'White', 3, 4, '64403647d393b0.43764267.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(33, 'Black', 3, 4, '64403686d92570.37802681.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(34, 'Blue and white', 3, 4, '6440372322d0b2.75162437.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(35, 'sample', 3, 4, '6440388dc066c3.87048490.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(36, 'White and Blue', 3, 4, '64403974b37ff1.09331275.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(37, 'White', 3, 4, '', 4, '2023-04-19', 0, '0000-00-00', 0),
(38, 'Red', 3, 4, '', 4, '2023-04-19', 0, '0000-00-00', 0),
(39, 'Red', 3, 4, '@', 4, '2023-04-19', 0, '0000-00-00', 0),
(40, 'Red', 3, 4, '6440462a607402.12984062.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(41, 'Redss', 3, 4, '6440472f24cab9.32804985.jpg', 4, '2023-04-19', 0, '0000-00-00', 0),
(42, 'Redaa', 3, 4, '644047d385d1e4.25038654.jpg', 4, '2023-04-19', 4, '2023-04-19', 0),
(43, 'Black', 3, 4, '644048b4f2cbf1.82750275.jpg', 4, '2023-04-19', 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checkedservicetasks`
--

CREATE TABLE `tbl_checkedservicetasks` (
  `checkedservicetasksid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `status` varchar(16) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkedservicetasks`
--

INSERT INTO `tbl_checkedservicetasks` (`checkedservicetasksid`, `jobcardid`, `serviceid`, `subserviceid`, `status`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 1, 1, 'done', '2023-07-18', 26, 1),
(2, 1, 1, 3, 'done', '2023-07-18', 26, 1),
(3, 1, 1, 5, 'done', '2023-07-18', 26, 1),
(4, 1, 1, 4, 'done', '2023-07-18', 26, 1),
(5, 1, 1, 8, 'done', '2023-07-18', 26, 1),
(6, 2, 1, 1, 'done', '2023-07-18', 26, 1),
(7, 2, 1, 3, 'done', '2023-07-18', 26, 1),
(8, 2, 1, 5, 'done', '2023-07-18', 26, 1),
(9, 2, 1, 4, 'done', '2023-07-18', 26, 1),
(10, 2, 1, 8, 'done', '2023-07-18', 26, 1),
(11, 3, 1, 1, 'done', '2023-07-18', 26, 1),
(12, 3, 1, 2, 'done', '2023-07-18', 26, 1),
(13, 3, 1, 3, 'done', '2023-07-18', 26, 1),
(14, 3, 1, 5, 'done', '2023-07-18', 26, 1),
(15, 3, 1, 4, 'done', '2023-07-18', 26, 1),
(16, 3, 1, 8, 'done', '2023-07-18', 26, 1),
(17, 4, 1, 1, 'done', '2023-07-18', 26, 1),
(18, 4, 1, 2, 'done', '2023-07-18', 26, 1),
(19, 4, 1, 3, 'done', '2023-07-18', 26, 1),
(20, 4, 1, 5, 'done', '2023-07-18', 26, 1),
(21, 4, 1, 4, 'done', '2023-07-18', 26, 1),
(22, 4, 1, 8, 'done', '2023-07-18', 26, 1),
(23, 5, 2, 3, 'done', '2023-07-19', 26, 1),
(24, 5, 2, 2, 'done', '2023-07-19', 26, 1),
(25, 5, 2, 5, 'done', '2023-07-19', 26, 1),
(26, 6, 3, 1, 'done', '2023-07-19', 26, 1),
(27, 6, 3, 4, 'done', '2023-07-19', 26, 1),
(28, 6, 3, 8, 'done', '2023-07-19', 26, 1),
(29, 7, 1, 1, 'done', '2023-07-22', 26, 1),
(30, 7, 1, 2, 'done', '2023-07-22', 26, 1),
(31, 7, 1, 3, 'done', '2023-07-22', 26, 1),
(32, 7, 1, 5, 'done', '2023-07-22', 26, 1),
(33, 7, 1, 4, 'done', '2023-07-22', 26, 1),
(34, 7, 1, 8, 'done', '2023-07-22', 26, 1),
(35, 8, 1, 1, 'done', '2023-07-22', 26, 1),
(36, 8, 1, 2, 'done', '2023-07-22', 26, 1),
(37, 8, 1, 3, 'done', '2023-07-22', 26, 1),
(38, 8, 1, 5, 'done', '2023-07-22', 26, 1),
(39, 8, 1, 4, 'done', '2023-07-22', 26, 1),
(40, 8, 1, 8, 'done', '2023-07-22', 26, 1),
(41, 9, 1, 1, 'done', '2023-07-22', 26, 1),
(42, 9, 1, 2, 'done', '2023-07-22', 26, 1),
(43, 9, 1, 3, 'done', '2023-07-22', 26, 1),
(44, 9, 1, 5, 'done', '2023-07-22', 26, 1),
(45, 9, 1, 4, 'done', '2023-07-22', 26, 1),
(46, 9, 1, 8, 'done', '2023-07-22', 26, 1),
(47, 10, 1, 1, 'done', '2023-07-22', 26, 1),
(48, 10, 1, 2, 'done', '2023-07-22', 26, 1),
(49, 10, 1, 3, 'done', '2023-07-22', 26, 1),
(50, 10, 1, 5, 'done', '2023-07-22', 26, 1),
(51, 10, 1, 4, 'done', '2023-07-22', 26, 1),
(52, 10, 1, 8, 'done', '2023-07-22', 26, 1),
(53, 11, 2, 3, 'done', '2023-07-22', 26, 1),
(54, 11, 2, 2, 'done', '2023-07-22', 26, 1),
(55, 11, 2, 5, 'done', '2023-07-22', 26, 1),
(56, 12, 1, 1, 'done', '2023-07-23', 26, 1),
(57, 12, 1, 3, 'done', '2023-07-23', 26, 1),
(58, 12, 1, 5, 'done', '2023-07-23', 26, 1),
(59, 12, 1, 4, 'done', '2023-07-23', 26, 1),
(60, 12, 1, 8, 'done', '2023-07-23', 26, 1),
(61, 13, 1, 1, 'done', '2023-07-23', 26, 1),
(62, 13, 1, 2, 'done', '2023-07-23', 26, 1),
(63, 13, 1, 3, 'done', '2023-07-23', 26, 1),
(64, 13, 1, 5, 'done', '2023-07-23', 26, 1),
(65, 13, 1, 4, 'done', '2023-07-23', 26, 1),
(66, 13, 1, 8, 'done', '2023-07-23', 26, 1),
(67, 14, 1, 1, 'done', '2023-07-23', 26, 1),
(68, 14, 1, 2, 'done', '2023-07-23', 26, 1),
(69, 14, 1, 3, 'done', '2023-07-23', 26, 1),
(70, 14, 1, 5, 'done', '2023-07-23', 26, 1),
(71, 14, 1, 4, 'done', '2023-07-23', 26, 1),
(72, 14, 1, 8, 'done', '2023-07-23', 26, 1),
(73, 15, 1, 1, 'done', '2023-07-23', 26, 1),
(74, 15, 1, 2, 'done', '2023-07-23', 26, 1),
(75, 15, 1, 3, 'done', '2023-07-23', 26, 1),
(76, 15, 1, 5, 'done', '2023-07-23', 26, 1),
(77, 15, 1, 4, 'done', '2023-07-23', 26, 1),
(78, 15, 1, 8, 'done', '2023-07-23', 26, 1),
(79, 16, 1, 1, 'done', '2023-07-24', 26, 1),
(80, 16, 1, 2, 'done', '2023-07-24', 26, 1),
(81, 16, 1, 3, 'done', '2023-07-24', 26, 1),
(82, 16, 1, 5, 'done', '2023-07-24', 26, 1),
(83, 16, 1, 4, 'done', '2023-07-24', 26, 1),
(84, 16, 1, 8, 'done', '2023-07-24', 26, 1),
(85, 17, 1, 1, 'done', '2023-07-24', 26, 1),
(86, 17, 1, 2, 'done', '2023-07-24', 26, 1),
(87, 17, 1, 3, 'done', '2023-07-24', 26, 1),
(88, 17, 1, 5, 'done', '2023-07-24', 26, 1),
(89, 17, 1, 4, 'done', '2023-07-24', 26, 1),
(90, 17, 1, 8, 'done', '2023-07-24', 26, 1),
(91, 18, 1, 1, 'done', '2023-07-26', 26, 1),
(92, 18, 1, 2, 'done', '2023-07-26', 26, 1),
(93, 18, 1, 3, 'done', '2023-07-26', 26, 1),
(94, 18, 1, 5, 'done', '2023-07-26', 26, 1),
(95, 18, 1, 4, 'done', '2023-07-26', 26, 1),
(96, 18, 1, 8, 'done', '2023-07-26', 26, 1),
(97, 21, 1, 1, 'done', '2023-07-27', 26, 1),
(98, 21, 1, 3, 'done', '2023-07-27', 26, 1),
(99, 21, 1, 5, 'done', '2023-07-27', 26, 1),
(100, 21, 1, 4, 'done', '2023-07-27', 26, 1),
(101, 21, 1, 8, 'done', '2023-07-27', 26, 1),
(102, 23, 1, 1, 'done', '2023-07-27', 26, 1),
(103, 23, 1, 3, 'done', '2023-07-27', 26, 1),
(104, 23, 1, 5, 'done', '2023-07-27', 26, 1),
(105, 23, 1, 4, 'done', '2023-07-27', 26, 1),
(106, 23, 1, 8, 'done', '2023-07-27', 26, 1),
(107, 24, 1, 1, 'done', '2023-07-27', 26, 1),
(108, 24, 1, 3, 'done', '2023-07-27', 26, 1),
(109, 24, 1, 5, 'done', '2023-07-27', 26, 1),
(110, 24, 1, 4, 'done', '2023-07-27', 26, 1),
(111, 24, 1, 8, 'done', '2023-07-27', 26, 1),
(112, 25, 1, 1, 'done', '2023-07-27', 26, 1),
(113, 25, 1, 2, 'done', '2023-07-27', 26, 1),
(114, 25, 1, 3, 'done', '2023-07-27', 26, 1),
(115, 25, 1, 5, 'done', '2023-07-27', 26, 1),
(116, 25, 1, 4, 'done', '2023-07-27', 26, 1),
(117, 25, 1, 8, 'done', '2023-07-27', 26, 1),
(118, 26, 1, 1, 'done', '2023-07-27', 26, 1),
(119, 26, 1, 2, 'done', '2023-07-27', 26, 1),
(120, 26, 1, 3, 'done', '2023-07-27', 26, 1),
(121, 26, 1, 5, 'done', '2023-07-27', 26, 1),
(122, 26, 1, 4, 'done', '2023-07-27', 26, 1),
(123, 26, 1, 8, 'done', '2023-07-27', 26, 1),
(124, 27, 1, 1, 'done', '2023-07-27', 26, 1),
(125, 27, 1, 3, 'done', '2023-07-27', 26, 1),
(126, 27, 1, 5, 'done', '2023-07-27', 26, 1),
(127, 27, 1, 4, 'done', '2023-07-27', 26, 1),
(128, 27, 1, 8, 'done', '2023-07-27', 26, 1),
(129, 19, 1, 1, 'done', '2023-07-27', 26, 1),
(130, 19, 1, 2, 'done', '2023-07-27', 26, 1),
(131, 19, 1, 3, 'done', '2023-07-27', 26, 1),
(132, 19, 1, 5, 'done', '2023-07-27', 26, 1),
(133, 19, 1, 4, 'done', '2023-07-27', 26, 1),
(134, 19, 1, 8, 'done', '2023-07-27', 26, 1),
(135, 22, 1, 1, 'done', '2023-07-27', 26, 1),
(136, 22, 1, 2, 'done', '2023-07-27', 26, 1),
(137, 22, 1, 3, 'done', '2023-07-27', 26, 1),
(138, 22, 1, 5, 'done', '2023-07-27', 26, 1),
(139, 22, 1, 4, 'done', '2023-07-27', 26, 1),
(140, 22, 1, 8, 'done', '2023-07-27', 26, 1),
(141, 28, 1, 1, 'done', '2023-07-28', 26, 1),
(142, 28, 1, 3, 'done', '2023-07-28', 26, 1),
(143, 28, 1, 5, 'done', '2023-07-28', 26, 1),
(144, 28, 1, 4, 'done', '2023-07-28', 26, 1),
(145, 28, 1, 8, 'done', '2023-07-28', 26, 1),
(146, 29, 1, 1, 'done', '2023-07-28', 26, 1),
(147, 29, 1, 3, 'done', '2023-07-28', 26, 1),
(148, 29, 1, 5, 'done', '2023-07-28', 26, 1),
(149, 29, 1, 4, 'done', '2023-07-28', 26, 1),
(150, 29, 1, 8, 'done', '2023-07-28', 26, 1),
(151, 30, 1, 1, 'done', '2023-07-28', 26, 1),
(152, 30, 1, 3, 'done', '2023-07-28', 26, 1),
(153, 30, 1, 5, 'done', '2023-07-28', 26, 1),
(154, 30, 1, 4, 'done', '2023-07-28', 26, 1),
(155, 30, 1, 8, 'done', '2023-07-28', 26, 1),
(156, 32, 1, 1, 'done', '2023-07-29', 26, 1),
(157, 32, 1, 2, 'done', '2023-07-29', 26, 1),
(158, 32, 1, 3, 'done', '2023-07-29', 26, 1),
(159, 32, 1, 5, 'done', '2023-07-29', 26, 1),
(160, 32, 1, 4, 'done', '2023-07-29', 26, 1),
(161, 32, 1, 8, 'done', '2023-07-29', 26, 1),
(162, 33, 1, 1, 'done', '2023-07-29', 26, 1),
(163, 33, 1, 3, 'done', '2023-07-29', 26, 1),
(164, 33, 1, 5, 'done', '2023-07-29', 26, 1),
(165, 33, 1, 4, 'done', '2023-07-29', 26, 1),
(166, 31, 1, 1, 'done', '2023-07-29', 26, 1),
(167, 31, 1, 2, 'done', '2023-07-29', 26, 1),
(168, 31, 1, 3, 'done', '2023-07-29', 26, 1),
(169, 31, 1, 5, 'done', '2023-07-29', 26, 1),
(170, 31, 1, 1, 'done', '2023-07-29', 26, 1),
(171, 31, 1, 2, 'done', '2023-07-29', 26, 1),
(172, 31, 1, 3, 'done', '2023-07-29', 26, 1),
(173, 31, 1, 5, 'done', '2023-07-29', 26, 1),
(174, 31, 1, 1, 'done', '2023-07-29', 26, 1),
(175, 31, 1, 2, 'done', '2023-07-29', 26, 1),
(176, 31, 1, 3, 'done', '2023-07-29', 26, 1),
(177, 31, 1, 5, 'done', '2023-07-29', 26, 1),
(178, 34, 1, 1, 'done', '2023-07-29', 26, 1),
(179, 34, 1, 2, 'done', '2023-07-29', 26, 1),
(180, 34, 1, 3, 'done', '2023-07-29', 26, 1),
(181, 34, 1, 5, 'done', '2023-07-29', 26, 1),
(182, 34, 1, 4, 'done', '2023-07-29', 26, 1),
(183, 34, 1, 8, 'done', '2023-07-29', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checkedsubservicetasks`
--

CREATE TABLE `tbl_checkedsubservicetasks` (
  `checkedsubservicetaskid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `status` varchar(6) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkedsubservicetasks`
--

INSERT INTO `tbl_checkedsubservicetasks` (`checkedsubservicetaskid`, `jobcardid`, `subserviceid`, `status`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 20, 'done', '2023-07-18', 26, 1),
(2, 1, 6, 'done', '2023-07-18', 26, 1),
(3, 2, 6, 'done', '2023-07-18', 26, 1),
(4, 4, 20, 'done', '2023-07-18', 26, 1),
(5, 4, 21, 'done', '2023-07-18', 26, 1),
(6, 7, 20, 'done', '2023-07-22', 26, 1),
(7, 12, 6, 'done', '2023-07-23', 26, 1),
(8, 13, 10, 'done', '2023-07-23', 26, 1),
(9, 13, 6, 'done', '2023-07-23', 26, 1),
(10, 13, 20, 'done', '2023-07-23', 26, 1),
(11, 15, 20, 'done', '2023-07-23', 26, 1),
(12, 21, 20, 'done', '2023-07-27', 26, 1),
(13, 23, 20, 'done', '2023-07-27', 26, 1),
(14, 24, 20, 'done', '2023-07-27', 26, 1),
(15, 25, 20, 'done', '2023-07-27', 26, 1),
(16, 26, 20, 'done', '2023-07-27', 26, 1),
(17, 27, 20, 'done', '2023-07-27', 26, 1),
(18, 27, 6, 'done', '2023-07-27', 26, 1),
(19, 28, 20, 'done', '2023-07-28', 26, 1),
(20, 28, 6, 'done', '2023-07-28', 26, 1),
(21, 29, 20, 'done', '2023-07-28', 26, 1),
(22, 29, 6, 'done', '2023-07-28', 26, 1),
(23, 30, 20, 'done', '2023-07-28', 26, 1),
(24, 30, 6, 'done', '2023-07-28', 26, 1),
(25, 32, 20, 'done', '2023-07-29', 26, 1),
(26, 33, 20, 'done', '2023-07-29', 26, 1),
(27, 33, 6, 'done', '2023-07-29', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customerid` int(11) NOT NULL,
  `title` varchar(8) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nic` varchar(11) NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `regnumber` int(32) NOT NULL,
  `userid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customerid`, `title`, `firstname`, `lastname`, `nic`, `mobile`, `address1`, `address2`, `city`, `email`, `regnumber`, `userid`, `adddate`, `updateuser`, `updatedate`) VALUES
(12, 'Mr.', 'Hirun', 'Perera', '958993030V', '+9477-5005544', 'No 25', 'Sinhapura watta', 'Chilaw', 'hirun@gmail.com', 2023022616, 16, '2023-02-26', 16, '2023-07-13'),
(14, 'Mr.', 'Danushka', 'Gayan', '953001752V', '+9477-5005514', 'No 25', 'test', 'Chilaw', 'danushka@gmail.com', 2023040832, 32, '2023-04-08', 0, '0000-00-00'),
(15, 'Mrs.', 'Chamod', 'Kalhara', '92350193221', '+9477-5005045', 'No 25/255', 'Kurunagala rood', 'Chilaw', 'chamod@gmail.com', 202304150, 0, '2023-04-15', 0, '0000-00-00'),
(16, 'Miss.', 'Hansani', 'Gunathilaka', '928500193V', '+9477-5005555', 'No 25/55', 'Singapura watta', 'Chilaw', 'hansi@gmail.com', 202305260, 0, '2023-05-26', 0, '0000-00-00'),
(18, 'Mr.', 'Malintha', 'Waranakulasuriya', '951201650V', '+9477-5005848', 'No 26,Sinhapura rood', '', 'Chilaw', 'malintha@gmail.com', 2023061134, 34, '2023-06-11', 0, '0000-00-00'),
(19, 'Mr.', 'Niroshan', 'Fernando', '928233193V', '+9477-5118888', 'No 35, Sinhapura watta,', '', 'Chilaw', 'niroshan@gmail.com', 2023061135, 35, '2023-06-11', 0, '0000-00-00'),
(20, 'Miss.', 'Shashika', 'Silva', '968001930v', '+9477-4501456', 'No 22, Sinhapura rd', '', 'Chilaw', 'shashika@gmail.com', 2023061136, 36, '2023-06-11', 0, '0000-00-00'),
(21, 'Mr.', 'Sidath', 'Madawa', '924512045V', '+9477-4003212', 'No 24/55, Sinhapura watta', '', 'Chilaw', 'sidath@gmail.com', 2023061137, 37, '2023-06-11', 0, '0000-00-00'),
(22, 'Miss.', 'Nimali', 'Fernando', '924001922v', '+9477-5004555', 'No 25', '', 'Chilaw', 'nimali@gmail.com', 2023061138, 38, '2023-06-11', 0, '0000-00-00'),
(23, 'Mr.', 'Sadun', 'Fernando', '923883055V', '+9477-5005545', 'No 25', '', 'Chilaw', 'sadun@gmail.com', 2023061139, 39, '2023-06-11', 0, '0000-00-00'),
(24, 'Mr.', 'Kalpana', 'Amarasinghe', '953005514V', '+9477-5412564', 'No 55/245', 'Thappa watta', 'Chilaw', 'kalpana@gmail.com', 2023061940, 40, '2023-06-19', 0, '0000-00-00'),
(25, 'Mr.', 'kasuni', 'Nawarathna', '924126513V', '+9477-5142456', 'No 21/55', 'Sinhapura road', 'Chilaw', 'kasuni@gmail.com', 2023061941, 41, '2023-06-19', 0, '0000-00-00'),
(26, 'Mr.', 'Heshan', 'Kulathunga', '928670193V', '+9477-5865001', 'No 25/89', 'Sinhapura rd', 'Chilaw', 'heshan@gmail.com', 2023061942, 42, '2023-06-19', 0, '0000-00-00'),
(27, 'Miss.', 'Kalyani', 'Amarasinghe', '953001465V', '+9477-5007896', 'No 25/65', 'Sinhpaura watta', 'chilaw', 'kalyani@gmail.com', 2023062643, 43, '2023-06-26', 0, '0000-00-00'),
(29, 'Miss.', 'Tharushi', 'Abewikrama', '923888741V', '+9477-5005046', 'No 256', 'Sinhapura rood', 'Chilaw', 'tharushi@gmail.com', 2023063045, 45, '2023-06-30', 0, '0000-00-00'),
(30, 'Miss.', 'Senuri', 'Amanda', '926513030V', '+9477-5001654', 'No 25/100', 'Sinhapura watta', 'Chilaw', 'senuri@gmail.com', 2023071146, 46, '2023-07-11', 0, '0000-00-00'),
(31, 'Miss.', 'Anurada', 'Akarsha', '936001930v', '+9477-5016741', 'No 25/60', 'Puttalam rood', 'Jayabima', 'anurada@gmail.com', 2023071447, 47, '2023-07-14', 0, '0000-00-00'),
(32, 'Mr.', 'Hirusha', 'Nanayakkara', '950036541V', '+9477-5005506', 'No 45', 'Sinhapura rood', 'Chilaw', 'hirusha@gmail.com', 2023071848, 48, '2023-07-18', 0, '0000-00-00'),
(33, 'Mr.', 'Asela', 'Gunarathana', '19923101930', '+9477-4501741', 'No 25/225', 'Sinhapura rood', 'Chilaw', 'asela@gmail.com', 2023072649, 49, '2023-07-26', 0, '0000-00-00'),
(34, 'Miss.', 'Susanthi', 'Sudarshani', '923001930V', '+9477-6214562', 'No 25/45', 'Sinhapura rood', 'chilaw', 'Susanthi@gmail.com', 2023072650, 50, '2023-07-26', 0, '0000-00-00'),
(35, 'Mr.', 'Kumara', 'Sangakara', '19903001965', '+9472-5004145', 'No 25,', 'Sinhapura rood', 'chilaw', 'kumara@gmail.com', 2023072751, 51, '2023-07-27', 0, '0000-00-00'),
(36, 'Mr.', 'Dulan', 'Iduwara', '923001950V', '+9477-5004189', 'No 25', 'Sinhapura rood', 'chilaw', 'dulan@gmail.com', 2023072752, 52, '2023-07-27', 0, '0000-00-00'),
(37, 'Mr.', 'kawinda', 'Fernando', '923541620V', '+9477-5893245', 'No 25', 'Sinhapura rood', 'chilaw', 'kawinda@gmail.com', 2023072753, 53, '2023-07-27', 0, '0000-00-00'),
(38, 'Miss.', 'Kawindi', 'Dulanjali', '923004730V', '+9477-5514562', 'No 25/55', 'Sinhapura rood', 'Chailaw', 'kawindii@gmail.com', 2023072754, 54, '2023-07-27', 0, '0000-00-00'),
(39, 'Mr.', 'Kasun', 'Heshan', '925001730V', '+9477-5001489', 'No 26', 'Sinhapura rood', 'Chilaw', 'kasun@gmail.com', 2023072855, 55, '2023-07-28', 0, '0000-00-00'),
(40, 'Mr.', 'Gayan', 'Fonseka', '956001930V', '+9477-8954247', 'No 25/45', 'Sinhapura rood', 'Chilaw', 'gayan@gmail.com', 2023072856, 56, '2023-07-28', 0, '0000-00-00'),
(41, 'Mr.', 'Nalaka', 'Gunawardana', '925001480V', '+9477-9545712', 'No 24', 'Sinhapura rood', 'Chilaw', 'Nalaka@gmail.com', 2023072857, 57, '2023-07-28', 0, '0000-00-00'),
(42, 'Mr.', 'Harshana', 'Gunathilaka', '953001455V', '+9477-5005505', 'No 25', 'Sinhapura rood', 'Chilaw', 'harsana@gmail.com', 2023072858, 58, '2023-07-28', 0, '0000-00-00'),
(43, 'Miss.', 'Shalika', 'Roshini', '923001478V', '+9477-5005567', 'No25', 'Shashi@5819', 'chilaw', 'shalika@gmail.com', 2023072859, 59, '2023-07-28', 0, '0000-00-00'),
(44, 'Mr.', 'Suneth', 'Priyadarshana', '928219300V', '+9477-5005568', 'No 25', 'Sinhapura rood', 'Chilaw', 'suneth@gmail.com', 2023072860, 60, '2023-07-28', 0, '0000-00-00'),
(45, 'Mr.', 'Duminda', 'Fonseka', '923001547V', '+9477-5005457', 'No 25', '', 'chilaw', 'duminda@gmail.com', 2023072861, 61, '2023-07-28', 0, '0000-00-00'),
(46, 'Mr.', 'Kosala', 'Perera', '933001947V', '+9477-8947626', 'no 25', 'Sinhapura rood', 'Chilaw', 'shehaariyasinghe@gmail.com', 2023072962, 62, '2023-07-29', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_displaycarousel`
--

CREATE TABLE `tbl_displaycarousel` (
  `carouselid` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `carouselimage` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `adddate` text NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_displaycarousel`
--

INSERT INTO `tbl_displaycarousel` (`carouselid`, `title`, `carouselimage`, `description`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 'Thusitha Service Center-Honda Chilaw', '64b0d8d4702af3.75487187.jpg', 'Now customers can get a bay without waiting the time. Our service center has offered many vehicle bays for customer vehicles', '2023-07-14', 4, 1),
(2, 'Thusitha Service Center-Honda Chilaw', '64b0dc41d43010.71020664.jpg', 'Customers can detain their vehicles in the indoor yard', '2023-07-14', 4, 1),
(3, 'Thusitha Service Center-Honda Chilaw', '64b0e0537c1794.60528316.jpg', 'Display Honda recommended notice board to get the knowledge of spare parts.', '2023-07-14', 4, 1),
(4, 'Thusitha Service Center-Honda Chilaw', '64b0e24abb8ec5.88258855.jpg', 'Customers can stay in the waiting room till they finish the service.', '2023-07-14', 4, 1),
(5, 'Thusitha Service Center-Honda Chilaw', '64b0e4262ad483.06496826.jpg', 'Customers can detain outdoor space to park their vehicles.', '2023-07-14', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_displayservices`
--

CREATE TABLE `tbl_displayservices` (
  `displayserviceid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `serviceimage` varchar(64) NOT NULL,
  `description` varchar(128) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_displayservices`
--

INSERT INTO `tbl_displayservices` (`displayserviceid`, `serviceid`, `serviceimage`, `description`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 1, '6484a5aacb0f89.29793897.jpg', '', '2023-06-10', 4, '0000-00-00', 0, 1),
(2, 2, '6484a5f770fcc0.92768116.jpg', '', '2023-06-10', 4, '0000-00-00', 0, 1),
(3, 3, '6484a62debe4a9.34405646.jpg', '', '2023-06-10', 4, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employees`
--

CREATE TABLE `tbl_employees` (
  `employeeid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(12) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `temporarystatus` varchar(32) NOT NULL DEFAULT 'none',
  `userid` int(11) NOT NULL DEFAULT 0,
  `image` varchar(32) NOT NULL,
  `adduser` int(11) NOT NULL,
  `joindate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_employees`
--

INSERT INTO `tbl_employees` (`employeeid`, `firstname`, `lastname`, `nic`, `email`, `address1`, `address2`, `city`, `mobile`, `designation`, `temporarystatus`, `userid`, `image`, `adduser`, `joindate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 'Sauri', 'Gunathilaka', '953001930V', 'sauri@gmail.com', 'No 25', 'Sinhapura watta', 'chilaw', '+94775004142', 'manager', 'none', 1, '64afc87fed49b7.15563826.jpeg', 1, '2023-02-20', 2, '2023-07-13', 1),
(2, 'Kamal', 'Fernando', '946001930V', 'kamal@gmail.com', 'test', 'test', 'chilaw', '+94775004766', 'admin', 'none', 2, '63feffeb655139.12024046.jpg', 1, '2023-02-20', 0, '0000-00-00', 1),
(3, 'Saranga', 'Perera', '953055930V', 'saranga@gmail.com', 'No25', 'Kurunagala rd', 'chilaw', '+94775005001', 'storekeeper', 'none', 3, '64b187dac5c685.01355693.jpg', 1, '2023-02-20', 2, '2023-07-14', 1),
(6, 'Lakmal', 'Asela', '963001625V', 'lakmal@gmail.com', 'No 25/55', 'Sinhapura watta', 'chilaw', '+94775001550', 'manager', 'none', 4, '648f5752abe5e0.76701215.jpg', 2, '2023-02-20', 2, '2023-06-18', 1),
(14, 'Nipuni', 'Kulasekara', '953001960V', 'nipuni@gmail.com', 'No 25/45', 'Sinhapura watta', 'Chilaw', '+94775005500', 'cashier', 'none', 24, '64afc8ad7952b6.47417514.jpeg', 2, '2023-03-05', 2, '2023-07-13', 1),
(16, 'Hirushan', 'Gunathilaka', '923883088V', 'hirushangunathilaka@gmail.com', 'No 25/65', 'Jayabima rood', 'Chilaw', '+94771234545', 'supervisor', 'none', 26, '64b10556f105d0.98559921.jpg', 2, '2023-03-10', 2, '2023-07-14', 1),
(20, 'Tharidu', 'Gamage', '953001963V', 'tharidu@gmail.com', 'No55', 'Malwatha road', 'chilaw', '+94778888745', 'technician', 'technician', 0, '64b187b6ed6150.75130804.jpg', 2, '2023-03-29', 2, '2023-07-14', 1),
(24, 'Kasun', 'Dananjaya', '935003652V', 'kasun@gmail.com', 'No 57', 'Darga mawatha', 'Chilaw', '+94775661456', 'technician', 'technician', 0, '64afc8eb04fba7.42642928.jpg', 2, '2023-03-31', 2, '2023-07-13', 1),
(26, 'Indika', 'Prashad', '933541935V', 'indika@gmail.com', '24/55', 'Sinhaprua watta', 'Chilaw', '+94776474745', 'technician', 'technician', 0, '64afc8fecae669.90822481.jpg', 4, '2023-06-30', 2, '2023-07-13', 1),
(27, 'Dilshan', 'Nawarathna', '946501835V', 'dilshan@gamail.com', 'No 60', 'Darga mawatha', 'Chilaw', '+94775005641', 'technician', 'technician', 0, '64afc9150488c7.90027672.jpg', 2, '2023-06-30', 2, '2023-07-13', 1),
(28, 'Lakshitha', 'Perera', '908500193V', 'lakshitha@gmail.com', 'No 20', 'Sinhapura rood', 'Chilaw', '+94775580914', 'assistant technician', 'assistant technician', 0, '649e9f6092fbc2.51489358.jpg', 2, '2023-06-30', 0, '0000-00-00', 1),
(29, 'Dulan', 'Madusanka', '946001945V', 'dulan@gmail.com', 'No50', 'Sinhapura watta', 'Chilaw', '+94776416547', 'assistant technician', 'assistant technician', 0, '64b105b1664257.73102470.jpg', 2, '2023-06-30', 2, '2023-07-14', 1),
(30, 'Kasun', 'Nawarathna', '954563030V', 'nawarathna@gmail.com', 'No 45', 'Kurunagala rood', 'Chilaw', '+94775641456', 'assistant technician', 'assistant technician', 0, '649ea39c55cb17.02133869.jpg', 2, '2023-06-30', 0, '0000-00-00', 1),
(31, 'Sunanda', 'Gunasekara', '928500193V', 'sunanda@gmail.com', 'No 20/55', 'Sinhapura rd', 'Chilaw', '+9477-500451', 'storekeeper', 'none', 0, '64c124c717fe09.17917740.jpg', 4, '2023-07-26', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedbacks`
--

CREATE TABLE `tbl_feedbacks` (
  `feedbackid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `customername` varchar(128) NOT NULL,
  `feedback` text NOT NULL,
  `image` varchar(128) NOT NULL,
  `displaystatus` varchar(8) NOT NULL DEFAULT 'none',
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedbacks`
--

INSERT INTO `tbl_feedbacks` (`feedbackid`, `userid`, `customername`, `feedback`, `image`, `displaystatus`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 16, 'Hirun Perera', '&quot;Would highly recommend this auto shop! He was very professional, very helpful &amp; had great prices. Will definitely come back.&quot;', '64b64476468b05.70390697.jpg', 'show', '2023-07-18', 16, 1),
(2, 34, 'Malintha Waranakulasuriya', 'Great shop! Was traveling through town and in a rush to find a good mechanic and these guys were above amazing! It’s hard to find a good honest mechanic and this is one of them! 10/10 would recommend', '64b645925d3160.78006828.jpeg', 'show', '2023-07-18', 34, 0),
(3, 36, 'Shashika Silva', '&quot;Really awesome place. I had received excellent customer service upon my arrival I loved it.&quot;', '64b645e988f011.67342926.jpeg', 'none', '2023-07-18', 36, 1),
(4, 34, 'Mr .Malintha Waranakulasuriya', 'Great shop! Was traveling through town and in a rush to find a good mechanic and these guys were above amazing! It’s hard to find a good honest mechanic and this is one of them! 10/10 would recommend', '64b64808eb26d1.89288130.jpg', 'show', '2023-07-18', 34, 1),
(5, 36, 'Miss. Shashika Silva', '&quot;Really awesome place. I had received excellent customer service upon my arrival I loved it.&quot;', '64b6490a930356.98256321.jpg', 'show', '2023-07-18', 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holidays`
--

CREATE TABLE `tbl_holidays` (
  `holidayid` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `holidaydate` date NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_holidays`
--

INSERT INTO `tbl_holidays` (`holidayid`, `title`, `holidaydate`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 'Poya day', '2023-07-20', '2023-07-14', 4, 1),
(2, 'Closed day', '2023-07-24', '2023-07-22', 4, 0),
(3, 'Center close day', '2023-07-30', '2023-07-27', 4, 1),
(4, 'Center close day', '2023-08-06', '2023-07-27', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_investigationtasks`
--

CREATE TABLE `tbl_investigationtasks` (
  `investigationtaskid` int(11) NOT NULL,
  `taskname` varchar(255) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_investigationtasks`
--

INSERT INTO `tbl_investigationtasks` (`investigationtaskid`, `taskname`, `deletestatus`, `adddate`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 'Chain', 1, '2023-04-25', 26, '2023-07-05', 26),
(2, 'Brake cable', 1, '2023-04-25', 26, '2023-07-05', 26),
(3, 'Accelerator cable', 1, '2023-04-25', 26, '2023-07-05', 26),
(4, 'Clutch cable', 1, '2023-04-25', 26, '2023-07-05', 26),
(5, 'Battery', 1, '2023-04-25', 26, '2023-07-05', 26),
(6, 'Brake shoes', 1, '2023-04-25', 26, '2023-07-05', 26),
(7, 'Brake pads', 1, '2023-04-25', 26, '2023-07-05', 26),
(8, 'Choke cable', 1, '2023-04-25', 26, '2023-07-05', 26),
(9, 'Engine oil', 1, '2023-07-09', 26, '0000-00-00', 0),
(10, 'Brake oil', 1, '2023-07-09', 26, '0000-00-00', 0),
(11, 'Air filter', 1, '2023-07-09', 26, '0000-00-00', 0),
(12, 'Oil filter', 1, '2023-07-09', 26, '0000-00-00', 0),
(13, 'Head light', 1, '2023-07-09', 26, '0000-00-00', 0),
(14, 'Signal lights', 1, '2023-07-09', 26, '0000-00-00', 0),
(15, 'Brake light', 1, '2023-07-09', 26, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itembrands`
--

CREATE TABLE `tbl_itembrands` (
  `brandid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `subcategoryid` int(11) NOT NULL,
  `brandname` varchar(32) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itembrands`
--

INSERT INTO `tbl_itembrands` (`brandid`, `categoryid`, `subcategoryid`, `brandname`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 1, 1, 'Honda', '2023-04-03', 3, '0000-00-00', 0, 1),
(2, 2, 2, 'Caltex', '2023-04-03', 3, '0000-00-00', 0, 1),
(3, 1, 1, 'Yamaha', '2023-04-03', 3, '0000-00-00', 0, 1),
(4, 1, 4, 'Honda', '2023-04-03', 3, '0000-00-00', 0, 1),
(5, 2, 5, 'Havoline', '2023-04-03', 3, '0000-00-00', 0, 1),
(6, 2, 2, 'Havoline', '2023-04-03', 3, '0000-00-00', 0, 1),
(11, 1, 3, 'Honda', '2023-06-28', 3, '0000-00-00', 0, 1),
(12, 1, 11, 'Honda', '2023-07-09', 3, '0000-00-00', 0, 1),
(13, 2, 2, 'Mobil', '2023-07-15', 4, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemcatalog`
--

CREATE TABLE `tbl_itemcatalog` (
  `catalogid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `subcategoryid` int(11) NOT NULL,
  `itemname` varchar(64) NOT NULL,
  `modelno` varchar(64) NOT NULL,
  `itemcode` varchar(16) NOT NULL,
  `itemimage` varchar(32) NOT NULL,
  `vehicletype` varchar(16) DEFAULT NULL,
  `itemgrade` varchar(16) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `reorderqty` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemcatalog`
--

INSERT INTO `tbl_itemcatalog` (`catalogid`, `categoryid`, `brandid`, `subcategoryid`, `itemname`, `modelno`, `itemcode`, `itemimage`, `vehicletype`, `itemgrade`, `capacity`, `description`, `reorderqty`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 1, 1, 1, 'Honda Dio Air Filter', 'Dio Air Filter', '00100', '644104eeaa7986.22876119.jpg', NULL, NULL, NULL, '100%GENUINE HONDA\r\nAir Filter (17210-KVT-D00)  \r\nUse for Honda Dio   \r\nGenuine Parts from India    \r\nRecommended Milage 18000KM', 100, '2023-04-20', 3, '0000-00-00', 0, 1),
(2, 1, 1, 1, 'Honda Activa i air filters', 'Activa i air filters', '00101', '644109d6e64ac6.03713776.jpeg', NULL, NULL, NULL, 'Air Filter\r\nMade In India  \r\nUse for Honda Activa i \r\nGenuine Parts from India   \r\nRecommended Milage 18000KM', 100, '2023-04-20', 3, '0000-00-00', 0, 1),
(3, 2, 6, 2, 'Havoline Supermatic 4T SemiSynthetic SAE', 'Havoline Supermatic Engine oil', '00102', '64410dc1c79fc8.44040296.png', 'motorbike', '10W-30', 1000, 'Latest generation, four-stroke scooter engines\r\nAir and liquid-cooled four-stroke scooter engines\r\nParticularly suitable for Japanese high performance scooters\r\nScooters fitted with exhaust catalytic converters', 100, '2023-04-20', 3, '2023-07-18', 4, 1),
(5, 2, 5, 5, 'Caltex Brake Fluid DOT 3', 'Brake Fluid DOT 3', '00103', '649b1f79969d08.12783653.jpg', 'motorbike', '', 500, 'Brake and Clutch Fluid DOT 3 is suitable for hydraulically operated motor vehicle braking systems (drum and disc types) for which a DOT 3 or SAE J1703 fluid is specified.', 100, '2023-06-27', 3, '2023-07-18', 4, 1),
(6, 1, 11, 3, 'Honda dio brake cable', 'Dio brake cable', '00104', '649d4d018610a3.79434754.jpg', NULL, NULL, NULL, 'This BRAKE CABLE REAR is suitable for : HONDA DIO 110CC\r\n\r\nCategory Description\r\nbrake cable rear are manufactured from high quality material and high tensile steel.features: friction free,thermal resistance and durability. the fitment of the product is as per oe specification.', 100, '2023-06-28', 3, '2023-06-29', 3, 1),
(7, 2, 2, 2, 'Caltex super 4T', 'Enginee oil caltex super', '00105', '649d4c914f2122.24025489.jpg', 'motorbike', ' 20W-40', 1000, 'Air and liquid-cooled four-stroke motorcycle engines\r\nParticularly suitable for Japanese high performance motorcycle engines\r\nMotorcycles with and without oil immersed clutches\r\nMotorcycles with combined engine / transmission units, or separate gearboxes where a multigrade engine oil is specifiedMotorcycles with back torque limiters\r\nMotorcycles with exhaust catalytic converters\r\nLatest generation, four-stroke scooter engines', 100, '2023-06-28', 3, '2023-06-29', 3, 1),
(8, 1, 12, 11, 'Honda dio oil filter', 'dio oil filter', '00106', '64aa5e4cf321e5.75670534.jpg', NULL, NULL, NULL, 'Genuine part from Honda distributors in Sri Lanka.', 100, '2023-07-09', 3, '0000-00-00', 0, 1),
(9, 2, 13, 2, 'Mobil 1 Racing 4T', 'Mobil 1 Racing 4T engine oil', '00107', '64b27be45a4ef6.89316333.jpg', 'motorbike', '10W-40', 1000, 'Delivers racing performance for on-road, high-performance 4-stroke motorcycles', 100, '2023-07-15', 4, '0000-00-00', 0, 1),
(10, 2, 13, 2, 'Mobil V Twin', 'Mobil V Twin engine oil', '00108', '64b27f427794a5.24598932.png', 'motorbike', '20W-50', 1000, 'Get outstanding performance and protection for four-cycle, V-Twin engines.', 100, '2023-07-15', 4, '2023-07-21', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemcatalog_vehicles`
--

CREATE TABLE `tbl_itemcatalog_vehicles` (
  `catalogvehicleid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemcatalog_vehicles`
--

INSERT INTO `tbl_itemcatalog_vehicles` (`catalogvehicleid`, `catalogid`, `vehicleid`, `adddate`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 1, 9, '2023-04-20', 3, '0000-00-00', 0),
(2, 1, 10, '2023-04-20', 3, '0000-00-00', 0),
(3, 1, 11, '2023-04-20', 3, '0000-00-00', 0),
(4, 1, 12, '2023-04-20', 3, '0000-00-00', 0),
(5, 2, 2, '2023-04-20', 3, '0000-00-00', 0),
(6, 2, 3, '2023-04-20', 3, '0000-00-00', 0),
(7, 2, 4, '2023-04-20', 3, '0000-00-00', 0),
(26, 6, 9, '2023-06-29', 3, '0000-00-00', 0),
(27, 6, 10, '2023-06-29', 3, '0000-00-00', 0),
(28, 6, 11, '2023-06-29', 3, '0000-00-00', 0),
(29, 6, 12, '2023-06-29', 3, '0000-00-00', 0),
(30, 8, 9, '2023-07-09', 3, '0000-00-00', 0),
(31, 8, 10, '2023-07-09', 3, '0000-00-00', 0),
(32, 8, 11, '2023-07-09', 3, '0000-00-00', 0),
(33, 8, 12, '2023-07-09', 3, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemcategories`
--

CREATE TABLE `tbl_itemcategories` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(32) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemcategories`
--

INSERT INTO `tbl_itemcategories` (`categoryid`, `categoryname`, `deletestatus`, `adduser`, `adddate`, `updateuser`, `updatedate`) VALUES
(1, 'spare parts', 1, 3, '2023-04-01', 3, '2023-06-27'),
(2, 'oil', 1, 3, '2023-04-01', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemprice`
--

CREATE TABLE `tbl_itemprice` (
  `pricesid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `buyingprice` decimal(18,2) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date DEFAULT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemprice`
--

INSERT INTO `tbl_itemprice` (`pricesid`, `catalogid`, `buyingprice`, `adddate`, `adduser`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 3, '2100.00', '2023-07-17', 4, 4, '2023-07-18', 0),
(2, 3, '2100.00', '2023-07-17', 4, 4, '2023-07-18', 0),
(3, 5, '850.00', '2023-07-18', 4, 0, NULL, 1),
(4, 7, '2100.00', '2023-07-18', 4, 0, NULL, 1),
(5, 9, '1800.00', '2023-07-18', 4, 0, NULL, 1),
(6, 10, '1700.00', '2023-07-18', 4, 0, NULL, 1),
(7, 1, '0.25', '2023-07-18', 4, 4, '2023-07-25', 0),
(8, 2, '1000.00', '2023-07-18', 4, 0, NULL, 1),
(9, 6, '800.00', '2023-07-18', 4, 0, NULL, 1),
(10, 8, '850.00', '2023-07-18', 4, 0, NULL, 1),
(11, 3, '2100.00', '2023-07-23', 4, 0, NULL, 1),
(12, 1, '1200.00', '2023-07-25', 4, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemquotation`
--

CREATE TABLE `tbl_itemquotation` (
  `quotationid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `note` text NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `itemname` varchar(64) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemquotation`
--

INSERT INTO `tbl_itemquotation` (`quotationid`, `supplierid`, `catalogid`, `note`, `adddate`, `adduser`, `deletestatus`, `itemname`, `quantity`) VALUES
(1, 3, 9, '', '2023-07-17', 4, 1, '', 0),
(2, 4, 7, 'What is the latest price of this item?', '2023-07-17', 4, 1, 'Caltex super 4T', 100),
(3, 4, 7, 'What is the latest price of this item?', '2023-07-17', 4, 1, 'Caltex super 4T', 100),
(4, 4, 5, 'What is the latest prices of this Caltex Brake Fluid DOT 3', '2023-07-17', 4, 1, 'Caltex Brake Fluid DOT 3', 100),
(5, 2, 3, 'What is the price of Havoline Supermatic 4T SemiSynthetic SAE ?', '2023-07-17', 4, 1, 'Havoline Supermatic 4T SemiSynthetic SAE', 10),
(6, 4, 5, 'what is the bulk price of Caltex Brake Fluid DOT 3 ?', '2023-07-21', 4, 1, 'Caltex Brake Fluid DOT 3', 100),
(7, 3, 10, 'what is the bulk price?', '2023-07-21', 4, 1, 'Mobil V Twin', 100),
(8, 3, 10, 'I want to get a quotation for this item', '2023-07-21', 4, 1, 'Mobil V Twin', 100),
(9, 4, 5, 'Please send your price list for Caltex Brake Fluid DOT 3', '2023-07-22', 4, 1, 'Caltex Brake Fluid DOT 3', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemsofsupplier`
--

CREATE TABLE `tbl_itemsofsupplier` (
  `itemofsupplierid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemsofsupplier`
--

INSERT INTO `tbl_itemsofsupplier` (`itemofsupplierid`, `supplierid`, `catalogid`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(10, 1, 1, '2023-07-18', 4, '0000-00-00', 0, 1),
(11, 1, 2, '2023-07-18', 4, '0000-00-00', 0, 1),
(12, 1, 6, '2023-07-18', 4, '0000-00-00', 0, 1),
(13, 1, 8, '2023-07-18', 4, '0000-00-00', 0, 1),
(14, 2, 3, '2023-07-18', 4, '0000-00-00', 0, 1),
(15, 3, 9, '2023-07-18', 4, '0000-00-00', 0, 1),
(16, 3, 10, '2023-07-18', 4, '0000-00-00', 0, 1),
(17, 4, 7, '2023-07-18', 4, '0000-00-00', 0, 1),
(18, 4, 5, '2023-07-18', 4, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemstock`
--

CREATE TABLE `tbl_itemstock` (
  `itemstockid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `purchasedate` date NOT NULL,
  `quntity` int(32) NOT NULL,
  `buyingprice` float(16,2) NOT NULL,
  `sellingprice` float(16,2) NOT NULL,
  `discount` decimal(11,2) NOT NULL,
  `issuedqty` int(11) NOT NULL,
  `stockstatus` int(11) NOT NULL DEFAULT 1,
  `issueddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemstock`
--

INSERT INTO `tbl_itemstock` (`itemstockid`, `catalogid`, `purchasedate`, `quntity`, `buyingprice`, `sellingprice`, `discount`, `issuedqty`, `stockstatus`, `issueddate`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 3, '2023-07-18', 40, 2100.00, 2250.00, '0.00', 33, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(2, 5, '2023-07-18', 100, 850.00, 1000.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(3, 9, '2023-07-18', 50, 1800.00, 2000.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(4, 1, '2023-07-18', 80, 1200.00, 1450.00, '0.00', 11, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(5, 7, '2023-07-18', 40, 2100.00, 2350.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(6, 10, '2023-07-18', 50, 1700.00, 1850.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(7, 2, '2023-07-18', 100, 1000.00, 1200.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(8, 6, '2023-07-18', 100, 800.00, 1000.00, '0.00', 1, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(9, 8, '2023-07-18', 100, 850.00, 1000.00, '0.00', 32, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(10, 1, '2023-07-18', 50, 1200.00, 1350.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-18', 0, '0000-00-00', 1),
(11, 2, '2023-07-20', 10, 1000.00, 1250.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(12, 5, '2023-07-20', 10, 850.00, 1100.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(15, 9, '2023-07-20', 30, 1800.00, 2000.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(17, 10, '2023-07-20', 10, 1700.00, 1850.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(18, 9, '2023-07-20', 20, 1800.00, 2000.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(19, 10, '2023-07-20', 20, 1700.00, 1850.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-20', 0, '0000-00-00', 1),
(20, 3, '2023-07-21', 40, 2100.00, 2350.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-21', 0, '0000-00-00', 1),
(21, 9, '2023-07-21', 5, 1800.00, 2000.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-21', 0, '0000-00-00', 1),
(22, 7, '2023-07-22', 8, 2100.00, 2250.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-22', 0, '0000-00-00', 1),
(23, 10, '2023-07-25', 20, 1700.00, 1850.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-25', 0, '0000-00-00', 1),
(24, 7, '2023-07-27', 30, 2100.00, 2350.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1),
(25, 10, '2023-07-27', 20, 1700.00, 1850.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1),
(26, 7, '2023-07-27', 20, 2100.00, 2350.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1),
(27, 7, '2023-07-27', 15, 2100.00, 2250.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1),
(28, 3, '2023-07-27', 10, 2100.00, 2250.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1),
(29, 3, '2023-07-27', 40, 2100.00, 2300.00, '0.00', 0, 1, '0000-00-00', 3, '2023-07-27', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_itemsubcategories`
--

CREATE TABLE `tbl_itemsubcategories` (
  `subcategoryid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `subcategoryname` varchar(32) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_itemsubcategories`
--

INSERT INTO `tbl_itemsubcategories` (`subcategoryid`, `categoryid`, `subcategoryname`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 1, 'air filter', 3, '2023-04-03', 3, '2023-06-27', 1),
(2, 2, 'engine oil', 3, '2023-04-03', 3, '2023-06-27', 1),
(3, 1, 'break cable', 3, '2023-04-03', 3, '2023-06-27', 1),
(4, 1, 'clutch cable', 3, '2023-04-03', 3, '2023-06-27', 1),
(5, 2, 'break oil', 3, '2023-04-03', 0, '0000-00-00', 1),
(6, 1, 'head light', 3, '2023-04-03', 3, '2023-06-27', 1),
(7, 1, 'break pad', 3, '2023-04-03', 3, '2023-06-27', 1),
(11, 1, 'Oil filter', 3, '2023-07-09', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardassignitems`
--

CREATE TABLE `tbl_jobcardassignitems` (
  `jobcardassignitemid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `issuestatus` varchar(8) NOT NULL DEFAULT 'none',
  `issueqty` int(11) NOT NULL,
  `issuedate` date DEFAULT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardassignitems`
--

INSERT INTO `tbl_jobcardassignitems` (`jobcardassignitemid`, `jobcardid`, `orderid`, `catalogid`, `quantity`, `amount`, `issuestatus`, `issueqty`, `issuedate`, `deletestatus`, `adddate`, `adduser`) VALUES
(1, 1, 1, 3, 1, '2250.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(2, 1, 1, 1, 1, '1450.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(3, 1, 1, 8, 1, '1000.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(4, 2, 2, 3, 1, '2250.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(5, 2, 2, 1, 1, '1450.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(6, 2, 2, 8, 1, '1000.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(7, 3, 3, 3, 1, '2250.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(8, 3, 3, 8, 1, '1000.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(9, 4, 4, 3, 1, '2250.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(10, 4, 4, 6, 1, '1000.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(11, 4, 4, 8, 1, '1000.00', 'done', 1, '2023-07-18', 1, '2023-07-18', 26),
(12, 5, 5, 3, 1, '2250.00', 'done', 1, '2023-07-19', 1, '2023-07-19', 26),
(13, 5, 5, 8, 1, '1000.00', 'done', 1, '2023-07-19', 1, '2023-07-19', 26),
(14, 7, 6, 3, 1, '2250.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(15, 7, 6, 8, 1, '1000.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(16, 8, 7, 3, 1, '2250.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(17, 8, 7, 8, 1, '1000.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(18, 9, 8, 3, 1, '2250.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(19, 9, 8, 8, 1, '1000.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(20, 10, 9, 3, 1, '2250.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(21, 10, 9, 8, 1, '1000.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(22, 11, 10, 3, 1, '2250.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(23, 11, 10, 8, 1, '1000.00', 'done', 1, '2023-07-22', 1, '2023-07-22', 26),
(26, 13, 12, 3, 1, '2250.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(27, 13, 12, 8, 1, '1000.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(28, 12, 11, 3, 1, '2250.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(29, 12, 11, 8, 1, '1000.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(30, 12, 11, 1, 1, '1450.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(31, 14, 13, 3, 1, '2250.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(32, 14, 13, 8, 1, '1000.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(33, 15, 14, 3, 1, '2250.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(34, 15, 14, 8, 1, '1000.00', 'done', 1, '2023-07-23', 1, '2023-07-23', 26),
(35, 16, 15, 3, 1, '2250.00', 'done', 1, '2023-07-24', 1, '2023-07-24', 26),
(36, 16, 15, 8, 1, '1000.00', 'done', 1, '2023-07-24', 1, '2023-07-24', 26),
(37, 17, 16, 3, 1, '2250.00', 'done', 1, '2023-07-24', 1, '2023-07-24', 26),
(38, 17, 16, 8, 1, '1000.00', 'done', 1, '2023-07-24', 1, '2023-07-24', 26),
(39, 18, 17, 3, 1, '2250.00', 'done', 1, '2023-07-26', 1, '2023-07-26', 26),
(40, 18, 17, 8, 1, '1000.00', 'done', 1, '2023-07-26', 1, '2023-07-26', 26),
(41, 21, 18, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(42, 21, 18, 1, 1, '1450.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(43, 21, 18, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(44, 23, 19, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(45, 23, 19, 1, 1, '1450.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(46, 23, 19, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(47, 24, 20, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(48, 24, 20, 1, 1, '1450.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(49, 24, 20, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(50, 25, 21, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(51, 25, 21, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(52, 26, 22, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(53, 26, 22, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(54, 27, 23, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(55, 27, 23, 1, 1, '1450.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(56, 27, 23, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(57, 22, 24, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(58, 22, 24, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(59, 19, 25, 3, 1, '2250.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(60, 19, 25, 8, 1, '1000.00', 'done', 1, '2023-07-27', 1, '2023-07-27', 26),
(61, 28, 26, 3, 1, '2250.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(62, 28, 26, 1, 1, '1450.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(63, 28, 26, 8, 1, '1000.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(64, 29, 27, 3, 1, '2250.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(65, 29, 27, 1, 1, '1450.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(66, 29, 27, 8, 1, '1000.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(67, 30, 28, 3, 1, '4500.00', 'done', 2, '2023-07-28', 1, '2023-07-28', 26),
(68, 30, 28, 1, 1, '1450.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(69, 30, 28, 8, 1, '1000.00', 'done', 1, '2023-07-28', 1, '2023-07-28', 26),
(70, 31, 29, 3, 1, '2250.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(71, 31, 29, 8, 1, '1000.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(72, 32, 30, 3, 1, '2250.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(73, 32, 30, 8, 1, '1000.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(74, 33, 31, 3, 1, '2250.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(75, 33, 31, 1, 1, '1450.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(76, 33, 31, 8, 1, '1000.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(77, 34, 32, 3, 1, '2250.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(78, 34, 32, 8, 1, '1000.00', 'done', 1, '2023-07-29', 1, '2023-07-29', 26),
(79, 36, 33, 3, 1, '0.00', 'none', 0, NULL, 1, '2023-07-31', 26),
(80, 36, 33, 8, 1, '0.00', 'none', 0, NULL, 1, '2023-07-31', 26);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardassignserviceslist`
--

CREATE TABLE `tbl_jobcardassignserviceslist` (
  `jobcardassignserviceid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardassignserviceslist`
--

INSERT INTO `tbl_jobcardassignserviceslist` (`jobcardassignserviceid`, `jobcardid`, `subserviceid`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 1, 1, '2023-07-18', 26, '0000-00-00', 0, 1),
(2, 1, 3, '2023-07-18', 26, '0000-00-00', 0, 1),
(3, 1, 5, '2023-07-18', 26, '0000-00-00', 0, 1),
(4, 1, 4, '2023-07-18', 26, '0000-00-00', 0, 1),
(5, 1, 8, '2023-07-18', 26, '0000-00-00', 0, 1),
(6, 2, 1, '2023-07-18', 26, '0000-00-00', 0, 1),
(7, 2, 3, '2023-07-18', 26, '0000-00-00', 0, 1),
(8, 2, 5, '2023-07-18', 26, '0000-00-00', 0, 1),
(9, 2, 4, '2023-07-18', 26, '0000-00-00', 0, 1),
(10, 2, 8, '2023-07-18', 26, '0000-00-00', 0, 1),
(11, 3, 1, '2023-07-18', 26, '0000-00-00', 0, 1),
(12, 3, 2, '2023-07-18', 26, '0000-00-00', 0, 1),
(13, 3, 3, '2023-07-18', 26, '0000-00-00', 0, 1),
(14, 3, 5, '2023-07-18', 26, '0000-00-00', 0, 1),
(15, 3, 4, '2023-07-18', 26, '0000-00-00', 0, 1),
(16, 3, 8, '2023-07-18', 26, '0000-00-00', 0, 1),
(17, 4, 1, '2023-07-18', 26, '0000-00-00', 0, 1),
(18, 4, 2, '2023-07-18', 26, '0000-00-00', 0, 1),
(19, 4, 3, '2023-07-18', 26, '0000-00-00', 0, 1),
(20, 4, 5, '2023-07-18', 26, '0000-00-00', 0, 1),
(21, 4, 4, '2023-07-18', 26, '0000-00-00', 0, 1),
(22, 4, 8, '2023-07-18', 26, '0000-00-00', 0, 1),
(23, 5, 3, '2023-07-19', 26, '0000-00-00', 0, 1),
(24, 5, 2, '2023-07-19', 26, '0000-00-00', 0, 1),
(25, 5, 5, '2023-07-19', 26, '0000-00-00', 0, 1),
(26, 6, 1, '2023-07-19', 26, '0000-00-00', 0, 1),
(27, 6, 4, '2023-07-19', 26, '0000-00-00', 0, 1),
(28, 6, 8, '2023-07-19', 26, '0000-00-00', 0, 1),
(29, 7, 1, '2023-07-22', 26, '0000-00-00', 0, 1),
(30, 7, 2, '2023-07-22', 26, '0000-00-00', 0, 1),
(31, 7, 3, '2023-07-22', 26, '0000-00-00', 0, 1),
(32, 7, 5, '2023-07-22', 26, '0000-00-00', 0, 1),
(33, 7, 4, '2023-07-22', 26, '0000-00-00', 0, 1),
(34, 7, 8, '2023-07-22', 26, '0000-00-00', 0, 1),
(35, 8, 1, '2023-07-22', 26, '0000-00-00', 0, 1),
(36, 8, 2, '2023-07-22', 26, '0000-00-00', 0, 1),
(37, 8, 3, '2023-07-22', 26, '0000-00-00', 0, 1),
(38, 8, 5, '2023-07-22', 26, '0000-00-00', 0, 1),
(39, 8, 4, '2023-07-22', 26, '0000-00-00', 0, 1),
(40, 8, 8, '2023-07-22', 26, '0000-00-00', 0, 1),
(41, 9, 1, '2023-07-22', 26, '0000-00-00', 0, 1),
(42, 9, 2, '2023-07-22', 26, '0000-00-00', 0, 1),
(43, 9, 3, '2023-07-22', 26, '0000-00-00', 0, 1),
(44, 9, 5, '2023-07-22', 26, '0000-00-00', 0, 1),
(45, 9, 4, '2023-07-22', 26, '0000-00-00', 0, 1),
(46, 9, 8, '2023-07-22', 26, '0000-00-00', 0, 1),
(47, 10, 1, '2023-07-22', 26, '0000-00-00', 0, 1),
(48, 10, 2, '2023-07-22', 26, '0000-00-00', 0, 1),
(49, 10, 3, '2023-07-22', 26, '0000-00-00', 0, 1),
(50, 10, 5, '2023-07-22', 26, '0000-00-00', 0, 1),
(51, 10, 4, '2023-07-22', 26, '0000-00-00', 0, 1),
(52, 10, 8, '2023-07-22', 26, '0000-00-00', 0, 1),
(53, 11, 3, '2023-07-22', 26, '0000-00-00', 0, 1),
(54, 11, 2, '2023-07-22', 26, '0000-00-00', 0, 1),
(55, 11, 5, '2023-07-22', 26, '0000-00-00', 0, 1),
(62, 13, 1, '2023-07-23', 26, '0000-00-00', 0, 1),
(63, 13, 2, '2023-07-23', 26, '0000-00-00', 0, 1),
(64, 13, 3, '2023-07-23', 26, '0000-00-00', 0, 1),
(65, 13, 5, '2023-07-23', 26, '0000-00-00', 0, 1),
(66, 13, 4, '2023-07-23', 26, '0000-00-00', 0, 1),
(67, 13, 8, '2023-07-23', 26, '0000-00-00', 0, 1),
(68, 12, 1, '2023-07-23', 26, '0000-00-00', 0, 1),
(69, 12, 3, '2023-07-23', 26, '0000-00-00', 0, 1),
(70, 12, 5, '2023-07-23', 26, '0000-00-00', 0, 1),
(71, 12, 4, '2023-07-23', 26, '0000-00-00', 0, 1),
(72, 12, 8, '2023-07-23', 26, '0000-00-00', 0, 1),
(73, 14, 1, '2023-07-23', 26, '0000-00-00', 0, 1),
(74, 14, 2, '2023-07-23', 26, '0000-00-00', 0, 1),
(75, 14, 3, '2023-07-23', 26, '0000-00-00', 0, 1),
(76, 14, 5, '2023-07-23', 26, '0000-00-00', 0, 1),
(77, 14, 4, '2023-07-23', 26, '0000-00-00', 0, 1),
(78, 14, 8, '2023-07-23', 26, '0000-00-00', 0, 1),
(79, 15, 1, '2023-07-23', 26, '0000-00-00', 0, 1),
(80, 15, 2, '2023-07-23', 26, '0000-00-00', 0, 1),
(81, 15, 3, '2023-07-23', 26, '0000-00-00', 0, 1),
(82, 15, 5, '2023-07-23', 26, '0000-00-00', 0, 1),
(83, 15, 4, '2023-07-23', 26, '0000-00-00', 0, 1),
(84, 15, 8, '2023-07-23', 26, '0000-00-00', 0, 1),
(85, 16, 1, '2023-07-24', 26, '0000-00-00', 0, 1),
(86, 16, 2, '2023-07-24', 26, '0000-00-00', 0, 1),
(87, 16, 3, '2023-07-24', 26, '0000-00-00', 0, 1),
(88, 16, 5, '2023-07-24', 26, '0000-00-00', 0, 1),
(89, 16, 4, '2023-07-24', 26, '0000-00-00', 0, 1),
(90, 16, 8, '2023-07-24', 26, '0000-00-00', 0, 1),
(91, 17, 1, '2023-07-24', 26, '0000-00-00', 0, 1),
(92, 17, 2, '2023-07-24', 26, '0000-00-00', 0, 1),
(93, 17, 3, '2023-07-24', 26, '0000-00-00', 0, 1),
(94, 17, 5, '2023-07-24', 26, '0000-00-00', 0, 1),
(95, 17, 4, '2023-07-24', 26, '0000-00-00', 0, 1),
(96, 17, 8, '2023-07-24', 26, '0000-00-00', 0, 1),
(97, 18, 1, '2023-07-26', 26, '0000-00-00', 0, 1),
(98, 18, 2, '2023-07-26', 26, '0000-00-00', 0, 1),
(99, 18, 3, '2023-07-26', 26, '0000-00-00', 0, 1),
(100, 18, 5, '2023-07-26', 26, '0000-00-00', 0, 1),
(101, 18, 4, '2023-07-26', 26, '0000-00-00', 0, 1),
(102, 18, 8, '2023-07-26', 26, '0000-00-00', 0, 1),
(103, 21, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(104, 21, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(105, 21, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(106, 21, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(107, 21, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(108, 23, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(109, 23, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(110, 23, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(111, 23, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(112, 23, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(113, 24, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(114, 24, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(115, 24, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(116, 24, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(117, 24, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(118, 25, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(119, 25, 2, '2023-07-27', 26, '0000-00-00', 0, 1),
(120, 25, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(121, 25, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(122, 25, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(123, 25, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(124, 26, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(125, 26, 2, '2023-07-27', 26, '0000-00-00', 0, 1),
(126, 26, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(127, 26, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(128, 26, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(129, 26, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(130, 27, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(131, 27, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(132, 27, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(133, 27, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(134, 27, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(135, 22, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(136, 22, 2, '2023-07-27', 26, '0000-00-00', 0, 1),
(137, 22, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(138, 22, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(139, 22, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(140, 22, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(141, 19, 1, '2023-07-27', 26, '0000-00-00', 0, 1),
(142, 19, 2, '2023-07-27', 26, '0000-00-00', 0, 1),
(143, 19, 3, '2023-07-27', 26, '0000-00-00', 0, 1),
(144, 19, 5, '2023-07-27', 26, '0000-00-00', 0, 1),
(145, 19, 4, '2023-07-27', 26, '0000-00-00', 0, 1),
(146, 19, 8, '2023-07-27', 26, '0000-00-00', 0, 1),
(147, 28, 1, '2023-07-28', 26, '0000-00-00', 0, 1),
(148, 28, 3, '2023-07-28', 26, '0000-00-00', 0, 1),
(149, 28, 5, '2023-07-28', 26, '0000-00-00', 0, 1),
(150, 28, 4, '2023-07-28', 26, '0000-00-00', 0, 1),
(151, 28, 8, '2023-07-28', 26, '0000-00-00', 0, 1),
(152, 29, 1, '2023-07-28', 26, '0000-00-00', 0, 1),
(153, 29, 3, '2023-07-28', 26, '0000-00-00', 0, 1),
(154, 29, 5, '2023-07-28', 26, '0000-00-00', 0, 1),
(155, 29, 4, '2023-07-28', 26, '0000-00-00', 0, 1),
(156, 29, 8, '2023-07-28', 26, '0000-00-00', 0, 1),
(157, 30, 1, '2023-07-28', 26, '0000-00-00', 0, 1),
(158, 30, 3, '2023-07-28', 26, '0000-00-00', 0, 1),
(159, 30, 5, '2023-07-28', 26, '0000-00-00', 0, 1),
(160, 30, 4, '2023-07-28', 26, '0000-00-00', 0, 1),
(161, 30, 8, '2023-07-28', 26, '0000-00-00', 0, 1),
(162, 31, 1, '2023-07-29', 26, '0000-00-00', 0, 1),
(163, 31, 2, '2023-07-29', 26, '0000-00-00', 0, 1),
(164, 31, 3, '2023-07-29', 26, '0000-00-00', 0, 1),
(165, 31, 5, '2023-07-29', 26, '0000-00-00', 0, 1),
(166, 31, 4, '2023-07-29', 26, '0000-00-00', 0, 1),
(167, 31, 8, '2023-07-29', 26, '0000-00-00', 0, 1),
(168, 32, 1, '2023-07-29', 26, '0000-00-00', 0, 1),
(169, 32, 2, '2023-07-29', 26, '0000-00-00', 0, 1),
(170, 32, 3, '2023-07-29', 26, '0000-00-00', 0, 1),
(171, 32, 5, '2023-07-29', 26, '0000-00-00', 0, 1),
(172, 32, 4, '2023-07-29', 26, '0000-00-00', 0, 1),
(173, 32, 8, '2023-07-29', 26, '0000-00-00', 0, 1),
(174, 33, 1, '2023-07-29', 26, '0000-00-00', 0, 1),
(175, 33, 3, '2023-07-29', 26, '0000-00-00', 0, 1),
(176, 33, 5, '2023-07-29', 26, '0000-00-00', 0, 1),
(177, 33, 4, '2023-07-29', 26, '0000-00-00', 0, 1),
(178, 33, 8, '2023-07-29', 26, '0000-00-00', 0, 1),
(179, 34, 1, '2023-07-29', 26, '0000-00-00', 0, 1),
(180, 34, 2, '2023-07-29', 26, '0000-00-00', 0, 1),
(181, 34, 3, '2023-07-29', 26, '0000-00-00', 0, 1),
(182, 34, 5, '2023-07-29', 26, '0000-00-00', 0, 1),
(183, 34, 4, '2023-07-29', 26, '0000-00-00', 0, 1),
(184, 34, 8, '2023-07-29', 26, '0000-00-00', 0, 1),
(185, 36, 1, '2023-07-31', 26, '0000-00-00', 0, 1),
(186, 36, 2, '2023-07-31', 26, '0000-00-00', 0, 1),
(187, 36, 3, '2023-07-31', 26, '0000-00-00', 0, 1),
(188, 36, 5, '2023-07-31', 26, '0000-00-00', 0, 1),
(189, 36, 4, '2023-07-31', 26, '0000-00-00', 0, 1),
(190, 36, 8, '2023-07-31', 26, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardassignsubservices`
--

CREATE TABLE `tbl_jobcardassignsubservices` (
  `jobcardassignsubserviceid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardassignsubservices`
--

INSERT INTO `tbl_jobcardassignsubservices` (`jobcardassignsubserviceid`, `jobcardid`, `subserviceid`, `adduser`, `adddate`, `deletestatus`) VALUES
(1, 1, 20, 26, '2023-07-18', 1),
(2, 1, 6, 26, '2023-07-18', 1),
(3, 2, 6, 26, '2023-07-18', 1),
(4, 4, 20, 26, '2023-07-18', 1),
(5, 4, 21, 26, '2023-07-18', 1),
(6, 7, 20, 26, '2023-07-22', 1),
(8, 13, 10, 26, '2023-07-23', 1),
(9, 13, 6, 26, '2023-07-23', 1),
(10, 13, 20, 26, '2023-07-23', 1),
(11, 12, 6, 26, '2023-07-23', 1),
(12, 15, 20, 26, '2023-07-23', 1),
(13, 21, 20, 26, '2023-07-27', 1),
(14, 23, 20, 26, '2023-07-27', 1),
(15, 24, 20, 26, '2023-07-27', 1),
(16, 25, 20, 26, '2023-07-27', 1),
(17, 26, 20, 26, '2023-07-27', 1),
(18, 27, 20, 26, '2023-07-27', 1),
(19, 27, 6, 26, '2023-07-27', 1),
(20, 28, 20, 26, '2023-07-28', 1),
(21, 28, 6, 26, '2023-07-28', 1),
(22, 29, 20, 26, '2023-07-28', 1),
(23, 29, 6, 26, '2023-07-28', 1),
(24, 30, 20, 26, '2023-07-28', 1),
(25, 30, 6, 26, '2023-07-28', 1),
(26, 32, 20, 26, '2023-07-29', 1),
(27, 33, 20, 26, '2023-07-29', 1),
(28, 33, 6, 26, '2023-07-29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardinvestigationtasks`
--

CREATE TABLE `tbl_jobcardinvestigationtasks` (
  `jobcardinvestigationtaskid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `investigationtaskid` int(11) NOT NULL,
  `taskstatus` varchar(64) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardinvestigationtasks`
--

INSERT INTO `tbl_jobcardinvestigationtasks` (`jobcardinvestigationtaskid`, `jobcardid`, `investigationtaskid`, `taskstatus`, `adduser`, `adddate`, `deletestatus`) VALUES
(1, 1, 1, 'good', 26, '2023-07-18', 1),
(2, 1, 2, 'good', 26, '2023-07-18', 1),
(3, 1, 3, 'good', 26, '2023-07-18', 1),
(4, 1, 4, 'good', 26, '2023-07-18', 1),
(5, 1, 5, 'adjust', 26, '2023-07-18', 1),
(6, 1, 6, 'good', 26, '2023-07-18', 1),
(7, 1, 7, 'good', 26, '2023-07-18', 1),
(8, 1, 8, 'good', 26, '2023-07-18', 1),
(9, 1, 9, 'replace', 26, '2023-07-18', 1),
(10, 1, 10, 'good', 26, '2023-07-18', 1),
(11, 1, 11, 'replace', 26, '2023-07-18', 1),
(12, 1, 12, 'replace', 26, '2023-07-18', 1),
(13, 1, 13, 'good', 26, '2023-07-18', 1),
(14, 1, 14, 'good', 26, '2023-07-18', 1),
(15, 1, 15, 'good', 26, '2023-07-18', 1),
(16, 2, 1, 'good', 26, '2023-07-18', 1),
(17, 2, 3, 'good', 26, '2023-07-18', 1),
(18, 2, 4, 'good', 26, '2023-07-18', 1),
(19, 2, 5, 'good', 26, '2023-07-18', 1),
(20, 2, 6, 'good', 26, '2023-07-18', 1),
(21, 2, 7, 'good', 26, '2023-07-18', 1),
(22, 2, 8, 'good', 26, '2023-07-18', 1),
(23, 2, 9, 'replace', 26, '2023-07-18', 1),
(24, 2, 10, 'good', 26, '2023-07-18', 1),
(25, 2, 11, 'replace', 26, '2023-07-18', 1),
(26, 2, 12, 'replace', 26, '2023-07-18', 1),
(27, 2, 13, 'good', 26, '2023-07-18', 1),
(28, 2, 14, 'good', 26, '2023-07-18', 1),
(29, 2, 15, 'good', 26, '2023-07-18', 1),
(30, 3, 1, 'good', 26, '2023-07-18', 1),
(31, 3, 2, 'good', 26, '2023-07-18', 1),
(32, 3, 3, 'good', 26, '2023-07-18', 1),
(33, 3, 4, 'good', 26, '2023-07-18', 1),
(34, 3, 5, 'good', 26, '2023-07-18', 1),
(35, 3, 6, 'good', 26, '2023-07-18', 1),
(36, 3, 7, 'good', 26, '2023-07-18', 1),
(37, 3, 8, 'good', 26, '2023-07-18', 1),
(38, 3, 9, 'replace', 26, '2023-07-18', 1),
(39, 3, 10, 'good', 26, '2023-07-18', 1),
(40, 3, 11, 'good', 26, '2023-07-18', 1),
(41, 3, 12, 'replace', 26, '2023-07-18', 1),
(42, 3, 13, 'good', 26, '2023-07-18', 1),
(43, 3, 14, 'good', 26, '2023-07-18', 1),
(44, 3, 15, 'good', 26, '2023-07-18', 1),
(45, 4, 1, 'good', 26, '2023-07-18', 1),
(46, 4, 2, 'replace', 26, '2023-07-18', 1),
(47, 4, 3, 'good', 26, '2023-07-18', 1),
(48, 4, 4, 'good', 26, '2023-07-18', 1),
(49, 4, 5, 'adjust', 26, '2023-07-18', 1),
(50, 4, 6, 'good', 26, '2023-07-18', 1),
(51, 4, 7, 'good', 26, '2023-07-18', 1),
(52, 4, 8, 'good', 26, '2023-07-18', 1),
(53, 4, 9, 'replace', 26, '2023-07-18', 1),
(54, 4, 10, 'good', 26, '2023-07-18', 1),
(55, 4, 11, 'good', 26, '2023-07-18', 1),
(56, 4, 12, 'replace', 26, '2023-07-18', 1),
(57, 4, 13, 'good', 26, '2023-07-18', 1),
(58, 4, 14, 'good', 26, '2023-07-18', 1),
(59, 4, 15, 'good', 26, '2023-07-18', 1),
(60, 5, 1, 'good', 26, '2023-07-19', 1),
(61, 5, 2, 'good', 26, '2023-07-19', 1),
(62, 5, 3, 'good', 26, '2023-07-19', 1),
(63, 5, 4, 'good', 26, '2023-07-19', 1),
(64, 5, 5, 'good', 26, '2023-07-19', 1),
(65, 5, 6, 'good', 26, '2023-07-19', 1),
(66, 5, 7, 'good', 26, '2023-07-19', 1),
(67, 5, 8, 'good', 26, '2023-07-19', 1),
(68, 5, 9, 'replace', 26, '2023-07-19', 1),
(69, 5, 10, 'good', 26, '2023-07-19', 1),
(70, 5, 11, 'good', 26, '2023-07-19', 1),
(71, 5, 12, 'replace', 26, '2023-07-19', 1),
(72, 5, 13, 'good', 26, '2023-07-19', 1),
(73, 5, 14, 'good', 26, '2023-07-19', 1),
(74, 5, 15, 'good', 26, '2023-07-19', 1),
(75, 5, 1, 'good', 26, '2023-07-19', 1),
(76, 5, 2, 'good', 26, '2023-07-19', 1),
(77, 5, 3, 'good', 26, '2023-07-19', 1),
(78, 5, 4, 'good', 26, '2023-07-19', 1),
(79, 5, 5, 'good', 26, '2023-07-19', 1),
(80, 5, 6, 'good', 26, '2023-07-19', 1),
(81, 5, 7, 'good', 26, '2023-07-19', 1),
(82, 5, 8, 'good', 26, '2023-07-19', 1),
(83, 5, 9, 'replace', 26, '2023-07-19', 1),
(84, 5, 10, 'good', 26, '2023-07-19', 1),
(85, 5, 11, 'good', 26, '2023-07-19', 1),
(86, 5, 12, 'replace', 26, '2023-07-19', 1),
(87, 5, 13, 'good', 26, '2023-07-19', 1),
(88, 5, 14, 'good', 26, '2023-07-19', 1),
(89, 5, 15, 'good', 26, '2023-07-19', 1),
(90, 6, 1, 'good', 26, '2023-07-19', 1),
(91, 6, 2, 'good', 26, '2023-07-19', 1),
(92, 6, 3, 'good', 26, '2023-07-19', 1),
(93, 6, 4, 'good', 26, '2023-07-19', 1),
(94, 6, 5, 'good', 26, '2023-07-19', 1),
(95, 6, 6, 'good', 26, '2023-07-19', 1),
(96, 6, 7, 'good', 26, '2023-07-19', 1),
(97, 6, 8, 'good', 26, '2023-07-19', 1),
(98, 6, 9, 'good', 26, '2023-07-19', 1),
(99, 6, 10, 'good', 26, '2023-07-19', 1),
(100, 6, 11, 'good', 26, '2023-07-19', 1),
(101, 6, 12, 'good', 26, '2023-07-19', 1),
(102, 6, 13, 'good', 26, '2023-07-19', 1),
(103, 6, 14, 'good', 26, '2023-07-19', 1),
(104, 6, 15, 'good', 26, '2023-07-19', 1),
(105, 7, 1, 'good', 26, '2023-07-22', 1),
(106, 7, 2, 'good', 26, '2023-07-22', 1),
(107, 7, 3, 'good', 26, '2023-07-22', 1),
(108, 7, 4, 'good', 26, '2023-07-22', 1),
(109, 7, 5, 'adjust', 26, '2023-07-22', 1),
(110, 7, 6, 'good', 26, '2023-07-22', 1),
(111, 7, 7, 'good', 26, '2023-07-22', 1),
(112, 7, 8, 'good', 26, '2023-07-22', 1),
(113, 7, 9, 'replace', 26, '2023-07-22', 1),
(114, 7, 10, 'good', 26, '2023-07-22', 1),
(115, 7, 11, 'good', 26, '2023-07-22', 1),
(116, 7, 12, 'replace', 26, '2023-07-22', 1),
(117, 7, 13, 'good', 26, '2023-07-22', 1),
(118, 7, 14, 'good', 26, '2023-07-22', 1),
(119, 7, 15, 'good', 26, '2023-07-22', 1),
(120, 8, 1, 'good', 26, '2023-07-22', 1),
(121, 8, 2, 'good', 26, '2023-07-22', 1),
(122, 8, 3, 'good', 26, '2023-07-22', 1),
(123, 8, 4, 'good', 26, '2023-07-22', 1),
(124, 8, 5, 'good', 26, '2023-07-22', 1),
(125, 8, 6, 'good', 26, '2023-07-22', 1),
(126, 8, 7, 'good', 26, '2023-07-22', 1),
(127, 8, 8, 'good', 26, '2023-07-22', 1),
(128, 8, 9, 'replace', 26, '2023-07-22', 1),
(129, 8, 10, 'good', 26, '2023-07-22', 1),
(130, 8, 11, 'good', 26, '2023-07-22', 1),
(131, 8, 12, 'replace', 26, '2023-07-22', 1),
(132, 8, 13, 'good', 26, '2023-07-22', 1),
(133, 8, 14, 'good', 26, '2023-07-22', 1),
(134, 8, 15, 'good', 26, '2023-07-22', 1),
(135, 9, 1, 'good', 26, '2023-07-22', 1),
(136, 9, 2, 'good', 26, '2023-07-22', 1),
(137, 9, 3, 'good', 26, '2023-07-22', 1),
(138, 9, 4, 'good', 26, '2023-07-22', 1),
(139, 9, 5, 'good', 26, '2023-07-22', 1),
(140, 9, 6, 'good', 26, '2023-07-22', 1),
(141, 9, 7, 'good', 26, '2023-07-22', 1),
(142, 9, 8, 'good', 26, '2023-07-22', 1),
(143, 9, 9, 'replace', 26, '2023-07-22', 1),
(144, 9, 10, 'good', 26, '2023-07-22', 1),
(145, 9, 11, 'good', 26, '2023-07-22', 1),
(146, 9, 12, 'replace', 26, '2023-07-22', 1),
(147, 9, 13, 'good', 26, '2023-07-22', 1),
(148, 9, 14, 'good', 26, '2023-07-22', 1),
(149, 9, 15, 'good', 26, '2023-07-22', 1),
(150, 10, 1, 'good', 26, '2023-07-22', 1),
(151, 10, 2, 'good', 26, '2023-07-22', 1),
(152, 10, 3, 'good', 26, '2023-07-22', 1),
(153, 10, 4, 'good', 26, '2023-07-22', 1),
(154, 10, 5, 'good', 26, '2023-07-22', 1),
(155, 10, 6, 'good', 26, '2023-07-22', 1),
(156, 10, 7, 'good', 26, '2023-07-22', 1),
(157, 10, 8, 'good', 26, '2023-07-22', 1),
(158, 10, 9, 'replace', 26, '2023-07-22', 1),
(159, 10, 10, 'good', 26, '2023-07-22', 1),
(160, 10, 11, 'good', 26, '2023-07-22', 1),
(161, 10, 12, 'replace', 26, '2023-07-22', 1),
(162, 10, 13, 'good', 26, '2023-07-22', 1),
(163, 10, 14, 'good', 26, '2023-07-22', 1),
(164, 10, 15, 'good', 26, '2023-07-22', 1),
(165, 11, 1, 'good', 26, '2023-07-22', 1),
(166, 11, 2, 'good', 26, '2023-07-22', 1),
(167, 11, 3, 'good', 26, '2023-07-22', 1),
(168, 11, 4, 'good', 26, '2023-07-22', 1),
(169, 11, 5, 'good', 26, '2023-07-22', 1),
(170, 11, 6, 'good', 26, '2023-07-22', 1),
(171, 11, 7, 'good', 26, '2023-07-22', 1),
(172, 11, 8, 'good', 26, '2023-07-22', 1),
(173, 11, 9, 'replace', 26, '2023-07-22', 1),
(174, 11, 10, 'good', 26, '2023-07-22', 1),
(175, 11, 11, 'good', 26, '2023-07-22', 1),
(176, 11, 12, 'replace', 26, '2023-07-22', 1),
(177, 11, 13, 'good', 26, '2023-07-22', 1),
(178, 11, 14, 'good', 26, '2023-07-22', 1),
(179, 11, 15, 'good', 26, '2023-07-22', 1),
(195, 13, 1, 'good', 26, '2023-07-23', 1),
(196, 13, 2, 'good', 26, '2023-07-23', 1),
(197, 13, 3, 'good', 26, '2023-07-23', 1),
(198, 13, 4, 'good', 26, '2023-07-23', 1),
(199, 13, 5, 'good', 26, '2023-07-23', 1),
(200, 13, 6, 'good', 26, '2023-07-23', 1),
(201, 13, 7, 'good', 26, '2023-07-23', 1),
(202, 13, 8, 'good', 26, '2023-07-23', 1),
(203, 13, 9, 'replace', 26, '2023-07-23', 1),
(204, 13, 10, 'good', 26, '2023-07-23', 1),
(205, 13, 11, 'good', 26, '2023-07-23', 1),
(206, 13, 12, 'replace', 26, '2023-07-23', 1),
(207, 13, 13, 'good', 26, '2023-07-23', 1),
(208, 13, 14, 'good', 26, '2023-07-23', 1),
(209, 13, 15, 'good', 26, '2023-07-23', 1),
(210, 12, 1, 'good', 26, '2023-07-23', 1),
(211, 12, 2, 'good', 26, '2023-07-23', 1),
(212, 12, 3, 'good', 26, '2023-07-23', 1),
(213, 12, 4, 'good', 26, '2023-07-23', 1),
(214, 12, 5, 'good', 26, '2023-07-23', 1),
(215, 12, 6, 'good', 26, '2023-07-23', 1),
(216, 12, 7, 'good', 26, '2023-07-23', 1),
(217, 12, 8, 'good', 26, '2023-07-23', 1),
(218, 12, 9, 'replace', 26, '2023-07-23', 1),
(219, 12, 10, 'good', 26, '2023-07-23', 1),
(220, 12, 11, 'replace', 26, '2023-07-23', 1),
(221, 12, 12, 'replace', 26, '2023-07-23', 1),
(222, 12, 13, 'good', 26, '2023-07-23', 1),
(223, 12, 14, 'good', 26, '2023-07-23', 1),
(224, 12, 15, 'good', 26, '2023-07-23', 1),
(225, 14, 1, 'good', 26, '2023-07-23', 1),
(226, 14, 2, 'good', 26, '2023-07-23', 1),
(227, 14, 3, 'good', 26, '2023-07-23', 1),
(228, 14, 4, 'good', 26, '2023-07-23', 1),
(229, 14, 5, 'good', 26, '2023-07-23', 1),
(230, 14, 6, 'good', 26, '2023-07-23', 1),
(231, 14, 7, 'good', 26, '2023-07-23', 1),
(232, 14, 8, 'good', 26, '2023-07-23', 1),
(233, 14, 9, 'replace', 26, '2023-07-23', 1),
(234, 14, 10, 'good', 26, '2023-07-23', 1),
(235, 14, 11, 'good', 26, '2023-07-23', 1),
(236, 14, 12, 'replace', 26, '2023-07-23', 1),
(237, 14, 13, 'good', 26, '2023-07-23', 1),
(238, 14, 14, 'good', 26, '2023-07-23', 1),
(239, 14, 15, 'good', 26, '2023-07-23', 1),
(240, 15, 1, 'good', 26, '2023-07-23', 1),
(241, 15, 2, 'good', 26, '2023-07-23', 1),
(242, 15, 3, 'good', 26, '2023-07-23', 1),
(243, 15, 4, 'good', 26, '2023-07-23', 1),
(244, 15, 5, 'adjust', 26, '2023-07-23', 1),
(245, 15, 6, 'good', 26, '2023-07-23', 1),
(246, 15, 7, 'good', 26, '2023-07-23', 1),
(247, 15, 8, 'good', 26, '2023-07-23', 1),
(248, 15, 9, 'replace', 26, '2023-07-23', 1),
(249, 15, 10, 'good', 26, '2023-07-23', 1),
(250, 15, 11, 'good', 26, '2023-07-23', 1),
(251, 15, 12, 'replace', 26, '2023-07-23', 1),
(252, 15, 13, 'good', 26, '2023-07-23', 1),
(253, 15, 14, 'good', 26, '2023-07-23', 1),
(254, 15, 15, 'good', 26, '2023-07-23', 1),
(255, 16, 1, 'good', 26, '2023-07-24', 1),
(256, 16, 2, 'good', 26, '2023-07-24', 1),
(257, 16, 3, 'good', 26, '2023-07-24', 1),
(258, 16, 4, 'good', 26, '2023-07-24', 1),
(259, 16, 5, 'good', 26, '2023-07-24', 1),
(260, 16, 6, 'good', 26, '2023-07-24', 1),
(261, 16, 7, 'good', 26, '2023-07-24', 1),
(262, 16, 8, 'good', 26, '2023-07-24', 1),
(263, 16, 9, 'replace', 26, '2023-07-24', 1),
(264, 16, 10, 'good', 26, '2023-07-24', 1),
(265, 16, 11, 'good', 26, '2023-07-24', 1),
(266, 16, 12, 'replace', 26, '2023-07-24', 1),
(267, 16, 13, 'good', 26, '2023-07-24', 1),
(268, 16, 14, 'good', 26, '2023-07-24', 1),
(269, 16, 15, 'good', 26, '2023-07-24', 1),
(270, 17, 1, 'good', 26, '2023-07-24', 1),
(271, 17, 2, 'good', 26, '2023-07-24', 1),
(272, 17, 3, 'good', 26, '2023-07-24', 1),
(273, 17, 4, 'good', 26, '2023-07-24', 1),
(274, 17, 5, 'good', 26, '2023-07-24', 1),
(275, 17, 6, 'good', 26, '2023-07-24', 1),
(276, 17, 7, 'good', 26, '2023-07-24', 1),
(277, 17, 8, 'good', 26, '2023-07-24', 1),
(278, 17, 9, 'replace', 26, '2023-07-24', 1),
(279, 17, 10, 'good', 26, '2023-07-24', 1),
(280, 17, 11, 'good', 26, '2023-07-24', 1),
(281, 17, 12, 'replace', 26, '2023-07-24', 1),
(282, 17, 13, 'good', 26, '2023-07-24', 1),
(283, 17, 14, 'good', 26, '2023-07-24', 1),
(284, 17, 15, 'good', 26, '2023-07-24', 1),
(285, 18, 1, 'good', 26, '2023-07-26', 1),
(286, 18, 2, 'good', 26, '2023-07-26', 1),
(287, 18, 3, 'good', 26, '2023-07-26', 1),
(288, 18, 4, 'good', 26, '2023-07-26', 1),
(289, 18, 5, 'good', 26, '2023-07-26', 1),
(290, 18, 6, 'good', 26, '2023-07-26', 1),
(291, 18, 7, 'good', 26, '2023-07-26', 1),
(292, 18, 8, 'good', 26, '2023-07-26', 1),
(293, 18, 9, 'replace', 26, '2023-07-26', 1),
(294, 18, 10, 'good', 26, '2023-07-26', 1),
(295, 18, 11, 'good', 26, '2023-07-26', 1),
(296, 18, 12, 'replace', 26, '2023-07-26', 1),
(297, 18, 13, 'good', 26, '2023-07-26', 1),
(298, 18, 14, 'good', 26, '2023-07-26', 1),
(299, 18, 15, 'good', 26, '2023-07-26', 1),
(300, 21, 1, 'good', 26, '2023-07-27', 1),
(301, 21, 2, 'good', 26, '2023-07-27', 1),
(302, 21, 3, 'good', 26, '2023-07-27', 1),
(303, 21, 4, 'good', 26, '2023-07-27', 1),
(304, 21, 5, 'adjust', 26, '2023-07-27', 1),
(305, 21, 6, 'good', 26, '2023-07-27', 1),
(306, 21, 7, 'good', 26, '2023-07-27', 1),
(307, 21, 8, 'good', 26, '2023-07-27', 1),
(308, 21, 9, 'replace', 26, '2023-07-27', 1),
(309, 21, 10, 'good', 26, '2023-07-27', 1),
(310, 21, 11, 'replace', 26, '2023-07-27', 1),
(311, 21, 12, 'replace', 26, '2023-07-27', 1),
(312, 21, 13, 'good', 26, '2023-07-27', 1),
(313, 21, 14, 'good', 26, '2023-07-27', 1),
(314, 21, 15, 'good', 26, '2023-07-27', 1),
(315, 23, 1, 'good', 26, '2023-07-27', 1),
(316, 23, 2, 'good', 26, '2023-07-27', 1),
(317, 23, 3, 'good', 26, '2023-07-27', 1),
(318, 23, 4, 'good', 26, '2023-07-27', 1),
(319, 23, 5, 'adjust', 26, '2023-07-27', 1),
(320, 23, 6, 'good', 26, '2023-07-27', 1),
(321, 23, 7, 'good', 26, '2023-07-27', 1),
(322, 23, 8, 'good', 26, '2023-07-27', 1),
(323, 23, 9, 'replace', 26, '2023-07-27', 1),
(324, 23, 10, 'good', 26, '2023-07-27', 1),
(325, 23, 11, 'replace', 26, '2023-07-27', 1),
(326, 23, 12, 'replace', 26, '2023-07-27', 1),
(327, 23, 13, 'good', 26, '2023-07-27', 1),
(328, 23, 14, 'good', 26, '2023-07-27', 1),
(329, 23, 15, 'good', 26, '2023-07-27', 1),
(330, 24, 1, 'good', 26, '2023-07-27', 1),
(331, 24, 2, 'good', 26, '2023-07-27', 1),
(332, 24, 3, 'good', 26, '2023-07-27', 1),
(333, 24, 4, 'good', 26, '2023-07-27', 1),
(334, 24, 5, 'adjust', 26, '2023-07-27', 1),
(335, 24, 6, 'good', 26, '2023-07-27', 1),
(336, 24, 7, 'good', 26, '2023-07-27', 1),
(337, 24, 8, 'good', 26, '2023-07-27', 1),
(338, 24, 9, 'replace', 26, '2023-07-27', 1),
(339, 24, 10, 'good', 26, '2023-07-27', 1),
(340, 24, 11, 'replace', 26, '2023-07-27', 1),
(341, 24, 12, 'replace', 26, '2023-07-27', 1),
(342, 24, 13, 'good', 26, '2023-07-27', 1),
(343, 24, 14, 'good', 26, '2023-07-27', 1),
(344, 24, 15, 'good', 26, '2023-07-27', 1),
(345, 25, 1, 'good', 26, '2023-07-27', 1),
(346, 25, 2, 'good', 26, '2023-07-27', 1),
(347, 25, 3, 'good', 26, '2023-07-27', 1),
(348, 25, 4, 'good', 26, '2023-07-27', 1),
(349, 25, 5, 'adjust', 26, '2023-07-27', 1),
(350, 25, 6, 'good', 26, '2023-07-27', 1),
(351, 25, 7, 'good', 26, '2023-07-27', 1),
(352, 25, 8, 'good', 26, '2023-07-27', 1),
(353, 25, 9, 'replace', 26, '2023-07-27', 1),
(354, 25, 10, 'good', 26, '2023-07-27', 1),
(355, 25, 11, 'good', 26, '2023-07-27', 1),
(356, 25, 12, 'replace', 26, '2023-07-27', 1),
(357, 25, 13, 'good', 26, '2023-07-27', 1),
(358, 25, 14, 'good', 26, '2023-07-27', 1),
(359, 25, 15, 'good', 26, '2023-07-27', 1),
(360, 26, 1, 'good', 26, '2023-07-27', 1),
(361, 26, 2, 'good', 26, '2023-07-27', 1),
(362, 26, 3, 'good', 26, '2023-07-27', 1),
(363, 26, 4, 'good', 26, '2023-07-27', 1),
(364, 26, 5, 'adjust', 26, '2023-07-27', 1),
(365, 26, 6, 'good', 26, '2023-07-27', 1),
(366, 26, 7, 'good', 26, '2023-07-27', 1),
(367, 26, 8, 'good', 26, '2023-07-27', 1),
(368, 26, 9, 'replace', 26, '2023-07-27', 1),
(369, 26, 10, 'good', 26, '2023-07-27', 1),
(370, 26, 11, 'good', 26, '2023-07-27', 1),
(371, 26, 12, 'replace', 26, '2023-07-27', 1),
(372, 26, 13, 'good', 26, '2023-07-27', 1),
(373, 26, 14, 'good', 26, '2023-07-27', 1),
(374, 26, 15, 'good', 26, '2023-07-27', 1),
(375, 27, 1, 'good', 26, '2023-07-27', 1),
(376, 27, 2, 'good', 26, '2023-07-27', 1),
(377, 27, 3, 'good', 26, '2023-07-27', 1),
(378, 27, 4, 'good', 26, '2023-07-27', 1),
(379, 27, 5, 'adjust', 26, '2023-07-27', 1),
(380, 27, 6, 'good', 26, '2023-07-27', 1),
(381, 27, 7, 'good', 26, '2023-07-27', 1),
(382, 27, 8, 'good', 26, '2023-07-27', 1),
(383, 27, 9, 'replace', 26, '2023-07-27', 1),
(384, 27, 10, 'good', 26, '2023-07-27', 1),
(385, 27, 11, 'replace', 26, '2023-07-27', 1),
(386, 27, 12, 'replace', 26, '2023-07-27', 1),
(387, 27, 13, 'good', 26, '2023-07-27', 1),
(388, 27, 14, 'good', 26, '2023-07-27', 1),
(389, 27, 15, 'good', 26, '2023-07-27', 1),
(390, 22, 1, 'good', 26, '2023-07-27', 1),
(391, 22, 2, 'good', 26, '2023-07-27', 1),
(392, 22, 3, 'good', 26, '2023-07-27', 1),
(393, 22, 4, 'good', 26, '2023-07-27', 1),
(394, 22, 5, 'good', 26, '2023-07-27', 1),
(395, 22, 6, 'good', 26, '2023-07-27', 1),
(396, 22, 7, 'good', 26, '2023-07-27', 1),
(397, 22, 8, 'good', 26, '2023-07-27', 1),
(398, 22, 9, 'replace', 26, '2023-07-27', 1),
(399, 22, 10, 'good', 26, '2023-07-27', 1),
(400, 22, 11, 'good', 26, '2023-07-27', 1),
(401, 22, 12, 'replace', 26, '2023-07-27', 1),
(402, 22, 13, 'good', 26, '2023-07-27', 1),
(403, 22, 14, 'good', 26, '2023-07-27', 1),
(404, 22, 15, 'good', 26, '2023-07-27', 1),
(405, 19, 1, 'good', 26, '2023-07-27', 1),
(406, 19, 2, 'good', 26, '2023-07-27', 1),
(407, 19, 3, 'good', 26, '2023-07-27', 1),
(408, 19, 4, 'good', 26, '2023-07-27', 1),
(409, 19, 5, 'good', 26, '2023-07-27', 1),
(410, 19, 6, 'good', 26, '2023-07-27', 1),
(411, 19, 7, 'good', 26, '2023-07-27', 1),
(412, 19, 8, 'good', 26, '2023-07-27', 1),
(413, 19, 9, 'replace', 26, '2023-07-27', 1),
(414, 19, 10, 'good', 26, '2023-07-27', 1),
(415, 19, 11, 'good', 26, '2023-07-27', 1),
(416, 19, 12, 'replace', 26, '2023-07-27', 1),
(417, 19, 13, 'good', 26, '2023-07-27', 1),
(418, 19, 14, 'good', 26, '2023-07-27', 1),
(419, 19, 15, 'good', 26, '2023-07-27', 1),
(420, 28, 1, 'good', 26, '2023-07-28', 1),
(421, 28, 2, 'good', 26, '2023-07-28', 1),
(422, 28, 3, 'good', 26, '2023-07-28', 1),
(423, 28, 4, 'good', 26, '2023-07-28', 1),
(424, 28, 5, 'adjust', 26, '2023-07-28', 1),
(425, 28, 6, 'good', 26, '2023-07-28', 1),
(426, 28, 7, 'good', 26, '2023-07-28', 1),
(427, 28, 8, 'good', 26, '2023-07-28', 1),
(428, 28, 9, 'replace', 26, '2023-07-28', 1),
(429, 28, 10, 'good', 26, '2023-07-28', 1),
(430, 28, 11, 'replace', 26, '2023-07-28', 1),
(431, 28, 12, 'replace', 26, '2023-07-28', 1),
(432, 28, 13, 'good', 26, '2023-07-28', 1),
(433, 28, 14, 'good', 26, '2023-07-28', 1),
(434, 28, 15, 'good', 26, '2023-07-28', 1),
(435, 29, 1, 'good', 26, '2023-07-28', 1),
(436, 29, 2, 'good', 26, '2023-07-28', 1),
(437, 29, 3, 'good', 26, '2023-07-28', 1),
(438, 29, 4, 'good', 26, '2023-07-28', 1),
(439, 29, 5, 'adjust', 26, '2023-07-28', 1),
(440, 29, 6, 'good', 26, '2023-07-28', 1),
(441, 29, 7, 'good', 26, '2023-07-28', 1),
(442, 29, 8, 'good', 26, '2023-07-28', 1),
(443, 29, 9, 'replace', 26, '2023-07-28', 1),
(444, 29, 10, 'good', 26, '2023-07-28', 1),
(445, 29, 11, 'replace', 26, '2023-07-28', 1),
(446, 29, 12, 'replace', 26, '2023-07-28', 1),
(447, 29, 13, 'good', 26, '2023-07-28', 1),
(448, 29, 14, 'good', 26, '2023-07-28', 1),
(449, 29, 15, 'good', 26, '2023-07-28', 1),
(450, 30, 1, 'good', 26, '2023-07-28', 1),
(451, 30, 2, 'good', 26, '2023-07-28', 1),
(452, 30, 3, 'good', 26, '2023-07-28', 1),
(453, 30, 4, 'good', 26, '2023-07-28', 1),
(454, 30, 5, 'adjust', 26, '2023-07-28', 1),
(455, 30, 6, 'good', 26, '2023-07-28', 1),
(456, 30, 7, 'good', 26, '2023-07-28', 1),
(457, 30, 8, 'good', 26, '2023-07-28', 1),
(458, 30, 9, 'replace', 26, '2023-07-28', 1),
(459, 30, 10, 'good', 26, '2023-07-28', 1),
(460, 30, 11, 'replace', 26, '2023-07-28', 1),
(461, 30, 12, 'replace', 26, '2023-07-28', 1),
(462, 30, 13, 'good', 26, '2023-07-28', 1),
(463, 30, 14, 'good', 26, '2023-07-28', 1),
(464, 30, 15, 'good', 26, '2023-07-28', 1),
(465, 31, 1, 'good', 26, '2023-07-29', 1),
(466, 31, 2, 'good', 26, '2023-07-29', 1),
(467, 31, 3, 'good', 26, '2023-07-29', 1),
(468, 31, 4, 'good', 26, '2023-07-29', 1),
(469, 31, 5, 'good', 26, '2023-07-29', 1),
(470, 31, 6, 'good', 26, '2023-07-29', 1),
(471, 31, 7, 'good', 26, '2023-07-29', 1),
(472, 31, 8, 'good', 26, '2023-07-29', 1),
(473, 31, 9, 'replace', 26, '2023-07-29', 1),
(474, 31, 10, 'good', 26, '2023-07-29', 1),
(475, 31, 11, 'good', 26, '2023-07-29', 1),
(476, 31, 12, 'replace', 26, '2023-07-29', 1),
(477, 31, 13, 'good', 26, '2023-07-29', 1),
(478, 31, 14, 'good', 26, '2023-07-29', 1),
(479, 31, 15, 'good', 26, '2023-07-29', 1),
(480, 32, 1, 'good', 26, '2023-07-29', 1),
(481, 32, 2, 'good', 26, '2023-07-29', 1),
(482, 32, 3, 'good', 26, '2023-07-29', 1),
(483, 32, 4, 'good', 26, '2023-07-29', 1),
(484, 32, 5, 'adjust', 26, '2023-07-29', 1),
(485, 32, 6, 'good', 26, '2023-07-29', 1),
(486, 32, 7, 'good', 26, '2023-07-29', 1),
(487, 32, 8, 'good', 26, '2023-07-29', 1),
(488, 32, 9, 'replace', 26, '2023-07-29', 1),
(489, 32, 10, 'good', 26, '2023-07-29', 1),
(490, 32, 11, 'good', 26, '2023-07-29', 1),
(491, 32, 12, 'replace', 26, '2023-07-29', 1),
(492, 32, 13, 'good', 26, '2023-07-29', 1),
(493, 32, 14, 'good', 26, '2023-07-29', 1),
(494, 32, 15, 'good', 26, '2023-07-29', 1),
(495, 33, 1, 'good', 26, '2023-07-29', 1),
(496, 33, 2, 'good', 26, '2023-07-29', 1),
(497, 33, 3, 'good', 26, '2023-07-29', 1),
(498, 33, 4, 'good', 26, '2023-07-29', 1),
(499, 33, 5, 'adjust', 26, '2023-07-29', 1),
(500, 33, 6, 'good', 26, '2023-07-29', 1),
(501, 33, 7, 'good', 26, '2023-07-29', 1),
(502, 33, 8, 'good', 26, '2023-07-29', 1),
(503, 33, 9, 'replace', 26, '2023-07-29', 1),
(504, 33, 10, 'good', 26, '2023-07-29', 1),
(505, 33, 11, 'replace', 26, '2023-07-29', 1),
(506, 33, 12, 'replace', 26, '2023-07-29', 1),
(507, 33, 13, 'good', 26, '2023-07-29', 1),
(508, 33, 14, 'good', 26, '2023-07-29', 1),
(509, 33, 15, 'good', 26, '2023-07-29', 1),
(510, 34, 1, 'good', 26, '2023-07-29', 1),
(511, 34, 2, 'good', 26, '2023-07-29', 1),
(512, 34, 3, 'good', 26, '2023-07-29', 1),
(513, 34, 4, 'good', 26, '2023-07-29', 1),
(514, 34, 5, 'good', 26, '2023-07-29', 1),
(515, 34, 6, 'good', 26, '2023-07-29', 1),
(516, 34, 7, 'good', 26, '2023-07-29', 1),
(517, 34, 8, 'good', 26, '2023-07-29', 1),
(518, 34, 9, 'replace', 26, '2023-07-29', 1),
(519, 34, 10, 'good', 26, '2023-07-29', 1),
(520, 34, 11, 'good', 26, '2023-07-29', 1),
(521, 34, 12, 'replace', 26, '2023-07-29', 1),
(522, 34, 13, 'good', 26, '2023-07-29', 1),
(523, 34, 14, 'good', 26, '2023-07-29', 1),
(524, 34, 15, 'good', 26, '2023-07-29', 1),
(525, 35, 1, 'good', 26, '2023-07-29', 1),
(526, 35, 2, 'good', 26, '2023-07-29', 1),
(527, 35, 3, 'good', 26, '2023-07-29', 1),
(528, 35, 4, 'good', 26, '2023-07-29', 1),
(529, 35, 5, 'good', 26, '2023-07-29', 1),
(530, 35, 6, 'good', 26, '2023-07-29', 1),
(531, 35, 7, 'good', 26, '2023-07-29', 1),
(532, 35, 8, 'good', 26, '2023-07-29', 1),
(533, 35, 9, 'good', 26, '2023-07-29', 1),
(534, 35, 10, 'good', 26, '2023-07-29', 1),
(535, 35, 11, 'good', 26, '2023-07-29', 1),
(536, 35, 12, 'good', 26, '2023-07-29', 1),
(537, 35, 13, 'good', 26, '2023-07-29', 1),
(538, 35, 14, 'good', 26, '2023-07-29', 1),
(539, 35, 15, 'good', 26, '2023-07-29', 1),
(540, 36, 1, 'good', 26, '2023-07-31', 1),
(541, 36, 2, 'good', 26, '2023-07-31', 1),
(542, 36, 3, 'good', 26, '2023-07-31', 1),
(543, 36, 4, 'good', 26, '2023-07-31', 1),
(544, 36, 5, 'good', 26, '2023-07-31', 1),
(545, 36, 6, 'good', 26, '2023-07-31', 1),
(546, 36, 7, 'good', 26, '2023-07-31', 1),
(547, 36, 8, 'good', 26, '2023-07-31', 1),
(548, 36, 9, 'replace', 26, '2023-07-31', 1),
(549, 36, 10, 'good', 26, '2023-07-31', 1),
(550, 36, 11, 'good', 26, '2023-07-31', 1),
(551, 36, 12, 'replace', 26, '2023-07-31', 1),
(552, 36, 13, 'good', 26, '2023-07-31', 1),
(553, 36, 14, 'good', 26, '2023-07-31', 1),
(554, 36, 15, 'good', 26, '2023-07-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardorderitems`
--

CREATE TABLE `tbl_jobcardorderitems` (
  `jobcardorderid` int(11) NOT NULL,
  `orderdate` date NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardorderitems`
--

INSERT INTO `tbl_jobcardorderitems` (`jobcardorderid`, `orderdate`, `jobcardid`, `amount`, `adduser`, `adddate`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, '2023-07-18', 1, '4700.00', 26, '2023-07-18', '0000-00-00', 0, 1),
(2, '2023-07-18', 2, '4700.00', 26, '2023-07-18', '0000-00-00', 0, 1),
(3, '2023-07-18', 3, '3250.00', 26, '2023-07-18', '0000-00-00', 0, 1),
(4, '2023-07-18', 4, '4250.00', 26, '2023-07-18', '0000-00-00', 0, 1),
(5, '2023-07-19', 5, '3250.00', 26, '2023-07-19', '0000-00-00', 0, 1),
(6, '2023-07-22', 7, '3250.00', 26, '2023-07-22', '0000-00-00', 0, 1),
(7, '2023-07-22', 8, '3250.00', 26, '2023-07-22', '0000-00-00', 0, 1),
(8, '2023-07-22', 9, '3250.00', 26, '2023-07-22', '0000-00-00', 0, 1),
(9, '2023-07-22', 10, '3250.00', 26, '2023-07-22', '0000-00-00', 0, 1),
(10, '2023-07-22', 11, '3250.00', 26, '2023-07-22', '0000-00-00', 0, 1),
(11, '2023-07-23', 12, '4700.00', 26, '2023-07-23', '2023-07-23', 26, 1),
(12, '2023-07-23', 13, '3250.00', 26, '2023-07-23', '0000-00-00', 0, 1),
(13, '2023-07-23', 14, '3250.00', 26, '2023-07-23', '0000-00-00', 0, 1),
(14, '2023-07-23', 15, '3250.00', 26, '2023-07-23', '0000-00-00', 0, 1),
(15, '2023-07-24', 16, '3250.00', 26, '2023-07-24', '0000-00-00', 0, 1),
(16, '2023-07-24', 17, '3250.00', 26, '2023-07-24', '0000-00-00', 0, 1),
(17, '2023-07-26', 18, '3250.00', 26, '2023-07-26', '0000-00-00', 0, 1),
(18, '2023-07-27', 21, '4700.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(19, '2023-07-27', 23, '4700.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(20, '2023-07-27', 24, '4700.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(21, '2023-07-27', 25, '3250.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(22, '2023-07-27', 26, '3250.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(23, '2023-07-27', 27, '4700.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(24, '2023-07-27', 22, '3250.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(25, '2023-07-27', 19, '3250.00', 26, '2023-07-27', '0000-00-00', 0, 1),
(26, '2023-07-28', 28, '4700.00', 26, '2023-07-28', '0000-00-00', 0, 1),
(27, '2023-07-28', 29, '4700.00', 26, '2023-07-28', '0000-00-00', 0, 1),
(28, '2023-07-28', 30, '6950.00', 26, '2023-07-28', '0000-00-00', 0, 1),
(29, '2023-07-29', 31, '3250.00', 26, '2023-07-29', '0000-00-00', 0, 1),
(30, '2023-07-29', 32, '3250.00', 26, '2023-07-29', '0000-00-00', 0, 1),
(31, '2023-07-29', 33, '4700.00', 26, '2023-07-29', '0000-00-00', 0, 1),
(32, '2023-07-29', 34, '3250.00', 26, '2023-07-29', '0000-00-00', 0, 1),
(33, '2023-07-31', 36, '0.00', 26, '2023-07-31', '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcards`
--

CREATE TABLE `tbl_jobcards` (
  `jobcardid` int(11) NOT NULL,
  `customeruserid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `reservationdate` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `plateno` varchar(11) NOT NULL,
  `reservationid` int(11) NOT NULL,
  `qrimage` varchar(64) NOT NULL,
  `jobcardstatus` varchar(32) NOT NULL DEFAULT 'issuedjobcard',
  `subservicestotalprice` float(16,2) NOT NULL DEFAULT 0.00,
  `itemstotalprice` float(16,2) NOT NULL DEFAULT 0.00,
  `technicianid` int(11) NOT NULL,
  `oilstatus` varchar(16) NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `freeservicestatus` varchar(4) NOT NULL,
  `testride` varchar(12) NOT NULL DEFAULT 'pending',
  `mileage` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcards`
--

INSERT INTO `tbl_jobcards` (`jobcardid`, `customeruserid`, `vehicleid`, `serviceid`, `reservationdate`, `starttime`, `endtime`, `plateno`, `reservationid`, `qrimage`, `jobcardstatus`, `subservicestotalprice`, `itemstotalprice`, `technicianid`, `oilstatus`, `deletestatus`, `adduser`, `adddate`, `updateuser`, `updatedate`, `freeservicestatus`, `testride`, `mileage`) VALUES
(1, 16, 1, 1, '2023-07-18', '08:00:00', '09:50:00', 'BCW-5392', 1, 'tmsc69344907fa92a969d391fa82d2c3af91.png', 'finished', 750.00, 4700.00, 20, 'done', 1, 24, '2023-07-18', 0, '0000-00-00', 'no', 'passed', 4500),
(2, 16, 2, 1, '2023-07-18', '10:05:00', '11:55:00', 'BAN-8169', 2, 'tmsc734bce42114c9632d6423ac04e98d780.png', 'finished', 300.00, 4700.00, 20, 'done', 1, 24, '2023-07-18', 0, '0000-00-00', 'yes', 'passed', 6500),
(3, 16, 3, 1, '2023-07-18', '12:10:00', '14:00:00', 'BAT-1130', 3, 'tmscbab5fa098ba5ffeaf2ab18fb9777ef95.png', 'finished', 0.00, 3250.00, 24, 'done', 1, 24, '2023-07-18', 0, '0000-00-00', 'no', 'passed', 6500),
(4, 16, 4, 1, '2023-07-18', '14:15:00', '16:05:00', 'BCF-3013', 4, 'tmsc28abf709e95db07bdd3e9337aefc7739.png', 'finished', 800.00, 4250.00, 26, 'done', 1, 24, '2023-07-18', 0, '0000-00-00', 'yes', 'passed', 6500),
(5, 16, 5, 2, '2023-07-19', '08:00:00', '09:00:00', 'BEF-1321', 5, 'tmscb53d5158feb76aa56b6074f5dbb8a7a2.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-19', 0, '0000-00-00', 'no', 'passed', 1200),
(6, 16, 6, 3, '2023-07-19', '09:15:00', '10:05:00', 'BGH-8891', 6, 'tmsc43c0f87bd9b025689aca6b86d1b8e74d.png', 'finished', 0.00, 0.00, 24, 'none', 1, 24, '2023-07-19', 0, '0000-00-00', 'no', 'passed', 3200),
(7, 34, 12, 1, '2023-07-22', '12:10:00', '14:00:00', 'BAK-5681', 12, 'tmsc119d78a4c989d57aee1111ecc7579253.png', 'finished', 450.00, 3250.00, 30, 'done', 1, 24, '2023-07-22', 0, '0000-00-00', 'no', 'passed', 4500),
(8, 16, 1, 1, '2023-07-22', '08:00:00', '09:50:00', 'BCW-5392', 7, 'tmsc3c8ef60f53f11239210baa7b1d4ed700.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-22', 0, '0000-00-00', 'yes', 'passed', 6000),
(9, 36, 17, 1, '2023-07-22', '10:05:00', '11:55:00', 'BC-5514', 8, 'tmsc8091eea17accbf1025372b11f829f103.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-22', 0, '0000-00-00', 'no', 'passed', 6400),
(10, 48, 38, 1, '2023-07-22', '10:05:00', '11:55:00', 'AEC-4145', 9, 'tmsc4c996e10d289006f4bcaf805245aad8c.png', 'finished', 0.00, 3250.00, 24, 'done', 1, 24, '2023-07-22', 0, '0000-00-00', 'no', 'passed', 5500),
(11, 34, 13, 2, '2023-07-22', '12:10:00', '13:10:00', 'BBA-7881', 10, 'tmsc892d717a4322a208d74dc546d3f7a7e9.png', 'finished', 0.00, 3250.00, 26, 'done', 1, 24, '2023-07-22', 0, '0000-00-00', 'no', 'passed', 2850),
(12, 16, 5, 1, '2023-07-23', '08:00:00', '09:50:00', 'BEF-1321', 13, 'tmsceac5bb5fd13b1eaafdd0d482fbd405d2.png', 'finished', 300.00, 4700.00, 20, 'done', 1, 24, '2023-07-23', 26, '2023-07-23', 'no', 'passed', 4500),
(13, 16, 35, 1, '2023-07-23', '10:05:00', '11:55:00', 'BAC-5555', 14, 'tmsc3af09f630670db10fcef8b119fe2cefd.png', 'finished', 1150.00, 3250.00, 24, 'done', 1, 24, '2023-07-23', 0, '0000-00-00', 'yes', 'passed', 4200),
(14, 16, 25, 1, '2023-07-23', '12:10:00', '14:00:00', 'BKA-4587', 15, 'tmscd8ef46f8370c369b40d1aa668ea514d7.png', 'finished', 0.00, 3250.00, 26, 'done', 1, 24, '2023-07-23', 0, '0000-00-00', 'no', 'passed', 6400),
(15, 16, 4, 1, '2023-07-23', '14:15:00', '16:05:00', 'BCF-3013', 16, 'tmsc322f49d7380b50efcb32494114edd291.png', 'finished', 450.00, 3250.00, 27, 'done', 1, 24, '2023-07-23', 0, '0000-00-00', 'no', 'passed', 7500),
(16, 16, 1, 1, '2023-07-24', '08:00:00', '09:50:00', 'BCW-5392', 17, 'tmsc5ee6373c69ab11ea0feed41adb8d24c5.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-24', 0, '0000-00-00', 'no', 'passed', 4500),
(17, 16, 2, 1, '2023-07-24', '10:05:00', '11:55:00', 'BAN-8169', 18, 'tmscd5797e090477d6138730a42b462ff8ac.png', 'finished', 0.00, 3250.00, 24, 'done', 1, 24, '2023-07-24', 0, '0000-00-00', 'no', 'passed', 4500),
(18, 49, 40, 1, '2023-07-26', '08:00:00', '09:50:00', 'ABC-4554', 19, 'tmsce941f6522cbd4704e1814b9a3825d0e7.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-26', 0, '0000-00-00', 'no', 'passed', 500),
(19, 51, 41, 1, '2023-07-27', '08:00:00', '09:50:00', 'BAC-1469', 20, 'tmscd35196defa877a041dc249d0c2f79989.png', 'finished', 0.00, 3250.00, 24, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'yes', 'passed', 500),
(21, 16, 1, 1, '2023-07-27', '10:05:00', '11:55:00', 'BCW-5392', 21, 'tmsca78f2695654fb3fd5fa35eabdbee0769.png', 'finished', 450.00, 4700.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'no', 'passed', 1800),
(22, 16, 2, 1, '2023-07-27', '12:10:00', '14:00:00', 'BAN-8169', 23, 'tmscd983844447a954b57b6ac3407b94727c.png', 'finished', 0.00, 3250.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'yes', 'passed', 1200),
(23, 16, 3, 1, '2023-07-27', '14:15:00', '16:05:00', 'BAT-1130', 24, 'tmscaf3df2b729c05c533650e330b6bb6fec.png', 'finished', 450.00, 4700.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'yes', 'passed', 1580),
(24, 52, 42, 1, '2023-07-27', '08:00:00', '09:50:00', 'ABC-2546', 25, 'tmsc926032eaa17268f504afa0b5da1fa41a.png', 'finished', 450.00, 4700.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'no', 'passed', 1800),
(25, 16, 1, 1, '2023-07-27', '10:05:00', '11:55:00', 'BCW-5392', 26, 'tmscf79990d8c38a570ea1b4508cdcfa5a21.png', 'finished', 450.00, 3250.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'no', 'passed', 1200),
(26, 53, 43, 1, '2023-07-27', '14:15:00', '16:05:00', 'ACB-4785', 27, 'tmsc4713ce88560447c0814c25df471be436.png', 'finished', 450.00, 3250.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'no', 'passed', 8500),
(27, 54, 44, 1, '2023-07-27', '12:10:00', '14:00:00', 'BAA-5841', 28, 'tmscfa7ee7fe503bacd3505a6244027b9fff.png', 'finished', 750.00, 4700.00, 20, 'done', 1, 24, '2023-07-27', 0, '0000-00-00', 'no', 'passed', 1400),
(28, 55, 45, 1, '2023-07-28', '08:00:00', '09:50:00', 'BAE-5817', 29, 'tmsc1efb1d8bafb05456ba73b481da1400cd.png', 'finished', 750.00, 4700.00, 20, 'done', 1, 24, '2023-07-28', 0, '0000-00-00', 'no', 'passed', 1450),
(29, 56, 46, 1, '2023-07-28', '10:05:00', '11:55:00', 'BAC-4587', 30, 'tmsc0b61a5e7e2e57f79d55199588153e49d.png', 'finished', 750.00, 4700.00, 24, 'done', 1, 24, '2023-07-28', 0, '0000-00-00', 'no', 'passed', 3500),
(30, 57, 47, 1, '2023-07-28', '12:10:00', '14:00:00', 'BAC-8954', 31, 'tmsc25a302c657276c83ed9810b944ca6130.png', 'finished', 750.00, 6950.00, 20, 'done', 1, 24, '2023-07-28', 0, '0000-00-00', 'no', 'passed', 3500),
(31, 16, 1, 1, '2023-07-29', '08:00:00', '09:50:00', 'BCW-5392', 32, 'tmsc1d07afde0d6cc56bce1258b07fd53fce.png', 'completed', 0.00, 3250.00, 20, '', 1, 24, '2023-07-29', 0, '0000-00-00', 'no', 'passed', 1600),
(32, 16, 2, 1, '2023-07-29', '10:05:00', '11:55:00', 'BAN-8169', 33, 'tmscd6475e481927f2c27a3bda157a6960b1.png', 'finished', 450.00, 3250.00, 24, 'done', 1, 24, '2023-07-29', 0, '0000-00-00', 'yes', 'passed', 3500),
(33, 62, 48, 1, '2023-07-29', '08:00:00', '09:50:00', 'ABC-5819', 35, 'tmsc8680236de13fbee93c9a7c4496b11ec8.png', 'finished', 750.00, 4700.00, 24, 'done', 1, 24, '2023-07-29', 0, '0000-00-00', 'no', 'passed', 1500),
(34, 16, 3, 1, '2023-07-29', '08:00:00', '09:50:00', 'BAT-1130', 34, 'tmsccf1b9b2c0cb7caec7e038b65b7193576.png', 'completed', 0.00, 3250.00, 24, '', 1, 26, '2023-07-29', 0, '0000-00-00', 'no', 'passed', 3500),
(35, 16, 6, 1, '2023-07-29', '10:05:00', '11:55:00', 'BGH-8891', 36, 'tmsccdc353266efe951dfc31d82a5ef306b2.png', 'issuedjobcard', 0.00, 0.00, 0, '', 1, 24, '2023-07-29', 0, '0000-00-00', 'no', 'pending', 1580),
(36, 16, 1, 1, '2023-07-31', '08:00:00', '09:50:00', 'BCW-5392', 37, 'tmscf7608edfa00b085fe6a9de03f75f53dd.png', 'pending', 0.00, 0.00, 20, '', 1, 24, '2023-07-31', 0, '0000-00-00', 'no', 'pending', 1800);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobcardtechnician`
--

CREATE TABLE `tbl_jobcardtechnician` (
  `jobcardtechnicianid` int(11) NOT NULL,
  `technicianid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `technicianstatus` varchar(12) NOT NULL DEFAULT 'assigned',
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date DEFAULT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobcardtechnician`
--

INSERT INTO `tbl_jobcardtechnician` (`jobcardtechnicianid`, `technicianid`, `jobcardid`, `technicianstatus`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 20, 1, 'released', '2023-07-18', 26, NULL, 0, 1),
(2, 20, 2, 'released', '2023-07-18', 26, NULL, 0, 1),
(3, 24, 3, 'released', '2023-07-18', 26, NULL, 0, 1),
(4, 26, 4, 'released', '2023-07-18', 26, NULL, 0, 1),
(5, 20, 5, 'released', '2023-07-19', 26, NULL, 0, 1),
(7, 24, 6, 'released', '2023-07-19', 26, NULL, 0, 1),
(8, 30, 7, 'released', '2023-07-22', 26, NULL, 0, 1),
(9, 20, 8, 'released', '2023-07-22', 26, NULL, 0, 1),
(10, 20, 9, 'released', '2023-07-22', 26, NULL, 0, 1),
(11, 24, 10, 'released', '2023-07-22', 26, NULL, 0, 1),
(12, 26, 11, 'released', '2023-07-22', 26, NULL, 0, 1),
(13, 20, 12, 'released', '2023-07-23', 26, NULL, 0, 1),
(14, 24, 13, 'released', '2023-07-23', 26, NULL, 0, 1),
(15, 26, 14, 'released', '2023-07-23', 26, NULL, 0, 1),
(16, 27, 15, 'released', '2023-07-23', 26, NULL, 0, 1),
(17, 20, 16, 'released', '2023-07-24', 26, NULL, 0, 1),
(18, 24, 17, 'released', '2023-07-24', 26, NULL, 0, 1),
(19, 20, 18, 'released', '2023-07-26', 26, NULL, 0, 1),
(20, 20, 21, 'released', '2023-07-27', 26, NULL, 0, 1),
(21, 20, 23, 'released', '2023-07-27', 26, NULL, 0, 1),
(22, 20, 24, 'released', '2023-07-27', 26, NULL, 0, 1),
(23, 20, 25, 'released', '2023-07-27', 26, NULL, 0, 1),
(24, 20, 26, 'released', '2023-07-27', 26, NULL, 0, 1),
(25, 20, 27, 'released', '2023-07-27', 26, NULL, 0, 1),
(26, 20, 22, 'released', '2023-07-27', 26, NULL, 0, 1),
(27, 24, 19, 'released', '2023-07-27', 26, NULL, 0, 1),
(28, 20, 28, 'released', '2023-07-28', 26, NULL, 0, 1),
(29, 24, 29, 'released', '2023-07-28', 26, NULL, 0, 1),
(30, 20, 30, 'released', '2023-07-28', 26, NULL, 0, 1),
(31, 20, 31, 'released', '2023-07-29', 26, NULL, 0, 1),
(32, 24, 32, 'released', '2023-07-29', 26, NULL, 0, 1),
(33, 24, 33, 'released', '2023-07-29', 26, NULL, 0, 1),
(34, 24, 34, 'released', '2023-07-29', 26, NULL, 0, 1),
(35, 24, 35, 'assigned', '2023-07-29', 26, NULL, 0, 1),
(36, 20, 36, 'assigned', '2023-07-31', 26, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobroles`
--

CREATE TABLE `tbl_jobroles` (
  `jobroleid` int(11) NOT NULL,
  `jobrolename` varchar(32) NOT NULL,
  `jobavailability` varchar(3) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jobroles`
--

INSERT INTO `tbl_jobroles` (`jobroleid`, `jobrolename`, `jobavailability`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 'cashier', 'y', '2023-02-11', 2, '0000-00-00', 0, 1),
(2, 'manager', 'y', '2023-02-11', 2, '2023-04-17', 2, 1),
(3, 'storekeeper', 'y', '2023-02-11', 2, '0000-00-00', 0, 1),
(4, 'admin', 'n', '2023-02-12', 2, '0000-00-00', 0, 1),
(5, 'receptionist', 'y', '2023-02-19', 1, '0000-00-00', 0, 0),
(6, 'supervisor', 'y', '2023-03-28', 2, '0000-00-00', 0, 1),
(7, 'technician', 'n', '2023-03-28', 2, '0000-00-00', 0, 1),
(8, 'sample', 'y', '2023-04-17', 2, '0000-00-00', 0, 0),
(9, 'assistant technician', 'n', '2023-06-30', 2, '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_models`
--

CREATE TABLE `tbl_models` (
  `modelid` int(11) NOT NULL,
  `modelname` varchar(32) NOT NULL,
  `vehicletype` varchar(10) NOT NULL,
  `brandid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_models`
--

INSERT INTO `tbl_models` (`modelid`, `modelname`, `vehicletype`, `brandid`, `adddate`, `deletestatus`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 'FZ', 'Motorbike', 1, '2023-02-28', 0, 4, '0000-00-00', 0),
(2, 'Dio', 'Scooter', 3, '2023-02-28', 1, 4, '2023-04-19', 4),
(3, 'Activa i', 'Scooter', 3, '2023-04-04', 1, 4, '2023-04-19', 4),
(4, 'CB Shine', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(5, 'CB Trigger', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(6, 'Activa', 'Scooter', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(7, 'XR 125L', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(8, 'Stunner CBF', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(9, 'Dream Yuga', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(10, 'CB Twister', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(11, 'CD70', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(12, 'CBR 250R', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(13, 'ACE CB125', 'Motorbike', 3, '2023-04-05', 1, 4, '0000-00-00', 0),
(14, 'Activa i', 'Scooter', 3, '2023-04-20', 0, 4, '0000-00-00', 0),
(15, 'Activa i', 'Scooter', 3, '2023-04-20', 0, 4, '0000-00-00', 0),
(16, 'sample', 'Scooter', 3, '2023-04-20', 0, 4, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nextrecommendation`
--

CREATE TABLE `tbl_nextrecommendation` (
  `nextrecommendationid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_nextrecommendation`
--

INSERT INTO `tbl_nextrecommendation` (`nextrecommendationid`, `vehicleid`, `jobcardid`, `comment`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 1, 'have to change the brake oil', '2023-07-18', 26, 1),
(2, 4, 4, 'should change the air filter', '2023-07-18', 26, 1),
(3, 12, 7, 'Should change air filter immediately', '2023-07-22', 26, 1),
(4, 5, 12, 'You have to adjust the brake cable ', '2023-07-23', 26, 1),
(5, 25, 14, 'You should do your service in the proper mileage range', '2023-07-23', 26, 1),
(6, 40, 18, 'Should be change battary for next time', '2023-07-26', 26, 1),
(7, 1, 21, 'Should be changed brake cable and brake pad', '2023-07-27', 26, 1),
(8, 3, 23, 'Should be changed brake cable', '2023-07-27', 26, 1),
(9, 42, 24, 'should be change brake oil', '2023-07-27', 26, 1),
(10, 1, 25, 'have to change brake pads', '2023-07-27', 26, 1),
(11, 43, 26, 'should change the next service ', '2023-07-27', 26, 1),
(12, 44, 27, 'have to change the accelerator cable', '2023-07-27', 26, 1),
(13, 45, 28, 'Should be change next time', '2023-07-28', 26, 1),
(14, 46, 29, 'should be changed brake pad', '2023-07-28', 26, 1),
(15, 47, 30, 'have to change accelerator cable', '2023-07-28', 26, 1),
(16, 2, 32, 'have to change brake oil next time', '2023-07-29', 26, 1),
(17, 48, 33, 'have to change Change brake pad next time', '2023-07-29', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nextrecommendedmileage`
--

CREATE TABLE `tbl_nextrecommendedmileage` (
  `nextrecommendedmileageid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `nextmileage` varchar(64) NOT NULL,
  `nextserviceduration` varchar(64) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_nextrecommendedmileage`
--

INSERT INTO `tbl_nextrecommendedmileage` (`nextrecommendedmileageid`, `vehicleid`, `jobcardid`, `nextmileage`, `nextserviceduration`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 1, '5500-5750', '2024-06-15', '2023-07-18', 26, 1),
(2, 2, 2, '7500-7750', '2024-06-15', '2023-07-18', 26, 1),
(3, 3, 3, '7500-7750', '2024-06-15', '2023-07-18', 26, 1),
(4, 4, 4, '7500-7750', '2024-06-15', '2023-07-18', 26, 1),
(5, 5, 5, '2200-2450', '2024-06-16', '2023-07-19', 26, 1),
(6, 12, 7, '5500-5750', '2024-06-19', '2023-07-22', 26, 1),
(7, 1, 8, '7000-7250', '2024-06-19', '2023-07-22', 26, 1),
(8, 17, 9, '7400-7650', '2024-06-19', '2023-07-22', 26, 1),
(9, 38, 10, '6500-6750', '2024-06-19', '2023-07-22', 26, 1),
(10, 13, 11, '3850-4100', '2024-06-19', '2023-07-22', 26, 1),
(11, 5, 12, '5500-5750', '', '2023-07-23', 26, 1),
(12, 35, 13, '5200-5450', '', '2023-07-23', 26, 1),
(13, 25, 14, '7400-7650', '', '2023-07-23', 26, 1),
(14, 4, 15, '8500-8750', '', '2023-07-23', 26, 1),
(15, 1, 16, '5500-5750', '', '2023-07-24', 26, 1),
(16, 2, 17, '5500-5750', '', '2023-07-24', 26, 1),
(17, 40, 18, '1500-1750', '', '2023-07-26', 26, 1),
(18, 1, 21, '2800-3050', '', '2023-07-27', 26, 1),
(19, 3, 23, '2580-2830', '', '2023-07-27', 26, 1),
(20, 42, 24, '2800-3050', '', '2023-07-27', 26, 1),
(21, 1, 25, '2200-2450', '', '2023-07-27', 26, 1),
(22, 43, 26, '9500-9750', '', '2023-07-27', 26, 1),
(23, 44, 27, '2400-2650', '', '2023-07-27', 26, 1),
(24, 41, 19, '1500-1750', '', '2023-07-27', 26, 1),
(25, 2, 22, '2200-2450', '', '2023-07-27', 26, 1),
(26, 45, 28, '2450-2700', '', '2023-07-28', 26, 1),
(27, 46, 29, '4500-4750', '', '2023-07-28', 26, 1),
(28, 47, 30, '4500-4750', '', '2023-07-28', 26, 1),
(29, 2, 32, '4500-4750', '', '2023-07-29', 26, 1),
(30, 48, 33, '2500-2750', '', '2023-07-29', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nextrecommendedsubservices`
--

CREATE TABLE `tbl_nextrecommendedsubservices` (
  `recommendedsubserviceid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_nextrecommendedsubservices`
--

INSERT INTO `tbl_nextrecommendedsubservices` (`recommendedsubserviceid`, `vehicleid`, `jobcardid`, `subserviceid`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 1, 10, '2023-07-18', 26, 1),
(2, 2, 2, 22, '2023-07-18', 26, 1),
(3, 4, 4, 6, '2023-07-18', 26, 1),
(4, 12, 7, 6, '2023-07-22', 26, 1),
(5, 5, 12, 27, '2023-07-23', 26, 1),
(6, 4, 15, 26, '2023-07-23', 26, 1),
(7, 40, 18, 26, '2023-07-26', 26, 1),
(8, 1, 21, 21, '2023-07-27', 26, 1),
(9, 1, 21, 30, '2023-07-27', 26, 1),
(10, 3, 23, 21, '2023-07-27', 26, 1),
(11, 42, 24, 21, '2023-07-27', 26, 1),
(12, 1, 25, 30, '2023-07-27', 26, 1),
(13, 43, 26, 21, '2023-07-27', 26, 1),
(14, 44, 27, 28, '2023-07-27', 26, 1),
(15, 45, 28, 21, '2023-07-28', 26, 1),
(16, 46, 29, 30, '2023-07-28', 26, 1),
(17, 47, 30, 28, '2023-07-28', 26, 1),
(18, 2, 32, 10, '2023-07-29', 26, 1),
(19, 48, 33, 30, '2023-07-29', 26, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `orderid` int(11) NOT NULL,
  `orderdate` date NOT NULL,
  `customerid` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchaseorder`
--

CREATE TABLE `tbl_purchaseorder` (
  `purchaseorderid` int(11) NOT NULL,
  `catalogid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `buyingprice` decimal(18,2) NOT NULL DEFAULT 0.00,
  `sellingprice` decimal(18,2) NOT NULL,
  `quntity` int(11) NOT NULL,
  `pendingpayment` decimal(18,2) NOT NULL,
  `deliverystatus` varchar(6) NOT NULL DEFAULT 'none',
  `payment` varchar(12) NOT NULL DEFAULT 'pending',
  `paymentdate` date DEFAULT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_purchaseorder`
--

INSERT INTO `tbl_purchaseorder` (`purchaseorderid`, `catalogid`, `supplierid`, `buyingprice`, `sellingprice`, `quntity`, `pendingpayment`, `deliverystatus`, `payment`, `paymentdate`, `adduser`, `adddate`, `deletestatus`) VALUES
(1, 3, 2, '2100.00', '0.00', 40, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(2, 5, 4, '850.00', '0.00', 100, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(3, 9, 3, '1800.00', '0.00', 50, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(4, 1, 1, '1200.00', '0.00', 80, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(5, 7, 4, '2100.00', '0.00', 40, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(6, 10, 3, '1700.00', '0.00', 50, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(7, 2, 1, '1000.00', '0.00', 100, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(8, 6, 1, '800.00', '0.00', 100, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(9, 8, 1, '850.00', '0.00', 100, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(10, 1, 1, '1200.00', '0.00', 50, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(11, 1, 1, '1200.00', '0.00', 50, '0.00', 'done', 'done', '2023-07-18', 4, '2023-07-18', 1),
(13, 2, 1, '1000.00', '0.00', 10, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-19', 1),
(14, 5, 4, '850.00', '1100.00', 10, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-20', 1),
(15, 9, 3, '1800.00', '2000.00', 30, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-20', 1),
(16, 10, 3, '1700.00', '1850.00', 10, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-20', 1),
(17, 9, 3, '1800.00', '0.00', 20, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-20', 1),
(18, 10, 3, '1700.00', '0.00', 20, '0.00', 'done', 'done', '2023-07-20', 4, '2023-07-20', 1),
(19, 3, 2, '2100.00', '2350.00', 40, '0.00', 'done', 'done', '2023-07-21', 4, '2023-07-21', 1),
(20, 7, 4, '2100.00', '2350.00', 30, '0.00', 'done', 'done', '2023-07-22', 4, '2023-07-21', 1),
(21, 9, 3, '1800.00', '2000.00', 5, '0.00', 'done', 'done', '2023-07-21', 4, '2023-07-21', 1),
(22, 10, 3, '1700.00', '1850.00', 20, '0.00', 'done', 'done', '2023-07-21', 4, '2023-07-21', 1),
(23, 10, 3, '1700.00', '1850.00', 20, '34000.00', 'done', 'pending', NULL, 4, '2023-07-21', 1),
(24, 7, 4, '2100.00', '2250.00', 8, '0.00', 'done', 'done', '2023-07-25', 4, '2023-07-22', 1),
(25, 6, 1, '800.00', '0.00', 100, '80000.00', 'none', 'pending', NULL, 4, '2023-07-25', 0),
(26, 7, 4, '2100.00', '2350.00', 20, '0.00', 'done', 'done', '2023-07-27', 4, '2023-07-25', 1),
(27, 3, 2, '2100.00', '0.00', 40, '0.00', 'done', 'done', '2023-07-27', 4, '2023-07-25', 1),
(28, 7, 4, '2100.00', '2250.00', 15, '0.00', 'done', 'done', '2023-07-27', 4, '2023-07-27', 1),
(29, 3, 2, '2100.00', '2250.00', 10, '21000.00', 'done', 'pending', NULL, 4, '2023-07-27', 1),
(30, 8, 1, '850.00', '0.00', 50, '42500.00', 'none', 'pending', NULL, 4, '2023-07-29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservations`
--

CREATE TABLE `tbl_reservations` (
  `reservationid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `reservationdate` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `bay` varchar(11) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `jobcardstatus` varchar(16) NOT NULL DEFAULT 'pending',
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reservations`
--

INSERT INTO `tbl_reservations` (`reservationid`, `vehicleid`, `serviceid`, `reservationdate`, `starttime`, `endtime`, `bay`, `adddate`, `adduser`, `updatedate`, `updateuser`, `jobcardstatus`, `deletestatus`) VALUES
(1, 1, 1, '2023-07-18', '08:00:00', '09:50:00', 'bayA', '2023-07-18', 16, '0000-00-00', 0, 'completed', 1),
(2, 2, 1, '2023-07-18', '10:05:00', '11:55:00', 'bayA', '2023-07-18', 16, '0000-00-00', 0, 'completed', 1),
(3, 3, 1, '2023-07-18', '12:10:00', '14:00:00', 'bayA', '2023-07-18', 16, '0000-00-00', 0, 'completed', 1),
(4, 4, 1, '2023-07-18', '14:15:00', '16:05:00', 'bayA', '2023-07-18', 16, '0000-00-00', 0, 'completed', 1),
(5, 5, 2, '2023-07-19', '08:00:00', '09:00:00', 'bayA', '2023-07-19', 16, '0000-00-00', 0, 'completed', 1),
(6, 6, 3, '2023-07-19', '09:15:00', '10:05:00', 'bayA', '2023-07-19', 16, '0000-00-00', 0, 'completed', 1),
(7, 1, 1, '2023-07-22', '08:00:00', '09:50:00', 'bayA', '2023-07-22', 16, '0000-00-00', 0, 'completed', 1),
(8, 17, 1, '2023-07-22', '10:05:00', '11:55:00', 'bayA', '2023-07-22', 36, '0000-00-00', 0, 'completed', 1),
(9, 38, 1, '2023-07-22', '10:05:00', '11:55:00', 'bayB', '2023-07-22', 48, '0000-00-00', 0, 'completed', 1),
(10, 13, 2, '2023-07-22', '12:10:00', '13:10:00', 'bayB', '2023-07-22', 34, '0000-00-00', 0, 'completed', 1),
(11, 2, 1, '2023-07-22', '12:10:00', '14:00:00', 'bayA', '2023-07-22', 16, '0000-00-00', 0, 'cancel', 0),
(12, 12, 1, '2023-07-22', '12:10:00', '14:00:00', 'bayA', '2023-07-22', 34, '0000-00-00', 0, 'completed', 1),
(13, 5, 1, '2023-07-23', '08:00:00', '09:50:00', 'bayA', '2023-07-23', 16, '0000-00-00', 0, 'completed', 1),
(14, 35, 1, '2023-07-23', '10:05:00', '11:55:00', 'bayA', '2023-07-23', 16, '0000-00-00', 0, 'completed', 1),
(15, 25, 1, '2023-07-23', '12:10:00', '14:00:00', 'bayA', '2023-07-23', 16, '0000-00-00', 0, 'completed', 1),
(16, 4, 1, '2023-07-23', '14:15:00', '16:05:00', 'bayA', '2023-07-23', 16, '0000-00-00', 0, 'completed', 1),
(17, 1, 1, '2023-07-24', '08:00:00', '09:50:00', 'bayA', '2023-07-24', 16, '0000-00-00', 0, 'completed', 1),
(18, 2, 1, '2023-07-24', '10:05:00', '11:55:00', 'bayA', '2023-07-24', 16, '0000-00-00', 0, 'completed', 1),
(19, 40, 1, '2023-07-26', '08:00:00', '09:50:00', 'bayA', '2023-07-26', 49, '0000-00-00', 0, 'completed', 1),
(20, 41, 1, '2023-07-27', '08:00:00', '09:50:00', 'bayA', '2023-07-27', 51, '0000-00-00', 0, 'completed', 1),
(21, 1, 1, '2023-07-27', '10:05:00', '11:55:00', 'bayA', '2023-07-27', 16, '0000-00-00', 0, 'completed', 1),
(22, 2, 1, '2023-07-27', '14:15:00', '16:05:00', 'bayA', '2023-07-27', 16, '0000-00-00', 0, 'cancel', 0),
(23, 2, 1, '2023-07-27', '12:10:00', '14:00:00', 'bayA', '2023-07-27', 16, '0000-00-00', 0, 'completed', 1),
(24, 3, 1, '2023-07-27', '14:15:00', '16:05:00', 'bayA', '2023-07-27', 16, '0000-00-00', 0, 'completed', 1),
(25, 42, 1, '2023-07-27', '08:00:00', '09:50:00', 'bayB', '2023-07-27', 52, '0000-00-00', 0, 'completed', 1),
(26, 1, 1, '2023-07-27', '10:05:00', '11:55:00', 'bayB', '2023-07-27', 16, '0000-00-00', 0, 'completed', 1),
(27, 43, 1, '2023-07-27', '14:15:00', '16:05:00', 'bayB', '2023-07-27', 53, '0000-00-00', 0, 'completed', 1),
(28, 44, 1, '2023-07-27', '12:10:00', '14:00:00', 'bayB', '2023-07-27', 54, '0000-00-00', 0, 'completed', 1),
(29, 45, 1, '2023-07-28', '08:00:00', '09:50:00', 'bayA', '2023-07-28', 55, '0000-00-00', 0, 'completed', 1),
(30, 46, 1, '2023-07-28', '10:05:00', '11:55:00', 'bayA', '2023-07-28', 56, '0000-00-00', 0, 'completed', 1),
(31, 47, 1, '2023-07-28', '12:10:00', '14:00:00', 'bayA', '2023-07-28', 57, '0000-00-00', 0, 'completed', 1),
(32, 1, 1, '2023-07-29', '08:00:00', '09:50:00', 'bayA', '2023-07-29', 16, '0000-00-00', 0, 'completed', 1),
(33, 2, 1, '2023-07-29', '10:05:00', '11:55:00', 'bayA', '2023-07-29', 16, '0000-00-00', 0, 'completed', 1),
(34, 3, 1, '2023-07-29', '08:00:00', '09:50:00', 'bayC', '2023-07-29', 16, '0000-00-00', 0, 'completed', 1),
(35, 48, 1, '2023-07-29', '08:00:00', '09:50:00', 'bayB', '2023-07-29', 62, '0000-00-00', 0, 'completed', 1),
(36, 6, 1, '2023-07-29', '10:05:00', '11:55:00', 'bayB', '2023-07-29', 16, '0000-00-00', 0, 'issuedjobcard', 1),
(37, 1, 1, '2023-07-31', '08:00:00', '09:50:00', 'bayA', '2023-07-31', 16, '0000-00-00', 0, 'issuedjobcard', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `serviceid` int(11) NOT NULL,
  `servicename` varchar(255) NOT NULL,
  `serviceprice` decimal(10,2) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `servicestarttime` time NOT NULL,
  `servicelagtime` varchar(255) NOT NULL,
  `tasklist` text NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `serviceadddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`serviceid`, `servicename`, `serviceprice`, `duration`, `servicestarttime`, `servicelagtime`, `tasklist`, `deletestatus`, `serviceadddate`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 'Full service package', '3100.00', '110 minute', '00:00:00', '', '', 1, '2023-04-10', 4, '2023-07-05', 4),
(2, 'Normal service package', '1650.00', '60 minute', '00:00:00', '', '', 1, '2023-04-10', 4, '2023-07-05', 4),
(3, 'Body wash package', '1450.00', '50 minute', '00:00:00', '', '', 1, '2023-04-10', 4, '2023-07-05', 4),
(8, 'sample service', '1400.00', '55 minute', '00:00:00', '', '', 0, '2023-07-17', 4, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servicetasks`
--

CREATE TABLE `tbl_servicetasks` (
  `taskid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_servicetasks`
--

INSERT INTO `tbl_servicetasks` (`taskid`, `serviceid`, `subserviceid`, `deletestatus`, `adddate`, `adduser`) VALUES
(23, 4, 9, 0, '2023-04-18', 4),
(24, 4, 10, 0, '2023-04-18', 4),
(25, 4, 11, 0, '2023-04-18', 4),
(30, 5, 1, 0, '2023-04-18', 4),
(31, 5, 2, 0, '2023-04-18', 4),
(32, 5, 4, 0, '2023-04-18', 4),
(33, 5, 8, 0, '2023-04-18', 4),
(34, 5, 5, 0, '2023-04-18', 4),
(38, 6, 2, 0, '2023-04-18', 4),
(61, 1, 1, 1, '2023-07-05', 4),
(62, 1, 2, 1, '2023-07-05', 4),
(63, 1, 3, 1, '2023-07-05', 4),
(64, 1, 5, 1, '2023-07-05', 4),
(65, 1, 4, 1, '2023-07-05', 4),
(66, 1, 8, 1, '2023-07-05', 4),
(67, 2, 3, 1, '2023-07-05', 4),
(68, 2, 2, 1, '2023-07-05', 4),
(69, 2, 5, 1, '2023-07-05', 4),
(70, 3, 1, 1, '2023-07-05', 4),
(71, 3, 4, 1, '2023-07-05', 4),
(72, 3, 8, 1, '2023-07-05', 4),
(73, 7, 32, 0, '2023-07-13', 4),
(74, 7, 33, 0, '2023-07-13', 4),
(75, 8, 22, 0, '2023-07-17', 4),
(76, 8, 2, 0, '2023-07-17', 4),
(77, 8, 3, 0, '2023-07-17', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_servicevoucher`
--

CREATE TABLE `tbl_servicevoucher` (
  `servicevoucherid` int(11) NOT NULL,
  `jobcardid` int(11) NOT NULL,
  `customeruserid` int(11) NOT NULL,
  `vehicleid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `voucherimage` varchar(255) NOT NULL,
  `vouchercode` varchar(16) NOT NULL,
  `voucherstatus` varchar(16) NOT NULL DEFAULT 'pending',
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_servicevoucher`
--

INSERT INTO `tbl_servicevoucher` (`servicevoucherid`, `jobcardid`, `customeruserid`, `vehicleid`, `serviceid`, `voucherimage`, `vouchercode`, `voucherstatus`, `adddate`, `adduser`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 2, 16, 2, 1, '64b6cd50458380.93959394.jpeg', '#123564756', 'Released', '2023-07-18', 24, 0, '0000-00-00', 1),
(2, 4, 16, 4, 1, '64b6d1d1a16009.60551270.jpeg', '#123564789', 'Released', '2023-07-18', 24, 0, '0000-00-00', 1),
(3, 8, 16, 1, 1, '64bbdc89c6da51.19459609.jpeg', '#123564766', 'pending', '2023-07-22', 24, 0, '0000-00-00', 1),
(4, 13, 16, 35, 1, '64bd247e6dd145.84769112.jpeg', '#123354693', 'pending', '2023-07-23', 24, 0, '0000-00-00', 1),
(5, 19, 51, 41, 1, '64c2063c030a63.08729339.jpeg', '#123564800', 'pending', '2023-07-27', 24, 0, '0000-00-00', 1),
(6, 20, 51, 41, 1, '64c20684cd1432.30218613.jpeg', '#123565697', 'pending', '2023-07-27', 24, 0, '0000-00-00', 1),
(7, 22, 16, 2, 1, '64c21544f2b549.36490836.jpeg', '#123354655', 'pending', '2023-07-27', 24, 0, '0000-00-00', 1),
(8, 23, 16, 3, 1, '64c21735efd372.47765762.jpeg', '#555564756', 'pending', '2023-07-27', 24, 0, '0000-00-00', 1),
(9, 32, 16, 2, 1, '64c48e19c5e9e6.07976035.jpeg', '#123354669', 'pending', '2023-07-29', 24, 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stationdetails`
--

CREATE TABLE `tbl_stationdetails` (
  `stationid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_stationdetails`
--

INSERT INTO `tbl_stationdetails` (`stationid`, `name`, `address`, `email`) VALUES
(1, 'Thusitha Service Station HONDA', 'No 25/45,Colombo road,Chilaw', 'thusithastationhonda@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subservices`
--

CREATE TABLE `tbl_subservices` (
  `subserviceid` int(11) NOT NULL,
  `subservicename` varchar(255) NOT NULL,
  `subserviceprice` decimal(10,2) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `tasklist` text NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1,
  `subserviceadddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subservices`
--

INSERT INTO `tbl_subservices` (`subserviceid`, `subservicename`, `subserviceprice`, `duration`, `tasklist`, `deletestatus`, `subserviceadddate`, `adduser`, `updatedate`, `updateuser`) VALUES
(1, 'Body wash', '1000.00', '30 minute', '', 1, '2023-04-10', 4, '2023-07-19', 4),
(2, 'Air filter cleaning', '500.00', '30 minute', '', 1, '2023-04-10', 4, '0000-00-00', 0),
(3, 'Change engine oil', '650.00', '15 minute', '', 1, '2023-04-10', 4, '2023-07-05', 4),
(4, 'Cable oiling', '350.00', '10 minute', '', 1, '2023-04-10', 4, '0000-00-00', 0),
(5, 'Change oil filter', '500.00', '15 minute', '', 1, '2023-04-10', 4, '2023-07-05', 4),
(6, 'Change air filter', '300.00', '10 minute', '', 1, '2023-04-10', 4, '0000-00-00', 0),
(8, 'Greasing', '100.00', '10 minute', '', 1, '2023-04-10', 4, '0000-00-00', 0),
(10, 'Change brake oil', '400.00', '10 minute', '', 1, '2023-04-10', 4, '0000-00-00', 0),
(20, 'Charge battery', '450.00', '45 minute', '', 1, '2023-07-05', 4, '2023-07-05', 4),
(21, 'Change brake cable', '350.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(22, 'Change clutch cable', '250.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(23, 'Change chain', '400.00', '30 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(24, 'Adjustment chain', '150.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(25, 'Adjustment clutch cable', '150.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(26, 'Change battory', '450.00', '15 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(27, 'Adjustment brake cable', '150.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(28, 'Change accelerator cable', '350.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(29, 'Adjustment accelerator cable', '250.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(30, 'Change brake pad', '350.00', '10 minute', '', 1, '2023-07-05', 4, '2023-07-05', 4),
(31, 'Adjustment brake pads', '150.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(32, 'Change brake shoes', '250.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(33, 'Adjustment brake shoes', '150.00', '5 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(34, 'Change choke cable', '350.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0),
(35, 'Adjustment choke cable', '150.00', '10 minute', '', 1, '2023-07-05', 4, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subservicetasks`
--

CREATE TABLE `tbl_subservicetasks` (
  `taskid` int(11) NOT NULL,
  `subserviceid` int(11) NOT NULL,
  `taskname` varchar(32) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subservicetasks`
--

INSERT INTO `tbl_subservicetasks` (`taskid`, `subserviceid`, `taskname`, `deletestatus`, `adddate`, `adduser`) VALUES
(6, 2, 'Air filter cleaning', 1, '2023-04-10', 4),
(8, 4, 'Cable oiling', 1, '2023-04-10', 4),
(10, 6, 'Change air filter', 1, '2023-04-10', 4),
(22, 8, 'Greasing chassis', 1, '2023-04-10', 4),
(24, 10, 'Change brake oil', 1, '2023-04-10', 4),
(56, 3, 'Change engine oil', 1, '2023-07-05', 4),
(57, 5, 'Change oil filter', 1, '2023-07-05', 4),
(59, 20, 'charge battery', 1, '2023-07-05', 4),
(60, 21, 'change brake cable', 1, '2023-07-05', 4),
(61, 22, 'change clutch cable', 1, '2023-07-05', 4),
(62, 23, 'change chain', 1, '2023-07-05', 4),
(63, 24, 'adjustment chain', 1, '2023-07-05', 4),
(64, 25, 'adjustment clutch cable', 1, '2023-07-05', 4),
(65, 26, 'change battory', 1, '2023-07-05', 4),
(66, 27, 'adjustment brake cable', 1, '2023-07-05', 4),
(67, 28, 'change accelerator cable', 1, '2023-07-05', 4),
(68, 29, 'Adjustment accelerator cable', 1, '2023-07-05', 4),
(70, 31, 'adjustment brake pads', 1, '2023-07-05', 4),
(71, 32, 'change brake shoes', 1, '2023-07-05', 4),
(72, 33, 'adjustment brake shoes', 1, '2023-07-05', 4),
(73, 30, 'Change brake pads', 1, '2023-07-05', 4),
(74, 34, 'change choke cable', 1, '2023-07-05', 4),
(75, 35, 'adjustment choke cable', 1, '2023-07-05', 4),
(79, 1, 'Tyres polishing', 1, '2023-07-19', 4),
(80, 1, 'Waxing', 1, '2023-07-19', 4),
(81, 1, 'wash', 1, '2023-07-19', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplierpayments`
--

CREATE TABLE `tbl_supplierpayments` (
  `supplierpaymentid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `purchaseorderid` int(11) NOT NULL,
  `totalpayment` decimal(18,2) NOT NULL,
  `method` varchar(16) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplierpayments`
--

INSERT INTO `tbl_supplierpayments` (`supplierpaymentid`, `supplierid`, `purchaseorderid`, `totalpayment`, `method`, `adddate`, `adduser`, `deletestatus`) VALUES
(1, 1, 4, '96000.00', 'deposit', '2023-07-18', 4, 1),
(2, 2, 1, '84000.00', 'deposit', '2023-07-18', 4, 1),
(3, 3, 3, '90000.00', 'deposit', '2023-07-18', 4, 1),
(4, 4, 2, '85000.00', 'deposit', '2023-07-18', 4, 1),
(5, 4, 5, '84000.00', 'deposit', '2023-07-18', 4, 1),
(6, 3, 6, '85000.00', 'deposit', '2023-07-18', 4, 1),
(7, 1, 7, '100000.00', 'deposit', '2023-07-18', 4, 1),
(8, 1, 8, '80000.00', 'deposit', '2023-07-18', 4, 1),
(9, 1, 9, '85000.00', 'deposit', '2023-07-18', 4, 1),
(11, 1, 10, '60000.00', 'deposit', '2023-07-18', 4, 1),
(12, 1, 11, '60000.00', 'deposit', '2023-07-18', 4, 1),
(13, 3, 16, '10000.00', 'deposit', '2023-07-20', 4, 1),
(14, 3, 15, '54000.00', 'deposit', '2023-07-20', 4, 1),
(15, 1, 13, '5000.00', 'deposit', '2023-07-20', 4, 1),
(16, 1, 13, '5000.00', 'deposit', '2023-07-20', 4, 1),
(17, 3, 16, '7000.00', 'deposit', '2023-07-20', 4, 1),
(18, 4, 14, '8500.00', 'deposit', '2023-07-20', 4, 1),
(19, 3, 17, '30000.00', 'deposit', '2023-07-20', 4, 1),
(20, 3, 18, '30000.50', 'deposit', '2023-07-20', 4, 1),
(21, 3, 18, '3999.50', 'deposit', '2023-07-20', 4, 1),
(22, 3, 17, '6000.00', 'deposit', '2023-07-20', 4, 1),
(23, 2, 19, '84000.00', 'deposit', '2023-07-21', 4, 1),
(24, 3, 21, '5000.00', 'deposit', '2023-07-21', 3, 1),
(25, 3, 21, '4000.00', 'deposit', '2023-07-21', 4, 1),
(26, 3, 22, '34000.00', 'deposit', '2023-07-21', 4, 1),
(27, 4, 24, '15000.00', 'deposit', '2023-07-22', 4, 1),
(28, 4, 20, '63000.00', 'deposit', '2023-07-22', 4, 1),
(29, 4, 24, '1800.00', 'cheque', '2023-07-25', 4, 1),
(30, 4, 26, '42000.00', 'deposit', '2023-07-27', 4, 1),
(31, 4, 28, '31500.00', 'deposit', '2023-07-27', 4, 1),
(32, 2, 27, '84000.00', 'deposit', '2023-07-27', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `supplierid` int(11) NOT NULL,
  `companyname` varchar(32) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `telephone` varchar(12) NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `email` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `regno` varchar(32) NOT NULL,
  `creditlimit` decimal(16,2) NOT NULL,
  `bankname` varchar(32) NOT NULL,
  `accountname` varchar(32) NOT NULL,
  `bankaccountno` varchar(32) NOT NULL,
  `supplierstatus` varchar(12) NOT NULL DEFAULT 'yes',
  `supplieradddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`supplierid`, `companyname`, `firstname`, `lastname`, `telephone`, `mobile`, `email`, `address`, `regno`, `creditlimit`, `bankname`, `accountname`, `bankaccountno`, `supplierstatus`, `supplieradddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 'Honda (Pvt) Ltd', 'Kawindi', 'Gunathilaka', '0322222555', '+9477-5580555', 'kawindi@gmail.com', 'No 125,Kurunagala rd, Chilaw', '', '57500.00', 'Sampath bank', 'A.P Kawindi Gunathilaka', '4512-456789-1234', 'yes', '2023-07-07', 4, '2023-07-18', 4, 1),
(2, 'Havoline distributors', 'Kusal', 'Hasaranga', '0322222444', '+9477-5005446', 'kusal@gmail.com', 'No 55, Puttalum rood, Chilaw', '', '79000.00', 'People&#039;s bank', 'A.K Kusal Hasaranga', '456-4565-4526-41', 'yes', '2023-07-07', 4, '2023-07-18', 4, 1),
(3, 'Mobil distributors chilaw', 'Akalanka', 'Sunanda', '', '+9477-9543535', 'Akalanka@gmail.com', 'No 35/87,kurunagala rood,chilaw', '', '66000.00', 'Peoples bank', 'A.K.Sunanda', '456-4565-4526-35', 'yes', '2023-07-15', 4, '2023-07-18', 4, 1),
(4, 'Caltex distributor', 'Sadun', 'Akalanka', '', '+9477-8754346', 'sadun@gmail.com', 'No 125,Puttalam rood,Chilaw', '', '100000.00', 'People&#039;s bank', 'P.Sadun Akalanaka', '4512-4567-8904-722', 'yes', '2023-07-15', 4, '2023-07-18', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_technicianattendance`
--

CREATE TABLE `tbl_technicianattendance` (
  `attendanceid` int(11) NOT NULL,
  `technicianid` int(11) NOT NULL,
  `attendancestatus` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_technicianattendance`
--

INSERT INTO `tbl_technicianattendance` (`attendanceid`, `technicianid`, `attendancestatus`, `date`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 20, 'yes', '2023-07-02', 4, '2023-07-02', 4, '2023-07-02', 1),
(2, 24, 'no', '2023-07-02', 4, '2023-07-02', 4, '2023-07-02', 1),
(3, 26, 'no', '2023-07-02', 4, '2023-07-02', 4, '2023-07-02', 1),
(4, 27, 'yes', '2023-07-02', 4, '2023-07-02', 4, '2023-07-02', 1),
(5, 30, 'no', '2023-07-02', 4, '2023-07-02', 4, '2023-07-02', 1),
(48, 20, 'yes', '2023-07-03', 0, '0000-00-00', 4, '2023-07-03', 1),
(49, 24, 'yes', '2023-07-03', 0, '0000-00-00', 4, '2023-07-03', 1),
(50, 26, 'yes', '2023-07-03', 0, '0000-00-00', 4, '2023-07-03', 1),
(51, 27, 'no', '2023-07-03', 0, '0000-00-00', 4, '2023-07-03', 1),
(52, 29, 'yes', '2023-07-03', 0, '0000-00-00', 4, '2023-07-03', 1),
(53, 20, 'yes', '2023-07-04', 4, '2023-07-04', 0, '0000-00-00', 1),
(54, 24, 'yes', '2023-07-04', 4, '2023-07-04', 0, '0000-00-00', 1),
(55, 26, 'yes', '2023-07-04', 4, '2023-07-04', 0, '0000-00-00', 1),
(56, 27, 'no', '2023-07-04', 4, '2023-07-04', 0, '0000-00-00', 1),
(57, 28, 'yes', '2023-07-04', 4, '2023-07-04', 0, '0000-00-00', 1),
(58, 20, 'yes', '2023-07-05', 4, '2023-07-05', 0, '0000-00-00', 1),
(59, 24, 'yes', '2023-07-05', 4, '2023-07-05', 0, '0000-00-00', 1),
(60, 26, 'yes', '2023-07-05', 4, '2023-07-05', 0, '0000-00-00', 1),
(61, 27, 'yes', '2023-07-05', 4, '2023-07-05', 0, '0000-00-00', 1),
(62, 20, 'yes', '2023-07-08', 4, '2023-07-08', 0, '0000-00-00', 1),
(63, 24, 'yes', '2023-07-08', 4, '2023-07-08', 0, '0000-00-00', 1),
(64, 26, 'yes', '2023-07-08', 4, '2023-07-08', 0, '0000-00-00', 1),
(65, 27, 'yes', '2023-07-08', 4, '2023-07-08', 0, '0000-00-00', 1),
(66, 20, 'yes', '2023-07-09', 4, '2023-07-09', 0, '0000-00-00', 1),
(67, 24, 'yes', '2023-07-09', 4, '2023-07-09', 0, '0000-00-00', 1),
(68, 26, 'yes', '2023-07-09', 4, '2023-07-09', 0, '0000-00-00', 1),
(69, 27, 'no', '2023-07-09', 4, '2023-07-09', 0, '0000-00-00', 1),
(70, 28, 'yes', '2023-07-09', 4, '2023-07-09', 0, '0000-00-00', 1),
(71, 20, 'yes', '2023-07-10', 4, '2023-07-10', 0, '0000-00-00', 1),
(72, 24, 'yes', '2023-07-10', 4, '2023-07-10', 0, '0000-00-00', 1),
(73, 26, 'yes', '2023-07-10', 4, '2023-07-10', 0, '0000-00-00', 1),
(74, 27, 'yes', '2023-07-10', 4, '2023-07-10', 0, '0000-00-00', 1),
(75, 20, 'yes', '2023-07-11', 4, '2023-07-11', 0, '0000-00-00', 1),
(76, 24, 'yes', '2023-07-11', 4, '2023-07-11', 0, '0000-00-00', 1),
(77, 26, 'yes', '2023-07-11', 4, '2023-07-11', 0, '0000-00-00', 1),
(78, 27, 'yes', '2023-07-11', 4, '2023-07-11', 0, '0000-00-00', 1),
(79, 20, 'yes', '2023-07-12', 4, '2023-07-12', 0, '0000-00-00', 1),
(80, 24, 'yes', '2023-07-12', 4, '2023-07-12', 0, '0000-00-00', 1),
(81, 26, 'yes', '2023-07-12', 4, '2023-07-12', 0, '0000-00-00', 1),
(82, 27, 'yes', '2023-07-12', 4, '2023-07-12', 0, '0000-00-00', 1),
(83, 20, 'yes', '2023-07-13', 4, '2023-07-13', 0, '0000-00-00', 1),
(84, 24, 'yes', '2023-07-13', 4, '2023-07-13', 0, '0000-00-00', 1),
(85, 26, 'yes', '2023-07-13', 4, '2023-07-13', 0, '0000-00-00', 1),
(86, 27, 'yes', '2023-07-13', 4, '2023-07-13', 0, '0000-00-00', 1),
(91, 20, 'yes', '2023-07-18', 0, '0000-00-00', 4, '2023-07-18', 1),
(92, 24, 'yes', '2023-07-18', 0, '0000-00-00', 4, '2023-07-18', 1),
(93, 26, 'yes', '2023-07-18', 0, '0000-00-00', 4, '2023-07-18', 1),
(94, 27, 'no', '2023-07-18', 0, '0000-00-00', 4, '2023-07-18', 1),
(95, 30, 'yes', '2023-07-18', 0, '0000-00-00', 4, '2023-07-18', 1),
(96, 20, 'yes', '2023-07-19', 4, '2023-07-19', 0, '0000-00-00', 1),
(97, 24, 'yes', '2023-07-19', 4, '2023-07-19', 0, '0000-00-00', 1),
(98, 26, 'yes', '2023-07-19', 4, '2023-07-19', 0, '0000-00-00', 1),
(99, 27, 'yes', '2023-07-19', 4, '2023-07-19', 0, '0000-00-00', 1),
(100, 20, 'yes', '2023-07-22', 4, '2023-07-22', 0, '0000-00-00', 1),
(101, 24, 'yes', '2023-07-22', 4, '2023-07-22', 0, '0000-00-00', 1),
(102, 26, 'yes', '2023-07-22', 4, '2023-07-22', 0, '0000-00-00', 1),
(103, 27, 'no', '2023-07-22', 4, '2023-07-22', 0, '0000-00-00', 1),
(104, 30, 'yes', '2023-07-22', 4, '2023-07-22', 0, '0000-00-00', 1),
(105, 20, 'yes', '2023-07-23', 4, '2023-07-23', 0, '0000-00-00', 1),
(106, 24, 'yes', '2023-07-23', 4, '2023-07-23', 0, '0000-00-00', 1),
(107, 26, 'yes', '2023-07-23', 4, '2023-07-23', 0, '0000-00-00', 1),
(108, 27, 'yes', '2023-07-23', 4, '2023-07-23', 0, '0000-00-00', 1),
(109, 20, 'yes', '2023-07-24', 4, '2023-07-24', 0, '0000-00-00', 1),
(110, 24, 'yes', '2023-07-24', 4, '2023-07-24', 0, '0000-00-00', 1),
(111, 26, 'yes', '2023-07-24', 4, '2023-07-24', 0, '0000-00-00', 1),
(112, 27, 'yes', '2023-07-24', 4, '2023-07-24', 0, '0000-00-00', 1),
(116, 20, 'yes', '2023-07-26', 0, '0000-00-00', 4, '2023-07-26', 1),
(117, 24, 'yes', '2023-07-26', 0, '0000-00-00', 4, '2023-07-26', 1),
(118, 27, 'yes', '2023-07-26', 0, '0000-00-00', 4, '2023-07-26', 1),
(119, 30, 'yes', '2023-07-26', 0, '0000-00-00', 4, '2023-07-26', 1),
(120, 20, 'yes', '2023-07-27', 4, '2023-07-27', 0, '0000-00-00', 1),
(121, 24, 'yes', '2023-07-27', 4, '2023-07-27', 0, '0000-00-00', 1),
(122, 26, 'yes', '2023-07-27', 4, '2023-07-27', 0, '0000-00-00', 1),
(123, 27, 'yes', '2023-07-27', 4, '2023-07-27', 0, '0000-00-00', 1),
(124, 20, 'yes', '2023-07-28', 4, '2023-07-28', 0, '0000-00-00', 1),
(125, 24, 'yes', '2023-07-28', 4, '2023-07-28', 0, '0000-00-00', 1),
(126, 26, 'yes', '2023-07-28', 4, '2023-07-28', 0, '0000-00-00', 1),
(127, 27, 'yes', '2023-07-28', 4, '2023-07-28', 0, '0000-00-00', 1),
(128, 20, 'yes', '2023-07-29', 4, '2023-07-29', 0, '0000-00-00', 1),
(129, 24, 'yes', '2023-07-29', 4, '2023-07-29', 0, '0000-00-00', 1),
(130, 26, 'yes', '2023-07-29', 4, '2023-07-29', 0, '0000-00-00', 1),
(131, 27, 'yes', '2023-07-29', 4, '2023-07-29', 0, '0000-00-00', 1),
(132, 20, 'yes', '2023-07-31', 4, '2023-07-31', 0, '0000-00-00', 1),
(133, 24, 'yes', '2023-07-31', 4, '2023-07-31', 0, '0000-00-00', 1),
(134, 26, 'yes', '2023-07-31', 4, '2023-07-31', 0, '0000-00-00', 1),
(135, 27, 'yes', '2023-07-31', 4, '2023-07-31', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userrole` varchar(50) NOT NULL,
  `accountstatus` varchar(11) NOT NULL,
  `adduser` int(11) NOT NULL,
  `adddate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userid`, `username`, `password`, `userrole`, `accountstatus`, `adduser`, `adddate`, `updateuser`, `updatedate`, `deletestatus`) VALUES
(1, 'sauri@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'manager', 'active', 2, '2023-02-20', 0, '0000-00-00', 1),
(2, 'kamal@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'admin', 'active', 2, '2023-02-20', 0, '0000-00-00', 1),
(3, 'saranga@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'storekeeper', 'active', 2, '2023-02-20', 0, '0000-00-00', 1),
(4, 'lakmal@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'manager', 'active', 2, '2023-02-20', 0, '0000-00-00', 1),
(9, 'ayesh@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-02-21', 0, '0000-00-00', 1),
(16, 'hirun@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-02-26', 0, '2023-07-13', 1),
(24, 'nipuni@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'cashier', 'active', 2, '2023-03-05', 0, '0000-00-00', 1),
(26, 'hirushangunathilaka@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'supervisor', 'active', 2, '2023-03-10', 2, '2023-03-31', 1),
(32, 'danushka@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-04-08', 0, '0000-00-00', 1),
(34, 'malintha@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(35, 'niroshan@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(36, 'shashika@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(37, 'sidath@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(38, 'nimali@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(39, 'sadun@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-11', 0, '0000-00-00', 1),
(40, 'kalpana@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-19', 0, '0000-00-00', 1),
(41, 'kasuni@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-19', 0, '0000-00-00', 1),
(42, 'heshan@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-19', 0, '0000-00-00', 1),
(43, 'kalyani@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-26', 0, '0000-00-00', 1),
(45, 'tharushi@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-06-30', 0, '0000-00-00', 1),
(46, 'senuri@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-11', 0, '0000-00-00', 1),
(47, 'anurada@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-14', 0, '0000-00-00', 1),
(48, 'hirusha@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-18', 0, '0000-00-00', 1),
(49, 'Asela@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-26', 0, '0000-00-00', 1),
(50, 'Susanthi@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-26', 0, '0000-00-00', 1),
(51, 'kumara@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-27', 0, '0000-00-00', 1),
(52, 'dulan@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-27', 0, '0000-00-00', 1),
(53, 'kawinda@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-27', 0, '0000-00-00', 1),
(54, 'kawindii@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-27', 0, '0000-00-00', 1),
(55, 'kasun@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(56, 'gayan@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(57, 'Nalaka@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(58, 'harsana@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(59, 'shalika@gmail.com', 'c8e4ba852b66d8e1f4b1b76eaaa9a3b60bfc6e9b', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(60, 'suneth@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(61, 'duminda@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-28', 0, '0000-00-00', 1),
(62, 'shehaariyasinghe@gmail.com', 'a3f9c7c801189b2f3ffe2daf1c077a6a4b0361cb', 'customer', 'active', 0, '2023-07-29', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicles`
--

CREATE TABLE `tbl_vehicles` (
  `vehicleid` int(11) NOT NULL,
  `plateno` varchar(8) NOT NULL,
  `year` int(32) NOT NULL,
  `brandid` int(32) NOT NULL,
  `modelid` int(32) NOT NULL,
  `plateimage` varchar(32) NOT NULL,
  `adddate` date NOT NULL,
  `adduser` int(11) NOT NULL,
  `updatedate` date NOT NULL,
  `updateuser` int(11) NOT NULL,
  `deletestatus` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vehicles`
--

INSERT INTO `tbl_vehicles` (`vehicleid`, `plateno`, `year`, `brandid`, `modelid`, `plateimage`, `adddate`, `adduser`, `updatedate`, `updateuser`, `deletestatus`) VALUES
(1, 'BCW-5392', 2020, 3, 3, '64423ad25c34f8.44752442.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(2, 'BAN-8169', 2018, 3, 3, '64423b7dcba2e4.52761713.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(3, 'BAT-1130', 2020, 3, 3, '64423baeb43db2.22628286.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(4, 'BCF-3013', 2021, 3, 3, '64423bf042e6d7.22905823.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(5, 'BEF-1321', 2021, 3, 2, '64423c6ec3c644.34550942.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(6, 'BGH-8891', 2020, 3, 2, '64423ca238ef86.06995955.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(7, 'BED-9773', 2021, 3, 2, '64423ce8c66509.91375142.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(8, 'BES-3144', 2020, 3, 2, '64423d2ea63bd9.48491192.jpg', '2023-04-21', 16, '0000-00-00', 0, 1),
(12, 'BAK-5681', 2018, 3, 2, '648567e46aaa24.81151688.jpg', '2023-06-11', 34, '0000-00-00', 0, 1),
(13, 'BBA-7881', 2018, 3, 2, '64856a174f2281.10924919.jpg', '2023-06-11', 34, '0000-00-00', 0, 1),
(14, 'BAD-8771', 2018, 3, 2, '64857759035889.25648937.jpg', '2023-06-11', 35, '0000-00-00', 0, 1),
(15, 'BAC-5556', 2012, 3, 2, '648586bbe31d27.65756813.jpg', '2023-06-11', 35, '0000-00-00', 0, 1),
(16, 'BC-5545', 2018, 3, 2, '64858aa8680688.92430713.jpg', '2023-06-11', 35, '0000-00-00', 0, 1),
(17, 'BC-5514', 2018, 3, 2, '64858c6d0fe1e3.22165236.jpg', '2023-06-11', 36, '0000-00-00', 0, 1),
(18, 'BAK-5526', 2018, 3, 2, '64859a60aaef45.59054151.jpg', '2023-06-11', 37, '0000-00-00', 0, 1),
(19, 'BAC-5564', 2017, 3, 2, '6485db9ebe9170.68030434.jpg', '2023-06-11', 38, '0000-00-00', 0, 1),
(20, 'BC-4554', 2008, 3, 2, '6485e132141550.76586868.jpg', '2023-06-11', 39, '0000-00-00', 0, 1),
(25, 'BKA-4587', 2018, 3, 2, '6490177509be32.12151525.jpg', '2023-06-19', 16, '0000-00-00', 0, 1),
(26, 'BAE-4544', 2017, 3, 2, '64af93c34288a9.12381249.jpg', '2023-06-19', 16, '2023-07-13', 16, 1),
(27, 'BW-5369', 2018, 3, 3, '64903e6c2c7803.87053152.jpg', '2023-06-19', 42, '0000-00-00', 0, 1),
(28, 'ACB-5632', 2016, 3, 2, '6499291134f046.20376395.jpg', '2023-06-26', 43, '0000-00-00', 0, 1),
(30, 'BCW-4569', 2018, 3, 3, '649e437c5945c1.67896909.jpg', '2023-06-30', 45, '0000-00-00', 0, 1),
(31, 'BCW-5064', 2007, 3, 3, '64a6b8ca3587e6.78552394.jpg', '2023-07-06', 42, '0000-00-00', 0, 1),
(32, 'BCC-4512', 2012, 3, 2, '64a6b916ab78b0.20345574.jpg', '2023-07-06', 42, '0000-00-00', 0, 1),
(35, 'BAC-5555', 2005, 3, 2, '64abd2dc40e739.01424628.jpg', '2023-07-10', 16, '2023-07-10', 16, 1),
(36, 'BAC-7546', 2015, 3, 3, '64ad99d813bb80.83761262.jpg', '2023-07-11', 46, '0000-00-00', 0, 1),
(37, 'BC-5562', 2015, 3, 3, '64b15475e35403.47946960.jpg', '2023-07-14', 47, '0000-00-00', 0, 1),
(38, 'AEC-4145', 2016, 3, 3, '64b66e802e8a14.49551504.jpg', '2023-07-18', 48, '2023-07-18', 48, 1),
(39, 'BAK-9235', 2015, 3, 2, '64bf62333070c7.48685018.jpg', '2023-07-25', 34, '0000-00-00', 0, 1),
(40, 'ABC-4554', 2018, 3, 3, '64c0ee7b3e5c55.18902686.jpg', '2023-07-26', 49, '0000-00-00', 0, 1),
(41, 'BAC-1469', 2018, 3, 2, '64c20073e2efb2.90256091.jpg', '2023-07-27', 51, '0000-00-00', 0, 1),
(42, 'ABC-2546', 2018, 3, 2, '64c23679e67031.76643743.jpg', '2023-07-27', 52, '0000-00-00', 0, 1),
(43, 'ACB-4785', 2018, 3, 2, '64c26f3e4d0a15.24869520.jpg', '2023-07-27', 53, '0000-00-00', 0, 1),
(44, 'BAA-5841', 2016, 3, 2, '64c2835334d7b3.53006910.jpg', '2023-07-27', 54, '0000-00-00', 0, 1),
(45, 'BAE-5817', 2020, 3, 2, '64c35e52f18572.73810227.jpg', '2023-07-28', 55, '0000-00-00', 0, 1),
(46, 'BAC-4587', 2022, 3, 2, '64c376e683bd52.96840714.jpg', '2023-07-28', 56, '0000-00-00', 0, 1),
(47, 'BAC-8954', 2015, 3, 2, '64c3d9b77086e7.06320719.jpg', '2023-07-28', 57, '0000-00-00', 0, 1),
(48, 'ABC-5819', 2018, 3, 2, '64c4db624cec10.89541588.jpg', '2023-07-29', 62, '0000-00-00', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bays`
--
ALTER TABLE `tbl_bays`
  ADD PRIMARY KEY (`bayid`);

--
-- Indexes for table `tbl_billpayment`
--
ALTER TABLE `tbl_billpayment`
  ADD PRIMARY KEY (`billid`);

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  ADD PRIMARY KEY (`brandid`);

--
-- Indexes for table `tbl_centervehicles`
--
ALTER TABLE `tbl_centervehicles`
  ADD PRIMARY KEY (`vehicleid`);

--
-- Indexes for table `tbl_checkedservicetasks`
--
ALTER TABLE `tbl_checkedservicetasks`
  ADD PRIMARY KEY (`checkedservicetasksid`);

--
-- Indexes for table `tbl_checkedsubservicetasks`
--
ALTER TABLE `tbl_checkedsubservicetasks`
  ADD PRIMARY KEY (`checkedsubservicetaskid`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customerid`);

--
-- Indexes for table `tbl_displaycarousel`
--
ALTER TABLE `tbl_displaycarousel`
  ADD PRIMARY KEY (`carouselid`);

--
-- Indexes for table `tbl_displayservices`
--
ALTER TABLE `tbl_displayservices`
  ADD PRIMARY KEY (`displayserviceid`);

--
-- Indexes for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  ADD PRIMARY KEY (`employeeid`);

--
-- Indexes for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  ADD PRIMARY KEY (`feedbackid`);

--
-- Indexes for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  ADD PRIMARY KEY (`holidayid`);

--
-- Indexes for table `tbl_investigationtasks`
--
ALTER TABLE `tbl_investigationtasks`
  ADD PRIMARY KEY (`investigationtaskid`);

--
-- Indexes for table `tbl_itembrands`
--
ALTER TABLE `tbl_itembrands`
  ADD PRIMARY KEY (`brandid`);

--
-- Indexes for table `tbl_itemcatalog`
--
ALTER TABLE `tbl_itemcatalog`
  ADD PRIMARY KEY (`catalogid`);

--
-- Indexes for table `tbl_itemcatalog_vehicles`
--
ALTER TABLE `tbl_itemcatalog_vehicles`
  ADD PRIMARY KEY (`catalogvehicleid`);

--
-- Indexes for table `tbl_itemcategories`
--
ALTER TABLE `tbl_itemcategories`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `tbl_itemprice`
--
ALTER TABLE `tbl_itemprice`
  ADD PRIMARY KEY (`pricesid`);

--
-- Indexes for table `tbl_itemquotation`
--
ALTER TABLE `tbl_itemquotation`
  ADD PRIMARY KEY (`quotationid`);

--
-- Indexes for table `tbl_itemsofsupplier`
--
ALTER TABLE `tbl_itemsofsupplier`
  ADD PRIMARY KEY (`itemofsupplierid`);

--
-- Indexes for table `tbl_itemstock`
--
ALTER TABLE `tbl_itemstock`
  ADD PRIMARY KEY (`itemstockid`);

--
-- Indexes for table `tbl_itemsubcategories`
--
ALTER TABLE `tbl_itemsubcategories`
  ADD PRIMARY KEY (`subcategoryid`);

--
-- Indexes for table `tbl_jobcardassignitems`
--
ALTER TABLE `tbl_jobcardassignitems`
  ADD PRIMARY KEY (`jobcardassignitemid`);

--
-- Indexes for table `tbl_jobcardassignserviceslist`
--
ALTER TABLE `tbl_jobcardassignserviceslist`
  ADD PRIMARY KEY (`jobcardassignserviceid`);

--
-- Indexes for table `tbl_jobcardassignsubservices`
--
ALTER TABLE `tbl_jobcardassignsubservices`
  ADD PRIMARY KEY (`jobcardassignsubserviceid`);

--
-- Indexes for table `tbl_jobcardinvestigationtasks`
--
ALTER TABLE `tbl_jobcardinvestigationtasks`
  ADD PRIMARY KEY (`jobcardinvestigationtaskid`);

--
-- Indexes for table `tbl_jobcardorderitems`
--
ALTER TABLE `tbl_jobcardorderitems`
  ADD PRIMARY KEY (`jobcardorderid`);

--
-- Indexes for table `tbl_jobcards`
--
ALTER TABLE `tbl_jobcards`
  ADD PRIMARY KEY (`jobcardid`);

--
-- Indexes for table `tbl_jobcardtechnician`
--
ALTER TABLE `tbl_jobcardtechnician`
  ADD PRIMARY KEY (`jobcardtechnicianid`);

--
-- Indexes for table `tbl_jobroles`
--
ALTER TABLE `tbl_jobroles`
  ADD PRIMARY KEY (`jobroleid`);

--
-- Indexes for table `tbl_models`
--
ALTER TABLE `tbl_models`
  ADD PRIMARY KEY (`modelid`);

--
-- Indexes for table `tbl_nextrecommendation`
--
ALTER TABLE `tbl_nextrecommendation`
  ADD PRIMARY KEY (`nextrecommendationid`);

--
-- Indexes for table `tbl_nextrecommendedmileage`
--
ALTER TABLE `tbl_nextrecommendedmileage`
  ADD PRIMARY KEY (`nextrecommendedmileageid`);

--
-- Indexes for table `tbl_nextrecommendedsubservices`
--
ALTER TABLE `tbl_nextrecommendedsubservices`
  ADD PRIMARY KEY (`recommendedsubserviceid`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`orderid`);

--
-- Indexes for table `tbl_purchaseorder`
--
ALTER TABLE `tbl_purchaseorder`
  ADD PRIMARY KEY (`purchaseorderid`);

--
-- Indexes for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD PRIMARY KEY (`reservationid`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`serviceid`);

--
-- Indexes for table `tbl_servicetasks`
--
ALTER TABLE `tbl_servicetasks`
  ADD PRIMARY KEY (`taskid`);

--
-- Indexes for table `tbl_servicevoucher`
--
ALTER TABLE `tbl_servicevoucher`
  ADD PRIMARY KEY (`servicevoucherid`);

--
-- Indexes for table `tbl_stationdetails`
--
ALTER TABLE `tbl_stationdetails`
  ADD PRIMARY KEY (`stationid`);

--
-- Indexes for table `tbl_subservices`
--
ALTER TABLE `tbl_subservices`
  ADD PRIMARY KEY (`subserviceid`);

--
-- Indexes for table `tbl_subservicetasks`
--
ALTER TABLE `tbl_subservicetasks`
  ADD PRIMARY KEY (`taskid`);

--
-- Indexes for table `tbl_supplierpayments`
--
ALTER TABLE `tbl_supplierpayments`
  ADD PRIMARY KEY (`supplierpaymentid`);

--
-- Indexes for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  ADD PRIMARY KEY (`supplierid`);

--
-- Indexes for table `tbl_technicianattendance`
--
ALTER TABLE `tbl_technicianattendance`
  ADD PRIMARY KEY (`attendanceid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  ADD PRIMARY KEY (`vehicleid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bays`
--
ALTER TABLE `tbl_bays`
  MODIFY `bayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_billpayment`
--
ALTER TABLE `tbl_billpayment`
  MODIFY `billid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `brandid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_centervehicles`
--
ALTER TABLE `tbl_centervehicles`
  MODIFY `vehicleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_checkedservicetasks`
--
ALTER TABLE `tbl_checkedservicetasks`
  MODIFY `checkedservicetasksid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `tbl_checkedsubservicetasks`
--
ALTER TABLE `tbl_checkedsubservicetasks`
  MODIFY `checkedsubservicetaskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_displaycarousel`
--
ALTER TABLE `tbl_displaycarousel`
  MODIFY `carouselid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_displayservices`
--
ALTER TABLE `tbl_displayservices`
  MODIFY `displayserviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_employees`
--
ALTER TABLE `tbl_employees`
  MODIFY `employeeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  MODIFY `holidayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_investigationtasks`
--
ALTER TABLE `tbl_investigationtasks`
  MODIFY `investigationtaskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_itembrands`
--
ALTER TABLE `tbl_itembrands`
  MODIFY `brandid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_itemcatalog`
--
ALTER TABLE `tbl_itemcatalog`
  MODIFY `catalogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_itemcatalog_vehicles`
--
ALTER TABLE `tbl_itemcatalog_vehicles`
  MODIFY `catalogvehicleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_itemcategories`
--
ALTER TABLE `tbl_itemcategories`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_itemprice`
--
ALTER TABLE `tbl_itemprice`
  MODIFY `pricesid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_itemquotation`
--
ALTER TABLE `tbl_itemquotation`
  MODIFY `quotationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_itemsofsupplier`
--
ALTER TABLE `tbl_itemsofsupplier`
  MODIFY `itemofsupplierid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_itemstock`
--
ALTER TABLE `tbl_itemstock`
  MODIFY `itemstockid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_itemsubcategories`
--
ALTER TABLE `tbl_itemsubcategories`
  MODIFY `subcategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_jobcardassignitems`
--
ALTER TABLE `tbl_jobcardassignitems`
  MODIFY `jobcardassignitemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tbl_jobcardassignserviceslist`
--
ALTER TABLE `tbl_jobcardassignserviceslist`
  MODIFY `jobcardassignserviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `tbl_jobcardassignsubservices`
--
ALTER TABLE `tbl_jobcardassignsubservices`
  MODIFY `jobcardassignsubserviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_jobcardinvestigationtasks`
--
ALTER TABLE `tbl_jobcardinvestigationtasks`
  MODIFY `jobcardinvestigationtaskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=555;

--
-- AUTO_INCREMENT for table `tbl_jobcardorderitems`
--
ALTER TABLE `tbl_jobcardorderitems`
  MODIFY `jobcardorderid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_jobcards`
--
ALTER TABLE `tbl_jobcards`
  MODIFY `jobcardid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_jobcardtechnician`
--
ALTER TABLE `tbl_jobcardtechnician`
  MODIFY `jobcardtechnicianid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_jobroles`
--
ALTER TABLE `tbl_jobroles`
  MODIFY `jobroleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_models`
--
ALTER TABLE `tbl_models`
  MODIFY `modelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_nextrecommendation`
--
ALTER TABLE `tbl_nextrecommendation`
  MODIFY `nextrecommendationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_nextrecommendedmileage`
--
ALTER TABLE `tbl_nextrecommendedmileage`
  MODIFY `nextrecommendedmileageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_nextrecommendedsubservices`
--
ALTER TABLE `tbl_nextrecommendedsubservices`
  MODIFY `recommendedsubserviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `orderid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchaseorder`
--
ALTER TABLE `tbl_purchaseorder`
  MODIFY `purchaseorderid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  MODIFY `reservationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `serviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_servicetasks`
--
ALTER TABLE `tbl_servicetasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_servicevoucher`
--
ALTER TABLE `tbl_servicevoucher`
  MODIFY `servicevoucherid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_stationdetails`
--
ALTER TABLE `tbl_stationdetails`
  MODIFY `stationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_subservices`
--
ALTER TABLE `tbl_subservices`
  MODIFY `subserviceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_subservicetasks`
--
ALTER TABLE `tbl_subservicetasks`
  MODIFY `taskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tbl_supplierpayments`
--
ALTER TABLE `tbl_supplierpayments`
  MODIFY `supplierpaymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  MODIFY `supplierid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_technicianattendance`
--
ALTER TABLE `tbl_technicianattendance`
  MODIFY `attendanceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  MODIFY `vehicleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
