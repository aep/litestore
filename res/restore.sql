-- MySQL dump 10.11
--
-- Host: localhost    Database: restore
-- ------------------------------------------------------
-- Server version	5.0.51a

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
-- Table structure for table `address_book`
--

DROP TABLE IF EXISTS `address_book`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `address_book` (
  `address_book_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL,
  `entry_gender` char(1) NOT NULL,
  `entry_company` varchar(32) default NULL,
  `entry_firstname` varchar(32) NOT NULL,
  `entry_lastname` varchar(32) NOT NULL,
  `entry_street_address` varchar(64) NOT NULL,
  `entry_suburb` varchar(32) default NULL,
  `entry_postcode` varchar(10) NOT NULL,
  `entry_city` varchar(32) NOT NULL,
  `entry_state` varchar(32) default NULL,
  `entry_country_id` int(11) NOT NULL default '0',
  `entry_zone_id` int(11) NOT NULL default '0',
  `address_date_added` datetime default '0000-00-00 00:00:00',
  `address_last_modified` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`address_book_id`),
  KEY `idx_address_book_customers_id` (`customers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `address_book`
--

LOCK TABLES `address_book` WRITE;
/*!40000 ALTER TABLE `address_book` DISABLE KEYS */;
INSERT INTO `address_book` VALUES (1,1,'','<<RSTI_COMPANY_NAME>>','<<RSTI_OWNER_FIRST_NAME>>','<<RSTI_OWNER_LAST_NAME>>','<<RSTI_OWNER_STREET>>','','<<RSTI_OWNER_POSTCODE>>','<<RSTI_OWNER_CITY>>','',81,94,'0000-00-00 00:00:00','2008-05-15 13:08:17');
/*!40000 ALTER TABLE `address_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `address_format`
--

DROP TABLE IF EXISTS `address_format`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `address_format` (
  `address_format_id` int(11) NOT NULL auto_increment,
  `address_format` varchar(128) NOT NULL,
  `address_summary` varchar(48) NOT NULL,
  PRIMARY KEY  (`address_format_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `address_format`
--

LOCK TABLES `address_format` WRITE;
/*!40000 ALTER TABLE `address_format` DISABLE KEYS */;
INSERT INTO `address_format` VALUES (1,'$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country'),(2,'$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country'),(3,'$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country'),(4,'$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country','$postcode / $country'),(5,'$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');
/*!40000 ALTER TABLE `address_format` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_access`
--

DROP TABLE IF EXISTS `admin_access`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `admin_access` (
  `customers_id` varchar(32) NOT NULL default '0',
  `configuration` int(1) NOT NULL default '0',
  `modules` int(1) NOT NULL default '0',
  `countries` int(1) NOT NULL default '0',
  `currencies` int(1) NOT NULL default '0',
  `zones` int(1) NOT NULL default '0',
  `geo_zones` int(1) NOT NULL default '0',
  `tax_classes` int(1) NOT NULL default '0',
  `tax_rates` int(1) NOT NULL default '0',
  `accounting` int(1) NOT NULL default '0',
  `backup` int(1) NOT NULL default '0',
  `cache` int(1) NOT NULL default '0',
  `server_info` int(1) NOT NULL default '0',
  `whos_online` int(1) NOT NULL default '0',
  `languages` int(1) NOT NULL default '0',
  `define_language` int(1) NOT NULL default '0',
  `orders_status` int(1) NOT NULL default '0',
  `shipping_status` int(1) NOT NULL default '0',
  `module_export` int(1) NOT NULL default '0',
  `customers` int(1) NOT NULL default '0',
  `create_account` int(1) NOT NULL default '0',
  `customers_status` int(1) NOT NULL default '0',
  `orders` int(1) NOT NULL default '0',
  `campaigns` int(1) NOT NULL default '0',
  `print_packingslip` int(1) NOT NULL default '0',
  `print_order` int(1) NOT NULL default '0',
  `popup_memo` int(1) NOT NULL default '0',
  `coupon_admin` int(1) NOT NULL default '0',
  `listcategories` int(1) NOT NULL default '0',
  `gv_queue` int(1) NOT NULL default '0',
  `gv_mail` int(1) NOT NULL default '0',
  `gv_sent` int(1) NOT NULL default '0',
  `validproducts` int(1) NOT NULL default '0',
  `validcategories` int(1) NOT NULL default '0',
  `mail` int(1) NOT NULL default '0',
  `categories` int(1) NOT NULL default '0',
  `new_attributes` int(1) NOT NULL default '0',
  `products_attributes` int(1) NOT NULL default '0',
  `manufacturers` int(1) NOT NULL default '0',
  `reviews` int(1) NOT NULL default '0',
  `specials` int(1) NOT NULL default '0',
  `stats_products_expected` int(1) NOT NULL default '0',
  `stats_products_viewed` int(1) NOT NULL default '0',
  `stats_products_purchased` int(1) NOT NULL default '0',
  `stats_customers` int(1) NOT NULL default '0',
  `stats_sales_report` int(1) NOT NULL default '0',
  `stats_campaigns` int(1) NOT NULL default '0',
  `banner_manager` int(1) NOT NULL default '0',
  `banner_statistics` int(1) NOT NULL default '0',
  `module_newsletter` int(1) NOT NULL default '0',
  `start` int(1) NOT NULL default '0',
  `content_manager` int(1) NOT NULL default '0',
  `content_preview` int(1) NOT NULL default '0',
  `credits` int(1) NOT NULL default '0',
  `blacklist` int(1) NOT NULL default '0',
  `orders_edit` int(1) NOT NULL default '0',
  `popup_image` int(1) NOT NULL default '0',
  `export` int(1) NOT NULL default '0',
  `csv_backend` int(1) NOT NULL default '0',
  `products_vpe` int(1) NOT NULL default '0',
  `cross_sell_groups` int(1) NOT NULL default '0',
  `stats_unsold_carts` int(11) NOT NULL default '0',
  `fck_wrapper` int(1) NOT NULL default '0',
  `filemanager` int(1) NOT NULL default '0',
  `adsense` int(1) NOT NULL default '0',
  `adwords` int(1) NOT NULL default '0',
  `style` int(1) NOT NULL default '0',
  `metatags` int(1) NOT NULL default '0',
  PRIMARY KEY  (`customers_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `admin_access`
--

LOCK TABLES `admin_access` WRITE;
/*!40000 ALTER TABLE `admin_access` DISABLE KEYS */;
INSERT INTO `admin_access` 
VALUES ('1',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1),   
  ('groups',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,3,3,3,3,3,3,3,4,4,4,4,2,4,2,2,2,2,5,5,5,5,5,5,5,5,2,2,2,2,2,2,2,2,2,2,2,1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `admin_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banktransfer`
--

DROP TABLE IF EXISTS `banktransfer`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `banktransfer` (
  `orders_id` int(11) NOT NULL default '0',
  `banktransfer_owner` varchar(64) default NULL,
  `banktransfer_number` varchar(24) default NULL,
  `banktransfer_bankname` varchar(255) default NULL,
  `banktransfer_blz` varchar(8) default NULL,
  `banktransfer_status` int(11) default NULL,
  `banktransfer_prz` char(2) default NULL,
  `banktransfer_fax` char(2) default NULL,
  KEY `orders_id` (`orders_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `banktransfer`
--

LOCK TABLES `banktransfer` WRITE;
/*!40000 ALTER TABLE `banktransfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `banktransfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `banners` (
  `banners_id` int(11) NOT NULL auto_increment,
  `banners_title` varchar(64) NOT NULL,
  `banners_url` varchar(255) NOT NULL,
  `banners_image` varchar(64) NOT NULL,
  `banners_group` varchar(10) NOT NULL,
  `banners_html_text` text,
  `expires_impressions` int(7) default '0',
  `expires_date` datetime default NULL,
  `date_scheduled` datetime default NULL,
  `date_added` datetime NOT NULL,
  `date_status_change` datetime default NULL,
  `status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`banners_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (13,'banner','','meinonlineshop.de.png','banner','',NULL,NULL,NULL,'2008-06-11 13:44:56',NULL,1);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners_history`
--

DROP TABLE IF EXISTS `banners_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `banners_history` (
  `banners_history_id` int(11) NOT NULL auto_increment,
  `banners_id` int(11) NOT NULL,
  `banners_shown` int(5) NOT NULL default '0',
  `banners_clicked` int(5) NOT NULL default '0',
  `banners_history_date` datetime NOT NULL,
  PRIMARY KEY  (`banners_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `banners_history`
--

LOCK TABLES `banners_history` WRITE;
/*!40000 ALTER TABLE `banners_history` DISABLE KEYS */;
INSERT INTO `banners_history` VALUES (39,13,28,0,'2008-06-19 15:50:59');
/*!40000 ALTER TABLE `banners_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `campaigns` (
  `campaigns_id` int(11) NOT NULL auto_increment,
  `campaigns_name` varchar(32) NOT NULL default '',
  `campaigns_refID` varchar(64) default NULL,
  `campaigns_leads` int(11) NOT NULL default '0',
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  PRIMARY KEY  (`campaigns_id`),
  KEY `IDX_CAMPAIGNS_NAME` (`campaigns_name`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `campaigns`
--

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns_ip`
--

DROP TABLE IF EXISTS `campaigns_ip`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `campaigns_ip` (
  `user_ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL,
  `campaign` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `campaigns_ip`
--

LOCK TABLES `campaigns_ip` WRITE;
/*!40000 ALTER TABLE `campaigns_ip` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaigns_ip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `card_blacklist`
--

DROP TABLE IF EXISTS `card_blacklist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `card_blacklist` (
  `blacklist_id` int(5) NOT NULL auto_increment,
  `blacklist_card_number` varchar(20) NOT NULL default '',
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  KEY `blacklist_id` (`blacklist_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `card_blacklist`
--

LOCK TABLES `card_blacklist` WRITE;
/*!40000 ALTER TABLE `card_blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `card_blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL auto_increment,
  `categories_image` varchar(100) default NULL,
  `categories_teaser` varchar(100) default '',
  `parent_id` int(11) NOT NULL default '0',
  `categories_status` tinyint(1) unsigned NOT NULL default '1',
  `categories_template` varchar(64) default NULL,
  `listing_template` varchar(64) default NULL,
  `sort_order` int(3) NOT NULL default '0',
  `products_sorting` varchar(32) default NULL,
  `products_sorting2` varchar(32) default NULL,
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  `categories_key` varchar(100) default '',
  `ibc_devices` varchar(64) default NULL,
  PRIMARY KEY  (`categories_id`),
  KEY `idx_categories_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=715 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_description`
--

DROP TABLE IF EXISTS `categories_description`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `categories_description` (
  `categories_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `categories_name` varchar(255) NOT NULL default '',
  `categories_heading_title` varchar(255) NOT NULL default '',
  `categories_description` text NOT NULL,
  `categories_meta_title` varchar(100) NOT NULL default '',
  `categories_meta_description` varchar(255) NOT NULL default '',
  `categories_meta_keywords` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`categories_id`,`languages_id`),
  KEY `idx_categories_name` (`categories_name`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `categories_description`
--

LOCK TABLES `categories_description` WRITE;
/*!40000 ALTER TABLE `categories_description` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cm_file_flags`
--

DROP TABLE IF EXISTS `cm_file_flags`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `cm_file_flags` (
  `file_flag` int(11) NOT NULL,
  `file_flag_name` varchar(32) NOT NULL,
  PRIMARY KEY  (`file_flag`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `cm_file_flags`
--

LOCK TABLES `cm_file_flags` WRITE;
/*!40000 ALTER TABLE `cm_file_flags` DISABLE KEYS */;
INSERT INTO `cm_file_flags` VALUES (0,'information'),(1,'content');
/*!40000 ALTER TABLE `cm_file_flags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `configuration` (
  `configuration_id` int(11) NOT NULL auto_increment,
  `configuration_key` varchar(64) NOT NULL,
  `configuration_value` varchar(255) NOT NULL,
  `configuration_group_id` int(11) NOT NULL,
  `sort_order` int(5) default NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL,
  `use_function` varchar(255) default NULL,
  `set_function` varchar(255) default NULL,
  PRIMARY KEY  (`configuration_id`),
  KEY `idx_configuration_group_id` (`configuration_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=383 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `configuration`
--



LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` VALUES 
    (1,'STORE_NAME','<<RSTI_STORE_NAME>>',1,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (2,'STORE_OWNER','<<RSTI_STORE_NAME>>',1,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (3,'STORE_OWNER_EMAIL_ADDRESS','<<RSTI_OWNER_MAIL>>',1,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (4,'EMAIL_FROM','<<RSTI_STORE_MAIL>>',1,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (5,'STORE_COUNTRY','81',1,6,NULL,'0000-00-00 00:00:00','xtc_get_country_name','xtc_cfg_pull_down_country_list('),
    (6,'STORE_ZONE','94',1,7,NULL,'0000-00-00 00:00:00','xtc_cfg_get_zone_name','xtc_cfg_pull_down_zone_list('),
    (7,'EXPECTED_PRODUCTS_SORT','desc',1,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'asc\', \'desc\'),'),
    (8,'EXPECTED_PRODUCTS_FIELD','date_expected',1,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'products_name\', \'date_expected\'),'),
    (9,'USE_DEFAULT_LANGUAGE_CURRENCY','false',1,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (10,'SEARCH_ENGINE_FRIENDLY_URLS','false',2147483647,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (11,'DISPLAY_CART','false',1,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (12,'ADVANCED_SEARCH_DEFAULT_OPERATOR','and',1,15,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'and\', \'or\'),'),
    (13,'STORE_NAME_ADDRESS','Test',1,16,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea('),
    (14,'SHOW_COUNTS','false',1,17,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (15,'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN','0',1,20,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('),
    (16,'DEFAULT_CUSTOMERS_STATUS_ID_GUEST','1',1,21,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('),
    (17,'DEFAULT_CUSTOMERS_STATUS_ID','2',1,23,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('),
    (18,'ALLOW_ADD_TO_CART','false',1,24,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (19,'CURRENT_TEMPLATE','restore',666,26,NULL,'0000-00-00 00:00:00',NULL,''),
    (20,'PRICE_IS_BRUTTO','false',1,27,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (21,'PRICE_PRECISION','4',1,28,NULL,'0000-00-00 00:00:00',NULL,''),
    (22,'CC_KEYCHAIN','64854354354',1,29,NULL,'0000-00-00 00:00:00',NULL,''),
    (23,'ENTRY_FIRST_NAME_MIN_LENGTH','2',2,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (24,'ENTRY_LAST_NAME_MIN_LENGTH','2',2,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (25,'ENTRY_DOB_MIN_LENGTH','10',2,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (26,'ENTRY_EMAIL_ADDRESS_MIN_LENGTH','6',2,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (27,'ENTRY_STREET_ADDRESS_MIN_LENGTH','5',2,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (28,'ENTRY_COMPANY_MIN_LENGTH','2',2,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (29,'ENTRY_POSTCODE_MIN_LENGTH','4',2,7,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (30,'ENTRY_CITY_MIN_LENGTH','3',2,8,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (31,'ENTRY_STATE_MIN_LENGTH','2',2,9,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (32,'ENTRY_TELEPHONE_MIN_LENGTH','3',2,10,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (33,'ENTRY_PASSWORD_MIN_LENGTH','5',2,11,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (34,'CC_OWNER_MIN_LENGTH','3',2,12,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (35,'CC_NUMBER_MIN_LENGTH','10',2,13,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (36,'REVIEW_TEXT_MIN_LENGTH','50',2,14,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (37,'MIN_DISPLAY_BESTSELLERS','1',2,15,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (38,'MIN_DISPLAY_ALSO_PURCHASED','1',2,16,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (39,'MAX_ADDRESS_BOOK_ENTRIES','5',3,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (40,'MAX_DISPLAY_SEARCH_RESULTS','48',3,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (41,'MAX_DISPLAY_PAGE_LINKS','5',3,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (42,'MAX_DISPLAY_SPECIAL_PRODUCTS','9',3,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (43,'MAX_DISPLAY_NEW_PRODUCTS','9',3,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (44,'MAX_DISPLAY_UPCOMING_PRODUCTS','10',3,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (45,'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST','0',3,7,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (46,'MAX_MANUFACTURERS_LIST','1',3,7,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (47,'MAX_DISPLAY_MANUFACTURER_NAME_LEN','15',3,8,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (48,'MAX_DISPLAY_NEW_REVIEWS','6',3,9,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (49,'MAX_RANDOM_SELECT_REVIEWS','10',3,10,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (50,'MAX_RANDOM_SELECT_NEW','10',3,11,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (51,'MAX_RANDOM_SELECT_SPECIALS','10',3,12,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (52,'MAX_DISPLAY_CATEGORIES_PER_ROW','3',3,13,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (53,'MAX_DISPLAY_PRODUCTS_NEW','10',3,14,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (54,'MAX_DISPLAY_BESTSELLERS','10',3,15,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (55,'MAX_DISPLAY_ALSO_PURCHASED','6',3,16,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (56,'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX','6',3,17,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (57,'MAX_DISPLAY_ORDER_HISTORY','10',3,18,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (58,'PRODUCT_REVIEWS_VIEW','5',3,19,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (59,'MAX_PRODUCTS_QTY','1000',3,21,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL),
    (60,'MAX_DISPLAY_NEW_PRODUCTS_DAYS','30',3,22,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL),
    (61,'CONFIG_CALCULATE_IMAGE_SIZE','true',4,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (62,'IMAGE_QUALITY','80',4,2,'2003-12-15 12:10:45','0000-00-00 00:00:00',NULL,NULL),
    (63,'PRODUCT_IMAGE_THUMBNAIL_WIDTH','80',4,7,'2003-12-15 12:10:45','0000-00-00 00:00:00',NULL,NULL),
    (64,'PRODUCT_IMAGE_THUMBNAIL_HEIGHT','80',4,8,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (65,'PRODUCT_IMAGE_INFO_WIDTH','160',4,9,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (66,'PRODUCT_IMAGE_INFO_HEIGHT','160',4,10,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (67,'PRODUCT_IMAGE_POPUP_WIDTH','350',4,11,'2003-12-15 12:11:00','0000-00-00 00:00:00',NULL,NULL),
    (68,'PRODUCT_IMAGE_POPUP_HEIGHT','350',4,12,'2003-12-15 12:11:09','0000-00-00 00:00:00',NULL,NULL),
    (69,'PRODUCT_IMAGE_THUMBNAIL_BEVEL','',4,13,'2003-12-15 13:14:39','0000-00-00 00:00:00','',''),
    (70,'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE','',4,14,'2003-12-15 13:13:37','0000-00-00 00:00:00',NULL,NULL),
    (71,'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE','',4,15,'2003-12-15 13:14:57','0000-00-00 00:00:00',NULL,NULL),
    (72,'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES','',4,16,'2003-12-15 13:19:45','0000-00-00 00:00:00',NULL,NULL),
    (73,'PRODUCT_IMAGE_THUMBNAIL_MERGE','',4,17,'2003-12-15 12:01:43','0000-00-00 00:00:00',NULL,NULL),
    (74,'PRODUCT_IMAGE_THUMBNAIL_FRAME','',4,18,'2003-12-15 13:19:37','0000-00-00 00:00:00',NULL,NULL),
    (75,'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW','',4,19,'2003-12-15 13:15:14','0000-00-00 00:00:00',NULL,NULL),
    (76,'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR','',4,20,'2003-12-15 12:02:19','0000-00-00 00:00:00',NULL,NULL),
    (77,'PRODUCT_IMAGE_INFO_BEVEL','',4,21,'2003-12-15 13:42:09','0000-00-00 00:00:00',NULL,NULL),
    (78,'PRODUCT_IMAGE_INFO_GREYSCALE','',4,22,'2003-12-15 13:18:00','0000-00-00 00:00:00',NULL,NULL),
    (79,'PRODUCT_IMAGE_INFO_ELLIPSE','',4,23,'2003-12-15 13:41:53','0000-00-00 00:00:00',NULL,NULL),
    (80,'PRODUCT_IMAGE_INFO_ROUND_EDGES','',4,24,'2003-12-15 13:21:55','0000-00-00 00:00:00',NULL,NULL),
    (81,'PRODUCT_IMAGE_INFO_MERGE','',4,25,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (82,'PRODUCT_IMAGE_INFO_FRAME','',4,26,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (83,'PRODUCT_IMAGE_INFO_DROP_SHADDOW','',4,27,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (84,'PRODUCT_IMAGE_INFO_MOTION_BLUR','',4,28,'2003-12-15 13:21:18','0000-00-00 00:00:00',NULL,NULL),
    (85,'PRODUCT_IMAGE_POPUP_BEVEL','',4,29,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (86,'PRODUCT_IMAGE_POPUP_GREYSCALE','',4,30,'2003-12-15 13:22:58','0000-00-00 00:00:00',NULL,NULL),
    (87,'PRODUCT_IMAGE_POPUP_ELLIPSE','',4,31,'2003-12-15 13:22:51','0000-00-00 00:00:00',NULL,NULL),
    (88,'PRODUCT_IMAGE_POPUP_ROUND_EDGES','',4,32,'2003-12-15 13:23:17','0000-00-00 00:00:00',NULL,NULL),
    (89,'PRODUCT_IMAGE_POPUP_MERGE','',4,33,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (90,'PRODUCT_IMAGE_POPUP_FRAME','',4,34,'2003-12-15 13:22:43','0000-00-00 00:00:00',NULL,NULL),
    (91,'PRODUCT_IMAGE_POPUP_DROP_SHADDOW','',4,35,'2003-12-15 13:22:26','0000-00-00 00:00:00',NULL,NULL),
    (92,'PRODUCT_IMAGE_POPUP_MOTION_BLUR','',4,36,'2003-12-15 13:22:32','0000-00-00 00:00:00',NULL,NULL),
    (93,'MO_PICS','0',2147483647,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL),
    (94,'IMAGE_MANIPULATOR','image_manipulator_GD2.php',4,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'image_manipulator_GD2.php\', \'image_manipulator_GD1.php\'),'),
    (95,'ACCOUNT_GENDER','true',5,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (96,'ACCOUNT_DOB','true',5,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (97,'ACCOUNT_COMPANY','true',5,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (98,'ACCOUNT_SUBURB','false',5,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (99,'ACCOUNT_STATE','true',5,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (100,'ACCOUNT_OPTIONS','account',1000000017,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'account\', \'guest\', \'both\'),'),
    (101,'DELETE_GUEST_ACCOUNT','true',1000000017,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (102,'MODULE_PAYMENT_INSTALLED','banktransfer.php;cod.php',6,0,'2008-05-15 14:28:06','0000-00-00 00:00:00',NULL,NULL),
    (103,'MODULE_ORDER_TOTAL_INSTALLED','ot_subtotal.php;ot_discount.php;ot_shipping.php;ot_subtotal_no_tax.php;ot_tax.php;ot_total.php',6,0,'2008-02-12 14:49:24','0000-00-00 00:00:00',NULL,NULL),
    (104,'MODULE_SHIPPING_INSTALLED','dp.php;selfpickup.php',6,0,'2008-05-15 16:29:07','0000-00-00 00:00:00',NULL,NULL),
    (105,'DEFAULT_CURRENCY','EUR',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (106,'DEFAULT_LANGUAGE','de',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (107,'DEFAULT_ORDERS_STATUS_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (108,'DEFAULT_PRODUCTS_VPE_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (109,'DEFAULT_SHIPPING_STATUS_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (110,'MODULE_ORDER_TOTAL_SHIPPING_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (111,'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER','30',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (112,'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING','false',6,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (113,'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER','50',6,4,NULL,'0000-00-00 00:00:00','currencies->format',NULL),
    (114,'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION','national',6,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'national\', \'international\', \'both\'),'),
    (115,'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (116,'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER','10',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (117,'MODULE_ORDER_TOTAL_TAX_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (118,'MODULE_ORDER_TOTAL_TAX_SORT_ORDER','50',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (119,'MODULE_ORDER_TOTAL_TOTAL_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (120,'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER','99',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (121,'MODULE_ORDER_TOTAL_DISCOUNT_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (122,'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER','20',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (123,'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (124,'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER','40',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (125,'SHIPPING_ORIGIN_COUNTRY','81',7,1,NULL,'0000-00-00 00:00:00','xtc_get_country_name','xtc_cfg_pull_down_country_list('),
    (126,'SHIPPING_ORIGIN_ZIP','99817',7,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (127,'SHIPPING_MAX_WEIGHT','30',7,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (128,'SHIPPING_BOX_WEIGHT','3',7,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (129,'SHIPPING_BOX_PADDING','10',7,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (130,'SHOW_SHIPPING','true',7,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (131,'SHIPPING_INFOS','1',7,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (132,'PRODUCT_LIST_FILTER','1',8,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (133,'STOCK_CHECK','false',9,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (134,'ATTRIBUTE_STOCK_CHECK','true',9,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (135,'STOCK_LIMITED','false',9,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (136,'STOCK_ALLOW_CHECKOUT','true',9,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (137,'STOCK_MARK_PRODUCT_OUT_OF_STOCK','***',9,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (138,'STOCK_REORDER_LEVEL','5',9,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (139,'STORE_PAGE_PARSE_TIME','false',10,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (140,'STORE_PAGE_PARSE_TIME_LOG','/var/log/www/tep/page_parse_time.log',10,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (141,'STORE_PARSE_DATE_TIME_FORMAT','%d/%m/%Y %H:%M:%S',10,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (142,'DISPLAY_PAGE_PARSE_TIME','true',10,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (143,'STORE_DB_TRANSACTIONS','false',10,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (144,'USE_CACHE','false',11,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (145,'DIR_FS_CACHE','cache',11,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (146,'CACHE_LIFETIME','3600',11,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (147,'CACHE_CHECK','true',11,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (148,'DB_CACHE','false',11,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (149,'DB_CACHE_EXPIRE','3600',11,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (150,'EMAIL_TRANSPORT','sendmail',12,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'sendmail\', \'smtp\', \'mail\'),'),
    (151,'SENDMAIL_PATH','/usr/sbin/sendmail',12,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (152,'SMTP_MAIN_SERVER','',12,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (153,'SMTP_Backup_Server','',12,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (154,'SMTP_PORT','',12,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (155,'SMTP_USERNAME','',12,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (156,'SMTP_PASSWORD','',12,7,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (157,'SMTP_AUTH','true',12,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (158,'EMAIL_LINEFEED','LF',12,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'LF\', \'CRLF\'),'),
    (159,'EMAIL_USE_HTML','true',12,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (160,'ENTRY_EMAIL_ADDRESS_CHECK','false',12,11,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (161,'SEND_EMAILS','true',12,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (162,'CONTACT_US_EMAIL_ADDRESS','<<RSTI_OWNER_MAIL>>',12,20,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (163,'CONTACT_US_NAME','<<RSTI_OWNER_MAIL>>',12,21,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (164,'CONTACT_US_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,22,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (165,'CONTACT_US_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,23,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (166,'CONTACT_US_EMAIL_SUBJECT','<<RSTI_OWNER_MAIL>>',12,24,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (167,'CONTACT_US_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,25,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (168,'EMAIL_SUPPORT_ADDRESS','<<RSTI_OWNER_MAIL>>',12,26,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (169,'EMAIL_SUPPORT_NAME','<<RSTI_OWNER_MAIL>>',12,27,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (170,'EMAIL_SUPPORT_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,28,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (171,'EMAIL_SUPPORT_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,29,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (172,'EMAIL_SUPPORT_SUBJECT','<<RSTI_OWNER_MAIL>>',12,30,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (173,'EMAIL_SUPPORT_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,31,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (174,'EMAIL_BILLING_ADDRESS','<<RSTI_OWNER_MAIL>>',12,32,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (175,'EMAIL_BILLING_NAME','<<RSTI_OWNER_MAIL>>',12,33,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (176,'EMAIL_BILLING_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,34,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (177,'EMAIL_BILLING_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,35,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (178,'EMAIL_BILLING_SUBJECT','<<RSTI_OWNER_MAIL>>',12,36,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (179,'EMAIL_BILLING_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,37,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (180,'EMAIL_BILLING_SUBJECT_ORDER','Ihre Onlinebestellung Nr:{$nr} vom {$date}',12,38,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (181,'DOWNLOAD_ENABLED','false',13,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (182,'DOWNLOAD_BY_REDIRECT','false',13,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (183,'DOWNLOAD_UNALLOWED_PAYMENT','banktransfer,cod,invoice,moneyorder',13,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (184,'DOWNLOAD_MIN_ORDERS_STATUS','1',13,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (185,'GZIP_COMPRESSION','false',14,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (186,'GZIP_LEVEL','5',14,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (187,'SESSION_WRITE_DIRECTORY','/tmp',15,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (188,'SESSION_FORCE_COOKIE_USE','False',15,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'),'),
    (189,'SESSION_CHECK_SSL_SESSION_ID','False',15,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'),'),
    (190,'SESSION_CHECK_USER_AGENT','False',15,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'),'),
    (191,'SESSION_CHECK_IP_ADDRESS','False',15,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'),'),
    (192,'SESSION_RECREATE','False',15,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'),'),
    (193,'META_MIN_KEYWORD_LENGTH','6',16,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (194,'META_KEYWORDS_NUMBER','20',16,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (195,'META_AUTHOR','<<RSTI_COMPANY_NAME>>',16,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (196,'META_PUBLISHER','litestore.de',16,5,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (197,'META_COMPANY','<<RSTI_COMPANY_NAME>>',16,6,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (198,'META_TOPIC','shopping',16,7,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (199,'META_REPLY_TO','',16,8,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (200,'META_REVISIT_AFTER','1',16,9,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (201,'META_ROBOTS','index,follow',16,10,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (202,'META_DESCRIPTION','<<RSTI_COMPANY_NAME>>',16,11,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (203,'META_KEYWORDS','<<RSTI_COMPANY_NAME>>',16,12,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (204,'CHECK_CLIENT_AGENT','false',16,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (205,'USE_WYSIWYG','true',1000000017,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (206,'ACTIVATE_GIFT_SYSTEM','false',1000000017,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (207,'SECURITY_CODE_LENGTH','10',1000000017,3,NULL,'2003-12-05 05:01:41',NULL,NULL),
    (208,'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT','0',1000000017,4,NULL,'2003-12-05 05:01:41',NULL,NULL),
    (209,'NEW_SIGNUP_DISCOUNT_COUPON','',1000000017,5,NULL,'2003-12-05 05:01:41',NULL,NULL),
    (210,'ACTIVATE_SHIPPING_STATUS','true',17,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (211,'DISPLAY_CONDITIONS_ON_CHECKOUT','true',17,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (212,'SHOW_IP_LOG','false',17,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (213,'GROUP_CHECK','false',17,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (214,'ACTIVATE_NAVIGATOR','false',17,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (215,'QUICKLINK_ACTIVATED','true',17,11,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (216,'ACTIVATE_REVERSE_CROSS_SELLING','true',17,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (217,'DISPLAY_REVOCATION_ON_CHECKOUT','true',17,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (218,'REVOCATION_ID','',17,14,NULL,'2003-12-05 05:01:41',NULL,NULL),
    (219,'ACCOUNT_COMPANY_VAT_CHECK','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (220,'STORE_OWNER_VAT_ID','',18,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL),
    (221,'DEFAULT_CUSTOMERS_VAT_STATUS_ID','1',18,23,'0000-00-00 00:00:00','0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('),
    (222,'ACCOUNT_COMPANY_VAT_LIVE_CHECK','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (223,'ACCOUNT_COMPANY_VAT_GROUP','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (224,'ACCOUNT_VAT_BLOCK_ERROR','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (225,'DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL','3',18,24,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('),
    (226,'GOOGLE_CONVERSION_ID','',19,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (227,'GOOGLE_LANG','de',19,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (229,'CSV_TEXTSIGN','\"',20,1,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (230,'CSV_SEPERATOR','    ',20,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (231,'COMPRESS_EXPORT','false',20,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (232,'AFTERBUY_PARTNERID','',21,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (233,'AFTERBUY_PARTNERPASS','',21,3,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (234,'AFTERBUY_USERID','',21,4,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (235,'AFTERBUY_ORDERSTATUS','1',21,5,NULL,'0000-00-00 00:00:00','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('),
    (236,'AFTERBUY_ACTIVATED','false',21,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (237,'SEARCH_IN_DESC','true',22,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (238,'SEARCH_IN_ATTR','true',22,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (239,'TRACKING_ECONDA_ACTIVE','false',23,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),'),
    (240,'TRACKING_ECONDA_ID','',23,2,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (241,'MODULE_EXPORT_INSTALLED','golem.php;image_processing.php',6,0,'2008-04-28 15:44:27','2008-01-20 16:40:06',NULL,NULL),
    (242,'MODULE_IMAGE_PROCESS_STATUS','True',6,1,NULL,'2008-01-24 14:10:12',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (243,'MODULE_PAYMENT_MONEYORDER_STATUS','True',6,1,NULL,'2008-02-13 16:25:20',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (244,'MODULE_PAYMENT_MONEYORDER_ALLOWED','',6,0,NULL,'2008-02-13 16:25:20',NULL,NULL),
    (245,'MODULE_PAYMENT_MONEYORDER_PAYTO','Der Gesamtbetrag und die Bankverbindung wird Ihnen in der AuftragsbestÃƒÂ¤tigung mitgeteilt.',6,1,NULL,'2008-02-13 16:25:20',NULL,NULL),
    (246,'MODULE_PAYMENT_MONEYORDER_SORT_ORDER','10',6,0,NULL,'2008-02-13 16:25:20',NULL,NULL),
    (247,'MODULE_PAYMENT_MONEYORDER_ZONE','0',6,2,NULL,'2008-02-13 16:25:20','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('),
    (248,'MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID','1',6,0,NULL,'2008-02-13 16:25:20','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('),
    (335,'MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID','0',6,0,NULL,'2008-04-03 14:01:33','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('),
    (334,'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER','0',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL),
    (333,'MODULE_PAYMENT_BANKTRANSFER_ALLOWED','',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL),
    (332,'MODULE_PAYMENT_BANKTRANSFER_ZONE','0',6,2,NULL,'2008-04-03 14:01:33','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('),
    (331,'MODULE_PAYMENT_BANKTRANSFER_STATUS','True',6,1,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (255,'MODULE_SHIPPING_DP_STATUS','True',6,0,NULL,'2008-04-03 13:31:21',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (256,'MODULE_SHIPPING_DP_HANDLING','0',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (257,'MODULE_SHIPPING_DP_TAX_CLASS','0',6,0,NULL,'2008-04-03 13:31:21','xtc_get_tax_class_title','xtc_cfg_pull_down_tax_classes('),
    (258,'MODULE_SHIPPING_DP_ZONE','0',6,0,NULL,'2008-04-03 13:31:21','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('),
    (259,'MODULE_SHIPPING_DP_SORT_ORDER','0',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (260,'MODULE_SHIPPING_DP_ALLOWED','',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (261,'MODULE_SHIPPING_DP_COUNTRIES_1','AD,AT,BE,CZ,DK,FO,FI,FR,GR,GL,IE,IT,LI,LU,MC,NL,PL,PT,SM,SK,SE,CH,VA,GB,SP',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (262,'MODULE_SHIPPING_DP_COST_1','5:16.50,10:20.50,20:28.50',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (263,'MODULE_SHIPPING_DP_COUNTRIES_2','AL,AM,AZ,BY,BA,BG,HR,CY,GE,GI,HU,IS,KZ,LT,MK,MT,MD,NO,SI,UA,TR,YU,RU,RO,LV,EE',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (264,'MODULE_SHIPPING_DP_COST_2','5:25.00,10:35.00,20:45.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (265,'MODULE_SHIPPING_DP_COUNTRIES_3','DZ,BH,CA,EG,IR,IQ,IL,JO,KW,LB,LY,OM,SA,SY,US,AE,YE,MA,QA,TN,PM',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (266,'MODULE_SHIPPING_DP_COST_3','5:29.00,10:39.00,20:59.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (267,'MODULE_SHIPPING_DP_COUNTRIES_4','AF,AS,AO,AI,AG,AR,AW,AU,BS,BD,BB,BZ,BJ,BM,BT,BO,BW,BR,IO,BN,BF,BI,KH,CM,CV,KY,CF,TD,CL,CN,CC,CO,KM,CG,CR,CI,CU,DM,DO,EC,SV,ER,ET,FK,FJ,GF,PF,GA,GM,GH,GD,GP,GT,GN,GW,GY,HT,HN,HK,IN,ID,JM,JP,KE,KI,KG,KP,KR,LA,LS',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (268,'MODULE_SHIPPING_DP_COST_4','5:35.00,10:50.00,20:80.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (269,'MODULE_SHIPPING_DP_COUNTRIES_5','MO,MG,MW,MY,MV,ML,MQ,MR,MU,MX,MN,MS,MZ,MM,NA,NR,NP,AN,NC,NZ,NI,NE,NG,PK,PA,PG,PY,PE,PH,PN,RE,KN,LC,VC,SN,SC,SL,SO,LK,SR,SZ,ZA,SG,TG,TH,TZ,TT,TO,TM,TV,VN,WF,VE,UG,UZ,UY,ST,SH,SD,TW,GQ,LR,DJ,CG,RW,ZM,ZW',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (270,'MODULE_SHIPPING_DP_COST_5','5:35.00,10:50.00,20:80.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (271,'MODULE_SHIPPING_DP_COUNTRIES_6','DE',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (272,'MODULE_SHIPPING_DP_COST_6','5:6.70,10:9.70,20:13.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL),
    (354,'MODULE_SHIPPING_SELFPICKUP_ALLOWED','',6,0,NULL,'2008-05-15 11:59:57',NULL,NULL),
    (355,'MODULE_SHIPPING_SELFPICKUP_SORT_ORDER','0',6,4,NULL,'2008-05-15 11:59:57',NULL,NULL),
    (353,'MODULE_SHIPPING_SELFPICKUP_STATUS','True',6,7,NULL,'2008-05-15 11:59:57',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (348,'CURRENT_BACKGROUND','gruenes1.jpg',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (349,'CURRENT_LOGO','meinonlineshop.de.png',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (350,'ADSENSE_PUBID','pub-5799004657015467',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (351,'ADSENSE_SLOT','9815371424',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (352,'ADSENSE_ACTIVE','on',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (347,'CURRENT_CSS','rot.css',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL),
    (345,'MODULE_GOLEM_FILE','golem.xml',6,1,NULL,'2008-04-28 15:44:26',NULL,''),
    (346,'MODULE_GOLEM_STATUS','True',6,1,NULL,'2008-04-28 15:44:26',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (343,'MODULE_PAYMENT_COD_SORT_ORDER','0',6,0,NULL,'2008-04-03 14:01:36',NULL,NULL),
    (344,'MODULE_PAYMENT_COD_ORDER_STATUS_ID','0',6,0,NULL,'2008-04-03 14:01:36','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('),
    (341,'MODULE_PAYMENT_COD_ALLOWED','',6,0,NULL,'2008-04-03 14:01:36',NULL,NULL),
    (342,'MODULE_PAYMENT_COD_ZONE','0',6,2,NULL,'2008-04-03 14:01:36','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('),
    (338,'MODULE_PAYMENT_BANKTRANSFER_URL_NOTE','fax.html',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL),
    (339,'MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER','0',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL),
    (340,'MODULE_PAYMENT_COD_STATUS','True',6,1,NULL,'2008-04-03 14:01:36',NULL,'xtc_cfg_select_option(array(\'True\', \'False\'), '),
    (336,'MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION','false',6,2,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'), '),
    (337,'MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ','false',6,0,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'), '),
    (1021,'GOOGLE_CONVERSION_REGISTER','',76,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea(');
    (1022,'GOOGLE_CONVERSION_BUY','',76,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea('),
    (228,'GOOGLE_CONVERSION','false',76,0,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(\'true\', \'false\'),');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;



UNLOCK TABLES;

--
-- Table structure for table `configuration_group`
--

DROP TABLE IF EXISTS `configuration_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `configuration_group` (
  `configuration_group_id` int(11) NOT NULL auto_increment,
  `configuration_group_title` varchar(64) NOT NULL,
  `configuration_group_description` varchar(255) NOT NULL,
  `sort_order` int(5) default NULL,
  `visible` int(1) default '1',
  PRIMARY KEY  (`configuration_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `configuration_group`
--

LOCK TABLES `configuration_group` WRITE;
/*!40000 ALTER TABLE `configuration_group` DISABLE KEYS */;
INSERT INTO `configuration_group` VALUES (1,'My Store','General information about my store',1,1),(2,'Minimum Values','The minimum values for functions / data',2,1),(3,'Maximum Values','The maximum values for functions / data',3,1),(4,'Images','Image parameters',4,1),(5,'Customer Details','Customer account configuration',5,1),(6,'Module Options','Hidden from configuration',6,0),(7,'Shipping/Packaging','Shipping options available at my store',7,1),(8,'Product Listing','Product Listing    configuration options',8,1),(9,'Stock','Stock configuration options',9,1),(10,'Logging','Logging configuration options',10,1),(11,'Cache','Caching configuration options',11,1),(12,'E-Mail Options','General setting for E-Mail transport and HTML E-Mails',12,1),(13,'Download','Downloadable products options',13,1),(14,'GZip Compression','GZip compression options',14,1),(15,'Sessions','Session options',15,1),(16,'Meta-Tags/Search engines','Meta-tags/Search engines',16,1),(18,'Vat ID','Vat ID',18,1),(19,'Google Conversion','Google Conversion-Tracking',19,1),(20,'Import/Export','Import/Export',20,1),(21,'Afterbuy','Afterbuy.de',21,1),(22,'Search Options','Additional Options for search function',22,1);
/*!40000 ALTER TABLE `configuration_group` ENABLE KEYS */;
UNLOCK TABLES;


-- Table structure for table `content_manager`
--


DROP TABLE IF EXISTS `content_manager`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `content_manager` (
  `content_id` int(11) NOT NULL auto_increment,
  `categories_id` int(11) NOT NULL default '0',
  `parent_id` int(11) NOT NULL default '0',
  `group_ids` text,
  `languages_id` int(11) NOT NULL default '0',
  `content_title` text NOT NULL,
  `content_heading` text NOT NULL,
  `content_text` text NOT NULL,
  `sort_order` int(4) NOT NULL default '0',
  `file_flag` int(1) NOT NULL default '0',
  `content_file` varchar(64) NOT NULL default '',
  `content_status` int(1) NOT NULL default '0',
  `content_group` int(11) NOT NULL,
  `content_delete` int(1) NOT NULL default '1',
  PRIMARY KEY  (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `content_manager`
--


LOCK TABLES `content_manager` WRITE;
/*!40000 ALTER TABLE `content_manager` DISABLE KEYS */;
INSERT INTO `content_manager` VALUES (6,0,0,'',2,'Liefer- und Versandkosten','Liefer- und Versandkosten','',0,1,'versandkosten.html',1,1,0),(7,0,0,'',2,'Privatsphäre und Datenschutz','Privatsphäre und Datenschutz','',0,1,'agb.html',0,2,0),(8,0,0,'',2,'AGB\'s','Allgemeine Gesch&auml;ftsbedingungen','',0,1,'agb.html',1,3,0),(9,0,0,'',2,'Impressum','Impressum','',0,1,'impressum.html',1,4,0),(10,0,0,'',2,'Index','','Willkommen',0,1,'',0,5,0);
/*!40000 ALTER TABLE `content_manager` ENABLE KEYS */;
UNLOCK TABLES;






--
-- Table structure for table `counter`
--

DROP TABLE IF EXISTS `counter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `counter` (
  `startdate` char(8) default NULL,
  `counter` int(12) default NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `counter`
--

LOCK TABLES `counter` WRITE;
/*!40000 ALTER TABLE `counter` DISABLE KEYS */;
/*!40000 ALTER TABLE `counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counter_history`
--

DROP TABLE IF EXISTS `counter_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `counter_history` (
  `month` char(8) default NULL,
  `counter` int(12) default NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `counter_history`
--

LOCK TABLES `counter_history` WRITE;
/*!40000 ALTER TABLE `counter_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `counter_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `countries` (
  `countries_id` int(11) NOT NULL auto_increment,
  `countries_name` varchar(64) NOT NULL,
  `countries_iso_code_2` char(2) NOT NULL,
  `countries_iso_code_3` char(3) NOT NULL,
  `address_format_id` int(11) NOT NULL,
  `status` int(1) default '1',
  PRIMARY KEY  (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','AF','AFG',1,1),(2,'Albania','AL','ALB',1,1),(3,'Algeria','DZ','DZA',1,1),(4,'American Samoa','AS','ASM',1,1),(5,'Andorra','AD','AND',1,1),(6,'Angola','AO','AGO',1,1),(7,'Anguilla','AI','AIA',1,1),(8,'Antarctica','AQ','ATA',1,1),(9,'Antigua and Barbuda','AG','ATG',1,1),(10,'Argentina','AR','ARG',1,1),(11,'Armenia','AM','ARM',1,1),(12,'Aruba','AW','ABW',1,1),(13,'Australia','AU','AUS',1,1),(14,'Austria','AT','AUT',5,1),(15,'Azerbaijan','AZ','AZE',1,1),(16,'Bahamas','BS','BHS',1,1),(17,'Bahrain','BH','BHR',1,1),(18,'Bangladesh','BD','BGD',1,1),(19,'Barbados','BB','BRB',1,1),(20,'Belarus','BY','BLR',1,1),(21,'Belgium','BE','BEL',1,1),(22,'Belize','BZ','BLZ',1,1),(23,'Benin','BJ','BEN',1,1),(24,'Bermuda','BM','BMU',1,1),(25,'Bhutan','BT','BTN',1,1),(26,'Bolivia','BO','BOL',1,1),(27,'Bosnia and Herzegowina','BA','BIH',1,1),(28,'Botswana','BW','BWA',1,1),(29,'Bouvet Island','BV','BVT',1,1),(30,'Brazil','BR','BRA',1,1),(31,'British Indian Ocean Territory','IO','IOT',1,1),(32,'Brunei Darussalam','BN','BRN',1,1),(33,'Bulgaria','BG','BGR',1,1),(34,'Burkina Faso','BF','BFA',1,1),(35,'Burundi','BI','BDI',1,1),(36,'Cambodia','KH','KHM',1,1),(37,'Cameroon','CM','CMR',1,1),(38,'Canada','CA','CAN',1,1),(39,'Cape Verde','CV','CPV',1,1),(40,'Cayman Islands','KY','CYM',1,1),(41,'Central African Republic','CF','CAF',1,1),(42,'Chad','TD','TCD',1,1),(43,'Chile','CL','CHL',1,1),(44,'China','CN','CHN',1,1),(45,'Christmas Island','CX','CXR',1,1),(46,'Cocos (Keeling) Islands','CC','CCK',1,1),(47,'Colombia','CO','COL',1,1),(48,'Comoros','KM','COM',1,1),(49,'Congo','CG','COG',1,1),(50,'Cook Islands','CK','COK',1,1),(51,'Costa Rica','CR','CRI',1,1),(52,'Cote D\'Ivoire','CI','CIV',1,1),(53,'Croatia','HR','HRV',1,1),(54,'Cuba','CU','CUB',1,1),(55,'Cyprus','CY','CYP',1,1),(56,'Czech Republic','CZ','CZE',1,1),(57,'Denmark','DK','DNK',1,1),(58,'Djibouti','DJ','DJI',1,1),(59,'Dominica','DM','DMA',1,1),(60,'Dominican Republic','DO','DOM',1,1),(61,'East Timor','TP','TMP',1,1),(62,'Ecuador','EC','ECU',1,1),(63,'Egypt','EG','EGY',1,1),(64,'El Salvador','SV','SLV',1,1),(65,'Equatorial Guinea','GQ','GNQ',1,1),(66,'Eritrea','ER','ERI',1,1),(67,'Estonia','EE','EST',1,1),(68,'Ethiopia','ET','ETH',1,1),(69,'Falkland Islands (Malvinas)','FK','FLK',1,1),(70,'Faroe Islands','FO','FRO',1,1),(71,'Fiji','FJ','FJI',1,1),(72,'Finland','FI','FIN',1,1),(73,'France','FR','FRA',1,1),(74,'France, Metropolitan','FX','FXX',1,1),(75,'French Guiana','GF','GUF',1,1),(76,'French Polynesia','PF','PYF',1,1),(77,'French Southern Territories','TF','ATF',1,1),(78,'Gabon','GA','GAB',1,1),(79,'Gambia','GM','GMB',1,1),(80,'Georgia','GE','GEO',1,1),(81,'Germany','DE','DEU',5,1),(82,'Ghana','GH','GHA',1,1),(83,'Gibraltar','GI','GIB',1,1),(84,'Greece','GR','GRC',1,1),(85,'Greenland','GL','GRL',1,1),(86,'Grenada','GD','GRD',1,1),(87,'Guadeloupe','GP','GLP',1,1),(88,'Guam','GU','GUM',1,1),(89,'Guatemala','GT','GTM',1,1),(90,'Guinea','GN','GIN',1,1),(91,'Guinea-bissau','GW','GNB',1,1),(92,'Guyana','GY','GUY',1,1),(93,'Haiti','HT','HTI',1,1),(94,'Heard and Mc Donald Islands','HM','HMD',1,1),(95,'Honduras','HN','HND',1,1),(96,'Hong Kong','HK','HKG',1,1),(97,'Hungary','HU','HUN',1,1),(98,'Iceland','IS','ISL',1,1),(99,'India','IN','IND',1,1),(100,'Indonesia','ID','IDN',1,1),(101,'Iran (Islamic Republic of)','IR','IRN',1,1),(102,'Iraq','IQ','IRQ',1,1),(103,'Ireland','IE','IRL',1,1),(104,'Israel','IL','ISR',1,1),(105,'Italy','IT','ITA',1,1),(106,'Jamaica','JM','JAM',1,1),(107,'Japan','JP','JPN',1,1),(108,'Jordan','JO','JOR',1,1),(109,'Kazakhstan','KZ','KAZ',1,1),(110,'Kenya','KE','KEN',1,1),(111,'Kiribati','KI','KIR',1,1),(112,'Korea, Democratic People\'s Republic of','KP','PRK',1,1),(113,'Korea, Republic of','KR','KOR',1,1),(114,'Kuwait','KW','KWT',1,1),(115,'Kyrgyzstan','KG','KGZ',1,1),(116,'Lao People\'s Democratic Republic','LA','LAO',1,1),(117,'Latvia','LV','LVA',1,1),(118,'Lebanon','LB','LBN',1,1),(119,'Lesotho','LS','LSO',1,1),(120,'Liberia','LR','LBR',1,1),(121,'Libyan Arab Jamahiriya','LY','LBY',1,1),(122,'Liechtenstein','LI','LIE',1,1),(123,'Lithuania','LT','LTU',1,1),(124,'Luxembourg','LU','LUX',1,1),(125,'Macau','MO','MAC',1,1),(126,'Macedonia, The Former Yugoslav Republic of','MK','MKD',1,1),(127,'Madagascar','MG','MDG',1,1),(128,'Malawi','MW','MWI',1,1),(129,'Malaysia','MY','MYS',1,1),(130,'Maldives','MV','MDV',1,1),(131,'Mali','ML','MLI',1,1),(132,'Malta','MT','MLT',1,1),(133,'Marshall Islands','MH','MHL',1,1),(134,'Martinique','MQ','MTQ',1,1),(135,'Mauritania','MR','MRT',1,1),(136,'Mauritius','MU','MUS',1,1),(137,'Mayotte','YT','MYT',1,1),(138,'Mexico','MX','MEX',1,1),(139,'Micronesia, Federated States of','FM','FSM',1,1),(140,'Moldova, Republic of','MD','MDA',1,1),(141,'Monaco','MC','MCO',1,1),(142,'Mongolia','MN','MNG',1,1),(143,'Montserrat','MS','MSR',1,1),(144,'Morocco','MA','MAR',1,1),(145,'Mozambique','MZ','MOZ',1,1),(146,'Myanmar','MM','MMR',1,1),(147,'Namibia','NA','NAM',1,1),(148,'Nauru','NR','NRU',1,1),(149,'Nepal','NP','NPL',1,1),(150,'Netherlands','NL','NLD',1,1),(151,'Netherlands Antilles','AN','ANT',1,1),(152,'New Caledonia','NC','NCL',1,1),(153,'New Zealand','NZ','NZL',1,1),(154,'Nicaragua','NI','NIC',1,1),(155,'Niger','NE','NER',1,1),(156,'Nigeria','NG','NGA',1,1),(157,'Niue','NU','NIU',1,1),(158,'Norfolk Island','NF','NFK',1,1),(159,'Northern Mariana Islands','MP','MNP',1,1),(160,'Norway','NO','NOR',1,1),(161,'Oman','OM','OMN',1,1),(162,'Pakistan','PK','PAK',1,1),(163,'Palau','PW','PLW',1,1),(164,'Panama','PA','PAN',1,1),(165,'Papua New Guinea','PG','PNG',1,1),(166,'Paraguay','PY','PRY',1,1),(167,'Peru','PE','PER',1,1),(168,'Philippines','PH','PHL',1,1),(169,'Pitcairn','PN','PCN',1,1),(170,'Poland','PL','POL',1,1),(171,'Portugal','PT','PRT',1,1),(172,'Puerto Rico','PR','PRI',1,1),(173,'Qatar','QA','QAT',1,1),(174,'Reunion','RE','REU',1,1),(175,'Romania','RO','ROM',1,1),(176,'Russian Federation','RU','RUS',1,1),(177,'Rwanda','RW','RWA',1,1),(178,'Saint Kitts and Nevis','KN','KNA',1,1),(179,'Saint Lucia','LC','LCA',1,1),(180,'Saint Vincent and the Grenadines','VC','VCT',1,1),(181,'Samoa','WS','WSM',1,1),(182,'San Marino','SM','SMR',1,1),(183,'Sao Tome and Principe','ST','STP',1,1),(184,'Saudi Arabia','SA','SAU',1,1),(185,'Senegal','SN','SEN',1,1),(186,'Seychelles','SC','SYC',1,1),(187,'Sierra Leone','SL','SLE',1,1),(188,'Singapore','SG','SGP',4,1),(189,'Slovakia (Slovak Republic)','SK','SVK',1,1),(190,'Slovenia','SI','SVN',1,1),(191,'Solomon Islands','SB','SLB',1,1),(192,'Somalia','SO','SOM',1,1),(193,'South Africa','ZA','ZAF',1,1),(194,'South Georgia and the South Sandwich Islands','GS','SGS',1,1),(195,'Spain','ES','ESP',3,1),(196,'Sri Lanka','LK','LKA',1,1),(197,'St. Helena','SH','SHN',1,1),(198,'St. Pierre and Miquelon','PM','SPM',1,1),(199,'Sudan','SD','SDN',1,1),(200,'Suriname','SR','SUR',1,1),(201,'Svalbard and Jan Mayen Islands','SJ','SJM',1,1),(202,'Swaziland','SZ','SWZ',1,1),(203,'Sweden','SE','SWE',1,1),(204,'Switzerland','CH','CHE',1,1),(205,'Syrian Arab Republic','SY','SYR',1,1),(206,'Taiwan','TW','TWN',1,1),(207,'Tajikistan','TJ','TJK',1,1),(208,'Tanzania, United Republic of','TZ','TZA',1,1),(209,'Thailand','TH','THA',1,1),(210,'Togo','TG','TGO',1,1),(211,'Tokelau','TK','TKL',1,1),(212,'Tonga','TO','TON',1,1),(213,'Trinidad and Tobago','TT','TTO',1,1),(214,'Tunisia','TN','TUN',1,1),(215,'Turkey','TR','TUR',1,1),(216,'Turkmenistan','TM','TKM',1,1),(217,'Turks and Caicos Islands','TC','TCA',1,1),(218,'Tuvalu','TV','TUV',1,1),(219,'Uganda','UG','UGA',1,1),(220,'Ukraine','UA','UKR',1,1),(221,'United Arab Emirates','AE','ARE',1,1),(222,'United Kingdom','GB','GBR',1,1),(223,'United States','US','USA',2,1),(224,'United States Minor Outlying Islands','UM','UMI',1,1),(225,'Uruguay','UY','URY',1,1),(226,'Uzbekistan','UZ','UZB',1,1),(227,'Vanuatu','VU','VUT',1,1),(228,'Vatican City State (Holy See)','VA','VAT',1,1),(229,'Venezuela','VE','VEN',1,1),(230,'Viet Nam','VN','VNM',1,1),(231,'Virgin Islands (British)','VG','VGB',1,1),(232,'Virgin Islands (U.S.)','VI','VIR',1,1),(233,'Wallis and Futuna Islands','WF','WLF',1,1),(234,'Western Sahara','EH','ESH',1,1),(235,'Yemen','YE','YEM',1,1),(236,'Yugoslavia','YU','YUG',1,1),(237,'Zaire','ZR','ZAR',1,1),(238,'Zambia','ZM','ZMB',1,1),(239,'Zimbabwe','ZW','ZWE',1,1);
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `currencies` (
  `currencies_id` int(11) NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `code` char(3) NOT NULL,
  `symbol_left` varchar(12) default NULL,
  `symbol_right` varchar(12) default NULL,
  `decimal_point` char(1) default NULL,
  `thousands_point` char(1) default NULL,
  `decimal_places` char(1) default NULL,
  `value` float(13,8) default NULL,
  `last_updated` datetime default NULL,
  PRIMARY KEY  (`currencies_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'Euro','EUR','','EUR',',','.','2',1.00000000,'2008-01-20 11:05:21');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers` (
  `customers_id` int(11) NOT NULL auto_increment,
  `customers_cid` varchar(32) default NULL,
  `customers_vat_id` varchar(20) default NULL,
  `customers_vat_id_status` int(2) NOT NULL default '0',
  `customers_warning` varchar(32) default NULL,
  `customers_status` int(5) NOT NULL default '1',
  `customers_gender` char(1) NOT NULL,
  `customers_firstname` varchar(32) NOT NULL,
  `customers_lastname` varchar(32) NOT NULL,
  `customers_dob` datetime NOT NULL default '0000-00-00 00:00:00',
  `customers_email_address` varchar(96) NOT NULL,
  `customers_default_address_id` int(11) NOT NULL,
  `customers_telephone` varchar(32) NOT NULL,
  `customers_fax` varchar(32) default NULL,
  `customers_password` varchar(40) NOT NULL,
  `customers_newsletter` char(1) default NULL,
  `customers_newsletter_mode` char(1) NOT NULL default '0',
  `member_flag` char(1) NOT NULL default '0',
  `delete_user` char(1) NOT NULL default '1',
  `account_type` int(1) NOT NULL default '0',
  `password_request_key` varchar(32) NOT NULL,
  `payment_unallowed` varchar(255) NOT NULL,
  `shipping_unallowed` varchar(255) NOT NULL,
  `refferers_id` int(5) NOT NULL default '0',
  `customers_date_added` datetime default '0000-00-00 00:00:00',
  `customers_last_modified` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`customers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'admin','',0,NULL,0,'m','<<RSTI_OWNER_FIRST_NAME>>','<<RSTI_OWNER_LAST_NAME>>','2987-01-26 00:00:00','<<RSTI_OWNER_MAIL>>',1,'000','',MD5('<<RSTI_OWNER_POSTCODE>>'),'1','0','0','0',0,'','','',0,'0000-00-00 00:00:00','2008-05-15 13:08:17');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_basket`
--

DROP TABLE IF EXISTS `customers_basket`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_basket` (
  `customers_basket_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL,
  `products_id` tinytext NOT NULL,
  `customers_basket_quantity` int(2) NOT NULL,
  `final_price` decimal(15,4) NOT NULL,
  `customers_basket_date_added` char(8) default NULL,
  PRIMARY KEY  (`customers_basket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=392 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_basket`
--

LOCK TABLES `customers_basket` WRITE;
/*!40000 ALTER TABLE `customers_basket` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers_basket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_basket_attributes`
--

DROP TABLE IF EXISTS `customers_basket_attributes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_basket_attributes` (
  `customers_basket_attributes_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL,
  `products_id` tinytext NOT NULL,
  `products_options_id` int(11) NOT NULL,
  `products_options_value_id` int(11) NOT NULL,
  PRIMARY KEY  (`customers_basket_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_basket_attributes`
--

LOCK TABLES `customers_basket_attributes` WRITE;
/*!40000 ALTER TABLE `customers_basket_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers_basket_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_info`
--

DROP TABLE IF EXISTS `customers_info`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_info` (
  `customers_info_id` int(11) NOT NULL,
  `customers_info_date_of_last_logon` datetime default NULL,
  `customers_info_number_of_logons` int(5) default NULL,
  `customers_info_date_account_created` datetime default NULL,
  `customers_info_date_account_last_modified` datetime default NULL,
  `global_product_notifications` int(1) default '0',
  PRIMARY KEY  (`customers_info_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_info`
--

LOCK TABLES `customers_info` WRITE;
/*!40000 ALTER TABLE `customers_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_ip`
--

DROP TABLE IF EXISTS `customers_ip`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_ip` (
  `customers_ip_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL default '0',
  `customers_ip` varchar(15) NOT NULL default '',
  `customers_ip_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `customers_host` varchar(255) NOT NULL default '',
  `customers_advertiser` varchar(30) default NULL,
  `customers_referer_url` varchar(255) default NULL,
  PRIMARY KEY  (`customers_ip_id`),
  KEY `customers_id` (`customers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=793 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_ip`
--

LOCK TABLES `customers_ip` WRITE;
/*!40000 ALTER TABLE `customers_ip` DISABLE KEYS */;
INSERT INTO `customers_ip` VALUES (792,1,'::1','2008-06-19 15:55:24','localhost','','localhost/checkout');
/*!40000 ALTER TABLE `customers_ip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_memo`
--

DROP TABLE IF EXISTS `customers_memo`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_memo` (
  `memo_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL default '0',
  `memo_date` date NOT NULL default '0000-00-00',
  `memo_title` text NOT NULL,
  `memo_text` text NOT NULL,
  `poster_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`memo_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_memo`
--

LOCK TABLES `customers_memo` WRITE;
/*!40000 ALTER TABLE `customers_memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers_memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_status`
--

DROP TABLE IF EXISTS `customers_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_status` (
  `customers_status_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `customers_status_name` varchar(32) NOT NULL default '',
  `customers_status_public` int(1) NOT NULL default '1',
  `customers_status_min_order` int(7) default NULL,
  `customers_status_max_order` int(7) default NULL,
  `customers_status_image` varchar(64) default NULL,
  `customers_status_discount` decimal(4,2) default '0.00',
  `customers_status_ot_discount_flag` char(1) NOT NULL default '0',
  `customers_status_ot_discount` decimal(4,2) default '0.00',
  `customers_status_graduated_prices` varchar(1) NOT NULL default '0',
  `customers_status_show_price` int(1) NOT NULL default '1',
  `customers_status_show_price_tax` int(1) NOT NULL default '1',
  `customers_status_add_tax_ot` int(1) NOT NULL default '0',
  `customers_status_payment_unallowed` varchar(255) NOT NULL default '',
  `customers_status_shipping_unallowed` varchar(255) NOT NULL default '',
  `customers_status_discount_attributes` int(1) NOT NULL default '0',
  `customers_fsk18` int(1) NOT NULL default '1',
  `customers_fsk18_display` int(1) NOT NULL default '1',
  `customers_status_write_reviews` int(1) NOT NULL default '1',
  `customers_status_read_reviews` int(1) NOT NULL default '1',
  PRIMARY KEY  (`customers_status_id`,`languages_id`),
  KEY `idx_orders_status_name` (`customers_status_name`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_status`
--

LOCK TABLES `customers_status` WRITE;
/*!40000 ALTER TABLE `customers_status` DISABLE KEYS */;
INSERT INTO `customers_status` VALUES (0,2,'Admin',1,0,0,'admin_status.gif','0.00','0','0.00','0',1,1,0,'','',0,0,0,0,0),(1,2,'Gast',1,0,0,'guest_status.gif','0.00','0','0.00','0',1,1,0,'','',0,1,0,0,0),(2,2,'Neuer Kunde',1,0,0,'customer_status.gif','0.00','0','0.00','0',1,1,0,'','',0,1,1,0,1),(3,2,'Kunde, Vorkasse',1,0,0,'merchant_status.gif','0.00','0','0.00','0',1,1,0,'invoice','',0,1,1,0,0),(4,2,'Kunde, Rechnung',1,0,0,NULL,'0.00','0','0.00','0',1,1,0,'','',0,0,0,0,0);
/*!40000 ALTER TABLE `customers_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers_status_history`
--

DROP TABLE IF EXISTS `customers_status_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `customers_status_history` (
  `customers_status_history_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL default '0',
  `new_value` int(5) NOT NULL default '0',
  `old_value` int(5) default NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `customer_notified` int(1) default '0',
  PRIMARY KEY  (`customers_status_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `customers_status_history`
--

LOCK TABLES `customers_status_history` WRITE;
/*!40000 ALTER TABLE `customers_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `customers_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `geo_zones`
--

DROP TABLE IF EXISTS `geo_zones`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `geo_zones` (
  `geo_zone_id` int(11) NOT NULL auto_increment,
  `geo_zone_name` varchar(32) NOT NULL,
  `geo_zone_description` varchar(255) NOT NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`geo_zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `geo_zones`
--

LOCK TABLES `geo_zones` WRITE;
/*!40000 ALTER TABLE `geo_zones` DISABLE KEYS */;
INSERT INTO `geo_zones` VALUES (6,'Steuerzone EU-Ausland','','0000-00-00 00:00:00','2008-01-20 11:12:18'),(5,'Steuerzone EU','Steuerzone fÃ¼r die EU','0000-00-00 00:00:00','2008-01-20 11:12:18'),(7,'Steuerzone B2B','',NULL,'2008-01-20 11:12:18');
/*!40000 ALTER TABLE `geo_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ibc_alternative_supplies_to_original_supplies`
--

DROP TABLE IF EXISTS `ibc_alternative_supplies_to_original_supplies`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ibc_alternative_supplies_to_original_supplies` (
  `ibc_original_supplies` varchar(64) NOT NULL,
  `ibc_alternative_supplies` varchar(64) NOT NULL,
  PRIMARY KEY  (`ibc_original_supplies`,`ibc_alternative_supplies`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ibc_alternative_supplies_to_original_supplies`
--

LOCK TABLES `ibc_alternative_supplies_to_original_supplies` WRITE;
/*!40000 ALTER TABLE `ibc_alternative_supplies_to_original_supplies` DISABLE KEYS */;
/*!40000 ALTER TABLE `ibc_alternative_supplies_to_original_supplies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ibc_original_supplies_to_devices`
--

DROP TABLE IF EXISTS `ibc_original_supplies_to_devices`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ibc_original_supplies_to_devices` (
  `ibc_devices` varchar(64) NOT NULL,
  `ibc_original_supplies` varchar(64) NOT NULL,
  PRIMARY KEY  (`ibc_devices`,`ibc_original_supplies`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ibc_original_supplies_to_devices`
--

LOCK TABLES `ibc_original_supplies_to_devices` WRITE;
/*!40000 ALTER TABLE `ibc_original_supplies_to_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `ibc_original_supplies_to_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `languages` (
  `languages_id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `code` char(2) NOT NULL default '',
  `image` varchar(64) default NULL,
  `directory` varchar(32) default NULL,
  `sort_order` int(3) default NULL,
  `language_charset` text NOT NULL,
  PRIMARY KEY  (`languages_id`),
  UNIQUE KEY `code` (`code`),
  KEY `IDX_LANGUAGES_NAME` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (2,'Deutsch','de','icon.gif','german',1,'UTF-8');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manufacturers`
--

DROP TABLE IF EXISTS `manufacturers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `manufacturers` (
  `manufacturers_id` int(11) NOT NULL auto_increment,
  `manufacturers_name` varchar(32) NOT NULL default '',
  `manufacturers_image` varchar(64) default NULL,
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  PRIMARY KEY  (`manufacturers_id`),
  UNIQUE KEY `name` (`manufacturers_name`),
  KEY `IDX_MANUFACTURERS_NAME` (`manufacturers_name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `manufacturers`
--

LOCK TABLES `manufacturers` WRITE;
/*!40000 ALTER TABLE `manufacturers` DISABLE KEYS */;
/*!40000 ALTER TABLE `manufacturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manufacturers_info`
--

DROP TABLE IF EXISTS `manufacturers_info`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `manufacturers_info` (
  `manufacturers_id` int(11) NOT NULL,
  `languages_id` int(11) NOT NULL,
  `manufacturers_meta_title` varchar(100) NOT NULL,
  `manufacturers_meta_description` varchar(255) NOT NULL,
  `manufacturers_meta_keywords` varchar(255) NOT NULL,
  `manufacturers_url` varchar(255) NOT NULL,
  `url_clicked` int(5) NOT NULL default '0',
  `date_last_click` datetime default NULL,
  PRIMARY KEY  (`manufacturers_id`,`languages_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `manufacturers_info`
--

LOCK TABLES `manufacturers_info` WRITE;
/*!40000 ALTER TABLE `manufacturers_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `manufacturers_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_content`
--

DROP TABLE IF EXISTS `media_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `media_content` (
  `file_id` int(11) NOT NULL auto_increment,
  `old_filename` text NOT NULL,
  `new_filename` text NOT NULL,
  `file_comment` text NOT NULL,
  PRIMARY KEY  (`file_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `media_content`
--

LOCK TABLES `media_content` WRITE;
/*!40000 ALTER TABLE `media_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_newsletter`
--

DROP TABLE IF EXISTS `module_newsletter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `module_newsletter` (
  `newsletter_id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `bc` text NOT NULL,
  `cc` text NOT NULL,
  `date` datetime default NULL,
  `status` int(1) NOT NULL default '0',
  `body` text NOT NULL,
  PRIMARY KEY  (`newsletter_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `module_newsletter`
--

LOCK TABLES `module_newsletter` WRITE;
/*!40000 ALTER TABLE `module_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_recipients`
--

DROP TABLE IF EXISTS `newsletter_recipients`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `newsletter_recipients` (
  `mail_id` int(11) NOT NULL auto_increment,
  `customers_email_address` varchar(96) NOT NULL default '',
  `customers_id` int(11) NOT NULL default '0',
  `customers_status` int(5) NOT NULL default '0',
  `customers_firstname` varchar(32) NOT NULL default '',
  `customers_lastname` varchar(32) NOT NULL default '',
  `mail_status` int(1) NOT NULL default '0',
  `mail_key` varchar(32) NOT NULL default '',
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`mail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `newsletter_recipients`
--

LOCK TABLES `newsletter_recipients` WRITE;
/*!40000 ALTER TABLE `newsletter_recipients` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_recipients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `newsletters` (
  `newsletters_id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `module` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_sent` datetime default NULL,
  `status` int(1) default NULL,
  `locked` int(1) default '0',
  PRIMARY KEY  (`newsletters_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters_history`
--

DROP TABLE IF EXISTS `newsletters_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `newsletters_history` (
  `news_hist_id` int(11) NOT NULL default '0',
  `news_hist_cs` int(11) NOT NULL default '0',
  `news_hist_cs_date_sent` date default NULL,
  PRIMARY KEY  (`news_hist_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `newsletters_history`
--

LOCK TABLES `newsletters_history` WRITE;
/*!40000 ALTER TABLE `newsletters_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL auto_increment,
  `customers_id` int(11) NOT NULL,
  `customers_cid` varchar(32) default NULL,
  `customers_vat_id` varchar(20) default NULL,
  `customers_status` int(11) default NULL,
  `customers_status_name` varchar(32) NOT NULL,
  `customers_status_image` varchar(64) default NULL,
  `customers_status_discount` decimal(4,2) default NULL,
  `customers_name` varchar(64) NOT NULL,
  `customers_firstname` varchar(64) NOT NULL,
  `customers_lastname` varchar(64) NOT NULL,
  `customers_company` varchar(32) default NULL,
  `customers_street_address` varchar(64) NOT NULL,
  `customers_suburb` varchar(32) default NULL,
  `customers_city` varchar(32) NOT NULL,
  `customers_postcode` varchar(10) NOT NULL,
  `customers_state` varchar(32) default NULL,
  `customers_country` varchar(32) NOT NULL,
  `customers_telephone` varchar(32) NOT NULL,
  `customers_email_address` varchar(96) NOT NULL,
  `customers_address_format_id` int(5) NOT NULL,
  `delivery_name` varchar(64) NOT NULL,
  `delivery_firstname` varchar(64) NOT NULL,
  `delivery_lastname` varchar(64) NOT NULL,
  `delivery_company` varchar(32) default NULL,
  `delivery_street_address` varchar(64) NOT NULL,
  `delivery_suburb` varchar(32) default NULL,
  `delivery_city` varchar(32) NOT NULL,
  `delivery_postcode` varchar(10) NOT NULL,
  `delivery_state` varchar(32) default NULL,
  `delivery_country` varchar(32) NOT NULL,
  `delivery_country_iso_code_2` char(2) NOT NULL,
  `delivery_address_format_id` int(5) NOT NULL,
  `billing_name` varchar(64) NOT NULL,
  `billing_firstname` varchar(64) NOT NULL,
  `billing_lastname` varchar(64) NOT NULL,
  `billing_company` varchar(32) default NULL,
  `billing_street_address` varchar(64) NOT NULL,
  `billing_suburb` varchar(32) default NULL,
  `billing_city` varchar(32) NOT NULL,
  `billing_postcode` varchar(10) NOT NULL,
  `billing_state` varchar(32) default NULL,
  `billing_country` varchar(32) NOT NULL,
  `billing_country_iso_code_2` char(2) NOT NULL,
  `billing_address_format_id` int(5) NOT NULL,
  `payment_method` varchar(32) NOT NULL,
  `cc_type` varchar(20) default NULL,
  `cc_owner` varchar(64) default NULL,
  `cc_number` varchar(64) default NULL,
  `cc_expires` varchar(4) default NULL,
  `cc_start` varchar(4) default NULL,
  `cc_issue` varchar(3) default NULL,
  `cc_cvv` varchar(4) default NULL,
  `comments` varchar(255) default NULL,
  `last_modified` datetime default NULL,
  `date_purchased` datetime default NULL,
  `orders_status` int(5) NOT NULL,
  `orders_date_finished` datetime default NULL,
  `currency` char(3) default NULL,
  `currency_value` decimal(14,6) default NULL,
  `account_type` int(1) NOT NULL default '0',
  `payment_class` varchar(32) NOT NULL,
  `shipping_method` varchar(32) NOT NULL,
  `shipping_class` varchar(32) NOT NULL,
  `customers_ip` varchar(32) NOT NULL,
  `language` varchar(32) NOT NULL,
  `afterbuy_success` int(1) NOT NULL default '0',
  `afterbuy_id` int(32) NOT NULL default '0',
  `refferers_id` varchar(32) NOT NULL,
  `conversion_type` int(1) NOT NULL default '0',
  `orders_ident_key` varchar(128) default NULL,
  PRIMARY KEY  (`orders_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_products`
--

DROP TABLE IF EXISTS `orders_products`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_products` (
  `orders_products_id` int(11) NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `products_model` varchar(64) default NULL,
  `products_name` varchar(255) NOT NULL,
  `products_price` decimal(15,4) NOT NULL,
  `products_discount_made` decimal(4,2) default NULL,
  `products_shipping_time` varchar(255) default NULL,
  `final_price` decimal(15,4) NOT NULL,
  `products_tax` decimal(7,4) NOT NULL,
  `products_quantity` int(2) NOT NULL,
  `allow_tax` int(1) NOT NULL,
  PRIMARY KEY  (`orders_products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_products`
--

LOCK TABLES `orders_products` WRITE;
/*!40000 ALTER TABLE `orders_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_products_attributes`
--

DROP TABLE IF EXISTS `orders_products_attributes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_products_attributes` (
  `orders_products_attributes_id` int(11) NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL,
  `orders_products_id` int(11) NOT NULL,
  `products_options` varchar(32) NOT NULL,
  `products_options_values` varchar(64) NOT NULL,
  `options_values_price` decimal(15,4) NOT NULL,
  `price_prefix` char(1) NOT NULL,
  PRIMARY KEY  (`orders_products_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_products_attributes`
--

LOCK TABLES `orders_products_attributes` WRITE;
/*!40000 ALTER TABLE `orders_products_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_products_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_products_download`
--

DROP TABLE IF EXISTS `orders_products_download`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_products_download` (
  `orders_products_download_id` int(11) NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL default '0',
  `orders_products_id` int(11) NOT NULL default '0',
  `orders_products_filename` varchar(255) NOT NULL default '',
  `download_maxdays` int(2) NOT NULL default '0',
  `download_count` int(2) NOT NULL default '0',
  PRIMARY KEY  (`orders_products_download_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_products_download`
--

LOCK TABLES `orders_products_download` WRITE;
/*!40000 ALTER TABLE `orders_products_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_products_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_recalculate`
--

DROP TABLE IF EXISTS `orders_recalculate`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_recalculate` (
  `orders_recalculate_id` int(11) NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL default '0',
  `n_price` decimal(15,4) NOT NULL default '0.0000',
  `b_price` decimal(15,4) NOT NULL default '0.0000',
  `tax` decimal(15,4) NOT NULL default '0.0000',
  `tax_rate` decimal(7,4) NOT NULL default '0.0000',
  `class` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`orders_recalculate_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_recalculate`
--

LOCK TABLES `orders_recalculate` WRITE;
/*!40000 ALTER TABLE `orders_recalculate` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_recalculate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_status`
--

DROP TABLE IF EXISTS `orders_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_status` (
  `orders_status_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `orders_status_name` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`orders_status_id`,`languages_id`),
  KEY `idx_orders_status_name` (`orders_status_name`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_status`
--

LOCK TABLES `orders_status` WRITE;
/*!40000 ALTER TABLE `orders_status` DISABLE KEYS */;
INSERT INTO `orders_status` VALUES (1,2,'Offen'),(2,2,'In Bearbeitung'),(3,2,'Versendet'),(4,2,'warten auf Zahlungseingang'),(5,2,'Bestellung storniert');
/*!40000 ALTER TABLE `orders_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_status_history`
--

DROP TABLE IF EXISTS `orders_status_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_status_history` (
  `orders_status_history_id` int(11) NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL,
  `orders_status_id` int(5) NOT NULL,
  `date_added` datetime NOT NULL,
  `customer_notified` int(1) default '0',
  `comments` text,
  PRIMARY KEY  (`orders_status_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_status_history`
--

LOCK TABLES `orders_status_history` WRITE;
/*!40000 ALTER TABLE `orders_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_total`
--

DROP TABLE IF EXISTS `orders_total`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `orders_total` (
  `orders_total_id` int(10) unsigned NOT NULL auto_increment,
  `orders_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `value` decimal(15,4) NOT NULL,
  `class` varchar(32) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY  (`orders_total_id`),
  KEY `idx_orders_total_orders_id` (`orders_id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `orders_total`
--

LOCK TABLES `orders_total` WRITE;
/*!40000 ALTER TABLE `orders_total` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_moneybookers`
--

DROP TABLE IF EXISTS `payment_moneybookers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_moneybookers` (
  `mb_TRID` varchar(255) NOT NULL default '',
  `mb_ERRNO` smallint(3) unsigned NOT NULL default '0',
  `mb_ERRTXT` varchar(255) NOT NULL default '',
  `mb_DATE` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_MBTID` bigint(18) unsigned NOT NULL default '0',
  `mb_STATUS` tinyint(1) NOT NULL default '0',
  `mb_ORDERID` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mb_TRID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payment_moneybookers`
--

LOCK TABLES `payment_moneybookers` WRITE;
/*!40000 ALTER TABLE `payment_moneybookers` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_moneybookers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_moneybookers_countries`
--

DROP TABLE IF EXISTS `payment_moneybookers_countries`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_moneybookers_countries` (
  `osc_cID` int(11) NOT NULL default '0',
  `mb_cID` char(3) NOT NULL default '',
  PRIMARY KEY  (`osc_cID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payment_moneybookers_countries`
--

LOCK TABLES `payment_moneybookers_countries` WRITE;
/*!40000 ALTER TABLE `payment_moneybookers_countries` DISABLE KEYS */;
INSERT INTO `payment_moneybookers_countries` VALUES (2,'ALB'),(3,'ALG'),(4,'AME'),(5,'AND'),(6,'AGL'),(7,'ANG'),(9,'ANT'),(10,'ARG'),(11,'ARM'),(12,'ARU'),(13,'AUS'),(14,'AUT'),(15,'AZE'),(16,'BMS'),(17,'BAH'),(18,'BAN'),(19,'BAR'),(20,'BLR'),(21,'BGM'),(22,'BEL'),(23,'BEN'),(24,'BER'),(26,'BOL'),(27,'BOS'),(28,'BOT'),(30,'BRA'),(32,'BRU'),(33,'BUL'),(34,'BKF'),(35,'BUR'),(36,'CAM'),(37,'CMR'),(38,'CAN'),(39,'CAP'),(40,'CAY'),(41,'CEN'),(42,'CHA'),(43,'CHL'),(44,'CHN'),(47,'COL'),(49,'CON'),(51,'COS'),(52,'COT'),(53,'CRO'),(54,'CUB'),(55,'CYP'),(56,'CZE'),(57,'DEN'),(58,'DJI'),(59,'DOM'),(60,'DRP'),(62,'ECU'),(64,'EL_'),(65,'EQU'),(66,'ERI'),(67,'EST'),(68,'ETH'),(70,'FAR'),(71,'FIJ'),(72,'FIN'),(73,'FRA'),(75,'FRE'),(78,'GAB'),(79,'GAM'),(80,'GEO'),(81,'GER'),(82,'GHA'),(83,'GIB'),(84,'GRC'),(85,'GRL'),(87,'GDL'),(88,'GUM'),(89,'GUA'),(90,'GUI'),(91,'GBS'),(92,'GUY'),(93,'HAI'),(95,'HON'),(96,'HKG'),(97,'HUN'),(98,'ICE'),(99,'IND'),(101,'IRN'),(102,'IRA'),(103,'IRE'),(104,'ISR'),(105,'ITA'),(106,'JAM'),(107,'JAP'),(108,'JOR'),(109,'KAZ'),(110,'KEN'),(112,'SKO'),(113,'KOR'),(114,'KUW'),(115,'KYR'),(116,'LAO'),(117,'LAT'),(141,'MCO'),(119,'LES'),(120,'LIB'),(121,'LBY'),(122,'LIE'),(123,'LIT'),(124,'LUX'),(125,'MAC'),(126,'F.Y'),(127,'MAD'),(128,'MLW'),(129,'MLS'),(130,'MAL'),(131,'MLI'),(132,'MLT'),(134,'MAR'),(135,'MRT'),(136,'MAU'),(138,'MEX'),(140,'MOL'),(142,'MON'),(143,'MTT'),(144,'MOR'),(145,'MOZ'),(76,'PYF'),(147,'NAM'),(149,'NEP'),(150,'NED'),(151,'NET'),(152,'CDN'),(153,'NEW'),(154,'NIC'),(155,'NIG'),(69,'FLK'),(160,'NWY'),(161,'OMA'),(162,'PAK'),(164,'PAN'),(165,'PAP'),(166,'PAR'),(167,'PER'),(168,'PHI'),(170,'POL'),(171,'POR'),(172,'PUE'),(173,'QAT'),(175,'ROM'),(176,'RUS'),(177,'RWA'),(178,'SKN'),(179,'SLU'),(180,'ST.'),(181,'WES'),(182,'SAN'),(183,'SAO'),(184,'SAU'),(185,'SEN'),(186,'SEY'),(187,'SIE'),(188,'SIN'),(189,'SLO'),(190,'SLV'),(191,'SOL'),(192,'SOM'),(193,'SOU'),(195,'SPA'),(196,'SRI'),(199,'SUD'),(200,'SUR'),(202,'SWA'),(203,'SWE'),(204,'SWI'),(205,'SYR'),(206,'TWN'),(207,'TAJ'),(208,'TAN'),(209,'THA'),(210,'TOG'),(212,'TON'),(213,'TRI'),(214,'TUN'),(215,'TUR'),(216,'TKM'),(217,'TCI'),(219,'UGA'),(231,'BRI'),(221,'UAE'),(222,'GBR'),(223,'UNI'),(225,'URU'),(226,'UZB'),(227,'VAN'),(229,'VEN'),(230,'VIE'),(232,'US_'),(235,'YEM'),(236,'YUG'),(238,'ZAM'),(239,'ZIM');
/*!40000 ALTER TABLE `payment_moneybookers_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_moneybookers_currencies`
--

DROP TABLE IF EXISTS `payment_moneybookers_currencies`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_moneybookers_currencies` (
  `mb_currID` char(3) NOT NULL default '',
  `mb_currName` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mb_currID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payment_moneybookers_currencies`
--

LOCK TABLES `payment_moneybookers_currencies` WRITE;
/*!40000 ALTER TABLE `payment_moneybookers_currencies` DISABLE KEYS */;
INSERT INTO `payment_moneybookers_currencies` VALUES ('AUD','Australian Dollar'),('BGN','Bulgarian Lev'),('CAD','Canadian Dollar'),('CHF','Swiss Franc'),('CZK','Czech Koruna'),('DKK','Danish Krone'),('EEK','Estonian Koruna'),('EUR','Euro'),('GBP','Pound Sterling'),('HKD','Hong Kong Dollar'),('HUF','Forint'),('ILS','Shekel'),('ISK','Iceland Krona'),('JPY','Yen'),('KRW','South-Korean Won'),('LVL','Latvian Lat'),('MYR','Malaysian Ringgit'),('NOK','Norwegian Krone'),('NZD','New Zealand Dollar'),('PLN','Zloty'),('SEK','Swedish Krona'),('SGD','Singapore Dollar'),('SKK','Slovak Koruna'),('THB','Baht'),('TWD','New Taiwan Dollar'),('USD','US Dollar'),('ZAR','South-African Rand');
/*!40000 ALTER TABLE `payment_moneybookers_currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_qenta`
--

DROP TABLE IF EXISTS `payment_qenta`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `payment_qenta` (
  `q_TRID` varchar(255) NOT NULL default '',
  `q_DATE` datetime NOT NULL default '0000-00-00 00:00:00',
  `q_QTID` bigint(18) unsigned NOT NULL default '0',
  `q_ORDERDESC` varchar(255) NOT NULL default '',
  `q_STATUS` tinyint(1) NOT NULL default '0',
  `q_ORDERID` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`q_TRID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `payment_qenta`
--

LOCK TABLES `payment_qenta` WRITE;
/*!40000 ALTER TABLE `payment_qenta` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_qenta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_offers_by_customers_status_0`
--

DROP TABLE IF EXISTS `personal_offers_by_customers_status_0`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_offers_by_customers_status_0` (
  `price_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  `personal_offer` decimal(15,4) default NULL,
  PRIMARY KEY  (`price_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `personal_offers_by_customers_status_0`
--

LOCK TABLES `personal_offers_by_customers_status_0` WRITE;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_0` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_offers_by_customers_status_1`
--

DROP TABLE IF EXISTS `personal_offers_by_customers_status_1`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_offers_by_customers_status_1` (
  `price_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  `personal_offer` decimal(15,4) default NULL,
  PRIMARY KEY  (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6599 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `personal_offers_by_customers_status_1`
--

LOCK TABLES `personal_offers_by_customers_status_1` WRITE;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_offers_by_customers_status_2`
--

DROP TABLE IF EXISTS `personal_offers_by_customers_status_2`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_offers_by_customers_status_2` (
  `price_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  `personal_offer` decimal(15,4) default NULL,
  PRIMARY KEY  (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6599 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `personal_offers_by_customers_status_2`
--

LOCK TABLES `personal_offers_by_customers_status_2` WRITE;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_2` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_offers_by_customers_status_3`
--

DROP TABLE IF EXISTS `personal_offers_by_customers_status_3`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_offers_by_customers_status_3` (
  `price_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  `personal_offer` decimal(15,4) default NULL,
  PRIMARY KEY  (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6599 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `personal_offers_by_customers_status_3`
--

LOCK TABLES `personal_offers_by_customers_status_3` WRITE;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_3` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_offers_by_customers_status_4`
--

DROP TABLE IF EXISTS `personal_offers_by_customers_status_4`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `personal_offers_by_customers_status_4` (
  `price_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `quantity` int(11) default NULL,
  `personal_offer` decimal(15,4) default NULL,
  PRIMARY KEY  (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6599 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `personal_offers_by_customers_status_4`
--

LOCK TABLES `personal_offers_by_customers_status_4` WRITE;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_4` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_offers_by_customers_status_4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products` (
  `products_id` int(11) NOT NULL auto_increment,
  `products_ean` varchar(128) default NULL,
  `products_quantity` int(4) NOT NULL default '0',
  `products_shippingtime` int(4) NOT NULL default '0',
  `products_model` varchar(64) default NULL,
  `products_sort` int(4) NOT NULL default '0',
  `products_price` decimal(15,4) NOT NULL default '0.0000',
  `products_discount_allowed` decimal(3,2) NOT NULL default '0.00',
  `products_date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `products_last_modified` datetime default NULL,
  `products_date_available` datetime default NULL,
  `products_weight` decimal(5,2) NOT NULL default '0.00',
  `products_status` tinyint(1) NOT NULL default '0',
  `products_tax_class_id` int(11) NOT NULL default '0',
  `product_template` varchar(64) default NULL,
  `options_template` varchar(64) default NULL,
  `manufacturers_id` int(11) default NULL,
  `products_ordered` int(11) NOT NULL default '0',
  `products_fsk18` int(1) NOT NULL default '0',
  `products_vpe_id` int(11) NOT NULL default '0',
  `products_vpe_status` int(1) NOT NULL default '0',
  `products_vpe_value` decimal(15,4) NOT NULL default '0.0000',
  `products_startpage` int(1) NOT NULL default '0',
  `products_startpage_sort` int(4) NOT NULL default '0',
  `products_trading_unit` int(4) NOT NULL default '1',
  `ibc_supplies` varchar(255) default NULL,
  PRIMARY KEY  (`products_id`),
  UNIQUE KEY `products_model` (`products_model`),
  KEY `idx_products_date_added` (`products_date_added`)
) ENGINE=InnoDB AUTO_INCREMENT=1437 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_attributes`
--

DROP TABLE IF EXISTS `products_attributes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_attributes` (
  `products_attributes_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `options_id` int(11) NOT NULL,
  `options_values_id` int(11) NOT NULL,
  `options_values_price` decimal(15,4) NOT NULL,
  `price_prefix` char(1) NOT NULL,
  `attributes_model` varchar(64) default NULL,
  `attributes_stock` int(4) default NULL,
  `options_values_weight` decimal(15,4) NOT NULL,
  `weight_prefix` char(1) NOT NULL,
  `sortorder` int(11) default NULL,
  PRIMARY KEY  (`products_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_attributes`
--

LOCK TABLES `products_attributes` WRITE;
/*!40000 ALTER TABLE `products_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_attributes_download`
--

DROP TABLE IF EXISTS `products_attributes_download`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_attributes_download` (
  `products_attributes_id` int(11) NOT NULL,
  `products_attributes_filename` varchar(255) NOT NULL default '',
  `products_attributes_maxdays` int(2) default '0',
  `products_attributes_maxcount` int(2) default '0',
  PRIMARY KEY  (`products_attributes_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_attributes_download`
--

LOCK TABLES `products_attributes_download` WRITE;
/*!40000 ALTER TABLE `products_attributes_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_attributes_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_content`
--

DROP TABLE IF EXISTS `products_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_content` (
  `content_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL default '0',
  `group_ids` text,
  `content_name` varchar(32) NOT NULL default '',
  `content_file` varchar(64) NOT NULL,
  `content_link` text NOT NULL,
  `languages_id` int(11) NOT NULL default '0',
  `content_read` int(11) NOT NULL default '0',
  `file_comment` text NOT NULL,
  PRIMARY KEY  (`content_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_content`
--

LOCK TABLES `products_content` WRITE;
/*!40000 ALTER TABLE `products_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_description`
--

DROP TABLE IF EXISTS `products_description`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_description` (
  `products_id` int(11) NOT NULL auto_increment,
  `languages_id` int(11) NOT NULL default '1',
  `products_name` varchar(255) NOT NULL default '',
  `products_description` text,
  `products_short_description` text,
  `products_keywords` varchar(255) default NULL,
  `products_meta_title` text NOT NULL,
  `products_meta_description` text NOT NULL,
  `products_meta_keywords` text NOT NULL,
  `products_url` varchar(255) default NULL,
  `products_viewed` int(5) default '0',
  `products_trading_unit_name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`products_id`,`languages_id`),
  KEY `products_name` (`products_name`)
) ENGINE=InnoDB AUTO_INCREMENT=34397 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_description`
--

LOCK TABLES `products_description` WRITE;
/*!40000 ALTER TABLE `products_description` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_graduated_prices`
--

DROP TABLE IF EXISTS `products_graduated_prices`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_graduated_prices` (
  `products_id` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '0',
  `unitprice` decimal(15,4) NOT NULL default '0.0000',
  KEY `products_id` (`products_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_graduated_prices`
--

LOCK TABLES `products_graduated_prices` WRITE;
/*!40000 ALTER TABLE `products_graduated_prices` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_graduated_prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_images`
--

DROP TABLE IF EXISTS `products_images`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_images` (
  `image_nr` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL default '0',
  `url_small` varchar(100) NOT NULL default '',
  `url_middle` varchar(100) default '',
  `url_big` varchar(254) default '',
  PRIMARY KEY  (`image_nr`,`products_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2856 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_images`
--

LOCK TABLES `products_images` WRITE;
/*!40000 ALTER TABLE `products_images` DISABLE KEYS */;
INSERT INTO `products_images` VALUES (2594,674,'/images/product_images/thumbnail_images/674_2594.png','/images/product_images/info_images/674_2594.png','/images/product_images/popup_images/674_2594.png'),(2596,574,'/images/product_images/thumbnail_images/574_2596.jpg','/images/product_images/info_images/574_2596.jpg','/images/product_images/popup_images/574_2596.jpg');
/*!40000 ALTER TABLE `products_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_notifications`
--

DROP TABLE IF EXISTS `products_notifications`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_notifications` (
  `products_id` int(11) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`products_id`,`customers_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_notifications`
--

LOCK TABLES `products_notifications` WRITE;
/*!40000 ALTER TABLE `products_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_options`
--

DROP TABLE IF EXISTS `products_options`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_options` (
  `products_options_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `products_options_name` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`products_options_id`,`languages_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_options`
--

LOCK TABLES `products_options` WRITE;
/*!40000 ALTER TABLE `products_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_options_values`
--

DROP TABLE IF EXISTS `products_options_values`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_options_values` (
  `products_options_values_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `products_options_values_name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`products_options_values_id`,`languages_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_options_values`
--

LOCK TABLES `products_options_values` WRITE;
/*!40000 ALTER TABLE `products_options_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_options_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_options_values_to_products_options`
--

DROP TABLE IF EXISTS `products_options_values_to_products_options`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_options_values_to_products_options` (
  `products_options_values_to_products_options_id` int(11) NOT NULL auto_increment,
  `products_options_id` int(11) NOT NULL,
  `products_options_values_id` int(11) NOT NULL,
  PRIMARY KEY  (`products_options_values_to_products_options_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_options_values_to_products_options`
--

LOCK TABLES `products_options_values_to_products_options` WRITE;
/*!40000 ALTER TABLE `products_options_values_to_products_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_options_values_to_products_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_to_categories`
--

DROP TABLE IF EXISTS `products_to_categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_to_categories` (
  `products_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY  (`products_id`,`categories_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_to_categories`
--

LOCK TABLES `products_to_categories` WRITE;
/*!40000 ALTER TABLE `products_to_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_to_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_vpe`
--

DROP TABLE IF EXISTS `products_vpe`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_vpe` (
  `products_vpe_id` int(11) NOT NULL auto_increment,
  `languages_id` int(11) NOT NULL default '0',
  `products_vpe_name` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`products_vpe_id`,`languages_id`),
  UNIQUE KEY `name` (`products_vpe_name`,`languages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;; 
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_vpe`
--

LOCK TABLES `products_vpe` WRITE;
/*!40000 ALTER TABLE `products_vpe` DISABLE KEYS */;
INSERT INTO `products_vpe` VALUES (1,1,'kg'),(1,2,'kg');
/*!40000 ALTER TABLE `products_vpe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_xsell`
--

DROP TABLE IF EXISTS `products_xsell`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_xsell` (
  `ID` int(10) NOT NULL auto_increment,
  `products_id` int(10) unsigned NOT NULL default '1',
  `products_xsell_grp_name_id` int(10) unsigned NOT NULL default '1',
  `xsell_id` int(10) unsigned NOT NULL default '1',
  `sort_order` int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_xsell`
--

LOCK TABLES `products_xsell` WRITE;
/*!40000 ALTER TABLE `products_xsell` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_xsell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_xsell_grp_name`
--

DROP TABLE IF EXISTS `products_xsell_grp_name`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `products_xsell_grp_name` (
  `products_xsell_grp_name_id` int(10) NOT NULL,
  `xsell_sort_order` int(10) NOT NULL default '0',
  `language_id` smallint(6) NOT NULL default '0',
  `groupname` varchar(255) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `products_xsell_grp_name`
--

LOCK TABLES `products_xsell_grp_name` WRITE;
/*!40000 ALTER TABLE `products_xsell_grp_name` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_xsell_grp_name` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reviews` (
  `reviews_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `customers_id` int(11) default NULL,
  `customers_name` varchar(64) NOT NULL,
  `reviews_rating` int(1) default NULL,
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  `reviews_read` int(5) NOT NULL default '0',
  PRIMARY KEY  (`reviews_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews_description`
--

DROP TABLE IF EXISTS `reviews_description`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reviews_description` (
  `reviews_id` int(11) NOT NULL,
  `languages_id` int(11) NOT NULL,
  `reviews_text` text NOT NULL,
  PRIMARY KEY  (`reviews_id`,`languages_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reviews_description`
--

LOCK TABLES `reviews_description` WRITE;
/*!40000 ALTER TABLE `reviews_description` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sessions` (
  `sesskey` varchar(32) NOT NULL,
  `expiry` int(11) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`sesskey`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('cfc3jjrj21fscov1qpnl9v4144',1213885334,'tracking|a:5:{s:12:\"http_referer\";a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:9:\"/checkout\";}s:2:\"ip\";s:3:\"::1\";s:4:\"date\";s:19:\"2008-06-19 15:50:59\";s:7:\"browser\";s:71:\"Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.9 (like Gecko)\";s:16:\"pageview_history\";a:7:{i:0;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:5:\"/cart\";}i:1;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:1:\"/\";}i:2;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:1:\"/\";}i:3;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:5:\"/cart\";}i:4;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:8:\"/account\";}i:5;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:5:\"/cart\";}i:6;a:3:{s:6:\"scheme\";s:4:\"http\";s:4:\"host\";s:9:\"localhost\";s:4:\"path\";s:8:\"/account\";}}}tracked|b:1;language|s:6:\"german\";languages_id|s:1:\"2\";language_charset|s:11:\"iso-8859-15\";language_code|s:2:\"de\";currency|s:3:\"EUR\";customers_status|a:20:{s:19:\"customers_status_id\";s:1:\"0\";s:21:\"customers_status_name\";s:5:\"Admin\";s:22:\"customers_status_image\";s:16:\"admin_status.gif\";s:23:\"customers_status_public\";s:1:\"1\";s:26:\"customers_status_min_order\";s:1:\"0\";s:26:\"customers_status_max_order\";s:1:\"0\";s:25:\"customers_status_discount\";s:4:\"0.00\";s:33:\"customers_status_ot_discount_flag\";s:1:\"0\";s:28:\"customers_status_ot_discount\";s:4:\"0.00\";s:33:\"customers_status_graduated_prices\";s:1:\"0\";s:27:\"customers_status_show_price\";s:1:\"1\";s:31:\"customers_status_show_price_tax\";s:1:\"1\";s:27:\"customers_status_add_tax_ot\";s:1:\"0\";s:34:\"customers_status_payment_unallowed\";s:0:\"\";s:35:\"customers_status_shipping_unallowed\";s:0:\"\";s:36:\"customers_status_discount_attributes\";s:1:\"0\";s:15:\"customers_fsk18\";s:1:\"0\";s:23:\"customers_fsk18_display\";s:1:\"0\";s:30:\"customers_status_write_reviews\";s:1:\"0\";s:29:\"customers_status_read_reviews\";s:1:\"0\";}cart|O:12:\"shoppingCart\":5:{s:8:\"contents\";a:0:{}s:5:\"total\";i:0;s:6:\"weight\";i:0;s:6:\"cartID\";N;s:12:\"content_type\";b:0;}account_type|s:1:\"0\";customer_gender|s:1:\"m\";customer_first_name|s:25:\"<<RSTI_OWNER_FIRST_NAME>>\";customer_last_name|s:24:\"<<RSTI_OWNER_LAST_NAME>>\";customer_id|s:1:\"1\";customer_vat_id|s:0:\"\";customer_default_address_id|s:1:\"1\";customer_country_id|s:2:\"81\";customer_zone_id|s:2:\"94\";user_info|a:4:{s:7:\"user_ip\";s:3:\"::1\";s:9:\"user_host\";s:3:\"::1\";s:10:\"advertiser\";N;s:11:\"referer_url\";s:21:\"http://localhost/cart\";}selected_box|s:13:\"configuration\";actual_content|a:1:{s:0:\"\";a:1:{s:3:\"qty\";i:0;}}');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_status`
--

DROP TABLE IF EXISTS `shipping_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `shipping_status` (
  `shipping_status_id` int(11) NOT NULL default '0',
  `languages_id` int(11) NOT NULL default '1',
  `shipping_status_name` varchar(32) NOT NULL default '',
  `shipping_status_image` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`shipping_status_id`,`languages_id`),
  UNIQUE KEY `idx_shipping_status_name` (`shipping_status_name`,`languages_id`)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `shipping_status`
--

LOCK TABLES `shipping_status` WRITE;
/*!40000 ALTER TABLE `shipping_status` DISABLE KEYS */;
INSERT INTO `shipping_status` VALUES (1,1,'3-4 Days',''),(1,2,'Sofort lieferbar!',''),(2,1,'1 Week',''),(2,2,'demn&auml;chst lieferbar','');
/*!40000 ALTER TABLE `shipping_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specials`
--

DROP TABLE IF EXISTS `specials`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `specials` (
  `specials_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL,
  `specials_quantity` int(4) NOT NULL,
  `specials_new_products_price` decimal(15,4) NOT NULL,
  `specials_date_added` datetime default NULL,
  `specials_last_modified` datetime default NULL,
  `expires_date` datetime default NULL,
  `date_status_change` datetime default NULL,
  `status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`specials_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `specials`
--

LOCK TABLES `specials` WRITE;
/*!40000 ALTER TABLE `specials` DISABLE KEYS */;
/*!40000 ALTER TABLE `specials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_class`
--

DROP TABLE IF EXISTS `tax_class`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tax_class` (
  `tax_class_id` int(11) NOT NULL auto_increment,
  `tax_class_title` varchar(32) NOT NULL,
  `tax_class_description` varchar(255) NOT NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`tax_class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `tax_class`
--

LOCK TABLES `tax_class` WRITE;
/*!40000 ALTER TABLE `tax_class` DISABLE KEYS */;
INSERT INTO `tax_class` VALUES (1,'Standardsatz','','0000-00-00 00:00:00','2008-01-20 11:12:18'),(2,'ermÃ¤ÃŸigter Steuersatz','',NULL,'2008-01-20 11:12:18');
/*!40000 ALTER TABLE `tax_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_rates`
--

DROP TABLE IF EXISTS `tax_rates`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tax_rates` (
  `tax_rates_id` int(11) NOT NULL auto_increment,
  `tax_zone_id` int(11) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `tax_priority` int(5) default '1',
  `tax_rate` decimal(7,4) NOT NULL,
  `tax_description` varchar(255) NOT NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`tax_rates_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `tax_rates`
--

LOCK TABLES `tax_rates` WRITE;
/*!40000 ALTER TABLE `tax_rates` DISABLE KEYS */;
INSERT INTO `tax_rates` VALUES (1,5,1,1,'19.0000','UST 19%','2008-01-20 17:02:35','0000-00-00 00:00:00'),(2,5,2,1,'7.0000','UST 7%','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,6,1,1,'0.0000','EU-AUS-UST 0%','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,6,2,1,'0.0000','EU-AUS-UST 0%','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tax_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whos_online`
--

DROP TABLE IF EXISTS `whos_online`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `whos_online` (
  `customer_id` int(11) default NULL,
  `full_name` varchar(64) NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `time_entry` varchar(14) NOT NULL,
  `time_last_click` varchar(14) NOT NULL,
  `last_page_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `whos_online`
--

LOCK TABLES `whos_online` WRITE;
/*!40000 ALTER TABLE `whos_online` DISABLE KEYS */;
INSERT INTO `whos_online` VALUES (1,'<<RSTI_OWNER_FIRST_NAME>> <<RSTI_OWNER_LAST_NAME>>','cfc3jjrj21fscov1qpnl9v4144','::1','1213883459','1213883826','/cart');
/*!40000 ALTER TABLE `whos_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `zones` (
  `zone_id` int(11) NOT NULL auto_increment,
  `zone_country_id` int(11) NOT NULL,
  `zone_code` varchar(32) NOT NULL,
  `zone_name` varchar(32) NOT NULL,
  PRIMARY KEY  (`zone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=848 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (1,223,'AL','Alabama'),(2,223,'AK','Alaska'),(3,223,'AS','American Samoa'),(4,223,'AZ','Arizona'),(5,223,'AR','Arkansas'),(6,223,'AF','Armed Forces Africa'),(7,223,'AA','Armed Forces Americas'),(8,223,'AC','Armed Forces Canada'),(9,223,'AE','Armed Forces Europe'),(10,223,'AM','Armed Forces Middle East'),(11,223,'AP','Armed Forces Pacific'),(12,223,'CA','California'),(13,223,'CO','Colorado'),(14,223,'CT','Connecticut'),(15,223,'DE','Delaware'),(16,223,'DC','District of Columbia'),(17,223,'FM','Federated States Of Micronesia'),(18,223,'FL','Florida'),(19,223,'GA','Georgia'),(20,223,'GU','Guam'),(21,223,'HI','Hawaii'),(22,223,'ID','Idaho'),(23,223,'IL','Illinois'),(24,223,'IN','Indiana'),(25,223,'IA','Iowa'),(26,223,'KS','Kansas'),(27,223,'KY','Kentucky'),(28,223,'LA','Louisiana'),(29,223,'ME','Maine'),(30,223,'MH','Marshall Islands'),(31,223,'MD','Maryland'),(32,223,'MA','Massachusetts'),(33,223,'MI','Michigan'),(34,223,'MN','Minnesota'),(35,223,'MS','Mississippi'),(36,223,'MO','Missouri'),(37,223,'MT','Montana'),(38,223,'NE','Nebraska'),(39,223,'NV','Nevada'),(40,223,'NH','New Hampshire'),(41,223,'NJ','New Jersey'),(42,223,'NM','New Mexico'),(43,223,'NY','New York'),(44,223,'NC','North Carolina'),(45,223,'ND','North Dakota'),(46,223,'MP','Northern Mariana Islands'),(47,223,'OH','Ohio'),(48,223,'OK','Oklahoma'),(49,223,'OR','Oregon'),(50,223,'PW','Palau'),(51,223,'PA','Pennsylvania'),(52,223,'PR','Puerto Rico'),(53,223,'RI','Rhode Island'),(54,223,'SC','South Carolina'),(55,223,'SD','South Dakota'),(56,223,'TN','Tennessee'),(57,223,'TX','Texas'),(58,223,'UT','Utah'),(59,223,'VT','Vermont'),(60,223,'VI','Virgin Islands'),(61,223,'VA','Virginia'),(62,223,'WA','Washington'),(63,223,'WV','West Virginia'),(64,223,'WI','Wisconsin'),(65,223,'WY','Wyoming'),(66,38,'AB','Alberta'),(67,38,'BC','British Columbia'),(68,38,'MB','Manitoba'),(69,38,'NF','Newfoundland'),(70,38,'NB','New Brunswick'),(71,38,'NS','Nova Scotia'),(72,38,'NT','Northwest Territories'),(73,38,'NU','Nunavut'),(74,38,'ON','Ontario'),(75,38,'PE','Prince Edward Island'),(76,38,'QC','Quebec'),(77,38,'SK','Saskatchewan'),(78,38,'YT','Yukon Territory'),(79,81,'NDS','Niedersachsen'),(80,81,'BAW','Baden-WÃ¼rttemberg'),(81,81,'BAY','Bayern'),(82,81,'BER','Berlin'),(83,81,'BRG','Brandenburg'),(84,81,'BRE','Bremen'),(85,81,'HAM','Hamburg'),(86,81,'HES','Hessen'),(87,81,'MEC','Mecklenburg-Vorpommern'),(88,81,'NRW','Nordrhein-Westfalen'),(89,81,'RHE','Rheinland-Pfalz'),(90,81,'SAR','Saarland'),(91,81,'SAS','Sachsen'),(92,81,'SAC','Sachsen-Anhalt'),(93,81,'SCN','Schleswig-Holstein'),(94,81,'THE','ThÃ¼ringen'),(95,14,'WI','Wien'),(96,14,'NO','NiederÃ¶sterreich'),(97,14,'OO','OberÃ¶sterreich'),(98,14,'SB','Salzburg'),(99,14,'KN','KÃ¤rnten'),(100,14,'ST','Steiermark'),(101,14,'TI','Tirol'),(102,14,'BL','Burgenland'),(103,14,'VB','Voralberg'),(104,204,'AG','Aargau'),(105,204,'AI','Appenzell Innerrhoden'),(106,204,'AR','Appenzell Ausserrhoden'),(107,204,'BE','Bern'),(108,204,'BL','Basel-Landschaft'),(109,204,'BS','Basel-Stadt'),(110,204,'FR','Freiburg'),(111,204,'GE','Genf'),(112,204,'GL','Glarus'),(113,204,'JU','GraubÃ¼nden'),(114,204,'JU','Jura'),(115,204,'LU','Luzern'),(116,204,'NE','Neuenburg'),(117,204,'NW','Nidwalden'),(118,204,'OW','Obwalden'),(119,204,'SG','St. Gallen'),(120,204,'SH','Schaffhausen'),(121,204,'SO','Solothurn'),(122,204,'SZ','Schwyz'),(123,204,'TG','Thurgau'),(124,204,'TI','Tessin'),(125,204,'UR','Uri'),(126,204,'VD','Waadt'),(127,204,'VS','Wallis'),(128,204,'ZG','Zug'),(129,204,'ZH','ZÃ¼rich'),(130,195,'A CoruÃ±a','A CoruÃ±a'),(131,195,'Alava','Alava'),(132,195,'Albacete','Albacete'),(133,195,'Alicante','Alicante'),(134,195,'Almeria','Almeria'),(135,195,'Asturias','Asturias'),(136,195,'Avila','Avila'),(137,195,'Badajoz','Badajoz'),(138,195,'Baleares','Baleares'),(139,195,'Barcelona','Barcelona'),(140,195,'Burgos','Burgos'),(141,195,'Caceres','Caceres'),(142,195,'Cadiz','Cadiz'),(143,195,'Cantabria','Cantabria'),(144,195,'Castellon','Castellon'),(145,195,'Ceuta','Ceuta'),(146,195,'Ciudad Real','Ciudad Real'),(147,195,'Cordoba','Cordoba'),(148,195,'Cuenca','Cuenca'),(149,195,'Girona','Girona'),(150,195,'Granada','Granada'),(151,195,'Guadalajara','Guadalajara'),(152,195,'Guipuzcoa','Guipuzcoa'),(153,195,'Huelva','Huelva'),(154,195,'Huesca','Huesca'),(155,195,'Jaen','Jaen'),(156,195,'La Rioja','La Rioja'),(157,195,'Las Palmas','Las Palmas'),(158,195,'Leon','Leon'),(159,195,'Lleida','Lleida'),(160,195,'Lugo','Lugo'),(161,195,'Madrid','Madrid'),(162,195,'Malaga','Malaga'),(163,195,'Melilla','Melilla'),(164,195,'Murcia','Murcia'),(165,195,'Navarra','Navarra'),(166,195,'Ourense','Ourense'),(167,195,'Palencia','Palencia'),(168,195,'Pontevedra','Pontevedra'),(169,195,'Salamanca','Salamanca'),(170,195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife'),(171,195,'Segovia','Segovia'),(172,195,'Sevilla','Sevilla'),(173,195,'Soria','Soria'),(174,195,'Tarragona','Tarragona'),(175,195,'Teruel','Teruel'),(176,195,'Toledo','Toledo'),(177,195,'Valencia','Valencia'),(178,195,'Valladolid','Valladolid'),(179,195,'Vizcaya','Vizcaya'),(180,195,'Zamora','Zamora'),(181,195,'Zaragoza','Zaragoza'),(182,13,'NSW','New South Wales'),(183,13,'VIC','Victoria'),(184,13,'QLD','Queensland'),(185,13,'NT','Northern Territory'),(186,13,'WA','Western Australia'),(187,13,'SA','South Australia'),(188,13,'TAS','Tasmania'),(189,13,'ACT','Australian Capital Territory'),(190,153,'Northland','Northland'),(191,153,'Auckland','Auckland'),(192,153,'Waikato','Waikato'),(193,153,'Bay of Plenty','Bay of Plenty'),(194,153,'Gisborne','Gisborne'),(195,153,'Hawkes Bay','Hawkes Bay'),(196,153,'Taranaki','Taranaki'),(197,153,'Manawatu-Wanganui','Manawatu-Wanganui'),(198,153,'Wellington','Wellington'),(199,153,'West Coast','West Coast'),(200,153,'Canterbury','Canterbury'),(201,153,'Otago','Otago'),(202,153,'Southland','Southland'),(203,153,'Tasman','Tasman'),(204,153,'Nelson','Nelson'),(205,153,'Marlborough','Marlborough'),(206,30,'SP','SÃ£o Paulo'),(207,30,'RJ','Rio de Janeiro'),(208,30,'PE','Pernanbuco'),(209,30,'BA','Bahia'),(210,30,'AM','Amazonas'),(211,30,'MG','Minas Gerais'),(212,30,'ES','Espirito Santo'),(213,30,'RS','Rio Grande do Sul'),(214,30,'PR','ParanÃ¡'),(215,30,'SC','Santa Catarina'),(216,30,'RG','Rio Grande do Norte'),(217,30,'MS','Mato Grosso do Sul'),(218,30,'MT','Mato Grosso'),(219,30,'GO','Goias'),(220,30,'TO','Tocantins'),(221,30,'DF','Distrito Federal'),(222,30,'RO','Rondonia'),(223,30,'AC','Acre'),(224,30,'AP','Amapa'),(225,30,'RO','Roraima'),(226,30,'AL','Alagoas'),(227,30,'CE','CearÃ¡'),(228,30,'MA','MaranhÃ£o'),(229,30,'PA','ParÃ¡'),(230,30,'PB','ParaÃ­ba'),(231,30,'PI','PiauÃ­'),(232,30,'SE','Sergipe'),(233,43,'I','I RegiÃ³n de TarapacÃ¡'),(234,43,'II','II RegiÃ³n de Antofagasta'),(235,43,'III','III RegiÃ³n de Atacama'),(236,43,'IV','IV RegiÃ³n de Coquimbo'),(237,43,'V','V RegiÃ³n de ValaparaÃ­so'),(238,43,'RM','RegiÃ³n Metropolitana'),(239,43,'VI','VI RegiÃ³n de L. B. OÂ´higgins'),(240,43,'VII','VII RegiÃ³n del Maule'),(241,43,'VIII','VIII RegiÃ³n del BÃ­o BÃ­o'),(242,43,'IX','IX RegiÃ³n de la AraucanÃ­a'),(243,43,'X','X RegiÃ³n de los Lagos'),(244,43,'XI','XI RegiÃ³n de AysÃ©n'),(245,43,'XII','XII RegiÃ³n de Magallanes'),(246,47,'AMA','Amazonas'),(247,47,'ANT','Antioquia'),(248,47,'ARA','Arauca'),(249,47,'ATL','Atlantico'),(250,47,'BOL','Bolivar'),(251,47,'BOY','Boyaca'),(252,47,'CAL','Caldas'),(253,47,'CAQ','Caqueta'),(254,47,'CAS','Casanare'),(255,47,'CAU','Cauca'),(256,47,'CES','Cesar'),(257,47,'CHO','Choco'),(258,47,'COR','Cordoba'),(259,47,'CUN','Cundinamarca'),(260,47,'HUI','Huila'),(261,47,'GUA','Guainia'),(262,47,'GUA','Guajira'),(263,47,'GUV','Guaviare'),(264,47,'MAG','Magdalena'),(265,47,'MET','Meta'),(266,47,'NAR','Narino'),(267,47,'NDS','Norte de Santander'),(268,47,'PUT','Putumayo'),(269,47,'QUI','Quindio'),(270,47,'RIS','Risaralda'),(271,47,'SAI','San Andres Islas'),(272,47,'SAN','Santander'),(273,47,'SUC','Sucre'),(274,47,'TOL','Tolima'),(275,47,'VAL','Valle'),(276,47,'VAU','Vaupes'),(277,47,'VIC','Vichada'),(278,73,'Et','Etranger'),(279,73,'01','Ain'),(280,73,'02','Aisne'),(281,73,'03','Allier'),(282,73,'04','Alpes de Haute Provence'),(283,73,'05','Hautes-Alpes'),(284,73,'06','Alpes Maritimes'),(285,73,'07','Ard?che'),(286,73,'08','Ardennes'),(287,73,'09','Ari?ge'),(288,73,'10','Aube'),(289,73,'11','Aude'),(290,73,'12','Aveyron'),(291,73,'13','Bouches du RhÃƒÂ´ne'),(292,73,'14','Calvados'),(293,73,'15','Cantal'),(294,73,'16','Charente'),(295,73,'17','Charente Maritime'),(296,73,'18','Cher'),(297,73,'19','Corr?ze'),(298,73,'2A','Corse du Sud'),(299,73,'2B','Haute Corse'),(300,73,'21','Câ„¢te d\'or'),(301,73,'22','Câ„¢tes d\'Armor'),(302,73,'23','Creuse'),(303,73,'24','Dordogne'),(304,73,'25','Doubs'),(305,73,'26','Drâ„¢me'),(306,73,'27','Eure'),(307,73,'28','Eure et Loir'),(308,73,'29','Finist?re'),(309,73,'30','Gard'),(310,73,'31','Haute Garonne'),(311,73,'32','Gers'),(312,73,'33','Gironde'),(313,73,'34','HÅ½rault'),(314,73,'35','Ille et Vilaine'),(315,73,'36','Indre'),(316,73,'37','Indre et Loire'),(317,73,'38','Is?re'),(318,73,'39','Jura'),(319,73,'40','Landes'),(320,73,'41','Loir et Cher'),(321,73,'42','Loire'),(322,73,'43','Haute Loire'),(323,73,'44','Loire Atlantique'),(324,73,'45','Loiret'),(325,73,'46','Lot'),(326,73,'47','Lot et Garonne'),(327,73,'48','Loz?re'),(328,73,'49','Maine et Loire'),(329,73,'50','Manche'),(330,73,'51','Marne'),(331,73,'52','Haute Marne'),(332,73,'53','Mayenne'),(333,73,'54','Meurthe et Moselle'),(334,73,'55','Meuse'),(335,73,'56','Morbihan'),(336,73,'57','Moselle'),(337,73,'58','Ni?vre'),(338,73,'59','Nord'),(339,73,'60','Oise'),(340,73,'61','Orne'),(341,73,'62','Pas de Calais'),(342,73,'63','Puy de Dâ„¢me'),(343,73,'64','PyrÅ½nÅ½es Atlantiques'),(344,73,'65','Hautes PyrÅ½nÅ½es'),(345,73,'66','PyrÅ½nÅ½es Orientales'),(346,73,'67','Bas Rhin'),(347,73,'68','Haut Rhin'),(348,73,'69','Rhâ„¢ne'),(349,73,'70','Haute Saâ„¢ne'),(350,73,'71','Saâ„¢ne et Loire'),(351,73,'72','Sarthe'),(352,73,'73','Savoie'),(353,73,'74','Haute Savoie'),(354,73,'75','Paris'),(355,73,'76','Seine Maritime'),(356,73,'77','Seine et Marne'),(357,73,'78','Yvelines'),(358,73,'79','Deux S?vres'),(359,73,'80','Somme'),(360,73,'81','Tarn'),(361,73,'82','Tarn et Garonne'),(362,73,'83','Var'),(363,73,'84','Vaucluse'),(364,73,'85','VendÅ½e'),(365,73,'86','Vienne'),(366,73,'87','Haute Vienne'),(367,73,'88','Vosges'),(368,73,'89','Yonne'),(369,73,'90','Territoire de Belfort'),(370,73,'91','Essonne'),(371,73,'92','Hauts de Seine'),(372,73,'93','Seine St-Denis'),(373,73,'94','Val de Marne'),(374,73,'95','Val d\'Oise'),(375,73,'971 (DOM)','Guadeloupe'),(376,73,'972 (DOM)','Martinique'),(377,73,'973 (DOM)','Guyane'),(378,73,'974 (DOM)','Saint Denis'),(379,73,'975 (DOM)','St-Pierre de Miquelon'),(380,73,'976 (TOM)','Mayotte'),(381,73,'984 (TOM)','Terres australes et Antartiques '),(382,73,'985 (TOM)','Nouvelle CalÅ½donie'),(383,73,'986 (TOM)','Wallis et Futuna'),(384,73,'987 (TOM)','PolynÅ½sie fran?aise'),(385,99,'DL','Delhi'),(386,99,'MH','Maharashtra'),(387,99,'TN','Tamil Nadu'),(388,99,'KL','Kerala'),(389,99,'AP','Andhra Pradesh'),(390,99,'KA','Karnataka'),(391,99,'GA','Goa'),(392,99,'MP','Madhya Pradesh'),(393,99,'PY','Pondicherry'),(394,99,'GJ','Gujarat'),(395,99,'OR','Orrisa'),(396,99,'CA','Chhatisgarh'),(397,99,'JH','Jharkhand'),(398,99,'BR','Bihar'),(399,99,'WB','West Bengal'),(400,99,'UP','Uttar Pradesh'),(401,99,'RJ','Rajasthan'),(402,99,'PB','Punjab'),(403,99,'HR','Haryana'),(404,99,'CH','Chandigarh'),(405,99,'JK','Jammu & Kashmir'),(406,99,'HP','Himachal Pradesh'),(407,99,'UA','Uttaranchal'),(408,99,'LK','Lakshadweep'),(409,99,'AN','Andaman & Nicobar'),(410,99,'MG','Meghalaya'),(411,99,'AS','Assam'),(412,99,'DR','Dadra & Nagar Haveli'),(413,99,'DN','Daman & Diu'),(414,99,'SK','Sikkim'),(415,99,'TR','Tripura'),(416,99,'MZ','Mizoram'),(417,99,'MN','Manipur'),(418,99,'NL','Nagaland'),(419,99,'AR','Arunachal Pradesh'),(420,105,'AG','Agrigento'),(421,105,'AL','Alessandria'),(422,105,'AN','Ancona'),(423,105,'AO','Aosta'),(424,105,'AR','Arezzo'),(425,105,'AP','Ascoli Piceno'),(426,105,'AT','Asti'),(427,105,'AV','Avellino'),(428,105,'BA','Bari'),(429,105,'BL','Belluno'),(430,105,'BN','Benevento'),(431,105,'BG','Bergamo'),(432,105,'BI','Biella'),(433,105,'BO','Bologna'),(434,105,'BZ','Bolzano'),(435,105,'BS','Brescia'),(436,105,'BR','Brindisi'),(437,105,'CA','Cagliari'),(438,105,'CL','Caltanissetta'),(439,105,'CB','Campobasso'),(440,105,'CE','Caserta'),(441,105,'CT','Catania'),(442,105,'CZ','Catanzaro'),(443,105,'CH','Chieti'),(444,105,'CO','Como'),(445,105,'CS','Cosenza'),(446,105,'CR','Cremona'),(447,105,'KR','Crotone'),(448,105,'CN','Cuneo'),(449,105,'EN','Enna'),(450,105,'FE','Ferrara'),(451,105,'FI','Firenze'),(452,105,'FG','Foggia'),(453,105,'FO','ForlÃ¬'),(454,105,'FR','Frosinone'),(455,105,'GE','Genova'),(456,105,'GO','Gorizia'),(457,105,'GR','Grosseto'),(458,105,'IM','Imperia'),(459,105,'IS','Isernia'),(460,105,'AQ','Aquila'),(461,105,'SP','La Spezia'),(462,105,'LT','Latina'),(463,105,'LE','Lecce'),(464,105,'LC','Lecco'),(465,105,'LI','Livorno'),(466,105,'LO','Lodi'),(467,105,'LU','Lucca'),(468,105,'MC','Macerata'),(469,105,'MN','Mantova'),(470,105,'MS','Massa-Carrara'),(471,105,'MT','Matera'),(472,105,'ME','Messina'),(473,105,'MI','Milano'),(474,105,'MO','Modena'),(475,105,'NA','Napoli'),(476,105,'NO','Novara'),(477,105,'NU','Nuoro'),(478,105,'OR','Oristano'),(479,105,'PD','Padova'),(480,105,'PA','Palermo'),(481,105,'PR','Parma'),(482,105,'PG','Perugia'),(483,105,'PV','Pavia'),(484,105,'PS','Pesaro e Urbino'),(485,105,'PE','Pescara'),(486,105,'PC','Piacenza'),(487,105,'PI','Pisa'),(488,105,'PT','Pistoia'),(489,105,'PN','Pordenone'),(490,105,'PZ','Potenza'),(491,105,'PO','Prato'),(492,105,'RG','Ragusa'),(493,105,'RA','Ravenna'),(494,105,'RC','Reggio di Calabria'),(495,105,'RE','Reggio Emilia'),(496,105,'RI','Rieti'),(497,105,'RN','Rimini'),(498,105,'RM','Roma'),(499,105,'RO','Rovigo'),(500,105,'SA','Salerno'),(501,105,'SS','Sassari'),(502,105,'SV','Savona'),(503,105,'SI','Siena'),(504,105,'SR','Siracusa'),(505,105,'SO','Sondrio'),(506,105,'TA','Taranto'),(507,105,'TE','Teramo'),(508,105,'TR','Terni'),(509,105,'TO','Torino'),(510,105,'TP','Trapani'),(511,105,'TN','Trento'),(512,105,'TV','Treviso'),(513,105,'TS','Trieste'),(514,105,'UD','Udine'),(515,105,'VA','Varese'),(516,105,'VE','Venezia'),(517,105,'VB','Verbania'),(518,105,'VC','Vercelli'),(519,105,'VR','Verona'),(520,105,'VV','Vibo Valentia'),(521,105,'VI','Vicenza'),(522,105,'VT','Viterbo'),(523,107,'Niigata','Niigata'),(524,107,'Toyama','Toyama'),(525,107,'Ishikawa','Ishikawa'),(526,107,'Fukui','Fukui'),(527,107,'Yamanashi','Yamanashi'),(528,107,'Nagano','Nagano'),(529,107,'Gifu','Gifu'),(530,107,'Shizuoka','Shizuoka'),(531,107,'Aichi','Aichi'),(532,107,'Mie','Mie'),(533,107,'Shiga','Shiga'),(534,107,'Kyoto','Kyoto'),(535,107,'Osaka','Osaka'),(536,107,'Hyogo','Hyogo'),(537,107,'Nara','Nara'),(538,107,'Wakayama','Wakayama'),(539,107,'Tottori','Tottori'),(540,107,'Shimane','Shimane'),(541,107,'Okayama','Okayama'),(542,107,'Hiroshima','Hiroshima'),(543,107,'Yamaguchi','Yamaguchi'),(544,107,'Tokushima','Tokushima'),(545,107,'Kagawa','Kagawa'),(546,107,'Ehime','Ehime'),(547,107,'Kochi','Kochi'),(548,107,'Fukuoka','Fukuoka'),(549,107,'Saga','Saga'),(550,107,'Nagasaki','Nagasaki'),(551,107,'Kumamoto','Kumamoto'),(552,107,'Oita','Oita'),(553,107,'Miyazaki','Miyazaki'),(554,107,'Kagoshima','Kagoshima'),(555,129,'JOH','Johor'),(556,129,'KDH','Kedah'),(557,129,'KEL','Kelantan'),(558,129,'KL','Kuala Lumpur'),(559,129,'MEL','Melaka'),(560,129,'NS','Negeri Sembilan'),(561,129,'PAH','Pahang'),(562,129,'PRK','Perak'),(563,129,'PER','Perlis'),(564,129,'PP','Pulau Pinang'),(565,129,'SAB','Sabah'),(566,129,'SWK','Sarawak'),(567,129,'SEL','Selangor'),(568,129,'TER','Terengganu'),(569,129,'LAB','W.P.Labuan'),(570,138,'AGS','Aguascalientes'),(571,138,'BC','Baja California'),(572,138,'BCS','Baja California Sur'),(573,138,'CAM','Campeche'),(574,138,'COA','Coahuila'),(575,138,'COL','Colima'),(576,138,'CHI','Chiapas'),(577,138,'CHIH','Chihuahua'),(578,138,'DF','Distrito Federal'),(579,138,'DGO','Durango'),(580,138,'MEX','Estado de Mexico'),(581,138,'GTO','Guanajuato'),(582,138,'GRO','Guerrero'),(583,138,'HGO','Hidalgo'),(584,138,'JAL','Jalisco'),(585,138,'MCH','Michoacan'),(586,138,'MOR','Morelos'),(587,138,'NAY','Nayarit'),(588,138,'NL','Nuevo Leon'),(589,138,'OAX','Oaxaca'),(590,138,'PUE','Puebla'),(591,138,'QRO','Queretaro'),(592,138,'QR','Quintana Roo'),(593,138,'SLP','San Luis Potosi'),(594,138,'SIN','Sinaloa'),(595,138,'SON','Sonora'),(596,138,'TAB','Tabasco'),(597,138,'TMPS','Tamaulipas'),(598,138,'TLAX','Tlaxcala'),(599,138,'VER','Veracruz'),(600,138,'YUC','Yucatan'),(601,138,'ZAC','Zacatecas'),(602,160,'OSL','Oslo'),(603,160,'AKE','Akershus'),(604,160,'AUA','Aust-Agder'),(605,160,'BUS','Buskerud'),(606,160,'FIN','Finnmark'),(607,160,'HED','Hedmark'),(608,160,'HOR','Hordaland'),(609,160,'MOR','MÃ¸re og Romsdal'),(610,160,'NOR','Nordland'),(611,160,'NTR','Nord-TrÃ¸ndelag'),(612,160,'OPP','Oppland'),(613,160,'ROG','Rogaland'),(614,160,'SOF','Sogn og Fjordane'),(615,160,'STR','SÃ¸r-TrÃ¸ndelag'),(616,160,'TEL','Telemark'),(617,160,'TRO','Troms'),(618,160,'VEA','Vest-Agder'),(619,160,'OST','Ã˜stfold'),(620,160,'SVA','Svalbard'),(621,99,'KHI','Karachi'),(622,99,'LH','Lahore'),(623,99,'ISB','Islamabad'),(624,99,'QUE','Quetta'),(625,99,'PSH','Peshawar'),(626,99,'GUJ','Gujrat'),(627,99,'SAH','Sahiwal'),(628,99,'FSB','Faisalabad'),(629,99,'RIP','Rawal Pindi'),(630,175,'AB','Alba'),(631,175,'AR','Arad'),(632,175,'AG','Arges'),(633,175,'BC','Bacau'),(634,175,'BH','Bihor'),(635,175,'BN','Bistrita-Nasaud'),(636,175,'BT','Botosani'),(637,175,'BV','Brasov'),(638,175,'BR','Braila'),(639,175,'B','Bucuresti'),(640,175,'BZ','Buzau'),(641,175,'CS','Caras-Severin'),(642,175,'CL','Calarasi'),(643,175,'CJ','Cluj'),(644,175,'CT','Constanta'),(645,175,'CV','Covasna'),(646,175,'DB','Dimbovita'),(647,175,'DJ','Dolj'),(648,175,'GL','Galati'),(649,175,'GR','Giurgiu'),(650,175,'GJ','Gorj'),(651,175,'HR','Harghita'),(652,175,'HD','Hunedoara'),(653,175,'IL','Ialomita'),(654,175,'IS','Iasi'),(655,175,'IF','Ilfov'),(656,175,'MM','Maramures'),(657,175,'MH','Mehedint'),(658,175,'MS','Mures'),(659,175,'NT','Neamt'),(660,175,'OT','Olt'),(661,175,'PH','Prahova'),(662,175,'SM','Satu-Mare'),(663,175,'SJ','Salaj'),(664,175,'SB','Sibiu'),(665,175,'SV','Suceava'),(666,175,'TR','Teleorman'),(667,175,'TM','Timis'),(668,175,'TL','Tulcea'),(669,175,'VS','Vaslui'),(670,175,'VL','Valcea'),(671,175,'VN','Vrancea'),(672,193,'WP','Western Cape'),(673,193,'GP','Gauteng'),(674,193,'KZN','Kwazulu-Natal'),(675,193,'NC','Northern-Cape'),(676,193,'EC','Eastern-Cape'),(677,193,'MP','Mpumalanga'),(678,193,'NW','North-West'),(679,193,'FS','Free State'),(680,193,'NP','Northern Province'),(681,215,'ADANA','ADANA'),(682,215,'ADIYAMAN','ADIYAMAN'),(683,215,'AFYON','AFYON'),(684,215,'AGRI','AGRI'),(685,215,'AMASYA','AMASYA'),(686,215,'ANKARA','ANKARA'),(687,215,'ANTALYA','ANTALYA'),(688,215,'ARTVIN','ARTVIN'),(689,215,'AYDIN','AYDIN'),(690,215,'BALIKESIR','BALIKESIR'),(691,215,'BILECIK','BILECIK'),(692,215,'BINGÃ–L','BINGÃ–L'),(693,215,'BITLIS','BITLIS'),(694,215,'BOLU','BOLU'),(695,215,'BURDUR','BURDUR'),(696,215,'BURSA','BURSA'),(697,215,'Ã‡ANAKKALE','Ã‡ANAKKALE'),(698,215,'Ã‡ANKIRI','Ã‡ANKIRI'),(699,215,'Ã‡ORUM','Ã‡ORUM'),(700,215,'DENIZLI','DENIZLI'),(701,215,'DIYARBAKIR','DIYARBAKIR'),(702,215,'EDIRNE','EDIRNE'),(703,215,'ELAZIG','ELAZIG'),(704,215,'ERZINCAN','ERZINCAN'),(705,215,'ERZURUM','ERZURUM'),(706,215,'ESKISEHIR','ESKISEHIR'),(707,215,'GAZIANTEP','GAZIANTEP'),(708,215,'GIRESUN','GIRESUN'),(709,215,'GÃœMÃœSHANE','GÃœMÃœSHANE'),(710,215,'HAKKARI','HAKKARI'),(711,215,'HATAY','HATAY'),(712,215,'ISPARTA','ISPARTA'),(713,215,'IÃ‡EL','IÃ‡EL'),(714,215,'ISTANBUL','ISTANBUL'),(715,215,'IZMIR','IZMIR'),(716,215,'KARS','KARS'),(717,215,'KASTAMONU','KASTAMONU'),(718,215,'KAYSERI','KAYSERI'),(719,215,'KIRKLARELI','KIRKLARELI'),(720,215,'KIRSEHIR','KIRSEHIR'),(721,215,'KOCAELI','KOCAELI'),(722,215,'KONYA','KONYA'),(723,215,'KÃœTAHYA','KÃœTAHYA'),(724,215,'MALATYA','MALATYA'),(725,215,'MANISA','MANISA'),(726,215,'KAHRAMANMARAS','KAHRAMANMARAS'),(727,215,'MARDIN','MARDIN'),(728,215,'MUGLA','MUGLA'),(729,215,'MUS','MUS'),(730,215,'NEVSEHIR','NEVSEHIR'),(731,215,'NIGDE','NIGDE'),(732,215,'ORDU','ORDU'),(733,215,'RIZE','RIZE'),(734,215,'SAKARYA','SAKARYA'),(735,215,'SAMSUN','SAMSUN'),(736,215,'SIIRT','SIIRT'),(737,215,'SINOP','SINOP'),(738,215,'SIVAS','SIVAS'),(739,215,'TEKIRDAG','TEKIRDAG'),(740,215,'TOKAT','TOKAT'),(741,215,'TRABZON','TRABZON'),(742,215,'TUNCELI','TUNCELI'),(743,215,'SANLIURFA','SANLIURFA'),(744,215,'USAK','USAK'),(745,215,'VAN','VAN'),(746,215,'YOZGAT','YOZGAT'),(747,215,'ZONGULDAK','ZONGULDAK'),(748,215,'AKSARAY','AKSARAY'),(749,215,'BAYBURT','BAYBURT'),(750,215,'KARAMAN','KARAMAN'),(751,215,'KIRIKKALE','KIRIKKALE'),(752,215,'BATMAN','BATMAN'),(753,215,'SIRNAK','SIRNAK'),(754,215,'BARTIN','BARTIN'),(755,215,'ARDAHAN','ARDAHAN'),(756,215,'IGDIR','IGDIR'),(757,215,'YALOVA','YALOVA'),(758,215,'KARABÃœK','KARABÃœK'),(759,215,'KILIS','KILIS'),(760,215,'OSMANIYE','OSMANIYE'),(761,215,'DÃœZCE','DÃœZCE'),(762,229,'AM','Amazonas'),(763,229,'AN','AnzoÃ¡tegui'),(764,229,'AR','Aragua'),(765,229,'AP','Apure'),(766,229,'BA','Barinas'),(767,229,'BO','BolÃ­var'),(768,229,'CA','Carabobo'),(769,229,'CO','Cojedes'),(770,229,'DA','Delta Amacuro'),(771,229,'DC','Distrito Capital'),(772,229,'FA','FalcÃ³n'),(773,229,'GA','GuÃ¡rico'),(774,229,'GU','Guayana'),(775,229,'LA','Lara'),(776,229,'ME','MÃ©rida'),(777,229,'MI','Miranda'),(778,229,'MO','Monagas'),(779,229,'NE','Nueva Esparta'),(780,229,'PO','Portuguesa'),(781,229,'SU','Sucre'),(782,229,'TA','TÃ¡chira'),(783,229,'TU','Trujillo'),(784,229,'VA','Vargas'),(785,229,'YA','Yaracuy'),(786,229,'ZU','Zulia'),(787,222,'AVON','Avon'),(788,222,'BEDS','Bedfordshire'),(789,222,'BERK','Berkshire'),(790,222,'BIRM','Birmingham'),(791,222,'BORD','Borders'),(792,222,'BUCK','Buckinghamshire'),(793,222,'CAMB','Cambridgeshire'),(794,222,'CENT','Central'),(795,222,'CHES','Cheshire'),(796,222,'CLEV','Cleveland'),(797,222,'CLWY','Clwyd'),(798,222,'CORN','Cornwall'),(799,222,'CUMB','Cumbria'),(800,222,'DERB','Derbyshire'),(801,222,'DEVO','Devon'),(802,222,'DORS','Dorset'),(803,222,'DUMF','Dumfries & Galloway'),(804,222,'DURH','Durham'),(805,222,'DYFE','Dyfed'),(806,222,'ESUS','East Sussex'),(807,222,'ESSE','Essex'),(808,222,'FIFE','Fife'),(809,222,'GLAM','Glamorgan'),(810,222,'GLOU','Gloucestershire'),(811,222,'GRAM','Grampian'),(812,222,'GWEN','Gwent'),(813,222,'GWYN','Gwynedd'),(814,222,'HAMP','Hampshire'),(815,222,'HERE','Hereford & Worcester'),(816,222,'HERT','Hertfordshire'),(817,222,'HUMB','Humberside'),(818,222,'KENT','Kent'),(819,222,'LANC','Lancashire'),(820,222,'LEIC','Leicestershire'),(821,222,'LINC','Lincolnshire'),(822,222,'LOND','London'),(823,222,'LOTH','Lothian'),(824,222,'MANC','Manchester'),(825,222,'MERS','Merseyside'),(826,222,'NORF','Norfolk'),(827,222,'NYOR','North Yorkshire'),(828,222,'NWHI','North west Highlands'),(829,222,'NHAM','Northamptonshire'),(830,222,'NUMB','Northumberland'),(831,222,'NOTT','Nottinghamshire'),(832,222,'OXFO','Oxfordshire'),(833,222,'POWY','Powys'),(834,222,'SHRO','Shropshire'),(835,222,'SOME','Somerset'),(836,222,'SYOR','South Yorkshire'),(837,222,'STAF','Staffordshire'),(838,222,'STRA','Strathclyde'),(839,222,'SUFF','Suffolk'),(840,222,'SURR','Surrey'),(841,222,'WSUS','West Sussex'),(842,222,'TAYS','Tayside'),(843,222,'TYWE','Tyne & Wear'),(844,222,'WARW','Warwickshire'),(845,222,'WISL','West Isles'),(846,222,'WYOR','West Yorkshire'),(847,222,'WILT','Wiltshire');
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones_to_geo_zones`
--

DROP TABLE IF EXISTS `zones_to_geo_zones`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `zones_to_geo_zones` (
  `association_id` int(11) NOT NULL auto_increment,
  `zone_country_id` int(11) NOT NULL,
  `zone_id` int(11) default NULL,
  `geo_zone_id` int(11) default NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`association_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `zones_to_geo_zones`
--

LOCK TABLES `zones_to_geo_zones` WRITE;
/*!40000 ALTER TABLE `zones_to_geo_zones` DISABLE KEYS */;
INSERT INTO `zones_to_geo_zones` VALUES (14,14,0,5,NULL,'2008-01-20 11:12:18'),(21,21,0,5,NULL,'2008-01-20 11:12:18'),(55,55,0,5,NULL,'2008-01-20 11:12:18'),(56,56,0,5,NULL,'2008-01-20 11:12:18'),(57,57,0,5,NULL,'2008-01-20 11:12:18'),(67,67,0,5,NULL,'2008-01-20 11:12:18'),(72,72,0,5,NULL,'2008-01-20 11:12:18'),(73,73,0,5,NULL,'2008-01-20 11:12:18'),(81,81,NULL,5,'2008-05-02 15:39:31','2008-01-20 11:12:18'),(84,84,0,5,NULL,'2008-01-20 11:12:18'),(97,97,0,5,NULL,'2008-01-20 11:12:18'),(103,103,0,5,NULL,'2008-01-20 11:12:18'),(105,105,0,5,NULL,'2008-01-20 11:12:18'),(117,117,0,5,NULL,'2008-01-20 11:12:18'),(123,123,0,5,NULL,'2008-01-20 11:12:18'),(124,124,0,5,NULL,'2008-01-20 11:12:18'),(132,132,0,5,NULL,'2008-01-20 11:12:18'),(150,150,0,5,NULL,'2008-01-20 11:12:18'),(170,170,0,5,NULL,'2008-01-20 11:12:18'),(171,171,0,5,NULL,'2008-01-20 11:12:18'),(189,189,0,5,NULL,'2008-01-20 11:12:18'),(190,190,0,5,NULL,'2008-01-20 11:12:18'),(195,195,0,5,NULL,'2008-01-20 11:12:18'),(203,203,0,5,NULL,'2008-01-20 11:12:18'),(222,222,0,5,NULL,'2008-01-20 11:12:18'),(1,1,0,6,NULL,'2008-01-20 11:12:18'),(2,2,0,6,NULL,'2008-01-20 11:12:18'),(3,3,0,6,NULL,'2008-01-20 11:12:18'),(4,4,0,6,NULL,'2008-01-20 11:12:18'),(5,5,0,6,NULL,'2008-01-20 11:12:18'),(6,6,0,6,NULL,'2008-01-20 11:12:18'),(7,7,0,6,NULL,'2008-01-20 11:12:18'),(8,8,0,6,NULL,'2008-01-20 11:12:18'),(9,9,0,6,NULL,'2008-01-20 11:12:18'),(10,10,0,6,NULL,'2008-01-20 11:12:18'),(11,11,0,6,NULL,'2008-01-20 11:12:18'),(12,12,0,6,NULL,'2008-01-20 11:12:18'),(13,13,0,6,NULL,'2008-01-20 11:12:18'),(15,15,0,6,NULL,'2008-01-20 11:12:18'),(16,16,0,6,NULL,'2008-01-20 11:12:18'),(17,17,0,6,NULL,'2008-01-20 11:12:18'),(18,18,0,6,NULL,'2008-01-20 11:12:18'),(19,19,0,6,NULL,'2008-01-20 11:12:18'),(20,20,0,6,NULL,'2008-01-20 11:12:18'),(22,22,0,6,NULL,'2008-01-20 11:12:18'),(23,23,0,6,NULL,'2008-01-20 11:12:18'),(24,24,0,6,NULL,'2008-01-20 11:12:18'),(25,25,0,6,NULL,'2008-01-20 11:12:18'),(26,26,0,6,NULL,'2008-01-20 11:12:18'),(27,27,0,6,NULL,'2008-01-20 11:12:18'),(28,28,0,6,NULL,'2008-01-20 11:12:18'),(29,29,0,6,NULL,'2008-01-20 11:12:18'),(30,30,0,6,NULL,'2008-01-20 11:12:18'),(31,31,0,6,NULL,'2008-01-20 11:12:18'),(32,32,0,6,NULL,'2008-01-20 11:12:18'),(33,33,0,6,NULL,'2008-01-20 11:12:18'),(34,34,0,6,NULL,'2008-01-20 11:12:18'),(35,35,0,6,NULL,'2008-01-20 11:12:18'),(36,36,0,6,NULL,'2008-01-20 11:12:18'),(37,37,0,6,NULL,'2008-01-20 11:12:18'),(38,38,0,6,NULL,'2008-01-20 11:12:18'),(39,39,0,6,NULL,'2008-01-20 11:12:18'),(40,40,0,6,NULL,'2008-01-20 11:12:18'),(41,41,0,6,NULL,'2008-01-20 11:12:18'),(42,42,0,6,NULL,'2008-01-20 11:12:18'),(43,43,0,6,NULL,'2008-01-20 11:12:18'),(44,44,0,6,NULL,'2008-01-20 11:12:18'),(45,45,0,6,NULL,'2008-01-20 11:12:18'),(46,46,0,6,NULL,'2008-01-20 11:12:18'),(47,47,0,6,NULL,'2008-01-20 11:12:18'),(48,48,0,6,NULL,'2008-01-20 11:12:18'),(49,49,0,6,NULL,'2008-01-20 11:12:18'),(50,50,0,6,NULL,'2008-01-20 11:12:18'),(51,51,0,6,NULL,'2008-01-20 11:12:18'),(52,52,0,6,NULL,'2008-01-20 11:12:18'),(53,53,0,6,NULL,'2008-01-20 11:12:18'),(54,54,0,6,NULL,'2008-01-20 11:12:18'),(58,58,0,6,NULL,'2008-01-20 11:12:18'),(59,59,0,6,NULL,'2008-01-20 11:12:18'),(60,60,0,6,NULL,'2008-01-20 11:12:18'),(61,61,0,6,NULL,'2008-01-20 11:12:18'),(62,62,0,6,NULL,'2008-01-20 11:12:18'),(63,63,0,6,NULL,'2008-01-20 11:12:18'),(64,64,0,6,NULL,'2008-01-20 11:12:18'),(65,65,0,6,NULL,'2008-01-20 11:12:18'),(66,66,0,6,NULL,'2008-01-20 11:12:18'),(68,68,0,6,NULL,'2008-01-20 11:12:18'),(69,69,0,6,NULL,'2008-01-20 11:12:18'),(70,70,0,6,NULL,'2008-01-20 11:12:18'),(71,71,0,6,NULL,'2008-01-20 11:12:18'),(74,74,0,6,NULL,'2008-01-20 11:12:18'),(75,75,0,6,NULL,'2008-01-20 11:12:18'),(76,76,0,6,NULL,'2008-01-20 11:12:18'),(77,77,0,6,NULL,'2008-01-20 11:12:18'),(78,78,0,6,NULL,'2008-01-20 11:12:18'),(79,79,0,6,NULL,'2008-01-20 11:12:18'),(80,80,0,6,NULL,'2008-01-20 11:12:18'),(82,82,0,6,NULL,'2008-01-20 11:12:18'),(83,83,0,6,NULL,'2008-01-20 11:12:18'),(85,85,0,6,NULL,'2008-01-20 11:12:18'),(86,86,0,6,NULL,'2008-01-20 11:12:18'),(87,87,0,6,NULL,'2008-01-20 11:12:18'),(88,88,0,6,NULL,'2008-01-20 11:12:18'),(89,89,0,6,NULL,'2008-01-20 11:12:18'),(90,90,0,6,NULL,'2008-01-20 11:12:18'),(91,91,0,6,NULL,'2008-01-20 11:12:18'),(92,92,0,6,NULL,'2008-01-20 11:12:18'),(93,93,0,6,NULL,'2008-01-20 11:12:18'),(94,94,0,6,NULL,'2008-01-20 11:12:18'),(95,95,0,6,NULL,'2008-01-20 11:12:18'),(96,96,0,6,NULL,'2008-01-20 11:12:18'),(98,98,0,6,NULL,'2008-01-20 11:12:18'),(99,99,0,6,NULL,'2008-01-20 11:12:18'),(100,100,0,6,NULL,'2008-01-20 11:12:18'),(101,101,0,6,NULL,'2008-01-20 11:12:18'),(102,102,0,6,NULL,'2008-01-20 11:12:18'),(104,104,0,6,NULL,'2008-01-20 11:12:18'),(106,106,0,6,NULL,'2008-01-20 11:12:18'),(107,107,0,6,NULL,'2008-01-20 11:12:18'),(108,108,0,6,NULL,'2008-01-20 11:12:18'),(109,109,0,6,NULL,'2008-01-20 11:12:18'),(110,110,0,6,NULL,'2008-01-20 11:12:18'),(111,111,0,6,NULL,'2008-01-20 11:12:18'),(112,112,0,6,NULL,'2008-01-20 11:12:18'),(113,113,0,6,NULL,'2008-01-20 11:12:18'),(114,114,0,6,NULL,'2008-01-20 11:12:18'),(115,115,0,6,NULL,'2008-01-20 11:12:18'),(116,116,0,6,NULL,'2008-01-20 11:12:18'),(118,118,0,6,NULL,'2008-01-20 11:12:18'),(119,119,0,6,NULL,'2008-01-20 11:12:18'),(120,120,0,6,NULL,'2008-01-20 11:12:18'),(121,121,0,6,NULL,'2008-01-20 11:12:18'),(122,122,0,6,NULL,'2008-01-20 11:12:18'),(125,125,0,6,NULL,'2008-01-20 11:12:18'),(126,126,0,6,NULL,'2008-01-20 11:12:18'),(127,127,0,6,NULL,'2008-01-20 11:12:18'),(128,128,0,6,NULL,'2008-01-20 11:12:18'),(129,129,0,6,NULL,'2008-01-20 11:12:18'),(130,130,0,6,NULL,'2008-01-20 11:12:18'),(131,131,0,6,NULL,'2008-01-20 11:12:18'),(133,133,0,6,NULL,'2008-01-20 11:12:18'),(134,134,0,6,NULL,'2008-01-20 11:12:18'),(135,135,0,6,NULL,'2008-01-20 11:12:18'),(136,136,0,6,NULL,'2008-01-20 11:12:18'),(137,137,0,6,NULL,'2008-01-20 11:12:18'),(138,138,0,6,NULL,'2008-01-20 11:12:18'),(139,139,0,6,NULL,'2008-01-20 11:12:18'),(140,140,0,6,NULL,'2008-01-20 11:12:18'),(141,141,0,6,NULL,'2008-01-20 11:12:18'),(142,142,0,6,NULL,'2008-01-20 11:12:18'),(143,143,0,6,NULL,'2008-01-20 11:12:18'),(144,144,0,6,NULL,'2008-01-20 11:12:18'),(145,145,0,6,NULL,'2008-01-20 11:12:18'),(146,146,0,6,NULL,'2008-01-20 11:12:18'),(147,147,0,6,NULL,'2008-01-20 11:12:18'),(148,148,0,6,NULL,'2008-01-20 11:12:18'),(149,149,0,6,NULL,'2008-01-20 11:12:18'),(151,151,0,6,NULL,'2008-01-20 11:12:18'),(152,152,0,6,NULL,'2008-01-20 11:12:18'),(153,153,0,6,NULL,'2008-01-20 11:12:18'),(154,154,0,6,NULL,'2008-01-20 11:12:18'),(155,155,0,6,NULL,'2008-01-20 11:12:18'),(156,156,0,6,NULL,'2008-01-20 11:12:18'),(157,157,0,6,NULL,'2008-01-20 11:12:18'),(158,158,0,6,NULL,'2008-01-20 11:12:18'),(159,159,0,6,NULL,'2008-01-20 11:12:18'),(160,160,0,6,NULL,'2008-01-20 11:12:18'),(161,161,0,6,NULL,'2008-01-20 11:12:18'),(162,162,0,6,NULL,'2008-01-20 11:12:18'),(163,163,0,6,NULL,'2008-01-20 11:12:18'),(164,164,0,6,NULL,'2008-01-20 11:12:18'),(165,165,0,6,NULL,'2008-01-20 11:12:18'),(166,166,0,6,NULL,'2008-01-20 11:12:18'),(167,167,0,6,NULL,'2008-01-20 11:12:18'),(168,168,0,6,NULL,'2008-01-20 11:12:18'),(169,169,0,6,NULL,'2008-01-20 11:12:18'),(172,172,0,6,NULL,'2008-01-20 11:12:18'),(173,173,0,6,NULL,'2008-01-20 11:12:18'),(174,174,0,6,NULL,'2008-01-20 11:12:18'),(175,175,0,6,NULL,'2008-01-20 11:12:18'),(176,176,0,6,NULL,'2008-01-20 11:12:18'),(177,177,0,6,NULL,'2008-01-20 11:12:18'),(178,178,0,6,NULL,'2008-01-20 11:12:18'),(179,179,0,6,NULL,'2008-01-20 11:12:18'),(180,180,0,6,NULL,'2008-01-20 11:12:18'),(181,181,0,6,NULL,'2008-01-20 11:12:18'),(182,182,0,6,NULL,'2008-01-20 11:12:18'),(183,183,0,6,NULL,'2008-01-20 11:12:18'),(184,184,0,6,NULL,'2008-01-20 11:12:18'),(185,185,0,6,NULL,'2008-01-20 11:12:18'),(186,186,0,6,NULL,'2008-01-20 11:12:18'),(187,187,0,6,NULL,'2008-01-20 11:12:18'),(188,188,0,6,NULL,'2008-01-20 11:12:18'),(191,191,0,6,NULL,'2008-01-20 11:12:18'),(192,192,0,6,NULL,'2008-01-20 11:12:18'),(193,193,0,6,NULL,'2008-01-20 11:12:18'),(194,194,0,6,NULL,'2008-01-20 11:12:18'),(196,196,0,6,NULL,'2008-01-20 11:12:18'),(197,197,0,6,NULL,'2008-01-20 11:12:18'),(198,198,0,6,NULL,'2008-01-20 11:12:18'),(199,199,0,6,NULL,'2008-01-20 11:12:18'),(200,200,0,6,NULL,'2008-01-20 11:12:18'),(201,201,0,6,NULL,'2008-01-20 11:12:18'),(202,202,0,6,NULL,'2008-01-20 11:12:18'),(204,204,0,6,NULL,'2008-01-20 11:12:18'),(205,205,0,6,NULL,'2008-01-20 11:12:18'),(206,206,0,6,NULL,'2008-01-20 11:12:18'),(207,207,0,6,NULL,'2008-01-20 11:12:18'),(208,208,0,6,NULL,'2008-01-20 11:12:18'),(209,209,0,6,NULL,'2008-01-20 11:12:18'),(210,210,0,6,NULL,'2008-01-20 11:12:18'),(211,211,0,6,NULL,'2008-01-20 11:12:18'),(212,212,0,6,NULL,'2008-01-20 11:12:18'),(213,213,0,6,NULL,'2008-01-20 11:12:18'),(214,214,0,6,NULL,'2008-01-20 11:12:18'),(215,215,0,6,NULL,'2008-01-20 11:12:18'),(216,216,0,6,NULL,'2008-01-20 11:12:18'),(217,217,0,6,NULL,'2008-01-20 11:12:18'),(218,218,0,6,NULL,'2008-01-20 11:12:18'),(219,219,0,6,NULL,'2008-01-20 11:12:18'),(220,220,0,6,NULL,'2008-01-20 11:12:18'),(221,221,0,6,NULL,'2008-01-20 11:12:18'),(223,223,0,6,NULL,'2008-01-20 11:12:18'),(224,224,0,6,NULL,'2008-01-20 11:12:18'),(225,225,0,6,NULL,'2008-01-20 11:12:18'),(226,226,0,6,NULL,'2008-01-20 11:12:18'),(227,227,0,6,NULL,'2008-01-20 11:12:18'),(228,228,0,6,NULL,'2008-01-20 11:12:18'),(229,229,0,6,NULL,'2008-01-20 11:12:18'),(230,230,0,6,NULL,'2008-01-20 11:12:18'),(231,231,0,6,NULL,'2008-01-20 11:12:18'),(232,232,0,6,NULL,'2008-01-20 11:12:18'),(233,233,0,6,NULL,'2008-01-20 11:12:18'),(234,234,0,6,NULL,'2008-01-20 11:12:18'),(235,235,0,6,NULL,'2008-01-20 11:12:18'),(236,236,0,6,NULL,'2008-01-20 11:12:18'),(237,237,0,6,NULL,'2008-01-20 11:12:18'),(238,238,0,6,NULL,'2008-01-20 11:12:18'),(239,239,0,6,NULL,'2008-01-20 11:12:18');
/*!40000 ALTER TABLE `zones_to_geo_zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-06-19 14:02:34
