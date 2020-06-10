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

-- Dumping structure for table pa_db.employeestatus
CREATE TABLE IF NOT EXISTS `employeestatus` (
  `EmployeeStatusID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`EmployeeStatusID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.employeestatus: ~2 rows (approximately)
/*!40000 ALTER TABLE `employeestatus` DISABLE KEYS */;
INSERT INTO `employeestatus` (`EmployeeStatusID`, `Name`) VALUES
	(1, 'Kontrak'),
	(2, 'Tetap');
/*!40000 ALTER TABLE `employeestatus` ENABLE KEYS */;

-- Dumping structure for table pa_db.employment
CREATE TABLE IF NOT EXISTS `employment` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonalID` int(11) NOT NULL,
  `JoinDate` date NOT NULL,
  `EmployeeStatus` int(11) NOT NULL,
  `OrganizationID` int(11) NOT NULL,
  `JobPositionID` int(11) NOT NULL,
  `AKA_JobPosition` varchar(150) DEFAULT NULL,
  `JobTitleID` int(11) DEFAULT NULL,
  `LevelID` int(11) DEFAULT NULL,
  `EmployeeSuperiorID` int(11) DEFAULT NULL,
  `SquadID` int(11) DEFAULT NULL,
  `EmployeeNumber` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`),
  KEY `FK1_PERSONAL` (`PersonalID`),
  KEY `FK2_superior` (`EmployeeSuperiorID`),
  KEY `FK3_employeestatus` (`EmployeeStatus`),
  KEY `FK4_organizaiton` (`OrganizationID`),
  KEY `FK5_jobposition` (`JobPositionID`),
  KEY `FK6_jobtitle` (`JobTitleID`),
  KEY `FK7_level` (`LevelID`),
  KEY `FK8_squad` (`SquadID`),
  CONSTRAINT `FK1_PERSONAL` FOREIGN KEY (`PersonalID`) REFERENCES `personalinfo` (`PersonalID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_superior` FOREIGN KEY (`EmployeeSuperiorID`) REFERENCES `employment` (`EmployeeID`),
  CONSTRAINT `FK3_employeestatus` FOREIGN KEY (`EmployeeStatus`) REFERENCES `employeestatus` (`EmployeeStatusID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK4_organizaiton` FOREIGN KEY (`OrganizationID`) REFERENCES `organization` (`OrganizationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK5_jobposition` FOREIGN KEY (`JobPositionID`) REFERENCES `jobposition` (`JobPositionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK6_jobtitle` FOREIGN KEY (`JobTitleID`) REFERENCES `jobtitle` (`JobTitleID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK7_level` FOREIGN KEY (`LevelID`) REFERENCES `joblevel` (`LevelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK8_squad` FOREIGN KEY (`SquadID`) REFERENCES `squad` (`SquadID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.employment: ~7 rows (approximately)
/*!40000 ALTER TABLE `employment` DISABLE KEYS */;
INSERT INTO `employment` (`EmployeeID`, `PersonalID`, `JoinDate`, `EmployeeStatus`, `OrganizationID`, `JobPositionID`, `AKA_JobPosition`, `JobTitleID`, `LevelID`, `EmployeeSuperiorID`, `SquadID`, `EmployeeNumber`) VALUES
	(1, 20, '2020-06-03', 2, 1, 3, 'dasdads', 2, 3, NULL, 2, '12345690-'),
	(2, 21, '2020-06-03', 2, 1, 3, 'dasdasda', 2, 4, 1, 3, '1234567890'),
	(3, 22, '2020-06-03', 1, 1, 3, 'dasdads', 2, 3, 1, 2, '11111111'),
	(4, 23, '2020-06-03', 1, 1, 3, 'dasdad', 2, 3, 1, 3, '01010101010'),
	(6, 25, '2020-06-03', 1, 1, 4, 'dasdads', 2, 3, NULL, 2, '1293910312b'),
	(7, 26, '2020-06-03', 1, 1, 4, 'dasdads', 3, 3, NULL, NULL, '5656565656565'),
	(8, 27, '2020-06-09', 2, 1, 3, 'dasdads', 2, 3, NULL, NULL, '67676767');
/*!40000 ALTER TABLE `employment` ENABLE KEYS */;

-- Dumping structure for table pa_db.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `GenderID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) NOT NULL,
  PRIMARY KEY (`GenderID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.gender: ~2 rows (approximately)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`GenderID`, `Name`) VALUES
	(1, 'Perempuan'),
	(2, 'Laki-laki');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;

-- Dumping structure for table pa_db.identitytype
CREATE TABLE IF NOT EXISTS `identitytype` (
  `IdentityTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(225) NOT NULL,
  PRIMARY KEY (`IdentityTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.identitytype: ~2 rows (approximately)
/*!40000 ALTER TABLE `identitytype` DISABLE KEYS */;
INSERT INTO `identitytype` (`IdentityTypeID`, `Name`) VALUES
	(1, 'KTP'),
	(2, 'VISA'),
	(3, 'KK');
/*!40000 ALTER TABLE `identitytype` ENABLE KEYS */;

-- Dumping structure for table pa_db.joblevel
CREATE TABLE IF NOT EXISTS `joblevel` (
  `LevelID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeLevel` varchar(150) DEFAULT NULL,
  `LevelName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`LevelID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.joblevel: ~2 rows (approximately)
/*!40000 ALTER TABLE `joblevel` DISABLE KEYS */;
INSERT INTO `joblevel` (`LevelID`, `CodeLevel`, `LevelName`) VALUES
	(3, 'JL001', 'Test Level'),
	(4, 'JL002', 'Test Job Level');
/*!40000 ALTER TABLE `joblevel` ENABLE KEYS */;

-- Dumping structure for table pa_db.jobposition
CREATE TABLE IF NOT EXISTS `jobposition` (
  `JobPositionID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeJobPosition` varchar(150) DEFAULT NULL,
  `JobPositionName` varchar(50) NOT NULL,
  `Level` int(11) NOT NULL,
  PRIMARY KEY (`JobPositionID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.jobposition: ~6 rows (approximately)
/*!40000 ALTER TABLE `jobposition` DISABLE KEYS */;
INSERT INTO `jobposition` (`JobPositionID`, `CodeJobPosition`, `JobPositionName`, `Level`) VALUES
	(3, 'JP001', 'Test JP', 1),
	(4, 'JP002', 'Test JP2', 2),
	(5, 'JP003', 'Test JP3', 3),
	(6, 'JP004', 'Test JP4', 4),
	(7, 'JP005', 'Test JP5', 5),
	(8, 'JP006', 'Test JP6', 6);
/*!40000 ALTER TABLE `jobposition` ENABLE KEYS */;

-- Dumping structure for table pa_db.jobtitle
CREATE TABLE IF NOT EXISTS `jobtitle` (
  `JobTitleID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeJobTitle` varchar(150) DEFAULT NULL,
  `JobTitleName` varchar(50) NOT NULL,
  PRIMARY KEY (`JobTitleID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.jobtitle: ~0 rows (approximately)
/*!40000 ALTER TABLE `jobtitle` DISABLE KEYS */;
INSERT INTO `jobtitle` (`JobTitleID`, `CodeJobTitle`, `JobTitleName`) VALUES
	(2, 'JT001', 'Test Job titles'),
	(3, 'JT002', 'Test Job Title 2');
/*!40000 ALTER TABLE `jobtitle` ENABLE KEYS */;

-- Dumping structure for table pa_db.organization
CREATE TABLE IF NOT EXISTS `organization` (
  `OrganizationID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeOrganization` varchar(150) DEFAULT NULL,
  `OrganizationName` varchar(50) NOT NULL,
  PRIMARY KEY (`OrganizationID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.organization: ~0 rows (approximately)
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
INSERT INTO `organization` (`OrganizationID`, `CodeOrganization`, `OrganizationName`) VALUES
	(1, 'OR001', 'Test Organization'),
	(2, 'OR002', 'Test Organization 2');
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;

-- Dumping structure for table pa_db.pacomponent
CREATE TABLE IF NOT EXISTS `pacomponent` (
  `PAComponentID` int(11) NOT NULL AUTO_INCREMENT,
  `PerformanceAppraisalID` int(11) NOT NULL,
  `Self` float NOT NULL,
  `Peers` float NOT NULL,
  `SubordinatesToSuperior` float NOT NULL,
  `SuperiorToSubOrdinates` float NOT NULL,
  `EmployeeScore` float NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `PeriodeID` int(11) NOT NULL,
  `Total` float NOT NULL,
  `TrackRecord` varchar(150) NOT NULL,
  PRIMARY KEY (`PAComponentID`),
  KEY `FK1_performanceappraisal` (`PerformanceAppraisalID`),
  KEY `FK2_employementid` (`EmployeeID`),
  KEY `FK3_periode` (`PeriodeID`),
  CONSTRAINT `FK1_performanceappraisal` FOREIGN KEY (`PerformanceAppraisalID`) REFERENCES `performanceappraisal` (`PerformanceAppraisalID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_employementid` FOREIGN KEY (`EmployeeID`) REFERENCES `employment` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK3_periode` FOREIGN KEY (`PeriodeID`) REFERENCES `periode` (`PeriodeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.pacomponent: ~0 rows (approximately)
/*!40000 ALTER TABLE `pacomponent` DISABLE KEYS */;
/*!40000 ALTER TABLE `pacomponent` ENABLE KEYS */;

-- Dumping structure for table pa_db.paparameter
CREATE TABLE IF NOT EXISTS `paparameter` (
  `PAParameterID` int(11) NOT NULL AUTO_INCREMENT,
  `PositiveContribution` varchar(250) DEFAULT NULL,
  `SelfImprovement` varchar(250) DEFAULT NULL,
  `EmployeePerformanceScore` float NOT NULL,
  `TeamImprovement` varchar(250) NOT NULL,
  `Aspirasi` varchar(250) NOT NULL,
  `AGILE` float NOT NULL,
  `PositifSelfAgile` varchar(250) NOT NULL,
  `NegativeSelfAgile` varchar(250) NOT NULL,
  `IMPACT` float NOT NULL,
  `PositiveSelfImpact` varchar(250) NOT NULL,
  `NegativeSelfImpact` varchar(250) NOT NULL,
  `UDPE` float NOT NULL,
  `PositiveSelfUDPE` varchar(250) NOT NULL,
  `NegativeSelfUDPE` varchar(250) NOT NULL,
  `Entrepreneurial` float NOT NULL,
  `PositiveSelfEntrepreneurial` varchar(250) NOT NULL,
  `NegativeSelfEntrepreneurial` varchar(250) NOT NULL,
  `OpenInnovation` float NOT NULL,
  `PositiveSelfInnovation` varchar(250) NOT NULL,
  `NegativeSelfInnovation` varchar(250) NOT NULL,
  `AvgValues` float DEFAULT '0',
  `TypePA` varchar(50) DEFAULT NULL,
  `PerformanceAppraisalID` int(11) NOT NULL,
  `ReviewByID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  PRIMARY KEY (`PAParameterID`),
  KEY `FK1_paparam_papraisal` (`PerformanceAppraisalID`),
  KEY `FK2_review` (`ReviewByID`),
  CONSTRAINT `FK1_paparam_papraisal` FOREIGN KEY (`PerformanceAppraisalID`) REFERENCES `performanceappraisal` (`PerformanceAppraisalID`) ON DELETE CASCADE,
  CONSTRAINT `FK2_review` FOREIGN KEY (`ReviewByID`) REFERENCES `employment` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.paparameter: ~0 rows (approximately)
/*!40000 ALTER TABLE `paparameter` DISABLE KEYS */;
/*!40000 ALTER TABLE `paparameter` ENABLE KEYS */;

-- Dumping structure for table pa_db.paresult
CREATE TABLE IF NOT EXISTS `paresult` (
  `PaResultID` int(11) NOT NULL AUTO_INCREMENT,
  `PerformanceAppraisalID` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `TotalScore` float NOT NULL,
  PRIMARY KEY (`PaResultID`),
  KEY `FK1_paid` (`PerformanceAppraisalID`),
  KEY `FK2_employeescore` (`EmployeeID`),
  CONSTRAINT `FK1_paid` FOREIGN KEY (`PerformanceAppraisalID`) REFERENCES `performanceappraisal` (`PerformanceAppraisalID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_employeescore` FOREIGN KEY (`EmployeeID`) REFERENCES `employment` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.paresult: ~0 rows (approximately)
/*!40000 ALTER TABLE `paresult` DISABLE KEYS */;
/*!40000 ALTER TABLE `paresult` ENABLE KEYS */;

-- Dumping structure for table pa_db.performanceappraisal
CREATE TABLE IF NOT EXISTS `performanceappraisal` (
  `PerformanceAppraisalID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `PeersID1` int(11) DEFAULT NULL,
  `PeersID2` int(11) DEFAULT NULL,
  `SuperiorID1` int(11) DEFAULT NULL,
  `SuperiorID2` int(11) DEFAULT NULL,
  `SubordinateID1` int(11) DEFAULT NULL,
  `SubordinateID2` int(11) DEFAULT NULL,
  `PeriodeID` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PerformanceAppraisalID`),
  KEY `FK1_employee` (`EmployeeID`),
  KEY `FK2_peersid1` (`PeersID1`),
  KEY `FK3_peers2` (`PeersID2`),
  KEY `FK4_superior1` (`SuperiorID1`),
  KEY `FK5_superior2` (`SuperiorID2`),
  KEY `FK6_subordinate1` (`SubordinateID1`),
  KEY `FK7_subordinate2` (`SubordinateID2`),
  KEY `FK8_periodeid` (`PeriodeID`),
  CONSTRAINT `FK1_employee` FOREIGN KEY (`EmployeeID`) REFERENCES `employment` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_peersid1` FOREIGN KEY (`PeersID1`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK3_peers2` FOREIGN KEY (`PeersID2`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK4_superior1` FOREIGN KEY (`SuperiorID1`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK5_superior2` FOREIGN KEY (`SuperiorID2`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK6_subordinate1` FOREIGN KEY (`SubordinateID1`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK7_subordinate2` FOREIGN KEY (`SubordinateID2`) REFERENCES `employment` (`EmployeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK8_periodeid` FOREIGN KEY (`PeriodeID`) REFERENCES `periode` (`PeriodeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.performanceappraisal: ~14 rows (approximately)
/*!40000 ALTER TABLE `performanceappraisal` DISABLE KEYS */;
INSERT INTO `performanceappraisal` (`PerformanceAppraisalID`, `EmployeeID`, `PeersID1`, `PeersID2`, `SuperiorID1`, `SuperiorID2`, `SubordinateID1`, `SubordinateID2`, `PeriodeID`, `Status`) VALUES
	(1, 1, 3, NULL, NULL, NULL, 3, NULL, 2, NULL),
	(2, 2, 4, NULL, 1, NULL, NULL, NULL, 2, NULL),
	(3, 3, 1, NULL, 1, NULL, NULL, NULL, 2, NULL),
	(4, 4, 2, NULL, 1, NULL, NULL, NULL, 2, NULL),
	(5, 6, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL),
	(6, 7, 6, NULL, NULL, NULL, NULL, NULL, 2, NULL),
	(7, 8, 3, 2, NULL, NULL, NULL, NULL, 2, NULL),
	(8, 1, 3, NULL, NULL, NULL, 3, NULL, 3, NULL),
	(9, 2, 4, NULL, 1, NULL, NULL, NULL, 3, NULL),
	(10, 3, 1, NULL, 1, NULL, NULL, NULL, 3, NULL),
	(11, 4, 2, NULL, 1, NULL, NULL, NULL, 3, NULL),
	(12, 6, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL),
	(13, 7, 6, NULL, NULL, NULL, NULL, NULL, 3, NULL),
	(14, 8, 2, 1, NULL, NULL, NULL, NULL, 3, NULL);
/*!40000 ALTER TABLE `performanceappraisal` ENABLE KEYS */;

-- Dumping structure for table pa_db.periode
CREATE TABLE IF NOT EXISTS `periode` (
  `PeriodeID` int(11) NOT NULL AUTO_INCREMENT,
  `Start` date NOT NULL,
  `End` date NOT NULL,
  `LastModified` datetime NOT NULL,
  `Status` varchar(1) DEFAULT '0',
  PRIMARY KEY (`PeriodeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.periode: ~2 rows (approximately)
/*!40000 ALTER TABLE `periode` DISABLE KEYS */;
INSERT INTO `periode` (`PeriodeID`, `Start`, `End`, `LastModified`, `Status`) VALUES
	(2, '2020-06-01', '2020-06-02', '2020-06-15 00:00:00', '1'),
	(3, '2020-06-01', '2020-06-18', '2020-07-16 00:00:00', '0');
/*!40000 ALTER TABLE `periode` ENABLE KEYS */;

-- Dumping structure for table pa_db.personalinfo
CREATE TABLE IF NOT EXISTS `personalinfo` (
  `PersonalID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(150) NOT NULL,
  `IdentityType` int(11) NOT NULL,
  `IdentityNumber` varchar(15) NOT NULL,
  `IdentityExpiryDate` date NOT NULL,
  `PlaceOfBirth` varchar(50) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Status` int(11) NOT NULL,
  `Gender` int(11) NOT NULL,
  `Religion` int(11) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Address` varchar(225) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PersonalID`),
  KEY `FK1_identitytype` (`IdentityType`),
  KEY `FK2_gender` (`Gender`),
  KEY `FK3_religion` (`Religion`),
  KEY `FK4_user` (`UserID`),
  KEY `FK5_status` (`Status`),
  CONSTRAINT `FK1_identitytype` FOREIGN KEY (`IdentityType`) REFERENCES `identitytype` (`IdentityTypeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_gender` FOREIGN KEY (`Gender`) REFERENCES `gender` (`GenderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK3_religion` FOREIGN KEY (`Religion`) REFERENCES `religion` (`ReligionID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK4_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK5_status` FOREIGN KEY (`Status`) REFERENCES `statuspersonal` (`StatusPersonalID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.personalinfo: ~6 rows (approximately)
/*!40000 ALTER TABLE `personalinfo` DISABLE KEYS */;
INSERT INTO `personalinfo` (`PersonalID`, `FullName`, `IdentityType`, `IdentityNumber`, `IdentityExpiryDate`, `PlaceOfBirth`, `DateOfBirth`, `Status`, `Gender`, `Religion`, `PhoneNumber`, `Address`, `Email`, `UserID`) VALUES
	(20, 'EDIT ', 1, '23123123', '2020-06-01', 'Balige', '2020-06-09', 1, 1, 3, '082111726818', 'czcdasdasdasd', 'gorettis010@gmail.comv', 1),
	(21, 'SAVE', 2, '23123123', '2020-06-01', 'Balige', '2020-06-02', 1, 1, 1, '082111726818', 'dasdasda', 'gorettis010@gmail.com', NULL),
	(22, 'Goretti Situmorang', 2, 'dasdasd', '2020-06-03', 'Balige', '2020-06-02', 2, 1, 2, '082111726818', 'dasdasdad', 'gorettis010@gmail.com', NULL),
	(23, 'ASUS1', 1, 'dadada', '2020-06-01', 'Balige', '2020-06-02', 1, 1, 2, '082111726818', 'dasdadg', 'gorettis010@gmail.com', NULL),
	(25, 'AQAU', 1, '23123123', '2020-06-01', 'Balige', '2020-06-09', 1, 1, 1, '082111726818', 'dasdasdad', 'gorettis010@gmail.com', NULL),
	(26, 'Maria', 3, '23123123', '2020-06-03', 'Balige', '2020-06-09', 1, 1, 5, '082111726818', 'dasdasd', 'gorettis010@gmail.com', NULL),
	(27, 'HEAD', 1, 'DASDA', '2020-06-03', 'Balige', '2020-06-09', 1, 1, 5, 'DASDAD', 'DASDADAD', 'gorettis010@gmail.com', NULL);
/*!40000 ALTER TABLE `personalinfo` ENABLE KEYS */;

-- Dumping structure for table pa_db.religion
CREATE TABLE IF NOT EXISTS `religion` (
  `ReligionID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`ReligionID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.religion: ~5 rows (approximately)
/*!40000 ALTER TABLE `religion` DISABLE KEYS */;
INSERT INTO `religion` (`ReligionID`, `Name`) VALUES
	(1, 'Kristen Protestan'),
	(2, 'Katolik'),
	(3, 'Islam'),
	(4, 'Budha'),
	(5, 'Hindhu'),
	(6, 'Konghuchu');
/*!40000 ALTER TABLE `religion` ENABLE KEYS */;

-- Dumping structure for table pa_db.squad
CREATE TABLE IF NOT EXISTS `squad` (
  `SquadID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeSquad` varchar(150) DEFAULT NULL,
  `SquadName` varchar(50) NOT NULL,
  PRIMARY KEY (`SquadID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.squad: ~0 rows (approximately)
/*!40000 ALTER TABLE `squad` DISABLE KEYS */;
INSERT INTO `squad` (`SquadID`, `CodeSquad`, `SquadName`) VALUES
	(2, 'SQ001', 'Test Squad'),
	(3, 'SQ002', 'Test Squad 2');
/*!40000 ALTER TABLE `squad` ENABLE KEYS */;

-- Dumping structure for table pa_db.statuspersonal
CREATE TABLE IF NOT EXISTS `statuspersonal` (
  `StatusPersonalID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`StatusPersonalID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.statuspersonal: ~3 rows (approximately)
/*!40000 ALTER TABLE `statuspersonal` DISABLE KEYS */;
INSERT INTO `statuspersonal` (`StatusPersonalID`, `Name`) VALUES
	(1, 'Single'),
	(2, 'Menikah');
/*!40000 ALTER TABLE `statuspersonal` ENABLE KEYS */;

-- Dumping structure for table pa_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `auth_key` varchar(50) DEFAULT NULL,
  `password_reset_token` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table pa_db.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`UserID`, `username`, `password`, `role`, `auth_key`, `password_reset_token`) VALUES
	(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', '', ''),
	(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'user', '', '');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
