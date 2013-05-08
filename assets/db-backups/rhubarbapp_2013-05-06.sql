# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.25)
# Database: rhubarbapp
# Generation Time: 2013-05-07 03:26:04 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table laravel_migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `laravel_migrations`;

CREATE TABLE `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `laravel_migrations` WRITE;
/*!40000 ALTER TABLE `laravel_migrations` DISABLE KEYS */;

INSERT INTO `laravel_migrations` (`bundle`, `name`, `batch`)
VALUES
	('application','2013_04_23_010004_update_users_table_fields',1),
	('application','2013_04_23_012319_create_roles_table',2),
	('application','2013_05_04_121424_create_movies_table',2),
	('application','2013_05_04_142631_add_movie_id_to_movies',2),
	('application','2013_05_06_071329_add_image_thumb_and_image_small_thumb_to_users_table',3);

/*!40000 ALTER TABLE `laravel_migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movies`;

CREATE TABLE `movies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `year` datetime DEFAULT NULL,
  `genres` varchar(200) DEFAULT NULL,
  `release_theater` datetime DEFAULT NULL,
  `release_dvd` varchar(200) DEFAULT NULL,
  `synopsis` text,
  `cast` varchar(200) DEFAULT NULL,
  `critics_reviews` text,
  `watched` varchar(200) DEFAULT NULL,
  `tosee` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;

INSERT INTO `movies` (`id`, `title`, `year`, `genres`, `release_theater`, `release_dvd`, `synopsis`, `cast`, `critics_reviews`, `watched`, `tosee`, `user_id`, `created_at`, `updated_at`, `movie_id`)
VALUES
	(1,'Sightseers','0000-00-00 00:00:00',NULL,'2013-05-10 00:00:00','Not Given','Chris (Steve Oram) wants to show Tina (Alice Lowe) his world and he wants to do it his way - on a journey through the British Isles in his beloved Abbey Oxford Caravan. Tina\'s led a sheltered life and there are things that Chris needs her to see - the Crich Tramway Museum, the Ribblehead Viaduct, the Keswick Pencil Museum and the rolling countryside that separates these wonders in his life. But it doesn\'t take long for the dream to fade. Litterbugs, noisy teenagers and pre-booked caravan sites, not to mention Tina\'s meddling mother, soon conspire to shatter Chris\'s dreams and send him, and anyone who rubs him the wrong way, over a very jagged edge. (c) IFC Film',NULL,NULL,'YES','NO',1,'2013-05-06 06:57:33','2013-05-06 14:23:02',771307349);

/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `role_id` varchar(200) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `image_thumb` varchar(200) NOT NULL,
  `image_small_thumb` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `role_id`, `status`, `created_at`, `updated_at`, `image_thumb`, `image_small_thumb`)
VALUES
	(1,'Bryan','Sattler','bryansattler','$2a$08$5oV0jumENtU/4gXL5AjhjePonU00W/AOMoDUuqmPfEH.y5PYwXdGu','bsattler@gmail.com','0',0,'2013-04-23 01:08:34','2013-05-07 02:17:50','http://rhubarb.dev/pics/1_thumb.jpg','http://rhubarb.dev/pics/1_smallthumb.jpg'),
	(2,'Bryan','Sattler','fullsail','$2a$08$CwJT4Rvq3ow6gfHh//RR/u0qlQYrjQYbKXII5KlBJ0T.57qS7lhWC','bsattler@fullsail.edu','',0,'2013-05-07 02:07:48','2013-05-07 02:13:50','http://rhubarb.dev/pics/2_thumb.jpg','http://rhubarb.dev/pics/2_smallthumb.jpg');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
