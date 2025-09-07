-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/09/2025 às 01:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Cannabis');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `razao_social` varchar(255) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `razao_social`, `cnpj`, `email`, `telefone`, `senha`, `reset_token`, `reset_token_expire`) VALUES
(6, 'Goteira', '49447734000102', 'iarafontes@usp.br', '11947010600', '$2y$10$bKNB0Gi0cOiit82IGld38uSbsfP9AghfDOMyxXKd4Wr2/EoYwvWrG', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `especificacao` text DEFAULT NULL,
  `quantidade_estoque` int(11) NOT NULL DEFAULT 0,
  `quantidade_minima` int(11) NOT NULL DEFAULT 5,
  `valor_compra` decimal(10,2) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `fornecedor_id` int(11) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `especificacao`, `quantidade_estoque`, `quantidade_minima`, `valor_compra`, `valor_venda`, `categoria_id`, `fornecedor_id`, `data_cadastro`) VALUES
(2, 'Prensado de cinco', 'O prensado de cinco mais gostoso da região do goteira', 420, 24, 2.50, 5.00, 1, NULL, '2025-09-06 20:31:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
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
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_empresa`, `email`, `telefone`, `ramo_atuacao`, `quantidade_funcionarios`, `natureza_juridica`, `cnpj`, `senha`, `reset_token`, `reset_token_expire`) VALUES
(9, 'Relp!', 'relp123@outlook.com', '11-94031-4679', 'Atacado/Varejo', '1-5', 'LTDA', '49.447.734/0001-02', '12345678', NULL, NULL),
(10, 'gaby', 'gabyhatsunemiku@gmail.com', '11-94031-4567', 'Atacado/Varejo', '11-20', 'LTDA', '49.447.734/0001-22', '123#abc', NULL, NULL),
(11, 'ttt', 'ttt23@gmail.com', '121212121', 'Atacado/Varejo', '6-10', 'LTDA', '49.457.734/0001-02', '455667', NULL, NULL),
(12, 'hihi', 'hihi123@gmail.com', '11-96767-5644', 'Atacado/Varejo', '11-20', 'ltda', '82281119000144', '$2y$10$6ofchys8ByzoWMEBTJXaSOHQtPl0Nw7LcGvCIB7eJCS4Jyu/soXFK', NULL, NULL),
(13, 'paulo', 'paulo123@gmail.com', '11-96767-5655', 'Atacado/Varejo', '51+', 'ltda', '82281119000166', '$2y$10$6ToWHDKfamHSteoIKmBFpe1NnfB4L5TlCnMwP81TygJCC2Qiur/Iq', NULL, NULL),
(14, 'test', 'test@gmail.com', '11111111111', 'Beleza/Estética', '1-5', 'LTDA', '49447734000102', '$2y$10$0i.tsG6H3okzw7vNYkHTJOiFhpQp074My3PwDWcEqjmW1uS997d3S', NULL, NULL),
(15, 'cu', 'iarafontes@usp.br', '69', 'Beleza/Estética', '6-10', 'LTDA', '12345678901234', '$2y$10$mXM6WdKf8ti7rTgQBMXTo.YeDKYT9e1GI2HLxxh2Hw4BKgVFfIPxq', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnpj` (`cnpj`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produtos_categorias` (`categoria_id`),
  ADD KEY `fk_produtos_fornecedores` (`fornecedor_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produtos_fornecedores` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
