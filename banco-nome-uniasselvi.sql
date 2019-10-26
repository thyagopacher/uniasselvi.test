-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Out-2019 às 21:18
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `uniasselvi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `CodCliente` int(11) NOT NULL,
  `NomeCliente` varchar(100) NOT NULL,
  `CPF` char(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`CodCliente`, `NomeCliente`, `CPF`, `Email`, `Senha`) VALUES
(1, 'thyago henrique pacher', '05820810929', 'thyago.pacher@gmail.com', '6a4120be23c814f80233ecbb34e71adc'),
(17, 'sssssssss', '353534', 'eeee@ssss', 'fdea1593ad940821012f52fc0d5282f8');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itempedido`
--

CREATE TABLE `itempedido` (
  `CodItem` int(11) NOT NULL,
  `CodProduto` int(11) NOT NULL,
  `CodPedido` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `itempedido`
--

INSERT INTO `itempedido` (`CodItem`, `CodProduto`, `CodPedido`, `Quantidade`) VALUES
(12, 21, 2, 2),
(17, 1, 10, 3),
(18, 15, 10, 2),
(21, 1, 12, 4),
(22, 13, 12, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `NumPedido` int(11) NOT NULL,
  `DtPedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `CodCliente` int(11) NOT NULL,
  `PctDesconto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`NumPedido`, `DtPedido`, `CodCliente`, `PctDesconto`) VALUES
(2, '2019-10-26 14:46:53', 1, 5.53),
(10, '2019-10-26 18:24:25', 1, 0),
(12, '2019-10-26 19:18:02', 17, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `CodProduto` int(11) NOT NULL,
  `NomeProduto` varchar(100) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `CodBarras` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`CodProduto`, `NomeProduto`, `ValorUnitario`, `CodBarras`) VALUES
(1, 'produto 1', 20202.23, '3203202323'),
(3, 'produto 2', 343.43, '3r434'),
(4, 'produto 3', 2222.23, '2123123'),
(5, 'produto 4', 44444.44, '44444444444'),
(6, 'produto 5', 555555.55, '555555555555'),
(7, 'produto 6', 666666.66, '666666666'),
(12, 'produto 11', 8888, '888'),
(13, 'produto 12', 8888, '888'),
(14, 'produto 13', 8888, '888'),
(15, 'produto 14', 8888, '888'),
(16, 'produto 15', 8888, '888'),
(17, 'produto 16', 8888, '888'),
(18, 'produto 17', 8888, '888'),
(19, 'produto 18', 8888, '888'),
(20, 'produto 19', 8888, '888'),
(21, 'produto 20', 8888, '888'),
(22, 'fsafafasfa', 44454.54, 'eeee');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CodCliente`),
  ADD UNIQUE KEY `CPF` (`CPF`);

--
-- Índices para tabela `itempedido`
--
ALTER TABLE `itempedido`
  ADD PRIMARY KEY (`CodItem`),
  ADD KEY `CodPedido` (`CodPedido`),
  ADD KEY `CodProduto` (`CodProduto`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`NumPedido`),
  ADD KEY `CodCliente` (`CodCliente`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`CodProduto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `CodCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `itempedido`
--
ALTER TABLE `itempedido`
  MODIFY `CodItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `NumPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `CodProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `itempedido`
--
ALTER TABLE `itempedido`
  ADD CONSTRAINT `itempedido_ibfk_1` FOREIGN KEY (`CodPedido`) REFERENCES `pedido` (`NumPedido`),
  ADD CONSTRAINT `itempedido_ibfk_2` FOREIGN KEY (`CodProduto`) REFERENCES `produto` (`CodProduto`);

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`CodCliente`) REFERENCES `cliente` (`CodCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
