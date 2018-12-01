
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `siaf`
--

CREATE DATABASE siaf;

USE siaf;

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `estoque` (`quantidade` INT, `proprietarios_id` INT, `produtos_id` INT)  BEGIN
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION; 
    		UPDATE estoques SET estoques.quantidade=(estoques.quantidade+quantidade) WHERE estoques.produtos_id=produtos_id and estoques.proprietarios_id=proprietarios_id;
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `perdas` (`quantidade` INT, `motivo` VARCHAR(255), `data1` DATE, `perda` INT, `produto` INT)  BEGIN
	DECLARE qtdEstoque INTEGER;
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
    	SELECT estoques.quantidade FROM estoques  WHERE estoques.produtos_id=produto and estoques.id=perda INTO qtdEstoque;
    	if qtdEstoque >= quantidade THEN  
    		insert into perda_produtos(quantidade, motivo, data, estoques_id, produtos_id) values(quantidade, motivo, data1, perda,produto);
    		UPDATE estoques SET estoques.quantidade=(estoques.quantidade-quantidade) WHERE estoques.produtos_id=produto and estoques.id=perda;
    		SELECT "suscesso" AS suscesso;
        END IF;
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `produtos` (`nome` VARCHAR(255), `unidade` VARCHAR(15), `id` INT)  BEGIN
	DECLARE produto_id INTEGER;
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
    	insert into produtos(`nome_produto`, `unidade`, `proprietarios_id`) values (nome, unidade, id );
    	SELECT LAST_INSERT_ID() INTO produto_id;	
    	insert into estoques(`quantidade`, `proprietarios_id`, `produtos_id`) values (0,id,produto_id);
    	SELECT "suscesso" AS suscesso; 
    COMMIT;
    
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `produtos_del` (`id` INT)  BEGIN
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
			DELETE FROM produtos WHERE produtos.id = id;
    		SELECT 'suscesso' as suscesso;
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$

 
CREATE DEFINER=`root`@`localhost` PROCEDURE `vendas` (`data1` DATE, `quantidade` INT, `preco` FLOAT, `id` INT, `codproduto` INT)  BEGIN
	DECLARE qtdEstoque INTEGER;
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
    	SELECT estoques.quantidade FROM estoques  WHERE estoques.produtos_id=codproduto  INTO qtdEstoque;
    	if qtdEstoque >= quantidade THEN  
    		INSERT INTO vendas(`data`, `quantidade`, `preco`, `total`, `proprietarios_id`, `produtos_id`) VALUES (data1, quantidade, preco, (quantidade * preco), id, codproduto);
    		UPDATE estoques SET estoques.quantidade=(estoques.quantidade-quantidade) WHERE estoques.produtos_id=codproduto ;
    		SELECT "suscesso" AS suscesso;
        END IF;
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$

 
CREATE DEFINER=`root`@`localhost` PROCEDURE `vendas_del` (`id` INT)  BEGIN
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
    		UPDATE estoques SET estoques.quantidade=(estoques.quantidade+( SELECT vendas.quantidade FROM vendas WHERE vendas.id=id) ) WHERE estoques.produtos_id=(SELECT vendas.produtos_id FROM vendas WHERE vendas.id=id) ;
    		DELETE FROM `vendas` WHERE vendas.id = id;
    		SELECT 'suscesso' as suscesso;
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$

 
CREATE DEFINER=`root`@`localhost` PROCEDURE `vendas_edt` (`data1` DATE, `quantidade` INT, `preco` FLOAT, `id` INT)  BEGIN
	DECLARE qtdEstoque INTEGER;
	DECLARE qtdanterior INTEGER;
	SET SESSION AUTOCOMMIT=0;
	SET AUTOCOMMIT =0;
    START TRANSACTION;
    	SELECT vendas.quantidade FROM vendas WHERE vendas.id=id INTO qtdanterior;
    	IF qtdanterior < quantidade  THEN
	  		SELECT estoques.quantidade FROM estoques  WHERE estoques.produtos_id=(SELECT vendas.produtos_id FROM vendas WHERE vendas.id=id)  INTO qtdEstoque;
    		IF qtdEstoque >= (quantidade-qtdanterior) THEN  
    			UPDATE vendas SET  `preco` = preco, `quantidade` = quantidade, `data` = data1, total = (preco * quantidade) WHERE vendas.id = id;
    			UPDATE estoques SET estoques.quantidade=(estoques.quantidade+(qtdanterior-quantidade)) WHERE estoques.produtos_id=(SELECT vendas.produtos_id FROM vendas WHERE vendas.id=id) ;
    			SELECT "suscesso - " AS suscesso;
    		END IF; 
        else
     		UPDATE vendas SET  `preco` = preco, `quantidade` = quantidade, `data` = data1, total = (preco * quantidade) WHERE vendas.id = id;
     		UPDATE estoques SET estoques.quantidade=(estoques.quantidade-(quantidade-qtdanterior)) WHERE estoques.produtos_id=(SELECT vendas.produtos_id FROM vendas WHERE vendas.id=id) ;
    		SELECT "suscesso + " AS suscesso;
        END IF;	
    COMMIT;
    SET SESSION AUTOCOMMIT=1;
	SET AUTOCOMMIT =1;
