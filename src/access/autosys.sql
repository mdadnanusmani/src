-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 10.0.0.140    Database: new_autopmo
-- ------------------------------------------------------
-- Server version	5.7.21-log

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
-- Table structure for table `db`
--

DROP TABLE IF EXISTS `db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `s_insertby` varchar(25) NOT NULL,
  `name` varchar(200) NOT NULL,
  `table_lable` varchar(200) NOT NULL,
  `descrption` varchar(200) NOT NULL,
  `sortby` varchar(200) NOT NULL,
  `fillter` varchar(200) DEFAULT NULL,
  `view` varchar(50) NOT NULL,
  `linecolor` varchar(200) NOT NULL,
  `tb_col` varchar(200) DEFAULT NULL,
  `notificition` varchar(50) NOT NULL,
  `report_view` varchar(200) DEFAULT NULL,
  `report_menu_by` varchar(200) DEFAULT NULL,
  `fillter_search` varchar(200) DEFAULT NULL,
  `page_style` int(5) NOT NULL,
  `dbnote` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db`
--

LOCK TABLES `db` WRITE;
/*!40000 ALTER TABLE `db` DISABLE KEYS */;
INSERT INTO `db` VALUES (0,'admin','login','الدخول للنظام','الدخول للنظام','ordernum',NULL,'0','No',NULL,'No','1',NULL,NULL,1,NULL),(1,'admin','users','المستخدمين','المستخدمين','ordernum','','1','No','','No','1','','username',1,''),(2,'admin','db','قواعد البيانات','قواعد البيانات','ordernum','','1','No','','No','1','','',1,''),(3,'admin','log','تتبع العمليات','تتبع العمليات','ordernum','date,time','1','No','','No','1','','date',1,''),(4,'admin','yesno','فلتر','فلتر','ordernum','','0','No','','No','1','','',1,'');
/*!40000 ALTER TABLE `db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `generation_table`
--

DROP TABLE IF EXISTS `generation_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `generation_table` (
  `table_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(17) NOT NULL,
  `lable` varchar(500) NOT NULL,
  `width` int(2) NOT NULL,
  `visable` varchar(3) NOT NULL,
  `font_size` int(2) NOT NULL,
  `placeholder` varchar(200) NOT NULL,
  `default_value` varchar(200) DEFAULT NULL,
  `table_name` varchar(250) NOT NULL,
  `related_table` varchar(100) NOT NULL,
  `fields` varchar(100) NOT NULL,
  `dis_fields` varchar(150) NOT NULL,
  `refields` varchar(45) DEFAULT NULL,
  `refields_dis` varchar(45) DEFAULT NULL,
  `required` varchar(3) NOT NULL,
  `ordernum` int(5) NOT NULL,
  `fenabling` int(11) DEFAULT '1',
  `dbf` varchar(45) DEFAULT NULL,
  `dbf_to` varchar(45) DEFAULT NULL,
  `dbf_value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=308 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `generation_table`
--

LOCK TABLES `generation_table` WRITE;
/*!40000 ALTER TABLE `generation_table` DISABLE KEYS */;
INSERT INTO `generation_table` VALUES (120,'change_password','Select','تغير كلمة المرور',6,'Yes',14,'الرجاء إدخال تغير كلمة المرور','1','users','','','',NULL,NULL,'Yes',6,1,'No','',NULL),(112,'username','Text','أسم المستخدم',6,'Yes',14,'الرجاء إدخال أسم المستخدم','','users','','','',NULL,NULL,'Yes',1,1,'No','',NULL),(114,'password','Text','كلمة المرور',6,'Yes',14,'الرجاء إدخال كلمة المرور','','users','','','',NULL,NULL,'Yes',2,1,'No','',NULL),(115,'isadmin','Select','مدير نظام',6,'Yes',14,'الرجاء إدخال مدير نظام','','users','','','',NULL,NULL,'Yes',3,1,'No','',NULL),(129,'dbgroups','Multi Select','المجموعات',6,'Yes',14,'الرجاء إدخال المجموعات','','users','db','id','table_lable',NULL,NULL,'Yes',7,1,'No','',NULL),(117,'notificition','Select','تنبيهات',6,'Yes',14,'الرجاء إدخال تنبيهات','','users','','','',NULL,NULL,'Yes',5,1,'No','',NULL),(130,'showall','Select','عرض الكل !',6,'Yes',14,'الرجاء إدخال عرض الكل !','','users','','','',NULL,NULL,'Yes',8,1,'No','',NULL),(131,'name','Text','الأسم داخل قاعدة البيانات ',6,'Yes',14,'الرجاء إدخال الأسم داخل قاعدة البيانات ','','db','','','',NULL,NULL,'Yes',1,1,'No','',NULL),(132,'table_lable','Text','الأسم ',6,'Yes',14,'الرجاء إدخال الأسم ','','db','','','',NULL,NULL,'Yes',2,1,'No','',NULL),(133,'descrption','Text','نص توضيحي',6,'Yes',14,'الرجاء إدخال نص توضيحي','','db','','','',NULL,NULL,'Yes',3,1,'No','',NULL),(143,'report_menu_by','Text','القائمة الجانبية في العرض ',6,'Yes',14,'الرجاء إدخال القائمة الجانبية في العرض ','','db','','','',NULL,NULL,'No',12,1,'No','',NULL),(134,'sortby','Text','ترتيب العرض',6,'Yes',14,'الرجاء إدخال ترتيب العرض','','db','','','',NULL,NULL,'Yes',4,1,'No','',NULL),(135,'fillter','Text','الفلتر',6,'Yes',14,'الرجاء إدخال الفلتر','','db','','','',NULL,NULL,'No',5,1,'No','',NULL),(136,'view','Text','عرض ؟',6,'Yes',14,'الرجاء إدخال عرض ؟','','db','','','',NULL,NULL,'No',6,1,'No','',NULL),(139,'linecolor','Text','تلوين القوائم ؟',6,'Yes',14,'الرجاء إدخال تلوين القوائم ؟','','db','','','',NULL,NULL,'No',7,1,'No','',NULL),(140,'tb_col','Text','tb_col',6,'Yes',14,'الرجاء إدخال tb_col','','db','','','',NULL,NULL,'No',8,1,'No','',NULL),(141,'notificition','Text','التنبيهات ؟',6,'Yes',14,'الرجاء إدخال التنبيهات ؟','','db','','','',NULL,NULL,'No',9,1,'No','',NULL),(142,'report_view','Text','report_view',6,'Yes',14,'الرجاء إدخال report_view','','db','','','',NULL,NULL,'No',10,1,'No','',NULL),(153,'emp_name','Text','أسم الموظف',6,'Yes',14,'الرجاء إدخال أسم الموظف','','users','','','',NULL,NULL,'Yes',9,1,'No','',NULL),(154,'fillter_search','Text','بحث بالتصنيف',6,'Yes',14,'الرجاء إدخال بحث بالتصنيف','','db','','','',NULL,NULL,'No',13,1,'No','',NULL),(182,'page_style','Select','تنصيق الصفحة',6,'Yes',14,'الرجاء إدخال تنصيق الصفحة','','db','','','',NULL,NULL,'No',14,1,'No','',NULL),(199,'dbnote','Text','نص تنبيهي',6,'Yes',14,'الرجاء إدخال نص تنبيهي','','db','','','',NULL,NULL,'No',15,1,'No','',NULL),(217,'mobile','Text','رقم الجوال',6,'Yes',14,'الرجاء إدخال رقم الجوال','','users','','','','','','Yes',14,1,'No','',''),(281,'user_id','Related to table','أسم المستخدم',6,'Yes',14,'الرجاء إدخال أسم المستخدم','','log','users','id','emp_name','','','Yes',1,1,'No','',''),(282,'db','Related to table','المجموعة',6,'Yes',14,'الرجاء إدخال المجموعة','','log','db','id','table_lable','','','Yes',2,1,'No','',''),(283,'date','Date','التاريخ',6,'Yes',14,'الرجاء إدخال التاريخ','','log','','','','','','Yes',3,1,'No','',''),(284,'time','Time','الوقت',6,'Yes',14,'الرجاء إدخال الوقت','','log','','','','','','Yes',4,1,'No','',''),(285,'opration','Select','نوع العملية',6,'Yes',14,'الرجاء إدخال نوع العملية','','log','','','','','','Yes',5,1,'No','',''),(287,'ip_address','Text','IP Address',6,'Yes',14,'الرجاء إدخال IP Address','','log','','','','','','Yes',6,1,'No','',''),(289,'note','Text','الملاحظات',6,'Yes',14,'الرجاء إدخال الملاحظات','','log','','','','','','No',7,1,'Yes','','');
/*!40000 ALTER TABLE `generation_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_change_password`
--

DROP TABLE IF EXISTS `gt_change_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_change_password` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_change_password`
--

LOCK TABLES `gt_change_password` WRITE;
/*!40000 ALTER TABLE `gt_change_password` DISABLE KEYS */;
INSERT INTO `gt_change_password` VALUES (0,'لا','0'),(1,'نعم','1');
/*!40000 ALTER TABLE `gt_change_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_fenabling`
--

DROP TABLE IF EXISTS `gt_fenabling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_fenabling` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_fenabling`
--

LOCK TABLES `gt_fenabling` WRITE;
/*!40000 ALTER TABLE `gt_fenabling` DISABLE KEYS */;
INSERT INTO `gt_fenabling` VALUES (1,'نعم','1'),(2,'لا','2');
/*!40000 ALTER TABLE `gt_fenabling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_isadmin`
--

DROP TABLE IF EXISTS `gt_isadmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_isadmin` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(25) NOT NULL,
  `value` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_isadmin`
--

LOCK TABLES `gt_isadmin` WRITE;
/*!40000 ALTER TABLE `gt_isadmin` DISABLE KEYS */;
INSERT INTO `gt_isadmin` VALUES (1,'نعم','1'),(2,'لا','2');
/*!40000 ALTER TABLE `gt_isadmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_notificition`
--

DROP TABLE IF EXISTS `gt_notificition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_notificition` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(25) NOT NULL,
  `value` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_notificition`
--

LOCK TABLES `gt_notificition` WRITE;
/*!40000 ALTER TABLE `gt_notificition` DISABLE KEYS */;
INSERT INTO `gt_notificition` VALUES (1,'نعم','1'),(2,'لا','0');
/*!40000 ALTER TABLE `gt_notificition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_opration`
--

DROP TABLE IF EXISTS `gt_opration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_opration` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_opration`
--

LOCK TABLES `gt_opration` WRITE;
/*!40000 ALTER TABLE `gt_opration` DISABLE KEYS */;
INSERT INTO `gt_opration` VALUES (1,'دخول فقط','L'),(2,'أضافة','I'),(3,'تعديل','E'),(4,'حذف','D'),(5,'طباعة','P'),(6,'استعراض','V');
/*!40000 ALTER TABLE `gt_opration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_p_status`
--

DROP TABLE IF EXISTS `gt_p_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_p_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_p_status`
--

LOCK TABLES `gt_p_status` WRITE;
/*!40000 ALTER TABLE `gt_p_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `gt_p_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_page_style`
--

DROP TABLE IF EXISTS `gt_page_style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_page_style` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_page_style`
--

LOCK TABLES `gt_page_style` WRITE;
/*!40000 ALTER TABLE `gt_page_style` DISABLE KEYS */;
INSERT INTO `gt_page_style` VALUES (1,'إدخال , تعديل','1'),(2,'تعديل','2');
/*!40000 ALTER TABLE `gt_page_style` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_showall`
--

DROP TABLE IF EXISTS `gt_showall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_showall` (
  `id` int(3) NOT NULL,
  `option` varchar(500) NOT NULL,
  `value` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_showall`
--

LOCK TABLES `gt_showall` WRITE;
/*!40000 ALTER TABLE `gt_showall` DISABLE KEYS */;
INSERT INTO `gt_showall` VALUES (1,'نعم','1'),(0,'لا','0');
/*!40000 ALTER TABLE `gt_showall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_status`
--

DROP TABLE IF EXISTS `gt_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_status` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `option` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_status`
--

LOCK TABLES `gt_status` WRITE;
/*!40000 ALTER TABLE `gt_status` DISABLE KEYS */;
INSERT INTO `gt_status` VALUES (1,'نشط','1'),(2,'غير نشط','0');
/*!40000 ALTER TABLE `gt_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_insertby` varchar(45) NOT NULL,
  `user_id` int(5) NOT NULL,
  `db` int(5) NOT NULL,
  `date` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `opration` int(5) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `note` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2010 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1999,'1',1,0,'2019-02-10','13:54:47',1,'localhost',''),(2000,'1',1,3,'2019-02-10','13:57:50',6,'localhost',''),(2001,'1',1,3,'2019-02-10','13:58:20',6,'localhost',''),(2002,'1',1,1,'2019-02-10','13:58:26',6,'localhost',''),(2003,'1',1,1,'2019-02-10','13:58:46',6,'localhost',''),(2004,'1',1,1,'2019-02-10','13:59:11',6,'localhost',''),(2005,'1',1,1,'2019-02-10','14:00:04',6,'localhost',''),(2006,'1',1,1,'2019-02-10','14:00:33',6,'localhost',''),(2007,'1',1,0,'2019-02-10','14:00:37',6,'localhost',''),(2008,'1',1,2,'2019-02-10','14:00:43',6,'localhost',''),(2009,'1',1,3,'2019-02-10','14:00:47',6,'localhost','');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificition`
--

DROP TABLE IF EXISTS `notificition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificition` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `db` int(9) NOT NULL,
  `lastinsert` int(9) NOT NULL,
  `lastupdate` int(9) NOT NULL,
  `flaqinsert` int(9) NOT NULL,
  `flaqupdate` int(9) NOT NULL,
  `userid` int(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificition`
--

LOCK TABLES `notificition` WRITE;
/*!40000 ALTER TABLE `notificition` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `ba` varchar(100) NOT NULL,
  `sl` varchar(100) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitname` varchar(100) NOT NULL,
  `msgurl` text NOT NULL,
  `url` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `main_design` text NOT NULL,
  `main_design_end` text NOT NULL,
  `icon` text NOT NULL,
  `about` varchar(500) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES ('admin','1',1,'Goot Delivery','','','','<!doctype html>\n<html class=\"fixed\">\n	<head>\n\n		<!-- Basic -->\n		<meta charset=\"UTF-8\">\n\n		<title>Goot Admin Panal</title>\n        <meta name=\"keywords\" content=\"HTML5 Admin Template\" />\n		<meta name=\"description\" content=\"Porto Admin - Responsive HTML5 Template\">\n		<meta name=\"author\" content=\"okler.net\">\n\n		<!-- Mobile Metas -->\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\n\n		<!-- Web Fonts  -->\n		<link href=\"http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light\" rel=\"stylesheet\" type=\"text/css\">\n\n		<!-- Vendor CSS -->\n		<link rel=\"stylesheet\" href=\"assets/vendor/bootstrap/css/bootstrap.css\" />\n		<link rel=\"stylesheet\" href=\"assets/vendor/font-awesome/css/font-awesome.css\" />\n		<link rel=\"stylesheet\" href=\"assets/vendor/magnific-popup/magnific-popup.css\" />\n		<link rel=\"stylesheet\" href=\"assets/vendor/bootstrap-datepicker/css/datepicker3.css\" />\n\n		<!-- Theme CSS -->\n		<link rel=\"stylesheet\" href=\"assets/stylesheets/theme.css\" />\n\n		<!-- Skin CSS -->\n		<link rel=\"stylesheet\" href=\"assets/stylesheets/skins/default.css\" />\n\n		<!-- Theme Custom CSS -->\n		<link rel=\"stylesheet\" href=\"assets/stylesheets/theme-custom.css\">\n\n		<!-- Head Libs -->\n		<script src=\"assets/vendor/modernizr/modernizr.js\"></script>\n       <link rel=\"shortcut icon\" href=\"assets/images/logo.png\" />\n       <script src=\"assets/vendor/modernizr/modernizr.js\"></script>\n\n\n	</head>\n	<body>\n		<section class=\"body\">\n\n			<!-- start: header -->\n			<header class=\"header\">\n				<div class=\"logo-container\">\n					<a href=\"index.php\" class=\"logo\">\n						<img src=\"assets/images/logo.png\" height=\"35\" alt=\"Porto Admin\" />\n					</a>\n					<div class=\"visible-xs toggle-sidebar-left\" data-toggle-class=\"sidebar-left-opened\" data-target=\"html\" data-fire-event=\"sidebar-left-opened\">\n						<i class=\"fa fa-bars\" aria-label=\"Toggle sidebar\"></i>\n					</div>\n				</div>\n\n				<!-- start: search & user box -->\n				<div class=\"header-right\">\n\n\n				   <span class=\"separator\"></span>\n\n					<div id=\"userbox\" class=\"userbox\">\n						<a href=\"#\" data-toggle=\"dropdown\">\n							<figure class=\"profile-picture\">\n								<img src=\"assets/images/defult_photo.jpg\" alt=\"Joseph Doe\" class=\"img-circle\" data-lock-picture=\"assets/images/!logged-user.jpg\" width=\"25\" height=\"36\" />\n							</figure>\n							<div class=\"profile-info\" data-lock-name=\"John Doe\" data-lock-email=\"johndoe@okler.com\">\n								<span class=\"name\">Admin</span>\n								<span class=\"role\">administrator</span>\n							</div>\n\n							<i class=\"fa custom-caret\"></i>\n						</a>\n\n						<div class=\"dropdown-menu\">\n							<ul class=\"list-unstyled\">\n								<li class=\"divider\"></li>\n								<li>\n									<a role=\"menuitem\" tabindex=\"-1\" href=\"#\"><i class=\"fa fa-user\"></i> My Profile</a>\n								</li>\n								<li>\n									<a role=\"menuitem\" tabindex=\"-1\" href=\"#\" data-lock-screen=\"true\"><i class=\"fa fa-lock\"></i> Lock Screen</a>\n								</li>\n								<li>\n									<a role=\"menuitem\" tabindex=\"-1\" href=\"logout.php\"><i class=\"fa fa-power-off\"></i> Logout</a>\n								</li>\n							</ul>\n						</div>\n					</div>\n				</div>\n				<!-- end: search & user box -->\n			</header>\n			<!-- end: header -->\n\n			<div class=\"inner-wrapper\">\n				<!-- start: sidebar -->\n				<aside id=\"sidebar-left\" class=\"sidebar-left\">\n\n					<div class=\"sidebar-header\">\n						<div class=\"sidebar-title\">\n							<span style=\"color: #ABB4BE\"><b>Navigation</b></span>\n						</div>\n						<div class=\"sidebar-toggle hidden-xs\" data-toggle-class=\"sidebar-left-collapsed\" data-target=\"html\" data-fire-event=\"sidebar-left-toggle\">\n							<i class=\"fa fa-bars\" aria-label=\"Toggle sidebar\"></i>\n						</div>\n					</div>\n\n					<div class=\"nano\">\n						<div class=\"nano-content\">\n							<nav id=\"menu\" class=\"nav-main\" role=\"navigation\">\n								<ul class=\"nav nav-main\">\n									<li>\n										<a href=\"index.php\">\n											<i class=\"fa fa-home\" aria-hidden=\"true\"></i>\n											<span>Home</span>\n										</a>\n									</li>\n								<!--	<li>\n										<a href=\"mailbox-folder.html\">\n											<span class=\"pull-right label label-primary\">182</span>\n											<i class=\"fa fa-envelope\" aria-hidden=\"true\"></i>\n											<span>Mailbox</span>\n										</a>\n									</li>\n							-->\n                                    <li>\n										<a href=\"form_reg.php\">\n\n											<i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>\n											<span>Registration Form</span>\n										</a>\n									</li>\n                                     <li>\n										<a href=\"cat.php\">\n\n											<i class=\"fa fa-copy\" aria-hidden=\"true\"></i>\n											<span>Main Category</span>\n										</a>\n									</li>\n                                    <li>\n										<a href=\"cat_width.php\">\n\n											<i class=\"fa fa-cubes\" aria-hidden=\"true\"></i>\n											<span>Main Category Width</span>\n										</a>\n									</li>\n\n                                    <li class=\"nav-parent nav-expanded\">\n										<a>\n											<i class=\"fa  fa-list-alt\" aria-hidden=\"true\"></i>\n											<span>App Customer</span>\n										</a>\n										<ul class=\"nav nav-children\">\n						  					<li>\n												<a href=\"customer_kh.php\">\n													Khartoum\n												</a>\n											</li>\n						  					<li>\n												<a href=\"customer_om.php\">\n													Omdrman\n												</a>\n											</li>\n						  					<li>\n												<a href=\"customer_bh.php\">\n													Bahry\n												</a>\n											</li>\n										</ul>\n									</li>\n                                     	<li class=\"nav-parent nav-expanded\">\n										<a>\n											<i class=\"fa  fa-shopping-cart\" aria-hidden=\"true\"></i>\n											<span>Reports</span>\n										</a>\n										<ul class=\"nav nav-children\">\n						  					<li>\n												<a href=\"report_cat.php\">\n													Category\n												</a>\n											</li>\n						  				   \n						  					<li>\n												<a href=\"report_customer.php\">\n													Customers\n												</a>\n											</li>\n										</ul>\n									</li>\n								</ul>\n							</nav>\n						</div>\n\n					</div>\n\n				</aside>\n				<!-- end: sidebar -->\n','			</div>\n\n\n		</section>\n\n		<!-- Vendor -->\n		<script src=\"assets/vendor/jquery/jquery.js\"></script>\n		<script src=\"assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js\"></script>\n		<script src=\"assets/vendor/bootstrap/js/bootstrap.js\"></script>\n		<script src=\"assets/vendor/nanoscroller/nanoscroller.js\"></script>\n		<script src=\"assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js\"></script>\n		<script src=\"assets/vendor/magnific-popup/magnific-popup.js\"></script>\n		<script src=\"assets/vendor/jquery-placeholder/jquery.placeholder.js\"></script>\n\n		<!-- Theme Base, Components and Settings -->\n		<script src=\"assets/javascripts/theme.js\"></script>\n\n		<!-- Theme Custom -->\n		<script src=\"assets/javascripts/theme.custom.js\"></script>\n\n		<!-- Theme Initialization Files -->\n		<script src=\"assets/javascripts/theme.init.js\"></script>\n        	<script src=\"assets/vendor/pnotify/pnotify.custom.js\"></script>\n\n\n		<!-- Examples -->\n		<script src=\"assets/javascripts/ui-elements/examples.modals.js\"></script>\n	</body>\n</html>',' 	<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-automobile\"></i> fa-automobile <span class=\"text-muted\">(alias)</span></a></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bank\"></i> fa-bank <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-behance\"></i> fa-behance</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-behance-square\"></i> fa-behance-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bomb\"></i> fa-bomb</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-building\"></i> fa-building</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cab\"></i> fa-cab <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-car\"></i> fa-car</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-child\"></i> fa-child</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-o-notch\"></i> fa-circle-o-notch</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-thin\"></i> fa-circle-thin</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-codepen\"></i> fa-codepen</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cube\"></i> fa-cube</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cubes\"></i> fa-cubes</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-database\"></i> fa-database</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-delicious\"></i> fa-delicious</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-deviantart\"></i> fa-deviantart</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-digg\"></i> fa-digg</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-drupal\"></i> fa-drupal</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-empire\"></i> fa-empire</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-envelope-square\"></i> fa-envelope-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-fax\"></i> fa-fax</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-archive-o\"></i> fa-file-archive-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-audio-o\"></i> fa-file-audio-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-code-o\"></i> fa-file-code-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-excel-o\"></i> fa-file-excel-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-image-o\"></i> fa-file-image-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-movie-o\"></i> fa-file-movie-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-pdf-o\"></i> fa-file-pdf-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-photo-o\"></i> fa-file-photo-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-picture-o\"></i> fa-file-picture-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-powerpoint-o\"></i> fa-file-powerpoint-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-sound-o\"></i> fa-file-sound-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-video-o\"></i> fa-file-video-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-word-o\"></i> fa-file-word-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-zip-o\"></i> fa-file-zip-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ge\"></i> fa-ge <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-git\"></i> fa-git</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-git-square\"></i> fa-git-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-google\"></i> fa-google</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-graduation-cap\"></i> fa-graduation-cap</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-hacker-news\"></i> fa-hacker-news</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-header\"></i> fa-header</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-history\"></i> fa-history</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-institution\"></i> fa-institution <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-joomla\"></i> fa-joomla</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-jsfiddle\"></i> fa-jsfiddle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-language\"></i> fa-language</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-bouy\"></i> fa-life-bouy <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-ring\"></i> fa-life-ring</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-saver\"></i> fa-life-saver <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mortar-board\"></i> fa-mortar-board <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-openid\"></i> fa-openid</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paper-plane\"></i> fa-paper-plane</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paper-plane-o\"></i> fa-paper-plane-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paragraph\"></i> fa-paragraph</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paw\"></i> fa-paw</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pied-piper\"></i> fa-pied-piper</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pied-piper-alt\"></i> fa-pied-piper-alt</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pied-piper-square\"></i> fa-pied-piper-square <span class=\"text-muted\">(alias)</s</a></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-qq\"></i> fa-qq</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ra\"></i> fa-ra <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rebel\"></i> fa-rebel</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-recycle\"></i> fa-recycle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-reddit\"></i> fa-reddit</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-reddit-square\"></i> fa-reddit-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-send\"></i> fa-send <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-send-o\"></i> fa-send-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-alt\"></i> fa-share-alt</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-alt-square\"></i> fa-share-alt-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-slack\"></i> fa-slack</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sliders\"></i> fa-sliders</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-soundcloud\"></i> fa-soundcloud</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-space-shuttle\"></i> fa-space-shuttle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-spoon\"></i> fa-spoon</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-spotify\"></i> fa-spotify</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-steam\"></i> fa-steam</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-steam-square\"></i> fa-steam-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-stumbleupon\"></i> fa-stumbleupon</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-stumbleupon-circle\"></i> fa-stumbleupon-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-support\"></i> fa-support <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-taxi\"></i> fa-taxi</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tencent-weibo\"></i> fa-tencent-weibo</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tree\"></i> fa-tree</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-university\"></i> fa-university</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-vine\"></i> fa-vine</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-wechat\"></i> fa-wechat <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-weixin\"></i> fa-weixin</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-wordpress\"></i> fa-wordpress</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-yahoo\"></i> fa-yahoo</div>\r\n                          	<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-adjust\"></i> fa-adjust</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-anchor\"></i> fa-anchor</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-archive\"></i> fa-archive</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-arrows\"></i> fa-arrows</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-arrows-h\"></i> fa-arrows-h</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-arrows-v\"></i> fa-arrows-v</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-asterisk\"></i> fa-asterisk</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-automobile\"></i> fa-automobile <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ban\"></i> fa-ban</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bank\"></i> fa-bank <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bar-chart-o\"></i> fa-bar-chart-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-barcode\"></i> fa-barcode</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bars\"></i> fa-bars</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-beer\"></i> fa-beer</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bell\"></i> fa-bell</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bell-o\"></i> fa-bell-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bolt\"></i> fa-bolt</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bomb\"></i> fa-bomb</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-book\"></i> fa-book</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bookmark\"></i> fa-bookmark</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bookmark-o\"></i> fa-bookmark-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-briefcase\"></i> fa-briefcase</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bug\"></i> fa-bug</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-building\"></i> fa-building</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-building-o\"></i> fa-building-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bullhorn\"></i> fa-bullhorn</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bullseye\"></i> fa-bullseye</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cab\"></i> fa-cab <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-calendar\"></i> fa-calendar</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-calendar-o\"></i> fa-calendar-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-camera\"></i> fa-camera</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-camera-retro\"></i> fa-camera-retro</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-car\"></i> fa-car</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-caret-square-o-down\"></i> fa-caret-square-o-down</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-caret-square-o-left\"></i> fa-caret-square-o-left</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-caret-square-o-right\"></i> fa-caret-square-o-right</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-caret-square-o-up\"></i> fa-caret-square-o-up</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-certificate\"></i> fa-certificate</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check\"></i> fa-check</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-circle\"></i> fa-check-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-circle-o\"></i> fa-check-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-square\"></i> fa-check-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-square-o\"></i> fa-check-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-child\"></i> fa-child</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle\"></i> fa-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-o\"></i> fa-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-o-notch\"></i> fa-circle-o-notch</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-thin\"></i> fa-circle-thin</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-clock-o\"></i> fa-clock-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cloud\"></i> fa-cloud</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cloud-download\"></i> fa-cloud-download</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cloud-upload\"></i> fa-cloud-upload</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-code\"></i> fa-code</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-code-fork\"></i> fa-code-fork</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-coffee\"></i> fa-coffee</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cog\"></i> fa-cog</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cogs\"></i> fa-cogs</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-comment\"></i> fa-comment</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-comment-o\"></i> fa-comment-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-comments\"></i> fa-comments</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-comments-o\"></i> fa-comments-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-compass\"></i> fa-compass</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-credit-card\"></i> fa-credit-card</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-crop\"></i> fa-crop</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-crosshairs\"></i> fa-crosshairs</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cube\"></i> fa-cube</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cubes\"></i> fa-cubes</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cutlery\"></i> fa-cutlery</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-dashboard\"></i> fa-dashboard <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-database\"></i> fa-database</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-desktop\"></i> fa-desktop</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-dot-circle-o\"></i> fa-dot-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-download\"></i> fa-download</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-edit\"></i> fa-edit <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ellipsis-h\"></i> fa-ellipsis-h</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ellipsis-v\"></i> fa-ellipsis-v</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-envelope\"></i> fa-envelope</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-envelope-o\"></i> fa-envelope-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-envelope-square\"></i> fa-envelope-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-eraser\"></i> fa-eraser</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-exchange\"></i> fa-exchange</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-exclamation\"></i> fa-exclamation</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-exclamation-circle\"></i> fa-exclamation-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-exclamation-triangle\"></i> fa-exclamation-triangle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-external-link\"></i> fa-external-link</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-external-link-square\"></i> fa-external-link-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-eye\"></i> fa-eye</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-eye-slash\"></i> fa-eye-slash</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-fax\"></i> fa-fax</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-female\"></i> fa-female</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-fighter-jet\"></i> fa-fighter-jet</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-archive-o\"></i> fa-file-archive-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-audio-o\"></i> fa-file-audio-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-code-o\"></i> fa-file-code-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-excel-o\"></i> fa-file-excel-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-image-o\"></i> fa-file-image-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-movie-o\"></i> fa-file-movie-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-pdf-o\"></i> fa-file-pdf-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-photo-o\"></i> fa-file-photo-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-picture-o\"></i> fa-file-picture-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-powerpoint-o\"></i> fa-file-powerpoint-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-sound-o\"></i> fa-file-sound-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-video-o\"></i> fa-file-video-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-word-o\"></i> fa-file-word-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-file-zip-o\"></i> fa-file-zip-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-film\"></i> fa-film</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-filter\"></i> fa-filter</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-fire\"></i> fa-fire</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-fire-extinguisher\"></i> fa-fire-extinguisher</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-flag\"></i> fa-flag</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-flag-checkered\"></i> fa-flag-checkered</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-flag-o\"></i> fa-flag-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-flash\"></i> fa-flash <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-flask\"></i> fa-flask</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-folder\"></i> fa-folder</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-folder-o\"></i> fa-folder-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-folder-open\"></i> fa-folder-open</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-folder-open-o\"></i> fa-folder-open-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-frown-o\"></i> fa-frown-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gamepad\"></i> fa-gamepad</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gavel\"></i> fa-gavel</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gear\"></i> fa-gear <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gears\"></i> fa-gears <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gift\"></i> fa-gift</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-glass\"></i> fa-glass</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-globe\"></i> fa-globe</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-graduation-cap\"></i> fa-graduation-cap</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-group\"></i> fa-group <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-hdd-o\"></i> fa-hdd-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-headphones\"></i> fa-headphones</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-heart\"></i> fa-heart</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-heart-o\"></i> fa-heart-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-history\"></i> fa-history</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-home\"></i> fa-home</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-image\"></i> fa-image <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-inbox\"></i> fa-inbox</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-info\"></i> fa-info</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-info-circle\"></i> fa-info-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-institution\"></i> fa-institution <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-key\"></i> fa-key</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-keyboard-o\"></i> fa-keyboard-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-language\"></i> fa-language</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-laptop\"></i> fa-laptop</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-leaf\"></i> fa-leaf</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-legal\"></i> fa-legal <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-lemon-o\"></i> fa-lemon-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-level-down\"></i> fa-level-down</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-level-up\"></i> fa-level-up</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-bouy\"></i> fa-life-bouy <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-ring\"></i> fa-life-ring</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-life-saver\"></i> fa-life-saver <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-lightbulb-o\"></i> fa-lightbulb-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-location-arrow\"></i> fa-location-arrow</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-lock\"></i> fa-lock</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-magic\"></i> fa-magic</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-magnet\"></i> fa-magnet</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mail-forward\"></i> fa-mail-forward <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mail-reply\"></i> fa-mail-reply <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mail-reply-all\"></i> fa-mail-reply-all <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-male\"></i> fa-male</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-map-marker\"></i> fa-map-marker</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-meh-o\"></i> fa-meh-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-microphone\"></i> fa-microphone</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-microphone-slash\"></i> fa-microphone-slash</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus\"></i> fa-minus</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus-circle\"></i> fa-minus-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus-square\"></i> fa-minus-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus-square-o\"></i> fa-minus-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mobile\"></i> fa-mobile</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mobile-phone\"></i> fa-mobile-phone <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-money\"></i> fa-money</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-moon-o\"></i> fa-moon-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-mortar-board\"></i> fa-mortar-board <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-music\"></i> fa-music</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-navicon\"></i> fa-navicon <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paper-plane\"></i> fa-paper-plane</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paper-plane-o\"></i> fa-paper-plane-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-paw\"></i> fa-paw</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pencil\"></i> fa-pencil</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pencil-square\"></i> fa-pencil-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-pencil-square-o\"></i> fa-pencil-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-phone\"></i> fa-phone</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-phone-square\"></i> fa-phone-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-photo\"></i> fa-photo <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-picture-o\"></i> fa-picture-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plane\"></i> fa-plane</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus\"></i> fa-plus</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus-circle\"></i> fa-plus-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus-square\"></i> fa-plus-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus-square-o\"></i> fa-plus-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-power-off\"></i> fa-power-off</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-print\"></i> fa-print</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-puzzle-piece\"></i> fa-puzzle-piece</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-qrcode\"></i> fa-qrcode</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-question\"></i> fa-question</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-question-circle\"></i> fa-question-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-quote-left\"></i> fa-quote-left</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-quote-right\"></i> fa-quote-right</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-random\"></i> fa-random</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-recycle\"></i> fa-recycle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-refresh\"></i> fa-refresh</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-reorder\"></i> fa-reorder <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-reply\"></i> fa-reply</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-reply-all\"></i> fa-reply-all</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-retweet\"></i> fa-retweet</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-road\"></i> fa-road</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rocket\"></i> fa-rocket</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rss\"></i> fa-rss</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rss-square\"></i> fa-rss-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-search\"></i> fa-search</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-search-minus\"></i> fa-search-minus</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-search-plus\"></i> fa-search-plus</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-send\"></i> fa-send <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-send-o\"></i> fa-send-o <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share\"></i> fa-share</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-alt\"></i> fa-share-alt</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-alt-square\"></i> fa-share-alt-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-square\"></i> fa-share-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-share-square-o\"></i> fa-share-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-shield\"></i> fa-shield</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-shopping-cart\"></i> fa-shopping-cart</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sign-in\"></i> fa-sign-in</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sign-out\"></i> fa-sign-out</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-signal\"></i> fa-signal</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sitemap\"></i> fa-sitemap</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sliders\"></i> fa-sliders</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-smile-o\"></i> fa-smile-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort\"></i> fa-sort</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-alpha-asc\"></i> fa-sort-alpha-asc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-alpha-desc\"></i> fa-sort-alpha-desc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-amount-asc\"></i> fa-sort-amount-asc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-amount-desc\"></i> fa-sort-amount-desc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-asc\"></i> fa-sort-asc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-desc\"></i> fa-sort-desc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-down\"></i> fa-sort-down <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-numeric-asc\"></i> fa-sort-numeric-asc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-numeric-desc\"></i> fa-sort-numeric-desc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sort-up\"></i> fa-sort-up <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-space-shuttle\"></i> fa-space-shuttle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-spinner\"></i> fa-spinner</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-spoon\"></i> fa-spoon</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-square\"></i> fa-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-square-o\"></i> fa-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star\"></i> fa-star</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star-half\"></i> fa-star-half</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star-half-empty\"></i> fa-star-half-empty <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star-half-full\"></i> fa-star-half-full <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star-half-o\"></i> fa-star-half-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-star-o\"></i> fa-star-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-suitcase\"></i> fa-suitcase</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-sun-o\"></i> fa-sun-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-support\"></i> fa-support <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tablet\"></i> fa-tablet</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tachometer\"></i> fa-tachometer</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tag\"></i> fa-tag</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tags\"></i> fa-tags</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tasks\"></i> fa-tasks</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-taxi\"></i> fa-taxi</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-terminal\"></i> fa-terminal</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-thumb-tack\"></i> fa-thumb-tack</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-thumbs-down\"></i> fa-thumbs-down</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-thumbs-o-down\"></i> fa-thumbs-o-down</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-thumbs-o-up\"></i> fa-thumbs-o-up</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-thumbs-up\"></i> fa-thumbs-up</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ticket\"></i> fa-ticket</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-times\"></i> fa-times</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-times-circle\"></i> fa-times-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-times-circle-o\"></i> fa-times-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tint\"></i> fa-tint</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-toggle-down\"></i> fa-toggle-down <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-toggle-left\"></i> fa-toggle-left <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-toggle-right\"></i> fa-toggle-right <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-toggle-up\"></i> fa-toggle-up <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-trash-o\"></i> fa-trash-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-tree\"></i> fa-tree</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-trophy\"></i> fa-trophy</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-truck\"></i> fa-truck</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-umbrella\"></i> fa-umbrella</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-university\"></i> fa-university</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-unlock\"></i> fa-unlock</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-unlock-alt\"></i> fa-unlock-alt</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-unsorted\"></i> fa-unsorted <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-upload\"></i> fa-upload</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-user\"></i> fa-user</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-users\"></i> fa-users</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-video-camera\"></i> fa-video-camera</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-volume-down\"></i> fa-volume-down</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-volume-off\"></i> fa-volume-off</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-volume-up\"></i> fa-volume-up</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-warning\"></i> fa-warning <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-wheelchair\"></i> fa-wheelchair</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-wrench\"></i> fa-wrench</div>\r\n                            <div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-square\"></i> fa-check-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-check-square-o\"></i> fa-check-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle\"></i> fa-circle</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-circle-o\"></i> fa-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-dot-circle-o\"></i> fa-dot-circle-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus-square\"></i> fa-minus-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-minus-square-o\"></i> fa-minus-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus-square\"></i> fa-plus-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-plus-square-o\"></i> fa-plus-square-o</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-square\"></i> fa-square</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-square-o\"></i> fa-square-o</div>\r\n                  			<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-bitcoin\"></i> fa-bitcoin <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-btc\"></i> fa-btc</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-cny\"></i> fa-cny <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-dollar\"></i> fa-dollar <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-eur\"></i> fa-eur</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-euro\"></i> fa-euro <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-gbp\"></i> fa-gbp</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-inr\"></i> fa-inr</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-jpy\"></i> fa-jpy</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-krw\"></i> fa-krw</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-money\"></i> fa-money</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rmb\"></i> fa-rmb <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rouble\"></i> fa-rouble <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rub\"></i> fa-rub</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-ruble\"></i> fa-ruble <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-rupee\"></i> fa-rupee <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-try\"></i> fa-try</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-turkish-lira\"></i> fa-turkish-lira <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-usd\"></i> fa-usd</div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-won\"></i> fa-won <span class=\"text-muted\">(alias)</span></div>\r\n							<div class=\"fa-hover mb-sm mt-sm col-md-6 col-lg-4 col-xl-3\"><i class=\"fa fa-yen\"></i> fa-yen <span class=\"text-muted\">(alias)</span></div>\r\n','');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_linecolor`
--

DROP TABLE IF EXISTS `setting_linecolor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting_linecolor` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `table` varchar(255) NOT NULL,
  `tb_value` varchar(150) NOT NULL,
  `csscolor` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_linecolor`
--

LOCK TABLES `setting_linecolor` WRITE;
/*!40000 ALTER TABLE `setting_linecolor` DISABLE KEYS */;
/*!40000 ALTER TABLE `setting_linecolor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `s_insertby` varchar(25) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `isadmin` int(5) NOT NULL,
  `notificition` int(5) NOT NULL,
  `change_password` varchar(50) NOT NULL,
  `dbgroups` varchar(9999) NOT NULL,
  `showall` int(5) NOT NULL,
  `emp_name` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=345 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin',1,1,'1','-1',1,'admin','0500385025');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'new_autopmo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-10 14:00:59
