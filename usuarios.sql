-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Ago-2025 às 22:51
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `streamline`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome_empresa` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `ramo_atuacao` varchar(100) NOT NULL,
  `quantidade_funcionarios` varchar(20) NOT NULL,
  `natureza_juridica` varchar(100) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_empresa`, `email`, `telefone`, `ramo_atuacao`, `quantidade_funcionarios`, `natureza_juridica`, `cnpj`, `senha`, `reset_token`, `reset_token_expire`) VALUES
(9, 'Relp!', 'relp123@outlook.com', '11-94031-4679', 'Atacado/Varejo', '1-5', 'LTDA', '49.447.734/0001-02', '12345678', NULL, NULL),
(10, 'gaby', 'gabyhatsunemiku@gmail.com', '11-94031-4567', 'Atacado/Varejo', '11-20', 'LTDA', '49.447.734/0001-22', '123#abc', NULL, NULL),
(11, 'ttt', 'ttt23@gmail.com', '121212121', 'Atacado/Varejo', '6-10', 'LTDA', '49.457.734/0001-02', '455667', NULL, NULL),
(12, 'hihi', 'hihi123@gmail.com', '11-96767-5644', 'Atacado/Varejo', '11-20', 'ltda', '82281119000144', '$2y$10$6ofchys8ByzoWMEBTJXaSOHQtPl0Nw7LcGvCIB7eJCS4Jyu/soXFK', NULL, NULL),
(13, 'paulo', 'paulo123@gmail.com', '11-96767-5655', 'Atacado/Varejo', '51+', 'ltda', '82281119000166', '$2y$10$6ToWHDKfamHSteoIKmBFpe1NnfB4L5TlCnMwP81TygJCC2Qiur/Iq', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
