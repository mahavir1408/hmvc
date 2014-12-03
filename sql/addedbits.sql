-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 03, 2014 at 09:24 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `addedbits`
--

-- --------------------------------------------------------

--
-- Table structure for table `ab_admin`
--

CREATE TABLE IF NOT EXISTS `ab_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `last_access` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ab_admin`
--

INSERT INTO `ab_admin` (`id`, `name`, `email`, `passwd`, `last_access`, `is_active`) VALUES
(1, 'Mahavir Munot', 'veer712@gmail.com', '9adae88d4114c5e6212de9c9a36929d7', '2013-10-19 16:17:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ab_comment`
--

CREATE TABLE IF NOT EXISTS `ab_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(70) NOT NULL,
  `comment` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ab_directory`
--

CREATE TABLE IF NOT EXISTS `ab_directory` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ab_directory`
--

INSERT INTO `ab_directory` (`id`, `display_name`, `slug`, `uri`, `parent_id`, `created_at`, `is_published`) VALUES
(1, 'Level1 Directory1', 'level1-directory1', '/level1-directory1', 0, '2014-01-15 12:46:45', 1),
(2, 'Level2 Directory1', 'level2-directory1', '/level1-directory1/level2-directory1', 1, '2014-01-15 12:51:31', 1),
(3, 'Level3 Directory1', 'level3-directory1', '/level1-directory1/level2-directory1/level3-directory1', 2, '2014-01-15 12:54:25', 1),
(4, 'Level4 Directory1', 'level4-directory1', '/level1-directory1/level2-directory1/level3-directory1/level4-directory1', 3, '2014-01-15 12:58:18', 1),
(5, 'Level4 Sub-Directory1', 'level4-sub-directory1', '/level1-directory1/level2-directory1/level3-directory1/level4-directory1/level4-sub-directory1', 4, '2014-01-15 13:00:38', 1),
(6, 'Level1 Directory2', 'level1-directory2', '/level1-directory2', 0, '2014-01-16 05:54:05', 1),
(7, 'Level1 Directory3', 'level1-directory3', '/level1-directory3', 0, '2014-01-16 05:54:44', 1),
(8, 'Level1 Directory4', 'level1-directory4', '/level1-directory4', 0, '2014-01-16 05:54:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ab_page`
--

CREATE TABLE IF NOT EXISTS `ab_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_title` varchar(70) NOT NULL,
  `meta_description` varchar(155) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `head` varchar(255) NOT NULL,
  `leader` tinytext NOT NULL,
  `directory_id` int(11) NOT NULL,
  `parent_directory_id` int(11) NOT NULL,
  `page_type` enum('page','directory') NOT NULL DEFAULT 'page',
  `created_at` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `is_published` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `head` (`head`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ab_page`
--

INSERT INTO `ab_page` (`id`, `meta_title`, `meta_description`, `page_name`, `uri`, `head`, `leader`, `directory_id`, `parent_directory_id`, `page_type`, `created_at`, `userid`, `is_published`) VALUES
(1, '', '', 'level1-page1', 'level1-page1', 'level1 page1', '', 0, 0, 'page', '2014-01-15 12:45:08', 1, 0),
(2, '', '', 'level1-page2', 'level1-page2', 'level1 page2', '', 0, 0, 'page', '2014-01-15 12:45:52', 1, 0),
(3, '', '', '', '/level1-directory1', 'Level1 Directory1', '', 1, 0, 'directory', '2014-01-15 12:46:46', 1, 0),
(4, '', '', 'level2-page1', '/level1-directory1/level2-page1', 'Level2 Page1', '', 1, 1, 'page', '2014-01-15 12:47:52', 1, 0),
(5, '', '', '', '/level1-directory1/level2-directory1', 'Level2 Directory1', '', 2, 1, 'directory', '2014-01-15 12:51:31', 1, 0),
(6, '', '', '', '/level1-directory1/level2-directory1/level3-directory1', 'Level3 Directory1', '', 3, 2, 'directory', '2014-01-15 12:54:25', 1, 0),
(7, '', '', '', '/level1-directory1/level2-directory1/level3-directory1/level4-directory1', 'Level4 Directory1', '', 4, 3, 'directory', '2014-01-15 12:58:18', 1, 0),
(8, '', '', 'level4-page1', '/level1-directory1/level2-directory1/level3-directory1/level4-directory1/level4-page1', 'Level4 Page1', '', 4, 4, 'page', '2014-01-15 12:58:44', 1, 0),
(9, '', '', '', '/level1-directory1/level2-directory1/level3-directory1/level4-directory1/level4-sub-directory1', 'Level4 Sub-Directory1', '', 5, 4, 'directory', '2014-01-15 13:00:38', 1, 0),
(10, '', '', 'level3-sub-page1', '/level1-directory1/level2-directory1/level3-directory1/level3-sub-page1', 'Level3 Sub Page1', '', 3, 3, 'page', '2014-01-15 13:01:32', 1, 0),
(11, '', '', '', '/level1-directory2', 'Level1 Directory2', '', 6, 0, 'directory', '2014-01-16 05:54:05', 1, 0),
(12, '', '', '', '/level1-directory3', 'Level1 Directory3', '', 7, 0, 'directory', '2014-01-16 05:54:44', 1, 0),
(13, '', '', '', '/level1-directory4', 'Level1 Directory4', '', 8, 0, 'directory', '2014-01-16 05:54:58', 1, 0),
(14, '', '', 'level1-page1', 'level1-page1', 'level1 page1', '', 0, 0, 'page', '2014-01-16 12:30:03', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ab_page_content`
--

CREATE TABLE IF NOT EXISTS `ab_page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
