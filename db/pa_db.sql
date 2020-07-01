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

-- Data exporting was unselected.
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `GenderID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) NOT NULL,
  PRIMARY KEY (`GenderID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.identitytype
CREATE TABLE IF NOT EXISTS `identitytype` (
  `IdentityTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(225) NOT NULL,
  PRIMARY KEY (`IdentityTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.joblevel
CREATE TABLE IF NOT EXISTS `joblevel` (
  `LevelID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeLevel` varchar(150) NOT NULL,
  `LevelName` varchar(50) NOT NULL,
  PRIMARY KEY (`LevelID`),
  UNIQUE KEY `CodeLevel` (`CodeLevel`),
  UNIQUE KEY `LevelName` (`LevelName`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.jobposition
CREATE TABLE IF NOT EXISTS `jobposition` (
  `JobPositionID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeJobPosition` varchar(150) NOT NULL,
  `JobPositionName` varchar(50) NOT NULL,
  `Level` int(11) NOT NULL,
  PRIMARY KEY (`JobPositionID`),
  UNIQUE KEY `CodeJobPosition` (`CodeJobPosition`),
  UNIQUE KEY `JobPositionName` (`JobPositionName`),
  UNIQUE KEY `Level` (`Level`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.jobtitle
CREATE TABLE IF NOT EXISTS `jobtitle` (
  `JobTitleID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeJobTitle` varchar(150) NOT NULL,
  `JobTitleName` varchar(50) NOT NULL,
  PRIMARY KEY (`JobTitleID`),
  UNIQUE KEY `CodeJobTitle` (`CodeJobTitle`),
  UNIQUE KEY `JobTitleName` (`JobTitleName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.organization
CREATE TABLE IF NOT EXISTS `organization` (
  `OrganizationID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeOrganization` varchar(150) DEFAULT NULL,
  `OrganizationName` varchar(50) NOT NULL,
  PRIMARY KEY (`OrganizationID`),
  UNIQUE KEY `CodeOrganization` (`CodeOrganization`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.pacomponent
CREATE TABLE IF NOT EXISTS `pacomponent` (
  `PAComponentID` int(11) NOT NULL AUTO_INCREMENT,
  `PerformanceAppraisalID` int(11) NOT NULL,
  `Self` float NOT NULL,
  `Peers` float NOT NULL,
  `SubordinatesToSuperior` float NOT NULL,
  `SuperiorToSubordinates` float NOT NULL,
  `EmployeeScore` float NOT NULL,
  `TotalScore` float DEFAULT '0',
  `EmployeeID` int(11) NOT NULL,
  `PeriodeID` int(11) NOT NULL,
  `TrackRecord` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`PAComponentID`),
  KEY `FK1_performanceappraisal` (`PerformanceAppraisalID`),
  KEY `FK2_employementid` (`EmployeeID`),
  KEY `FK3_periode` (`PeriodeID`),
  CONSTRAINT `FK1_performanceappraisal` FOREIGN KEY (`PerformanceAppraisalID`) REFERENCES `performanceappraisal` (`PerformanceAppraisalID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2_employementid` FOREIGN KEY (`EmployeeID`) REFERENCES `employment` (`EmployeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK3_periode` FOREIGN KEY (`PeriodeID`) REFERENCES `periode` (`PeriodeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
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
  `Status` varchar(1) DEFAULT '0',
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
  CONSTRAINT `FK8_periodeid` FOREIGN KEY (`PeriodeID`) REFERENCES `periode` (`PeriodeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.periode
CREATE TABLE IF NOT EXISTS `periode` (
  `PeriodeID` int(11) NOT NULL AUTO_INCREMENT,
  `Start` date NOT NULL,
  `End` date NOT NULL,
  `LastModified` datetime NOT NULL,
  `Status` varchar(1) DEFAULT '0',
  PRIMARY KEY (`PeriodeID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.personalinfo
CREATE TABLE IF NOT EXISTS `personalinfo` (
  `PersonalID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(150) NOT NULL,
  `IdentityType` int(11) NOT NULL,
  `IdentityNumber` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.religion
CREATE TABLE IF NOT EXISTS `religion` (
  `ReligionID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`ReligionID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.squad
CREATE TABLE IF NOT EXISTS `squad` (
  `SquadID` int(11) NOT NULL AUTO_INCREMENT,
  `CodeSquad` varchar(150) NOT NULL,
  `SquadName` varchar(50) NOT NULL,
  PRIMARY KEY (`SquadID`),
  UNIQUE KEY `SquadName` (`SquadName`),
  UNIQUE KEY `CodeSquad` (`CodeSquad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.statuspersonal
CREATE TABLE IF NOT EXISTS `statuspersonal` (
  `StatusPersonalID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`StatusPersonalID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
-- Dumping structure for table pa_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `auth_key` varchar(50) DEFAULT NULL,
  `password_reset_token` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