END$$


DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesas`
--

CREATE TABLE `despesas` (
  `id` int(10) NOT NULL,
  `nome_despesa` varchar(30) DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `data` date NOT NULL,
  `proprietarios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Fazendo dump de dados para tabela `despesas`
--
-- --------------------------------------------------------

--
-- Estrutura para tabela `estados`
--

CREATE TABLE `estados` (
  `id` int(2) NOT NULL,
  `nome_estado` varchar(30) DEFAULT NULL,
  `sigla` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `estados`
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
-- Estrutura para tabela `estoques`
--

CREATE TABLE `estoques` (
  `id` int(10) NOT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Fazendo dump de dados para tabela `estoques`
--

--
-- Estrutura para tabela `investimentos`
--

CREATE TABLE `investimentos` (
  `id` int(10) NOT NULL,
  `nome_investimento` varchar(30) DEFAULT NULL,
  `descricao` varchar(30) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Fazendo dump de dados para tabela `investimentos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `municipios`
--

CREATE TABLE `municipios` (
  `id` int(10) NOT NULL,
  `nome_municipio` varchar(30) DEFAULT NULL,
  `estados_id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `municipios`
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
-- Estrutura para tabela `perda_produtos`
--

CREATE TABLE `perda_produtos` (
  `id` int(10) NOT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `motivo` varchar(30) DEFAULT NULL,
  `data` date NOT NULL,
  `estoques_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Fazendo dump de dados para tabela `perda_produtos`
--

-----------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(10) NOT NULL,
  `nome_produto` varchar(30) DEFAULT NULL,
  `unidade` char(3) DEFAULT NULL,
  `proprietarios_id` int(10) DEFAULT NULL,
  `destino` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Fazendo dump de dados para tabela `produtos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietarios`
--

CREATE TABLE `proprietarios` (
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
 
-- Fazendo dump de dados para tabela `proprietarios`
--
-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(10) NOT NULL,
  `data` date DEFAULT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `total` float NOT NULL,
  `proprietarios_id` int(10) DEFAULT NULL,
  `produtos_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
 
-- Fazendo dump de dados para tabela `vendas`
--
--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `despesas`
--
ALTER TABLE `despesas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Índices de tabela `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `estoques`
--
ALTER TABLE `estoques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- Índices de tabela `investimentos`
--
ALTER TABLE `investimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Índices de tabela `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estados_id` (`estados_id`);

--
-- Índices de tabela `perda_produtos`
--
ALTER TABLE `perda_produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estoques_id` (`estoques_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`);

--
-- Índices de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipios_id` (`municipios_id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proprietarios_id` (`proprietarios_id`),
  ADD KEY `produtos_id` (`produtos_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `despesas`
--
ALTER TABLE `despesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `estoques`
--
ALTER TABLE `estoques`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `investimentos`
--
ALTER TABLE `investimentos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de tabela `perda_produtos`
--
ALTER TABLE `perda_produtos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `proprietarios`
--
ALTER TABLE `proprietarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `despesas`
--
ALTER TABLE `despesas`
  ADD CONSTRAINT `despesas_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Restrições para tabelas `estoques`
--
ALTER TABLE `estoques`
  ADD CONSTRAINT `estoques_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`),
  ADD CONSTRAINT `estoques_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `investimentos`
--
ALTER TABLE `investimentos`
  ADD CONSTRAINT `investimentos_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Restrições para tabelas `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`estados_id`) REFERENCES `estados` (`id`);

--
-- Restrições para tabelas `perda_produtos`
--
ALTER TABLE `perda_produtos`
  ADD CONSTRAINT `perda_produtos_ibfk_1` FOREIGN KEY (`estoques_id`) REFERENCES `estoques` (`id`),
  ADD CONSTRAINT `perda_produtos_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`);

--
-- Restrições para tabelas `proprietarios`
--
ALTER TABLE `proprietarios`
  ADD CONSTRAINT `proprietarios_ibfk_1` FOREIGN KEY (`municipios_id`) REFERENCES `municipios` (`id`);

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`proprietarios_id`) REFERENCES `proprietarios` (`id`),
  ADD CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`);
COMMIT;
