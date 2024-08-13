-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 13, 2024 at 10:44 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hemppmft_finerfits`
--

-- --------------------------------------------------------

--
-- Table structure for table `messagein`
--

CREATE TABLE `messagein` (
  `Id` int(11) NOT NULL,
  `SendTime` datetime DEFAULT NULL,
  `ReceiveTime` datetime DEFAULT NULL,
  `MessageFrom` varchar(80) DEFAULT NULL,
  `MessageTo` varchar(80) DEFAULT NULL,
  `SMSC` varchar(80) DEFAULT NULL,
  `MessageText` text,
  `MessageType` varchar(80) DEFAULT NULL,
  `MessageParts` int(11) DEFAULT NULL,
  `MessagePDU` text,
  `Gateway` varchar(80) DEFAULT NULL,
  `UserId` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messagein`
--

INSERT INTO `messagein` (`Id`, `SendTime`, `ReceiveTime`, `MessageFrom`, `MessageTo`, `SMSC`, `MessageText`, `MessageType`, `MessageParts`, `MessagePDU`, `Gateway`, `UserId`) VALUES
(1, '2017-11-02 05:19:29', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FB0302,870906890101C651018715060350524F585932000187070603534D415254204D4D530001C65201872F060350524F5859325F3100018720060331302E3130322E36312E343600018721068501872206034E4150475052535F320001C6530187230603383038300001010101C600015501873606037734000187070603534D4152', NULL, NULL, NULL, NULL, NULL),
(2, '2017-11-02 05:19:34', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FB0303,54204D4D5300018739060350524F585932000187340603687474703A2F2F31302E3130322E36312E3233383A383030322F00010101', NULL, NULL, NULL, NULL, NULL),
(3, '2017-11-02 05:19:14', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FA0201,6C062F1F2DB69180923646443032463643313042394231363544354242413143304143413232424334343239453236423600030B6A00C54503312E310001C6560187070603534D41525420494E5445524E4554000101C65501871106034E4150475052535F330001871006AB0187070603534D41525420494E5445524E455400', NULL, NULL, NULL, NULL, NULL),
(4, '2017-11-02 05:19:19', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FA0202,0187140187080603696E7465726E65740001870906890101C600015501873606037732000187070603534D41525420494E5445524E45540001872206034E4150475052535F330001C65901873A0603687474703A2F2F6D2E736D6172742E636F6D2E7068000187070603484F4D450001871C01010101', NULL, NULL, NULL, NULL, NULL),
(5, '2017-11-02 05:19:24', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FB0301,6D062F1F2DB69180923432373832413042464145313131463335303137323744303141433530304134373930423843334500030B6A00C54503312E310001C6560187070603534D415254204D4D53000101C65501871106034E4150475052535F320001871006AB0187070603534D415254204D4D530001870806036D6D730001', NULL, NULL, NULL, NULL, NULL),
(6, '2017-11-02 05:19:29', NULL, '211', '+639305235027', NULL, '0B05040B8423F00003FB0302,870906890101C651018715060350524F585932000187070603534D415254204D4D530001C65201872F060350524F5859325F3100018720060331302E3130322E36312E343600018721068501872206034E4150475052535F320001C6530187230603383038300001010101C600015501873606037734000187070603534D4152', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messagelog`
--

CREATE TABLE `messagelog` (
  `Id` int(11) NOT NULL,
  `SendTime` datetime DEFAULT NULL,
  `ReceiveTime` datetime DEFAULT NULL,
  `StatusCode` int(11) DEFAULT NULL,
  `StatusText` varchar(80) DEFAULT NULL,
  `MessageTo` varchar(80) DEFAULT NULL,
  `MessageFrom` varchar(80) DEFAULT NULL,
  `MessageText` text,
  `MessageType` varchar(80) DEFAULT NULL,
  `MessageId` varchar(80) DEFAULT NULL,
  `ErrorCode` varchar(80) DEFAULT NULL,
  `ErrorText` varchar(80) DEFAULT NULL,
  `Gateway` varchar(80) DEFAULT NULL,
  `MessageParts` int(11) DEFAULT NULL,
  `MessagePDU` text,
  `Connector` varchar(80) DEFAULT NULL,
  `UserId` varchar(80) DEFAULT NULL,
  `UserInfo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messagelog`
--

INSERT INTO `messagelog` (`Id`, `SendTime`, `ReceiveTime`, `StatusCode`, `StatusText`, `MessageTo`, `MessageFrom`, `MessageText`, `MessageType`, `MessageId`, `ErrorCode`, `ErrorText`, `Gateway`, `MessageParts`, `MessagePDU`, `Connector`, `UserId`, `UserInfo`) VALUES
(1, '2018-01-27 20:38:08', NULL, 300, NULL, '09305235027', 'Hello Poh', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2018-01-27 20:39:06', NULL, 300, NULL, '09305235027', 'Hello Poh', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2018-01-27 20:49:14', NULL, 300, NULL, '09305235027', 'hi poh', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2018-01-27 20:50:56', NULL, 300, NULL, '09508767867', 'hi poh', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2018-02-09 17:52:26', NULL, 300, NULL, '09486457414', 'Test to send', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2018-02-09 17:54:27', NULL, 300, NULL, '09486457414', 'Test to send', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2018-02-09 17:55:11', NULL, 300, NULL, '09486457414', 'Test to send', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2018-02-09 17:59:11', NULL, 300, NULL, '09486457414', 'Test to send', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2018-02-09 18:00:12', NULL, 200, NULL, '+639486457414', 'yes', NULL, NULL, '1:+639486457414:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2018-02-09 18:01:12', NULL, 200, NULL, '+639486457414', 'Test to send', NULL, NULL, '1:+639486457414:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '2018-02-09 18:02:58', NULL, 200, NULL, '+639486457414', 'FROM JANNO : Confirmed', NULL, NULL, '1:+639486457414:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '2018-02-09 18:05:22', NULL, 200, NULL, '+639486457414', 'FROM Bachelor of Science and Entrepreneurs : Your order has been .Confirmed', NULL, NULL, '1:+639486457414:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '2018-02-09 18:08:14', NULL, 200, NULL, '+639486457414', 'FROM Bachelor of Science and Entrepreneurs : Your order has been .Confirmed', NULL, NULL, '1:+639486457414:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2018-02-09 18:21:41', NULL, 200, NULL, '+639486457414', 'FROM Bachelor of Science and Entrepreneurs : Your order has been .Confirmed', NULL, NULL, '1:+639486457414:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2018-04-01 22:17:34', NULL, 300, NULL, '09123586545', 'Your code is .6048', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '2018-04-01 22:18:20', NULL, 300, NULL, '09123586545', 'Your code is .9305', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2018-04-01 22:20:15', NULL, 300, NULL, '09123586545', 'Your code is .2924', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '2018-04-01 22:42:36', NULL, 300, NULL, '09123586545', 'Your code is .6938', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2018-04-02 00:40:53', NULL, 300, NULL, '9956112920', 'Your code is .7290', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '2018-04-02 00:42:14', NULL, 300, NULL, '9956112920', 'Your code is .4506', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '2018-04-02 00:43:46', NULL, 300, NULL, '9956112920', 'Your code is .4506', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '2018-04-02 00:45:56', NULL, 300, NULL, '09956112920', 'Your code is .6988', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '2018-04-02 00:47:17', NULL, 300, NULL, '09956112920', 'Your code is .4380', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '2018-04-02 00:48:53', NULL, 200, NULL, '639956112920', 'Your code is .5936', NULL, NULL, '1:639956112920:129', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '2018-04-02 00:50:29', NULL, 200, NULL, '639956112920', 'Your code is .5349', NULL, NULL, '1:639956112920:130', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '2018-04-02 00:53:32', NULL, 200, NULL, '639956112920', 'Your code is', NULL, NULL, '1:639956112920:131', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2018-04-02 00:54:43', NULL, 200, NULL, '639956112920', 'Your code is 3407', NULL, NULL, '1:639956112920:132', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messageout`
--

CREATE TABLE `messageout` (
  `Id` int(11) NOT NULL,
  `MessageTo` varchar(80) DEFAULT NULL,
  `MessageFrom` varchar(80) DEFAULT NULL,
  `MessageText` text,
  `MessageType` varchar(80) DEFAULT NULL,
  `Gateway` varchar(80) DEFAULT NULL,
  `UserId` varchar(80) DEFAULT NULL,
  `UserInfo` text,
  `Priority` int(11) DEFAULT NULL,
  `Scheduled` datetime DEFAULT NULL,
  `ValidityPeriod` int(11) DEFAULT NULL,
  `IsSent` tinyint(1) NOT NULL DEFAULT '0',
  `IsRead` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblautonumber`
--

CREATE TABLE `tblautonumber` (
  `ID` int(11) NOT NULL,
  `AUTOSTART` varchar(11) NOT NULL,
  `AUTOINC` int(11) NOT NULL,
  `AUTOEND` int(11) NOT NULL,
  `AUTOKEY` varchar(12) NOT NULL,
  `AUTONUM` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblautonumber`
--

INSERT INTO `tblautonumber` (`ID`, `AUTOSTART`, `AUTOINC`, `AUTOEND`, `AUTOKEY`, `AUTONUM`) VALUES
(1, '2017', 1, 104, 'PROID', 10),
(2, '0', 1, 98, 'ordernumber', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int(11) NOT NULL,
  `USER` varchar(45) NOT NULL,
  `PROID` int(11) NOT NULL,
  `CARTQTY` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `height` int(11) NOT NULL,
  `chest` int(11) NOT NULL,
  `sleeve_length` int(11) NOT NULL,
  `shoulder` int(11) NOT NULL,
  `belly` int(11) NOT NULL,
  `bicep` int(11) NOT NULL,
  `waist` int(11) NOT NULL,
  `hip` int(11) NOT NULL,
  `thigh` int(11) NOT NULL,
  `calf` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fit` varchar(15) NOT NULL,
  `status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`id`, `USER`, `PROID`, `CARTQTY`, `size`, `height`, `chest`, `sleeve_length`, `shoulder`, `belly`, `bicep`, `waist`, `hip`, `thigh`, `calf`, `gender`, `fit`, `status`) VALUES
(18, 'qwerty', 201741, 2, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(19, 'qwerty', 201761, 4, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(40, '9h87mtl32hd6eushvm7umbv7qe', 201761, 1, 'XS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(41, '42637bdfb65b9877ed7583d8bc7d0ac0', 201761, 1, '36R', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(42, 'd010a5d40d5e09712e9a53b3406ac40b', 201740, 1, '42R', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(45, 'dffa414dc4b8b7351d525511e79d4056', 201764, 2, '48R', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(46, 'e9f2a9af2a89943a20060024493ae14b', 201764, 2, '38S', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(47, '8a990d23ffc9056ed4388c06f623f478', 201764, 3, '38S', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Man', '', b'1'),
(49, '8956de98afd8d429d406ee49ca4be81a', 201764, 2, '38S', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(50, '137bdab0fb12ce8b075b0dcf290b469d', 201764, 1, '40R', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(51, '992ae5377be15b65d5401b11a8958424', 201765, 1, '48R', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', b'1'),
(52, '083bbea11881b8c6df2ff28c0f7d8bd3', 201794, 2, '43L', 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, '', '', b'1'),
(53, '133ac7e48e84c5bd63ace8696c968ad2', 201780, 1, '44L', 0, 0, 0, 0, 0, 0, 36, 0, 0, 0, '', '', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `CATEGID` int(11) NOT NULL,
  `CATEGORIES` varchar(255) NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`CATEGID`, `CATEGORIES`, `USERID`) VALUES
(20, 'Men Suits', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer`
--

CREATE TABLE `tblcustomer` (
  `CUSTOMERID` int(11) NOT NULL,
  `FNAME` varchar(30) NOT NULL,
  `LNAME` varchar(30) NOT NULL,
  `MNAME` varchar(30) NOT NULL,
  `CUSHOMENUM` varchar(90) NOT NULL,
  `STREETADD` text NOT NULL,
  `BRGYADD` text NOT NULL,
  `CITYADD` text NOT NULL,
  `PROVINCE` varchar(80) NOT NULL,
  `COUNTRY` varchar(30) NOT NULL,
  `DBIRTH` date NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `PHONE` varchar(20) NOT NULL,
  `EMAILADD` varchar(40) NOT NULL,
  `ZIPCODE` int(6) NOT NULL,
  `CUSUNAME` varchar(20) NOT NULL,
  `CUSPASS` varchar(90) NOT NULL,
  `CUSPHOTO` varchar(255) NOT NULL,
  `TERMS` tinyint(4) NOT NULL,
  `DATEJOIN` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`CUSTOMERID`, `FNAME`, `LNAME`, `MNAME`, `CUSHOMENUM`, `STREETADD`, `BRGYADD`, `CITYADD`, `PROVINCE`, `COUNTRY`, `DBIRTH`, `GENDER`, `PHONE`, `EMAILADD`, `ZIPCODE`, `CUSUNAME`, `CUSPASS`, `CUSPHOTO`, `TERMS`, `DATEJOIN`) VALUES
(1, 'janobe', 'Palacios', '', '321', 'Coloso Street', 'brgy. 1', 'Kabankalan City', 'Negros Occidental', 'Philippines', '0000-00-00', 'Male', '+639956112920', '', 6111, 'kenjie@yahoo.com', '1dd4efc811372cd1efe855981a8863d10ddde1ca', 'customer_image/a1157016c5d8272126380b27a59e2e7e.jpg', 1, '2015-11-26'),
(2, 'Mark Anthony', 'Geasin', '', '1234', 'paglaom', 'dancalan', 'ilog', 'negros occ', 'philippines', '0000-00-00', '', '091023333234', '', 6111, 'bboy', '0377588176145a8f0d837ff6e9bf0c1616268387', 'customer_image/10801930_959054964122877_391305007291646162_n.jpg', 1, '2015-11-26'),
(3, 'Jano', 'Palacios', '', '12312', 's', 'brgy 1', 'kabankalan city', 'negross occidental', 'philippines', '0000-00-00', 'Male', '21312312312', '', 6111, 'jan', '53199fa57fdf5676d03d89fbdd26e69a927766fc', 'customer_image/Tropical-Beach-Wallpaper.jpg', 1, '2017-12-08'),
(4, 'Jamei', 'Laveste', '', '', '', '', 'kabankalan city', '', '', '0000-00-00', 'Female', '362656556', '', 0, 'jame', 'f144dcce05af4d40fa0aeba34b05f4472472a4de', 'customer_image/1351064148bpguarhW.jpg', 1, '2018-01-23'),
(5, 'Jeanniebe', 'Palacios', '', '', '', '', 'Kab City', '', '', '0000-00-00', 'Female', '+639486457414', '', 0, 'bebe', 'd079a1c06803587ea09bff3f44a567e19169e7b5', '', 1, '2018-02-09'),
(6, 'Janry', 'Tan', '', '', '', '', 'Kab City', '', '', '0000-00-00', 'Male', '0234234', '', 0, 'jan', '0271c5467994a9e88e01be5b7e1f5f43d0ab93d2', '', 1, '2018-04-01'),
(7, 'Jake', 'Cuenca', '', '', '', '', 'Kabankalan City', '', '', '0000-00-00', 'Male', '639305235027', '', 0, 'jake', '403ba16f713c8371eef121530a922824be29b68a', '', 1, '2018-04-16'),
(8, 'Jake', 'Tam', '', '', '', '', 'Kab City', '', '', '0000-00-00', 'Male', '021312312', '', 0, 'j', '30e1fe53111f7e583c382596a32885fd27283970', '', 1, '2018-09-23'),
(9, 'Annie', 'Paredes', '', '', '', '', 's', '', '', '0000-00-00', 'Female', '12312312', '', 0, 'an', 'aa46142b604e671794a84129896d4dec508dec81', 'customer_image/shirt2.jpg', 1, '2019-08-20'),
(10, 'zoha', 'gul', '', '', '', '', 'khi', '', '', '0000-00-00', 'Male', '92111111', '', 0, 'zoha', 'eb9bd013134064c3e2f6d1d164d98a5d465dbc8f', '', 1, '2022-08-15'),
(11, 'zoha', 'gula', '', '', '', '', 'khi', '', '', '0000-00-00', 'Male', '48029384209', '', 0, 'zoha', 'bbdbf707cbe1520ae147fd95ffd9455a76e17784', 'customer_image/recommend3.jpg', 1, '2022-08-16'),
(12, 'john', 'elia', '', '', '', '', 'khi', '', '', '0000-00-00', 'Male', '633902830', '', 0, 'johnelia', '8f48819108e2a452a470cd699bd2942146276fd7', 'customer_image/iframe3.png', 1, '2022-08-17'),
(17, 'Gourav', 'Kumar', '', '', 'Main Road', 'Prajapati Bhawan', 'Rourkela', 'Odisha', 'United States', '0000-00-00', '', '07377547571', 'kgourav038@gmail.com', 769001, '', '', '', 1, '2023-09-01'),
(18, 'Gourav', 'Kumar', '', '', 'Main Road', 'Prajapati Bhawan', 'Rourkela', 'Odisha', 'United States', '0000-00-00', '', '7377547571', 'kgourav038@gmail.com', 769001, '', '', '', 1, '2023-09-01'),
(19, 'Gourav', 'Kumar', '', '', 'sundar nagar,hehal', 'near kaju bagan', 'Ranchi', 'jharkhand', 'United States', '0000-00-00', '', '7377547571', 'kgourav038@gmail.com', 834005, '', '', '', 1, '2023-09-04'),
(20, '', '', '', '', '', '', '', '', 'United States', '0000-00-00', '', '', '', 0, '', '', '', 1, '2023-09-04'),
(21, 'Gourav', 'Kumar', '', '', 'Main Road', 'Prajapati Bhawan', 'Rourkela', 'Odisha', 'United States', '0000-00-00', '', '07377547571', 'kgourav038@gmail.com', 769001, '', '', '', 1, '2023-09-12'),
(22, 'Gourav', 'Kumar', '', '', 'Main Road', 'Prajapati Bhawan', 'Rourkela', 'Odisha', 'United States', '0000-00-00', '', '07377547571', 'kgourav038@gmail.com', 769001, '', '', '', 1, '2023-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `tblimages`
--

CREATE TABLE `tblimages` (
  `id` int(11) NOT NULL,
  `proid` int(11) DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblimages`
--

INSERT INTO `tblimages` (`id`, `proid`, `file_name`, `uploaded_on`, `status`) VALUES
(11, 201761, '201762DSC04805.jpg', '2023-08-04 21:40:34', '1'),
(12, 201741, '201768DSC04838.JPG', '2023-08-04 21:42:40', '1'),
(13, 201740, '201772DSC04903.jpg', '2023-08-04 21:44:15', '1'),
(14, 201762, '201774DSC04947.jpg', '2023-08-18 18:45:41', '1'),
(15, 201741, '201768DSC04851.JPG', '2023-08-30 21:33:20', '1'),
(16, 201763, '201763201768DSC04854.jpg', '2023-09-13 19:30:41', '1'),
(17, 201764, '2017642C5A1959.JPG', '2023-09-18 17:57:13', '1'),
(18, 201764, '2017642C5A1964.JPG', '2023-09-18 17:57:13', '1'),
(19, 201764, '2017642C5A1968.JPG', '2023-09-18 17:57:13', '1'),
(20, 201764, '2017642C5A1971.JPG', '2023-09-18 17:57:13', '1'),
(21, 201764, '2017642C5A1972.JPG', '2023-09-18 17:57:13', '1'),
(23, 201765, '201765DSC_7205.JPG', '2023-10-26 15:54:12', '1'),
(24, 201765, '201765DSC_7200.JPG', '2023-10-26 15:54:54', '1'),
(25, 201765, '201765DSC_7207.JPG', '2023-10-26 15:54:54', '1'),
(26, 201765, '201765DSC_7209.JPG', '2023-10-26 15:54:54', '1'),
(27, 201765, '201765DSC_7211.JPG', '2023-10-26 15:54:54', '1'),
(28, 201766, '201766DSC_7575.JPG', '2023-10-26 15:55:44', '1'),
(29, 201766, '201766DSC_7577.JPG', '2023-10-26 15:55:44', '1'),
(30, 201766, '201766DSC_7578.JPG', '2023-10-26 15:55:44', '1'),
(32, 201767, '2017672C5A2764.JPG', '2023-10-26 16:02:05', '1'),
(33, 201767, '2017672C5A2770.JPG', '2023-10-26 16:02:50', '1'),
(34, 201767, '2017672C5A2772.JPG', '2023-10-26 16:02:50', '1'),
(35, 201767, '2017672C5A2774.JPG', '2023-10-26 16:02:50', '1'),
(36, 201768, '201768DSC_7185.JPG', '2023-10-26 16:15:06', '1'),
(37, 201768, '201768DSC_7179.JPG', '2023-10-26 16:16:13', '1'),
(38, 201768, '201768DSC_7188.JPG', '2023-10-26 16:16:13', '1'),
(39, 201768, '201768DSC_7190.JPG', '2023-10-26 16:16:13', '1'),
(40, 201768, '201768DSC_7191.JPG', '2023-10-26 16:16:13', '1'),
(41, 201769, '2017692C5A2353.JPG', '2023-10-26 16:17:03', '1'),
(42, 201769, '2017692C5A2354.JPG', '2023-10-26 16:17:39', '1'),
(43, 201769, '2017692C5A2356.JPG', '2023-10-26 16:17:39', '1'),
(44, 201769, '2017692C5A2357.JPG', '2023-10-26 16:18:20', '1'),
(45, 201770, '201770DSC_7163.JPG', '2023-10-26 16:18:20', '1'),
(46, 201770, '201770DSC_7159.JPG', '2023-10-26 16:19:41', '1'),
(47, 201770, '201770DSC_7170.JPG', '2023-10-26 16:19:41', '1'),
(48, 201770, '201770DSC_7172.JPG', '2023-10-26 16:19:41', '1'),
(49, 201770, '201770DSC_7173.JPG', '2023-10-26 16:19:41', '1'),
(50, 201770, '201770DSC_7174.JPG', '2023-10-26 16:19:41', '1'),
(51, 201771, '2017712C5A2203.JPG', '2023-10-26 16:21:14', '1'),
(53, 201771, '2017712C5A2206.JPG', '2023-10-26 16:22:20', '1'),
(54, 201771, '2017712C5A2197.JPG', '2023-10-26 16:23:46', '1'),
(55, 201771, '2017712C5A2207.JPG', '2023-10-26 16:23:46', '1'),
(56, 201772, '201772DSC_7145.JPG', '2023-10-26 16:24:07', '1'),
(57, 201771, '2017712C5A2196.JPG', '2023-10-26 16:24:23', '1'),
(58, 201772, '201772DSC_7142.JPG', '2023-10-26 16:24:59', '1'),
(59, 201772, '201772DSC_7150.JPG', '2023-10-26 16:24:59', '1'),
(60, 201772, '201772DSC_7153.JPG', '2023-10-26 16:24:59', '1'),
(61, 201772, '201772DSC_7154.JPG', '2023-10-26 16:24:59', '1'),
(62, 201772, '201772DSC_7155.JPG', '2023-10-26 16:24:59', '1'),
(63, 201773, '2017732C5A2213.JPG', '2023-10-26 16:26:44', '1'),
(64, 201774, '201774DSC_7134.JPG', '2023-10-26 16:26:48', '1'),
(65, 201773, '2017732C5A2212.JPG', '2023-10-26 16:27:53', '1'),
(66, 201773, '2017732C5A2220.JPG', '2023-10-26 16:27:53', '1'),
(67, 201773, '2017732C5A2222.JPG', '2023-10-26 16:27:53', '1'),
(68, 201773, '2017732C5A2225.JPG', '2023-10-26 16:27:53', '1'),
(69, 201774, '201774DSC_7123.JPG', '2023-10-26 16:28:04', '1'),
(70, 201774, '201774DSC_7129.JPG', '2023-10-26 16:28:04', '1'),
(71, 201774, '201774DSC_7133.JPG', '2023-10-26 16:28:04', '1'),
(72, 201774, '201774DSC_7136.JPG', '2023-10-26 16:28:04', '1'),
(73, 201774, '201774DSC_7137.JPG', '2023-10-26 16:28:04', '1'),
(74, 201775, '2017752C5A2237.JPG', '2023-10-26 16:30:35', '1'),
(75, 201775, '2017752C5A2227.JPG', '2023-10-26 16:33:42', '1'),
(76, 201775, '2017752C5A2230.JPG', '2023-10-26 16:33:42', '1'),
(77, 201775, '2017752C5A2235.JPG', '2023-10-26 16:33:42', '1'),
(78, 201776, '201776DSC_7116.JPG', '2023-10-26 16:34:01', '1'),
(79, 201775, '2017752C5A2238.JPG', '2023-10-26 16:34:32', '1'),
(80, 201776, '201776DSC_7106.JPG', '2023-10-26 16:34:45', '1'),
(81, 201776, '201776DSC_7111.JPG', '2023-10-26 16:34:45', '1'),
(82, 201776, '201776DSC_7115.JPG', '2023-10-26 16:34:45', '1'),
(83, 201776, '201776DSC_7118.JPG', '2023-10-26 16:34:45', '1'),
(84, 201776, '201776DSC_7119.JPG', '2023-10-26 16:34:45', '1'),
(85, 201777, '2017772C5A2248.JPG', '2023-10-26 16:35:36', '1'),
(86, 201777, '2017772C5A2243.JPG', '2023-10-26 16:36:27', '1'),
(87, 201777, '2017772C5A2254.JPG', '2023-10-26 16:36:27', '1'),
(88, 201777, '2017772C5A2251.JPG', '2023-10-26 16:37:19', '1'),
(89, 201777, '2017772C5A2253.JPG', '2023-10-26 16:37:19', '1'),
(90, 201777, '2017772C5A2256.JPG', '2023-10-26 16:37:19', '1'),
(91, 201778, '2017782C5A2261.JPG', '2023-10-26 16:41:55', '1'),
(92, 201778, '2017782C5A2258.JPG', '2023-10-26 16:43:14', '1'),
(93, 201778, '2017782C5A2265.JPG', '2023-10-26 16:43:14', '1'),
(94, 201778, '2017782C5A2268.JPG', '2023-10-26 16:43:14', '1'),
(95, 201778, '2017782C5A2269.JPG', '2023-10-26 16:43:14', '1'),
(96, 201779, '2017792C5A2276.JPG', '2023-10-26 16:45:17', '1'),
(97, 201780, '201780DSC_7302.JPG', '2023-10-26 16:46:09', '1'),
(98, 201779, '2017792C5A2274 - Copy.JPG', '2023-10-26 16:46:24', '1'),
(99, 201779, '2017792C5A2280 - Copy.JPG', '2023-10-26 16:46:24', '1'),
(100, 201779, '2017792C5A2280.JPG', '2023-10-26 16:46:24', '1'),
(101, 201779, '2017792C5A2282 - Copy.JPG', '2023-10-26 16:46:24', '1'),
(102, 201780, '201780DSC_7294.JPG', '2023-10-26 16:47:13', '1'),
(103, 201780, '201780DSC_7298.JPG', '2023-10-26 16:47:13', '1'),
(104, 201780, '201780DSC_7304.JPG', '2023-10-26 16:47:13', '1'),
(105, 201780, '201780DSC_7307.JPG', '2023-10-26 16:47:13', '1'),
(106, 201781, '2017812C5A2291.JPG', '2023-10-26 16:48:56', '1'),
(107, 201782, '201782DSC_7280.JPG', '2023-10-26 16:49:08', '1'),
(108, 201781, '2017812C5A2288.JPG', '2023-10-26 16:49:51', '1'),
(109, 201781, '2017812C5A2295.JPG', '2023-10-26 16:49:51', '1'),
(110, 201781, '2017812C5A2297.JPG', '2023-10-26 16:49:51', '1'),
(111, 201781, '2017812C5A2299.JPG', '2023-10-26 16:49:51', '1'),
(112, 201782, '201782DSC_7275.JPG', '2023-10-26 16:49:52', '1'),
(113, 201782, '201782DSC_7282.JPG', '2023-10-26 16:49:52', '1'),
(114, 201782, '201782DSC_7284.JPG', '2023-10-26 16:49:52', '1'),
(115, 201782, '201782DSC_7286.JPG', '2023-10-26 16:49:52', '1'),
(116, 201782, '201782DSC_7287.JPG', '2023-10-26 16:49:52', '1'),
(117, 201783, '2017832C5A2310.JPG', '2023-10-26 16:51:42', '1'),
(118, 201783, '2017832C5A2304.JPG', '2023-10-26 16:52:46', '1'),
(119, 201783, '2017832C5A2306.JPG', '2023-10-26 16:52:46', '1'),
(120, 201783, '2017832C5A2314.JPG', '2023-10-26 16:52:46', '1'),
(121, 201783, '2017832C5A2316.JPG', '2023-10-26 16:52:46', '1'),
(122, 201784, '201784DSC_7075.JPG', '2023-10-26 16:53:30', '1'),
(123, 201785, '2017852C5A2321.JPG', '2023-10-26 16:53:45', '1'),
(124, 201784, '201784DSC_7066.JPG', '2023-10-26 16:54:14', '1'),
(125, 201784, '201784DSC_7069.JPG', '2023-10-26 16:54:14', '1'),
(126, 201784, '201784DSC_7078.JPG', '2023-10-26 16:54:14', '1'),
(127, 201784, '201784DSC_7079.JPG', '2023-10-26 16:54:14', '1'),
(128, 201784, '201784DSC_7080.JPG', '2023-10-26 16:54:14', '1'),
(129, 201785, '2017852C5A2318.JPG', '2023-10-26 16:54:37', '1'),
(130, 201785, '2017852C5A2321.JPG', '2023-10-26 16:54:37', '1'),
(131, 201785, '2017852C5A2329.JPG', '2023-10-26 16:54:37', '1'),
(132, 201785, '2017852C5A2331.JPG', '2023-10-26 16:54:37', '1'),
(133, 201786, '2017862C5A2341.JPG', '2023-10-26 16:55:45', '1'),
(134, 201786, '2017862C5A2333.JPG', '2023-10-26 16:56:44', '1'),
(135, 201786, '2017862C5A2341.JPG', '2023-10-26 16:56:44', '1'),
(136, 201786, '2017862C5A2342.JPG', '2023-10-26 16:56:44', '1'),
(137, 201786, '2017862C5A2344.JPG', '2023-10-26 16:56:44', '1'),
(138, 201787, '201787DSC_7054.JPG', '2023-10-26 16:58:12', '1'),
(139, 201787, '201787DSC_7044.JPG', '2023-10-26 16:59:10', '1'),
(140, 201787, '201787DSC_7051.JPG', '2023-10-26 16:59:10', '1'),
(141, 201787, '201787DSC_7056.JPG', '2023-10-26 16:59:10', '1'),
(142, 201787, '201787DSC_7057.JPG', '2023-10-26 16:59:10', '1'),
(143, 201787, '201787DSC_7058.JPG', '2023-10-26 16:59:10', '1'),
(144, 201788, '2017882C5A2336.JPG', '2023-10-26 17:01:15', '1'),
(145, 201788, '2017882C5A2335.JPG', '2023-10-26 17:02:15', '1'),
(146, 201788, '2017882C5A2340.JPG', '2023-10-26 17:02:15', '1'),
(147, 201788, '2017882C5A2343.JPG', '2023-10-26 17:02:15', '1'),
(148, 201788, '2017882C5A2344.JPG', '2023-10-26 17:02:15', '1'),
(149, 201788, '2017882C5A2346.JPG', '2023-10-26 17:02:15', '1'),
(150, 201789, '2017892C5A2366.JPG', '2023-10-26 17:05:25', '1'),
(151, 201789, '2017892C5A2363.JPG', '2023-10-26 17:06:27', '1'),
(152, 201789, '2017892C5A2371.JPG', '2023-10-26 17:06:27', '1'),
(153, 201789, '2017892C5A2373.JPG', '2023-10-26 17:06:27', '1'),
(154, 201789, '2017892C5A2374.JPG', '2023-10-26 17:06:27', '1'),
(155, 201789, '2017892C5A2376.JPG', '2023-10-26 17:06:27', '1'),
(156, 201790, '2017902C5A2381.JPG', '2023-10-26 17:07:19', '1'),
(157, 201791, '201791DSC_7036.JPG', '2023-10-26 17:07:29', '1'),
(158, 201790, '2017902C5A2380.JPG', '2023-10-26 17:08:24', '1'),
(159, 201790, '2017902C5A2387.JPG', '2023-10-26 17:08:24', '1'),
(160, 201790, '2017902C5A2389.JPG', '2023-10-26 17:08:24', '1'),
(161, 201790, '2017902C5A2390.JPG', '2023-10-26 17:08:24', '1'),
(162, 201790, '2017902C5A2393.JPG', '2023-10-26 17:08:24', '1'),
(163, 201791, '201791DSC_7025.JPG', '2023-10-26 17:08:26', '1'),
(164, 201791, '201791DSC_7028.JPG', '2023-10-26 17:08:26', '1'),
(165, 201791, '201791DSC_7030.JPG', '2023-10-26 17:08:26', '1'),
(166, 201791, '201791DSC_7039.JPG', '2023-10-26 17:08:26', '1'),
(167, 201791, '201791DSC_7040.JPG', '2023-10-26 17:08:26', '1'),
(168, 201792, '2017922C5A2934.JPG', '2023-10-26 17:10:48', '1'),
(169, 201793, '2017932C5A2934.JPG', '2023-10-26 17:10:50', '1'),
(170, 201793, '2017932C5A2929.JPG', '2023-10-26 17:12:25', '1'),
(171, 201793, '2017932C5A2931.JPG', '2023-10-26 17:12:25', '1'),
(172, 201793, '2017932C5A2935.JPG', '2023-10-26 17:12:25', '1'),
(173, 201793, '2017932C5A2936.JPG', '2023-10-26 17:12:25', '1'),
(174, 201794, '2017942C5A2399.JPG', '2023-10-26 17:12:43', '1'),
(175, 201794, '2017942C5A2395.JPG', '2023-10-26 17:14:20', '1'),
(176, 201794, '2017942C5A2402.JPG', '2023-10-26 17:14:20', '1'),
(177, 201794, '2017942C5A2405.JPG', '2023-10-26 17:14:20', '1'),
(178, 201794, '2017942C5A2406.JPG', '2023-10-26 17:14:20', '1'),
(179, 201794, '2017942C5A2408.JPG', '2023-10-26 17:14:20', '1'),
(180, 201795, '2017952C5A2413.JPG', '2023-10-26 17:15:55', '1'),
(181, 201795, '2017952C5A2412.JPG', '2023-10-26 17:16:44', '1'),
(182, 201795, '2017952C5A2415.JPG', '2023-10-26 17:16:44', '1'),
(183, 201795, '2017952C5A2418.JPG', '2023-10-26 17:16:44', '1'),
(184, 201795, '2017952C5A2420.JPG', '2023-10-26 17:16:44', '1'),
(185, 201795, '2017952C5A2423.JPG', '2023-10-26 17:16:44', '1'),
(186, 201796, '2017962C5A2429.JPG', '2023-10-26 17:19:15', '1'),
(187, 201796, '2017962C5A2426.JPG', '2023-10-26 17:20:16', '1'),
(188, 201796, '2017962C5A2434.JPG', '2023-10-26 17:20:16', '1'),
(189, 201796, '2017962C5A2436.JPG', '2023-10-26 17:20:16', '1'),
(190, 201796, '2017962C5A2437.JPG', '2023-10-26 17:20:16', '1'),
(191, 201796, '2017962C5A2439.JPG', '2023-10-26 17:20:16', '1'),
(192, 201797, '2017972C5A2919.JPG', '2023-10-26 17:20:47', '1'),
(193, 201797, '2017972C5A2916.JPG', '2023-10-26 17:21:37', '1'),
(194, 201797, '2017972C5A2920.JPG', '2023-10-26 17:21:37', '1'),
(195, 201797, '2017972C5A2922.JPG', '2023-10-26 17:21:37', '1'),
(196, 201797, '2017972C5A2923.JPG', '2023-10-26 17:21:37', '1'),
(197, 201798, '2017982C5A2908.JPG', '2023-10-26 17:27:19', '1'),
(198, 201798, '2017982C5A2902.JPG', '2023-10-26 17:28:16', '1'),
(199, 201798, '2017982C5A2905.JPG', '2023-10-26 17:28:16', '1'),
(200, 201798, '2017982C5A2909.JPG', '2023-10-26 17:28:16', '1'),
(201, 201798, '2017982C5A2910.JPG', '2023-10-26 17:28:16', '1'),
(202, 201799, '2017992C5A2444.JPG', '2023-10-26 17:28:25', '1'),
(203, 201799, '2017992C5A2443.JPG', '2023-10-26 17:29:39', '1'),
(204, 201799, '2017992C5A2448.JPG', '2023-10-26 17:29:39', '1'),
(205, 201799, '2017992C5A2451.JPG', '2023-10-26 17:29:39', '1'),
(206, 201799, '2017992C5A2452.JPG', '2023-10-26 17:29:39', '1'),
(207, 201799, '2017992C5A2454.JPG', '2023-10-26 17:29:39', '1'),
(208, 2017100, '20171002C5A2894.JPG', '2023-10-26 17:30:49', '1'),
(209, 2017100, '20171002C5A2890.JPG', '2023-10-26 17:31:38', '1'),
(210, 2017100, '20171002C5A2892.JPG', '2023-10-26 17:31:38', '1'),
(211, 2017100, '20171002C5A2896.JPG', '2023-10-26 17:31:38', '1'),
(212, 2017100, '20171002C5A2897.JPG', '2023-10-26 17:31:38', '1'),
(213, 2017101, '20171012C5A2878.JPG', '2023-10-26 18:22:19', '1'),
(214, 2017101, '20171012C5A2875.JPG', '2023-10-26 18:23:10', '1'),
(215, 2017101, '20171012C5A2880.JPG', '2023-10-26 18:23:10', '1'),
(216, 2017101, '20171012C5A2882.JPG', '2023-10-26 18:23:10', '1'),
(217, 2017101, '20171012C5A2883.JPG', '2023-10-26 18:23:10', '1'),
(218, 2017101, '20171012C5A2884.JPG', '2023-10-26 18:23:10', '1'),
(219, 2017102, '20171022C5A2069.JPG', '2023-10-31 18:43:50', '1'),
(220, 2017102, '20171022C5A2073.JPG', '2023-10-31 18:43:50', '1'),
(221, 2017102, '20171022C5A2075.JPG', '2023-10-31 18:43:50', '1'),
(222, 2017102, '20171022C5A2078.JPG', '2023-10-31 18:43:50', '1'),
(223, 2017102, '20171022C5A2079.JPG', '2023-10-31 18:43:50', '1'),
(224, 2017102, '20171022C5A2082.JPG', '2023-10-31 18:43:50', '1'),
(225, 2017102, '2017102Sky Blue Blazer-22 339.mp4', '2023-10-31 18:43:50', '1'),
(226, 2017103, '2017103anklepain.jpg', '2023-10-31 18:46:56', '1'),
(227, 2017103, '2017103armpain.jpg', '2023-10-31 18:46:56', '1'),
(228, 2017103, '2017103armpain-2.jpg', '2023-10-31 18:46:56', '1'),
(229, 2017103, '2017103backpain.jpg', '2023-10-31 18:46:56', '1'),
(230, 2017103, '2017103bg_1.jpg', '2023-10-31 18:46:56', '1'),
(231, 2017103, '2017103bg_2.jpg', '2023-10-31 18:46:56', '1'),
(232, 2017103, '2017103bg_3.jpg', '2023-10-31 18:46:56', '1'),
(233, 2017103, '2017103footpain.jpg', '2023-10-31 18:46:56', '1'),
(234, 2017103, '2017103headaches.jpg', '2023-10-31 18:46:56', '1'),
(235, 2017103, '2017103this.mp4', '2023-10-31 18:46:56', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblorder`
--

CREATE TABLE `tblorder` (
  `ORDERID` int(11) NOT NULL,
  `PROID` int(11) NOT NULL,
  `ORDEREDQTY` int(11) NOT NULL,
  `ORDEREDPRICE` double NOT NULL,
  `ORDEREDNUM` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `height` int(11) NOT NULL,
  `chest` int(11) NOT NULL,
  `sleeve_length` int(11) NOT NULL,
  `shoulder` int(11) NOT NULL,
  `belly` int(11) NOT NULL,
  `bicep` int(11) NOT NULL,
  `waist` int(11) NOT NULL,
  `hip` int(11) NOT NULL,
  `thigh` int(11) NOT NULL,
  `calf` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `fit` varchar(15) NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblorder`
--

INSERT INTO `tblorder` (`ORDERID`, `PROID`, `ORDEREDQTY`, `ORDEREDPRICE`, `ORDEREDNUM`, `size`, `height`, `chest`, `sleeve_length`, `shoulder`, `belly`, `bicep`, `waist`, `hip`, `thigh`, `calf`, `gender`, `fit`, `USERID`) VALUES
(63, 201740, 2, 149, 102, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(64, 201762, 4, 7, 102, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(65, 201741, 4, 89, 102, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(66, 201761, 2, 23, 102, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(70, 201761, 2, 23, 103, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(71, 201762, 1, 7, 103, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(72, 201762, 1, 7, 104, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(73, 201761, 1, 23, 104, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0),
(76, 201762, 1, 7, 106, '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 'Man', 'slim fit', 0),
(77, 201764, 1, 13999, 107, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `PROID` int(11) NOT NULL,
  `PROTITLE` varchar(255) NOT NULL,
  `PRODESC` varchar(500) DEFAULT NULL,
  `INGREDIENTS` varchar(255) NOT NULL,
  `PROQTY` int(11) DEFAULT NULL,
  `ORIGINALPRICE` double NOT NULL,
  `PROPRICE` double DEFAULT NULL,
  `USDPRICE` int(11) NOT NULL,
  `USDMRP` int(11) NOT NULL,
  `CATEGID` int(11) DEFAULT NULL,
  `SUBCATID` int(11) NOT NULL,
  `IMAGES` varchar(255) DEFAULT NULL,
  `PROSTATS` varchar(30) DEFAULT NULL,
  `OWNERNAME` varchar(90) NOT NULL,
  `OWNERPHONE` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`PROID`, `PROTITLE`, `PRODESC`, `INGREDIENTS`, `PROQTY`, `ORIGINALPRICE`, `PROPRICE`, `USDPRICE`, `USDMRP`, `CATEGID`, `SUBCATID`, `IMAGES`, `PROSTATS`, `OWNERNAME`, `OWNERPHONE`) VALUES
(201764, 'Finerfits Men green Modern-Fit Suit', 'Care Instructions: Dry Clean Only\r\nPremium Viscose Material: Our suit is meticulously crafted from high-quality viscose fabric, known for its exceptional softness, breathability, and drape.\r\n It ensures you not only look great but feel incredibly comforta', '', 5, 14999, 8999, 199, 0, 20, 5, NULL, 'Available', '', ''),
(201765, 'Finerfits suit-Men blue 3 piece suit for groom & groomsmen wedding', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFINERFITS introduce our latest range of tweed man suit, complete 3 piece suits designed in India hand crafted by master tailors, straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete                       ', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201766, 'Finerfits man tweed 3 piece suit', 'PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With B  ', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(201767, 'Finerfits man tweed red 2 piece suit', 'PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With B  ', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(201768, 'Finerfits suit-Men orange 3 piece suit for groom & groomsmen wedding', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201769, 'Finerfits stylish tweed blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blezer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 5999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201770, 'Men red 3 piece suit for groom & groomsmen wedding-Finerfits suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201771, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blezer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 179, 0, 20, 9, NULL, 'Available', '', ''),
(201772, 'Finerfits beige Suit-men 3 piece suit for groom & groomsmen', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201773, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 179, 0, 20, 9, NULL, 'Available', '', ''),
(201774, 'Finerfits Orange Suit-men 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201775, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 189, 0, 20, 9, NULL, 'Available', '', ''),
(201776, 'Finerfits peach color Suit-men 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201777, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 179, 0, 20, 9, NULL, 'Available', '', ''),
(201778, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 179, 0, 20, 6, NULL, 'Available', '', ''),
(201779, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201780, 'Finerfits blue Suit-men 3 piece suit ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201781, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201782, 'Finerfits black Suit-men 3 piece suit for groom & groomsmen wedding', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201783, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201784, 'Finerfits pink Suit-men 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201785, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201786, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201787, 'Finerfits teal blue Suit-men 3 piece suit prom party wear suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201788, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201789, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201790, 'Finerfits stylish tweed vest and blazer ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\nWe introduce our latest range of man tweed Blazer with premium quality suits designed in india hand crafted by master tailors, straight from factory to your door.\r\n. tweed Blazer.\r\n• slim fit\r\n• Pe', '', 15, 12999, 6999, 199, 0, 20, 9, NULL, 'Available', '', ''),
(201791, 'Finerfits rust  Suit-men 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201793, 'Finerfits magenta Suit-Men 2 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201794, 'Finerfits man tweed 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With   ', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(201795, 'Finerfits man tweed 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With   ', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(201796, 'Finerfits man tweed 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors, straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With  ', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(201797, 'Finerfits sage green Suit-Men 2 piece suit ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201798, 'Finerfits rust orange Suit-Men 2 piece suit ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(201799, 'Finerfits man tweed 3 piece suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 6, NULL, 'Available', '', ''),
(2017100, 'Finerfits green Suit-Men 2 piece suit-bespoke suit', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 15, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(2017101, 'Finerfits brown Suit-Men 2 piece suit ', '\"PLEASE CHECK SIZE CHART CAREFULLY BEFORE PLACING ORDER\"\r\n\r\nFinerfits introduce our latest range of man suit, complete 3 piece suits designed in India hand crafted by master tailors,straight from factory to your door.\r\n\r\n3 Piece man Suit, Complete With Bl', '', 20, 14999, 7999, 199, 0, 20, 4, NULL, 'Available', '', ''),
(2017102, 'Test - 1 ', 'This is a test module.\r\n\r\n\r\npoint 1\r\npoint 2', '', 15, 13999, 10999, 369, 499, 20, 6, NULL, 'Available', '', ''),
(2017103, 'Test 23', 'This is a test', '', 15, 23699, 20999, 1099, 1299, 20, 5, NULL, 'Available', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblpromopro`
--

CREATE TABLE `tblpromopro` (
  `PROMOID` int(11) NOT NULL,
  `PROID` int(11) NOT NULL,
  `PRODISCOUNT` double NOT NULL,
  `PRODISPRICE` double NOT NULL,
  `PROBANNER` tinyint(4) NOT NULL,
  `PRONEW` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpromopro`
--

INSERT INTO `tblpromopro` (`PROMOID`, `PROID`, `PRODISCOUNT`, `PRODISPRICE`, `PROBANNER`, `PRONEW`) VALUES
(28, 201764, 0, 13999, 0, 0),
(29, 201765, 0, 7999, 0, 0),
(30, 201766, 0, 7999, 0, 0),
(31, 201767, 0, 7999, 0, 0),
(32, 201768, 0, 7999, 0, 0),
(33, 201769, 0, 5999, 0, 0),
(34, 201770, 0, 7999, 0, 0),
(35, 201771, 0, 5999, 0, 0),
(36, 201772, 0, 7999, 0, 0),
(37, 201773, 0, 5999, 0, 0),
(38, 201774, 0, 7999, 0, 0),
(39, 201775, 0, 6999, 0, 0),
(40, 201776, 0, 7999, 0, 0),
(41, 201777, 0, 5999, 0, 0),
(42, 201778, 0, 6999, 0, 0),
(43, 201779, 0, 6999, 0, 0),
(44, 201780, 0, 7999, 0, 0),
(45, 201781, 0, 6999, 0, 0),
(46, 201782, 0, 7999, 0, 0),
(47, 201783, 0, 6999, 0, 0),
(48, 201784, 0, 7999, 0, 0),
(49, 201785, 0, 6999, 0, 0),
(50, 201786, 0, 6999, 0, 0),
(51, 201787, 0, 7999, 0, 0),
(52, 201788, 0, 6999, 0, 0),
(53, 201789, 0, 6999, 0, 0),
(54, 201790, 0, 6999, 0, 0),
(55, 201791, 0, 7999, 0, 0),
(57, 201793, 0, 7999, 0, 0),
(58, 201794, 0, 7999, 0, 0),
(59, 201795, 0, 7999, 0, 0),
(60, 201796, 0, 7999, 0, 0),
(61, 201797, 0, 7999, 0, 0),
(62, 201798, 0, 7999, 0, 0),
(63, 201799, 0, 7999, 0, 0),
(64, 2017100, 0, 7999, 0, 0),
(65, 2017101, 0, 7999, 0, 0),
(66, 2017102, 0, 10999, 0, 0),
(67, 2017103, 0, 20999, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsetting`
--

CREATE TABLE `tblsetting` (
  `SETTINGID` int(11) NOT NULL,
  `PLACE` text NOT NULL,
  `BRGY` varchar(90) NOT NULL,
  `DELPRICE` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsetting`
--

INSERT INTO `tblsetting` (`SETTINGID`, `PLACE`, `BRGY`, `DELPRICE`) VALUES
(1, 'Kabankalan City', 'Brgy. 1', 50),
(2, 'Himamaylan City', 'Brgy. 1', 70);

-- --------------------------------------------------------

--
-- Table structure for table `tblstockin`
--

CREATE TABLE `tblstockin` (
  `STOCKINID` int(11) NOT NULL,
  `STOCKDATE` datetime DEFAULT NULL,
  `PROID` int(11) DEFAULT NULL,
  `STOCKQTY` int(11) DEFAULT NULL,
  `STOCKPRICE` double DEFAULT NULL,
  `USERID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `SUBCATID` int(11) NOT NULL,
  `SUBCATEGORY` varchar(255) CHARACTER SET latin1 NOT NULL,
  `CATEGID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsubcategory`
--

INSERT INTO `tblsubcategory` (`SUBCATID`, `SUBCATEGORY`, `CATEGID`, `USERID`) VALUES
(4, 'men cotton viscose suit', 0, 0),
(5, 'Men viscose suits', 20, 0),
(6, 'Tweed man suit', 0, 0),
(7, 'suede/velvet blazer', 0, 0),
(8, 'Linen man suit', 0, 0),
(9, 'tweed man blazer', 0, 0),
(10, 'tweed man vest', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsummary`
--

CREATE TABLE `tblsummary` (
  `SUMMARYID` int(11) NOT NULL,
  `ORDEREDDATE` datetime NOT NULL,
  `CUSTOMERID` int(11) NOT NULL,
  `ORDEREDNUM` int(11) NOT NULL,
  `DELFEE` double NOT NULL,
  `PAYMENT` double NOT NULL,
  `PAYMENTMETHOD` varchar(30) NOT NULL,
  `ORDEREDSTATS` varchar(30) NOT NULL,
  `ORDEREDREMARKS` varchar(125) NOT NULL,
  `CLAIMEDADTE` datetime NOT NULL,
  `roi` varchar(20) NOT NULL,
  `pai` varchar(20) NOT NULL,
  `HVIEW` tinyint(4) NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblsummary`
--

INSERT INTO `tblsummary` (`SUMMARYID`, `ORDEREDDATE`, `CUSTOMERID`, `ORDEREDNUM`, `DELFEE`, `PAYMENT`, `PAYMENTMETHOD`, `ORDEREDSTATS`, `ORDEREDREMARKS`, `CLAIMEDADTE`, `roi`, `pai`, `HVIEW`, `USERID`) VALUES
(20, '2023-09-01 05:04:01', 17, 102, 10, 728, 'online', 'Confirmed', 'Your order has been confirmed.', '2023-09-01 05:04:01', '', '', 0, 0),
(21, '2023-09-01 05:22:52', 18, 103, 10, 53, 'online', 'Confirmed', 'Your order has been confirmed.', '2023-09-01 05:22:52', 'order_MX7RYCLCvMFi4z', 'pay_MX7RsmMGSbpyRI', 0, 0),
(22, '2023-09-04 04:25:22', 19, 104, 10, 30, 'online', 'Confirmed', 'Your order has been confirmed.', '2023-09-05 00:00:00', '4WH1077526555411Y', 'EAT2T3CE5VUUA', 0, 0),
(24, '2023-09-12 02:39:47', 21, 106, 10, 7, 'online', 'Confirmed', 'Your order has been confirmed.', '2023-09-12 00:00:00', 'order_MbQXICNF39TEiF', 'pay_MbQXwrQXUKgg6z', 0, 0),
(25, '2023-09-28 01:00:00', 22, 107, 10, 13999, 'online', 'Cancelled', 'Your order has been cancelled due to lack of communication and incomplete information.', '0000-00-00 00:00:00', 'order_MhZ9l97m2XsEVJ', 'pay_MhZAcQVVJIhvgN', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `USERID` int(11) NOT NULL,
  `U_NAME` varchar(122) NOT NULL,
  `U_USERNAME` varchar(122) NOT NULL,
  `U_PASS` varchar(122) NOT NULL,
  `U_ROLE` varchar(30) NOT NULL,
  `USERIMAGE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`USERID`, `U_NAME`, `U_USERNAME`, `U_PASS`, `U_ROLE`, `USERIMAGE`) VALUES
(127, 'gourav', 'gourav', '7889dc82a476c81354d1351687901fc2e84b5ef5', 'Administrator', ''),
(128, 'FinerFits', 'Finerfits_Admin', '8859be0f139c9855bbaade838a4bc88cbf3f284e', 'Administrator', ''),
(129, 'gourav', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Staff', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

CREATE TABLE `tblwishlist` (
  `id` int(11) NOT NULL,
  `CUSID` int(11) NOT NULL,
  `PROID` int(11) NOT NULL,
  `WISHDATE` date NOT NULL,
  `WISHSTATS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblwishlist`
--

INSERT INTO `tblwishlist` (`id`, `CUSID`, `PROID`, `WISHDATE`, `WISHSTATS`) VALUES
(2, 9, 201742, '2019-08-21', '0'),
(3, 10, 201740, '2022-08-15', '0'),
(4, 12, 201742, '2022-08-17', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messagein`
--
ALTER TABLE `messagein`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `messagelog`
--
ALTER TABLE `messagelog`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IDX_MessageId` (`MessageId`,`SendTime`);

--
-- Indexes for table `messageout`
--
ALTER TABLE `messageout`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IDX_IsRead` (`IsRead`);

--
-- Indexes for table `tblautonumber`
--
ALTER TABLE `tblautonumber`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`CATEGID`);

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`CUSTOMERID`);

--
-- Indexes for table `tblimages`
--
ALTER TABLE `tblimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblorder`
--
ALTER TABLE `tblorder`
  ADD PRIMARY KEY (`ORDERID`),
  ADD KEY `USERID` (`USERID`),
  ADD KEY `PROID` (`PROID`),
  ADD KEY `ORDEREDNUM` (`ORDEREDNUM`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`PROID`),
  ADD KEY `CATEGID` (`CATEGID`);

--
-- Indexes for table `tblpromopro`
--
ALTER TABLE `tblpromopro`
  ADD PRIMARY KEY (`PROMOID`),
  ADD UNIQUE KEY `PROID` (`PROID`);

--
-- Indexes for table `tblsetting`
--
ALTER TABLE `tblsetting`
  ADD PRIMARY KEY (`SETTINGID`);

--
-- Indexes for table `tblstockin`
--
ALTER TABLE `tblstockin`
  ADD PRIMARY KEY (`STOCKINID`),
  ADD KEY `PROID` (`PROID`,`USERID`),
  ADD KEY `USERID` (`USERID`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`SUBCATID`);

--
-- Indexes for table `tblsummary`
--
ALTER TABLE `tblsummary`
  ADD PRIMARY KEY (`SUMMARYID`),
  ADD UNIQUE KEY `ORDEREDNUM` (`ORDEREDNUM`),
  ADD KEY `CUSTOMERID` (`CUSTOMERID`),
  ADD KEY `USERID` (`USERID`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`USERID`);

--
-- Indexes for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messagein`
--
ALTER TABLE `messagein`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messagelog`
--
ALTER TABLE `messagelog`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `messageout`
--
ALTER TABLE `messageout`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblautonumber`
--
ALTER TABLE `tblautonumber`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `CATEGID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `CUSTOMERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblimages`
--
ALTER TABLE `tblimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `tblorder`
--
ALTER TABLE `tblorder`
  MODIFY `ORDERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tblpromopro`
--
ALTER TABLE `tblpromopro`
  MODIFY `PROMOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tblsetting`
--
ALTER TABLE `tblsetting`
  MODIFY `SETTINGID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblstockin`
--
ALTER TABLE `tblstockin`
  MODIFY `STOCKINID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `SUBCATID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblsummary`
--
ALTER TABLE `tblsummary`
  MODIFY `SUMMARYID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tblwishlist`
--
ALTER TABLE `tblwishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
