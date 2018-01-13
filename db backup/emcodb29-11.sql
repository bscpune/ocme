CREATE DATABASE  IF NOT EXISTS `shubharambh` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shubharambh`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 192.168.0.172    Database: shubharambh
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excel_data`
--

LOCK TABLES `excel_data` WRITE;
/*!40000 ALTER TABLE `excel_data` DISABLE KEYS */;
INSERT INTO `excel_data` VALUES (1,'2000','s@gmail.com','784','pune'),(2,'Abhay','Anand@gmail.com','9874561230','Pune'),(3,'Abhay','Anand@gmail.com','9874561230','Pune'),(4,'Abhi','Abhi@gmail.com','1234567890','Mumbai'),(5,'Abhay','Anand@gmail.com','9874561230','Pune'),(6,'Abhi','Abhi@gmail.com','1234567890','Mumbai');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `import_excel`
--

LOCK TABLES `import_excel` WRITE;
/*!40000 ALTER TABLE `import_excel` DISABLE KEYS */;
INSERT INTO `import_excel` VALUES (1,'101','Emco Stock',91000983,'20090330','F1  ','PSSSETCHRWSTRAIN00','1035','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR','10000045','8','53488','53488','100050','MSEDCL-TD(Distribution)       ',NULL,'400051','Mumbai                   ','IN ','13','022 2642221     ',NULL,NULL,NULL),(2,'101','CustomerStock',91000983,'20090330','F1  ','PSSSETCHRWSTRAIN00','1035','ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR','10000045','4','52908','53488','100050','MSEDCL-TD(Distribution)       ',NULL,'400051','Mumbai                   ','IN ','13','022 2642221     ',NULL,NULL,NULL);
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
  `indent_date` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indent_head`
--

LOCK TABLES `indent_head` WRITE;
/*!40000 ALTER TABLE `indent_head` DISABLE KEYS */;
INSERT INTO `indent_head` VALUES (1,'I-1/17-18','2017-10-10 00:00:00',2,'Internal',3,2,3,'pune',12,'approved',12,0,NULL,'dfh','admin','2017-11-29 14:56:36',NULL,NULL),(42,'I-3/17-18','2017-11-01 00:00:00',1,'Internal Indent',3,1,3,'mumbai',42,'approved',9,0,NULL,'jkg','admin','2017-11-29 14:51:48',NULL,NULL),(43,'I-2/17-18','2017-11-02 00:00:00',2,'Internal Indent',4,3,2,NULL,NULL,'approved',11,NULL,NULL,'sdg','admin','2017-11-29 14:53:53',NULL,NULL),(44,'E-4/17-18','2017-11-01 00:00:00',1,'External Indent',3,1,3,NULL,NULL,'approved',12,NULL,NULL,'jhuj','admin','2017-11-29 17:14:57',NULL,NULL),(45,'I-3/17-18','2017-11-03 00:00:00',1,'Internal Indent',3,3,3,NULL,NULL,'pending',NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(46,'I-4/17-18','2017-11-10 00:00:00',2,'Internal Indent',4,3,3,NULL,NULL,'pending',NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(47,'I-5/17-18','2017-11-01 00:00:00',1,'Internal Indent',1,1,3,NULL,NULL,'approved',12,NULL,NULL,'sffgd','admin','2017-11-29 17:17:07',NULL,NULL),(48,'E-5/17-18','2017-11-02 00:00:00',2,'External Indent',1,1,4,NULL,NULL,'pending',NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL),(49,'E-6/17-18','2017-11-01 00:00:00',3,'External Indent',2,2,5,NULL,NULL,'pending',NULL,NULL,NULL,'admin',NULL,NULL,NULL,NULL);
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
  PRIMARY KEY (`indent_material_id`),
  KEY `indent_id` (`indent_id`),
  CONSTRAINT `indent_material_ibfk_1` FOREIGN KEY (`indent_id`) REFERENCES `indent_head` (`indent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indent_material`
--

LOCK TABLES `indent_material` WRITE;
/*!40000 ALTER TABLE `indent_material` DISABLE KEYS */;
INSERT INTO `indent_material` VALUES (31,43,5,'emco mfg',3,NULL,NULL,'ft'),(32,44,5,'emco mfg',4,NULL,NULL,'ft'),(33,45,6,'steel structure',4,NULL,NULL,'meter'),(34,46,5,'emco mfg',4,NULL,NULL,'ft'),(35,47,1,'OSM material',3,NULL,NULL,'meter'),(36,48,1,'OSM material',3,NULL,NULL,'meter'),(37,49,5,'emco mfg',3,NULL,NULL,'ft');
/*!40000 ALTER TABLE `indent_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_activity_master`
--

DROP TABLE IF EXISTS `tbl_activity_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_activity_master` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_activity_master`
--

