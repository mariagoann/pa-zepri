-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.33-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for pa_db
CREATE DATABASE IF NOT EXISTS `pa_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pa_db`;

-- Dumping structure for table pa_db.notif
CREATE TABLE IF NOT EXISTS `notif` (
  `NotifID` int(11) NOT NULL AUTO_INCREMENT,
  `Message` varchar(150) DEFAULT NULL,
  `Read` int(1) NOT NULL DEFAULT '0',
  `To` int(1) DEFAULT NULL,
  `TypeTo` int(1) DEFAULT '0',
  `Created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`NotifID`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
