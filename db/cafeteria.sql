-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2015 at 09:39 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafeteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) NOT NULL,
  `cat_desc` varchar(50) NOT NULL,
  `modifiy_date` date NOT NULL,
  `status` smallint(11) NOT NULL DEFAULT '1',
  `cat_img` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_desc`, `modifiy_date`, `status`, `cat_img`) VALUES
(1, 'new', 'mmmmmmmmmmmmmmmmmmm\r\n', '2015-02-20', -1, ''),
(2, 'mnb', 'kjgytdsmm\r\n', '2015-02-23', 1, ''),
(3, 'mens', 'efrge', '2015-02-24', 1, ''),
(9, 'ewqasdsaddddddddddd', '', '2015-04-15', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_date_time` text NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_date_time`, `total_price`, `total_quantity`, `order_date`, `status`) VALUES
(52, 12, 'Apr 15, 2015 3:46:48 AM', 4, 1, '2015-04-12', 1),
(53, 13, 'Apr 15, 2015 3:54:34 AM', 8, 2, '2015-04-15', 0),
(54, 12, 'Apr 15, 2015 6:58:31 AM', 4, 1, '2015-04-15', -1),
(55, 12, 'Apr 15, 2015 7:14:42 AM', 12, 3, '2015-04-15', 0),
(56, 12, 'Apr 15, 2015 7:49:53 AM', 12, 3, '2015-04-15', 0),
(57, 12, 'Apr 15, 2015 9:34:46 AM', 18, 5, '2015-04-15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `pro_name` varchar(11) NOT NULL,
  `img` varchar(50) NOT NULL,
  `pro_price` int(11) NOT NULL,
  `modifiy_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pro_id`, `cat_id`, `pro_name`, `img`, `pro_price`, `modifiy_date`, `status`) VALUES
(28, 1, 'tea', '1429061525_', 4, '0000-00-00', 1),
(29, 2, 'coffe', '1429061546_', 2, '0000-00-00', 1),
(30, -1, 'ice', '1429061567_', 6, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE IF NOT EXISTS `product_order` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`order_id`, `product_id`, `product_quantity`, `product_price`) VALUES
(52, 28, 1, 4),
(53, 29, 1, 2),
(53, 30, 1, 6),
(54, 28, 1, 4),
(55, 29, 1, 2),
(55, 28, 1, 4),
(55, 30, 1, 6),
(56, 28, 1, 4),
(56, 29, 1, 2),
(56, 30, 1, 6),
(57, 28, 2, 8),
(57, 29, 2, 4),
(57, 30, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_img` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_room` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_ext` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `status` int(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_email`, `user_img`, `user_room`, `user_ext`, `creation_date`, `status`) VALUES
(12, 'maged', '123', 'maged@yahoo.com', '1429061641_', '1222354', 656, '0000-00-00', 1),
(13, 'heidy', '123', 'sad@yahoo.com', '1429061691_', '9898', 7878, '0000-00-00', 1),
(14, 'admin', 'admin', 'admin@yahoo.com', 'admin.png', '', 0, '0000-00-00', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
