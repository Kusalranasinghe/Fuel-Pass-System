-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 01:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuelpass_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fuel_quota`
--

CREATE TABLE `fuel_quota` (
  `id` int(11) NOT NULL,
  `v_type` varchar(20) NOT NULL,
  `max_litters` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fuel_quota`
--

INSERT INTO `fuel_quota` (`id`, `v_type`, `max_litters`) VALUES
(1, 'Car', 20),
(2, 'Van', 20);

-- --------------------------------------------------------

--
-- Table structure for table `fuel_transactions`
--

CREATE TABLE `fuel_transactions` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `fuel_taken` int(11) NOT NULL,
  `trans_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fuel_transactions`
--

INSERT INTO `fuel_transactions` (`id`, `vehicle_id`, `fuel_taken`, `trans_date`) VALUES
(1, 3, 5, '2026-03-23 17:23:47'),
(2, 3, 12, '2026-03-23 17:23:58'),
(3, 4, 5, '2026-03-23 17:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `nic`, `telephone`, `address`, `reg_date`) VALUES
(3, 'Kusal', 'Ranasinghe', '200334810753', '0778767787', '\"Kusum Sewana\" Kajuduwawatta , Dodangoda', '2026-03-23 16:06:20'),
(4, 'nisal', 'chaturanga', '200305411535', '0987654321', 'matara', '2026-03-23 16:25:21'),
(5, 'maleesha', 'dilshan', '200412345678', '0345434543', 'colombo', '2026-03-23 16:33:08'),
(6, 'dasun', 'shanaka', '200310000000', '098765432', 'galle', '2026-03-23 17:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `v_type` varchar(20) NOT NULL,
  `v_number` int(11) NOT NULL,
  `c_number` int(11) NOT NULL,
  `fuel_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `u_id`, `v_type`, `v_number`, `c_number`, `fuel_type`) VALUES
(1, 3, '0', 123, 123, '0'),
(2, 4, '0', 12345, 12345, '0'),
(3, 5, 'van', 111, 111, 'disal'),
(4, 6, 'Van', 132, 132, 'petrol');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fuel_quota`
--
ALTER TABLE `fuel_quota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_transactions`
--
ALTER TABLE `fuel_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nic` (`nic`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `v_num` (`v_number`),
  ADD UNIQUE KEY `c_num` (`c_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fuel_quota`
--
ALTER TABLE `fuel_quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fuel_transactions`
--
ALTER TABLE `fuel_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fuel_transactions`
--
ALTER TABLE `fuel_transactions`
  ADD CONSTRAINT `fuel_transactions_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
