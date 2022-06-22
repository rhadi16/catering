-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for catering
CREATE DATABASE IF NOT EXISTS `catering` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `catering`;

-- Dumping structure for table catering.auth_tokens
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `selector` varchar(12) NOT NULL,
  `hashedvalidator` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `expires` timestamp NULL DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `selector` (`selector`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table catering.auth_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_tokens` ENABLE KEYS */;

-- Dumping structure for table catering.list_makanan
CREATE TABLE IF NOT EXISTS `list_makanan` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` text DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `kategori` varchar(150) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table catering.list_makanan: ~1 rows (approximately)
/*!40000 ALTER TABLE `list_makanan` DISABLE KEYS */;
INSERT INTO `list_makanan` (`id_menu`, `nama_menu`, `harga`, `stok`, `kategori`, `foto`) VALUES
  (20, 'Nasi Goreng', 15000, 15, 'makanan', 'nasgor.jpg');
/*!40000 ALTER TABLE `list_makanan` ENABLE KEYS */;

-- Dumping structure for table catering.list_pesanan
CREATE TABLE IF NOT EXISTS `list_pesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `jum_yg_dibeli` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table catering.list_pesanan: ~0 rows (approximately)
/*!40000 ALTER TABLE `list_pesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_pesanan` ENABLE KEYS */;

-- Dumping structure for table catering.log_accessi
CREATE TABLE IF NOT EXISTS `log_accessi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `mail_immessa` varchar(50) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `accesso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

-- Dumping data for table catering.log_accessi: ~2 rows (approximately)
/*!40000 ALTER TABLE `log_accessi` DISABLE KEYS */;
INSERT INTO `log_accessi` (`id`, `ip`, `mail_immessa`, `data`, `accesso`) VALUES
  (116, '::1', 'admin@admin.com', '2022-05-23 21:12:22', 1),
  (117, '::1', 'rhadi@gmail.com', '2022-05-23 21:14:57', 1);
/*!40000 ALTER TABLE `log_accessi` ENABLE KEYS */;

-- Dumping structure for table catering.pegawai
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `hp` varchar(50) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table catering.pegawai: ~0 rows (approximately)
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;

-- Dumping structure for table catering.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_wa` varchar(100) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table catering.pelanggan: ~1 rows (approximately)
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
INSERT INTO `pelanggan` (`id`, `email`, `nama`, `alamat`, `no_wa`, `password`, `tgl_lahir`) VALUES
  (5, 'rhadi@gmail.com', 'Rhadi Indrawan', 'Pongtiku', '085255554789', '$2y$12$jSiMsQbiXJhaxgzlCzMJxeJbKI2lXgvD0nS1X//cPL4o8CQ0Vcqeu', '2010-04-16');
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;

-- Dumping structure for table catering.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) DEFAULT NULL,
  `jum_yg_dibeli` int(11) DEFAULT NULL,
  `tot_harga` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `nama_pelanggan` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table catering.penjualan: ~0 rows (approximately)
/*!40000 ALTER TABLE `penjualan` DISABLE KEYS */;
/*!40000 ALTER TABLE `penjualan` ENABLE KEYS */;

-- Dumping structure for table catering.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `stato` int(11) NOT NULL,
  `reset_selector` varchar(100) NOT NULL,
  `reset_code` varchar(256) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table catering.utenti: ~1 rows (approximately)
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` (`id`, `email`, `password`, `stato`, `reset_selector`, `reset_code`, `data`, `last_update`) VALUES
  (1, 'admin@admin.com', '$2y$12$eI5QCwkkNH69TwlpSu4pouDOX/64SWS8vq2SmXaFPDsAyXFyaaici', 0, '', '', '2022-05-21 10:59:53', '2022-05-21 11:00:16');
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
