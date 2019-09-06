-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sndrsn.db
-- Generation Time: Sep 06, 2019 at 03:10 PM
-- Server version: 5.3.12-MariaDB
-- PHP Version: 7.2.19-nfsn1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rateapaper`
--

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE `papers` (
  `id` int(11) NOT NULL,
  `doi` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `authors` text NOT NULL,
  `date` text NOT NULL,
  `journal` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `possible_answers`
--

CREATE TABLE `possible_answers` (
  `id` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `answer_order` int(11) NOT NULL,
  `answer_text` text NOT NULL,
  `answer_color` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `possible_answers`
--

INSERT INTO `possible_answers` (`id`, `question`, `answer_order`, `answer_text`, `answer_color`) VALUES
(1, 0, 0, 'Yes', '#abfad4'),
(2, 0, 1, 'No', '#fdc4d2'),
(3, 0, 0, 'Don\'t know', 'f1f1f1'),
(4, 1, 0, 'Yes', '#abfad4'),
(5, 1, 1, 'No', '#fdc4d2'),
(6, 1, 3, 'N/A', 'f1f1f1'),
(7, 7, 1, 'Yes', '#abfad4'),
(10, 2, 5, 'No', '#fdc4d2'),
(9, 2, 1, 'Yes', '#abfad4');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL DEFAULT '0',
  `question` text NOT NULL,
  `supplemental_info` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `supplemental_info`, `type`, `ordering`) VALUES
(0, 'Is the raw data available?', 'Is all the raw data discussed in this paper available either in public repositories or in the supplemental material?', 'binary', 0),
(1, 'Is the code available?', 'This does not include \'available on request\'.', 'binary', 1),
(2, 'Were you able to easily reproduce the key analyses of the paper?', 'E.g. an R markdown file or Docker container.', 'binary', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `doi` varchar(200) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `hashed_orcid` varchar(50) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doi` (`doi`);

--
-- Indexes for table `possible_answers`
--
ALTER TABLE `possible_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueness` (`user`,`doi`,`question`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `possible_answers`
--
ALTER TABLE `possible_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
