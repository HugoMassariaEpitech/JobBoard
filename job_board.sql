-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: job_board
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `advertisements`
--

DROP TABLE IF EXISTS `advertisements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advertisements` (
  `id_advertisement` int NOT NULL AUTO_INCREMENT,
  `advertisement_name` text NOT NULL,
  `advertisement_company` text NOT NULL,
  `advertisement_location` text NOT NULL,
  `advertisement_type` text NOT NULL,
  `advertisement_description` text NOT NULL,
  `advertisement_details` json DEFAULT NULL,
  PRIMARY KEY (`id_advertisement`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertisements`
--

LOCK TABLES `advertisements` WRITE;
/*!40000 ALTER TABLE `advertisements` DISABLE KEYS */;
INSERT INTO `advertisements` VALUES (1,'Infirmier - Rouen (H/F)','1','Rouen (76)','Temps plein, CDI','Rejoindre SNCF.',NULL);
/*!40000 ALTER TABLE `advertisements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applies`
--

DROP TABLE IF EXISTS `applies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applies` (
  `id_apply` int NOT NULL AUTO_INCREMENT,
  `user_email` text NOT NULL,
  `id_advertisement` int NOT NULL,
  `user_phone` text NOT NULL,
  `user_firstname` text NOT NULL,
  `user_name` text NOT NULL,
  PRIMARY KEY (`id_apply`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applies`
--

LOCK TABLES `applies` WRITE;
/*!40000 ALTER TABLE `applies` DISABLE KEYS */;
INSERT INTO `applies` VALUES (1,'elies@test333.com',4,'0909090909','Elies','Elies'),(2,'elies@testapply.com',4,'0909080909','Elies','Test');
/*!40000 ALTER TABLE `applies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `user_name` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_email` text,
  `user_phone` text,
  `user_birthdate` date DEFAULT NULL,
  `user_civility` text,
  `user_password` text,
  `user_firstname` text,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Hugo Massaria',1,'hugo.massaria@google.com',NULL,NULL,NULL,'Hugo',NULL),(2,'Elies Hariate',1,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Hugo',0,'hugo.massaria@epitech.com',NULL,NULL,NULL,'$2y$10$B5p9nZw0ohMBKyenKNqh/OeSpsfz.pULhf6etRfxkJd6xuBIlsh5u',NULL),(4,'Hugo',0,'hugo.massaria@hotmail.com','0606060606','2006-06-20','Mr','$2y$10$n4V6j.O7ObKD3tR0qagCsOctFhBlUvBZtknFWwf/GwFe..LToGCDG','Hugo'),(5,'Hariate',0,'elies.hariate@epitech.eu','0606060606','2022-09-13','M.','$2y$10$Yd2acyx7Dq.u3IZdLeDis.U/hocLZHXe/pkLMjNKe31x5DeCX481e','Elies'),(15,'jjj',0,'test@test.com','jjjjj','2022-09-01','M.','$2y$10$M2vvnXMHWZNNwSb3PTvNtuEhfv.1eFjWliZ/mEKIrnUNIaPP5PSV6','jjj'),(16,'jjj',0,'test2@test.com','0234567891','2022-10-01','M.','$2y$10$dlNd7fJM0/xguy060QfKuOBqHuTwUs9WWOB4hjhyZBsANRDKloOEu','jjj'),(17,'jjj',0,'test@test2.com','0234567891','2022-10-01','M.','$2y$10$bJ7n8ocGrOjSG3PvyGC10.I/Drr2Bs8a6vcIXKRrLyMOq4Q4WIgVm','jjj'),(18,'hariate',0,'elies@test.com','0909090909','2002-02-09','M.','$2y$10$Y2V2t0GWZOmHyCWQJ27Q2u1SmAAJjmEP1AGRf9XDs15gtHNuUls1i','elies'),(19,'hariate',0,'elies@test2.com','0909090909','2002-02-09','M.','$2y$10$ggF33gZCZNHYYAI3BSEXtuTsgUbHp8iLLcCzu6aEBjZbm29UmBttO','elies'),(20,'Hariate',0,'elies@test3.com','0909090909','2002-09-22','M.','$2y$10$5ODPVgw0F8J26niqjRA1SuIHxufJhYRfyTnGHRrdIL7w0Ue2F2x0i','Elies'),(21,'Hariate',0,'elies@test4.com','0909090909','2002-08-29','M.','$2y$10$EUFf8uFIuepK/ffpT.gdaezONqhOVxySqZlzuUfOsPP4/JCqpkdjC','Elies'),(22,'Hariate',0,'elies@test5.com','0909090909','2002-08-29','M.','$2y$10$E//Gj3S7A9bPE0T6roFlUumMNfTcBvxCrAFgguE05Zfmto3aCObX.','Elies'),(23,'Hariate',0,'elies@test6.com','0909090909','2002-08-29','M.','$2y$10$ou.7m5UGlJz2ZyP6.dE/3ORCmSiyrUngYrE/7lr2igoRVlcMawo8.','Elies'),(24,'Elies',1,'elies@test333.com','0909090909','2002-09-01','Mr','$2y$10$8xGRf17XmJDFImI7/2DoN.dYadcVq5uCgSkv5NMw0sjJJF6keNGxm','Elies'),(25,'Elies',0,'elies@test44.com','0909090909','2002-09-01','Mr','$2y$10$cXz0nXFNga9Rvv.FfNPwquPY8vc3n9cpu0eDoy1YVTC0sW9LLXLQi','Elies');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-11  5:21:55
