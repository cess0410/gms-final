-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 12:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gms`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `specialty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`) VALUES
(4, 'happy', '2'),
(15, 'gfdg', '3'),
(20, 'add', '4');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(11) NOT NULL,
  `doctor` varchar(50) NOT NULL,
  `specialty` varchar(50) NOT NULL,
  `start_datetime` varchar(50) NOT NULL,
  `end_datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `doctor`, `specialty`, `start_datetime`, `end_datetime`) VALUES
(50, '4', 'Family Medicine', '2024-07-10T08:00', '2024-07-10T17:00'),
(51, '20', 'OB GYNE', '2024-07-25T05:58', '2024-07-25T17:58'),
(52, '4', 'Family Medicine', '2024-07-10T08:00', '2024-07-10T17:25'),
(53, '4', 'Family Medicine', '2024-07-10T08:00', '2024-07-10T17:30');

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(11) NOT NULL,
  `specialty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `specialty`) VALUES
(1, 'Internal Medicine'),
(2, 'Family Medicine'),
(3, 'General Surgey'),
(4, 'OB GYNE');

-- --------------------------------------------------------

--
-- Table structure for table `tblinquiry`
--

CREATE TABLE `tblinquiry` (
  `id` int(11) NOT NULL,
  `consultdate` varchar(50) NOT NULL,
  `consultmonth` varchar(50) NOT NULL,
  `consultyear` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `endorsement` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL DEFAULT '',
  `contact_no` varchar(50) NOT NULL,
  `specialty` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `start_datetime` varchar(50) NOT NULL,
  `doctor` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `rescheduled` varchar(50) NOT NULL,
  `diagnose` varchar(50) NOT NULL,
  `end_datetime` varchar(50) NOT NULL,
  `end_month` varchar(50) NOT NULL,
  `end_year` varchar(50) NOT NULL,
  `rescheduled_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblinquiry`
--

INSERT INTO `tblinquiry` (`id`, `consultdate`, `consultmonth`, `consultyear`, `receiver`, `mode`, `endorsement`, `name`, `type`, `birthdate`, `age`, `gender`, `contact_no`, `specialty`, `remarks`, `start_datetime`, `doctor`, `status`, `rescheduled`, `diagnose`, `end_datetime`, `end_month`, `end_year`, `rescheduled_id`) VALUES
(2028, 'June 28, 2024 9:22 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy', 'New', '1998-06-27', 26, 'Female', '0910-899-8321', '4', 'abc', '2024-07-01', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblinquiry_logs`
--

