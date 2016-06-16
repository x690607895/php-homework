-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-05-19 09:42:11
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mem_mgr`
--
CREATE DATABASE IF NOT EXISTS `mem_mgr` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mem_mgr`;

-- --------------------------------------------------------

--
-- 表的结构 `m_user`
--

DROP TABLE IF EXISTS `m_user`;
CREATE TABLE IF NOT EXISTS `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `realname` varchar(50) NOT NULL,
  `sex` char(2) NOT NULL,
  `age` smallint(3) NOT NULL,
  `mobile` char(15) NOT NULL,
  `email` char(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `m_user`
--

INSERT INTO `m_user` (`id`, `username`, `password`, `realname`, `sex`, `age`, `mobile`, `email`, `address`, `create_time`, `update_time`, `status`) VALUES
(1, 'root', 'd41d8cd98f00b204e9800998ecf8427e', '张三', '男', 0, '', '', '', 1461208317, 1461208317, 1),
(2, 'abc', '0cc175b9c0f1b6a831c399e269772661', '', '男', 0, '', '', '', 1463639809, 1463639809, 1);

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_list`
--

DROP TABLE IF EXISTS `m_vote_list`;
CREATE TABLE IF NOT EXISTS `m_vote_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `creator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_option`
--

DROP TABLE IF EXISTS `m_vote_option`;
CREATE TABLE IF NOT EXISTS `m_vote_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_vote_result`
--

DROP TABLE IF EXISTS `m_vote_result`;
CREATE TABLE IF NOT EXISTS `m_vote_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `vote_time` int(10) NOT NULL,
  `num` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
