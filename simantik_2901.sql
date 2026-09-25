-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2019 at 01:46 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simantik`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_barang`
--

CREATE TABLE IF NOT EXISTS `m_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jenisbarang` varchar(15) NOT NULL,
  `kode_subjenisbarang` varchar(6) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `stok_barang` int(11) NOT NULL,
  `satuan` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

--
-- Dumping data for table `m_barang`
--

INSERT INTO `m_barang` (`id`, `kode_jenisbarang`, `kode_subjenisbarang`, `nama_barang`, `stok_barang`, `satuan`) VALUES
(1, '1010302004', '000001', 'Amplop Polos Panjang', 15, 'dos'),
(2, '1010302004', '000006', 'Amplop Kabinet Putih', 15, 'lembar'),
(3, '1010302004', '000004', 'Amplop Samsonkraft Besar', 15, 'lembar'),
(4, '1010302004', '000005', 'Amplop Samsonkraft Kecil', 15, 'lembar'),
(5, '1010301001', '000017', 'Ballpoint Ballliner', 22, 'buah'),
(6, '1010399999', '000239', 'Baterai AA', 15, 'buah'),
(7, '1010399999', '000238', 'Baterai AAA', 15, 'buah'),
(8, '1010305012', '000006', 'Baygon Spray Isi 400 gr', 15, 'kaleng'),
(9, '1010301003', '000011', 'Binder Klip 107', 13, 'buah'),
(10, '1010301003', '000006', 'Binder Klip 111', 15, 'buah'),
(11, '1010301003', '000002', 'Binder Klip 155', 15, 'buah'),
(12, '1010301003', '000003', 'Binder Klip 200                                   ', 15, 'buah'),
(13, '1010301003', '000004', 'Binder Klip 260', 15, 'buah'),
(14, '1010301999', '000007', 'bloknote', 15, 'buah'),
(15, '1010301001', '000008', 'Ballpoint Standar', 15, 'buah'),
(16, '1010305012', '000013', 'Bubuk Cuci Piring', 15, 'buah'),
(17, '1010301005', '000003', 'Buku Ekspedisi ', 10, 'buah'),
(18, '1010301005', '000002', 'Buku Folio Bergaris', 15, 'buah'),
(19, '1010301005', '000001', 'Buku Tulis Kuarto isi 100', 15, 'buah'),
(20, '1010301006', '000017', 'Bussines File', 15, 'buah'),
(21, '1010304005', '000002', 'CD R + tempat', 15, 'buah'),
(22, '1010301008', '000003', 'Pisau Cutter A300', 15, 'buah'),
(23, '1010301008', '000004', 'Pisau Cutter L500', 15, 'buah'),
(24, '1010301006', '000008', 'Document Keeper', 15, 'buah'),
(25, '1010304004', '000054', 'DVD dan tempat', 15, 'buah'),
(26, '1010305003', '000002', 'Ember Plastik                                     ', 15, 'buah'),
(27, '1010305004', '000002', 'Engkrak Plastik ', 15, 'buah'),
(28, '1010301999', '000005', 'File Box  ', 15, 'buah'),
(29, '1010304006', '000003', 'Flash Disk 16 GB', 15, 'buah'),
(30, '1010304006', '000005', 'Flashdisk 32 GB', 15, 'buah'),
(31, '1010305001', '000006', 'Floor Scrub', 15, 'buah'),
(32, '1010305003', '000001', 'Gayung AIR', 15, 'buah'),
(33, '1010305999', '000001', 'Gunting', 15, 'buah'),
(34, '1010305012', '000015', 'Handsoap isi 4l liter', 15, 'jerigen'),
(35, '1010301011', '000001', 'Hechmachine No. 10', 15, 'buah'),
(36, '1010301011', '000002', 'Hechmachine 24/6', 15, 'buah'),
(37, '1010301011', '000005', 'Isi Hechneces Besar', 15, 'dos'),
(38, '1010301011', '000003', 'Isi Hechneches No. 10', 15, 'dos'),
(39, '1010301002', '000004', 'Isi Penthel', 15, 'buah'),
(40, '1010301010', '000007', 'Isolasi 1/2x 72', 15, 'buah'),
(41, '1010301010', '000009', 'Isolasi 1 x 72', 15, 'buah'),
(42, '1010301010', '000020', 'Isolasi Bolak Balik', 15, 'gulung'),
(43, '1010301010', '000019', 'Isolasi Bolak Balik Busa', 15, 'gulung'),
(44, '1010301010', '000012', 'Isolasi Putih Besar', 15, 'gulung'),
(45, '1010305002', '000002', 'Kain Pel Gading', 15, 'buah'),
(46, '1010305012', '000011', 'Kapur Barus', 15, 'kg'),
(47, '1010305012', '000016', 'Kapur Barus bola2', 15, 'bungkus'),
(48, '1010305012', '000019', 'Kapur barus gantung', 15, 'buah'),
(49, '1010399999', '000087', 'Kardus BPS Prov Jateng (50x37x27)', 15, 'buah'),
(50, '1010301010', '000004', 'Karet Gelang', 15, 'pak'),
(51, '1010305004', '000008', 'Karpet Bakmi Tebal', 15, 'buah'),
(52, '1010305004', '000001', 'Keranjang Sampah', 15, 'buah'),
(53, '1010302001', '000001', 'Kertas HVS A4 70gr', 15, 'rim'),
(54, '1010302001', '000009', 'Kertas HVS A4 80gr', 15, 'rim'),
(55, '1010302001', '000008', 'Kertas HVS A4 100gr', 15, 'rim'),
(56, '1010302001', '000007', 'Kertas HVS 70gr B5  ', 15, 'rim'),
(57, '1010302001', '000002', 'Kertas HVS F4 70gr', 15, 'rim'),
(58, '1010302003', '000001', 'Kertas Cover Manila', 15, 'lembar'),
(59, '1010302002', '000002', 'Kertas sampul Kraft', 15, 'lembar'),
(60, '1010305004', '000021', 'Keset karet lubang 1,5 m', 15, 'buah'),
(61, '1010305004', '000006', 'Keset Kain', 15, 'buah'),
(62, '1010305002', '000007', 'Lap Kanebo', 15, 'buah'),
(63, '1010301010', '000005', 'Lem Fox', 15, 'buah'),
(64, '1010301010', '000001', 'Lem Tackol', 15, 'botol'),
(65, '1010399999', '000252', 'Lem Tikus', 15, 'buah'),
(66, '1010301006', '000022', 'Map L     ', 15, 'buah'),
(67, '1010301006', '000004', 'Map Plastik', 15, 'buah'),
(68, '1010301006', '000015', 'Map Plastik Kancing', 15, 'buah'),
(69, '1010301006', '000001', 'Ordner Folio ', 15, 'buah'),
(70, '1010301003', '000005', 'Paper Klip Besar', 15, 'dos'),
(71, '1010301003', '000001', 'Paper Klip Kecil', 15, 'dos'),
(72, '1010305012', '000008', 'Pembersih Kaca Clear', 15, 'buah'),
(73, '1010305012', '000001', 'Kreolin Wangi Cemara', 15, 'buah'),
(74, '1010305012', '000002', 'Kreolin Wangi Sereh', 15, 'buah'),
(75, '1010305012', '000007', 'Pembersih Porselin/Closet', 15, 'buah'),
(76, '1010301004', '000001', 'Karet Penghapus', 15, 'buah'),
(77, '1010301001', '000001', 'Pensil 2B', 17, 'buah'),
(78, '1010301999', '000016', 'Perpurator Punch XL 30', 15, 'buah'),
(79, '1010301999', '000006', 'Perpurator No. 85  ', 15, 'buah'),
(80, '1010305012', '000004', 'Pewangi Kamar Mandi (Stela/Galde)     ', 15, 'buah'),
(81, '1010305012', '000009', 'Pewangi Ruangan Spray ', 15, 'kaleng'),
(82, '1010301008', '000001', 'Pisau Peruncing', 15, 'buah'),
(83, '1010304004', '000005', 'Pita Rol Facsimile', 15, 'buah'),
(84, '1010301010', '000011', 'Plakband Coklat ', 15, 'buah'),
(85, '1010301010', '000010', 'Plakban Hitam', 15, 'buah'),
(86, '1010301006', '000005', 'Portepel Map Bertali', 15, 'buah'),
(87, '1010301008', '000002', 'Rautan pensil ', 15, 'buah'),
(88, '1010305012', '000003', 'Rinso', 15, 'buah'),
(89, '1010305001', '000003', 'Sapu Ijuk   ', 15, 'buah'),
(90, '1010305001', '000001', 'Sikat kawat  ', 15, 'buah'),
(91, '1010305001', '000002', 'Sikat WC', 15, 'buah'),
(92, '1010301001', '000010', 'Spidol Kecil Warna', 15, 'buah'),
(93, '1010301006', '000003', 'Snelhectermap', 15, 'buah'),
(94, '1010301006', '000006', 'Snelhecter Plastik', 15, 'buah'),
(95, '1010601999', '000003', 'Spidol SP 2010', 15, 'buah'),
(96, '1010301001', '000005', 'Spidol Whiteboard', 15, 'buah'),
(97, '1010301001', '000021', 'Stabilo', 15, 'buah'),
(98, '1010301999', '000017', 'Sticky Note Besar ', 15, 'set'),
(99, '1010301999', '000018', 'Sticky Note Kecil', 15, 'set'),
(100, '1010301006', '000024', 'Stopmap Batik', 15, 'buah'),
(101, '1010301006', '000002', 'Stopmap Folio', 15, 'buah'),
(102, '1010301006', '000007', 'Stopmap Plastik Jepit', 15, 'buah'),
(103, '1010305002', '000001', 'Sulak', 15, 'buah'),
(104, '1010305012', '000012', 'Pencuci Piring (Sunlight Cair)', 15, 'buah'),
(105, '1010301010', '000003', 'Tali Rafia', 15, 'gulung'),
(106, '1010305004', '000007', 'Tempat Sampah Injak', 15, 'buah'),
(107, '1010301002', '000001', 'Tinta Stempel ', 15, 'botol'),
(108, '1010301004', '000003', 'Tip Ex', 15, 'buah'),
(109, '1010305999', '000007', 'Tissue Multifold', 15, 'buah'),
(110, '1010305999', '000010', 'Tissue Roll', 15, 'gulung'),
(111, '1010304004', '000050', 'Toner HP CE 505A (05a)', 15, 'buah'),
(112, '1010304004', '000065', 'Catridge Toner CC530A (304A) Black', 15, 'buah'),
(113, '1010304004', '000066', 'Catridge Toner CC531A (304A) Cyan', 15, 'buah'),
(114, '1010304004', '000068', 'Catridge Toner CC533A (304A) Magenta', 15, 'buah'),
(115, '1010304004', '000067', 'Catridge Toner CC532A (304A) Yellow', 15, 'buah'),
(116, '1010304004', '000060', 'Catridge Toner CE410A (305A) Black', 15, 'buah'),
(117, '1010304004', '000061', 'Catridge Toner CE411A (305A) Cyan', 15, 'buah'),
(118, '1010304004', '000062', 'Catridge Toner CE413A (305A) Magenta', 15, 'buah'),
(119, '1010304004', '000063', 'Catridge Toner CE412A (305A) Yellow', 15, 'buah'),
(120, '1010304004', '000059', 'Catridge Toner CF280A (80A) ', 15, 'buah'),
(121, '1010304004', '000070', 'Catridge Toner HP Laser Jet CF 410A Black', 15, 'buah'),
(122, '1010304004', '000071', 'Catridge Toner HP Laser Jet CF 411A Cyan', 15, 'buah'),
(123, '1010304004', '000072', 'Catridge Toner HP Laser Jet CF 412A Yellow', 15, 'buah'),
(124, '1010304004', '000073', 'Catridge Toner HP Laser Jet CF 413A Magenta', 15, 'buah'),
(125, '1010305002', '000003', 'Tongkat Pel', 15, 'buah'),
(126, '1010305002', '000008', 'Wiper Stick ', 15, 'buah');

