-- MySQL dump 10.13  Distrib 9.0.1, for macos14.7 (arm64)
--
-- Host: localhost    Database: orders_management
-- ------------------------------------------------------
-- Server version	9.0.1

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
-- Table structure for table `orders_ejido_2024_12_26`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_26`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_26` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_26`
--

LOCK TABLES `orders_ejido_2024_12_26` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_26` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_26` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_ejido_2024_12_26` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2024_12_27`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_27`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_27` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_27`
--

LOCK TABLES `orders_ejido_2024_12_27` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_27` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_27` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_ejido_2024_12_27` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2024_12_28`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_28`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_28` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_28`
--

LOCK TABLES `orders_ejido_2024_12_28` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_28` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_28` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_ejido_2024_12_28` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2024_12_29`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_29`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_29` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_29`
--

LOCK TABLES `orders_ejido_2024_12_29` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_29` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_29` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_ejido_2024_12_29` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2024_12_30`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_30`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_30` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_30`
--

LOCK TABLES `orders_ejido_2024_12_30` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_30` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_30` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_ejido_2024_12_30` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2024_12_31`
--

DROP TABLE IF EXISTS `orders_ejido_2024_12_31`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2024_12_31` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2024_12_31`
--

LOCK TABLES `orders_ejido_2024_12_31` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2024_12_31` DISABLE KEYS */;
INSERT INTO `orders_ejido_2024_12_31` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',2,3,1,250.00,300.00,'Efectivo',50.00,'Joys',1,'Carlos'),(2,'María López',1,2,2,180.00,200.00,'Transferencia',20.00,'Pickup',1,'Luis'),(3,'Pedro Sánchez',3,4,0,320.00,400.00,'Tarjeta',80.00,'Interno',1,'Ana'),(4,'Clara Martínez',2,1,1,220.00,250.00,'Efectivo',30.00,'Joys',1,'Pedro'),(5,'José Ruiz',1,1,0,100.00,150.00,'Transferencia',50.00,'Pickup',1,'Laura'),(6,'Sofía Gómez',3,2,2,350.00,400.00,'Efectivo',50.00,'Interno',1,'Diego'),(7,'Miguel Torres',2,2,3,300.00,400.00,'Tarjeta',100.00,'Joys',1,'Ricardo'),(8,'Elena Sánchez',1,1,1,150.00,200.00,'Transferencia',50.00,'Pickup',1,'Carlos'),(9,'Luis García',2,0,2,200.00,250.00,'Efectivo',50.00,'Interno',1,'Ana'),(10,'Carmen López',1,2,1,180.00,200.00,'Tarjeta',20.00,'Joys',1,'Luis'),(11,'Jothan Luna',2,2,2,80.00,100.00,'Efectivo',30.00,'Interno',1,'zai');
/*!40000 ALTER TABLE `orders_ejido_2024_12_31` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2025_01_01`
--

DROP TABLE IF EXISTS `orders_ejido_2025_01_01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2025_01_01` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2025_01_01`
--

LOCK TABLES `orders_ejido_2025_01_01` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2025_01_01` DISABLE KEYS */;
INSERT INTO `orders_ejido_2025_01_01` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Yaris',2,2,2,300.00,300.00,'Efectivo',30.00,'Interno',1,'zai'),(2,'zai',3,1,4,500.00,500.00,'Transferencia',30.00,'Interno',1,'ya'),(3,'yan',3,1,4,200.00,200.00,'Tarjeta',30.00,'Interno',1,'yi'),(4,'Jothan',3,3,3,300.00,500.00,'Transferencia',0.00,'Interno',0,'yi'),(5,'Luna',2,2,2,0.00,0.00,'Tarjeta',0.00,'Interno',0,'yo'),(6,'severla',10,0,0,300.00,0.00,'Efectivo',0.00,NULL,0,NULL);
/*!40000 ALTER TABLE `orders_ejido_2025_01_01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_ejido_2025_01_02`
--

DROP TABLE IF EXISTS `orders_ejido_2025_01_02`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_ejido_2025_01_02` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_ejido_2025_01_02`
--

LOCK TABLES `orders_ejido_2025_01_02` WRITE;
/*!40000 ALTER TABLE `orders_ejido_2025_01_02` DISABLE KEYS */;
INSERT INTO `orders_ejido_2025_01_02` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`, `created_at`) VALUES (1,'Yaris',2,0,2,300.00,500.00,'Efectivo',30.00,NULL,0,NULL,'2025-01-02 18:44:15'),(2,'Mariana',0,0,0,1000.00,2000.00,'Efectivo',50.00,NULL,0,NULL,'2025-01-02 21:44:31');
/*!40000 ALTER TABLE `orders_ejido_2025_01_02` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_26`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_26`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_26` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_26`
--

LOCK TABLES `orders_palmeras_2024_12_26` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_26` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_26` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_26` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_27`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_27`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_27` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_27`
--

