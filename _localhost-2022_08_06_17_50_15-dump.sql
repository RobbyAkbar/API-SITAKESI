-- MySQL dump 10.13  Distrib 8.0.29, for macos12 (arm64)
--
-- Host: 127.0.0.1    Database: keuangan
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `agreement`
--

DROP TABLE IF EXISTS `agreement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agreement` (
  `idAgree` int NOT NULL AUTO_INCREMENT,
  `nameAgree` text NOT NULL,
  PRIMARY KEY (`idAgree`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggota` (
  `idAnggota` int NOT NULL AUTO_INCREMENT,
  `namaAnggota` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kode_aktivasi` varchar(255) NOT NULL,
  `status` enum('not verified','verified') NOT NULL DEFAULT 'not verified',
  `dtBuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAnggota`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laporan` (
  `idLaporan` int NOT NULL AUTO_INCREMENT,
  `idOrganisasi` int NOT NULL,
  `jenisLaporan` enum('pemasukan','pengeluaran') NOT NULL,
  `jumlah` int NOT NULL,
  `dtBuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ketLaporan` varchar(50) NOT NULL,
  PRIMARY KEY (`idLaporan`),
  KEY `idOrganisasi` (`idOrganisasi`),
  CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`idOrganisasi`) REFERENCES `organisasi` (`idOrganisasi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lingkup`
--

DROP TABLE IF EXISTS `lingkup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lingkup` (
  `idLingkup` int NOT NULL AUTO_INCREMENT,
  `idAnggota` int NOT NULL,
  `idOrganisasi` int NOT NULL,
  `statusAnggota` enum('ketua','bendahara','anggota') NOT NULL DEFAULT 'ketua',
  `dtBuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idLingkup`),
  KEY `idAnggota` (`idAnggota`),
  KEY `idOrganisasi` (`idOrganisasi`),
  CONSTRAINT `lingkup_ibfk_1` FOREIGN KEY (`idAnggota`) REFERENCES `anggota` (`idAnggota`),
  CONSTRAINT `lingkup_ibfk_2` FOREIGN KEY (`idOrganisasi`) REFERENCES `organisasi` (`idOrganisasi`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organisasi`
--

DROP TABLE IF EXISTS `organisasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organisasi` (
  `idOrganisasi` int NOT NULL AUTO_INCREMENT,
  `namaOrganisasi` varchar(50) NOT NULL,
  `statusOrganisasi` enum('nonaktif','aktif') NOT NULL DEFAULT 'nonaktif',
  `referral` char(8) NOT NULL,
  `namaInstansi` varchar(50) NOT NULL,
  `dtBuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtAktif` date DEFAULT NULL,
  PRIMARY KEY (`idOrganisasi`),
  UNIQUE KEY `referral` (`referral`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `idPembayaran` int NOT NULL AUTO_INCREMENT,
  `idAnggota` int NOT NULL,
  `idTagihan` int NOT NULL,
  `jumlahBayar` int NOT NULL,
  `dtBayar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPembayaran`),
  KEY `idAnggota` (`idAnggota`),
  KEY `idTagihan` (`idTagihan`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`idAnggota`) REFERENCES `anggota` (`idAnggota`),
  CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`idTagihan`) REFERENCES `tagihan` (`idTagihan`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tagihan`
--

DROP TABLE IF EXISTS `tagihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagihan` (
  `idTagihan` int NOT NULL AUTO_INCREMENT,
  `namaTagihan` varchar(50) NOT NULL,
  `jumlahTagihan` int NOT NULL,
  `dtBuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtDeadline` date NOT NULL,
  `statusTagihan` enum('belum selesai','selesai') NOT NULL DEFAULT 'belum selesai',
  `idOrganisasi` int NOT NULL,
  PRIMARY KEY (`idTagihan`),
  KEY `idOrganisasi` (`idOrganisasi`),
  CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`idOrganisasi`) REFERENCES `organisasi` (`idOrganisasi`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-06 17:50:15