LOCK TABLES `tbl_activity_master` WRITE;
/*!40000 ALTER TABLE `tbl_activity_master` DISABLE KEYS */;
INSERT INTO `tbl_activity_master` VALUES (1,'A0001','change cable','in progress','admin',NULL,'admin',NULL,NULL,NULL,0),(2,'A0002','repair tower','progress','admin',NULL,NULL,NULL,NULL,NULL,0),(3,'A0003','construct tower','done','admin',NULL,NULL,NULL,NULL,NULL,0),(4,'A0004','foundation','progress','admin',NULL,NULL,NULL,NULL,NULL,0),(31,'2344','gdfg','Active','admin',NULL,NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `tbl_activity_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bom_master`
--

DROP TABLE IF EXISTS `tbl_bom_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bom_master` (
  `site_id` int(11) NOT NULL,
  `activity_id` varchar(45) DEFAULT NULL,
  `material_id` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` int(11) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime(6) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime(6) DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bom_master`
--

LOCK TABLES `tbl_bom_master` WRITE;
/*!40000 ALTER TABLE `tbl_bom_master` DISABLE KEYS */;
INSERT INTO `tbl_bom_master` VALUES (1,'fdg','sdgsg',21,12342,NULL,NULL,NULL,NULL,NULL,NULL),(2,'hgd','hd',35,463,NULL,NULL,NULL,NULL,NULL,NULL),(3,'gds','sg',123,13,NULL,NULL,NULL,NULL,NULL,NULL),(5,'fa','sdg',124,124,NULL,NULL,NULL,NULL,NULL,NULL);
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
  `contractor_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  `consumed_qty` int(11) DEFAULT NULL,
  `return_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`contractor_inventory_id`),
  KEY `storeID_idx` (`store_id`),
  KEY `projectID_idx` (`project_id`),
  KEY `contractorID_idx` (`contractor_id`),
  CONSTRAINT `contractorID1` FOREIGN KEY (`contractor_id`) REFERENCES `tbl_contractor_master` (`contractor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `projectID1` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `storeID1` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contractor_inventory`
--

LOCK TABLES `tbl_contractor_inventory` WRITE;
/*!40000 ALTER TABLE `tbl_contractor_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_contractor_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contractor_master`
--

DROP TABLE IF EXISTS `tbl_contractor_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contractor_master` (
  `contractor_id` int(11) NOT NULL AUTO_INCREMENT,
  `contractor_name` varchar(45) DEFAULT NULL,
  `contractor_address` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contractor_master`
--

LOCK TABLES `tbl_contractor_master` WRITE;
/*!40000 ALTER TABLE `tbl_contractor_master` DISABLE KEYS */;
INSERT INTO `tbl_contractor_master` VALUES (1,'ajay','kranti nagar','pune',23,'gst45','atul','123456',NULL,NULL,NULL,NULL,NULL,NULL,0),(2,'ranveer','sambhaji nagar','mumbai',5,'gst56','ajay','12345630','admin',NULL,'admin',NULL,'admin','2017-11-27 13:03:55.000000',1),(3,'ankush','sinhgad road','pune',21,'gst34','aman','12345312','admin',NULL,NULL,NULL,NULL,NULL,0);
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
  `address` varchar(100) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_master`
--

LOCK TABLES `tbl_customer_master` WRITE;
/*!40000 ALTER TABLE `tbl_customer_master` DISABLE KEYS */;
INSERT INTO `tbl_customer_master` VALUES (1,'C0001','emco1','viman nagar','234546','324235545','dinesh','2436','dinesh@g.c','dd434546','admin','2017-11-25 15:58:55','admin',NULL,'admin','2017-11-25 15:59:11',0,'pune',21,'gst55673'),(2,'C0002','emco10','ameerpet','2356789','2561346','Sanjay','234578','sanjay@emco.com','S234657','admin','2017-11-27 15:36:08','admin',NULL,NULL,NULL,0,'Hyderabad',32,'CGST12'),(3,'C0003','AVP','Pune','131','546546','Amit','9762184145','a@localhost.com','APK4546L','admin','2017-11-28 09:51:24',NULL,NULL,NULL,NULL,0,'Pune',21,'1542005');
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
  `import_excel_id` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`gate_entry_id`),
  KEY `two_idx` (`created_by`),
  KEY `three_idx` (`updated_by`),
  KEY `four_idx` (`deleted_by`),
  KEY `one_idx` (`project_id`),
  KEY `five_idx` (`store_id`),
  KEY `six_idx` (`import_excel_id`),
  CONSTRAINT `five` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `four` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `one` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `six` FOREIGN KEY (`import_excel_id`) REFERENCES `import_excel` (`import_excel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `three` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `two` FOREIGN KEY (`created_by`) REFERENCES `tbl_user_master` (`user_name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_gate_entry`
--

LOCK TABLES `tbl_gate_entry` WRITE;
/*!40000 ALTER TABLE `tbl_gate_entry` DISABLE KEYS */;
INSERT INTO `tbl_gate_entry` VALUES (1,1,1,1,'G-11271','2017-11-27','Mr.ABCD','Customer Stock','2019-09-23 00:00:00',NULL,'MH11-BG-5765','1234','1','admin','2017-11-27 19:09:48',NULL,NULL,NULL,NULL,1),(2,1,1,1,'G-11282','2017-11-28','Mr.XYZ','Customer Stock','2010-02-08 00:00:00',NULL,'MH14-BR-1111','1234','1','admin','2017-11-28 10:02:26',NULL,NULL,NULL,NULL,1),(3,1,1,1,'G-11283','2017-11-28','Mr.XYZ','Customer Stock','2010-07-06 00:00:00','2017-11-28 18:08:09','MH14-BR-2222','4569','3','admin','2017-11-28 10:07:28',NULL,NULL,NULL,NULL,1),(4,1,1,1,'G-11284','2017-11-28','abcd','T&P Stock','2010-09-03 00:00:00',NULL,'MH11-BG-3333','9876','4','admin','2017-11-28 10:09:31',NULL,NULL,NULL,NULL,0),(5,1,1,13,'G-11285','1970-01-01','Mr. Abcd Efgh','Emco Stock','2017-11-28 18:01:11',NULL,'MH14-BR-1111','98761','5','admin','2017-11-28 18:01:11',NULL,NULL,NULL,NULL,0),(6,1,3,2,'G-11286','1970-01-01','Mr. Abcd Efgh','Customer Stock','2017-11-28 18:03:25','2017-11-28 18:05:52','MH11-BG-3333','987612','22','admin','2017-11-28 18:03:25',NULL,NULL,NULL,NULL,1),(7,1,1,2,'G-11287','2017-11-28','abcd','T&P Stock','2017-11-28 18:07:53',NULL,'MH14-BR-1111','987612','56','admin','2017-11-28 18:07:53',NULL,NULL,NULL,NULL,0),(8,1,2,14,'G-11288','2017-11-28','Mr.Qwerty','Emco Stock','2017-11-28 18:11:38',NULL,'MH11-BG-5765','34561','22','admin','2017-11-28 18:11:38',NULL,NULL,NULL,NULL,0),(9,1,2,13,'G-11289','2017-11-28','Mr.Qwerty','Customer Stock','2017-11-28 18:13:01','2017-11-29 12:20:13','MH14-BR-2222','987612','22','admin','2017-11-28 18:13:01',NULL,NULL,NULL,NULL,1),(10,1,2,14,'G-112810','2017-11-28','Mr. Abcd Efgh','Customer Stock','2017-11-28 18:16:25','2017-11-28 18:16:35','MH11-BG-3333','987612','22','admin','2017-11-28 18:16:25',NULL,NULL,NULL,NULL,1);
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
  `material_description` varchar(45) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `unitprice` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`tbl_gate_entry_material_id`),
  KEY `gateentry_idx` (`gate_entry_id`),
  CONSTRAINT `gateentry` FOREIGN KEY (`gate_entry_id`) REFERENCES `tbl_gate_entry` (`gate_entry_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_gate_entry_material`
--

LOCK TABLES `tbl_gate_entry_material` WRITE;
/*!40000 ALTER TABLE `tbl_gate_entry_material` DISABLE KEYS */;
INSERT INTO `tbl_gate_entry_material` VALUES (1,1,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(2,1,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',4,'52908'),(3,2,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(4,2,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',4,'52908'),(5,3,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(6,3,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',4,'52908'),(7,4,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(8,4,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',4,'52908'),(9,10,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',8,'53488'),(10,10,'ETC-Act-11/Est-35-ETC FOR 22/4.500KVA TR',4,'52908');
/*!40000 ALTER TABLE `tbl_gate_entry_material` ENABLE KEYS */;
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
  `unit_price` varchar(45) DEFAULT NULL,
  `min_quantity` int(11) DEFAULT NULL,
  `max_quantity` int(11) DEFAULT NULL,
  `expiry_status` varchar(45) DEFAULT NULL,
  `mfg_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  `active_status` int(2) DEFAULT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_material_master`
--

LOCK TABLES `tbl_material_master` WRITE;
/*!40000 ALTER TABLE `tbl_material_master` DISABLE KEYS */;
INSERT INTO `tbl_material_master` VALUES (1,'OSM material','copper cable','tested','Local','meter','250',1,4,'Yes','2017-09-03','2018-01-31','admin','2017-11-21 15:31:56','admin',NULL,NULL,NULL,0),(2,'M0002','steel pipe','clear','Imported','ft1','1750',1,3,'No','2017-07-16','2018-02-20','admin','2017-11-21 15:33:11','admin',NULL,'admin','2017-11-25 12:10:00',0),(3,'bought out material','cement','good','Local','kg','350',1,10,'Yes','2017-09-18','2018-01-30','admin','2017-11-21 15:47:07','admin',NULL,NULL,NULL,0),(4,'M0004','steel structure','Structures for plant maintenance','Imported','killo gram','3000',1,10,'No','2017-09-11','2017-11-29','admin','2017-11-23 19:17:35','admin',NULL,NULL,NULL,0),(5,'emco mfg','steel rod','good quality material','Imported','ft','500',1,10,'Yes',NULL,NULL,'admin','2017-11-25 12:03:50','admin',NULL,'','2017-11-25 15:37:06',0),(6,'steel structure','steel pipe','tested heavy pipe','Imported','meter','4000',1,15,'No',NULL,NULL,'admin','2017-11-27 15:38:46','admin',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `tbl_material_master` ENABLE KEYS */;
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
  `supplier_name` varchar(45) DEFAULT NULL,
  `supplier_invoice_no` varchar(45) DEFAULT NULL,
  `location_of_despatch` varchar(45) DEFAULT NULL,
  `total_quantity` varchar(45) DEFAULT NULL,
  `remark` varchar(45) DEFAULT NULL,
  `active_status` int(10) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`mrr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mrr_head`
--

LOCK TABLES `tbl_mrr_head` WRITE;
/*!40000 ALTER TABLE `tbl_mrr_head` DISABLE KEYS */;
INSERT INTO `tbl_mrr_head` VALUES (1,'MRR0001',1,'2017-11-29','Amit','2345','location4','12','asf',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'MRR0002',4,'2017-11-29','jayesh','24424','Location10','12','dsfsd',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'MRR0003',3,'2017-11-29','asdsa','234243','sdf','12','sfgv',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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
  `gate_entry_id` int(10) DEFAULT NULL,
  `tbl_gate_entry_material_id` int(10) DEFAULT NULL,
  `accepted_quantity` varchar(45) DEFAULT NULL,
  `rejected_quantity` varchar(45) DEFAULT NULL,
  `active_status` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `deleted_by` varchar(45) DEFAULT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`mrr_material_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mrr_material`
--

LOCK TABLES `tbl_mrr_material` WRITE;
/*!40000 ALTER TABLE `tbl_mrr_material` DISABLE KEYS */;
INSERT INTO `tbl_mrr_material` VALUES (1,1,9,'4','4',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,10,'2','2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,11,9,'8','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,11,10,'3','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,1,'6','2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,2,'2','2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,2,7,'5','3',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,2,8,'3','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,5,5,'8','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,5,6,'3','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_mrr_material` ENABLE KEYS */;
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
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state_id` varchar(45) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_project_master`
--

LOCK TABLES `tbl_project_master` WRITE;
/*!40000 ALTER TABLE `tbl_project_master` DISABLE KEYS */;
INSERT INTO `tbl_project_master` VALUES (1,'P0001','emco0','ground','amit','897777','asd@g.c','mumbai','mumbai','21','2017-10-01','2017-11-30','tu','admin','2017-11-21 15:18:41','admin',NULL,'admin','2017-11-25 16:04:27','0'),(2,'P0002','emco5','feez','sunil','34567','sunil@emco.com','ram nagar','hyderabad','32','2017-09-03','2018-01-26','bhu','','2017-11-25 15:17:10','',NULL,'','2017-11-25 15:29:56','0'),(3,'P0003','emco77','on site','sandip','34776768','sandip@e.c','keshav nagar','kanpur','34','2017-10-02','2017-12-07','ghg','','2017-11-25 15:43:49','admin',NULL,'','2017-11-25 15:44:16','0');
/*!40000 ALTER TABLE `tbl_project_master` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_site_master`
--

LOCK TABLES `tbl_site_master` WRITE;
/*!40000 ALTER TABLE `tbl_site_master` DISABLE KEYS */;
INSERT INTO `tbl_site_master` VALUES (1,1,'emco godown','pune','sanjay',0,'admin',NULL,'admin',NULL,NULL,NULL),(2,2,'emcowh','mumbai','jayesh',0,'admin',NULL,'admin',NULL,NULL,NULL),(3,3,'emco office','hyderabad','sachin',0,'admin',NULL,NULL,NULL,NULL,NULL),(4,2,'warehouse','chennai','gaurav',0,'admin','2017-11-23 14:54:31',NULL,NULL,NULL,NULL),(5,2,'university','surat','harish',0,'admin','2017-11-23 19:21:28','admin',NULL,NULL,NULL);
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
-- Table structure for table `tbl_store_inventory`
--

DROP TABLE IF EXISTS `tbl_store_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_store_inventory` (
  `store_inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `inventory_type` varchar(45) DEFAULT NULL,
  `store_location_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `material_number` varchar(45) DEFAULT NULL,
  `accepted_qty` int(11) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  `remaining_qty` int(11) DEFAULT NULL,
  `consumed_qty` int(11) DEFAULT NULL,
  `return_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`store_inventory_id`),
  KEY `storeID_idx` (`store_id`),
  KEY `projectID_idx` (`project_id`),
  CONSTRAINT `projectID` FOREIGN KEY (`project_id`) REFERENCES `tbl_project_master` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `storeID` FOREIGN KEY (`store_id`) REFERENCES `tbl_store_master` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_inventory`
--

LOCK TABLES `tbl_store_inventory` WRITE;
/*!40000 ALTER TABLE `tbl_store_inventory` DISABLE KEYS */;
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
  `store_address` varchar(45) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_store_master`
--

LOCK TABLES `tbl_store_master` WRITE;
/*!40000 ALTER TABLE `tbl_store_master` DISABLE KEYS */;
INSERT INTO `tbl_store_master` VALUES (1,2,'chennai','super market','location 1','dinesh',0,'pune',23,'admin','2017-11-23 15:27:18',NULL,NULL,NULL,NULL),(2,4,'dubai','rohit shop','location5','juber',0,'mumbai',24,'admin','2017-11-23 15:27:51',NULL,NULL,NULL,NULL),(3,3,'mumbai',NULL,'warehouse1','sunil',0,NULL,NULL,'admin','2017-11-23 15:28:31',NULL,NULL,NULL,NULL),(4,1,'hyderabad',NULL,'store3','vicky',1,NULL,NULL,'admin','2017-11-23 15:29:28',NULL,NULL,'','2017-11-25 15:37:29.000000'),(5,2,'warehouse7',NULL,'location8','karan',0,NULL,NULL,'admin','2017-11-23 19:20:21',NULL,NULL,NULL,NULL),(6,1,'nigdi pradhikaran',NULL,'dombivli','sumit',0,NULL,NULL,'admin','2017-11-25 12:30:06',NULL,NULL,NULL,NULL),(13,4,'neharu chowk','om jay jagdish','mumbai','rohan',0,'mumbai',5,'admin','2017-11-25 13:18:52','admin',NULL,NULL,NULL),(14,1,'sambhaji chowk','amol shop','mumbai','donlad',0,'pune',21,'admin','2017-11-25 16:03:19','admin',NULL,NULL,NULL);
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
  `mobile_number` varchar(20) DEFAULT NULL,
  `user_location` varchar(15) DEFAULT NULL,
  `user_status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_name`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  KEY `tbl_typeofuse_master_ibfk_2_idx` (`user_role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_master`
--

LOCK TABLES `tbl_user_master` WRITE;
/*!40000 ALTER TABLE `tbl_user_master` DISABLE KEYS */;
INSERT INTO `tbl_user_master` VALUES (1,'admin','admin','admin','Developer BSC','admin@localhost.com','1','Pune',0);
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
  PRIMARY KEY (`user_role_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `tbl_user_role_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_user_role_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `tbl_user_master` (`user_name`),
  CONSTRAINT `tbl_user_role_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `tbl_user_master` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_role`
--

LOCK TABLES `tbl_user_role` WRITE;
/*!40000 ALTER TABLE `tbl_user_role` DISABLE KEYS */;
INSERT INTO `tbl_user_role` VALUES (1,'admin',NULL,0,'admin','2017-09-21 20:17:12',NULL,NULL,NULL,NULL),(2,'developer',NULL,1,'admin','2017-09-21 20:17:21',NULL,NULL,NULL,NULL),(3,'SE','Site Engineer',0,'admin','2017-09-22 20:17:21',NULL,NULL,NULL,NULL),(4,'PM','Project Manager',0,'admin','2017-10-04 10:46:30',NULL,NULL,NULL,NULL),(5,'Store','Store Supervioser',0,'admin','2017-10-04 10:47:55',NULL,NULL,NULL,NULL),(6,'Gate','Security',0,'admin','2017-10-04 10:47:55',NULL,NULL,NULL,NULL);
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
  `address` varchar(45) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vendor_master`
--

LOCK TABLES `tbl_vendor_master` WRITE;
/*!40000 ALTER TABLE `tbl_vendor_master` DISABLE KEYS */;
INSERT INTO `tbl_vendor_master` VALUES (2,'V0002','samsung','1002','yog nagar','surat',12,'suraj','23344','awsert@h.c','swerr','SGST28','admin',NULL,'admin',NULL,'admin','2017-11-25 16:01:48','0'),(3,'V0003','dell','46','viman nagar','mumbai',21,'rahul','46334','hhfdh@gmail.com','35248','CGST25','admin',NULL,'admin',NULL,'','2017-11-25 15:35:37','0'),(14,'V0004','lenovo','2005','dev nagar','indore',20,'jayesh','638284','jayesh@lenovo.com','JD2517722','CGST12','admin','2017-11-25 13:07:39','admin',NULL,'','2017-11-25 15:35:07','0'),(15,'V0005','swaraj','SAP1252','shiva temple','kanpur',34,'sudhir','4535355','swap@h.c','SW123441','SGST28','admin','2017-11-27 15:44:44',NULL,NULL,NULL,NULL,'0');
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

-- Dump completed on 2017-11-29 18:24:40
