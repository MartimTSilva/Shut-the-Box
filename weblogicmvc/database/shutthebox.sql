-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 14-Jun-2019 às 16:17
-- Versão do servidor: 5.7.24
-- versão do PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gofish`
--
create database shutthebox;
use shutthebox;
-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_bin NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(125) COLLATE latin1_bin NOT NULL,
  `username` varchar(80) COLLATE latin1_bin NOT NULL,
  `password` varchar(256) COLLATE latin1_bin NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;


INSERT INTO `users` (`id`, `name`, `birthdate`, `email`, `username`, `password`, `blocked`, `admin`) VALUES
(1, 'admin', '2019-06-14', 'admin@mail.com', 'admin', '$2y$10$5gRa.27ajxO5bO7b8KjGAOLMK77V5xb8fGIH9ce4S2H/Xmu3W9HgS', 0, 1);
COMMIT;


--
-- Estrutura da tabela `classifications`
--

CREATE TABLE `classifications`
(
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int NOT NULL ,
 `points`  int NOT NULL ,
 `date`    datetime NOT NULL ,

PRIMARY KEY (`id`),
KEY `fkIdx_16` (`user_id`),
CONSTRAINT `FK_16` FOREIGN KEY `fkIdx_16` (`user_id`) REFERENCES `users` (`id`)
);