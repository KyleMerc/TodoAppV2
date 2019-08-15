-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 15, 2019 at 03:56 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tododb`
--

-- --------------------------------------------------------

--
-- Table structure for table `subtodos`
--

CREATE TABLE `subtodos` (
  `sub_todo_id` int(11) NOT NULL,
  `todo_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` enum('IN PROGRESS','DONE') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `todo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `status` enum('IN PROGRESS','DONE') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`todo_id`, `user_id`, `title`, `content`, `status`, `date_created`, `date_updated`) VALUES
(71, 19, 'strip tags 2', 'Test paragraph. Other text\r\n', 'IN PROGRESS', '2019-08-13 05:27:24', '2019-08-13 05:27:24'),
(72, 16, 'Surfing the webasfas', 'dafdfsff', 'IN PROGRESS', '2019-08-14 08:18:12', '2019-08-15 06:02:17'),
(73, 16, 'lorem  ipsum v2', 'adasdasd', 'IN PROGRESS', '2019-08-15 06:02:23', '2019-08-15 06:02:23'),
(74, 19, 'asdas', 'asdas', 'IN PROGRESS', '2019-08-15 07:07:54', '2019-08-15 07:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `vkey` varchar(100) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `user_role_id`, `vkey`, `verified`, `date_created`, `date_updated`) VALUES
(9, 'admin', '$2y$10$edJN3XB4yyU.yWT7cXOPyeTKQoTc4YO.UvKyp45Nmldm3VajHbu02', '', '', '', 1, '', 1, '2019-08-01 07:16:05', '2019-08-01 07:16:05'),
(16, 'mikasa', '$2y$10$rFjl7xWfSeXP86/mPX6/DerbzyqtRoQyR0u5pNzNnrqcwyHDxc1Q6', 'Armin', 'Ackermann', 'killtitans@aot.com', 2, 'asdfdsf4153253kljrsdfsdf3453asdf', 1, '2019-08-08 09:19:22', '2019-08-15 05:17:12'),
(19, 'n121', '$2y$10$n.WRKhSHLAegTNk8.Zi/0uscSVi178vrOeTZdTv/BBUgCximDhGYq', 'Fullspeed', 'Technologies', 'fst@fullspeedtech.com', 2, 'fasdfmdspgkdfaohp[th234.[g;dg,sagdsfadh', 0, '2019-08-09 10:43:26', '2019-08-09 10:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_role_id` int(11) NOT NULL,
  `user_role` varchar(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_role_id`, `user_role`, `date_created`, `date_updated`) VALUES
(1, 'ADMIN', '2019-07-30 09:49:30', '2019-07-30 09:49:30'),
(2, 'USER', '2019-07-30 09:49:49', '2019-07-30 09:49:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subtodos`
--
ALTER TABLE `subtodos`
  ADD PRIMARY KEY (`sub_todo_id`),
  ADD UNIQUE KEY `todo_id` (`todo_id`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`todo_id`),
  ADD KEY `todos_ibfk_1` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role_id` (`user_role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subtodos`
--
ALTER TABLE `subtodos`
  MODIFY `sub_todo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtodos`
--
ALTER TABLE `subtodos`
  ADD CONSTRAINT `fk_todo_id` FOREIGN KEY (`todo_id`) REFERENCES `todos` (`todo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`user_role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