-- --------------------------------------------------------

--
-- Table structure for table `m_pegawai`
--

CREATE TABLE IF NOT EXISTS `m_pegawai` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(75) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `level` enum('admin','admin_tu','user') NOT NULL,
  `id_unitkerja` varchar(5) NOT NULL,
  `id_eselon` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `m_pegawai`
--

INSERT INTO `m_pegawai` (`id`, `username`, `password`, `nama`, `nip`, `level`, `id_unitkerja`, `id_eselon`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', '19900326 201401 1 002', 'admin', '33562', 0),
(50, 'sentot', 'b80174f1de4b1e6959d435797f75c001', 'Sentot Bangun Widoyono M.A.', '196109041983021001', 'user', '33500', 2),
(51, 'hermanu', 'beb8e26b4dc9e663118d67da6f5cdddb', 'HERMANU TRI HANDOYO,SE,MM', '196405161992031001', 'user', '33514', 4),
(54, 'sunarto', '518a7b677aa79cf948b80c3c4b661208', 'SUNARTO ', '198211232009111001', 'user', '33514', 0),
(55, 'yani', '5719f00b70965d78f8a8d7c72cf50692', 'BUDHI LISTYARAYANI, S.Si.', '198207232009022010', 'admin_tu', '33514', 0),
(56, 'hendro', 'a60c9c3495b753095babb3ec1cb09adf', 'HENDRO DEASMARAN, A.Md.', '198012222011011008', 'user', '33514', 0),
(57, 'laela', '1c995326b28220d86a5cbba3c2297117', 'LAELA ANISATIN', '198803142008012003', 'user', '33514', 0),
(61, 'darto', 'a21bc36cb14ee8231ad0b02906c2b521', 'DARTO YUGO SUBROTO', '196510191987031001', 'user', '33512', 0),
(62, 'noor', '9d9b3b50b9785d3dda783b0d31098177', 'NOOR AISYAH, A.Md', '198110152002122001', 'user', '33512', 0),
(63, 'sobirin', '84bade597d0fefc64addae2a7c39aa60', 'MUHAMAD SOBIRIN,S.Si', '197806262002121003', 'user', '33512', 4),
(64, 'tutut', '09c47d3ec93d50c74e77694f86825084', 'SUPRI TUTI EKAWATI,SE', '196901271994032002', 'user', '33512', 0),
(65, 'tejo', 'fa73bbfee66972534c2551290838e8cd', 'Drs. TEJO HARYOKO', '195906181990031002', 'user', '33512', 0),
(66, 'wiwie', 'c12d5d42651c6bde96debbe53579cc31', 'WIHARYATI, S.H.', '198403222011012013', 'user', '33512', 0),
(67, 'renny', '7410c34014074a26ed0727ef8434076e', 'RENNY WIDYANINGRUM, S.Psi', '198709202011012017', 'user', '33512', 0),
(68, 'utami', 'b5d3452069320e13ef5c31927c8d9b8c', 'LESTARI UTAMININGSIH S.ST', '197710132000022000', 'user', '33512', 0),
(70, 'agus', '15fbca3bc4f31836eb0bcb8dceb6c522', 'IMAN AGUS WISMONO', '196108271983011001', 'user', '33513', 0),
(71, 'rusanto', 'b7f0211f936f22fca9dbe0bb658d430b', 'BAMBANG BUDI RUSANTO', '196607171989031002', 'user', '33513', 0),
(72, 'aksi', 'ba2385b73f42461e079721cdbd60a4af', 'AKSIONO NUSWANTORO, SE', '196806031994031006', 'user', '33513', 0),
(73, 'khani', '8d325aa67a378bddc349c72406dea637', 'KHANI FATUR ROSYIDAH, A.Md', '198506202009022004', 'user', '33513', 0),
(74, 'priyono', 'c4ca4238a0b923820dcc509a6f75849b', 'PRIYONO, A.Md', '198704092009021004', 'user', '33513', 0),
(75, 'ismu', '1241bc70e6aee20a1304424e4612705a', 'ISMUNARTO', '197605142006041016', 'user', '33513', 0),
(76, 'evy', 'a68140485d341dc8e6e304fa811a0403', 'EVY KUSETYANINGRUM, A.Md', '198004292006042010', 'user', '33513', 0),
(77, 'ayu', 'c906e54022598fd3f85bbf7f2f31d1a6', 'AYU RACHMAWATI,A.Md', '198605312009022007', 'user', '33513', 0),
(78, 'saniman', '185543d8ee85cde0c7cca64a2c4fb79e', 'SANIMAN, SH', '196911261989031001', 'user', '33515', 0),
(79, 'ganes', '0d27ea1c2e122b3e8b9e950b2772584e', 'GANES MAHENDRATI YEKTI', '198105292003122002', 'user', '33515', 0),
(80, 'wiwid', 'af908a21ee42f7e085ae6b2ba612e22c', 'WIWID BUDI SANTOSO,S.ST', '197711021999121001', 'user', '33515', 0),
(81, 'fitri', '0ee4e95a4fcec11e71bf3df2697c1b72', 'FITRI WAHYUNI, A.Md', '198612052009022010', 'user', '33515', 0),
(82, 'ambar', 'f350bf05fd8353839695196cf3026a85', 'RINA AMBAR SARI', '198609222006042001', 'user', '33515', 0),
(83, 'fendy', '9ba07166fd77503e15fbf08093e5696c', 'FENDY ARDYANTO, S.ST', '198502232008011003', 'user', '33515', 0),
(84, 'one', '612f2abc715c3c6e316a5b32d1f5f493', 'ONE DWI ENDARNINGTYAS', '198712022006042002', 'user', '33515', 0),
(85, 'lia', '0ddc712dd723508b0511e99373c29080', 'CHRISTINA LIA HUWAE, A.Md', '198204262011012009', 'admin_tu', '33514', 0),
(87, 'suprianta', 'd165144bbf62ac0596a29f57a99ff1e6', 'AGUS SUPRIANTA', '196908171994031008', 'user', '33511', 0),
(88, 'ika', '8879bbc51b790326f6ce3a0e512cd867', 'IKA BUDI AMBARYANTI, SE', '198110052006042035', 'user', '33511', 0),
(89, 'samiran', 'c2e9ac33cadc66291c879563b3942ddb', 'SAMIRAN, S.Si, MT', '197305121994121001', 'user', '33550', 3),
(90, 'samu', 'ffbbcfca0d4b7fbd32e3bab8d462c2c2', 'MATHIUS SAMUHARWADI S.ST', '196909031994031006', 'user', '33551', 4),
(91, 'renaldhi', '638be61ff95ac6a912f5e775a97b68ac', 'RENALDHI PRIYANTOMO, S.ST', '197803132000121001', 'user', '33551', 0),
(92, 'santi', '659d1733b23fe14c17ada95fda7d37f4', 'SANTI WIDYASTUTI, S.ST', '198708292009122003', 'user', '33551', 0),
(93, 'rizkie', '5bef1373ac431689577cb0774c75234e', 'Ir. RIZKIE ARUMINGTYAS, MM', '196709251994012001', 'user', '33552', 4),
(94, 'endangwido', 'c397fe33ef12da802def60560fc0aa0e', 'IR ENDANG WIDOWATI', '196611161994032003', 'user', '33552', 0),
(95, 'wiwit', 'f63ebf86e22fb05171a07762ff4bda5a', 'WIWIT SANTI WAHYUNINGSIH, S.ST', '197811062000122001', 'user', '33552', 0),
(96, 'eny', 'efba5b43ae987ff777313b34bb90c23e', 'DRA. ENY PRAMUDYASTUTI', '196902241994022001', 'user', '33553', 4),
(97, 'joko', '16e2f5885653ae1a2eb263fd4ec8357a', 'JOKO MULYONO', '197405141994031003', 'user', '33553', 0),
(98, 'rio', '1d1323d07cd2677f114de9cb6b9ca475', 'RIO BASUNINDYA GUNAWAN, S.ST', '197603151997121001', 'user', '33563', 4),
(99, 'totok', '866dc5dbaff947d4fea4299ccf054c62', 'TOTOK TAVIRIJANTO, S.Si', '196504191988021001', 'user', '33530', 3),
(100, 'dias', '496858c9427ad475109e3df141938353', 'IR. SRI DIASTUTI, MM', '196809291993022001', 'user', '33531', 4),
(101, 'taufiq', '937cc08756b57c0e1bac3b1a3ed93f95', 'IR. M TAUFIQURROCHMAN', '196602031994011001', 'user', '33531', 0),
(102, 'sartini', '1981eab9746d93395a75d487f6a15b5d', 'SARTINI', '196007091980122001', 'user', '33531', 0),
(103, 'lestania', 'f19612804dcf21de11eaf4598b6f1d95', 'LESTANIA JAYANTI, S.Pt', '198207082006042002', 'user', '33531', 0),
(104, 'kharis', 'c4d38594d140101792f17ef5b65f56ea', 'KHARIS KOMARUDIN,S.ST,M.Stat', '197607171999031003', 'user', '33531', 0),
(105, 'ari', '1b1645bfc318eb62d715351ccf081443', 'ARI SUSANTO, A.Md', '198302212005021002', 'user', '33531', 0),
(106, 'chaju', 'f369112275a2a81d751ecb94e1b87d6d', 'DRA. CHAJU RATNA LATIFADEWI', '196408101991022001', 'user', '33532', 4),
(107, 'etika', '7964702a8ccc129112c2bbfdf0666219', 'ETIKAWATI DATIEK PRATIWI, A.Md', '198201282006042015', 'user', '33532', 0),
(108, 'nugroho', 'fa47d1b3d757e0aed75c8e6265d61067', 'NUGROHO IMAN DARODJAT, S.ST', '197710061998031006', 'user', '33533', 4),
(109, 'murtini', '75f93712c293a5d28f437ccefc1e2bf6', 'SRI MURTINI, SE', '196507301992122001', 'user', '33533', 4),
(110, 'tri', '79074d0cf1bfb244ef1b312f3158fc34', 'TRI KARJONO, S.Pi', '197208281994031005', 'user', '33533', 0),
(111, 'adib', '2efc424558ee6f35238af7ebb09ae910', 'Agus Sudibyo M.Stat', '197412311996121001', 'admin', '33560', 3),
(112, 'sumbodo', '7b9fa3992620add9bb6d9d494a0fb528', 'SUMBODO AJI CAHYONO, S.Si, MA', '197703081999011001', 'user', '33561', 4),
(114, 'hesti', 'bc7021c63f5e1c4a41835be7f35cc7e0', 'HESTI PRAMUDYASTI,S.Si', '197909252009022005', 'user', '33561', 0),
(115, 'ariyadi', '924863ba54a545ea324e2e387ad43715', 'MAHMUDA ARIYADI, S. Kom', '197111172006041010', 'user', '33561', 0),
(116, 'yuli', 'e172dd95f4feb21412a692e73929961e', 'YULI PURWITASARI, SST', '198707082009022002', 'user', '33561', 0),
(118, 'aris', 'b9f3e94cbf116480adfefc21326443e8', 'ARIS ARIANTO', '197505291994031002', 'user', '33562', 0),
(119, 'pras', '6cc38f05dcf9b1bc849ce53f32a584f3', 'HERMAWAN PRASETYO,S.ST', '198610082009021005', 'user', '33562', 4),
(120, 'rizchi', 'b37c8dd8b83fce9b7239550976117d7b', 'RIZCHI EKA WAHYUNI, SST', '198701042009122002', 'user', '33562', 0),
(121, 'aji', 'eff239968f8ebf554ac2c7cb2889306f', 'SEPTYAJI BANGUN ANARGI, S.Si', '198409092010031002', 'user', '33562', 0),
(122, 'asis', '469d79c9ede61573ac6db9285c7f94c4', 'ASIS PURNOMO, S.Pi', '196602031994021001', 'user', '33563', 4),
(123, 'nanang', '293b48cf9367840930f76073d6e05333', 'YUN RESTIANTO', '197406132006041014', 'user', '33563', 0),
(124, 'indah', 'd0c16c776f8f315527c7a3cd4e983479', 'INDAH PURNAMASARI, SE', '198501252006042001', 'user', '33563', 0),
(125, 'daryanto', 'b55240629f6eb74ae99acc77cf3c40fb', 'DARYANTO, S.ST', '197603051999031004', 'user', '33563', 0),
(126, 'rita', '5b72fd5387035e3b0b11a2ba7a15757e', 'DRA RITA UMAMI,MM', '195904231991032001', 'user', '33541', 4),
(127, 'gani', 'cf3095a67f8c832f39604e958f541b12', 'GANIYANTO', '196108151982031007', 'user', '33541', 0),
(128, 'rully', '8dd6ff77392850ee3290f03ca190749b', 'RULLY SUTANSYAH EFFENDY,S.ST', '197906262002121003', 'user', '33541', 0),
(129, 'dyah', '5fe2f3abd10b3aa853306df5d370f790', 'DYAH INDAH RAHMAWATI, S.ST', '197201231996032001', 'user', '33541', 0),
(130, 'indri', '4bd6e2826de9eec3057ddf3665bc147d', 'IES DRIARTI, SE', '196702041994012001', 'user', '33542', 4),
(132, 'juni', 'aec801a11e0776b0a0863937a7d17fb0', 'JUNIARTI HARTINDAH, SE', '196506221993032001', 'user', '33542', 0),
(133, 'anton', 'e22b125a72697e4b2df4df375cf9da03', 'ANTONIUS TRIYUSANTO, SE', '196104161982031001', 'user', '33542', 0),
(134, 'trimulya', '0269f3b9333373d062629656fdbe5358', 'TRI MULYANINGSIH, S.ST', '197705282000022001', 'user', '33542', 0),
(135, 'endangsulis', 'abe9a20e9ef3868199ca460924665187', 'IR. SRI ENDANG SULISTIOWATI', '196406191987022001', 'user', '33541', 4),
(136, 'yusnita', 'f3f3d5724edbe1ac0c2fa65b7b505f53', 'YUSNITA DEWANTI, SST', '197712091999122001', 'user', '33543', 0),
(137, 'irma', 'b0bb7ae1a73e40be8503c960fde3ac9d', 'IRMA NUR AFIFAH', '197512011999032003', 'user', '33543', 0),
(138, 'ison', 'ea0610a932edb7ad66af980d811b6b28', 'ISON DARSONO, SE, MM', '197112291993021001', 'user', '33543', 0),
(139, 'untung', 'ea7ef55530e15f0cb8a5fa2d7c0cc981', 'UNTUNG RAHARDJO, SE', '196101241979121001', 'user', '33523', 4),
(140, 'medha', '5dd6fc9dfeb606416deb887419ec9f34', 'MEDHA WARDHANY, S.ST', '198202272004122002', 'user', '33523', 0),
(141, 'lolo', 'a194b13fbaec9364c6094025db66a442', 'FAUZIYAH SELOWATI, S.Si', '198109272006042021', 'user', '33523', 0),
(142, 'sriningsih', '63bb3fa18a0a7605e3495c2d483191dc', 'SRININGSIH, S.ST, M.Si', '197907152000122001', 'user', '33523', 0),
(143, 'sutirin', 'ba472540698e91ec0bf40d3a0054857c', 'Ir. SUTIRIN, M.Si', '196702061992022001', 'user', '33522', 4),
(144, 'herlina', '1c98c3c304639e79b5ba5647533bb9b3', 'HERLINA,S.ST', '197606271997122001', 'user', '33522', 0),
(145, 'rina', '8ebf56f025f3425322ed9fee430abd90', 'RINA KARTININGRUM, S.ST', '198404202007012006', 'user', '33522', 0),
(146, 'novi', '36d5cf38e0bb73b396ffff3540a5d497', 'NOVIANTO WIJOKO', '196911291994031006', 'user', '33522', 0),
(147, 'mimin', '2c042f555bcc7e1177c1f04597396555', 'DRA MINATUS SANIYAH', '196910191992122001', 'user', '33521', 4),
(148, 'pono', '2f8d5b929f94c71793194ca291453314', 'PONO', '196309041986031004', 'user', '33521', 0),
(149, 'mugi', '7fb42e0b2fd0874cdee62a3d487b2e63', 'MUGIYANA, SE', '197312241994031002', 'user', '33521', 0),
(150, 'rifah', '5775a4bb331ba4f967e6bd58cab2e631', 'MA''RIFAH NOOR ELYAH ', '196804151991012002', 'user', '33521', 0),
(151, 'atas', 'db1bcc1494094cea262dda5a6d86da5c', 'ATAS PARLINDUNGAN L, S.Si, M.Si', '196412141988021001', 'user', '33510', 3),
(152, 'hyas', '5978206b4b75fadf46dc9ad31f578092', 'HYAS AMAYSTA NUNING R, A.Md', '198605182009022010', 'user', '33514', 0),
(153, 'ichiek', '0b28c6850ece801176a823f85ca64546', 'Dra. V. ICHIEK NUGRAHATINING R', '196412211990032001', 'user', '33515', 4),
(154, 'gayanti', '4c872d573035553f91afff741a6bd2f2', 'SRI GAYANTI PUJI L, S.Si, M.M', '197404281996032001', 'user', '33511', 0),
(155, 'ranny', '0a8c3e10b77d546175c077bb244464a3', 'MAHARANNY DIWID P, SST', '199006052013112001', 'user', '33553', 0),
(156, 'mery', '9603c521e48090bc015276844966890d', 'MERYANTI SRI W, S.ST, M.Si', '197903062000122002', 'user', '33521', 0),
(157, 'aning', '1a85b9f0a3f5a31f96fecd2c9e00cc1d', 'ANING WIDIYATMI, SE', '197412171998032004', 'user', '33511', 0),
(158, 'arjuliwondo', 'e9d0e63f40d2d465df4867926cd17229', 'Arjuliwondo S.Si.', '196507221988021001', 'user', '33540', 3),
(159, 'dwi', 'abd1d5f8eab08b19c05813bdb2e532af', 'DWI AGUS WAHYU RIYADI, A.Md', '198805212012121003', 'user', '33562', 0),
(160, 'martin', 'fca02c80d591fb19537bf82811daa9f3', 'Martin Suanta S.E.,M.Si', '196603271990031002', 'user', '33520', 3),
(161, 'yayan', '6da88b2921f706c15ff5d94c822fc23b', 'Yayan Arum Wulandari SE', '197901102002122005', 'user', '33543', 0),
(162, 'adi', 'afee7ca9864266ae1b6986dd87452be5', 'Adi Susanto SST', '197304261997031003', 'user', '33531', 0),
(163, 'dina', '4c2260e5358fb0a52348fba497d3014d', 'Dina Andriana S.Pi', '198006172006042004', 'user', '33551', 0),
(164, 'pudyastuti', '9f14eb1082ab5f7bcb1e6f928a1cd071', 'PUDYASTUTI SAPTANINGSIH, SE', '196706141993022001', 'user', '33531', 0),
(165, 'dwiindri', 'd3acf7481ea04119db18d85ac0640720', 'Dwi Indriastuti Yulianingsih S.S', '198607022009122004', 'user', '33543', 0),
(166, 'hadi', '83a81e77ef8465b415ba937fef8fb52f', 'Hadi Lestiyono SST', '198607012010121003', 'user', '33511', 0),
(167, 'mira', 'bead3e9506154c5112a68d4d03fbfdc6', 'Mira Ayu Isnainy SST', '199003222013112001', 'user', '33523', 0),
(168, 'dwirahayu', 'ad93465d7f78e74d01aefc81627cb91c', 'IR DWI RAHAYU, MM', '196409021994032001', 'user', '33512', 0),
(169, 'adesandi', '174604e60ed5bd135b169335615e887b', 'Ade Sandi Parwoto SST.,MM', '197303291995121001', 'user', '33543', 4),
(170, 'dody', 'dacec304d60da48d6928fa20c060b321', 'Dody Saputro SST, M.Si.', '197909162000121003', 'user', '33531', 4),
(171, 'agita', '344bf09e003ba1b8a0ccc1441a992ab2', 'Dewi Agita Pradaningtyas SST', '199011182013112001', 'user', '33541', 0),
(172, 'dhinta', '3fa8000a33aee6242fc0c1cefb2ea106', 'Dhinta Mayasari SST', '198507242008012003', 'user', '33511', 0),
(174, 'laeli', '664d680add02c62d78dd491b8a473d3a', 'Laeli Sugiyono M.Si', '196304041987021001', 'user', '33550', 0),
(175, 'herry', 'cb9594b4a8c9147bf43fef7e329d18ef', 'Herry Kusmaiwanto S.Si', '197205242006041002', 'user', '33563', 0),
(176, 'tuti', '9c6605102f8f24676e28d2571effac0a', 'Tuti Dwijayanti SE', '198405192006042004', 'admin', '33513', 0),
(178, 'isnaini', 'eb9dbc99d325366de129c5782afe1fd6', 'Isnaini SST, M.M', '197406031994021002', 'admin', '33511', 4),
(179, 'suci', '87342fc035424b0d90c61eba3c7121dc', 'Suci Budi Utami SST', '197811262000122001', 'admin', '33513', 4),
(180, 'sentot', '1b3f9d3548730480a4ddee8a265c1430', 'Sentot Bangun Widoyono M.A.', '196109041983021001', 'admin', '33500', 2),
(181, 'iskandar', '02ed2b8e13722bd40c64b4a334d3ea01', 'Iskandar SST.,M.S.E', '197806072000121002', 'admin', '33531', 0),
(182, 'metriana', '990004e95e392042444c3063c1a31eed', 'Metriana Jovanika', '198909222012112001', 'admin', '33551', 0),
(183, 'arjuliwondo', 'f7483cd6d4c523de3997421e673a7fba', 'Arjuliwondo S.Si.', '196507221988021001', 'admin', '33540', 3),
(184, 'ekosuharto', '3933ac3978a91ba5c082986ca6724eac', 'Eko Suharto SST.,M.Si', '197706152000031002', 'admin', '33540', 0),
(186, 'suci', '87342fc035424b0d90c61eba3c7121dc', 'Suci Budi Utami SST', '197811262000122001', 'user', '33513', 4);

-- --------------------------------------------------------

--
-- Table structure for table `m_unitkerja`
--

CREATE TABLE IF NOT EXISTS `m_unitkerja` (
  `id_unitkerja` varchar(5) NOT NULL,
  `unitkerja` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_unitkerja`
--

INSERT INTO `m_unitkerja` (`id_unitkerja`, `unitkerja`) VALUES
('33500', 'BPS Provinsi'),
('33510', 'Bagian Tata Usaha'),
('33511', 'Subbag Bina Program'),
('33512', 'Subbag Kepegawaian'),
('33513', 'Subbag Keuangan'),
('33514', 'Subbagian Umum'),
('33515', 'Subbagian Pengadaan Barang/Jasa'),
('33520', 'Bidang Statistik Sosial'),
('33521', 'Seksi Statistik Kependudukan'),
('33522', 'Seksi Statistik Ketahanan Sosial'),
('33523', 'Seksi Statistik Kesejahteraan Rakyat'),
('33530', 'Bidang Statistik Produksi'),
('33531', 'Seksi Statistik Pertanian'),
('33532', 'Seksi Statistik Industri'),
('33533', 'Seksi Statistik Pertambangan Energi dan Konstruksi'),
('33540', 'Bidang Statistik Distribusi'),
('33541', 'Seksi Statistik HK dan HPB'),
('33542', 'Seksi Statistik Keuangan dan HP'),
('33543', 'Seksi Statistik Niaga Jasa'),
('33550', 'Bidang Neraca Wilayah dan Analisis'),
('33551', 'Seksi Neraca Produksi'),
('33552', 'Seksi Neraca Konsumsi'),
('33553', 'Seksi Analisis Statistik Lintas Sektor'),
('33560', 'Bidang Integrasi Pengolahan dan Diseminasi Statistik'),
('33561', 'Seksi Integrasi Pengolahan Data'),
('33562', 'Seksi Jaringan dan Rujukan Statistik'),
('33563', 'Seksi Diseminasi dan Layanan Statistik');

-- --------------------------------------------------------

--
-- Table structure for table `t_penerimaan_barang`
--

CREATE TABLE IF NOT EXISTS `t_penerimaan_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penerimaan` varchar(15) NOT NULL,
  `nip_pegawai` varchar(25) NOT NULL,
  `kode_jenisbarang` varchar(15) NOT NULL,
  `kode_subjenisbarang` varchar(6) NOT NULL,
  `tgl_diterima` date NOT NULL,
  `jumlah_penerimaan` int(11) NOT NULL,
  `sumber_penerimaan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_penerimaan_barang`
--

INSERT INTO `t_penerimaan_barang` (`id`, `id_penerimaan`, `nip_pegawai`, `kode_jenisbarang`, `kode_subjenisbarang`, `tgl_diterima`, `jumlah_penerimaan`, `sumber_penerimaan`) VALUES
(1, '2019-01-21-1', '19900326 201401 1 002', '1010302004', '000001', '2019-01-21', 5, 'beli'),
(2, '2019-01-21-1', '19900326 201401 1 002', '1010301001', '000001', '2019-01-21', 2, 'beli'),
(3, '2019-01-21-1', '19900326 201401 1 002', '1010301001', '000017', '2019-01-21', 7, 'beli');

-- --------------------------------------------------------

--
-- Table structure for table `t_permintaan_barang`
--

CREATE TABLE IF NOT EXISTS `t_permintaan_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permintaan` varchar(15) NOT NULL,
  `nip_pegawai` varchar(25) NOT NULL,
  `kode_jenisbarang` varchar(15) NOT NULL,
  `kode_subjenisbarang` varchar(6) NOT NULL,
  `jumlah_permintaan` int(11) NOT NULL,
  `nip_pegawai_menyerahkan` varchar(25) NOT NULL,
  `tgl_diserahkan` date NOT NULL,
  `tgl_permintaan` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `t_permintaan_barang`
--

INSERT INTO `t_permintaan_barang` (`id`, `id_permintaan`, `nip_pegawai`, `kode_jenisbarang`, `kode_subjenisbarang`, `jumlah_permintaan`, `nip_pegawai_menyerahkan`, `tgl_diserahkan`, `tgl_permintaan`) VALUES
(23, '2019-01-16-3', '198701042009122002', '1010301001', '000005', 5, '', '0000-00-00', '2019-01-16'),
(24, '2019-01-16-3', '198701042009122002', '1010301006', '000006', 4, '', '0000-00-00', '2019-01-16'),
(25, '2019-01-18-1', '198701042009122002', '1010301003', '000004', 2, '', '0000-00-00', '2019-01-18'),
(26, '2019-01-18-1', '198701042009122002', '1010305012', '000006', 1, '', '0000-00-00', '2019-01-18'),
(27, '2019-01-21-1', '198701042009122002', '1010301003', '000011', 2, '', '0000-00-00', '2019-01-21'),
(28, '2019-01-21-1', '198701042009122002', '1010301005', '000003', 5, '', '0000-00-00', '2019-01-21');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
