-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-23 10:01:46
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mem_mgr`
--
CREATE DATABASE IF NOT EXISTS `mem_mgr1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mem_mgr1`;

-- --------------------------------------------------------

--
-- 表的结构 `m_user`
--

CREATE TABLE `m_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(3) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `create_time` varchar(30) NOT NULL,
  `update_time` varchar(30) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `m_user`
--

INSERT INTO `m_user` (`id`, `username`, `password`, `realname`, `age`, `sex`, `mobile`, `email`, `address`, `create_time`, `update_time`, `status`) VALUES
(29, 'abc', '202cb962ac59075b964b07152d234b70', 'abc', 15, '女', '10000000000', 'abc@abc.com', 'abc', '2016-04-27 14:17:38', '2016-05-14 07:59:20', 1)

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_list`
--

CREATE TABLE `m_vote_list` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `m_vote_list`
--

INSERT INTO `m_vote_list` (`id`, `title`, `create_time`, `update_time`, `creator_id`) VALUES
(1, 'test', 1463196030, 1463196030, 29),
(2, 'test2', 1463196030, 1463196030, 29),
(3, 'test3', 1463196030, 1463196030, 29);

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_option`
--

CREATE TABLE `m_vote_option` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `m_vote_option`
--

INSERT INTO `m_vote_option` (`id`, `name`, `pid`) VALUES
(1, 'test1', 1),
(2, 'test2', 1),
(3, 'test2', 2),
(4, 'test 3', 3);

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_result`
--

CREATE TABLE `m_vote_result` (
  `id` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `vote_time` int(10) NOT NULL,
  `num` int(10) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `m_vote_result`
--

INSERT INTO `m_vote_result` (`id`, `ip`, `vote_time`, `num`, `item_id`) VALUES
(1, '192.168.1.1', 1463196030, 1, 1),
(2, '192.168.1.2', 1463196030, 1, 2),
(3, '192.168.1.3', 1463196030, 1, 2),
(5, '192.168.1.4', 1463196030, 2, 2),
(6, '192.168.1.1', 1000000000, 1, 3),
(7, '192.168.1.1', 1000000000, 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_vote_list`
--
ALTER TABLE `m_vote_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `m_vote_option`
--
ALTER TABLE `m_vote_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `m_vote_result`
--
ALTER TABLE `m_vote_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `m_user`
--
ALTER TABLE `m_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=817;
--
-- 使用表AUTO_INCREMENT `m_vote_list`
--
ALTER TABLE `m_vote_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `m_vote_option`
--
ALTER TABLE `m_vote_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `m_vote_result`
--
ALTER TABLE `m_vote_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 限制导出的表
--

--
-- 限制表 `m_vote_list`
--
ALTER TABLE `m_vote_list`
  ADD CONSTRAINT `m_vote_list_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `m_user` (`id`);

--
-- 限制表 `m_vote_option`
--
ALTER TABLE `m_vote_option`
  ADD CONSTRAINT `m_vote_option_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `m_vote_list` (`id`);

--
-- 限制表 `m_vote_result`
--
ALTER TABLE `m_vote_result`
  ADD CONSTRAINT `m_vote_result_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `m_vote_option` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
