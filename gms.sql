-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for gms
CREATE DATABASE IF NOT EXISTS `gms` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `gms`;

-- Dumping structure for table gms.doctors
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `specialty` varchar(50) NOT NULL,
  `month` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table gms.hms_slots
CREATE TABLE IF NOT EXISTS `hms_slots` (
  `id` int(11) NOT NULL,
  `slots` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table gms.specialties
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `specialty` varchar(50) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table gms.tblinquiry
CREATE TABLE IF NOT EXISTS `tblinquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `rescheduled_id` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `rescheduled_id` (`rescheduled_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2029 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table gms.tblinquiry_logs
CREATE TABLE IF NOT EXISTS `tblinquiry_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_id` int(11) NOT NULL,
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

-- Dumping structure for table gms.users
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `userpass` varchar(100) NOT NULL,
  `dateadded` datetime NOT NULL,
  `userprivilege` int(11) NOT NULL,
  `addedby` int(11) NOT NULL,
  `userstatus` tinyint(4) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `nameinit` varchar(10) NOT NULL,
  `deptid` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=100018 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