CREATE TABLE `tblinquiry_logs` (
  `id` int(11) NOT NULL,
  `consultdate` varchar(50) NOT NULL,
  `consultmonth` varchar(50) NOT NULL,
  `consultyear` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `endorsement` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL DEFAULT '',
  `contact_no` varchar(50) NOT NULL,
  `specialty` varchar(50) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  `start_datetime` varchar(50) NOT NULL,
  `end_datetime` varchar(50) NOT NULL,
  `doctor` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `rescheduled` varchar(50) NOT NULL,
  `diagnose` varchar(50) NOT NULL,
  `inquiry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tblinquiry_logs`
--

INSERT INTO `tblinquiry_logs` (`id`, `consultdate`, `consultmonth`, `consultyear`, `receiver`, `mode`, `endorsement`, `name`, `type`, `birthdate`, `age`, `gender`, `contact_no`, `specialty`, `remarks`, `start_datetime`, `end_datetime`, `doctor`, `status`, `rescheduled`, `diagnose`, `inquiry_id`, `user_id`) VALUES
(184, 'June 25, 2024 2:31 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-20', 26, 'Female', '0910-899-8321', '2', 'abc', '2024-06-26T14:32', '', '', '', '', '', 84, 100004),
(185, 'June 25, 2024 2:34 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-26', 25, 'Female', '0910-899-8321', '2', 'abc', '2024-06-27T14:34', '', '', '', '', '', 85, 100004),
(186, 'June 26, 2024 4:57 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Candy', 'New', '1998-06-20', 26, 'Female', '0910-899-8321', '4', 'abc', '2024-06-28T16:58', '', '', '', '', '', 90, 100004),
(187, 'June 27, 2024 5:31 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Candy', 'New', '1997-06-19', 27, 'Female', '0910-899-8321', '4', '', '2024-06-28T17:34', '', '', '', '', '', 91, 100004),
(188, 'June 28, 2024 3:49 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-26', 25, 'Female', '0910-899-8321', '4', 'abcd', '2024-06-27T14:34', '', '', '', '', '', 0, 0),
(189, 'June 28, 2024 4:15 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Clarence Baluyot', 'New', '1950-06-26', 74, 'Male', '09', '1', '', '', '', '', '', '', '', 92, 100004),
(190, 'June 28, 2024 8:24 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-26', 25, 'Female', '0910-899-8321', '4', 'abcd', '2024-06-28T20:24', '', '', '', '', '', 0, 0),
(191, 'June 28, 2024 8:26 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-26', 25, 'Female', '0910-899-8321', '4', 'abcd', '2024-07-01T20:26', '', '', '', '', '', 0, 0),
(192, 'June 28, 2024 8:50 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy Go', 'Old', '1998-06-26', 25, 'Female', '0910-899-8321', '4', 'abcd', '2024-07-01T20:50', '', '', '', '', '', 0, 0),
(193, 'June 28, 2024 8:53 PM', '06', '2024', '100004', 'F2F', '', 'Gfdg', 'New', '1998-06-26', 26, 'Female', '09', '1', '', '2024-07-02T20:53', '', '', '', '', '', 2025, 100004),
(194, 'June 28, 2024 8:58 PM', '06', '2024', '100004', 'F2F', '', 'Ghfghfgh', 'New', '1998-07-02', 25, 'Female', '09', '4', '', '2024-07-07T20:58', '', '', '', '', '', 2026, 100004),
(195, 'June 28, 2024 9:15 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy', 'New', '1998-07-01', 25, 'Female', '0910-899-8321', '2', 'abc', '2024-07-01T21:15', '', '', '', '', '', 2027, 100004),
(196, 'June 28, 2024 9:18 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy', 'New', '1998-07-01', 25, 'Female', '0910-899-8321', '2', 'abc', '2024-06-29T21:18', '', '', '', '', '', 0, 0),
(197, 'June 28, 2024 9:20 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy', 'New', '1998-07-01', 25, 'Female', '0910-899-8321', '2', 'abc', '2024-07-01T21:20', '', '', '', '', '', 0, 0),
(198, 'June 28, 2024 9:22 PM', '06', '2024', '100004', 'F2F', 'MARIVELES', 'Happy', 'New', '1998-06-27', 26, 'Female', '0910-899-8321', '4', 'abc', '2024-07-01T21:22', '', '', '', '', '', 2028, 100004);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userpass` varchar(100) NOT NULL,
  `dateadded` datetime NOT NULL,
  `userprivilege` int(11) NOT NULL,
  `addedby` int(11) NOT NULL,
  `userstatus` tinyint(4) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `nameinit` varchar(10) NOT NULL,
  `deptid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `userpass`, `dateadded`, `userprivilege`, `addedby`, `userstatus`, `fname`, `lname`, `nameinit`, `deptid`) VALUES
