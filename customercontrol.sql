/*
SQLyog Ultimate v11.5 (64 bit)
MySQL - 8.0.18 : Database - customercontrol
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`customercontrol` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `customercontrol`;

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Balance` double NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UserName` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `customers` */

insert  into `customers`(`Id`,`Name`,`Address`,`DateCreated`,`Username`,`Password`,`Balance`) values (1,'Lindsey Drew','6 prion lane summerstrand','2020-11-16 12:59:38','TheBear','Foxyzulu@2',548.1500000000001);

/*Table structure for table `invoicelines` */

DROP TABLE IF EXISTS `invoicelines`;

CREATE TABLE `invoicelines` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceId` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Amount` double NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `invoicelines` */

insert  into `invoicelines`(`Id`,`InvoiceId`,`Description`,`DateCreated`,`Amount`) values (1,1,'Joining Fee','2020-11-16 13:00:25',50.22),(2,1,'Joining Fee','2020-11-16 13:00:25',50.22),(3,2,'Domain Registration','2020-11-16 13:01:43',12.44),(4,2,'Domain Registration','2020-11-16 13:01:43',12.44);

/*Table structure for table `invoices` */

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerId` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Amount` double NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `invoices` */

insert  into `invoices`(`Id`,`CustomerId`,`Description`,`DateCreated`,`Amount`) values (1,1,'Gym membership','2020-11-16 13:00:25',507.21000000000004),(2,1,'Hosting Fee','2020-11-16 13:01:43',40.94);

/*Table structure for table `operators` */

DROP TABLE IF EXISTS `operators`;

CREATE TABLE `operators` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `operators` */

insert  into `operators`(`Id`,`Name`,`Username`,`Password`) values (1,'Lindsey','TheBear','55513587cf267d9bfedcc2f8a5466e68');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerId` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Amount` double DEFAULT NULL,
  `InvoiceId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `payments` */

/* Trigger structure for table `invoices` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `customer_balance_invoices` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `customer_balance_invoices` AFTER INSERT ON `invoices` FOR EACH ROW BEGIN
   DECLARE X,Y DOUBLE;
   SET X = (SELECT (cc.Balance + NEW.Amount) FROM customers cc WHERE cc.Id = NEW.CustomerId );
   UPDATE customers 
   SET Balance = x
   WHERE Id = NEW.CustomerId;
END */$$


DELIMITER ;

/* Trigger structure for table `payments` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `payment_tring` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `payment_tring` AFTER INSERT ON `payments` FOR EACH ROW BEGIN
  DECLARE X,y DOUBLE;
  SET X = (SELECT (cc.Balance - NEW.Amount) FROM customers cc WHERE cc.Id = NEW.CustomerId );
   UPDATE customers 
   SET Balance = X
   WHERE Id = NEW.CustomerId;
  -- ERROR 1242 if more than one row with 'Bill'
  
  SET y = (SELECT (n.Amount - NEW.Amount) FROM invoices n WHERE n.Id = NEW.InvoiceId );
   UPDATE invoices 
   SET Amount = Y
   WHERE Id = NEW.InvoiceId;
END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