LOCK TABLES `orders_palmeras_2024_12_27` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_27` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_27` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_27` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_28`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_28`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_28` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_28`
--

LOCK TABLES `orders_palmeras_2024_12_28` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_28` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_28` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_28` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_29`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_29`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_29` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_29`
--

LOCK TABLES `orders_palmeras_2024_12_29` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_29` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_29` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_29` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_30`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_30`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_30` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_30`
--

LOCK TABLES `orders_palmeras_2024_12_30` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_30` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_30` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Juan Pérez',1,1,0,100.00,100.00,'Efectivo',0.00,'Joys',1,'Pedro Sánchez'),(2,'María López',2,2,1,115.75,165.75,'Transferencia',20.00,'Pickup',0,'Clara Martínez'),(3,'Pedro Sánchez',3,3,2,131.50,231.50,'Tarjeta',40.00,'Interno',1,'José Ruiz'),(4,'Clara Martínez',1,4,3,147.25,147.25,'Efectivo',0.00,'Joys',0,'Sofía Gómez'),(5,'José Ruiz',2,1,4,163.00,213.00,'Transferencia',20.00,'Pickup',1,'Miguel Torres'),(6,'Sofía Gómez',3,2,0,178.75,278.75,'Tarjeta',40.00,'Interno',0,'Elena Sánchez'),(7,'Miguel Torres',1,3,1,194.50,194.50,'Efectivo',0.00,'Joys',1,'Luis García'),(8,'Elena Sánchez',2,4,2,210.25,260.25,'Transferencia',20.00,'Pickup',0,'Carmen López'),(9,'Luis García',3,1,3,226.00,326.00,'Tarjeta',40.00,'Interno',1,'Juan Pérez'),(10,'Carmen López',1,2,4,241.75,241.75,'Efectivo',0.00,'Joys',0,'María López');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_30` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_palmeras_2024_12_31`
--

DROP TABLE IF EXISTS `orders_palmeras_2024_12_31`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_palmeras_2024_12_31` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `ordenes` int DEFAULT '0',
  `burritos` int DEFAULT '0',
  `bebidas` int DEFAULT '0',
  `total` decimal(10,2) DEFAULT '0.00',
  `paga_con` decimal(10,2) DEFAULT '0.00',
  `metodo_pago` enum('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
  `cambio` decimal(10,2) GENERATED ALWAYS AS ((`paga_con` - `total`)) STORED,
  `envio` decimal(10,2) DEFAULT '0.00',
  `repartidor` enum('Joys','Pickup','Interno') DEFAULT NULL,
  `dinero_recibido` tinyint(1) DEFAULT '0',
  `nombre_repartidor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_palmeras_2024_12_31`
--

LOCK TABLES `orders_palmeras_2024_12_31` WRITE;
/*!40000 ALTER TABLE `orders_palmeras_2024_12_31` DISABLE KEYS */;
INSERT INTO `orders_palmeras_2024_12_31` (`id`, `nombre`, `ordenes`, `burritos`, `bebidas`, `total`, `paga_con`, `metodo_pago`, `envio`, `repartidor`, `dinero_recibido`, `nombre_repartidor`) VALUES (1,'Ana Gómez',1,1,1,150.00,200.00,'Efectivo',50.00,'Pickup',1,'Diego'),(2,'Luis García',2,2,1,210.00,250.00,'Transferencia',40.00,'Joys',1,'Ricardo'),(3,'Carla Ruiz',1,0,3,120.00,150.00,'Tarjeta',30.00,'Interno',1,'Laura'),(4,'Mario Pérez',3,3,2,300.00,350.00,'Efectivo',50.00,'Joys',1,'Carlos'),(5,'Claudia López',1,1,1,100.00,120.00,'Transferencia',20.00,'Pickup',1,'Luis'),(6,'Raúl Torres',2,2,2,250.00,300.00,'Efectivo',50.00,'Interno',1,'Ana'),(7,'Lucía Martínez',3,2,1,320.00,400.00,'Tarjeta',80.00,'Joys',1,'Ricardo'),(8,'Fernando Gómez',1,1,0,90.00,100.00,'Transferencia',10.00,'Pickup',1,'Laura'),(9,'Sandra Ruiz',2,2,3,200.00,250.00,'Efectivo',50.00,'Interno',1,'Carlos'),(10,'Patricia Sánchez',1,1,2,150.00,180.00,'Tarjeta',30.00,'Joys',1,'Luis');
/*!40000 ALTER TABLE `orders_palmeras_2024_12_31` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` enum('ejido','palmeras','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$O.r3DxOrxg/NB4fYosEZAezrpYPNlFblRHFHHS7zUpYjZDkJFGupq'),(2,'ejido','$2y$12$kFc6jXAnASrenrDnoq9BaOagsKZv0Y3scg1YAO.fQl/rzhPcQI0TG'),(3,'palmeras','$2y$12$PfhtW.Mh0ZrIPdATtNy4DO1cLEb5u08T8M33.W61wj312257gRUx2');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'orders_management'
--

--
-- Dumping routines for database 'orders_management'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-02 17:37:08
