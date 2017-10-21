-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2016 at 07:13 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `web1_asiantech`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `par_cat_id` int(11) DEFAULT NULL,
  `cat_name` varchar(200) DEFAULT NULL,
  `cat_image_shape` varchar(20) DEFAULT NULL,
  `cat_description` mediumtext,
  `cat_imageurl` mediumtext,
  `cat_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `par_cat_id`, `cat_name`, `cat_image_shape`, `cat_description`, `cat_imageurl`, `cat_status`) VALUES
(1, 1, 'formal shirt', 'square', 'formal shirt', '/images/category/category_1.jpg', 1),
(2, 1, 'casual shirt', 'square', 'lace up shoe', '/images/category/category_2.jpg', 1),
(3, 2, 'high heel shoe', 'square', 'long jean', '/images/category/category_3.jpg', 1),
(4, 2, 'running shoe', 'portrait', 'classic vest', '/images/category/category_4.jpg', 1),
(5, 3, 'long jean', 'square', 'formal shirt', '/images/category/category_5.jpg', 1),
(6, 4, 'classic vest', 'square', 'lace up shoe', '/images/category/category_6.jpg', 1),
(7, 5, 'small bag', 'square', 'long jean', '/images/category/category_7.jpg', 1),
(8, 6, 'short jean', 'portrait', 'classic vest', '/images/category/category_8.jpg', 1),
(9, 7, 'plain tshirt', 'portrait', 'classic vest', '/images/category/category_9.jpg', 1),
(10, 7, 'printed tshirt', 'portrait', 'classic vest', '/images/category/category_10.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_category`
--

DROP TABLE IF EXISTS `master_category`;
CREATE TABLE IF NOT EXISTS `master_category` (
  `mas_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mas_cat_name` varchar(200) DEFAULT NULL,
  `mas_cat_description` mediumtext,
  `mas_cat_imageurl` mediumtext,
  `mas_cat_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`mas_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `master_category`
--

INSERT INTO `master_category` (`mas_cat_id`, `mas_cat_name`, `mas_cat_description`, `mas_cat_imageurl`, `mas_cat_status`) VALUES
(1, 'Man', 'Products for man', 'application/views/images/categories/men_bg.jpg', 1),
(2, 'Woman', 'Products for woman', 'application/views/images/categories/women_bg.jpg', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
