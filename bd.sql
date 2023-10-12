-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11-Ago-2023 às 12:03
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `celke_web_socket`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mensagem` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `mensagem`, `usuario_id`) VALUES
(1, 'Olá Lucas Tandy', 1),
(2, 'Olá Lucas Teste', 2),
(3, 'Bom dia, Cesar,', 2),
(4, 'Bom dia, Kelly, tudo bem?', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_usuario` varchar(220) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha_usuario`) VALUES
(1, 'Lucas Tandy', 'lucastitandy@gmail.com', '$2y$10$6jYxGT3XPd9O98kTvubLheQaQRZPYQx/FdbICy/6TIF64KRIpDjta'),
(2, 'Lucas Teste', 'lucasteste@gmail.com', '$2y$10$M4dmDeNy1e4QkPAb3lZVPua23lPxAF8F.enNSvhk5lmJLCtpKBJN2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
