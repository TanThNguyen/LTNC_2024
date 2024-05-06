-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql203.infinityfree.com
-- Generation Time: May 06, 2024 at 01:08 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36322954_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `benhan`
--

CREATE TABLE `benhan` (
  `id` int(11) NOT NULL,
  `nv_id` int(11) NOT NULL,
  `bn_id` varchar(30) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `tenbenh` varchar(100) DEFAULT NULL,
  `phuongphapKT` varchar(100) DEFAULT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `benhnhan`
--

CREATE TABLE `benhnhan` (
  `id` varchar(30) NOT NULL,
  `ten` varchar(100) NOT NULL,
  `BaoHiem` varchar(20) NOT NULL,
  `ngaysinh` date DEFAULT NULL,
  `diachi` varchar(100) NOT NULL,
  `gioitinh` tinyint(1) NOT NULL DEFAULT 0,
  `SDT` varchar(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `benhnhan`
--

INSERT INTO `benhnhan` (`id`, `ten`, `BaoHiem`, `ngaysinh`, `diachi`, `gioitinh`, `SDT`, `status`, `update_at`) VALUES
('100001', 'Nguyễn Văn A', 'BH100001', '2004-04-27', 'Địa chỉ 1', 0, '0123456789', 1, '2024-05-06 12:51:39'),
('100002', 'Trần Thị B', 'BH100002', '2003-04-27', 'Địa chỉ 2', 1, '1123456789', 1, '2024-05-06 12:51:39'),
('100003', 'Lê Văn C', 'BH100003', '2002-04-27', 'Địa chỉ 3', 0, '2123456789', 1, '2024-05-06 12:51:39'),
('100004', 'Phạm Thị D', 'BH100004', '2001-04-27', 'Địa chỉ 4', 1, '3123456789', 1, '2024-05-06 12:51:39'),
('100005', 'Hoàng Văn E', 'BH100005', '2000-04-27', 'Địa chỉ 5', 0, '4123456789', 1, '2024-05-06 12:51:39'),
('100006', 'Vũ Thị F', 'BH100006', '1999-04-27', 'Địa chỉ 6', 1, '5123456789', 1, '2024-05-06 12:51:39'),
('100007', 'Đặng Văn G', 'BH100007', '1998-04-27', 'Địa chỉ 7', 0, '6123456789', 1, '2024-05-06 12:51:39'),
('100008', 'Bùi Thị H', 'BH100008', '1997-04-27', 'Địa chỉ 8', 1, '7123456789', 1, '2024-05-06 12:51:39'),
('100009', 'Ngô Văn I', 'BH100009', '1996-04-27', 'Địa chỉ 9', 0, '8123456789', 1, '2024-05-06 12:51:39'),
('100010', 'Mai Thị K', 'BH100010', '1995-04-27', 'Địa chỉ 10', 1, '9123456789', 1, '2024-05-06 12:51:39'),
('100011', 'Đinh Văn L', 'BH100011', '1994-04-27', 'Địa chỉ 11', 0, '0123456780', 1, '2024-05-06 12:51:39'),
('100012', 'Lý Thị M', 'BH100012', '1993-04-27', 'Địa chỉ 12', 1, '0123456781', 1, '2024-05-06 12:51:39'),
('100013', 'Trương Văn N', 'BH100013', '1992-04-27', 'Địa chỉ 13', 0, '0123456782', 1, '2024-05-06 12:51:39'),
('100014', 'Võ Thị O', 'BH100014', '1991-04-27', 'Địa chỉ 14', 1, '0123456783', 1, '2024-05-06 12:51:39'),
('100015', 'Hồ Văn P', 'BH100015', '1990-04-27', 'Địa chỉ 15', 0, '0123456784', 1, '2024-05-06 12:51:39'),
('100016', 'Phan Thị Q', 'BH100016', '1989-04-27', 'Địa chỉ 16', 1, '0123456785', 1, '2024-05-06 12:51:39'),
('100017', 'Vương Văn R', 'BH100017', '1988-04-27', 'Địa chỉ 17', 0, '0123456786', 1, '2024-05-06 12:51:39'),
('100018', 'Trịnh Thị S', 'BH100018', '1987-04-27', 'Địa chỉ 18', 1, '0123456787', 1, '2024-05-06 12:51:39'),
('100019', 'Đỗ Văn T', 'BH100019', '1986-04-27', 'Địa chỉ 19', 0, '0123456788', 1, '2024-05-06 12:51:39'),
('100020', 'Hoàng Thị U', 'BH100020', '1985-04-27', 'Địa chỉ 20', 1, '0123456789', 1, '2024-05-06 12:51:39'),
('100021', 'Nguyễn Văn V', 'BH100021', '1984-04-27', 'Địa chỉ 21', 0, '1123456789', 1, '2024-05-06 12:51:39'),
('100022', 'Lê Thị X', 'BH100022', '1983-04-27', 'Địa chỉ 22', 1, '2123456789', 1, '2024-05-06 12:51:39'),
('100023', 'Trần Văn Y', 'BH100023', '1982-04-27', 'Địa chỉ 23', 0, '3123456789', 1, '2024-05-06 12:51:39'),
('100024', 'Phạm Thị Z', 'BH100024', '1981-04-27', 'Địa chỉ 24', 1, '4123456789', 1, '2024-05-06 12:51:39'),
('100025', 'Hoàng Văn A1', 'BH100025', '1980-04-27', 'Địa chỉ 25', 0, '5123456789', 1, '2024-05-06 12:51:39'),
('100026', 'Vũ Thị B1', 'BH100026', '1979-04-27', 'Địa chỉ 26', 1, '6123456789', 1, '2024-05-06 12:51:39'),
('100027', 'Đặng Văn C1', 'BH100027', '1978-04-27', 'Địa chỉ 27', 0, '7123456789', 1, '2024-05-06 12:51:39'),
('100028', 'Nguyễn Thị D1', 'BH100028', '1977-04-27', 'Địa chỉ 28', 1, '8123456789', 1, '2024-05-06 12:51:39'),
('100029', 'Trần Văn E1', 'BH100029', '1976-04-27', 'Địa chỉ 29', 0, '0123456780', 1, '2024-05-06 12:51:39'),
('100030', 'Phạm Thị F1', 'BH100030', '1975-04-27', 'Địa chỉ 30', 1, '0123456781', 1, '2024-05-06 12:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `chamsoc`
--

CREATE TABLE `chamsoc` (
  `id` int(11) NOT NULL,
  `nv_id` int(11) NOT NULL,
  `bn_id` varchar(30) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donthuoc`
--

CREATE TABLE `donthuoc` (
  `id` int(20) NOT NULL,
  `nv_id` int(11) NOT NULL,
  `bn_id` varchar(30) NOT NULL,
  `ba_id` varchar(10) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `chiphidieutri` int(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `donthuoc_thuoc`
--

CREATE TABLE `donthuoc_thuoc` (
  `donthuoc_id` int(20) NOT NULL,
  `tenthuoc` varchar(100) NOT NULL,
  `soluong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `khothuoc`
--

CREATE TABLE `khothuoc` (
  `id` varchar(50) NOT NULL,
  `ten` varchar(100) NOT NULL,
  `TacDung` varchar(200) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 0,
  `gia` int(11) DEFAULT NULL,
  `ql_id` int(11) NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khothuoc`
--

INSERT INTO `khothuoc` (`id`, `ten`, `TacDung`, `soluong`, `gia`, `ql_id`, `update_at`) VALUES
('100001', 'Paracetamol', 'Giảm đau, hạ sốt', 13611, 3809, 100004, '2024-05-06 12:56:48'),
('100002', 'Amoxicillin', 'Kháng sinh', 12370, 493, 100004, '2024-05-06 12:56:48'),
('100003', 'Omeprazole', 'Điều trị bệnh loét dạ dày', 12125, 4953, 100002, '2024-05-06 12:56:48'),
('100004', 'Atorvastatin', 'Giảm cholesterol', 16008, 397, 100003, '2024-05-06 12:56:48'),
('100005', 'Captopril', 'Giảm huyết áp', 13239, 669, 100004, '2024-05-06 12:56:48'),
('100006', 'Ibuprofen', 'Giảm đau, hạ sốt', 16957, 3296, 100002, '2024-05-06 12:56:48'),
('100007', 'Loratadine', 'Giảm triệu chứng dị ứng', 19114, 276, 100004, '2024-05-06 12:56:48'),
('100008', 'Diazepam', 'Giảm lo âu và căng thẳng', 11206, 1404, 100006, '2024-05-06 12:56:48'),
('100009', 'Metformin', 'Điều trị tiểu đường', 10469, 1704, 100004, '2024-05-06 12:56:48'),
('100010', 'Warfarin', 'Chống đông máu', 14969, 4987, 100004, '2024-05-06 12:56:48'),
('100011', 'Aspirin', 'Giảm đau và viêm', 14849, 4701, 100004, '2024-05-06 12:56:48'),
('100012', 'Cetirizine', 'Giảm triệu chứng dị ứng', 13795, 981, 100006, '2024-05-06 12:56:48'),
('100013', 'Simvastatin', 'Giảm cholesterol', 12651, 310, 100005, '2024-05-06 12:56:48'),
('100014', 'Losartan', 'Giảm huyết áp', 19678, 2945, 100003, '2024-05-06 12:56:48'),
('100015', 'Metoprolol', 'Giảm huyết áp và nhịp tim', 12592, 1548, 100006, '2024-05-06 12:56:48'),
('100016', 'Alprazolam', 'Giảm lo âu và căng thẳng', 16120, 4809, 100008, '2024-05-06 12:56:48'),
('100017', 'Atenolol', 'Giảm huyết áp và nhịp tim', 19597, 4475, 100006, '2024-05-06 12:56:48'),
('100018', 'Lisinopril', 'Giảm huyết áp', 12460, 2431, 100007, '2024-05-06 12:56:48'),
('100019', 'Levothyroxine', 'Thay thế hoocmon giáp tử cung', 17740, 4751, 100006, '2024-05-06 12:56:48'),
('100020', 'Prednisone', 'Giảm viêm và triệu chứng dị ứng', 12725, 543, 100007, '2024-05-06 12:56:48'),
('100021', 'Montelukast', 'Giảm triệu chứng hen suyễn', 19018, 3065, 100006, '2024-05-06 12:56:48'),
('100022', 'Duloxetine', 'Điều trị trầm cảm và đau cơ', 17854, 4837, 100007, '2024-05-06 12:56:48'),
('100023', 'Tramadol', 'Giảm đau cấp tính và mạn tính', 14843, 4956, 100007, '2024-05-06 12:56:48'),
('100024', 'Sertraline', 'Điều trị trầm cảm, rối loạn áp-xe', 15344, 922, 100006, '2024-05-06 12:56:48'),
('100025', 'Citalopram', 'Điều trị trầm cảm và rối loạn áp-xe', 16751, 3374, 100006, '2024-05-06 12:56:48'),
('100026', 'Fluoxetine', 'Điều trị trầm cảm và rối loạn lo âu', 15752, 4649, 100009, '2024-05-06 12:56:48'),
('100027', 'Venlafaxine', 'Điều trị trầm cảm và rối loạn lo âu', 17922, 1152, 100008, '2024-05-06 12:56:48'),
('100028', 'Bupropion', 'Giảm trọng lượng và điều trị trầm cảm', 18440, 720, 100005, '2024-05-06 12:56:48'),
('100029', 'Mirtazapine', 'Điều trị trầm cảm', 11254, 1688, 100006, '2024-05-06 12:56:48'),
('100030', 'Quetiapine', 'Điều trị rối loạn tâm thần', 12485, 2599, 100009, '2024-05-06 12:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `lothuoc`
--

CREATE TABLE `lothuoc` (
  `id` int(11) NOT NULL,
  `thuoc_id` varchar(50) NOT NULL,
  `nhaphanphoi` varchar(200) NOT NULL,
  `NSX` date NOT NULL,
  `HSD` date NOT NULL,
  `soluong` int(11) NOT NULL,
  `gia` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lothuoc`
--

INSERT INTO `lothuoc` (`id`, `thuoc_id`, `nhaphanphoi`, `NSX`, `HSD`, `soluong`, `gia`) VALUES
(26, 't10001', 'DEF', '2023-12-02', '2025-12-12', 300, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `ten` varchar(100) DEFAULT NULL,
  `CCCD` varchar(12) NOT NULL,
  `ngaysinh` date DEFAULT NULL,
  `diachi` varchar(100) DEFAULT NULL,
  `gioitinh` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(100) DEFAULT NULL,
  `SDT` varchar(10) DEFAULT NULL,
  `chuyenmon` varchar(30) DEFAULT NULL,
  `ngayvaolam` date DEFAULT NULL,
  `luong` int(20) DEFAULT NULL,
  `update_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `ten`, `CCCD`, `ngaysinh`, `diachi`, `gioitinh`, `email`, `SDT`, `chuyenmon`, `ngayvaolam`, `luong`, `update_at`, `status`) VALUES
(100001, 'Nguyễn Văn A', '123456789012', '2004-04-27', 'Địa chỉ 1', 0, 'email1@example.com', '0123456789', 'Bác sĩ', '2022-04-27', 25000000, '2024-05-06 12:45:26', 1),
(100002, 'Trần Thị B', '123456789013', '2003-04-27', 'Địa chỉ 2', 1, 'email2@example.com', '0123456788', 'Y tá', '2022-04-27', 30000000, '2024-05-06 12:45:26', 1),
(100003, 'Lê Văn C', '123456789014', '2002-04-27', 'Địa chỉ 3', 0, 'email3@example.com', '0123456787', 'Bác sĩ', '2022-04-27', 35000000, '2024-05-06 12:45:26', 1),
(100004, 'Phạm Thị D', '123456789015', '2001-04-27', 'Địa chỉ 4', 1, 'email4@example.com', '0123456786', 'Y tá', '2022-04-27', 40000000, '2024-05-06 12:45:26', 1),
(100005, 'Hoàng Văn E', '123456789016', '2000-04-27', 'Địa chỉ 5', 0, 'email5@example.com', '0123456785', 'Bác sĩ', '2022-04-27', 45000000, '2024-05-06 12:45:26', 1),
(100006, 'Vũ Thị F', '123456789017', '1999-04-27', 'Địa chỉ 6', 1, 'email6@example.com', '0123456784', 'Y tá', '2022-04-27', 50000000, '2024-05-06 12:45:26', 1),
(100007, 'Đặng Văn G', '123456789018', '1998-04-27', 'Địa chỉ 7', 0, 'email7@example.com', '0123456783', 'Bác sĩ', '2022-04-27', 15000000, '2024-05-06 12:45:26', 1),
(100008, 'Bùi Thị H', '123456789019', '1997-04-27', 'Địa chỉ 8', 1, 'email8@example.com', '0123456782', 'Y tá', '2022-04-27', 20000000, '2024-05-06 12:45:26', 1),
(100009, 'Ngô Văn I', '123456789020', '1996-04-27', 'Địa chỉ 9', 0, 'email9@example.com', '0123456781', 'Bác sĩ', '2022-04-27', 25000000, '2024-05-06 12:45:26', 1),
(100010, 'Mai Thị K', '123456789021', '1995-04-27', 'Địa chỉ 10', 1, 'email10@example.com', '0123456780', 'Y tá', '2022-04-27', 30000000, '2024-05-06 12:45:26', 1),
(100011, 'Đinh Văn L', '123456789022', '1994-04-27', 'Địa chỉ 11', 0, 'email11@example.com', '0123456779', 'Bác sĩ', '2022-04-27', 35000000, '2024-05-06 12:45:26', 1),
(100012, 'Lý Thị M', '123456789023', '1993-04-27', 'Địa chỉ 12', 1, 'email12@example.com', '0123456778', 'Y tá', '2022-04-27', 40000000, '2024-05-06 12:45:26', 1),
(100013, 'Trương Văn N', '123456789024', '1992-04-27', 'Địa chỉ 13', 0, 'email13@example.com', '0123456777', 'Bác sĩ', '2022-04-27', 45000000, '2024-05-06 12:45:26', 1),
(100014, 'Võ Thị O', '123456789025', '1991-04-27', 'Địa chỉ 14', 1, 'email14@example.com', '0123456776', 'Y tá', '2022-04-27', 50000000, '2024-05-06 12:45:26', 1),
(100015, 'Hồ Văn P', '123456789026', '1990-04-27', 'Địa chỉ 15', 0, 'email15@example.com', '0123456775', 'Bác sĩ', '2022-04-27', 15000000, '2024-05-06 12:45:26', 1),
(100016, 'Phan Thị Q', '123456789027', '1989-04-27', 'Địa chỉ 16', 1, 'email16@example.com', '0123456774', 'Y tá', '2022-04-27', 20000000, '2024-05-06 12:45:26', 1),
(100017, 'Vương Văn R', '123456789028', '1988-04-27', 'Địa chỉ 17', 0, 'email17@example.com', '0123456773', 'Bác sĩ', '2022-04-27', 25000000, '2024-05-06 12:45:26', 1),
(100018, 'Trịnh Thị S', '123456789029', '1987-04-27', 'Địa chỉ 18', 1, 'email18@example.com', '0123456772', 'Y tá', '2022-04-27', 30000000, '2024-05-06 12:45:26', 1),
(100019, 'Đỗ Văn T', '123456789030', '1986-04-27', 'Địa chỉ 19', 0, 'email19@example.com', '0123456771', 'Bác sĩ', '2022-04-27', 35000000, '2024-05-06 12:45:26', 1),
(100020, 'Hoàng Thị U', '123456789031', '1985-04-27', 'Địa chỉ 20', 1, 'email20@example.com', '0123456770', 'Y tá', '2022-04-27', 40000000, '2024-05-06 12:45:26', 1),
(100021, 'Nguyễn Văn V', '123456789032', '1984-04-27', 'Địa chỉ 21', 0, 'email21@example.com', '0123456769', 'Bác sĩ', '2022-04-27', 45000000, '2024-05-06 12:45:26', 1),
(100022, 'Lê Thị X', '123456789033', '1983-04-27', 'Địa chỉ 22', 1, 'email22@example.com', '0123456768', 'Y tá', '2022-04-27', 50000000, '2024-05-06 12:45:26', 1),
(100023, 'Trần Văn Y', '123456789034', '1982-04-27', 'Địa chỉ 23', 0, 'email23@example.com', '0123456767', 'Bác sĩ', '2022-04-27', 15000000, '2024-05-06 12:45:26', 1),
(100024, 'Phạm Thị Z', '123456789035', '1981-04-27', 'Địa chỉ 24', 1, 'email24@example.com', '0123456766', 'Y tá', '2022-04-27', 20000000, '2024-05-06 12:45:26', 1),
(100025, 'Hoàng Văn A1', '123456789036', '1980-04-27', 'Địa chỉ 25', 0, 'email25@example.com', '0123456765', 'Bác sĩ', '2022-04-27', 25000000, '2024-05-06 12:45:26', 1),
(100026, 'Vũ Thị B1', '123456789037', '1979-04-27', 'Địa chỉ 26', 1, 'email26@example.com', '0123456764', 'Y tá', '2022-04-27', 30000000, '2024-05-06 12:45:26', 1),
(100027, 'Đặng Văn C1', '123456789038', '1978-04-27', 'Địa chỉ 27', 0, 'email27@example.com', '0123456763', 'Bác sĩ', '2022-04-27', 35000000, '2024-05-06 12:45:26', 1),
(100028, 'Nguyễn Thị D1', '123456789039', '1977-04-27', 'Địa chỉ 28', 1, 'email28@example.com', '0123456762', 'Y tá', '2022-04-27', 40000000, '2024-05-06 12:45:26', 1),
(100029, 'Trần Văn E1', '123456789040', '1976-04-27', 'Địa chỉ 29', 0, 'email29@example.com', '0123456761', 'Bác sĩ', '2022-04-27', 45000000, '2024-05-06 12:45:26', 1),
(100030, 'Phạm Thị F1', '123456789041', '1975-04-27', 'Địa chỉ 30', 1, 'email30@example.com', '0123456760', 'Y tá', '2022-04-27', 50000000, '2024-05-06 12:45:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokenlogin`
--

CREATE TABLE `tokenlogin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tokenlogin`
--

INSERT INTO `tokenlogin` (`id`, `user_id`, `token`, `create_at`) VALUES
(163, 24, 'c0c0af6765b0fae4e886d8bb8bccf64185c02e21', '2024-05-06 22:22:13'),
(168, 24, '6c1102c200497b6816a85cee16ae4bcb3619b27b', '2024-05-06 23:13:21'),
(169, 24, 'd6b8a60b3bfc37aa78ae6271faf143eba6f153ab', '2024-05-06 23:25:38'),
(171, 24, '11687c946bf505f37264540150a9fab729ee90d2', '2024-05-07 00:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `forgotToken` varchar(100) DEFAULT NULL,
  `activeToken` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `forgotToken`, `activeToken`, `status`, `create_at`, `update_at`) VALUES
(24, 'Hunggg', 'abcde@gmail.com', '0123456789', '$2y$10$.90LS17.HKtdgZC0zo5/EuQ2DqiP1LKYYnWM3X6RdF5y/M2PwDElu', NULL, NULL, 1, '2024-04-07 09:41:18', '2024-04-07 09:41:18'),
(25, 'Hải Trung Nguyễn', 'danisnguyen124@gmail.com', '0379117326', '$2y$10$lANhbbtvRDT5Ue3tmcxVBurzdFHan30SnWCKiPHvLOGXnAe04M3j6', 'd3a7662e89b8d44c307c821607772f6d622ef0ce', NULL, 1, '2024-04-23 19:50:58', '2024-04-23 19:50:58'),
(45, 'Hải Trung Nguyễn', 'danisnguyen12dsadas4@gmail.com', '0379117326', '$2y$10$cXy5gQyPCnuJseOpA7QKpe7/h4i9JXiaKHBtBiJL1GwjlqE9AmC3q', NULL, '0890fbd92d8cf87b2cee50c10e5becbb67582cb7', 0, '2024-05-06 13:47:22', '2024-05-06 13:47:22'),
(47, 'Nguyễn Thanh T&acirc;n', '00000@gmail.com', '0123456789', '$2y$10$Z7K/q5VDB3SfeFWulqh0Ne3SpgNnCNWEEWo6tXr59cTFvjMjI2OEy', NULL, NULL, 1, '2024-05-06 23:58:04', '2024-05-06 23:58:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `benhan`
--
ALTER TABLE `benhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nv_id` (`nv_id`);

--
-- Indexes for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CCCD` (`BaoHiem`);

--
-- Indexes for table `chamsoc`
--
ALTER TABLE `chamsoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nv_id` (`nv_id`),
  ADD KEY `bn_id` (`bn_id`);

--
-- Indexes for table `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nv_id` (`nv_id`),
  ADD KEY `bn_id` (`bn_id`);

--
-- Indexes for table `donthuoc_thuoc`
--
ALTER TABLE `donthuoc_thuoc`
  ADD PRIMARY KEY (`donthuoc_id`,`tenthuoc`),
  ADD KEY `fk_tenthuoc` (`tenthuoc`);

--
-- Indexes for table `khothuoc`
--
ALTER TABLE `khothuoc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten` (`ten`);

--
-- Indexes for table `lothuoc`
--
ALTER TABLE `lothuoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thuoc_id` (`thuoc_id`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CCCD` (`CCCD`);

--
-- Indexes for table `tokenlogin`
--
ALTER TABLE `tokenlogin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `benhan`
--
ALTER TABLE `benhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `donthuoc`
--
ALTER TABLE `donthuoc`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lothuoc`
--
ALTER TABLE `lothuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tokenlogin`
--
ALTER TABLE `tokenlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `benhan`
--
ALTER TABLE `benhan`
  ADD CONSTRAINT `benhan_ibfk_1` FOREIGN KEY (`nv_id`) REFERENCES `nhanvien` (`id`);

--
-- Constraints for table `chamsoc`
--
ALTER TABLE `chamsoc`
  ADD CONSTRAINT `chamsoc_ibfk_1` FOREIGN KEY (`nv_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `chamsoc_ibfk_2` FOREIGN KEY (`bn_id`) REFERENCES `benhnhan` (`id`);

--
-- Constraints for table `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD CONSTRAINT `donthuoc_ibfk_1` FOREIGN KEY (`nv_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `donthuoc_ibfk_2` FOREIGN KEY (`bn_id`) REFERENCES `benhnhan` (`id`);

--
-- Constraints for table `donthuoc_thuoc`
--
ALTER TABLE `donthuoc_thuoc`
  ADD CONSTRAINT `fk_tenthuoc` FOREIGN KEY (`tenthuoc`) REFERENCES `khothuoc` (`ten`);

--
-- Constraints for table `lothuoc`
--
ALTER TABLE `lothuoc`
  ADD CONSTRAINT `lothuoc_ibfk_2` FOREIGN KEY (`thuoc_id`) REFERENCES `khothuoc` (`id`);

--
-- Constraints for table `tokenlogin`
--
ALTER TABLE `tokenlogin`
  ADD CONSTRAINT `tokenlogin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
