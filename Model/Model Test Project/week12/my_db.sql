# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 10.1.9-MariaDB)
# Database: my_db
# Generation Time: 2016-05-08 16:02:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章 id',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '標題',
  `category` varchar(50) NOT NULL DEFAULT '' COMMENT '分類',
  `content` text NOT NULL COMMENT '內文',
  `publish` tinyint(1) NOT NULL COMMENT '是否發布',
  `create_date` datetime NOT NULL COMMENT '建立日期',
  `modify_date` datetime DEFAULT NULL COMMENT '修改日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '使用者id',
  `username` varchar(30) NOT NULL COMMENT '登⼊帳號',
  `password` varchar(100) NOT NULL COMMENT '使用者密碼',
  `name` varchar(30) NOT NULL COMMENT '名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `password`, `name`)
VALUES
	(1,'mktsai','asdkljfioej','阿洋'),
	(2,'albee','ajsdfijlk','阿喵');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table works
# ------------------------------------------------------------

DROP TABLE IF EXISTS `works`;

CREATE TABLE `works` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '作品 id',
  `intro` text NOT NULL COMMENT '簡介',
  `image_path` varchar(255) DEFAULT NULL COMMENT '圖⽚路徑',
  `video_path` varchar(255) DEFAULT NULL COMMENT '影⽚路徑',
  `publish` tinyint(1) NOT NULL COMMENT '是否發布',
  `upload_date` datetime NOT NULL COMMENT '上傳時間',
  `create_user_id` int(11) NOT NULL COMMENT '誰上傳的(建⽴立者id)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;

INSERT INTO `works` (`id`, `intro`, `image_path`, `video_path`, `publish`, `upload_date`, `create_user_id`)
VALUES
	(1,'我的第一次','files/images/20150514002349.jpg',NULL,1,'2015-05-12 03:10:21',1),
	(2,'我的影片作品01',NULL,'files/video/laughing.mp4',1,'2015-05-13 06:10:21',1),
	(3,'我家的小黑','files/images/20150514021023.jpg',NULL,1,'2015-05-14 13:10:21',1);

/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
