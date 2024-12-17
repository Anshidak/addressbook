-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 05:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `addressbook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`) VALUES
(28, 'midhun', 'midhun@gmail.com', '$2y$10$6nyNVDIVycUDBbRqMZNOq.zJ/ocLlMz8uHaLYF5eHRa'),
(29, 'anshid', 'anshid@gmail.com', '$2y$10$LkpDm3zBfOF.D3U2n64tV.mSFasbYI9pKQHfnfJRWzf'),
(30, 'jasmin', 'jasmin@gmail.com', '$2y$10$rCyhy8e89OuSocNCfXmuP.lMczjr1PG8RZm0eX78fwj'),
(31, 'jaseem', 'jaseem@gmail.com', '$2y$10$P49YKqwJuH1mbOBDm/7VYeUFkOFDCtgRDMuomdFZkHN'),
(32, 'bibin', 'bibin@gmail.com', '1234567890'),
(33, 'kiran', 'kiran@gmail.com', 'kirankiran'),
(34, 'nira', 'nira@gmail.com', 'nira12345'),
(35, 'nila', 'nila@gmail.com', '$2y$10$rZy5zoGQYp2z15BeClrXueEkNgaEZuu71KcvUmBAQlW'),
(36, 'nithya', 'nithya@gmail.com', '$2y$10$spH20eDOExKrTE/jdQAQMe27cN2kBg3tR6scQ/ef3Ts'),
(37, 'praveena', 'praveena@gmail.com', '$2y$10$PrbxTHBioykKA8Uvoyzk8uIWCKOyUxtfOqsJUfVukJW'),
(38, 'lokesh', 'lokesh@gmail.com', '$2y$10$T4ZNCe24nD8HnhxvYlG3Z.rgpfSO5pbAD/Xb40jHpT0'),
(39, 'nirmal', 'nirmal@gmail.com', '$2y$10$fLYe5TjT9EF1mQP.ram5XegBy4U.yvqXUpYzMWg6cXN');

-- --------------------------------------------------------

--
-- Table structure for table `_contact_`
--

CREATE TABLE `_contact_` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `_contact_`
--

INSERT INTO `_contact_` (`id`, `name`, `email`, `phone`, `address`, `group_id`, `user_id`) VALUES
(9, 'new ', 'mail@mail.com', '4594652256', 'lncjbajcnjk', 13, 34),
(11, 'jijin', 'jijin@gmail.com', '4948965568', 'palakkad', 13, 34);

-- --------------------------------------------------------

--
-- Table structure for table `_group_`
--

CREATE TABLE `_group_` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `_group_`
--

INSERT INTO `_group_` (`id`, `name`, `user_id`) VALUES
(1, 'Batch mates', 34),
(2, 'bad boys', 34),
(13, 'winners', 34),
(14, 'gym mates', 34),
(15, 'Batch mates', 34),
(16, 'test', 34),
(17, 'avengers', 34);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_contact_`
--
ALTER TABLE `_contact_`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_group_`
--
ALTER TABLE `_group_`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `_contact_`
--
ALTER TABLE `_contact_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `_group_`
--
ALTER TABLE `_group_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
