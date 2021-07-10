/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.1.30-MariaDB : Database - ahp_saw_maps
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ahp_saw_maps` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ahp_saw_maps`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values 
('admin','admin');

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(256) DEFAULT NULL,
  `keterangan` text,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_alternatif`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`kode_alternatif`,`nama_alternatif`,`keterangan`,`lat`,`lng`) values 
('A3','Pendaftar 3','','-7.6299754','111.4930317'),
('A2','Pendaftar 2','','-7.6299754','111.4930317'),
('A1','Pendaftar 1','Karangjati','-7.4584925','111.5826028');

/*Table structure for table `tb_crips` */

DROP TABLE IF EXISTS `tb_crips`;

CREATE TABLE `tb_crips` (
  `kode_crips` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `keterangan` varchar(256) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`kode_crips`)
) ENGINE=InnoDB AUTO_INCREMENT=538 DEFAULT CHARSET=latin1;

/*Data for the table `tb_crips` */

insert  into `tb_crips`(`kode_crips`,`kode_kriteria`,`keterangan`,`nilai`) values 
(505,'C1','Sangat Buruk',5),
(506,'C1','Buruk',25),
(507,'C1','Cukup',50),
(508,'C1','Baik',75),
(509,'C1','Sangat Baik',100),
(510,'C7','Blacklist',25),
(511,'C7','Netral',50),
(512,'C7','Whitelist',100),
(513,'C6','10 juta',5),
(514,'C6','20 juta',25),
(515,'C6','30 juta',50),
(516,'C6','40 juta',75),
(517,'C6','50 juta',100),
(518,'C5','Sangat Mundur',5),
(519,'C5','Mundur',25),
(520,'C5','Statis',50),
(521,'C5','Maju',75),
(522,'C5','Sangat Maju',100),
(523,'C4','10%',5),
(524,'C4','>=10%',25),
(525,'C4','>=20%',50),
(526,'C4','>=30%',75),
(527,'C4','>=40%',100),
(528,'C3','Sangat Tidak Mampu',5),
(529,'C3','Tidak mampu',25),
(530,'C3','Cukup',50),
(531,'C3','Mampu',75),
(532,'C3','Sangat Mampu',100),
(533,'C2','Sangat Tidak Mampu',5),
(534,'C2','Tidak Mampu',25),
(535,'C2','Cukup',50),
(536,'C2','Mampu',75),
(537,'C2','Sangat Mampu',100);

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(256) DEFAULT NULL,
  `atribut` varchar(16) DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  PRIMARY KEY (`kode_kriteria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`kode_kriteria`,`nama_kriteria`,`atribut`,`bobot`) values 
('C01','Character','benefit',0.19761657906239),
('C02','Capacity','cost',0.27484760119428),
('C03','Capital','benefit',0.13007482540025),
('C04','Collateral','cost',0.097876839615859),
('C05','Condition','benefit',0.14979207736361);

/*Table structure for table `tb_rel_alternatif` */

DROP TABLE IF EXISTS `tb_rel_alternatif`;

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `kode_crips` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `tb_rel_alternatif` */

insert  into `tb_rel_alternatif`(`ID`,`kode_alternatif`,`kode_kriteria`,`kode_crips`) values 
(1,'A1','C01',507),
(2,'A2','C01',509),
(3,'A3','C01',506),
(4,'A1','C02',536),
(5,'A2','C02',535),
(6,'A3','C02',535),
(7,'A1','C03',530),
(8,'A2','C03',531),
(9,'A3','C03',529),
(10,'A1','C04',525),
(11,'A2','C04',525),
(12,'A3','C04',525),
(13,'A1','C05',519),
(14,'A2','C05',521),
(15,'A3','C05',521);

/*Table structure for table `tb_rel_kriteria` */

DROP TABLE IF EXISTS `tb_rel_kriteria`;

CREATE TABLE `tb_rel_kriteria` (
  `ID1` varchar(16) NOT NULL,
  `ID2` varchar(16) NOT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`ID1`,`ID2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_rel_kriteria` */

insert  into `tb_rel_kriteria`(`ID1`,`ID2`,`nilai`) values 
('C01','C01',1),
('C01','C02',0.2),
('C01','C03',3),
('C01','C04',4),
('C01','C05',1),
('C01','C06',1),
('C02','C01',5),
('C02','C02',1),
('C02','C03',2),
('C02','C04',3),
('C02','C05',1),
('C02','C06',1),
('C03','C01',0.333333333),
('C03','C02',0.5),
('C03','C03',1),
('C03','C04',2),
('C03','C05',1),
('C03','C06',1),
('C04','C01',0.25),
('C04','C02',0.333333333),
('C04','C03',0.5),
('C04','C04',1),
('C04','C05',1),
('C04','C06',1),
('C05','C01',1),
('C05','C02',1),
('C05','C03',1),
('C05','C04',1),
('C05','C05',1),
('C05','C06',1),
('C06','C01',1),
('C06','C02',1),
('C06','C03',1),
('C06','C04',1),
('C06','C05',1),
('C06','C06',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
