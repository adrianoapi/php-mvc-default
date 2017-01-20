-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Jan-2017 às 20:32
-- Versão do servidor: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab_mvc_default`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `noticia_id` int(11) NOT NULL,
  `noticia_data` datetime DEFAULT '0000-00-00 00:00:00',
  `noticia_autor` varchar(255) DEFAULT NULL,
  `noticia_titulo` varchar(255) DEFAULT NULL,
  `noticia_texto` text,
  `noticia_imagem` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`noticia_id`, `noticia_data`, `noticia_autor`, `noticia_titulo`, `noticia_texto`, `noticia_imagem`) VALUES
(5, NULL, 'Admin', '222', '', '758941239298256jpg_1220174774.jpg'),
(2, '2017-01-12 00:00:00', 'Admin', 'nova notícia', 'programação php', 'vagaphp1jpg_1883211179.jpg'),
(4, '2017-01-12 13:52:00', 'Admin', 'novo arquio', 'foto para upload', '102978122jpg_2075983969.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_session_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_permissions` longtext COLLATE utf8_bin
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `user`, `user_password`, `user_name`, `user_session_id`, `user_permissions`) VALUES
(2, 'guest', '$2a$08$PD.b2dsykLxcbiwsPWh6qu7p.rJEpRkPGfIHUxpfdnA1hfZeY4Ct6', 'guest', '5aac236f44eb14e8efd2f4ee7a5c6365', 'a:1:{i:0;s:13:"user-register";}'),
(3, 'teste', '$2a$08$82H18pYQrgputd40W59cqeIYz2ksSYX7CjyVoNj4u8UbToaFc4WqO', 'teste 2', 'ekttd27qevpod8ignmegib2gm5', 'a:1:{i:0;s:13:"user-register";}'),
(4, 'adriano', '$2a$08$CIEJahSf.TAxXU0tF1KVi.VwzOtHv37BElMbWN.RNdgm7cpcKoZMW', 'adriano', 'pm74c8d6rjkr41ueg38mvc8t53', 'a:2:{i:0;s:13:"user-register";i:1;s:18:"gerenciar-noticias";}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`noticia_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `noticia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
