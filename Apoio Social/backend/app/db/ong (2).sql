-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/08/2026 às 15:16
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
-- Banco de dados: `ong`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `campanha`
--

CREATE TABLE `campanha` (
  `id_campanha` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `meta_valor` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `doacao`
--

CREATE TABLE `doacao` (
  `id` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `id_doador` int(11) NOT NULL,
  `id_campanha` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `prazo_aarrecadar` int(11) NOT NULL,
  `localizacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `doacao`
--

INSERT INTO `doacao` (`id`, `preco`, `id_doador`, `id_campanha`, `descricao`, `prazo_aarrecadar`, `localizacao`) VALUES
(1, 5.00, 14, 2, 'A campanha Natal que Abraça tem como objetivo levar alegria, carinho e esperança para crianças e famílias em situação de vulnerabilidade durante o período natalino. Através da arrecadação de brinquedos, alimentos e presentes, buscamos proporcionar um Nata', 45, 'Sede da ONG Apoio Social – São Paulo, SP');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doadores`
--

CREATE TABLE `doadores` (
  `id_doador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `participacoes`
--

CREATE TABLE `participacoes` (
  `id` int(11) NOT NULL,
  `doador_id` int(11) NOT NULL,
  `doacao_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `tipo` enum('Volutário','Admistrador','','') NOT NULL DEFAULT 'Volutário',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `tipo`, `foto`) VALUES
(2, 'Vitor Santo', 'santovitor828@gmail.com', '744444447ry', '9912524875', '', NULL),
(3, 'Vitor Santo', 'santovitor828@gmail.com', '09908777', '67676767', '', NULL),
(4, 'Vitor Santo', 'santovitor828@gmail.com', 'Vitor@2008', '18 999999999', '', NULL),
(5, 'Vitor Santo', 'santovitor828@gmail.com', '434343', '9912524875', '', NULL),
(6, 'Vitor Santo', 'santovitor828@gmail.com', '9887766', '9912524875', '', NULL),
(7, 'Vitor Santo', 'santovitor828@gmail.com', 'fjhfhjfjhf', '54545454', '', NULL),
(8, 'Vitor Santo', 'santovitor828@gmail.com', 'fxgdfgdgh', '54545454', '', NULL),
(9, 'teste', 'teste@gmal.com', 'fsdsadsda', '54545454', '', NULL),
(10, 'teste1', 'teste1@gmail.com', 'vdfzdhsgh', '67676767', 'Admistrador', NULL),
(11, 'teste2', 'teste2@gmail.com', 'fffsdfgs', '874385346345', '', NULL),
(12, 'teste3', 'teste3@gmail.com', 'gfjjfgjge', '54545454', '', NULL),
(13, 'Vitor Santo', 'santovitor828@gmail.com', '32221222', '67676767', '', NULL),
(14, 'teste4', 'teste4@gmail.com', 'vdsfhgafgdjf', '67676767', '', NULL),
(15, 'teste4', 'teste4@gmail.com', 'vdsfhgafgdjf', '67676767', '', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `campanha`
--
ALTER TABLE `campanha`
  ADD PRIMARY KEY (`id_campanha`);

--
-- Índices de tabela `doacao`
--
ALTER TABLE `doacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `doadores`
--
ALTER TABLE `doadores`
  ADD PRIMARY KEY (`id_doador`);

--
-- Índices de tabela `participacoes`
--
ALTER TABLE `participacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campanha`
--
ALTER TABLE `campanha`
  MODIFY `id_campanha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `doacao`
--
ALTER TABLE `doacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `doadores`
--
ALTER TABLE `doadores`
  MODIFY `id_doador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `participacoes`
--
ALTER TABLE `participacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
