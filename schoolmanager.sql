-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour schoolmanager
CREATE DATABASE IF NOT EXISTS `schoolmanager` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `schoolmanager`;

-- Listage de la structure de table schoolmanager. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.category : ~7 rows (environ)
INSERT INTO `category` (`id`, `label`) VALUES
	(1, 'Développement Web'),
	(2, 'Communication'),
	(3, 'Bureautique'),
	(4, 'Oraux'),
	(5, 'Projet'),
	(6, 'Démarche'),
	(7, 'Design');

-- Listage de la structure de table schoolmanager. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table schoolmanager.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230721122018', '2023-07-21 12:20:45', 408);

-- Listage de la structure de table schoolmanager. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.formation : ~3 rows (environ)
INSERT INTO `formation` (`id`, `label`, `description`) VALUES
	(1, 'Développeur Web Web Mobile', 'Apprendre les langage de développement web'),
	(2, 'Concepteur d\'application', 'Développement web avancé avec l\'utilisation de framework'),
	(3, 'Secrétaire', 'Gestion administrative');

-- Listage de la structure de table schoolmanager. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table schoolmanager. program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `duration` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784613FECDF` (`session_id`),
  KEY `IDX_92ED778423EDC87` (`subject_id`),
  CONSTRAINT `FK_92ED778423EDC87` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`),
  CONSTRAINT `FK_92ED7784613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.program : ~11 rows (environ)
INSERT INTO `program` (`id`, `session_id`, `subject_id`, `duration`) VALUES
	(1, 1, 9, 5),
	(2, 1, 10, 15),
	(3, 1, 1, 10),
	(4, 1, 11, 1),
	(6, 2, 2, 2),
	(7, 2, 9, 7),
	(8, 2, 8, 1),
	(9, 2, 4, 2),
	(10, 1, 4, 2),
	(11, 1, 5, 3),
	(12, 2, 6, 2);

-- Listage de la structure de table schoolmanager. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation_id` int NOT NULL,
  `label` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `datebegin` date NOT NULL,
  `dateend` date NOT NULL,
  `capacity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `formation_id`, `label`, `datebegin`, `dateend`, `capacity`) VALUES
	(1, 1, 'Dev. Web n°1', '2022-03-10', '2023-10-25', 15),
	(2, 1, 'Dev. Web n°2', '2023-02-25', '2023-12-25', 12);

-- Listage de la structure de table schoolmanager. student
CREATE TABLE IF NOT EXISTS `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date NOT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.student : ~5 rows (environ)
INSERT INTO `student` (`id`, `firstname`, `lastname`, `sex`, `birthdate`, `phone`, `email`, `city`) VALUES
	(1, 'Enzo', 'Ferrari', 'm', '1898-02-18', '0504706080', 'enzo.ferrari@gmail.com', 'Modena'),
	(2, 'Maxoms', 'Bertozi', 'm', '1998-10-21', '0504069080', 'maxoms68@hotmail.com', 'Colmar'),
	(3, 'Madinax', 'Citrolent', 'f', '1980-02-01', '0405060808', 'madinax@gmail.com', 'Colmar'),
	(4, 'Quentino', 'Despacito', 'm', '1995-11-28', '0604088932', 'quentin12@gmail.com', 'Saint Lous'),
	(5, 'Marie', 'Cyne', 'f', '2003-07-25', '06080409', 'marie.cyne@gmail.com', 'Paris');

-- Listage de la structure de table schoolmanager. student_session
CREATE TABLE IF NOT EXISTS `student_session` (
  `student_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`student_id`,`session_id`),
  KEY `IDX_3D72602CCB944F1A` (`student_id`),
  KEY `IDX_3D72602C613FECDF` (`session_id`),
  CONSTRAINT `FK_3D72602C613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3D72602CCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.student_session : ~0 rows (environ)

-- Listage de la structure de table schoolmanager. subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FBCE3E7A12469DE2` (`category_id`),
  CONSTRAINT `FK_FBCE3E7A12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table schoolmanager.subject : ~13 rows (environ)
INSERT INTO `subject` (`id`, `category_id`, `label`) VALUES
	(1, 1, 'PHP : les bases'),
	(2, 7, 'UX / UI : présentation'),
	(3, 2, 'Présentation orale'),
	(4, 6, 'Création de cv'),
	(5, 3, 'Word : les bases'),
	(6, 3, 'Exel : les bases'),
	(7, 5, 'Journée Projet'),
	(8, 6, 'Linkedin : initiation'),
	(9, 1, 'HTML CSS : Simpsons'),
	(10, 1, 'PHP : Les objets'),
	(11, 2, 'Expression orale'),
	(12, 7, 'Les bonnes pratiques'),
	(13, 5, 'Documentation de projet');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
