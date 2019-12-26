-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: lojinha
-- ------------------------------------------------------
-- Server version	5.7.28-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acao_estoque`
--

DROP TABLE IF EXISTS `acao_estoque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acao_estoque` (
  `id_acao_estoque` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `quantidade_atual` int(11) NOT NULL,
  `quantidade_inserido` int(11) DEFAULT NULL,
  `acao` varchar(10) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_acao_estoque`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acao_estoque`
--

LOCK TABLES `acao_estoque` WRITE;
/*!40000 ALTER TABLE `acao_estoque` DISABLE KEYS */;
/*!40000 ALTER TABLE `acao_estoque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimentacao`
--

DROP TABLE IF EXISTS `movimentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(6,2) NOT NULL,
  `descricao` text NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `status` varchar(10) DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_movimentacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimentacao`
--

LOCK TABLES `movimentacao` WRITE;
/*!40000 ALTER TABLE `movimentacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimentacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `endereco` varchar(45) DEFAULT NULL,
  `entrega` date DEFAULT NULL,
  `obs` varchar(45) DEFAULT NULL,
  `valor_total` decimal(6,2) NOT NULL,
  `valor_pago` decimal(6,2) NOT NULL,
  `troco` decimal(6,2) NOT NULL DEFAULT '0.00',
  `desconto` decimal(6,2) NOT NULL DEFAULT '0.00',
  `tipo_pagamento` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendencias`
--

DROP TABLE IF EXISTS `pendencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendencias` (
  `id_pendencia` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `valor` float(5,2) DEFAULT NULL,
  `vencimento` date NOT NULL,
  `status` varchar(45) DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendencias`
--

LOCK TABLES `pendencias` WRITE;
/*!40000 ALTER TABLE `pendencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `pendencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `valor` decimal(6,2) NOT NULL DEFAULT '0.00',
  `quantidade` int(11) NOT NULL DEFAULT '0',
  `status` varchar(45) NOT NULL DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos_pedido`
--

DROP TABLE IF EXISTS `produtos_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos_pedido` (
  `id_produto_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `valor` decimal(6,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `promocao` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_produto_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos_pedido`
--

LOCK TABLES `produtos_pedido` WRITE;
/*!40000 ALTER TABLE `produtos_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `produtos_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocao`
--

DROP TABLE IF EXISTS `promocao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promocao` (
  `id_promocao` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` varchar(45) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor` decimal(6,2) NOT NULL,
  `status` varchar(45) DEFAULT 'ativo',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_promocao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocao`
--

LOCK TABLES `promocao` WRITE;
/*!40000 ALTER TABLE `promocao` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocao` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-26  1:23:55
