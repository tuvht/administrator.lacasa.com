-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: web1_asiantech
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_position` varchar(200) DEFAULT NULL,
  `banner_order` int(11) DEFAULT NULL,
  `banner_image_source` mediumtext,
  `banner_image_alttext` mediumtext,
  `banner_image_link` mediumtext,
  `banner_image_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(200) DEFAULT NULL,
  `brand_origin_country` varchar(50) DEFAULT NULL,
  `brand_description` longtext,
  `brand_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Gucci','country1','Gucci brand',1),(2,'Versace','country2','Versace brand',1),(3,'Hermes','country2','Hermes brand',1);
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `par_cat_id` int(11) DEFAULT NULL,
  `cat_name` varchar(200) DEFAULT NULL,
  `cat_image_shape` varchar(20) DEFAULT NULL,
  `cat_description` mediumtext,
  `cat_imageurl` mediumtext,
  `cat_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,1,'formal shirt','square','formal shirt','/images/category/category_1.jpg',1),(2,1,'casual shirt','square','lace up shoe','/images/category/category_2.jpg',1),(3,2,'high heel shoe','square','long jean','/images/category/category_3.jpg',1),(4,2,'running shoe','portrait','classic vest','/images/category/category_4.jpg',1),(5,3,'long jean','square','formal shirt','/images/category/category_5.jpg',1),(6,4,'classic vest','square','lace up shoe','/images/category/category_6.jpg',1),(7,5,'small bag','square','long jean','/images/category/category_7.jpg',1),(8,6,'short jean','portrait','classic vest','/images/category/category_8.jpg',1),(9,7,'plain tshirt','portrait','classic vest','/images/category/category_9.jpg',1),(10,7,'printed tshirt','portrait','classic vest','/images/category/category_10.jpg',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_criteria_mapping`
--

DROP TABLE IF EXISTS `category_criteria_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_criteria_mapping` (
  `category_criteria_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `criteria_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_criteria_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`category_criteria_mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_criteria_mapping`
--

LOCK TABLES `category_criteria_mapping` WRITE;
/*!40000 ALTER TABLE `category_criteria_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_criteria_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_field`
--

DROP TABLE IF EXISTS `category_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_field` (
  `cat_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_field_name` varchar(200) DEFAULT NULL,
  `cat_field_description` mediumtext,
  `cat_field_valuetype` varchar(20) DEFAULT NULL,
  `cat_field_valuelength` varchar(20) DEFAULT NULL,
  `cat_field_controltype` varchar(20) DEFAULT NULL,
  `cat_field_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cat_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_field`
--

LOCK TABLES `category_field` WRITE;
/*!40000 ALTER TABLE `category_field` DISABLE KEYS */;
INSERT INTO `category_field` VALUES (1,'size','size of product','varchar','50','textbox',1),(2,'color','color of product','varchar','50','textbox',1),(3,'length','length of product','varchar','50','textbox',1),(4,'material','material of product','varchar','200','textbox',1),(5,'inner material','inner material of product','varchar','50','textbox',1),(6,'season','season of product','varchar','50','textbox',1);
/*!40000 ALTER TABLE `category_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_field_mapping`
--

DROP TABLE IF EXISTS `category_field_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_field_mapping` (
  `cat_field_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_field_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `cat_field_mapping_require` int(11) DEFAULT NULL,
  `cat_field_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cat_field_mapping_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_field_mapping`
--

LOCK TABLES `category_field_mapping` WRITE;
/*!40000 ALTER TABLE `category_field_mapping` DISABLE KEYS */;
INSERT INTO `category_field_mapping` VALUES (1,1,1,1,1),(2,1,2,1,1),(3,1,3,1,1),(4,1,4,1,1),(5,1,5,1,1),(6,1,6,1,1),(7,1,7,1,1),(8,4,1,1,1),(9,2,2,1,1),(10,3,3,1,1),(11,5,4,1,1),(12,6,4,1,1),(13,6,5,1,1),(14,3,6,1,1);
/*!40000 ALTER TABLE `category_field_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `city_name` mediumtext,
  `city_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `com_transaction_item`
--

DROP TABLE IF EXISTS `com_transaction_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `com_transaction_item` (
  `com_transaction_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `com_transaction_prod_id` bigint(20) DEFAULT NULL,
  `com_transaction_prod_variant_id` bigint(20) DEFAULT NULL,
  `com_transaction_item_price` double DEFAULT NULL,
  `com_transaction_item_saleprice` double DEFAULT NULL,
  `com_transaction_item_commision` double DEFAULT NULL,
  `com_transaction_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`com_transaction_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `com_transaction_item`
--

LOCK TABLES `com_transaction_item` WRITE;
/*!40000 ALTER TABLE `com_transaction_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `com_transaction_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_shipper`
--

DROP TABLE IF EXISTS `company_shipper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_shipper` (
  `com_shipper_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_shipper_name` mediumtext,
  `com_shipper_address` mediumtext,
  `com_shipper_website` varchar(200) DEFAULT NULL,
  `com_shipper_trackingsite` mediumtext,
  `com_shipper_trackingpattern` varchar(200) DEFAULT NULL,
  `com_shipper_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`com_shipper_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_shipper`
--

LOCK TABLES `company_shipper` WRITE;
/*!40000 ALTER TABLE `company_shipper` DISABLE KEYS */;
INSERT INTO `company_shipper` VALUES (1,'Viettel','1 hai ba trung, quan 1','http://www.viettel.com.vn','http://www.viettel.com.vn/tracking','*^[1-2]',1),(2,'Giaohangnhanh','2 hai ba trung, quan 1','http://www.giaohangnhanh.com.vn','http://www.giaohangnhanh.com.vn/tracking','*^[a-z]',1);
/*!40000 ALTER TABLE `company_shipper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_warehouse`
--

DROP TABLE IF EXISTS `company_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_warehouse` (
  `com_warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_warehouse_name` mediumtext,
  `com_warehouse_default` tinyint(4) DEFAULT NULL,
  `com_warehouse_street` mediumtext,
  `com_warehouse_country` int(11) DEFAULT NULL,
  `com_warehouse_city` int(11) DEFAULT NULL,
  `com_warehouse_district` int(11) DEFAULT NULL,
  `com_warehouse_contactperson` varchar(200) DEFAULT NULL,
  `com_warehouse_contactphone` varchar(200) DEFAULT NULL,
  `com_warehouse_contactmail` varchar(200) DEFAULT NULL,
  `com_warehouse_workinghour` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`com_warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_warehouse`
--

LOCK TABLES `company_warehouse` WRITE;
/*!40000 ALTER TABLE `company_warehouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` mediumtext,
  `country_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Viet Nam',1),(2,'USA',1),(3,'Thailand',1),(4,'Singapore',1);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criteria`
--

DROP TABLE IF EXISTS `criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criteria` (
  `criteria_id` int(11) NOT NULL AUTO_INCREMENT,
  `criteria_name` mediumtext,
  `criteria_description` mediumtext,
  `criteria_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`criteria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteria`
--

LOCK TABLES `criteria` WRITE;
/*!40000 ALTER TABLE `criteria` DISABLE KEYS */;
/*!40000 ALTER TABLE `criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `cus_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cus_name` varchar(200) DEFAULT NULL,
  `cus_email` varchar(200) DEFAULT NULL,
  `cus_phone` varchar(50) DEFAULT NULL,
  `cus_password` varchar(50) DEFAULT NULL,
  `cus_join_date` date DEFAULT NULL,
  `cus_type` int(11) DEFAULT NULL,
  `cus_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Dat Huynh','dathuynh@asiantechhub.com','0937111811','123456','0000-00-00',3,1),(2,'Tai Pham','taipham@asiantechhub.com','0937111811','123456','0000-00-00',2,1),(3,'Tu Vuong','tuvuong@asiantechhub.com','0937111811','','0000-00-00',1,1);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_detail`
--

DROP TABLE IF EXISTS `customer_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_detail` (
  `cus_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cus_id` bigint(20) DEFAULT NULL,
  `cus_detail_field_id` int(11) DEFAULT NULL,
  `cus_detail_valueint` int(11) DEFAULT NULL,
  `cus_detail_valuedouble` double DEFAULT NULL,
  `cus_detail_valuedate` date DEFAULT NULL,
  `cus_detail_valueshortchar` varchar(50) DEFAULT NULL,
  `cus_detail_valuelongchar` varchar(200) DEFAULT NULL,
  `cus_detail_valuemediumtext` mediumtext,
  `cus_detail_valuelongtext` longtext,
  PRIMARY KEY (`cus_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_detail`
--

LOCK TABLES `customer_detail` WRITE;
/*!40000 ALTER TABLE `customer_detail` DISABLE KEYS */;
INSERT INTO `customer_detail` VALUES (1,1,1,0,0,'0000-00-00','','','',''),(2,2,1,0,0,'0000-00-00','','','','');
/*!40000 ALTER TABLE `customer_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_field`
--

DROP TABLE IF EXISTS `customer_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_field` (
  `cus_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_field_name` varchar(200) DEFAULT NULL,
  `cus_field_description` mediumtext,
  `cus_field_valuetype` varchar(20) DEFAULT NULL,
  `cus_field_valuelength` varchar(20) DEFAULT NULL,
  `cus_field_controltype` varchar(20) DEFAULT NULL,
  `cus_field_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cus_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_field`
--

LOCK TABLES `customer_field` WRITE;
/*!40000 ALTER TABLE `customer_field` DISABLE KEYS */;
INSERT INTO `customer_field` VALUES (1,'birthday','birthday of customer','date','','calendar',1);
/*!40000 ALTER TABLE `customer_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_field_mapping`
--

DROP TABLE IF EXISTS `customer_field_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_field_mapping` (
  `cus_field_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_type_id` int(11) DEFAULT NULL,
  `cus_field_id` int(11) DEFAULT NULL,
  `cus_field_require` int(11) DEFAULT NULL,
  `cus_field_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`cus_field_mapping_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_field_mapping`
--

LOCK TABLES `customer_field_mapping` WRITE;
/*!40000 ALTER TABLE `customer_field_mapping` DISABLE KEYS */;
INSERT INTO `customer_field_mapping` VALUES (1,2,1,1,1),(2,3,1,1,1);
/*!40000 ALTER TABLE `customer_field_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_shipping_address`
--

DROP TABLE IF EXISTS `customer_shipping_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_shipping_address` (
  `addr_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cus_id` bigint(20) DEFAULT NULL,
  `addr_street` mediumtext,
  `addr_country` int(11) DEFAULT NULL,
  `addr_city` int(11) DEFAULT NULL,
  `addr_district` int(11) DEFAULT NULL,
  `addr_default` tinyint(4) DEFAULT NULL,
  `addr_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`addr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_shipping_address`
--

LOCK TABLES `customer_shipping_address` WRITE;
/*!40000 ALTER TABLE `customer_shipping_address` DISABLE KEYS */;
INSERT INTO `customer_shipping_address` VALUES (1,1,'14 Phan Ton',1,1,1,1,1),(2,2,'15 Phan Ton',1,1,1,1,1),(3,3,'16 Phan Ton',1,1,1,1,1);
/*!40000 ALTER TABLE `customer_shipping_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_type`
--

DROP TABLE IF EXISTS `customer_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_type` (
  `customer_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_type_name` varchar(200) DEFAULT NULL,
  `customer_type_description` mediumtext,
  `customer_type_discount` double DEFAULT NULL,
  `customer_type_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`customer_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_type`
--

LOCK TABLES `customer_type` WRITE;
/*!40000 ALTER TABLE `customer_type` DISABLE KEYS */;
INSERT INTO `customer_type` VALUES (1,'walkin','customer who does not register',0,1),(2,'normal member','customer who register',0,1),(3,'vip member','customer who register as vip',10,1);
/*!40000 ALTER TABLE `customer_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `district_name` mediumtext,
  `disctrict_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_status`
--

DROP TABLE IF EXISTS `image_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_status` (
  `image_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_status_name` varchar(200) DEFAULT NULL,
  `image_status_description` mediumtext,
  `image_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`image_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_status`
--

LOCK TABLES `image_status` WRITE;
/*!40000 ALTER TABLE `image_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `image_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incomplete_order`
--

DROP TABLE IF EXISTS `incomplete_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incomplete_order` (
  `incomplete_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(200) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `cus_id` bigint(20) DEFAULT NULL,
  `prod_id` bigint(20) DEFAULT NULL,
  `prod_variant_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`incomplete_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomplete_order`
--

LOCK TABLES `incomplete_order` WRITE;
/*!40000 ALTER TABLE `incomplete_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomplete_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_category`
--

DROP TABLE IF EXISTS `master_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_category` (
  `mas_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mas_cat_name` varchar(200) DEFAULT NULL,
  `mas_cat_description` mediumtext,
  `mas_cat_imageurl` mediumtext,
  `mas_cat_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`mas_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_category`
--

LOCK TABLES `master_category` WRITE;
/*!40000 ALTER TABLE `master_category` DISABLE KEYS */;
INSERT INTO `master_category` VALUES (1,'Man','Products for man','/images/master_category/mastercategory_1.jpg',1),(2,'Woman','Products for woman','/images/master_category/mastercategory_2.jpg',1);
/*!40000 ALTER TABLE `master_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_extra_fee`
--

DROP TABLE IF EXISTS `order_extra_fee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_extra_fee` (
  `order_extra_fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_extra_fee_name` mediumtext,
  `order_extra_fee_static` double DEFAULT NULL,
  `order_extra_fee_percentage` double DEFAULT NULL,
  `order_extra_fee_applyonprice` int(11) DEFAULT NULL,
  `order_extra_fee_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`order_extra_fee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_extra_fee`
--

LOCK TABLES `order_extra_fee` WRITE;
/*!40000 ALTER TABLE `order_extra_fee` DISABLE KEYS */;
INSERT INTO `order_extra_fee` VALUES (1,'Gift Wrap',20000,0,0,1),(2,'Fast Delivery',0,5,1,1);
/*!40000 ALTER TABLE `order_extra_fee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_extra_fee_detail`
--

DROP TABLE IF EXISTS `order_extra_fee_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_extra_fee_detail` (
  `order_extra_fee_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `order_extra_fee_type` int(11) DEFAULT NULL,
  `order_extra_fee_amount` double DEFAULT NULL,
  PRIMARY KEY (`order_extra_fee_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_extra_fee_detail`
--

LOCK TABLES `order_extra_fee_detail` WRITE;
/*!40000 ALTER TABLE `order_extra_fee_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_extra_fee_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `order_item_prod_id` bigint(20) DEFAULT NULL,
  `order_item_prod_variant_mapping_id` bigint(20) DEFAULT NULL,
  `order_item_price` double DEFAULT NULL,
  `order_item_sale_price` double DEFAULT NULL,
  `order_item_sale_percentage` double DEFAULT NULL,
  `order_item_quantity` int(11) DEFAULT NULL,
  `order_item_note` mediumtext,
  `order_item_shipping_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (1,1,1,1,500000,500000,0,1,'deliver soon',1),(2,1,1,2,500000,500000,0,1,'deliver soon',3),(3,1,1,2,500000,500000,0,1,'deliver soon',3),(4,1,1,4,500000,500000,0,1,'deliver soon',3),(5,1,3,0,500000,500000,0,1,'deliver soon',3),(6,2,1,3,500000,500000,0,1,'deliver soon',3),(7,2,1,4,500000,500000,0,1,'deliver soon',3),(8,2,4,0,500000,500000,0,1,'deliver soon',2),(9,3,1,5,500000,500000,0,1,'deliver soon',3),(10,3,1,5,500000,500000,0,1,'deliver soon',2),(11,3,5,0,500000,500000,0,1,'deliver soon',4),(12,4,6,0,500000,500000,0,1,'deliver soon',1),(13,5,7,0,500000,500000,0,1,'deliver soon',1),(14,6,3,0,500000,500000,0,1,'deliver soon',3);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_payment`
--

DROP TABLE IF EXISTS `order_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_payment` (
  `order_payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `order_payment_method_id` int(11) DEFAULT NULL,
  `order_payment_datetime` datetime DEFAULT NULL,
  `order_payment_note` longtext,
  `order_payment_amount` double DEFAULT NULL,
  `order_payment_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_payment`
--

LOCK TABLES `order_payment` WRITE;
/*!40000 ALTER TABLE `order_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_payment_detail`
--

DROP TABLE IF EXISTS `order_payment_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_payment_detail` (
  `order_payment_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_payment_id` bigint(20) DEFAULT NULL,
  `order_payment_method_field` int(11) DEFAULT NULL,
  `order_payment_method_field_valueint` int(11) DEFAULT NULL,
  `order_payment_method_field_valuedouble` double DEFAULT NULL,
  `order_payment_method_field_valuedate` date DEFAULT NULL,
  `order_payment_method_field_shortchar` varchar(50) DEFAULT NULL,
  `order_payment_method_field_longchar` varchar(200) DEFAULT NULL,
  `order_payment_method_field_mediumtext` mediumtext,
  `order_payment_method_field_longtext` longtext,
  PRIMARY KEY (`order_payment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_payment_detail`
--

LOCK TABLES `order_payment_detail` WRITE;
/*!40000 ALTER TABLE `order_payment_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_payment_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_return_type`
--

DROP TABLE IF EXISTS `order_return_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_return_type` (
  `order_return_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_return_type_name` varchar(200) DEFAULT NULL,
  `order_return_type_desc` mediumtext,
  `order_return_type_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`order_return_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_return_type`
--

LOCK TABLES `order_return_type` WRITE;
/*!40000 ALTER TABLE `order_return_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_return_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_status_name` varchar(200) DEFAULT NULL,
  `order_status_description` mediumtext,
  `order_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`order_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'New','New order waiting to be confirmed by supplier',1),(2,'Rejected','New order rejected by supplier',1),(3,'Confirmed','New order confirmed by supplier',1),(4,'Wait for shipment','New order waiting to be arranged for shipment pickup',1),(5,'On the way','New order is being shipped to customer',1),(6,'Delivered','New order is delivered to customer',1),(7,'Canceled','New order is canceled for some reason',1);
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_date` date DEFAULT NULL,
  `order_cus_id` bigint(20) DEFAULT NULL,
  `order_note` mediumtext,
  `order_shipping_recipient_name` varchar(200) DEFAULT NULL,
  `order_shipping_recipient_phone` varchar(50) DEFAULT NULL,
  `order_shipping_street` mediumtext,
  `order_shipping_country` varchar(200) DEFAULT NULL,
  `order_shipping_city` varchar(200) DEFAULT NULL,
  `order_shipping_district` varchar(200) DEFAULT NULL,
  `order_shipping_shipper_id` int(11) DEFAULT NULL,
  `order_shipping_shipper_tracking` varchar(50) DEFAULT NULL,
  `order_shipping_shipper_shipdate` date DEFAULT NULL,
  `order_shipping_shipper_estdate` date DEFAULT NULL,
  `order_shipping_shipper_actdate` date DEFAULT NULL,
  `order_shipping_shipper_shipfee` double DEFAULT NULL,
  `order_shipping_shipper_freeship` tinyint(4) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL,
  `voucher` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'0000-00-00',1,'this is note','Dat Huynh','0937111811','14 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',20000,1,6,NULL),(2,'0000-00-00',2,'this is note','Tu Vuong','0937111811','15 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',30000,1,1,NULL),(3,'0000-00-00',3,'this is note','Tai Pham','0937111811','15 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',30000,1,1,NULL),(4,'0000-00-00',2,'this is note','Tu Vuong','0937111811','15 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',30000,1,6,NULL),(5,'0000-00-00',2,'this is note','Tu Vuong','0937111811','15 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',30000,1,6,NULL),(6,'0000-00-00',2,'this is note','Tu Vuong','0937111811','15 phan ton','1','1','1',1,'TR123456','0000-00-00','0000-00-00','0000-00-00',30000,1,6,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_category`
--

DROP TABLE IF EXISTS `parent_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_category` (
  `par_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `par_cat_name` varchar(200) DEFAULT NULL,
  `par_cat_description` mediumtext,
  `par_cat_imageurl` mediumtext,
  `par_cat_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`par_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_category`
--

LOCK TABLES `parent_category` WRITE;
/*!40000 ALTER TABLE `parent_category` DISABLE KEYS */;
INSERT INTO `parent_category` VALUES (1,'Shirt','shirt of all kinds','/images/parent_category/parentcategory_1.jpg',1),(2,'Shoe','shoe of all kinds','/images/parent_category/parentcategory_2.jpg',1),(3,'Jean','jean of all kinds','/images/parent_category/parentcategory_3.jpg',1),(4,'Vest','vest of all kinds','/images/parent_category/parentcategory_4.jpg',1),(5,'Bag','bag of all kinds','/images/parent_category/parentcategory_5.jpg',1),(6,'Short','short of all kinds','/images/parent_category/parentcategory_6.jpg',1),(7,'Tshirt','Tshirt of all kinds','/images/parent_category/parentcategory_7.jpg',1);
/*!40000 ALTER TABLE `parent_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_provider` varchar(200) DEFAULT NULL,
  `payment_method_type` varchar(200) DEFAULT NULL,
  `payment_method_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method`
--

LOCK TABLES `payment_method` WRITE;
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
INSERT INTO `payment_method` VALUES (1,'Paypal','Credit Card',1),(2,'MobiVi','Online Payment',1),(3,'Viettel','COD',1);
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method_field`
--

DROP TABLE IF EXISTS `payment_method_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method_field` (
  `payment_method_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_field_name` varchar(200) DEFAULT NULL,
  `payment_method_field_description` mediumtext,
  `payment_method_field_valuetype` varchar(20) DEFAULT NULL,
  `payment_method_field_valuelength` varchar(20) DEFAULT NULL,
  `payment_method_field_controltype` varchar(20) DEFAULT NULL,
  `payment_method_field_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`payment_method_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method_field`
--

LOCK TABLES `payment_method_field` WRITE;
/*!40000 ALTER TABLE `payment_method_field` DISABLE KEYS */;
INSERT INTO `payment_method_field` VALUES (1,'Name On Card','Name On Card description','varchar','200','textbox',1),(2,'Card Number','Name On Card description','varchar','200','textbox',1),(3,'Expire Date','Name On Card description','varchar','200','textbox',1),(4,'CVV','Name On Card description','varchar','4','textbox',1),(5,'Account','Name On Card description','varchar','200','textbox',1);
/*!40000 ALTER TABLE `payment_method_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method_mapping`
--

DROP TABLE IF EXISTS `payment_method_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method_mapping` (
  `payment_method_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_method_field_id` int(11) DEFAULT NULL,
  `payment_method_field_require` int(11) DEFAULT NULL,
  `payment_method_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`payment_method_mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method_mapping`
--

LOCK TABLES `payment_method_mapping` WRITE;
/*!40000 ALTER TABLE `payment_method_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_method_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_status`
--

DROP TABLE IF EXISTS `payment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_status` (
  `payment_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_status_name` varchar(200) DEFAULT NULL,
  `payment_status_description` mediumtext,
  `payment_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`payment_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_status`
--

LOCK TABLES `payment_status` WRITE;
/*!40000 ALTER TABLE `payment_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `prod_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_name` mediumtext,
  `prod_supplierinternalid` varchar(200) DEFAULT NULL,
  `prod_price` double DEFAULT NULL,
  `prod_brand_id` int(11) DEFAULT NULL,
  `prod_made_country` int(11) DEFAULT NULL,
  `prod_mas_id` int(11) DEFAULT NULL,
  `prod_cat_id` int(11) DEFAULT NULL,
  `prod_description` longtext,
  `prod_supplier_id` int(11) DEFAULT NULL,
  `prod_upload_date` date DEFAULT NULL,
  `prod_type` int(11) DEFAULT NULL,
  `prod_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Summer man shirt','shirtabc0001',500000,1,1,1,1,'summer shirt from Gucci, very nice.',1,'0000-00-00',1,1),(2,'Summer man shirt','shirtabc0001',500000,1,1,1,2,'summer shirt from Gucci, very nice.',1,'0000-00-00',1,1),(3,'Spring woman shirt','shirtabc0003',300000,3,3,2,1,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(4,'Spring woman shirt','shirtabc0003',300000,1,3,1,2,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(5,'Spring woman shirt','shirtabc0003',300000,2,2,1,2,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(6,'Spring woman shirt','shirtabc0003',300000,2,2,1,2,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(7,'Spring woman shirt','shirtabc0003',300000,1,1,1,1,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(8,'Spring woman shirt','shirtabc0003',300000,3,1,1,1,'summer shirt from Gucci, very nice.',1,'0000-00-00',2,1),(9,'Running shoe','shoexyz0001',650000,3,2,1,3,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(10,'Running shoe','shoexyz0001',650000,2,1,1,3,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(11,'Running shoe','shoexyz0001',650000,4,1,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(12,'Running shoe','shoexyz0001',650000,3,3,1,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(13,'Running shoe','shoexyz0001',650000,1,3,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(14,'Running shoe','shoexyz0001',650000,2,4,1,3,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(15,'Running shoe','shoexyz0001',650000,1,3,1,3,'summer shirt from Gucci, very nice.',2,'0000-00-00',3,1),(16,'Running shoe','shoexyz0001',650000,1,2,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1),(17,'Running shoe','shoexyz0001',650000,1,3,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1),(18,'Running shoe','shoexyz0001',650000,1,3,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1),(19,'Running shoe','shoexyz0001',650000,1,4,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1),(20,'Running shoe','shoexyz0001',650000,1,4,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1),(21,'Running shoe','shoexyz0001',650000,1,4,2,4,'summer shirt from Gucci, very nice.',2,'0000-00-00',4,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_change_history`
--

DROP TABLE IF EXISTS `product_change_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_change_history` (
  `product_change_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `product_change_field` varchar(200) DEFAULT NULL,
  `product_change_oldvalue` mediumtext,
  `product_change_newvalue` mediumtext,
  `product_change_by` varchar(200) DEFAULT NULL,
  `product_change_date` date DEFAULT NULL,
  PRIMARY KEY (`product_change_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_change_history`
--

LOCK TABLES `product_change_history` WRITE;
/*!40000 ALTER TABLE `product_change_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_change_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_check`
--

DROP TABLE IF EXISTS `product_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_check` (
  `product_check_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `criteria_id` int(11) DEFAULT NULL,
  `product_check_supervisor` varchar(200) DEFAULT NULL,
  `product_check_result` tinyint(4) DEFAULT NULL,
  `product_check_reason` mediumtext,
  `product_check_date` date DEFAULT NULL,
  PRIMARY KEY (`product_check_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_check`
--

LOCK TABLES `product_check` WRITE;
/*!40000 ALTER TABLE `product_check` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_check` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_detail`
--

DROP TABLE IF EXISTS `product_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_detail` (
  `prod_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` bigint(20) DEFAULT NULL,
  `prod_detail_catfield_id` int(11) DEFAULT NULL,
  `prod_detail_catfield_valueint` int(11) DEFAULT NULL,
  `prod_detail_catfield_valuedouble` double DEFAULT NULL,
  `prod_detail_catfield_valuedate` date DEFAULT NULL,
  `prod_detail_catfield_shotchar` varchar(50) DEFAULT NULL,
  `prod_detail_catfield_longchar` varchar(200) DEFAULT NULL,
  `prod_detail_catfield_valuemediumtext` mediumtext,
  `prod_detail_catfield_valuelongtext` longtext,
  PRIMARY KEY (`prod_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_detail`
--

LOCK TABLES `product_detail` WRITE;
/*!40000 ALTER TABLE `product_detail` DISABLE KEYS */;
INSERT INTO `product_detail` VALUES (1,1,1,0,0,'0000-00-00','XL,','','','');
/*!40000 ALTER TABLE `product_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_image` (
  `prod_image_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prod_id` bigint(20) DEFAULT NULL,
  `prod_image_name` mediumtext,
  `prod_image_type` varchar(200) DEFAULT NULL,
  `prod_image_extension` varchar(100) DEFAULT NULL,
  `prod_image_size` varchar(100) DEFAULT NULL,
  `prod_image_path` mediumtext,
  `prod_image_encode` longtext,
  `prod_image_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`prod_image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` VALUES (1,1,'prod1_1','front look','jpg','200','/images/products/main','',1),(2,1,'prod1_1','front look','jpg','200','/images/products/main','',1),(3,1,'prod1_2','front look','jpg','200','/images/products/main','',1),(4,2,'prod2_1','front look','jpg','200','/images/products/main','',1),(5,2,'prod2_2','back look','jpg','200','/images/products/main','',1),(6,2,'prod2_3','side look look','jpg','200','/images/products/main','',1),(7,3,'prod3_1','front look','jpg','200','/images/products/main','',1),(8,4,'prod4_1','front look','jpg','200','/images/products/main','',1),(9,5,'prod5_1','front look','jpg','200','/images/products/main','',1),(10,6,'prod6_1','front look','jpg','200','/images/products/main','',1),(11,7,'prod7_1','front look','jpg','200','/images/products/main','',1),(12,8,'prod8_1','front look','jpg','200','/images/products/main','',1),(13,9,'prod9_1','front look','jpg','200','/images/products/main','',1),(14,10,'prod10_1','front look','jpg','200','/images/products/main','',1),(15,11,'prod11_1','front look','jpg','200','/images/products/main','',1),(16,12,'prod12_1','front look','jpg','200','/images/products/main','',1),(17,13,'prod13_1','front look','jpg','200','/images/products/main','',1),(18,14,'prod14_1','front look','jpg','200','/images/products/main','',1),(19,15,'prod15_1','front look','jpg','200','/images/products/main','',1),(20,16,'prod16_1','front look','jpg','200','/images/products/main','',1),(21,17,'prod17_1','front look','jpg','200','/images/products/main','',1),(22,18,'prod18_1','front look','jpg','200','/images/products/main','',1),(23,19,'prod19_1','front look','jpg','200','/images/products/main','',1),(24,20,'prod20_1','front look','jpg','200','/images/products/main','',1),(25,21,'prod21_1','front look','jpg','200','/images/products/main','',1);
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_rating`
--

DROP TABLE IF EXISTS `product_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_rating` (
  `rate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rate_prod_id` bigint(20) DEFAULT NULL,
  `rate_cus_id` bigint(20) DEFAULT NULL,
  `rate_order_id` bigint(20) DEFAULT NULL,
  `rate_star` int(11) DEFAULT NULL,
  `rate_comment` longtext,
  `rate_date` date DEFAULT NULL,
  `rate_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_rating`
--

LOCK TABLES `product_rating` WRITE;
/*!40000 ALTER TABLE `product_rating` DISABLE KEYS */;
INSERT INTO `product_rating` VALUES (1,1,1,1,4,'this product is suck','0000-00-00',1),(2,1,1,1,3,'this product is suck','0000-00-00',1),(3,1,1,1,2,'this product is suck','0000-00-00',1),(4,1,1,1,5,'this product is suck','0000-00-00',1),(5,2,1,1,4,'this product is suck','0000-00-00',1),(6,2,1,1,2,'this product is suck','0000-00-00',1),(7,2,1,1,3,'this product is suck','0000-00-00',1);
/*!40000 ALTER TABLE `product_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_status`
--

DROP TABLE IF EXISTS `product_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_status` (
  `product_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_status_name` varchar(200) DEFAULT NULL,
  `product_status_description` mediumtext,
  `product_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`product_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_status`
--

LOCK TABLES `product_status` WRITE;
/*!40000 ALTER TABLE `product_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_type` (
  `prod_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_type_name` varchar(200) DEFAULT NULL,
  `prod_type_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`prod_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_type`
--

LOCK TABLES `product_type` WRITE;
/*!40000 ALTER TABLE `product_type` DISABLE KEYS */;
INSERT INTO `product_type` VALUES (1,'Normal',1),(2,'Best Seller',1),(3,'Hot Product',1),(4,'New Arrival',1);
/*!40000 ALTER TABLE `product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant`
--

DROP TABLE IF EXISTS `product_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variant` (
  `product_variant_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `cat_field_id` int(11) DEFAULT NULL,
  `variant_value` varchar(200) DEFAULT NULL,
  `product_variant_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`product_variant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant`
--

LOCK TABLES `product_variant` WRITE;
/*!40000 ALTER TABLE `product_variant` DISABLE KEYS */;
INSERT INTO `product_variant` VALUES (1,1,1,'32 usa',1),(2,1,2,'black',1),(3,1,1,'34 usa',1),(4,1,2,'black',1),(5,1,1,'32 usa',1),(6,1,2,'white',1),(7,1,1,'36 usa',1),(8,1,2,'white',1),(9,1,1,'28 uk',1),(10,1,2,'white',1),(11,2,1,'siez S',1),(12,2,1,'size M',1);
/*!40000 ALTER TABLE `product_variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant_mapping`
--

DROP TABLE IF EXISTS `product_variant_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variant_mapping` (
  `product_variant_mapping_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `product_variant_supplier_internal_id` varchar(200) DEFAULT NULL,
  `product_variant_value1` bigint(20) DEFAULT NULL,
  `product_variant_value2` bigint(20) DEFAULT NULL,
  `product_variant_price` double DEFAULT NULL,
  `product_variant_image` mediumtext,
  `product_variant_note` mediumtext,
  `product_variant_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`product_variant_mapping_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant_mapping`
--

LOCK TABLES `product_variant_mapping` WRITE;
/*!40000 ALTER TABLE `product_variant_mapping` DISABLE KEYS */;
INSERT INTO `product_variant_mapping` VALUES (1,1,'shirtabc0011',1,2,500000,'','',1),(2,1,'shirtabc0011',3,4,510000,'','',1),(3,1,'shirtabc0011',5,6,520000,'','',1),(4,1,'shirtabc0011',7,8,540000,'','',1),(5,1,'shirtabc0011',9,10,550000,'','',1),(6,2,'shirtabc0011',11,0,500000,'','',1),(7,2,'shirtabc0011',12,0,500000,'','',1);
/*!40000 ALTER TABLE `product_variant_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_warehouse_stock`
--

DROP TABLE IF EXISTS `product_warehouse_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_warehouse_stock` (
  `product_warehouse_stock_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `product_variant_mapping_id` bigint(20) DEFAULT NULL,
  `supplier_warehouse` int(11) DEFAULT NULL,
  `product_warehouse_quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_warehouse_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_warehouse_stock`
--

LOCK TABLES `product_warehouse_stock` WRITE;
/*!40000 ALTER TABLE `product_warehouse_stock` DISABLE KEYS */;
INSERT INTO `product_warehouse_stock` VALUES (1,1,1,1,10),(2,1,2,2,5),(3,1,3,1,5),(4,1,4,2,6),(5,1,5,2,6),(6,2,6,1,10),(7,2,7,2,5),(8,3,0,1,5),(9,4,0,1,5),(10,5,0,1,5),(11,6,0,1,5),(12,7,0,1,5),(13,8,0,1,5),(14,9,0,1,5),(15,10,0,3,5),(16,11,0,3,5),(17,12,0,3,5),(18,13,0,3,5),(19,14,0,3,5),(20,15,0,3,5),(21,16,0,3,5),(22,17,0,3,5),(23,18,0,3,5),(24,19,0,3,5),(25,20,0,3,5),(26,21,0,3,5);
/*!40000 ALTER TABLE `product_warehouse_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion` (
  `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_name` mediumtext,
  `promotion_startdate` date DEFAULT NULL,
  `promotion_enddate` date DEFAULT NULL,
  `promotion_type` int(11) DEFAULT NULL,
  `promotion_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion`
--

LOCK TABLES `promotion` WRITE;
/*!40000 ALTER TABLE `promotion` DISABLE KEYS */;
INSERT INTO `promotion` VALUES (1,'new year discount','0000-00-00','0000-00-00',0,1);
/*!40000 ALTER TABLE `promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_detail`
--

DROP TABLE IF EXISTS `promotion_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_detail` (
  `promotion_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) DEFAULT NULL,
  `promotion_detail_field` varchar(200) DEFAULT NULL,
  `promotion_detail_mapping_field_valueint` int(11) DEFAULT NULL,
  `promotion_detail_mapping_field_valuedouble` double DEFAULT NULL,
  `promotion_detail_mapping_field_valuedate` date DEFAULT NULL,
  `promotion_detail_mapping_field_shortchar` varchar(50) DEFAULT NULL,
  `promotion_detail_mapping_field_longchar` varchar(200) DEFAULT NULL,
  `promotion_detail_mapping_field_mediumtext` mediumtext,
  `promotion_detail_mapping_field_longtext` longtext,
  PRIMARY KEY (`promotion_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_detail`
--

LOCK TABLES `promotion_detail` WRITE;
/*!40000 ALTER TABLE `promotion_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_item_mapping`
--

DROP TABLE IF EXISTS `promotion_item_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_item_mapping` (
  `promotion_item_mapping_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `promotion_item_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_item_mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_item_mapping`
--

LOCK TABLES `promotion_item_mapping` WRITE;
/*!40000 ALTER TABLE `promotion_item_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_item_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_supplier_mapping`
--

DROP TABLE IF EXISTS `promotion_supplier_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_supplier_mapping` (
  `promotion_supplier_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `promotion_item_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_supplier_mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_supplier_mapping`
--

LOCK TABLES `promotion_supplier_mapping` WRITE;
/*!40000 ALTER TABLE `promotion_supplier_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_supplier_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_type`
--

DROP TABLE IF EXISTS `promotion_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_type` (
  `promotion_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_type_name` varchar(200) DEFAULT NULL,
  `promotion_type_description` mediumtext,
  `promotion_type_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_type`
--

LOCK TABLES `promotion_type` WRITE;
/*!40000 ALTER TABLE `promotion_type` DISABLE KEYS */;
INSERT INTO `promotion_type` VALUES (1,'discount','discount directly on the item price',1),(2,'reduce','reduce directly on bill total',1);
/*!40000 ALTER TABLE `promotion_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_type_field`
--

DROP TABLE IF EXISTS `promotion_type_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_type_field` (
  `promotion_type_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_type_field_name` varchar(200) DEFAULT NULL,
  `promotion_type_field_valuetype` varchar(20) DEFAULT NULL,
  `promotion_type_field_valuelength` varchar(20) DEFAULT NULL,
  `promotion_type_field_controltype` varchar(20) DEFAULT NULL,
  `promotion_type_field_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_type_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_type_field`
--

LOCK TABLES `promotion_type_field` WRITE;
/*!40000 ALTER TABLE `promotion_type_field` DISABLE KEYS */;
INSERT INTO `promotion_type_field` VALUES (1,'percentage','double','','textbox',1),(2,'amount','double','','textbox',1),(3,'apply on','int','','chechbox',1);
/*!40000 ALTER TABLE `promotion_type_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotion_type_mapping`
--

DROP TABLE IF EXISTS `promotion_type_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotion_type_mapping` (
  `promotion_type_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `promotion_type_id` int(11) DEFAULT NULL,
  `promotion_type_field_id` int(11) DEFAULT NULL,
  `promotion_type_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`promotion_type_mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotion_type_mapping`
--

LOCK TABLES `promotion_type_mapping` WRITE;
/*!40000 ALTER TABLE `promotion_type_mapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotion_type_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `return_status`
--

DROP TABLE IF EXISTS `return_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `return_status` (
  `return_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_status_name` varchar(200) DEFAULT NULL,
  `return_status_description` mediumtext,
  PRIMARY KEY (`return_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `return_status`
--

LOCK TABLES `return_status` WRITE;
/*!40000 ALTER TABLE `return_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `return_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_status`
--

DROP TABLE IF EXISTS `shipping_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_status` (
  `shipping_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_status_name` varchar(200) DEFAULT NULL,
  `shipping_status_description` mediumtext,
  `shipping_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`shipping_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_status`
--

LOCK TABLES `shipping_status` WRITE;
/*!40000 ALTER TABLE `shipping_status` DISABLE KEYS */;
INSERT INTO `shipping_status` VALUES (1,'Ready to pickup','Ready to be picked up by the shipper',1),(2,'On the way','Item is being shipped to customer',1),(3,'Complete','Item is shipped to customer successfully',1),(4,'Canceled','Item is canceled',1);
/*!40000 ALTER TABLE `shipping_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_config`
--

DROP TABLE IF EXISTS `site_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` mediumtext,
  `config_description` mediumtext,
  `config_value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_config`
--

LOCK TABLES `site_config` WRITE;
/*!40000 ALTER TABLE `site_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supervisor`
--

DROP TABLE IF EXISTS `supervisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supervisor` (
  `sup_username` varchar(200) NOT NULL DEFAULT '',
  `sup_password` varchar(200) DEFAULT NULL,
  `sup_name` varchar(200) DEFAULT NULL,
  `sup_email` varchar(200) DEFAULT NULL,
  `sup_phone` varchar(200) DEFAULT NULL,
  `sup_creationdate` date DEFAULT NULL,
  `sup_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supervisor`
--

LOCK TABLES `supervisor` WRITE;
/*!40000 ALTER TABLE `supervisor` DISABLE KEYS */;
/*!40000 ALTER TABLE `supervisor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `sup_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_name` mediumtext,
  `sup_telephone` varchar(200) DEFAULT NULL,
  `sup_companyemail` varchar(200) DEFAULT NULL,
  `sup_contact_name` mediumtext,
  `sup_contact_title` mediumtext,
  `sup_contact_cellphone` varchar(200) DEFAULT NULL,
  `sup_contact_email` varchar(200) DEFAULT NULL,
  `sup_supervisor_username` varchar(200) DEFAULT NULL,
  `sup_joindate` date DEFAULT NULL,
  `sup_bank` mediumtext,
  `sup_bank_branch` mediumtext,
  `sup_bank_address` mediumtext,
  `sup_bank_accountnum` mediumtext,
  `sup_bank_accountname` mediumtext,
  `sup_username` varchar(200) DEFAULT NULL,
  `sup_password` varchar(200) DEFAULT NULL,
  `sup_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES (1,'cong ty ABC','0838123456','contact@abc.com','tai pham','director','0937123456','taipham@asiantechhub.com','supervisor1','0000-00-00','vietcombank','quan 10','so 1 dien bien phu','vcb1234567','cong ty ABC','abc','123456',1),(2,'cong ty XYZ','0838123456','contact@abc.com','tu vuong','manager','0937123456','tuvuong@asiantechhub.com','supervisor2','0000-00-00','vietcombank','quan 10','so 1 dien bien phu','vcb1234567','cong ty XYZ','xyz','123456',1),(3,'cong ty DEF','0838123456','contact@abc.com','tdat huynh','manager','0937123456','dathuynh@asiantechhub.com','supervisor2','0000-00-00','vietcombank','quan 10','so 1 dien bien phu','vcb1234567','cong ty DEF','def','123456',1);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_category_mapping`
--

DROP TABLE IF EXISTS `supplier_category_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_category_mapping` (
  `sup_cate_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sup_cate_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_cate_mapping_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_category_mapping`
--

LOCK TABLES `supplier_category_mapping` WRITE;
/*!40000 ALTER TABLE `supplier_category_mapping` DISABLE KEYS */;
INSERT INTO `supplier_category_mapping` VALUES (1,1,1,1),(2,1,2,1),(3,1,3,1),(4,1,4,1),(5,2,1,1),(6,2,2,1),(7,2,3,1),(8,3,1,1),(9,3,2,1);
/*!40000 ALTER TABLE `supplier_category_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_contract_detail`
--

DROP TABLE IF EXISTS `supplier_contract_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_contract_detail` (
  `sup_contract_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_id` int(11) DEFAULT NULL,
  `sup_contracttype` int(11) DEFAULT NULL,
  `sup_contract_number` varchar(200) DEFAULT NULL,
  `sup_contract_signdate` date DEFAULT NULL,
  `sup_contract_enddate` date DEFAULT NULL,
  `sup_contract_percentage` double DEFAULT NULL,
  `sup_contract_staticfee` double DEFAULT NULL,
  `sup_contract_shippinghandle` tinyint(4) DEFAULT NULL,
  `sup_contract_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_contract_detail`
--

LOCK TABLES `supplier_contract_detail` WRITE;
/*!40000 ALTER TABLE `supplier_contract_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_contract_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_contract_item_detail`
--

DROP TABLE IF EXISTS `supplier_contract_item_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_contract_item_detail` (
  `sup_contract_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_contract_id` int(11) DEFAULT NULL,
  `sup_contract_item_value` double DEFAULT NULL,
  PRIMARY KEY (`sup_contract_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_contract_item_detail`
--

LOCK TABLES `supplier_contract_item_detail` WRITE;
/*!40000 ALTER TABLE `supplier_contract_item_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_contract_item_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_contracttype`
--

DROP TABLE IF EXISTS `supplier_contracttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_contracttype` (
  `sup_contracttype_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_contracttype_name` varchar(200) DEFAULT NULL,
  `sup_contracttype_description` mediumtext,
  `sup_contracttype_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_contracttype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_contracttype`
--

LOCK TABLES `supplier_contracttype` WRITE;
/*!40000 ALTER TABLE `supplier_contracttype` DISABLE KEYS */;
INSERT INTO `supplier_contracttype` VALUES (1,'percentage','hop dong hoa hong phan tram',1),(2,'static commision','hop dong hoa hong co dinh',1);
/*!40000 ALTER TABLE `supplier_contracttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_order`
--

DROP TABLE IF EXISTS `supplier_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_order` (
  `sup_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sup_id` int(11) DEFAULT NULL,
  `main_order` bigint(20) DEFAULT NULL,
  `sup_order_date` date DEFAULT NULL,
  `sup_shipping_name` varchar(200) DEFAULT NULL,
  `sup_shipping_trackingwebsite` varchar(200) DEFAULT NULL,
  `sup_shipping_trackingnumber` varchar(200) DEFAULT NULL,
  `sup_shipping_warehouse` int(11) DEFAULT NULL,
  `sup_shipping_shipdate` date DEFAULT NULL,
  `sup_order_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`sup_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_order`
--

LOCK TABLES `supplier_order` WRITE;
/*!40000 ALTER TABLE `supplier_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_order_item`
--

DROP TABLE IF EXISTS `supplier_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_order_item` (
  `sup_order_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sup_order_id` bigint(20) DEFAULT NULL,
  `sup_order_prod_id` bigint(20) DEFAULT NULL,
  `sup_order_prod_variant_mapping_id` bigint(20) DEFAULT NULL,
  `sup_order_prod_supplierinternalprodid` varchar(200) DEFAULT NULL,
  `sup_order_item_price` double DEFAULT NULL,
  `sup_order_item_saleprice` double DEFAULT NULL,
  `sup_order_item_commision` double DEFAULT NULL,
  `sup_order_warehouse` mediumtext,
  `sup_order_detail_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`sup_order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_order_item`
--

LOCK TABLES `supplier_order_item` WRITE;
/*!40000 ALTER TABLE `supplier_order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_warehouse`
--

DROP TABLE IF EXISTS `supplier_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_warehouse` (
  `sup_warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_id` int(11) DEFAULT NULL,
  `sup_warehouse_name` mediumtext,
  `sup_warehouse_default` tinyint(4) DEFAULT NULL,
  `sup_warehouse_street` mediumtext,
  `sup_warehouse_country` int(11) DEFAULT NULL,
  `sup_warehouse_city` int(11) DEFAULT NULL,
  `sup_warehouse_district` int(11) DEFAULT NULL,
  `sup_warehouse_contactperson` varchar(200) DEFAULT NULL,
  `sup_warehouse_contactphone` varchar(200) DEFAULT NULL,
  `sup_warehouse_contactmail` varchar(200) DEFAULT NULL,
  `sup_warehouse_workinghour` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`sup_warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_warehouse`
--

LOCK TABLES `supplier_warehouse` WRITE;
/*!40000 ALTER TABLE `supplier_warehouse` DISABLE KEYS */;
INSERT INTO `supplier_warehouse` VALUES (1,1,'main warehouse',1,'so 1 pham van dong, thu duc',0,0,0,'Ong Bay','01212122121','','7-17'),(2,1,'sub warehouse',0,'so 2 pham van dong, thu duc',0,0,0,'Ong Bay','01212122121','','7-17'),(3,2,'main warehouse',1,'so 3 pham van dong, thu duc',0,0,0,'Ong Bay','01212122121','','7-17');
/*!40000 ALTER TABLE `supplier_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_warehouse_mapping`
--

DROP TABLE IF EXISTS `supplier_warehouse_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier_warehouse_mapping` (
  `sup_warehouse_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `sup_warehouse_mapping_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`sup_warehouse_mapping_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_warehouse_mapping`
--

LOCK TABLES `supplier_warehouse_mapping` WRITE;
/*!40000 ALTER TABLE `supplier_warehouse_mapping` DISABLE KEYS */;
INSERT INTO `supplier_warehouse_mapping` VALUES (1,1,1,1),(2,1,2,1),(3,2,3,1);
/*!40000 ALTER TABLE `supplier_warehouse_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_status`
--

DROP TABLE IF EXISTS `transaction_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_status` (
  `transaction_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_status_name` varchar(200) DEFAULT NULL,
  `transaction_status_description` mediumtext,
  `transaction_status_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`transaction_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_status`
--

LOCK TABLES `transaction_status` WRITE;
/*!40000 ALTER TABLE `transaction_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher`
--

DROP TABLE IF EXISTS `voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voucher` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_code` varchar(50) DEFAULT NULL,
  `voucher_description` mediumtext,
  `discount_value` double DEFAULT NULL,
  `discount_percentage` double DEFAULT NULL,
  `multiple_use` tinyint(4) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `apply_for_customer_type` int(11) DEFAULT NULL,
  `voucher_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`voucher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher`
--

LOCK TABLES `voucher` WRITE;
/*!40000 ALTER TABLE `voucher` DISABLE KEYS */;
INSERT INTO `voucher` VALUES (1,'NOEL2015','voucher for noel 2015 season',0,25,1,'2015-12-25','2016-12-25',0,1);
/*!40000 ALTER TABLE `voucher` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-09 13:19:10
