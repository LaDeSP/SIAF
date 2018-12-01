-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14-Set-2017 às 05:52
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE USER if not EXISTS 'siaf'@'%' IDENTIFIED BY '123456';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'siaf'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tcc`
--

 CREATE Database IF NOT EXISTS `siaf`;
 USE `siaf` ;
-- --------------------------------------------------------
--
-- Estrutura da tabela `despesas`
--

CREATE TABLE IF NOT EXISTS `despesas` (
  `id` int(10) NOT NULL,
  `nome_despesa` varchar(30) DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `data` date NOT NULL,
  `proprietarios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `despesas`
--

INSERT INTO `despesas` (`id`, `nome_despesa`, `descricao`, `quantidade`, `valor`, `data`, `proprietarios_id`) VALUES
(8, 'Luz', '', 1, 350, '2017-07-10', 7),
(10, 'Água', '', 1, 240, '2017-07-10', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(2) NOT NULL,
  `nome_estado` varchar(30) DEFAULT NULL,
  `sigla` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`id`, `nome_estado`, `sigla`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amazonas', 'AM'),
(4, 'Amapá', 'AP'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Minas Gerais', 'MG'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Mato Grosso', 'MT'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Pernambuco', 'PE'),
(17, 'Piauí', 'PI'),
(18, 'Paraná', 'PR'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rondônia', 'RO'),
(22, 'Roraima', 'RR'),
(23, 'Rio Grande do Sul', 'RS'),
(24, 'Santa Catarina', 'SC'),
(25, 'Sergipe', 'SE'),
(26, 'São Paulo', 'SP'),
(27, 'Tocantins', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoques`
--

CREATE TABLE IF NOT EXISTS `estoques` (
  `id` int(10) NOT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estoques`
--

INSERT INTO `estoques` (`id`, `quantidade`, `proprietarios_id`, `produtos_id`) VALUES
(1, 10, 6, 16),
(19, 20, 6, 21),
(21, 0, 6, 20),
(22, 15, 6, 20),
(23, 27, 7, 2),
(24, 30, 7, 51);

-- --------------------------------------------------------

--
-- Estrutura da tabela `investimentos`
--

CREATE TABLE IF NOT EXISTS `investimentos` (
  `id` int(10) NOT NULL,
  `nome_investimento` varchar(30) DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `investimentos`
--

INSERT INTO `investimentos` (`id`, `nome_investimento`, `descricao`, `data`, `valor`, `proprietarios_id`) VALUES
(1, 'Reforma no Galpão', '', '2017-07-03', 1500, 6),
(2, 'Construção', 'Construção do galinheiro', '2017-07-07', 800, 6),
(4, 'Roçadeira ', '', '2017-07-10', 350, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(10) NOT NULL,
  `nome_municipio` varchar(30) DEFAULT NULL,
  `estados_id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `municipios`
--

INSERT INTO `municipios` (`id`, `nome_municipio`, `estados_id`) VALUES
(1, 'Água Clara', 12),
(2, 'Alcinópolis', 12),
(3, 'Amambaí', 12),
(4, 'Anastácio', 12),
(5, 'Anaurilândia', 12),
(6, 'Angélica', 12),
(7, 'Antônio João', 12),
(8, 'Aparecida do Taboado', 12),
(9, 'Aquidauana', 12),
(10, 'Aral Moreira', 12),
(11, 'Bandeirantes', 12),
(12, 'Bataguassu', 12),
(13, 'Bataiporã', 12),
(14, 'Bela Vista', 12),
(15, 'Bodoquena', 12),
(16, 'Bonito', 12),
(17, 'Brasilândia', 12),
(18, 'Caarapó', 12),
(19, 'Camapuã', 12),
(20, 'Campo Grande', 12),
(21, 'Caracol', 12),
(22, 'Cassilândia', 12),
(23, 'Chapadão do Sul', 12),
(24, 'Corguinho', 12),
(25, 'Coronel Sapucaia', 12),
(26, 'Corumbá', 12),
(27, 'Costa Rica', 12),
(28, 'Coxim', 12),
(29, 'Deodápolis', 12),
(30, 'Dois Irmãos do Buriti', 12),
(31, 'Douradina', 12),
(32, 'Dourados', 12),
(33, 'Eldorado', 12),
(34, 'Fátima do Sul', 12),
(35, 'Figueirão', 12),
(36, 'Glória de Dourados', 12),
(37, 'Guia Lopes da Laguna', 12),
(38, 'Iguatemi', 12),
(39, 'Inocência', 12),
(40, 'Itaporã', 12),
(41, 'Itaquiraí', 12),
(42, 'Ivinhema', 12),
(43, 'Japorã', 12),
(44, 'Jaraguari', 12),
(45, 'Jardim', 12),
(46, 'Jateí', 12),
(47, 'Juti', 12),
(48, 'Ladário', 12),
(49, 'Maracaju', 12),
(50, 'Miranda', 12),
(51, 'Mundo Novo', 12),
(52, 'Naviraí', 12),
(53, 'Nioaque', 12),
(54, 'Nova Alvorada do Sul', 12),
(55, 'Nova Andradina', 12),
(56, 'Novo Horizonte do Sul', 12),
(57, 'Paranaíba', 12),
(58, 'Paranhos', 12),
(59, 'Pedro Gomes', 12),
(60, 'Ponta Porã', 12),
(61, 'Porto Murtinho', 12),
(62, 'Ribas do Rio Pardo', 12),
(63, 'Rio Brilhante', 12),
(64, 'Rio Negro', 12),
(65, 'Rio Verde de Mato Grosso', 12),
(66, 'Rochedo', 12),
(67, 'Santa Rita do Pardo', 12),
(68, 'São Gabriel do Oeste', 12),
(69, 'Selvíria', 12),
(70, 'Sete Quedas', 12),
(71, 'Sidrolândia', 12),
(72, 'Sonora', 12),
(73, 'Tacuru', 12),
(74, 'Taquarussu', 12),
(75, 'Terenos', 12),
(76, 'Três Lagoas', 12),
(77, 'Vicentina', 12),
(78, 'Cuiabá', 13),
(79, 'Belo Horizonte ', 11);

-- --------------------------------------------------------

--
-- Estrutura da tabela `perda_produtos`
--

CREATE TABLE IF NOT EXISTS `perda_produtos` (
  `id` int(10) NOT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `data` date NOT NULL,
  `estoques_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perda_produtos`
--

INSERT INTO `perda_produtos` (`id`, `quantidade`, `motivo`, `data`, `estoques_id`, `produtos_id`) VALUES
(2, 3, 'Consumo próprio', '2017-07-14', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(10) NOT NULL,
  `nome_produto` varchar(30) DEFAULT NULL,
  `unidade` char(3) DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome_produto`, `unidade`, `proprietarios_id`) VALUES
(1, 'Mandioca', 'KG', 6),
(2, 'Abacaxi', 'UN', 7),
(14, 'Coco', 'UN', 6),
(15, 'Abacaxi', 'UN', 6),
(16, 'Banana', 'DZ', 6),
(18, 'Melância', 'UN', 6),
(19, 'Melão', 'UN', 6),
(20, 'Batata ', 'KG', 6),
(21, 'Leite', 'LT', 6),
(22, 'Doce de Leite', 'UN', 6),
(23, 'Cebola', 'KG', 6),
(24, 'Alface', 'UN', 6),
(25, 'Couve', 'UN', 6),
(47, 'Cenoura', 'KG', 6),
(49, 'Maçã', 'KG', 6),
(50, 'Tomate', 'KG', 6),
(51, 'Alface Crespa', 'UN', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `proprietarios`
--

CREATE TABLE IF NOT EXISTS `proprietarios` (
  `id` int(10) NOT NULL,
  `nome_proprietario` varchar(30) DEFAULT NULL,
  `telefone` int(11) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `nome_propriedade` varchar(30) DEFAULT NULL,
  `localizacao` varchar(30) DEFAULT NULL,
  `municipios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `proprietarios`
--

INSERT INTO `proprietarios` (`id`, `nome_proprietario`, `telefone`, `email`, `senha`, `nome_propriedade`, `localizacao`, `municipios_id`) VALUES
(6, 'Paulo', 993099573, 'paulo@teste.com', '202cb962ac59075b964b07152d234b70', 'Assentamento 013', 'KM 20', 26),
(7, 'Andreza', 32261906, 'andreza@teste.com', 'e10adc3949ba59abbe56e057f20f883e', 'Assentamento 30', 'KM 27', 48),
(8, 'Lucineide', 0, 'lucineide@teste.com', '202cb962ac59075b964b07152d234b70', 'a', 'a', 12),
(9, 'A', 0, 'A@HOTMAIL.COM', '0cc175b9c0f1b6a831c399e269772661', 'a', 'a', 16),
(10, 'valdomiro', 992209284, 'valdomiro@teste.com', '123', 'sitio paraiso', 'assentamento taquaral', 26),
(11, 'Armin Beh', 999788, 'armin@Test.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sitio Sao Pedro', 'Taquaral', 26);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(10) NOT NULL,
  `data` date DEFAULT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `total` float NOT NULL,
  `proprietarios_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id`, `data`, `quantidade`, `preco`, `total`, `proprietarios_id`, `produtos_id`) VALUES
(9, '2017-07-13', 3, 3, 9, 6, 22),
(12, '2017-07-13', 10, 1.5, 15, 6, 24),
(13, '2017-07-14', 4, 3, 12, 6, 21),
(14, '2017-07-16', 4, 1.5, 6, 6, 24),
(15, '2017-07-16', 4, 3.8, 15.2, 6, 16),
(16, '2017-07-16', 5, 2.2, 11, 6, 20),
(17, '2017-07-16', 1, 2, 2, 6, 16),
(18, '2017-07-14', 4, 3, 12, 6, 20),
(19, '2017-07-15', 7, 4, 28, 6, 21),
(20, '2017-07-16', 9, 3.2, 28.8, 6, 20),
(21, '2017-07-16', 1, 3.2, 3.2, 6, 20),
(22, '2017-07-18', 3, 3.8, 11.4, 7, 2),
(23, '2017-07-18', 10, 2.5, 25, 7, 51);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `despesas`
--
ALTER TABLE `despesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Indexes for table `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estoques`
--
ALTER TABLE `estoques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- Indexes for table `investimentos`
--
ALTER TABLE `investimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Indexes for table `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estados_id` (`estados_id`);

--
-- Indexes for table `perda_produtos`
--
ALTER TABLE `perda_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estoques_id` (`estoques_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Indexes for table `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipios_id` (`municipios_id`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `despesas`
--
ALTER TABLE `despesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `estoques`
--
ALTER TABLE `estoques`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `investimentos`
--
ALTER TABLE `investimentos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `perda_produtos`
--
ALTER TABLE `perda_produtos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `proprietarios`
--
ALTER TABLE `proprietarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `despesas`
--
ALTER TABLE `despesas`
  ADD CONSTRAINT `despesas_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Limitadores para a tabela `estoques`
--
ALTER TABLE `estoques`
  ADD CONSTRAINT `estoques_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`),
  ADD CONSTRAINT `estoques_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `investimentos`
--
ALTER TABLE `investimentos`
  ADD CONSTRAINT `investimentos_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Limitadores para a tabela `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`estados_id`) REFERENCES `estados` (`id`);

--
-- Limitadores para a tabela `perda_produtos`
--
ALTER TABLE `perda_produtos`
  ADD CONSTRAINT `perda_produtos_ibfk_1` FOREIGN KEY (`estoques_id`) REFERENCES `estoques` (`id`),
  ADD CONSTRAINT `perda_produtos_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Limitadores para a tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD CONSTRAINT `proprietarios_ibfk_1` FOREIGN KEY (`municipios_id`) REFERENCES `municipios` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
