-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th4 21, 2023 lúc 05:19 AM
-- Phiên bản máy phục vụ: 10.3.38-MariaDB-0+deb10u1
-- Phiên bản PHP: 7.3.31-1~deb10u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cpms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `msgdate` text NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reserved-list`
--

CREATE TABLE `reserved-list` (
  `id` int(10) NOT NULL,
  `restime` varchar(10) NOT NULL,
  `slot` varchar(5) NOT NULL,
  `plate` varchar(10) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `charge` varchar(15) NOT NULL,
  `stats` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reserved-list`
--

INSERT INTO `reserved-list` (`id`, `restime`, `slot`, `plate`, `phone`, `charge`, `stats`) VALUES
(5, '2023-03-04', '0', '321', '00000', '0 VND', 0),
(6, '2023-01-10', '0', '66666', '00000', '480,000 VND', 0),
(7, '2023-05-05', '0', '9999', '00000', '1,680,000 VND', 0),
(8, '2023-06-07', 'A3', '55555', '00000', '480,000 VND', 0),
(9, '2023-01-26', 'A1', '44444', '00000', '180,000 VND', 0),
(10, '2023-03-16', 'A2', '00000', '00000', '300,000 VND', 0),
(11, '2023-03-16', 'A2', '00000', '00000', '300,000 VND', 0),
(12, '2023-03-25', 'A1', '11111', '00000', '300,000 VND', 0),
(13, '2023-03-26', 'A3', '11111', '00000', '300,000 VND', 0),
(14, '2023-03-27', 'A1', '00000', '00000', '300,000 VND', 0),
(15, '2023-03-28', 'A1', '00000', '00000', '5,000 VND', 0),
(16, '2023-03-28', 'A2', '11111', '00000', '5,000 VND', 0),
(17, '', '', '', '00000', '0 VND', 0),
(18, '2023-03-28', 'A2', '00000', '00000', '15,000 VND', 0),
(19, '2023-03-28', 'A3', '00000', '00000', '15,000 VND', 0),
(20, '2023-03-28', 'A1', '00002', '00001', '15,000 VND', 0),
(21, '2023-03-28', 'A2', '15A00001', '00000', '0 VND', 0),
(22, '2023-03-29', 'A1', '51B09865', '00000', '0 VND', 0),
(23, '2023-03-29', 'A1', '38A27230', '00000', '0 VND', 0),
(24, '2023-03-29', 'A2', '38A', '00000', '0 VND', 0),
(25, '2023-03-29', 'A3', '11111', '00000', '0 VND', 0),
(26, '2023-03-29', 'A2', '38A27230', '00000', '0 VND', 0),
(27, '2023-03-29', 'A1', '11111', '00000', '0 VND', 0),
(28, '2023-03-30', 'A1', '11111', '00000', '0 VND', 0),
(29, '2023-03-30', 'A1', '00002', '00000', '5,000 VND', 0),
(30, '2023-03-30', 'A1', '00002', '00000', '5,000 VND', 0),
(31, '2023-03-30', 'A1', '00002', '00000', '5,000 VND', 0),
(32, '2023-03-30', 'A1', '00004', '', '5,000 VND', 0),
(33, '2023-03-30', 'A1', '11111', '00000', '0 VND', 0),
(34, '2023-03-30', 'A1', '00000', '00000', '0 VND', 0),
(35, '2023-03-30', 'A1', '11111', '00000', '0 VND', 0),
(36, '2023-03-30', 'A2', '00002', '00000', '0 VND', 0),
(37, '2023-03-30', 'A1', '77777', '00000', '0 VND', 0),
(38, '2023-03-30', 'A1', '11111', '00000', '10,000 VND', 0),
(39, '2023-03-30', 'A3', '38A27230', '00000', '0 VND', 0),
(40, '2023-03-30', 'A1', '51F97022', '00000', '0 VND', 0),
(41, '2023-03-30', 'A1', '38A27230', '00000', '0 VND', 0),
(42, '2023-03-30', 'A1', '38A27203', '00000', '0 VND', 0),
(43, '2023-03-30', 'A2', '60A99999', '00000', '0 VND', 0),
(44, '2023-03-31', 'A1', '38A27203', '00000', '0 VND', 0),
(45, '2023-04-01', 'A1', '38A27203', '00000', '0 VND', 0),
(46, '2023-04-01', 'A1', '60A99999', '00000', '0 VND', 0),
(47, '2023-04-01', 'A2', '38A27203', '00000', '0 VND', 0),
(48, '2023-04-01', 'A1', '00000', '00000', '0 VND', 0),
(49, '2023-04-01', 'A1', '00000', '00000', '0 VND', 0),
(50, '2023-04-01', 'A3', '38A27203', '00000', '0 VND', 0),
(51, '2023-04-01', 'A2', '38A27203', '00000', '0 VND', 0),
(52, '2023-04-06', 'A2', '01B09865', '', '', 0),
(53, '2023-04-06', 'A3', '51B09865', '', '', 0),
(54, '2023-04-15', 'A3', '11B09865', '', '', 0),
(55, '2023-04-15', 'A1', '51B09865', '', '', 0),
(56, '2023-04-15', 'A2', '51B09809', '', '', 0),
(57, '2023-04-15', 'A1', '50A99999', '', '', 0),
(58, '2023-04-15', 'A1', '60A99999', '', '', 0),
(59, '2023-04-15', 'A2', '60A99999', '', '', 0),
(60, '2023-04-15', 'A2', '60A99999', '', '', 0),
(61, '2023-04-15', 'A2', '60A99998', '', '', 0),
(62, '2023-04-15', 'A1', '60A99999', '', '', 0),
(63, '2023-04-15', 'A1', '51B09864', '', '', 0),
(64, '2023-04-15', 'A3', '51B09868', '', '', 0),
(65, '2023-04-15', 'A3', '38A27203', '00000', '0 VND', 0),
(66, '2023-04-15', 'A1', '123', '012345', '0 VND', 0),
(67, '2023-04-15', 'A1', '51B09865', '', '', 0),
(68, '2023-04-15', 'A3', '60A99999', '', '', 0),
(69, '2023-04-15', 'A2', '60A99999', '', '', 0),
(70, '2023-04-16', 'A1', '51B09865', '00000', '0 VND', 0),
(71, '2023-04-16', 'A3', '60A99999', '', '', 0),
(72, '2023-04-16', 'A1', '60A99999', '', '', 0),
(73, '2023-04-16', 'A2', '51F97022', '', '', 0),
(74, '2023-04-16', 'A2', '51B09865', '00000', '0 VND', 0),
(75, '2023-04-16', 'A3', '60A99999', '', '', 0),
(76, '2023-04-16', 'A2', '11111', '00000', '0 VND', 0),
(77, '2023-04-16', 'A1', '1234', '00000', '0 VND', 0),
(78, '2023-04-16', 'A2', '38A27203', '00000', '0 VND', 0),
(79, '2023-04-16', 'A1', '11111', '00000', '0 VND', 0),
(80, '2023-04-16', 'A2', '00002', '00000', '0 VND', 0),
(81, '2023-04-16', 'A3', '60A99999', '', '', 0),
(82, '2023-04-17', 'A2', '60A99999', '', '', 0),
(86, '2023-04-17', 'A1', '60A99999', '', '3,226 VND', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL DEFAULT ' ',
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `id` int(11) NOT NULL,
  `access` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`username`, `email`, `phone`, `name`, `password`, `id`, `access`) VALUES
('admin', '', '012345', 'Adminstrator', '12345', 1, 0),
('a', 'adam@gmail.com', '00000', 'a dam', '0000', 13, 2),
('user', 'user1@gmail.com', '00001', 'user 1', '00001', 14, 2),
(' ', 'user2@gmail.com', '00002', 'user 2', '0000', 15, 2),
(' ', 'user3@gmail.com', '00003', 'user 3', '0000', 16, 2),
(' ', ' ', '543210', 'admin 1', '12345', 17, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `zones`
--

CREATE TABLE `zones` (
  `slot` text NOT NULL,
  `status` text NOT NULL,
  `plateno` text NOT NULL,
  `paynum` text NOT NULL,
  `timebegin` datetime DEFAULT NULL,
  `timeend` datetime DEFAULT NULL,
  `charge` text NOT NULL,
  `id` int(5) NOT NULL,
  `phone` text NOT NULL,
  `timein` datetime DEFAULT NULL,
  `timeout` datetime DEFAULT NULL,
  `pays` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reserved-list`
--
ALTER TABLE `reserved-list`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `zones`
--
ALTER TABLE `zones`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `reserved-list`
--
ALTER TABLE `reserved-list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT cho bảng `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
