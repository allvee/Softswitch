/*
SQLyog Enterprise - MySQL GUI v8.14 
MySQL - 5.5.19 : Database - webframework_release_1.0
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`webframework_release_1.0` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `webframework_release_1.0`;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `content` */

/*Table structure for table `layout` */

DROP TABLE IF EXISTS `layout`;

CREATE TABLE `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `auth_menu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `layout` */

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`address`,`phone`,`username`,`password`,`permissions`,`created`) values (3,'mazhar','SSD_TECT','01912186160','mazhar@ssd.com','1','{\"category\":{\"add\":true,\"edit\":true,\"approve\":true,\"delete\":true},\"contents\":{\"add\":true,\"edit\":true,\"approve\":true,\"delete\":true},\"users\":{\"add\":true,\"edit\":true,\"delete\":true}}','2014-09-30 18:50:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
