CREATE DATABASE  IF NOT EXISTS `shubharambh` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shubharambh`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 192.168.1.100    Database: shubharambh
-- ------------------------------------------------------
-- Server version	5.7.18-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `excel_data`
--

DROP TABLE IF EXISTS `excel_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `excel_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `refrence_number` varchar(45) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id_excel_data_idx` (`project_id`),
  KEY `store_id_excel_data_idx` (`store_id`),
  CONSTRAINT `project_id_excel_data` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `store_id_excel_data` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_data`
--

LOCK TABLES `excel_data` WRITE;
/*!40000 ALTER TABLE `excel_data` DISABLE KEYS */;
INSERT INTO `excel_data` VALUES (17,'Abhay','Anand@gmail.com','Pune','9874561230','1025','Emco Stock',2,1,'2017-12-01','2017-12-02'),(18,'Abhi','Abhi@gmail.com','Mumbai','1234567890','1025','Emco Stock',2,1,'2017-12-01','2017-12-02'),(19,'Abhay','Anand@gmail.com','Pune','9874561230','520','Customer Stock',2,2,'2017-12-01','2017-12-02'),(20,'Abhi','Abhi@gmail.com','Mumbai','1234567890','520','Customer Stock',2,2,'2017-12-01','2017-12-02'),(21,'Abhay','Anand@gmail.com','Pune','9874561230','520','Emco Stock',1,1,'2017-12-06','2017-12-12'),(22,'Abhi','Abhi@gmail.com','Mumbai','1234567890','520','Emco Stock',1,1,'2017-12-06','2017-12-12'),(23,'Abhay','Anand@gmail.com','Pune','9874561230','5220','Emco Stock',3,1,'2017-12-12','2017-12-22'),(24,'Abhi','Abhi@gmail.com','Mumbai','1234567890','5220','Emco Stock',3,1,'2017-12-12','2017-12-22'),(25,'Abhay','Anand@gmail.com','Pune','9874561230','250326','T&P Stock',2,1,'2017-12-04','2017-12-11'),(26,'Abhi','Abhi@gmail.com','Mumbai','1234567890','250326','T&P Stock',2,1,'2017-12-04','2017-12-11');
/*!40000 ALTER TABLE `excel_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `import_excel`
--

