-- -------------------------------------------------------------
-- TablePlus 3.12.5(363)
--
-- https://tableplus.com/
--
-- Database: concessionaria
-- Generation Time: 2021-03-07 16:33:40.8520
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `carros`;
CREATE TABLE `carros` (
  `id_carro` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_marca` int(11) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano` int(5) NOT NULL,
  `preco` decimal(12,2) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `cor` varchar(255) NOT NULL,
  `descricao` text,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_edicao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_carro`),
  KEY `fk_id_marca` (`fk_id_marca`),
  CONSTRAINT `carros_ibfk_1` FOREIGN KEY (`fk_id_marca`) REFERENCES `marcas` (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `carros` (`id_carro`, `fk_id_marca`, `modelo`, `ano`, `preco`, `foto`, `cor`, `descricao`, `data_cadastro`, `data_edicao`) VALUES
(1, 1, 'Mobi', 2020, 35000.00, 'fiat-mobi.jpg', 'Vermelho', 'Um verdadeiro desbravador das ruas, o Fiat Mobi possui um desgin jovem pensado para encarar as ruas e avenidas com muita presença e estilo.', '2021-03-07 16:31:01', NULL);

INSERT INTO `marcas` (`id_marca`, `nome`) VALUES
(1, 'Fiat');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;