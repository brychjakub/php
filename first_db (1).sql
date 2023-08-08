-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 03:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `first_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time NOT NULL,
  `bookingPeriod` int(11) NOT NULL,
  `eventOpen` tinyint(1) NOT NULL,
  `openPositions` int(11) DEFAULT 0,
  `startDate` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `eventName`, `startTime`, `endTime`, `bookingPeriod`, `eventOpen`, `openPositions`, `startDate`) VALUES
(88, 'zápis', '16:22:00', '19:00:00', 20, 0, 7, '2023-07-15'),
(89, 'zápis 2', '16:22:00', '18:00:00', 20, 1, 4, '2023-07-01'),
(90, 'zápis234', '16:22:00', '19:00:00', 20, 1, 7, '2023-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

CREATE TABLE `pupils` (
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `childBirthDay` varchar(30) NOT NULL,
  `childHomeAddressStreet` varchar(100) NOT NULL,
  `childHomeAddressNumber` varchar(30) NOT NULL,
  `childHomeAddressCity` varchar(50) NOT NULL,
  `childHomeAddressPostcode` varchar(30) NOT NULL,
  `legalRepresentativeFirstname` varchar(30) NOT NULL,
  `legalRepresentativeSurname` varchar(30) NOT NULL,
  `legalRepresentativeEmail` varchar(50) NOT NULL,
  `legalRepresentativePhone` varchar(30) NOT NULL,
  `legalRepresentativeHomeAddressStreet` varchar(100) NOT NULL,
  `legalRepresentativeHomeAddressNumber` varchar(30) NOT NULL,
  `legalRepresentativeHomeAddressCity` varchar(50) NOT NULL,
  `note` text DEFAULT NULL,
  `legalRepresentativeHomeAddressPostcode` varchar(30) NOT NULL,
  `id` int(11) NOT NULL,
  `eventDate` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`firstname`, `lastname`, `childBirthDay`, `childHomeAddressStreet`, `childHomeAddressNumber`, `childHomeAddressCity`, `childHomeAddressPostcode`, `legalRepresentativeFirstname`, `legalRepresentativeSurname`, `legalRepresentativeEmail`, `legalRepresentativePhone`, `legalRepresentativeHomeAddressStreet`, `legalRepresentativeHomeAddressNumber`, `legalRepresentativeHomeAddressCity`, `note`, `legalRepresentativeHomeAddressPostcode`, `id`, `eventDate`) VALUES
('Jakub', 'Brych', '19.16.2320', 'Šmídkova 5a', '5', 'Brno', '61600', 'Jakub', 'Brych', 'brychjakub@gmail.com', '732221145', 'Šmídkova 5a', '5', 'Brno', '17:42', '61600', 164, '02.07.2023');

--
-- Triggers `pupils`
--
DELIMITER $$
CREATE TRIGGER `sync_time_after_update` AFTER UPDATE ON `pupils` FOR EACH ROW BEGIN
    IF NEW.note <> OLD.note THEN
        UPDATE reservations
        SET time = NEW.note
        WHERE pupilID = NEW.ID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `reservationNumber` varchar(30) NOT NULL,
  `pupilID` varchar(50) NOT NULL,
  `eventID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `time`, `reservationNumber`, `pupilID`, `eventID`) VALUES
(121, '17:42', '1', '162', '88'),
(122, '18:02', '1', '163', '89'),
(123, '17:42', '1', '164', '90'),
(124, '17:02', '1', '165', '89'),
(125, '17:42', '2', '166', '88'),
(126, '17:02', '3', '167', '89'),
(127, '16:22', '1', '168', '88'),
(128, '17:22', '1', '169', '90'),
(129, '17:22', '2', '170', '90'),
(130, '17:22', '1', '171', '88');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'kuba', '$2y$10$t4TlqTrnU2xeHo75boSvzOLcVU7L14G1xd/wpFqZlOa94RyaLbEb6'),
(2, 'admin', '$2y$10$gME/SVvQG4R5LKB5y3kJJuVfk19k6eX0WB5M9TzGL7GkR/8BwikHe'),
(4, 'Doe', '$2y$10$jTM.JC.FPEwT9QY5FgBJFuK..PM4n1TOlegjbcSyiKFssEko9nqrq'),
(5, 'brych@cmczs.cz', '$2y$10$IOCqrfpHXT8por0fTLVOP.EcjWEhoG8BdsvNlY5VFnLhVoTl1NMp2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pupils`
--
ALTER TABLE `pupils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `pupils`
--
ALTER TABLE `pupils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
