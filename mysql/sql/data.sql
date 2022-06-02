-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jan 14, 2022 at 03:30 PM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tdt`
--
CREATE DATABASE IF NOT EXISTS `tdt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `tdt`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `chucvu` varchar(255) NOT NULL,
  `phongban` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `gender` varchar(64) NOT NULL,
  `birthday` date DEFAULT NULL,
  `activated` bit(1) NOT NULL DEFAULT b'0',
  `salary` int(11) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `ngaynghi` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `name`, `chucvu`, `phongban`, `diachi`, `gender`, `birthday`, `activated`, `salary`, `email`, `avatar`, `phone`, `ngaynghi`) VALUES
(1, 'mvmanh', '$2y$10$8moRteF6C1XW.7WXqti1NuYxNnLvzc3/Iyinp8YV4aM4DuWSxvnj.', 'Mai Văn Mạnh', 'Giám đốc', '', 'Tp.Hồ Chí Minh', 'Nam', '2021-12-15', b'1', 0, 'manh@gmail.com', 'avatar.png', '2343254534', 0),
(40, 'minhman', '$2y$10$m3Brsh3oTcMUJau5rNxlP.ukRGIyP.DQRYBZnpSMnBdQQb.gmEaMK', 'Minh Mẫn', 'Nhân viên', 'Marketing', 'Hồ Chí Minh', 'Nam', '2021-11-30', b'0', 17, 'man@gmail.com', 'avatar.png', '3423545', 0),
(42, 'quocdat', '$2y$10$iAHS6zQauMm4RcB.rsfCUeHsk1hC8S4YRcmVqiAUaTSPV2iWaO1qm', 'Trần Quốc Đạt', 'Trưởng phòng', 'Kỹ thuật', 'Hồ Chí Minh', 'Nam', '2021-12-28', b'1', 14, 'dat@gmail.com', 'avatar.png', '143423454', 1),
(45, 'thanhvy', '$2y$10$eskuYQn9Mzqc0tXXmFpbVuRnF.q6igKoenV3nFNWX1ONtLs2V8qeO', 'Thanh Vy', 'Trưởng phòng', 'Marketing', 'Hồ Chí Minh', 'Nữ', '2021-12-21', b'1', 18, 'vy@gmail.com', 'avatar.png', '456464561', 0),
(50, 'thanhhien', '$2y$10$1xTnPxX0mpMlZULZkZD3z.ofRFNO3F/xQqyq11.zNCsR7dHDA/EB2', 'Thanh Hiền', 'Trưởng phòng', 'Kế toán', 'Hà Nội', 'Nữ', '2001-10-02', b'1', 18, 'hien123@gmail.com', 'avatar.png', '123456789', 0),
(58, 'manhquoc', '$2y$10$isilxGtsagGsmtv3F70tGO3.S5nsAezw.TMcZSIHkwW4nJ5QIAsHu', 'Mạnh Quốc', 'Nhân viên', 'Marketing', 'Hà Nội', 'Nam', '2021-11-29', b'1', 20, 'quoc@gmail.com', 'avatar.png', '0976324156', 0),
(59, 'thuthao', '$2y$10$.csIBnZAkpRenEo7hkA3euMgjrjkArpoea3jg1QT.UwxViUxmkEMy', 'Thu Thảo', 'Nhân viên', 'Kế toán', 'Hà Nội', 'Nữ', '2021-11-30', b'1', 16, 'thao@gmail.com', 'avatar.png', '1464654651561', 0),
(60, 'giabao', '$2y$10$mahXtFT1nFueqdOA83AgeeQ3PVpGQHO1/x5LEhdp2TPLxGUMz4UIG', 'Gia Bảo', 'Nhân viên', 'Kỹ thuật', 'Hà Nội', 'Nam', '2021-12-03', b'1', 29, 'bao@gmail.com', 'avatar.png', '1523645614531', 0),
(66, 'quocvinh', '$2y$10$vYCbm3vMhT1Eza9EmT52juIAHXDYcNyJO9YB6kCcnJoAwnJ9vkFdq', 'Quốc Vinh', 'Nhân viên', 'Kỹ thuật', 'Hồ Chí Minh', 'Nam', '2021-12-08', b'1', 10, 'vinh@gmail.com', 'avatar.png', '42342342351221', 0),
(67, 'kimchi', '$2y$10$CfinlzCbBtbJWXtQ8UJZV.Ts8VyeDEBaHhiyxyANw09PpI6vo6Pxu', 'Huỳnh Kim Chi', 'Nhân viên', 'Kế toán', 'Hồ Chí Minh', 'Nam', '2022-01-03', b'0', 11, 'chi@gmail.com', 'avatar.png', '2134324341221323', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nghiphep`
--

CREATE TABLE `nghiphep` (
  `ID` int(11) NOT NULL,
  `ID_Form` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `End_day` date DEFAULT NULL,
  `Reason` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `Status` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nghiphep`
--

INSERT INTO `nghiphep` (`ID`, `ID_Form`, `Date`, `End_day`, `Reason`, `Status`) VALUES
(42, 26, '2022-01-17', '2022-01-18', 'Bệnh', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `leader` varchar(255) DEFAULT NULL,
  `num_room` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `leader`, `num_room`, `description`) VALUES
(25, 'Kỹ thuật', 'Trần Quốc Đạt', 20, 'Phòng kỹ thuật'),
(27, 'Marketing', 'Thanh Vy', 15, 'Phòng Maketing'),
(29, 'Kế toán', 'Thanh Hiền', 11, 'Phòng Kế toán');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `start` date NOT NULL,
  `end` date DEFAULT NULL,
  `truongphong` varchar(255) NOT NULL,
  `nhanvien` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `status`, `deadline`, `start`, `end`, `truongphong`, `nhanvien`, `rating`, `description`, `file_description`) VALUES
(30, 'Sửa máy in', 'Completed', '2022-01-22', '2022-01-14', '2022-01-14', 'Mai Văn Mạnh', 'Trần Quốc Đạt', 'Good', 'Sửa máy in lầu 1', ''),
(31, 'Tổng kết lương tháng 1', 'New', '2022-01-26', '2022-01-14', NULL, 'Mai Văn Mạnh', 'Thanh Hiền', 'Chưa hoàn thành', 'Tổng kết lượng cho công ty', 'danhsachnhanvien.txt'),
(32, 'Ra mắt sản phẩm  X', 'New', '2022-01-18', '2022-01-14', NULL, 'Mai Văn Mạnh', 'Thanh Vy', 'Chưa hoàn thành', 'Lên kế hoạch ngày  cụ thể  ra mắt sản  phẩm', ''),
(33, 'Sửa laptop', 'New', '2022-01-21', '2022-01-14', NULL, 'Trần Quốc Đạt', 'Quốc Vinh', 'Chưa hoàn thành', 'Sửa lap top lầu2', '');

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `description` text,
  `attach` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_history`
--

INSERT INTO `task_history` (`id`, `number`, `sender`, `description`, `attach`, `time`) VALUES
(30, 89, 'Trần Quốc Đạt', 'Đã sửa xong           ', '', '2022-01-14 22:22:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `nghiphep`
--
ALTER TABLE `nghiphep`
  ADD PRIMARY KEY (`ID_Form`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `leader` (`leader`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
  ADD PRIMARY KEY (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `nghiphep`
--
ALTER TABLE `nghiphep`
  MODIFY `ID_Form` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