(1, 'admin', '$2y$10$tDXgeRaCLrY/FELzUoBCvejW/l1q/BtIvLGYPrcfQ8KQ2.I8LfQIa', '2023-05-12 10:12:57', 0, 0, 0, 'Administrator', 'IHOMS', '', 1),
(2, 'onlinesched', '$2y$10$ZbpfvoDd81rtFXNJaQOtuOhy4saKDzl4/DokietTGM6DBBQg.du/W', '2023-12-27 15:18:29', 1, 1, 0, 'Online', 'Scheduler', 'oe', 1),
(6, 'carlo', '$2y$10$NOytGofiCFnXeeMK6oERyecAEkpOY7NehAWKTkWAKxtZRf0jIKgSi', '2023-06-09 14:45:49', 3, 1, 1, 'John Carlo', 'Valdez', 'JV', 1),
(7, 'laurence', '$2y$10$OLawhaUX2fX3xKU0wQ12uuOZLVdqTIhmthN3RgJLnjCopslmwaGfS', '2023-06-09 14:46:15', 2, 1, 0, 'John Laurence', 'Bautista', 'JB', 1),
(8, 'eric', '$2y$10$VsTkvEfEgMe7wjtOzoy.suXS813hq3MWueldvX/vSFSMkayqPVnc2', '2023-06-09 14:46:41', 3, 1, 0, 'John Eric', 'Madrid', 'JM', 1),
(9, 'eduard', '$2y$10$TnKIRZorfiFaA5.36C3FROaEtpENWxovlwlGttbGzCa6THo3M6Xjy', '2023-06-09 14:47:32', 2, 1, 0, 'Eduardland', 'Gatip', 'EG', 1),
(10, 'efraim', '$2y$10$JA01wlfe4VxpRI7TvXpj2..FypbXVm663jz4POEhKmAaw9N4SVQBm', '2023-06-09 14:47:52', 2, 1, 0, 'Efraim', 'Dabu', 'ED', 1),
(11, 'kent', '$2y$10$OAJlqG08pBaGnBNj8IByIehffcp5UhOjXFAFqnfrD7HeafczOKyly', '2023-06-09 14:48:22', 2, 1, 0, 'Kent', 'Punzalan', 'KP', 1),
(12, 'charlis', '$2y$10$FdWnK8dtoyCmrlzfNK0EOuLBW1NhxQ4F83iiMHDlzQWjy5SlOsnMW', '2023-06-09 14:48:40', 2, 1, 0, 'Charlis Jan', 'Jaring', 'CJ', 1),
(13, 'ryan', '$2y$10$pStn1TZCDW3syxCMFtp2FeUjNnK8ApG0GPSPK/tFZ.TGcNtmHC2lC', '2023-06-09 14:48:58', 2, 1, 0, 'Ryan', 'Castro', 'RC', 1),
(14, 'clarence', '$2y$10$KYSYkLjcQo3/80KMFPHBKOQdhuliGQMmhwp0LHJa5kRPSAWdznQii', '2023-06-09 14:49:46', 2, 1, 0, 'Clarence', 'Baluyot', 'CB', 1),
(15, 'emman', '$2y$10$.IXHDI7PVYeCJWwHAYt96uR7IMXDX5kYOKIkE9GeR/OOJRyxJ5ayG', '2023-06-09 14:50:02', 2, 1, 0, 'Emmanuel', 'Isidro', 'EI', 1),
(16, 'allan', '$2y$10$QY42Clh7qnqijIwvgdyZB.Bo2p1cwltj8LwQoTh3HLldQV/vTcGv.', '2023-07-05 10:52:08', 0, 1, 0, 'Rolando', 'Cordova', 'AC', 1),
(17, 'shiela', '$2y$10$8h9zzDL.QIhNpANNnm3fweMiKdtKPOe05/72RFQ3VFu.eF6bvcyUG', '2023-07-05 10:52:55', 1, 1, 0, 'Shiela Rose', 'Aringo', 'SA', 1),
(18, 'edniel', '$2y$10$HnXRWrvvHsg/FwHTqZNAqOk9raNOY73ZrD1NdBVeEKUKJpx7ex2T6', '2023-07-17 16:21:29', 1, 1, 0, 'Edniel', 'Espejo', '', 27),
(19, 'jr', '$2y$10$tx/LhsOH5DbmK9FrmMqgE.dRX9JGQVvM0pBVj7jWVUTjhWAZuNccO', '2023-10-10 10:11:29', 2, 1, 0, 'Jan Rommel', 'Buenaventura', 'RB', 1),
(20, 'ladymardo', '$2y$10$fapXOmtDVKAR1RkrqdFXQOnol2qnMaEu3ZKthnp/HPMzcP8.qLLV.', '2023-11-10 15:05:17', 1, 1, 0, 'Lady Ann', 'Mardo', 'LM', 62),
(21, 'sachi', '$2y$10$E038qHCMJHBqlqNI6/ssi.793pW2cvw3rczgambew7EKunrxfoRZW', '2023-12-13 09:48:44', 2, 15, 0, 'Marielle Sachi', 'Saygan', 'SS', 1),
(100001, 'robin', '$2y$10$xd42oXFcGWb5wuXZIucvq.RksgPJc5Hkt7wZlR/nCE4U.00zb.IBy', '2024-02-02 10:41:48', 2, 1, 0, 'Robinson', 'Esguerra', 'RE', 1),
(100002, 'ianlucas', '$2y$10$L.qBiT3tHPVUrnWbTJ61pOZnL2kUGtO0EmzB/p/ncsFol9y4.Imh2', '2024-03-08 10:34:18', 2, 1, 0, 'Michael Ian', 'Lucas', 'ML', 1),
(100003, 'neil', '$2y$10$iMp3OfSqvD6LqwptYZr1u.l2k8GjOuSlE7KILnmoRwbJsQU1htKtu', '2024-03-15 10:36:41', 0, 1, 0, 'Neil Anthony', 'Busa', 'NB', 1),
(100004, 'cess', '$2y$10$4RVYKefuwGfW/uj29pOqdejbxvXnKawXy/lSG.LNZFI9I/FnhR532', '2024-04-12 09:06:06', 2, 1, 0, 'Princess', 'Concepcion', 'PC', 1),
(100005, 'keano', '$2y$10$D86mdhvgKm.EFm97jBcV1OMW0sIyN0.Y7/Tc7MgWUq5Cvr7EsYdDq', '2024-04-12 10:57:48', 2, 1, 0, 'Keano', 'Peñaloza', 'kd', 1),
(100006, 'aly', '$2y$10$gp1WK3keIzqQGucP44xeEe5/W9QceckFi70cpFo8r./hcIxIQH5Ne', '2024-05-03 08:16:58', 1, 1, 0, 'Alyssa', 'De Leon', 'al', 62),
(100007, 'diana', '$2y$10$s9KrhvJ9lq1A3EOvmdfFzOC17ee/e.yeNCQ0ESRAnPJht.K87/sVG', '2024-05-03 08:17:39', 1, 1, 0, 'Diana Eloisa', 'Luna', 'dl', 62),
(100008, 'ham', '$2y$10$hnZi3f04khJCSvOYoDdKaOaZJH6lvylfGesm3jaU49z4HWponeuVy', '2024-05-03 08:18:17', 1, 1, 0, 'Ham Joseph', 'Luna', 'hl', 62),
(100009, 'annie', '$2y$10$AFDd6TCDVBE3Me5.O2zPFe1.15PsR78Yx5so6RkeV1X2K/Xpr2OuS', '2024-05-03 08:18:46', 1, 1, 0, 'Annie', 'Espejo', 'ae', 62),
(100010, 'teresa', '$2y$10$k36ldXn94CgYIcPF6in8eugM6GcXLnSpS0bqrWjtyYvnCqWeczhzK', '2024-05-03 08:19:16', 1, 1, 0, 'Teresa', 'Cruz', 'tc', 62),
(100011, 'ariel', '$2y$10$97Gt5Ui521QhcKztvjZP8.2NzpCXiW1ca3nTeXCmVyIPROl4x3Wti', '2024-05-03 08:20:05', 1, 1, 0, 'Ariel', 'Reyes', 'ar', 62),
(100012, 'kinney', '$2y$10$xnZoZUesqNmR5ehCefyE3eYS9KEuGDSgHERqnt8409e5VAmOckhfG', '2024-05-03 08:20:41', 1, 1, 0, 'Maria Corazon', 'Valmeo', 'mv', 62),
(100013, 'jayann', '$2y$10$tZGFQ7K0ajORmf2deYe3MedykKln3J3sP4V6wISwLxG.SGwpUTlu6', '2024-05-03 08:21:04', 1, 1, 0, 'Jay Ann', 'Sanchez', 'js', 62),
(100014, 'james', '$2y$10$fjGf1UNHmbM0Yzw80LzfU.l3YUtpFreoOUwp8UC5gkJga4/AN/Tua', '2024-05-03 08:21:31', 1, 1, 0, 'James Frederic', 'Raymundo', 'jr', 62),
(100015, 'alvin', '$2y$10$8RVbAqjmw3AbJ3s1o9repeaymMyyY9jQDUcJNSMIfAZVdrlCBXRvS', '2024-05-03 08:21:47', 1, 1, 0, 'Alvin', 'Quindo', 'aq', 62),
(100016, 'sarah', '$2y$10$bU9FsYPa57u3uTHm36E6j.YRrIQZBTv5MUWvNYPHIbDRG9oHeNLjC', '2024-05-03 08:22:19', 1, 1, 0, 'Sarah', 'Arenas', 'sa', 62),
(100017, 'nina', '$2y$10$dRx.SyBLvYwf5ZEOesZyJuDjibyelWd8HkodjHuN6aIOaBmoa.BaC', '2024-05-03 13:18:32', 1, 1, 0, 'Niña Patricia', 'Navarro', 'nn', 62);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD KEY `id` (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD KEY `id` (`id`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD KEY `id` (`id`);

--
-- Indexes for table `tblinquiry`
--
ALTER TABLE `tblinquiry`
  ADD KEY `id` (`id`),
  ADD KEY `rescheduled_id` (`rescheduled_id`);

--
-- Indexes for table `tblinquiry_logs`
--
ALTER TABLE `tblinquiry_logs`
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `specialties`
--
ALTER TABLE `specialties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblinquiry`
--
ALTER TABLE `tblinquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2029;

--
-- AUTO_INCREMENT for table `tblinquiry_logs`
--
ALTER TABLE `tblinquiry_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100018;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
