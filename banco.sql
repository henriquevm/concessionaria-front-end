DROP TABLE IF EXISTS `cor`;

CREATE TABLE `cor` (
  `id_cor` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_cor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `veiculo`;
CREATE TABLE `veiculo` (
  `id_veiculo` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_marca` int(11) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano` int(5) NOT NULL,
  `preco` decimal(12,2) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `fk_id_cor` int(11) NOT NULL,
  `descricao` text,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_veiculo`),
  KEY `fk_id_marca` (`fk_id_marca`),
  KEY `fk_id_cor` (`fk_id_cor`),
  CONSTRAINT `veiculo_ibfk_1` FOREIGN KEY (`fk_id_marca`) REFERENCES `marca` (`id_marca`),
  CONSTRAINT `veiculo_ibfk_2` FOREIGN KEY (`fk_id_cor`) REFERENCES `cor` (`id_cor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `cor` (`id_cor`, `descricao`) VALUES
(1, 'Vermelho'),
(2, 'Preto'),
(3, 'Prata'),
(4, 'Branco');

INSERT INTO `marca` (`id_marca`, `descricao`) VALUES
(1, 'Fiat'),
(2, 'Honda'),
(3, 'Chevrolet'),
(4, 'Ford'),
(5, 'Hyundai');

INSERT INTO `veiculo` (`id_veiculo`, `fk_id_marca`, `modelo`, `ano`, `preco`, `foto`, `fk_id_cor`, `descricao`, `data_cadastro`, `data_edicao`) VALUES
(1, 1, 'Mobi', 2020, 35000.00, 'fiat-mobi.jpg', 1, 'Um verdadeiro desbravador das ruas, o Fiat Mobi possui um desgin jovem pensado para encarar as ruas e avenidas com muita presença e estilo.', '2021-03-07 16:31:01', NULL),
(2, 5, 'HB20', 2021, 47990.00, 'hb20.jpg', 4, 'A linha 2021 do Hyundai HB20 começa a ser oferecida em todo o Brasil com pequenas alterações no visual e na lista de equipamentos. As versões Sense, Vision e Evolution, as mais baratas e que usam o motor 1.0 aspirado, passam a ter a grade frontal pintada de preto e uma mudança no pacote de equipamentos opcionais, unificando a oferta do controle de estabilidade com mais itens de segurança, dependendo da configuração.', '2021-03-08 02:11:59', NULL);