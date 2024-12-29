-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 10.4.25-MariaDB - mariadb.org binary distribution
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk db_api
CREATE DATABASE IF NOT EXISTS `db_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_api`;

-- membuang struktur untuk table db_api.client
CREATE TABLE IF NOT EXISTS `client` (
  `ClientID` varchar(10) NOT NULL,
  `ClientName` varchar(255) DEFAULT NULL,
  `ClientEmail` varchar(255) DEFAULT NULL,
  `ClientPhone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_api.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `EmployeeID` varchar(10) NOT NULL,
  `EmployeeName` varchar(255) DEFAULT NULL,
  `EmployeeEmail` varchar(255) DEFAULT NULL,
  `EmployeePhone` varchar(20) DEFAULT NULL,
  `Office` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `EmployeeEmail` (`EmployeeEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pengeluaran data tidak dipilih.

-- membuang struktur untuk table db_api.order
CREATE TABLE IF NOT EXISTS `order` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` varchar(10) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `OrderItem` varchar(255) DEFAULT NULL,
  `OrderAmount` decimal(10,2) DEFAULT NULL,
  `ClientID` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `EmployeeID` (`EmployeeID`),
  KEY `ClientID` (`ClientID`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`),
  CONSTRAINT `order_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4;

-- Pengeluaran data tidak dipilih.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
