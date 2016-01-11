/*
SQLyog Enterprise - MySQL GUI v8.14 
MySQL - 5.5.19 : Database - smsdozecms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `tbid` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `parent` varchar(500) DEFAULT NULL,
  `iconURL` varchar(500) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `thumbURL` varchar(500) DEFAULT NULL,
  `titleBanner` varchar(500) DEFAULT NULL,
  `titleThumb` varchar(500) DEFAULT NULL,
  `catBanner` varchar(500) DEFAULT NULL,
  `contentListLayoutName` varchar(200) DEFAULT NULL,
  `contentListLayout` text,
  `contentListTarget` varchar(500) DEFAULT NULL,
  `catListTarget` varchar(500) DEFAULT NULL,
  `catListLayoutName` varchar(200) DEFAULT NULL,
  `catListLayout` text,
  `catLayoutName` varchar(200) DEFAULT NULL,
  `catLayout` text,
  `rowSep` text,
  `columnNo` int(11) DEFAULT NULL,
  `isHighlited` enum('YES','NO') DEFAULT NULL,
  `highlightedLayoutName` varchar(500) DEFAULT NULL,
  `highlightedLayout` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tbid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`tbid`,`id`,`name`,`parent`,`iconURL`,`title`,`thumbURL`,`titleBanner`,`titleThumb`,`catBanner`,`contentListLayoutName`,`contentListLayout`,`contentListTarget`,`catListTarget`,`catListLayoutName`,`catListLayout`,`catLayoutName`,`catLayout`,`rowSep`,`columnNo`,`isHighlited`,`highlightedLayoutName`,`highlightedLayout`,`status`,`date`) values (1,'1','Login_Form','0',NULL,'Login Form',NULL,NULL,'img/141540FireShot_Screen_Capture_#003_-_\'SMS_Doze\'_-_sms_doze_my_index_php_FORM=forms_frmProfileUpdate_php.png',NULL,'#contentListLayout','<div id=\"contentListLayout\"><div id=\"cmsContent_details\"></div></div>','#contentList','#catList','#catListLayout','<div id=\"catListLayout\"><div class=\"hbox topic\"><div class=\"dd\"></div></div></div>','#catLaout','<div id=\"catLayout\"><div id=\"catList\"></div><div id=\"contentList\"><div/></div>','',0,NULL,NULL,NULL,1,'2014-10-02 16:01:19'),(2,'2','welcome','0',NULL,'welcome',NULL,NULL,NULL,NULL,'#contentListLayout','<div id=\"contentListLayout\"><div id=\"cmsContent_details\"></div></div>','#contentList','#catList','#catListLayout',NULL,NULL,'<div id=\"catLayout\"><div id=\"catList\"></div><div id=\"contentList\"><div/></div>',NULL,0,NULL,NULL,NULL,1,'2014-10-02 18:36:30');

/*Table structure for table `content` */

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `catid` varchar(500) NOT NULL,
  `userId` int(11) NOT NULL DEFAULT '0',
  `title` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `details` text CHARACTER SET utf8,
  `formData` text NOT NULL,
  `type` varchar(500) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `tag` varchar(500) DEFAULT NULL,
  `rowSep` text,
  `columnNo` int(11) DEFAULT NULL,
  `isHighlited` enum('YES','NO') DEFAULT NULL,
  `highlightedLayoutName` varchar(500) DEFAULT NULL,
  `highlightedLayout` varchar(500) DEFAULT NULL,
  `allow_comment` int(2) NOT NULL,
  `allow_like` int(2) NOT NULL,
  `status` int(11) DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `content` */

insert  into `content`(`cid`,`id`,`catid`,`userId`,`title`,`details`,`formData`,`type`,`url`,`tag`,`rowSep`,`columnNo`,`isHighlited`,`highlightedLayoutName`,`highlightedLayout`,`allow_comment`,`allow_like`,`status`,`date`) values (1,1,'1',0,'Auth Login','<form class=\"loginForm\" onSubmit=\"loginController(\'#cmsData\',\'loginForm\'); return false;\">\r\n<input type=\"text\" name=\"username\" value=\"\"/>\r\n<input type=\"password\" name=\"password\" value=\"\"/>\r\n<button type=\"submit\">submit</button>\r\n</ form>','','TEXT',NULL,NULL,'',0,NULL,NULL,NULL,0,0,1,'2014-10-02 18:22:34'),(2,2,'2',0,'hellow world','hellow wold','','TEXT',NULL,NULL,'',0,NULL,NULL,NULL,0,0,1,'2014-10-02 19:26:36');

/*Table structure for table `layout` */

DROP TABLE IF EXISTS `layout`;

CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `auth_menu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `layout` */

insert  into `layout`(`id`,`header`,`footer`,`auth_menu`) values (1,'<div style=\'color: red; background-color: blue;\'>head</div>','<div style=\'color: green; background-color: yellow;\'>foot</div>','<div style=\'color: red\'>menubar</div>');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_actions` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`module_name`,`module_actions`) values (1,'category','add,edit,approve,delete'),(2,'contents','add,edit,approve,delete'),(3,'users','add,edit,delete');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `address` varchar(350) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `permissions` varchar(300) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`address`,`phone`,`username`,`password`,`permissions`,`created`) values (1,'Talemul Islam','Dhaka','8801937517989','talemul@ssdtech.com','1','{\"category\":{\"add\":true,\"edit\":true,\"approve\":true,\"delete\":true},\"contents\":{\"add\":true,\"edit\":true,\"approve\":true,\"delete\":true},\"users\":{\"add\":true,\"edit\":true,\"delete\":true}}','2014-10-02 12:32:20');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
