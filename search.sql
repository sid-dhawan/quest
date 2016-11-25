-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2016 at 02:51 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `search`
--

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `Word` varchar(140) NOT NULL,
  `URL` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`Word`, `URL`) VALUES
('IIIT Delhi', 'https://www.iiitd.ac.in/'),
('IIITD', 'https://www.iiitd.ac.in/'),
('Indraprastha Institute Of Information Technology', 'https://www.iiitd.ac.in/'),
('Indraprastha Institute Of Information Technology, Delhi', 'https://www.iiitd.ac.in/'),
('Indraprastha Institute', 'https://www.iiitd.ac.in/'),
('Foobar', 'https://www.iiitd.ac.in/'),
('Foobar', 'http://foobar.iiitd.edu.in/'),
('Audiobytes', 'https://sites.google.com/a/iiitd.ac.in/audiobytes/'),
('Astronuts', 'https://sites.google.com/a/iiitd.ac.in/astronuts/'),
('Byld', 'http://byld.iiitd.edu.in/');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