DROP TABLE IF EXISTS `import_excel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_excel` (
  `import_excel_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(45) DEFAULT NULL,
  `inventory_type` varchar(15) DEFAULT NULL,
  `billing_doc_no` bigint(25) DEFAULT NULL,
  `billing_date` varchar(45) DEFAULT NULL,
  `billing_type` varchar(45) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `plant` varchar(45) DEFAULT NULL,
  `material_description` varchar(45) DEFAULT NULL,
  `refrence_document` varchar(45) DEFAULT NULL,
  `billing_quantity` varchar(45) DEFAULT NULL,
  `net_value` varchar(45) DEFAULT NULL,
  `control_code` varchar(45) DEFAULT NULL,
  `customer_no` varchar(45) DEFAULT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `customer_city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  `telephone_no` varchar(45) DEFAULT NULL,
  `email_id` varchar(45) DEFAULT NULL,
  `gst_no` varchar(45) DEFAULT NULL,
  `pan_no` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`import_excel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_excel`
--

LOCK TABLES `import_excel` WRITE;
/*!40000 ALTER TABLE `import_excel` DISABLE KEYS */;
/*!40000 ALTER TABLE `import_excel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indent_head`
--

DROP TABLE IF EXISTS `indent_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indent_head` (
  `indent_id` int(11) NOT NULL AUTO_INCREMENT,
  `indent_code` varchar(12) NOT NULL,
  `indent_date` date DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `indent_type` varchar(20) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `site_location` varchar(25) DEFAULT NULL,
  `indent_total_qty` double DEFAULT NULL,
  `indent_status` varchar(25) DEFAULT NULL,
  `approved_total_qty` double DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `approved_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(25) DEFAULT NULL,
  `updated_by` varchar(25) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(25) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`indent_id`),
  KEY `project_id` (`project_id`),
  KEY `activity_id` (`activity_id`),
  KEY `contractor_id` (`contractor_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `indent_head_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`),
  CONSTRAINT `indent_head_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `tbl_activity_master` (`activity_id`),
  CONSTRAINT `indent_head_ibfk_3` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`),
  CONSTRAINT `indent_head_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `tbl_site_master` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indent_head`
--

LOCK TABLES `indent_head` WRITE;
/*!40000 ALTER TABLE `indent_head` DISABLE KEYS */;
INSERT INTO `indent_head` VALUES (1,'I-1/17-18','2017-10-10',2,'Internal',3,2,3,'pune',12,'approved',12,0,'user',NULL,'dfh','admin','2017-11-29 14:56:36','admin','2017-12-05 16:25:21'),(42,'I-3/17-18','2017-11-01',1,'Internal Indent',3,1,3,'mumbai',42,'pending',9,0,'asf',NULL,'jkg','admin','2017-12-05 11:53:11','admin','2017-12-05 16:25:23'),(43,'I-2/17-18','2017-11-02',1,'Internal Indent',3,3,2,NULL,NULL,'approved',11,0,'afadag',NULL,'sdg','admin','2017-12-01 16:39:39',NULL,NULL),(44,'E-4/17-18','2017-11-01',1,'External Indent',3,1,3,NULL,NULL,'approved',12,0,NULL,NULL,'jhuj','admin','2017-11-29 17:14:57',NULL,NULL),(45,'I-3/17-18','2017-11-03',1,'Internal Indent',3,3,3,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(46,'I-4/17-18','2017-11-10',2,'Internal Indent',4,3,3,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','admin','2017-12-05 11:14:56','admin','2017-12-02 13:26:24'),(47,'I-5/17-18','2017-11-01',1,'Internal Indent',1,1,2,NULL,NULL,'pending',12,0,NULL,NULL,'sffgd','admin','2017-12-04 17:02:13',NULL,NULL),(48,'E-5/17-18','2017-11-02',2,'External Indent',1,1,4,NULL,NULL,'reject',NULL,0,NULL,NULL,'admin','admin','2017-12-01 17:23:45','admin','2017-12-02 13:52:03'),(49,'E-6/17-18','2017-11-01',3,'External Indent',2,2,5,NULL,NULL,'pending',NULL,1,NULL,NULL,'admin',NULL,NULL,'admin','2017-12-05 18:17:31'),(50,'E-7/17-18','2017-11-17',2,'External Indent',2,2,1,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(51,'E-8/17-18','2017-11-10',1,'External Indent',3,3,5,NULL,NULL,'reject',NULL,0,NULL,NULL,'admin','admin','2017-12-06 12:04:24','admin','2017-12-02 13:44:04'),(52,'E-9/17-18','2017-11-22',3,'External Indent',2,3,5,NULL,NULL,'approved',NULL,0,'admin',NULL,'admin','admin','2017-12-06 11:50:25',NULL,NULL),(53,'E-10/17-18','2017-11-02',1,'External Indent',31,3,2,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','admin','2017-12-06 11:55:38','admin','2017-12-04 15:30:52'),(54,'I-6/17-18','2017-12-07',3,'Internal Indent',1,4,1,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','admin','2017-12-06 11:59:21',NULL,NULL),(55,'E-11/17-18','2017-12-07',3,'External Indent',31,3,1,NULL,NULL,'approved',NULL,1,NULL,NULL,'admin','admin','2017-12-01 17:58:04','admin','2017-12-05 18:17:23'),(56,'I-7/17-18','2017-12-26',3,'Internal Indent',3,3,2,NULL,NULL,'reject',NULL,1,'admin',NULL,'admin','admin','2017-12-06 12:03:58','admin','2017-12-05 18:17:15'),(57,'E-12/17-18','2017-12-01',3,'External Indent',2,3,3,NULL,NULL,'approved',NULL,0,'',NULL,'admin','admin','2017-12-06 11:54:50','admin','2017-12-02 13:59:03'),(58,'E-15/17-18','2017-12-22',3,'External Indent',3,3,3,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin','admin','2017-12-04 18:42:23','admin','2017-12-02 13:26:10'),(59,'E-14/17-18','2017-12-13',3,'External Indent',3,2,3,NULL,NULL,'pending',NULL,1,NULL,NULL,'admin',NULL,NULL,'admin','2017-12-04 16:16:26'),(60,'I-3/17-18','2017-11-01',1,'Internal Indent',3,1,3,NULL,NULL,'pending',NULL,1,NULL,NULL,'admin',NULL,NULL,'admin','2017-12-02 13:59:16'),(61,'E-15/17-18','2017-12-07',3,'External Indent',2,1,3,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(62,'E-16/17-18','2017-11-12',1,'External Indent',2,1,4,NULL,NULL,'approved',NULL,0,'admin',NULL,'admin','admin','2017-12-06 11:49:49',NULL,NULL),(63,'E-17/17-18','2017-11-05',3,'External Indent',4,5,4,NULL,NULL,'approved',NULL,0,'emco',NULL,'admin','admin','2017-12-06 11:52:00',NULL,NULL),(64,'E-18/17-18','2017-12-05',2,'External Indent',3,2,2,NULL,NULL,'approved',NULL,0,'admin',NULL,'admin','admin','2017-12-06 11:48:12',NULL,NULL),(65,'E-19/17-18','2017-12-05',3,'External Indent',2,4,1,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(66,'E-20/17-18','2017-12-06',3,'External Indent',2,4,3,NULL,NULL,'pending',NULL,NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(67,'I-4/17-18','2017-12-06',2,'Internal Indent',4,1,1,NULL,NULL,'pending',NULL,NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(68,'I-5/17-18','2017-12-06',3,'Internal Indent',2,3,3,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(69,'I-6/17-18','2017-12-06',3,'Internal Indent',2,1,2,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(70,'I-7/17-18','2017-12-06',2,'Internal Indent',2,4,3,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(71,'E-21/17-18','2017-12-06',3,'External Indent',3,3,2,NULL,NULL,'approved',NULL,0,'admin',NULL,'admin','admin','2017-12-06 11:47:17',NULL,NULL),(72,'I-8/17-18','2017-12-06',2,'Internal Indent',2,1,3,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','admin','2017-12-06 17:05:10',NULL,NULL),(73,'E-22/17-18','2017-12-06',2,'External Indent',1,3,4,NULL,NULL,'approved',NULL,0,'',NULL,'admin','admin','2017-12-13 19:06:00',NULL,NULL),(74,'I-9/17-18','2017-12-06',2,'Internal Indent',4,3,3,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','','2017-12-13 19:05:10',NULL,NULL),(75,'I-10/17-18','2017-12-06',2,'Internal Indent',4,1,1,NULL,NULL,'approved',NULL,0,NULL,NULL,'admin','admin','2017-12-08 14:25:09',NULL,NULL),(76,'I-11/17-18','2017-12-06',2,'Internal Indent',4,3,4,NULL,NULL,'pending',NULL,0,NULL,NULL,'admin',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `indent_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indent_material`
--

DROP TABLE IF EXISTS `indent_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indent_material` (
  `indent_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `indent_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_code` varchar(20) DEFAULT NULL,
  `indent_material_qty` double DEFAULT NULL,
  `current_stock` double DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `unit_of_measurment` varchar(45) DEFAULT NULL,
  `approved_total_qty` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`indent_material_id`),
  KEY `indent_id` (`indent_id`),
  CONSTRAINT `indent_material_ibfk_1` FOREIGN KEY (`indent_id`) REFERENCES `indent_head` (`indent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indent_material`
--

LOCK TABLES `indent_material` WRITE;
/*!40000 ALTER TABLE `indent_material` DISABLE KEYS */;
INSERT INTO `indent_material` VALUES (8,43,1,'OSM material',3,NULL,NULL,'ft','3'),(32,44,7,'PSSSETCHRWSTRAIN00',4,NULL,NULL,'ft','10'),(33,44,8,'PSSSCVLFOUNDLTFEDR',4,NULL,NULL,'meter',NULL),(34,46,5,'emco mfg',4,NULL,NULL,'ft','3'),(35,47,1,'OSM material',3,NULL,NULL,'meter','1'),(36,48,1,'OSM material',3,NULL,NULL,'meter','1'),(37,49,5,'emco mfg',3,NULL,NULL,'ft',NULL),(38,50,3,'bought out material',3,NULL,NULL,'kg',NULL),(39,51,6,'steel structure',3,NULL,NULL,'meter','2'),(40,52,5,'emco mfg',3,NULL,NULL,'ft','2'),(41,53,1,'OSM material1',5,NULL,NULL,'meter','2'),(42,54,6,'steel structure',4,NULL,NULL,'meter',NULL),(43,55,5,'emco mfg',1,NULL,NULL,'ft','2'),(44,57,5,'emco mfg',2,NULL,NULL,'ft','2'),(45,58,6,'steel structure',3,NULL,NULL,'meter','2'),(46,59,1,'OSM material',3,NULL,NULL,'meter',NULL),(47,60,6,'steel structure',1,NULL,NULL,'meter',NULL),(48,61,3,'bought out material',3,NULL,NULL,'kg',NULL),(49,62,3,'bought out material',3,NULL,NULL,'kg','2'),(50,63,3,'bought out material',10,NULL,NULL,'kg','9'),(51,64,14,'M007',3,NULL,NULL,'kg','2'),(52,65,17,'M0001',4,NULL,NULL,'gs',NULL),(53,66,3,'bought out material',3,NULL,NULL,'kg',NULL),(54,67,3,'bought out material',10,NULL,NULL,'kg',NULL),(55,68,16,'M00010',2,NULL,NULL,'kg',NULL),(56,69,13,'M004',3,NULL,NULL,'kg',NULL),(57,70,2,'M0002',1,NULL,NULL,'ft1',NULL),(58,71,1,'OSM material1',4,NULL,NULL,'centimeter','2'),(59,72,16,'M00010',4,NULL,NULL,'kg','2'),(60,73,13,'M004',3,NULL,NULL,'kg','2'),(61,74,2,'M0002',3,NULL,NULL,'ft1','2'),(62,75,2,'M0002',1,NULL,NULL,'ft1','1'),(63,76,11,'M006',3,NULL,NULL,'kg',NULL);
/*!40000 ALTER TABLE `indent_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduler`
--

DROP TABLE IF EXISTS `scheduler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` varchar(20) DEFAULT NULL,
  `calories` int(11) DEFAULT NULL,
  `datestamp` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduler`
--

LOCK TABLES `scheduler` WRITE;
/*!40000 ALTER TABLE `scheduler` DISABLE KEYS */;
INSERT INTO `scheduler` VALUES (1,'name',0,'description',0,NULL),(2,'\nsamar',1000,'ok',25,NULL),(3,'\namar',2000,'not ok',50,NULL),(4,'\nkamar',12000,'onotok',50,NULL),(5,'\n',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `scheduler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_activity_master`
--

DROP TABLE IF EXISTS `tbl_activity_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_activity_master` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `activity_code` varchar(45) DEFAULT NULL,
  `activity_name` varchar(45) DEFAULT NULL,
  `activity_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime(6) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_activity_master`
--

LOCK TABLES `tbl_activity_master` WRITE;
/*!40000 ALTER TABLE `tbl_activity_master` DISABLE KEYS */;
INSERT INTO `tbl_activity_master` VALUES (1,NULL,'A0001','change cable','in progress','admin',NULL,'admin',NULL,NULL,NULL,0),(2,NULL,'A0002','repair tower','progress','admin',NULL,NULL,NULL,NULL,NULL,0),(3,NULL,'A0003','construct tower','done','admin',NULL,NULL,NULL,NULL,NULL,0),(4,NULL,'A0004','foundation','progress','admin',NULL,NULL,NULL,NULL,NULL,0),(31,NULL,'2344','gdfg','Active','admin',NULL,NULL,NULL,NULL,NULL,0),(32,NULL,'act123','repair tower','Active','admin',NULL,NULL,NULL,NULL,NULL,0),(33,NULL,'asd123','repair construction','Active','admin',NULL,NULL,NULL,NULL,NULL,0),(34,4,'asdaf','affafsa','Active','admin',NULL,NULL,NULL,NULL,NULL,0),(35,3,'asd234','sssssssss','Active','admin',NULL,'admin',NULL,NULL,NULL,0),(36,1,'sad45','asdf','Active','admin',NULL,NULL,NULL,'admin','2017-11-22 18:08:16.000000',1);
/*!40000 ALTER TABLE `tbl_activity_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bom_master`
--

DROP TABLE IF EXISTS `tbl_bom_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bom_master` (
  `bom_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` varchar(45) DEFAULT NULL,
  `bom_name` varchar(45) DEFAULT NULL,
  `soil_type` varchar(45) DEFAULT NULL,
  `tower_type` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime(6) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`bom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bom_master`
--

LOCK TABLES `tbl_bom_master` WRITE;
/*!40000 ALTER TABLE `tbl_bom_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_bom_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contractor_inventory`
--

DROP TABLE IF EXISTS `tbl_contractor_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contractor_inventory` (
  `contractor_inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_issue_code` varchar(45) DEFAULT NULL,
  `material_issue_date` date DEFAULT NULL,
  `indent_id` int(11) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `challan_no` varchar(20) DEFAULT NULL,
  `loc_no` varchar(25) DEFAULT NULL,
  `issued_to` varchar(45) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `material_return_code` varchar(45) DEFAULT NULL,
  `material_return_date` date DEFAULT NULL,
  PRIMARY KEY (`contractor_inventory_id`),
  KEY `storeID_idx` (`store_id`),
  KEY `projectID_idx` (`project_id`),
  KEY `contractorID_idx` (`contractor_id`),
  KEY `indentID1_idx` (`indent_id`),
  CONSTRAINT `contractorID1` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `indentID1` FOREIGN KEY (`indent_id`) REFERENCES `indent_head` (`indent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projectID1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `storeID1` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contractor_inventory`
--

LOCK TABLES `tbl_contractor_inventory` WRITE;
/*!40000 ALTER TABLE `tbl_contractor_inventory` DISABLE KEYS */;
INSERT INTO `tbl_contractor_inventory` VALUES (1,'MI301117-1','2017-12-12',44,1,2,2,'Customer Stock','Mr.ABCD','abcd','Mr.Qwerty','11111111','RET081217-7','2017-12-07'),(2,'MI301117-2','2017-12-12',44,1,2,2,'Customer Stock','Mr.ABCD','abcd','Mr.Qwerty','11111111',NULL,NULL),(3,'MI301117-3','2017-12-12',44,1,1,2,'Emco Stock','Mr.ABCD','Mr.ABCD','Mr.ABCD','nljkl',NULL,NULL),(4,'MI011217-4','2017-12-20',53,3,1,1,'Emco Stock','11','kuhki','jhk','dcdgf',NULL,NULL),(5,'MI011217-5','2017-12-13',44,1,1,1,'Emco Stock','hgf','hgfh','hgh','hgfhfh',NULL,NULL),(6,'MI011217-6','2017-12-12',44,1,1,1,'Emco Stock','ABCD','1','2','3 gdfg',NULL,NULL),(7,'MI011217-6','2017-12-12',44,1,1,1,'Emco Stock','ABCD','1','2','3 gdfg',NULL,NULL),(8,'MI011217-7','2017-12-21',44,1,1,1,'Customer Stock','ABCD','ABCD','ABCD','bdgfhgf','RET021217-2','2017-12-28'),(9,'MI021217-8','2017-12-14',48,1,2,1,'Customer Stock','6576','765','675','765756',NULL,NULL),(10,'MI021217-8','2017-12-14',48,1,2,1,'Customer Stock','6576','765','675','765756',NULL,NULL),(11,'MI021217-9','2017-12-07',48,1,1,2,'Customer Stock','gthy','try','hg','ghfgh','RET021217-1','2017-12-14'),(12,'MI041217-10','2017-12-30',54,2,2,1,'Customer Stock','hgfh','456','gthy','qwertyuiop','RET041217-4','2017-12-13'),(13,'MI041217-11','2017-12-28',54,2,2,1,'Emco Stock','fretg','grre','rer','retretretre','RET041217-5','2017-12-29'),(14,'MI051217-12','2017-12-13',47,1,1,2,'Emco Stock','435 4','fcds','esfwe','fewr',NULL,NULL),(15,'MI061217-13','2017-12-06',75,1,3,2,'Emco Stock','10001','100002','Rushi','ok',NULL,NULL),(16,'MI081217-14','2017-12-01',44,1,2,1,'Customer Stock','555','345','sam','kk',NULL,NULL),(17,'MI091217-15','2017-12-13',66,4,2,3,'Customer Stock','5464','213','dfhh','fdh',NULL,NULL),(18,'MI091217-16','2017-12-20',66,2,14,4,'T&P Stock','sdgfsd','sgery','eryy','dh',NULL,NULL),(19,'MI011217-5','2017-12-13',44,1,1,1,'Emco Stock','hgf','hgfh','hgh','hgfhfh',NULL,NULL),(20,'MI011217-5','2017-12-13',44,1,1,1,'Emco Stock','hgf','hgfh','hgh','hgfhfh',NULL,NULL);
/*!40000 ALTER TABLE `tbl_contractor_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contractor_inventory_material`
--

DROP TABLE IF EXISTS `tbl_contractor_inventory_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contractor_inventory_material` (
  `inventory_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `contractor_inventory_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `indent_qty` double DEFAULT NULL,
  `issued_qty` double DEFAULT NULL,
  `return_qty` double DEFAULT NULL,
  `consumed_qty` double DEFAULT NULL,
  `retrurn_material_type` varchar(45) DEFAULT NULL,
  `reason_return` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`inventory_material_id`),
  KEY `one_idx` (`contractor_inventory_id`),
  KEY `two_idx` (`material_id`),
  CONSTRAINT `one1` FOREIGN KEY (`contractor_inventory_id`) REFERENCES `tbl_contractor_inventory` (`contractor_inventory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `two2` FOREIGN KEY (`material_id`) REFERENCES `tbl_material_master` (`material_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contractor_inventory_material`
--

LOCK TABLES `tbl_contractor_inventory_material` WRITE;
/*!40000 ALTER TABLE `tbl_contractor_inventory_material` DISABLE KEYS */;
INSERT INTO `tbl_contractor_inventory_material` VALUES (1,1,5,' ',4,3,-77,80,'Excess','adf'),(2,1,6,' ',4,4,4,NULL,'Unused','fafsaf'),(3,1,6,' ',4,4,4,NULL,'Damaged','ffa'),(4,1,6,' ',4,4,4,NULL,'Damaged','afffff'),(5,3,5,' ',4,4,NULL,NULL,NULL,NULL),(6,3,6,' ',4,4,NULL,NULL,NULL,NULL),(7,4,1,'OSM material',5,5,NULL,NULL,NULL,NULL),(8,5,7,'PSSSETCHRWSTRAIN00',4,4,NULL,NULL,NULL,NULL),(9,5,8,'PSSSCVLFOUNDLTFEDR',4,4,NULL,NULL,NULL,NULL),(10,6,7,'PSSSETCHRWSTRAIN00',4,3,NULL,NULL,NULL,NULL),(11,6,8,'PSSSCVLFOUNDLTFEDR',4,2,NULL,NULL,NULL,NULL),(12,7,7,'PSSSETCHRWSTRAIN00',4,3,NULL,NULL,NULL,NULL),(13,7,8,'PSSSCVLFOUNDLTFEDR',4,2,NULL,NULL,NULL,NULL),(14,8,7,'PSSSETCHRWSTRAIN00',4,3,1,2,'Scrap','111111'),(15,8,8,'PSSSCVLFOUNDLTFEDR',4,3,2,1,'Other','22222'),(16,9,1,'OSM material',3,2,NULL,NULL,NULL,NULL),(17,10,1,'OSM material',3,2,NULL,NULL,NULL,NULL),(18,11,1,'OSM material',3,2,NULL,NULL,NULL,NULL),(19,12,6,'steel structure',4,4,4,NULL,'Damaged','hrtyht'),(20,13,6,'steel structure',4,4,4,NULL,'Damaged','ytiri'),(21,14,1,'OSM material',3,2,NULL,NULL,NULL,NULL),(22,15,2,'M0002',1,1,NULL,NULL,NULL,NULL),(23,16,7,'PSSSETCHRWSTRAIN00',4,4,NULL,NULL,NULL,NULL),(24,16,8,'PSSSCVLFOUNDLTFEDR',4,4,NULL,NULL,NULL,NULL),(25,17,3,'bought out material',3,2,NULL,NULL,NULL,NULL),(26,19,7,'PSSSETCHRWSTRAIN00',4,4,NULL,NULL,NULL,NULL),(27,19,8,'PSSSCVLFOUNDLTFEDR',4,4,NULL,NULL,NULL,NULL),(28,20,7,'PSSSETCHRWSTRAIN00',4,4,NULL,NULL,NULL,NULL),(29,20,8,'PSSSCVLFOUNDLTFEDR',4,4,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_contractor_inventory_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contractor_master`
--

DROP TABLE IF EXISTS `tbl_contractor_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contractor_master` (
  `contractor_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `contractor_name` varchar(45) DEFAULT NULL,
  `contractor_address1` varchar(100) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `gstin_no` varchar(45) DEFAULT NULL,
  `contact_person` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime(6) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  PRIMARY KEY (`contractor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contractor_master`
--

LOCK TABLES `tbl_contractor_master` WRITE;
/*!40000 ALTER TABLE `tbl_contractor_master` DISABLE KEYS */;
INSERT INTO `tbl_contractor_master` VALUES (1,2,1,'ajay','kranti nagar',NULL,NULL,'pune',23,'gst45','atul','123456',NULL,NULL,NULL,NULL,'admin','2017-12-02 13:04:24.000000',1),(2,1,2,'ranveer','sambhaji nagar',NULL,NULL,'nagpur',5,'gst56','ajay','12345630','admin',NULL,'admin',NULL,'admin','2017-11-27 13:03:55.000000',0),(3,3,14,'ankush','sinhgad road',NULL,NULL,'pune',21,'gst34','aman','12345312','admin',NULL,NULL,NULL,'admin','2017-12-02 13:04:21.000000',1),(4,2,13,'aman','soham nagar',NULL,NULL,'mumbai',20,'gst325','ajinky','2143125','admin',NULL,'admin',NULL,NULL,NULL,0),(5,3,15,'rohan','jijai nagar',NULL,NULL,'pune',21,'gst123','jayesh','215132','admin',NULL,'admin',NULL,NULL,NULL,0),(6,4,4,'jay','new adity building','new building 123','kolhapur','pune',21,'gst456789','lahfiahsk','8969698732','admin',NULL,'admin',NULL,NULL,NULL,0),(7,4,4,'jay','ajinky nivas','new building','kolhapur','pune',21,'gst456789','lahfiahsk','8969698732','admin',NULL,'admin',NULL,'admin','2017-12-09 16:36:11.000000',1),(8,4,4,'jay','sambhaji chowk','vihar building101','mumbai','pune',21,'gfd557','kgkhb','9867968756','admin',NULL,'admin',NULL,'admin','2017-12-09 16:36:07.000000',1),(9,2,2,'dipak','ajab vihar colony','building245','sambhaji nagar','pune',20,'ghdf5688','bbbbbb','46536','admin',NULL,'admin',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `tbl_contractor_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_create_indent`
--

DROP TABLE IF EXISTS `tbl_create_indent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_create_indent` (
  `indent_id` int(11) NOT NULL AUTO_INCREMENT,
  `indent_code` varchar(45) DEFAULT NULL,
  `indent_date` date DEFAULT NULL,
  `project_name` varchar(45) DEFAULT NULL,
  `manager_name` varchar(45) DEFAULT NULL,
  `indent_type` varchar(45) DEFAULT NULL,
  `activity_name` varchar(45) DEFAULT NULL,
  `contractor_name` varchar(45) DEFAULT NULL,
  `site_location` varchar(45) DEFAULT NULL,
  `indent_by` varchar(45) DEFAULT NULL,
  `approved_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `approved_quantity` int(11) DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`indent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_create_indent`
--

LOCK TABLES `tbl_create_indent` WRITE;
/*!40000 ALTER TABLE `tbl_create_indent` DISABLE KEYS */;
INSERT INTO `tbl_create_indent` VALUES (1,'I002','2017-10-10','emco','amar','intenel','repair tower','anuj','pune',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_create_indent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_master`
--

DROP TABLE IF EXISTS `tbl_customer_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customer_master` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(45) DEFAULT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `phone_no` varchar(45) DEFAULT NULL,
  `fax_no` varchar(45) DEFAULT NULL,
  `contact_person` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `email_id` varchar(45) DEFAULT NULL,
  `pan_no` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `gst_no` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_master`
--

LOCK TABLES `tbl_customer_master` WRITE;
/*!40000 ALTER TABLE `tbl_customer_master` DISABLE KEYS */;
INSERT INTO `tbl_customer_master` VALUES (1,'C0001','emco1','viman nagar','sgsdg','sgddgd','234546','324235545','dinesh','2436','dinesh@g.c','dd434546','admin','2017-11-25 15:58:55','admin',NULL,'admin','2017-11-25 15:59:11',0,'pune',21,'gst55673'),(2,'C0002','emco10','ameerpet','sgsg','sgsg','2356789','2561346','Sanjay','234578','sanjay@emco.com','S234657','admin','2017-11-27 15:36:08','admin',NULL,NULL,NULL,0,'Hyderabad',32,'CGST12'),(3,'C0003','AVP','Pune','sdg','sg','131','546546','Amit','9762184145','a@localhost.com','APK4546L','admin','2017-11-28 09:51:24','admin',NULL,NULL,NULL,0,'Pune',21,'1542005'),(4,'C0004','vilas','new colony','sambhaji chowk','nigdi','123467852','23242355555','amar','7547586987','amar@gmail.com','hsdr678','admin','2017-12-09 16:14:11','admin',NULL,NULL,NULL,0,'mumbai',21,'fg5676');
/*!40000 ALTER TABLE `tbl_customer_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_gate_entry`
--

DROP TABLE IF EXISTS `tbl_gate_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_gate_entry` (
  `gate_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_id` int(11) DEFAULT '1',
  `reference_number` varchar(45) DEFAULT NULL,
  `gate_entry_type` varchar(45) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `gate_entry_code` varchar(20) DEFAULT NULL,
  `gate_entry_date` date DEFAULT NULL,
  `transporter_name` varchar(45) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `time_in` datetime DEFAULT CURRENT_TIMESTAMP,
  `time_out` datetime DEFAULT NULL,
  `vehicle_no` varchar(45) DEFAULT NULL,
  `challan_no` varchar(25) DEFAULT NULL,
  `lr_no` varchar(25) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `mrr_status` varchar(45) DEFAULT 'active',
  PRIMARY KEY (`gate_entry_id`),
  KEY `two_idx` (`created_by`),
  KEY `three_idx` (`updated_by`),
  KEY `four_idx` (`deleted_by`),
  KEY `one_idx` (`project_id`),
  KEY `five_idx` (`store_id`),
  KEY `six_idx` (`contractor_id`),
  CONSTRAINT `five` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `four` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `one` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `six` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `three` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `two` FOREIGN KEY (`created_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_gate_entry`
--

LOCK TABLES `tbl_gate_entry` WRITE;
/*!40000 ALTER TABLE `tbl_gate_entry` DISABLE KEYS */;
INSERT INTO `tbl_gate_entry` VALUES (18,1,NULL,NULL,NULL,2,2,'G011217-13','2017-12-01','ABCD','Customer Stock','2017-12-01 10:57:39',NULL,'MH-11 BG 5765','1','1','admin','2017-12-01 10:57:39',NULL,NULL,NULL,NULL,0,'active'),(20,1,NULL,NULL,NULL,1,2,'G011217-15','2017-12-01','hgfh','Emco Stock','2017-12-01 14:13:01',NULL,'5657','76756','56765','admin','2017-12-01 14:13:01',NULL,NULL,NULL,NULL,0,'active'),(22,1,NULL,NULL,NULL,1,1,'G021217-16','2017-12-02','ABCD','Customer Stock','2017-12-02 11:56:49',NULL,'dfd','gdg','6547','admin','2017-12-02 11:56:49',NULL,NULL,NULL,NULL,0,'active'),(23,1,'MI011217-7','1',1,1,1,'G021217-17','2017-12-02','hgfh','Customer Stock','2017-12-02 12:08:43',NULL,'MH-11 BG 5765','1','dfhgtrs','admin','2017-12-02 12:08:43',NULL,NULL,NULL,NULL,0,'active'),(24,1,'101','3',1,1,2,'G071217-18','2017-12-07','onkar','','2017-12-07 18:50:01',NULL,'MH-11 BG 5723','123','23','admin','2017-12-07 18:50:01',NULL,NULL,NULL,NULL,0,'active'),(25,1,'101','3',1,1,2,'G081217-19','2017-12-08','qwerty','','2017-12-08 12:49:34',NULL,'65','66','666','admin','2017-12-08 12:49:34',NULL,NULL,NULL,NULL,0,'active'),(26,1,'MI011217-7','1',9,3,1,'G121217-20','2017-12-12','karan','','2017-12-12 10:24:40',NULL,'MH11-BG-3333','3435','4545','admin','2017-12-12 10:24:40',NULL,NULL,NULL,NULL,0,'active'),(27,1,'','4',5,6,2,'G121217-21','2017-12-12','tarun','','2017-12-12 10:25:37',NULL,'MH-11 BG 5723','767','457','admin','2017-12-12 10:25:37',NULL,NULL,NULL,NULL,0,'active'),(28,1,'','4',5,6,2,'G121217-21','2017-12-12','tarun','','2017-12-12 10:26:48',NULL,'MH-11 BG 5723','767','457','admin','2017-12-12 10:26:48',NULL,NULL,NULL,NULL,0,'active'),(31,1,'MI011217-6','1',4,1,1,'G141217-22','2017-12-14','ajit','','2017-12-14 11:52:02',NULL,'dsg46','sgdds','436','admin','2017-12-14 11:52:02',NULL,NULL,NULL,NULL,0,'active');
/*!40000 ALTER TABLE `tbl_gate_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_gate_entry_material`
--

DROP TABLE IF EXISTS `tbl_gate_entry_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_gate_entry_material` (
  `tbl_gate_entry_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `gate_entry_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `material_description` varchar(45) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `unitprice` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`tbl_gate_entry_material_id`),
  KEY `gateentry_idx` (`gate_entry_id`),
  CONSTRAINT `gateentry` FOREIGN KEY (`gate_entry_id`) REFERENCES `tbl_gate_entry` (`gate_entry_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_gate_entry_material`
--

LOCK TABLES `tbl_gate_entry_material` WRITE;
/*!40000 ALTER TABLE `tbl_gate_entry_material` DISABLE KEYS */;
INSERT INTO `tbl_gate_entry_material` VALUES (25,18,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(26,18,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',4,'52908'),(27,20,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',1,'4500'),(28,20,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',1,'3000'),(30,23,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',3,'4500'),(31,23,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',3,'3000'),(32,24,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(33,24,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',4,'52908'),(34,25,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(35,25,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',4,'52908'),(36,26,7,'PSSSETCHRWSTRAIN00','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',3,'4500'),(37,26,8,'PSSSCVLFOUNDLTFEDR','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ',3,'3000');
/*!40000 ALTER TABLE `tbl_gate_entry_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_material_consumption`
--

DROP TABLE IF EXISTS `tbl_material_consumption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_material_consumption` (
  `material_consumption_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(45) DEFAULT NULL,
  `issued_qty` bigint(20) DEFAULT NULL,
  `consumed_qty` bigint(20) DEFAULT NULL,
  `remaining_qty` bigint(20) DEFAULT NULL,
  `material_consumption_header_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`material_consumption_id`),
  KEY `material_consumption_header_id_tbl_material_consumption_idx` (`material_consumption_header_id`),
  CONSTRAINT `material_consumption_header_id_tbl_material_consumption` FOREIGN KEY (`material_consumption_header_id`) REFERENCES `tbl_material_consumption_header` (`material_consumption_header_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_material_consumption`
--

LOCK TABLES `tbl_material_consumption` WRITE;
/*!40000 ALTER TABLE `tbl_material_consumption` DISABLE KEYS */;
INSERT INTO `tbl_material_consumption` VALUES (1,'Cement',100,80,20,2),(3,'Cement',100,80,20,3),(4,'Cement',100,80,20,4),(5,'Cement',100,80,20,5),(6,'Cement',100,80,20,6),(7,'abc',5,1,1,10),(8,'abc',-1,-1,-1,11),(9,'abc',1,1,1,12),(10,'copper cable',5,2,3,12),(11,'Cement',100,80,20,13),(12,'Cement',100,80,20,14),(13,'abc',20,10,10,14),(14,'abc',-1,-1,-1,15),(15,'sadfg',1,1,1,15);
/*!40000 ALTER TABLE `tbl_material_consumption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_material_consumption_header`
--

DROP TABLE IF EXISTS `tbl_material_consumption_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_material_consumption_header` (
  `material_consumption_header_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_consumption_code` varchar(45) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `indent_id` int(11) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`material_consumption_header_id`),
  KEY `project_id_material_consumption_header_idx` (`project_id`),
  KEY `store_id1_idx` (`store_id`),
  KEY `indent_id1_idx` (`indent_id`),
  KEY `contr_id1_idx` (`contractor_id`),
  CONSTRAINT `contr_id1` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `indent_id1` FOREIGN KEY (`indent_id`) REFERENCES `indent_head` (`indent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `project_id_material_consumption_header` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `store_id1` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_material_consumption_header`
--

LOCK TABLES `tbl_material_consumption_header` WRITE;
/*!40000 ALTER TABLE `tbl_material_consumption_header` DISABLE KEYS */;
INSERT INTO `tbl_material_consumption_header` VALUES (1,'MC021217-1',2,1,NULL,3,'Emco Stock'),(2,'MC021217-2',2,1,NULL,4,'Emco Stock'),(3,'MI041217-11',2,2,46,3,'Customer Stock'),(4,'MI041217-11',2,2,42,1,'Emco Stock'),(5,'MC111217-12',2,2,54,4,'Emco Stock'),(6,'MC111217-13',1,1,56,4,'Emco Stock'),(7,'MC131217-14',6,13,54,4,'Customer Stock'),(8,'MC131217-15',1,1,43,3,'Emco Stock'),(9,'MC131217-16',1,1,54,4,'Emco Stock'),(10,'MC131217-17',1,1,42,1,'Emco Stock'),(11,'MC131217-18',1,1,42,1,'Emco Stock'),(12,'MC131217-19',1,1,54,4,'Emco Stock'),(13,'MC131217-20',1,1,54,6,'Emco Stock'),(14,'MC131217-21',1,14,42,4,'Emco Stock'),(15,'MC131217-22',1,1,74,1,'Emco Stock');
/*!40000 ALTER TABLE `tbl_material_consumption_header` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_material_master`
--

DROP TABLE IF EXISTS `tbl_material_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_material_master` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_code` varchar(45) DEFAULT NULL,
  `material_name` varchar(45) DEFAULT NULL,
  `material_description` varchar(45) DEFAULT NULL,
  `material_type` varchar(45) DEFAULT NULL,
  `unit_of_measurment` varchar(45) DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `min_quantity` int(11) DEFAULT NULL,
  `max_quantity` int(11) DEFAULT NULL,
  `expiry_status` varchar(3) DEFAULT NULL,
  `reorder_level` varchar(45) DEFAULT NULL,
  `reorder_quantity` double DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `approved_total_qty` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_material_master`
--

LOCK TABLES `tbl_material_master` WRITE;
/*!40000 ALTER TABLE `tbl_material_master` DISABLE KEYS */;
INSERT INTO `tbl_material_master` VALUES (1,'OSM material1','copper cable','tested','Local','centimeter',250,1,4,'Yes','220',200,'admin','2017-11-21 15:31:56','admin',NULL,NULL,NULL,0,'10'),(2,'M0002','steel pipe','clear','Local','ft1',1750,1,3,'No','32',250,'admin','2017-11-21 15:33:11','',NULL,'admin','2017-11-25 12:10:00',0,'12'),(3,'bought out material','cement','good','Local','kg',350,1,10,'Yes',NULL,NULL,'admin','2017-11-21 15:47:07','admin',NULL,NULL,NULL,0,'13'),(4,'M003','pipe','good product','Local','kg',504,2,3,'Yes','12',300,'admin','2017-11-23 19:17:35','',NULL,NULL,NULL,0,NULL),(5,'emco mfg','steel rod','good quality material','Local','ft',500,1,10,'Yes','100',300,'admin','2017-11-25 12:03:50','',NULL,'admin','2017-12-04 14:32:53',1,NULL),(6,'steel structure','steel pipe','tested heavy pipe','Imported','meter',4000,1,15,'No',NULL,NULL,'admin','2017-11-27 15:38:46','admin',NULL,'','2017-12-04 14:30:43',1,NULL),(7,'PSSSETCHRWSTRAIN00','Material 1','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR','Imported','meter',4500,1,15,'Yes',NULL,NULL,'admin','2017-11-27 15:38:46',NULL,NULL,NULL,NULL,NULL,NULL),(8,'PSSSCVLFOUNDLTFEDR','Material 2','CIVIL-Act-11/Est-35-ETC FOR 22/4.500KVA ','Imported','meter',3000,1,10,'Yes',NULL,NULL,'admin','2017-11-27 15:38:46',NULL,NULL,NULL,NULL,NULL,NULL),(9,'M0005','sand','good quality','Local','kg',500,1,3,'Yes','220',20,'','2017-12-04 12:25:17','',NULL,'','2017-12-04 14:30:33',1,NULL),(10,'M008','pipe','heavy pipe','Imported','120',150,1,4,'Yes','344',400,'','2017-12-04 12:28:10','',NULL,'','2017-12-04 12:39:29',1,NULL),(11,'M006','sand','best quality','Local','kg',200,1,3,'No','123',120,'','2017-12-04 12:36:49',NULL,NULL,'','2017-12-04 12:39:22',1,NULL),(12,'M003','steel pipe','good product','Local','kg',503,1,3,'Yes','12',300,'','2017-12-04 14:14:06','',NULL,'','2017-12-04 14:30:27',1,NULL),(13,'M004','steel pipe','good','Imported','kg',220,1,4,'Yes','dsd23',220,'','2017-12-04 14:34:20','',NULL,NULL,NULL,0,NULL),(14,'M007','sand','good quality','Local','kg',220,1,6,'Yes','sa23',22,'','2017-12-04 14:48:15','admin',NULL,NULL,NULL,0,NULL),(15,'rush','abc','fff','Local','kg',250,1,3,'Yes',NULL,NULL,'admin','2017-12-05 16:45:19',NULL,NULL,NULL,NULL,0,NULL),(16,'M00010','sdg','sdg','Local','kg',110,2,5,'Yes','ss2',120,'admin','2017-12-05 16:45:37',NULL,NULL,NULL,NULL,0,NULL),(17,'M0001','sadfg','gsdg','Local','gs',120,3,4,'Yes','hsj35',44,'admin','2017-12-05 17:00:38','admin',NULL,NULL,NULL,0,NULL),(18,'M-1/17-18','asd','fdf','Local','kg',120,2,5,'Yes','gdf5',65,'admin','2017-12-06 12:37:41',NULL,NULL,NULL,NULL,0,NULL),(19,'M-2/17-18','asf','fsdg','Local','kg',345,1,5,'Yes','s54',565,'admin','2017-12-06 13:16:11',NULL,NULL,NULL,NULL,0,NULL),(20,'M-3/17-18','steel rod','good quality','Imported','ft',120,1,5,'Yes','12',23,'admin','2017-12-06 15:08:29','admin',NULL,NULL,NULL,0,NULL),(21,'M-4/17-18','sa','gdaa','Local','hdh',565,1,3,'Yes','gf6',56,'admin','2017-12-06 16:02:30',NULL,NULL,NULL,NULL,0,NULL),(22,'M-5/17-18','Sand','good quality','Local','kg',152,5,10,'Yes','gh788',120,'admin','2017-12-11 17:38:15',NULL,NULL,NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `tbl_material_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_material_rejection`
--

DROP TABLE IF EXISTS `tbl_material_rejection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_material_rejection` (
  `material_id` int(10) DEFAULT NULL,
  `material_rejection_id` int(10) NOT NULL AUTO_INCREMENT,
  `material_rejection_code` varchar(45) DEFAULT NULL,
  `mrr_id` int(10) DEFAULT NULL,
  `gate_entry_id` int(10) DEFAULT NULL,
  `tbl_gate_entry_material_id` int(10) DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  `reason_for_rejection` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`material_rejection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_material_rejection`
--

LOCK TABLES `tbl_material_rejection` WRITE;
/*!40000 ALTER TABLE `tbl_material_rejection` DISABLE KEYS */;
INSERT INTO `tbl_material_rejection` VALUES (NULL,1,'REJ0NaN',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(NULL,2,'REJ0NaN',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(NULL,3,'REJ0NaN',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(NULL,4,'REJ0NaN',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(NULL,5,'REJ0NaN',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_material_rejection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mrr_head`
--

DROP TABLE IF EXISTS `tbl_mrr_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mrr_head` (
  `mrr_id` int(11) NOT NULL AUTO_INCREMENT,
  `mrr_code` varchar(45) DEFAULT NULL,
  `gate_entry_id` int(10) DEFAULT NULL,
  `mrr_date` date DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `supplier_name` varchar(45) DEFAULT NULL,
  `supplier_invoice_no` varchar(45) DEFAULT NULL,
  `location_of_despatch` varchar(45) DEFAULT NULL,
  `total_quantity` varchar(45) DEFAULT NULL,
  `total_rejected_quantity` varchar(45) DEFAULT NULL,
  `rejection_status` varchar(45) DEFAULT NULL,
  `remark` varchar(45) DEFAULT NULL,
  `active_status` int(10) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `material_rejection_code` varchar(45) DEFAULT NULL,
  `rejection_date` date DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mrr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mrr_head`
--

LOCK TABLES `tbl_mrr_head` WRITE;
/*!40000 ALTER TABLE `tbl_mrr_head` DISABLE KEYS */;
INSERT INTO `tbl_mrr_head` VALUES (1,'MRR0001',18,'2017-12-09','Customer Stock','satish','S12345','location2','12','5','return','ok',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0001','2017-12-09',NULL),(2,'MRR0002',20,'2017-12-09','Emco Stock','sanjay','s556','loc5','2','0','return','hh',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0002','2017-12-12',NULL),(4,'MRR0003',23,'2017-12-09','Emco Stock','jay','45545','loc4','6','1','return','gg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0003','2017-12-11',NULL),(5,'MRR0004',25,'2017-12-09','Customer Stock','asfsfa','gsd','sdg','12','5','return','sdg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0004','2017-12-21',NULL),(6,'MRR0005',24,'2017-12-11','T&P Stock','saurah','234567','location9','12','5','return','ok',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0005','2017-12-11',NULL),(7,'MRR0006',23,'2017-12-11','T&P Stock','jayesh','34556','loc4','6','1','return','gh',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0006','2017-12-11',NULL),(8,'MRR0007',24,'2017-12-11','Customer Stock','mukesh','123456','location10','12','4','return','hh',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0007','2017-12-11',NULL),(9,'MRR0008',25,'2017-12-11','T&P Stock','deva','45667','loc44','12','4','return','vv',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0008','2017-12-11',NULL),(10,'MRR0009',18,'2017-12-11','OSM Stock','sam','667','loc66','12','4','return','hh',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0009','2017-12-11',NULL),(11,'MRR0010',18,'2017-12-12','T&P Stock','hari','45467','loc34','12','5','return','hy',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'REJ0010','2017-12-13',NULL);
/*!40000 ALTER TABLE `tbl_mrr_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mrr_material`
--

DROP TABLE IF EXISTS `tbl_mrr_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mrr_material` (
  `mrr_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `mrr_id` int(10) DEFAULT NULL,
  `gate_entry_id` int(10) DEFAULT NULL,
  `tbl_gate_entry_material_id` int(10) DEFAULT NULL,
  `accepted_quantity` varchar(45) DEFAULT NULL,
  `rejected_quantity` varchar(45) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `reason_for_rejection` varchar(45) DEFAULT NULL,
  `material_rejection_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`mrr_material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mrr_material`
--

LOCK TABLES `tbl_mrr_material` WRITE;
/*!40000 ALTER TABLE `tbl_mrr_material` DISABLE KEYS */;
INSERT INTO `tbl_mrr_material` VALUES (1,1,1,25,'5','3','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ert',NULL),(2,1,1,26,'2','2','2017-12-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ert',NULL),(3,2,19,27,'1','0','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d',NULL),(4,2,19,28,'1','0','2017-12-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d',NULL),(5,3,21,30,'2','1','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hh',NULL),(6,3,21,31,'3','0','2017-12-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hh',NULL),(7,4,24,30,'2','1','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'f',NULL),(8,4,24,31,'3','0','2017-12-23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'f',NULL),(9,5,24,34,'5','3','2017-12-26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sa',NULL),(10,5,24,35,'2','2','2017-12-28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'sa',NULL),(11,6,26,32,'5','3','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hh',NULL),(12,6,26,33,'2','2','2017-12-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hh',NULL),(13,7,26,30,'2','1','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'gg',NULL),(14,7,26,31,'3','0','2017-12-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'gg',NULL),(15,8,26,32,'5','3','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'quality prob',NULL),(16,8,26,33,'3','1','2017-12-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'quality prob',NULL),(17,9,26,34,'5','3','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ss',NULL),(18,9,26,35,'3','1','2017-12-28',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'ss',NULL),(19,11,26,25,'5','3','2017-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'j',NULL),(20,11,26,26,'2','2','2017-12-13',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'j',NULL);
/*!40000 ALTER TABLE `tbl_mrr_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mtn_head`
--

DROP TABLE IF EXISTS `tbl_mtn_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mtn_head` (
  `mtn_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_code` varchar(45) DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `transfer_type` varchar(45) DEFAULT NULL,
  `s_project_id` varchar(45) DEFAULT NULL,
  `s_store_id` varchar(45) DEFAULT NULL,
  `s_contractor_id` varchar(45) DEFAULT NULL,
  `d_project_id` varchar(45) DEFAULT NULL,
  `d_store_id` varchar(45) DEFAULT NULL,
  `d_contractor_id` varchar(45) DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `store_inventory_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`mtn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mtn_head`
--

LOCK TABLES `tbl_mtn_head` WRITE;
/*!40000 ALTER TABLE `tbl_mtn_head` DISABLE KEYS */;
INSERT INTO `tbl_mtn_head` VALUES (1,'MTN0001','2017-12-12','Store to Store','6','2','','3','1','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'MTN0002','2017-12-12','Store to Store','6','2','','5','3','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'MTN0002','2017-12-12','Store to Store','6','2','','5','3','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'MTN0003','2017-12-12','Project to Project','2','1','','4','13','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'MTN0004','2017-12-12','Contractor To Contractor','6','2','2','3','1','6','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'MTN0005','2017-12-12','Project to Project','4','2','','5','13','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'MTN0006','2017-12-12','Contractor To Contractor','1','2','2','4','15','9','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'MTN0007','2017-12-12','Contractor To Contractor','1','2','2','4','1','3','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'MTN0008','2017-12-12','Store to Store','2','2','','5','3','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'MTN0009','2017-12-12','Contractor To Contractor','6','2','2','3','1','3','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'MTN0010','2017-12-12','Contractor To Contractor','4','2','2','6','22','9','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'MTN0011','2017-12-12','Contractor To Contractor','4','2','2','3','15','1','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'MTN0012','2017-12-12','Store to Store','4','2','','2','1','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'MTN0013','2017-12-13','Store to Store','2','1','','3','15','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'MTN0013','2017-12-13','Store to Store','2','1','','3','15','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'MTN0013','2017-12-13','Store to Store','2','1','','3','15','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'MTN0013','2017-12-13','Store to Store','2','1','','3','15','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'MTN0014','2017-12-13','Project to Project','2','1','','4','2','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,'MTN0014','2017-12-13','Project to Project','2','1','','4','2','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'MTN0015','2017-12-13','Store to Store','4','2','','2','1','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'MTN0015','2017-12-13','Store to Store','4','2','','2','1','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'MTN0016','2017-12-13','Store to Store','2','1','','3','3','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(23,'MTN0017','2017-12-13','Contractor To Contractor','4','2','2','6','22','5','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,'MTN0018','2017-12-13','Contractor To Contractor','4','2','2','3','3','5','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,'MTN0019','2017-12-13','Project to Project','2','1','','3','3','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,'MTN0020','2017-12-13','Store to Store','2','1','','4','13','','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_mtn_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mtn_material`
--

DROP TABLE IF EXISTS `tbl_mtn_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mtn_material` (
  `mtn_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `mtn_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `transfer_quantity` varchar(45) DEFAULT NULL,
  `remark` varchar(45) DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  `issued_quantity` varchar(45) DEFAULT NULL,
  `store_inventory_id` varchar(11) DEFAULT NULL,
  `contractor_inventory_id` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`mtn_material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mtn_material`
--

LOCK TABLES `tbl_mtn_material` WRITE;
/*!40000 ALTER TABLE `tbl_mtn_material` DISABLE KEYS */;
INSERT INTO `tbl_mtn_material` VALUES (1,2,8,'1','jk',NULL,NULL,'4','blank'),(2,4,7,'4','gg',NULL,NULL,'1','blank'),(3,4,8,'2','hh',NULL,NULL,'2','blank'),(4,5,6,'2','fg',NULL,NULL,'blank','12'),(5,5,6,'1','hj',NULL,NULL,'blank','13'),(6,6,6,'3','gh',NULL,NULL,'3','null'),(7,6,8,'1','jk',NULL,NULL,'4','null'),(8,7,6,'3','gh',NULL,NULL,'null','12'),(9,7,6,'2','jj',NULL,NULL,'null','13'),(10,8,6,'3','hh',NULL,NULL,'null','12'),(11,8,6,'1','jj',NULL,NULL,'null','13'),(12,9,6,'3','ff',NULL,NULL,'3','null'),(13,9,8,'1','ght',NULL,NULL,'4','null'),(14,10,6,'3','fert',NULL,NULL,'','12'),(15,10,6,'2','derw',NULL,NULL,'','13'),(16,11,6,'3','f',NULL,NULL,'','12'),(17,11,6,'2','g',NULL,NULL,'','13'),(18,22,7,'3','fg',NULL,NULL,NULL,NULL),(19,22,8,'1','hh',NULL,NULL,NULL,NULL),(20,23,6,'1','fg',NULL,NULL,NULL,NULL),(21,23,6,'1','hh',NULL,NULL,NULL,NULL),(22,24,6,'4','gh',NULL,NULL,NULL,NULL),(23,24,6,'1','jj',NULL,NULL,NULL,NULL),(24,25,7,'1','fg',NULL,NULL,NULL,NULL),(25,25,8,'1','hh',NULL,NULL,NULL,NULL),(26,26,7,'3','fg',NULL,NULL,NULL,NULL),(27,26,8,'4','hh',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_mtn_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_project_master`
--

DROP TABLE IF EXISTS `tbl_project_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_project_master` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_code` varchar(45) DEFAULT NULL,
  `project_name` varchar(45) DEFAULT NULL,
  `project_location` varchar(45) DEFAULT NULL,
  `manager_name` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `email_id` varchar(45) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `wbs` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_master`
--

LOCK TABLES `tbl_project_master` WRITE;
/*!40000 ALTER TABLE `tbl_project_master` DISABLE KEYS */;
INSERT INTO `tbl_project_master` VALUES (1,'P0001','emco0','ground','amit','897777','asd@g.c','mumbai',NULL,NULL,'mumbai',21,'2017-10-01','2017-11-30','tu','admin','2017-11-21 15:18:41','admin',NULL,'admin','2017-11-25 16:04:27','0'),(2,'P0002','emco5','feez','sunil','34567','sunil@emco.com','ram nagar',NULL,NULL,'hyderabad',32,'2017-09-03','2018-01-26','bhu','','2017-11-25 15:17:10','',NULL,'','2017-11-25 15:29:56','0'),(3,'P0003','emco77','on site','sandip','34776768','sandip@e.c','keshav nagar',NULL,NULL,'kanpur',34,'2017-10-02','2017-12-07','ghg','','2017-11-25 15:43:49','admin',NULL,'','2017-11-25 15:44:16','0'),(4,'P0004','emco56','hyd','ajay','56778','as@g.c','ammerpeth',NULL,NULL,'hyd',32,'2017-12-01','2018-02-28','198.161.1.11','admin','2017-12-08 16:43:32','admin',NULL,NULL,NULL,'0'),(5,'P0005','emco990','loc1','ramesh','3453656667','asas@d.c','abc road','vijay nagar','chinchwad','pune',21,'2017-10-01','2018-01-06','dgf','admin','2017-12-09 16:11:29','admin',NULL,NULL,NULL,'0'),(6,'P0006','emco10','loc2','abhay','2134214532','abhay.s@gmail.com','new colony','veer savarkar road','pimpri','pune',21,'2017-12-13','2017-12-28','sdad','admin','2017-12-11 17:35:56',NULL,NULL,NULL,NULL,'0');
/*!40000 ALTER TABLE `tbl_project_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_securitygroups`
--

DROP TABLE IF EXISTS `tbl_securitygroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_securitygroups` (
  `secroleid` int(11) DEFAULT NULL,
  `tokenid` int(11) DEFAULT NULL,
  KEY `secroleid_idx` (`secroleid`,`tokenid`),
  KEY `tokenid_idx` (`tokenid`),
  CONSTRAINT `secroleid` FOREIGN KEY (`secroleid`) REFERENCES `tbl_securityroles` (`secroleid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tokenid` FOREIGN KEY (`tokenid`) REFERENCES `tbl_securitytokens` (`tokenid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_securitygroups`
--

LOCK TABLES `tbl_securitygroups` WRITE;
/*!40000 ALTER TABLE `tbl_securitygroups` DISABLE KEYS */;
INSERT INTO `tbl_securitygroups` VALUES (1,0),(1,1),(1,2);
/*!40000 ALTER TABLE `tbl_securitygroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_securityroles`
--

DROP TABLE IF EXISTS `tbl_securityroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_securityroles` (
  `secroleid` int(11) NOT NULL AUTO_INCREMENT,
  `secrolename` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`secroleid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_securityroles`
--

LOCK TABLES `tbl_securityroles` WRITE;
/*!40000 ALTER TABLE `tbl_securityroles` DISABLE KEYS */;
INSERT INTO `tbl_securityroles` VALUES (1,'BSC'),(2,'BSC-Dev'),(4,'Tarun'),(5,'Tarun'),(6,'PAtidar'),(7,'TP'),(8,'Tar'),(9,'xhnc'),(10,'sss'),(11,'gfdg'),(12,'fff'),(13,'hhh'),(14,'dfjd'),(15,'Amit'),(16,'AM');
/*!40000 ALTER TABLE `tbl_securityroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_securitytokens`
--

DROP TABLE IF EXISTS `tbl_securitytokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_securitytokens` (
  `tokenid` int(11) NOT NULL,
  `tokenname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tokenid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_securitytokens`
--

LOCK TABLES `tbl_securitytokens` WRITE;
/*!40000 ALTER TABLE `tbl_securitytokens` DISABLE KEYS */;
INSERT INTO `tbl_securitytokens` VALUES (0,'Master Data'),(1,'Inventory'),(2,'Indent'),(3,'Gate Entry'),(4,'Material Receipt Report'),(5,'Material Rejection'),(6,'Material Issue'),(7,'Material Transfer Note'),(8,'Material Return'),(9,'Reports');
/*!40000 ALTER TABLE `tbl_securitytokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_site_master`
--

DROP TABLE IF EXISTS `tbl_site_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_site_master` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `site_name` varchar(45) DEFAULT NULL,
  `site_location` varchar(45) DEFAULT NULL,
  `site_engineer_name` varchar(45) DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_site_master`
--

LOCK TABLES `tbl_site_master` WRITE;
/*!40000 ALTER TABLE `tbl_site_master` DISABLE KEYS */;
INSERT INTO `tbl_site_master` VALUES (1,1,'emco godo','pune','sanjay',0,'admin',NULL,'admin',NULL,NULL,NULL),(2,2,'emcowh','mumbai','jayesh',0,'admin',NULL,'admin',NULL,NULL,NULL),(3,3,'emco office','hyderabad','sachin',0,'admin',NULL,NULL,NULL,NULL,NULL),(4,2,'warehouse','chennai','gaurav',0,'admin','2017-11-23 14:54:31',NULL,NULL,NULL,NULL),(5,2,'university','surat','harish',0,'admin','2017-11-23 19:21:28','admin',NULL,NULL,NULL),(6,4,'site1','hyd1','vijay',0,'admin','2017-12-08 16:44:28',NULL,NULL,NULL,NULL),(7,4,'site3','hyd2','jay',0,'admin','2017-12-08 16:45:00','admin',NULL,NULL,NULL),(8,1,'ABC Plaza','Pune','Ramesh Kale',1,'admin','2017-12-14 17:04:48',NULL,NULL,'admin','2017-12-14 17:04:52.000000');
/*!40000 ALTER TABLE `tbl_site_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_state_master`
--

DROP TABLE IF EXISTS `tbl_state_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_state_master` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `active_status` int(11) DEFAULT '0',
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `state_name_UNIQUE` (`state_name`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `tbl_state_master_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_state_master_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_state_master_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_user_master` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_state_master`
--

LOCK TABLES `tbl_state_master` WRITE;
/*!40000 ALTER TABLE `tbl_state_master` DISABLE KEYS */;
INSERT INTO `tbl_state_master` VALUES (1,'Andaman and Nico.In.','',0,'admin','2017-08-31 06:45:33',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(2,'Andra Pradesh','',0,'admin','2017-08-31 06:45:51',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(3,'Arunachal Pradesh','',0,'admin','2017-08-31 06:46:00',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(4,'Assam','',0,'admin','2017-08-31 06:46:08',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(5,'Bihar','',0,'admin','2017-08-31 06:46:15',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(6,'Chandigarh','',0,'admin','2017-08-31 06:46:23',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(7,'Chhaattisgarh','',0,'admin','2017-08-31 06:46:31',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(8,'Dadra and Nagar Hav.','',0,'admin','2017-08-31 06:46:39',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(9,'Daman and Diu','',0,'admin','2017-08-31 06:46:47',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(10,'Delhi','',0,'admin','2017-08-31 06:46:53',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(11,'Goa','',0,'admin','2017-08-31 06:47:02',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(12,'Gujarat','',0,'admin','2017-08-31 06:47:09',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(13,'Haryana','',0,'admin','2017-08-31 06:47:16',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(14,'Himachal Pradesh','',0,'admin','2017-08-31 06:47:23',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(15,'Jammu and Kashmir','',0,'admin','2017-08-31 06:47:39',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(16,'Jharkhand','',0,'admin','2017-08-31 06:47:46',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(17,'Karnataka','',0,'admin','2017-08-31 06:47:52',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(18,'Kerala','',0,'admin','2017-08-31 06:47:59',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(19,'Lakshadweep','',0,'admin','2017-08-31 06:48:06',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(20,'Madhya Pradesh','',0,'admin','2017-08-31 06:48:12',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(21,'Maharashtra','',0,'admin','2017-08-31 06:48:19',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(22,'Manipur','',0,'admin','2017-08-31 06:48:26',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(23,'Megalaya','',0,'admin','2017-08-31 06:48:33',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(24,'Mizoram','',0,'admin','2017-08-31 06:48:39',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(25,'Nagaland','',0,'admin','2017-08-31 06:48:47',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(26,'Orissa','',0,'admin','2017-08-31 06:48:55',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(27,'Pondicherry','',0,'admin','2017-08-31 06:49:02',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(28,'Punjab','',0,'admin','2017-08-31 06:49:08',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(29,'Rajasthan','',0,'admin','2017-08-31 06:49:15',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(30,'Sikkim','',0,'admin','2017-08-31 06:49:23',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(31,'Tamil Nadu','',0,'admin','2017-08-31 06:49:34',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(32,'Telangana','',0,'admin','2017-08-31 06:49:41',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(33,'Tripura','',0,'admin','2017-08-31 06:49:47',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(34,'Uttar Pradesh','',0,'admin','2017-08-31 06:49:54',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(35,'Uttaranchal','',0,'admin','2017-08-31 06:50:08',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00'),(36,'West Bengal','',0,'admin','2017-08-31 06:50:15',NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tbl_state_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_storage_location_master`
--

DROP TABLE IF EXISTS `tbl_storage_location_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_storage_location_master` (
  `storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `storage_location_code` varchar(45) DEFAULT NULL,
  `storage_location_name` varchar(45) DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`storage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_storage_location_master`
--

LOCK TABLES `tbl_storage_location_master` WRITE;
/*!40000 ALTER TABLE `tbl_storage_location_master` DISABLE KEYS */;
INSERT INTO `tbl_storage_location_master` VALUES (1,1,1,'S001','pune',1,NULL,NULL,NULL,NULL,'2017-12-02 12:20:33','admin'),(2,2,3,'S002','mumbai',1,NULL,'',NULL,NULL,'2017-12-02 12:11:01','admin'),(3,3,3,'S003','Nashik',1,NULL,'',NULL,NULL,'2017-12-02 12:10:58','admin'),(4,3,4,'S004','Nashik',1,NULL,'',NULL,NULL,'2017-12-02 12:10:55','admin'),(5,4,5,'S006','nagpur',1,NULL,'admin',NULL,'admin','2017-12-02 11:47:32','admin'),(6,2,2,'S009','delhi',0,NULL,'admin',NULL,NULL,NULL,NULL),(7,2,14,'S01','kalyan',1,NULL,'admin',NULL,'admin','2017-12-02 12:20:37','admin'),(8,1,15,'S003','solapur',1,NULL,'admin',NULL,'admin','2017-12-02 12:19:17','admin'),(9,1,14,'S006','delhi',0,NULL,'admin',NULL,'admin',NULL,NULL),(10,3,15,'S005','karad',0,NULL,'admin',NULL,'admin',NULL,NULL),(11,2,13,'S009','hydrabad',0,NULL,'admin',NULL,NULL,NULL,NULL),(12,4,3,'001','hyd loc1',0,NULL,'admin',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_storage_location_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_store_inventory`
--

DROP TABLE IF EXISTS `tbl_store_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store_inventory` (
  `store_inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `contractor_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `store_location_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `accepted_quantity` int(11) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  `remaining_qty` int(11) DEFAULT NULL,
  `consumed_qty` int(11) DEFAULT NULL,
  `return_qty` int(11) DEFAULT NULL,
  `scrap_qty` double DEFAULT NULL,
  `damaged_qty` double DEFAULT NULL,
  `unused_qty` double DEFAULT NULL,
  `excess_qty` double DEFAULT NULL,
  PRIMARY KEY (`store_inventory_id`),
  KEY `storeID_idx` (`store_id`),
  KEY `projectID_idx` (`project_id`),
  KEY `materialIDD_idx` (`material_id`),
  KEY `con_idx` (`contractor_id`),
  CONSTRAINT `con` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `materialIDD` FOREIGN KEY (`material_id`) REFERENCES `tbl_material_master` (`material_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projectID` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `storeID` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_inventory`
--

LOCK TABLES `tbl_store_inventory` WRITE;
/*!40000 ALTER TABLE `tbl_store_inventory` DISABLE KEYS */;
INSERT INTO `tbl_store_inventory` VALUES (1,1,1,7,'Customer Stock',NULL,1,'PSSSETCHRWSTRAIN00',7,4,3,NULL,1,1,NULL,NULL,NULL),(2,1,1,8,'Customer Stock',NULL,1,'PSSSCVLFOUNDLTFEDR',2,4,3,NULL,2,NULL,NULL,NULL,NULL),(3,2,2,6,'Customer Stock',NULL,1,'steel structure',5,4,1,NULL,4,NULL,4,NULL,NULL),(4,2,2,8,'Customer Stock',NULL,1,'PSSSCVLFOUNDLTFEDR',3,2,1,NULL,NULL,NULL,NULL,NULL,NULL),(5,2,NULL,NULL,'T&P Stock',NULL,2,NULL,5,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL),(6,2,NULL,NULL,'T&P Stock',NULL,2,NULL,2,NULL,2,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_store_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_store_master`
--

DROP TABLE IF EXISTS `tbl_store_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store_master` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `store_address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `store_name` varchar(45) DEFAULT NULL,
  `store_location` varchar(45) DEFAULT NULL,
  `store_supervisor_name` varchar(45) DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_master`
--

LOCK TABLES `tbl_store_master` WRITE;
/*!40000 ALTER TABLE `tbl_store_master` DISABLE KEYS */;
INSERT INTO `tbl_store_master` VALUES (1,2,'chennai',NULL,NULL,'super market','location 1','dinesh',1,'pune',23,'admin','2017-11-23 15:27:18',NULL,NULL,'admin','2017-12-02 10:22:54.000000'),(2,4,'dubai','building2','building34','rohit shop','location5','juber',0,'mumbai',24,'admin','2017-11-23 15:27:51','admin',NULL,NULL,NULL),(3,3,'mumbai',NULL,NULL,'store1','warehouse1','sunil',0,NULL,NULL,'admin','2017-11-23 15:28:31',NULL,NULL,NULL,NULL),(13,4,'neharu chowk','building1','plot no-23/building-3','om jay jagdish','mumbai','rohan',0,'Yavatmal',5,'admin','2017-11-25 13:18:52','admin',NULL,NULL,NULL),(14,1,'sambhaji chowk','building4','plot n-9/sector-A2','amol shop','mumbai','donlad',0,'pune',21,'admin','2017-11-25 16:03:19','admin',NULL,NULL,NULL),(15,3,'sambhaji nagar','buliding2','plot no-5/sector-B4','jaydeep shop','shnati chowk','anil',0,'pune',21,'admin','2017-12-01 18:54:16','admin',NULL,NULL,NULL),(22,6,'new building 2','sambhaji road','pradhikaran','store2','loc66','ajit',0,'mumbai',21,'admin','2017-12-11 17:37:16',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_store_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_master`
--

DROP TABLE IF EXISTS `tbl_user_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_role` varchar(20) DEFAULT NULL,
  `user_fullname` varchar(60) DEFAULT NULL,
  `email_id` varchar(60) DEFAULT NULL,
  `mobile_number` int(11) DEFAULT NULL,
  `user_location` varchar(15) DEFAULT NULL,
  `user_status` int(2) NOT NULL DEFAULT '0',
  `master_data` int(11) DEFAULT NULL,
  `inventory` int(11) DEFAULT NULL,
  `indent` int(11) DEFAULT NULL,
  `gate_entry` int(11) DEFAULT NULL,
  `material_receipt_report` int(11) DEFAULT NULL,
  `material_rejection` int(11) DEFAULT NULL,
  `material_issue` int(11) DEFAULT NULL,
  `material_transfer_note` int(11) DEFAULT NULL,
  `material_return` int(11) DEFAULT NULL,
  `reports` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  KEY `tbl_typeofuse_master_ibfk_2_idx` (`user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_master`
--

LOCK TABLES `tbl_user_master` WRITE;
/*!40000 ALTER TABLE `tbl_user_master` DISABLE KEYS */;
INSERT INTO `tbl_user_master` VALUES (1,'admin','admin','admin','Developer BSC','admin@localhost.com',1,'Pune',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'BSC','bsc123','SE','bgthtbt','g@gmail.com',123456789,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'dfgdfhgdg','ffdgdvd','PM','fvdvd','g@gmail.com',213456789,NULL,0,0,1,0,1,1,0,1,0,0,1),(4,'vdfbr','hthg','Gate','fdgdfr','g@gmail.com',123456789,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_user_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_role`
--

DROP TABLE IF EXISTS `tbl_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user_role` (
  `user_role_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `active_status` int(2) DEFAULT '0',
  `created_by` varchar(50) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `master_data_access` int(11) DEFAULT NULL,
  `inventory_access` int(11) DEFAULT NULL,
  `indent_access` int(11) DEFAULT NULL,
  `tbl_user_rolecol` int(11) DEFAULT NULL,
  `gate_entry_access` int(11) DEFAULT NULL,
  `material_receipt_access` int(11) DEFAULT NULL,
  `material_rejection_access` int(11) DEFAULT NULL,
  `material_issue_access` int(11) DEFAULT NULL,
  `material_transfer_note_access` int(11) DEFAULT NULL,
  `material_return_access` int(11) DEFAULT NULL,
  `reports_access` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_role_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `tbl_user_role_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_user_role_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_user_role_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_user_master` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_role`
--

LOCK TABLES `tbl_user_role` WRITE;
/*!40000 ALTER TABLE `tbl_user_role` DISABLE KEYS */;
INSERT INTO `tbl_user_role` VALUES (1,'admin',NULL,0,'admin','2017-09-21 20:17:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'developer',NULL,1,'admin','2017-09-21 20:17:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'SE','Site Engineer',0,'admin','2017-09-22 20:17:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'PM','Project Manager',0,'admin','2017-10-04 10:46:30',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'Store','Store Supervioser',0,'admin','2017-10-04 10:47:55',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'Gate','Security',0,'admin','2017-10-04 10:47:55',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'fegege','egtrgr',0,NULL,'2017-12-13 18:13:45',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,0,1,1,0,1),(8,'BSC','Software',0,NULL,'2017-12-13 18:52:58',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,0,1,1,1,0),(9,'BSC-Dev','Developer',0,NULL,'2017-12-13 19:08:09',NULL,NULL,NULL,NULL,0,1,0,NULL,1,0,1,0,1,0,1),(11,'Tarun','jnkjnjk',0,NULL,'2017-12-13 19:33:18',NULL,NULL,NULL,NULL,1,0,1,NULL,0,1,0,1,0,1,1),(12,'Tarun','fndsjkfnwj',0,NULL,'2017-12-13 19:46:10',NULL,NULL,NULL,NULL,0,0,1,NULL,1,1,0,0,0,1,0),(13,'PAtidar','Patidar',0,NULL,'2017-12-14 11:01:23',NULL,NULL,NULL,NULL,1,0,1,NULL,0,1,0,0,1,1,0),(14,'TP','Patidar',0,NULL,'2017-12-14 11:14:42',NULL,NULL,NULL,NULL,1,0,0,NULL,0,1,0,0,0,1,0),(15,'tgt','tgt',0,NULL,'2017-12-14 11:53:02',NULL,NULL,NULL,NULL,1,0,1,NULL,1,0,1,0,1,0,1),(16,'Tar','Yat',0,NULL,'2017-12-14 12:05:26',NULL,NULL,NULL,NULL,1,0,1,NULL,1,0,0,0,1,0,1),(17,'xhnc','vfdvf',0,NULL,'2017-12-14 12:13:15',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,1,1,1,0,0),(18,'sss','sss',0,NULL,'2017-12-14 12:29:52',NULL,NULL,NULL,NULL,0,1,0,NULL,0,1,1,1,1,0,1),(19,'gfdg','fvfdvf',0,NULL,'2017-12-14 12:31:55',NULL,NULL,NULL,NULL,1,0,1,NULL,0,1,0,1,0,1,1),(20,'fff','fff',0,NULL,'2017-12-14 12:33:16',NULL,NULL,NULL,NULL,1,1,1,NULL,0,0,0,1,1,1,1),(21,'hhh','jjnjkn',0,NULL,'2017-12-14 12:44:26',NULL,NULL,NULL,NULL,1,0,1,NULL,0,0,0,1,1,1,0),(22,'ff','gg',0,NULL,'2017-12-14 12:49:06',NULL,NULL,NULL,NULL,1,1,0,NULL,0,0,0,1,0,1,1),(23,'dfjd','ddc',0,NULL,'2017-12-14 14:29:55',NULL,NULL,NULL,NULL,1,1,0,NULL,1,1,1,0,1,0,1),(24,'Amit','Amit',0,NULL,'2017-12-14 15:14:09',NULL,NULL,NULL,NULL,1,0,1,NULL,0,0,1,1,0,0,1),(25,'AM','am',0,NULL,'2017-12-14 16:54:46',NULL,NULL,NULL,NULL,1,0,1,NULL,0,1,0,1,0,1,0);
/*!40000 ALTER TABLE `tbl_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_vendor_master`
--

DROP TABLE IF EXISTS `tbl_vendor_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendor_master` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_code` varchar(45) DEFAULT NULL,
  `vendor_name` varchar(45) DEFAULT NULL,
  `vendor_sap_id` varchar(45) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `contact_person` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `email_id` varchar(45) DEFAULT NULL,
  `pan_details` varchar(45) DEFAULT NULL,
  `gst_no` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vendor_master`
--

LOCK TABLES `tbl_vendor_master` WRITE;
/*!40000 ALTER TABLE `tbl_vendor_master` DISABLE KEYS */;
INSERT INTO `tbl_vendor_master` VALUES (1,'V0001','samsung','1002','yog nagar',NULL,NULL,'surat',12,'suraj','23344','awsert@h.c','swerr','SGST28','admin',NULL,'admin',NULL,'admin','2017-11-25 16:01:48','0'),(2,'V0002','dell','46','viman nagar',NULL,NULL,'mumbai',21,'rahul','46334','hhfdh@gmail.com','35248','CGST25','admin',NULL,'admin',NULL,'','2017-11-25 15:35:37','0'),(3,'V0003','lenovo','2005','dev nagar',NULL,NULL,'indore',20,'jayesh','638284','jayesh@lenovo.com','JD2517722','CGST12','admin','2017-11-25 13:07:39','admin',NULL,'','2017-11-25 15:35:07','0'),(4,'V0004','swaraj','SAP1252','shiva temple',NULL,NULL,'kanpur',34,'sudhir','4535355','swap@h.c','SW123441','SGST28','admin','2017-11-27 15:44:44',NULL,NULL,NULL,NULL,'0'),(5,'V0005','bindroo group','3000219','sambhaji chowk',NULL,NULL,'pune',21,'saurabh','45678923','sa.b@g.c','As233456','123456789','admin','2017-12-08 16:51:16',NULL,NULL,NULL,NULL,'0'),(6,'V0006','global bsc','212777','veer nagar','near temple','akurdi1','hyderabad',32,'sandeep','5646467767','ggsg@ww.c','wf','fd345346','admin','2017-12-09 16:25:13','admin',NULL,NULL,NULL,'0');
/*!40000 ALTER TABLE `tbl_vendor_master` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-14 18:20:28
