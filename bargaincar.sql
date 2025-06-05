-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Tempo de geração: 16/05/2025 às 01:32
-- Versão do servidor: 8.0.41
-- Versão do PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bargaincar`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--


-- Tabela para Marcas
CREATE TABLE `marcas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabela para Carros
CREATE TABLE `carros` (
  `carros_id` INT NOT NULL AUTO_INCREMENT,
  `carros_modelo` VARCHAR(255) NOT NULL,
  `carros_ano_fabricacao` INT NOT NULL,
  `carros_ano_modelo` INT NOT NULL,
  `carros_tipo_combustivel` VARCHAR(20) NOT NULL,
  `carros_placa` CHAR(8) NOT NULL UNIQUE,
  `carros_cor` VARCHAR(30) NOT NULL,
  `carros_quilometragem` INT NOT NULL,
  `carros_cambio` VARCHAR(20) NOT NULL,
  `carros_preco_venda` DECIMAL(10,2) NOT NULL,
  `carros_preco_fipe` DECIMAL(10,2) NOT NULL,
  `carros_status` VARCHAR(20) NOT NULL,
  `carros_data_cadastro` DATE NOT NULL,
  `marcas_id` INT NOT NULL,
  PRIMARY KEY (`carros_id`),
  FOREIGN KEY (`marcas_id`) REFERENCES `marcas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




CREATE TABLE `categorias` (
  `categorias_id` int NOT NULL,
  `categorias_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`categorias_id`, `categorias_nome`) VALUES
(1, 'Sedan'),
(2, 'Hath');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `cidades_id` int NOT NULL,
  `cidades_nome` varchar(255) NOT NULL,
  `cidades_uf` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`cidades_id`, `cidades_nome`, `cidades_uf`) VALUES
(1, 'Ceres', 'GO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `produtos_id` int NOT NULL,
  `produtos_nome` varchar(255) NOT NULL,
  `produtos_descricao` text NOT NULL,
  `produtos_preco_custo` float NOT NULL,
  `produtos_preco_venda` float NOT NULL,
  `produtos_categorias_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`produtos_id`, `produtos_nome`, `produtos_descricao`, `produtos_preco_custo`, `produtos_preco_venda`, `produtos_categorias_id`) VALUES
(1, 'Fiat Cronos', '1.4', 50, 70, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarios_id` int NOT NULL,
  `usuarios_nome` varchar(255) NOT NULL,
  `usuarios_sobrenome` varchar(255) NOT NULL,
  `usuarios_cpf` char(14) NOT NULL,
  `usuarios_email` varchar(255) NOT NULL,
  `usuarios_senha` char(32) NOT NULL,
  `usuarios_fone` varchar(15) NOT NULL,
  `usuarios_nivel` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`usuarios_id`, `usuarios_nome`, `usuarios_sobrenome`, `usuarios_cpf`, `usuarios_email`, `usuarios_senha`, `usuarios_fone`, `usuarios_nivel`) VALUES
(1, 'Vilson', 'Soares de Siqueira', '111.111.111-11', 'vilson@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '32 98541-5555', 1),
(2, 'admin', '', '999.999.999-99', 'admin@mail.com', 'e10adc3949ba59abbe56e057f20f883e', '99 99999-9999', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categorias_id`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidades_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produtos_id`),
  ADD KEY `fk_produtos_categoria` (`produtos_categorias_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categorias_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `cidades_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produtos_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarios_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produtos_categoria` FOREIGN KEY (`produtos_categorias_id`) REFERENCES `categorias` (`categorias_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
