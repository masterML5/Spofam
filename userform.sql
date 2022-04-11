-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2022 at 02:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userform`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(1, 993193, 0, 'a'),
(2, 418572, 0, ']'),
(3, 418572, 993193, 'dsfdfs'),
(4, 418572, 993193, 'asdasda'),
(5, 418572, 993193, 'h'),
(6, 418572, 993193, 'asdasdasd'),
(7, 993193, 418572, 'fgg'),
(8, 993193, 418572, 'hjghjhj'),
(9, 163327, 993193, 'p');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `text`) VALUES
(1, 'test posts'),
(2, 'test 2 test 2');

-- --------------------------------------------------------

--
-- Table structure for table `rating_info`
--

CREATE TABLE `rating_info` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating_action` varchar(20) NOT NULL,
  `comment_action` varchar(10) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating_info`
--

INSERT INTO `rating_info` (`post_id`, `user_id`, `rating_action`, `comment_action`, `comment`) VALUES
(1, 1, 'like', 'yes', 'asd'),
(1, 2, 'like', '', ''),
(1, 3, 'like', 'yes', 'break test'),
(1, 4, 'like', '', ''),
(1, 5, 'like', 'yes', 'testeteteaedawdawdwadawdawdawawawdaw'),
(2, 4, 'like', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `code` int(255) NOT NULL,
  `status_chat` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL,
  `unique_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `username`, `email`, `name`, `surname`, `password`, `status`, `code`, `status_chat`, `img`, `unique_id`) VALUES
(1, 'miki', 'miki@x.com', 'm', 'm', '$2y$10$ngAyLioFoAIGk0KVWl1fJeDcRt.cIAHq4iVpEaWnSBUpodV/5FyGe', 'verified', 0, 'Offline now', 'x.jpg', 418572),
(2, 'm', 'm@m.com', 'a', 'a', '$2y$10$KtzsTAKPQmNr4B4jFdxVCu5gLsuyycGZadRA8EqMpRD2qh6gw/Yqu', 'verified', 0, 'Active now', 'a.jpg', 993193),
(3, 'test', 'test@t.com', 'test', 'test', '$2y$10$Sdl8b6IYIm4z5wGI2L6Jg.x97cRT/DyiCM5D0f1H46s/Ou6eJtBxe', 'verified', 0, 'Offline now', '2.png', 425503),
(4, 'test2', 'test2@t.com', 'test2', 'test2', '$2y$10$Yym4AjbqyU8rI7LR2SRwxu8F6knuCepLZBOyvgQ5IsnrfsnSkzrt2', 'verified', 0, 'Offline now', '1.png', 433914),
(5, 'test3', 'test3@t.com', 'test3', 'test3', '$2y$10$1HFyOdnWxyjgvKJYgZRgSeT10GBKnNLMVkeXNuPjddoir8Xylpy06', 'verified', 0, 'Offline now', 'profile.png', 163327);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
