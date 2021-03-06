-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-12-2018 a las 19:27:54
-- Versión del servidor: 5.7.23
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `finanzas`
--
CREATE DATABASE IF NOT EXISTS `finanzas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `finanzas`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `GETTOTALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GETTOTALES` ()  BEGIN
SELECT 	  (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
      ) AS GASTOS,
	 (
      	SELECT SUM(I2.MONTO)
        FROM ingresos AS I2
        WHERE I2.id_usuario = G.id_usuario
      ) AS INGRESOS,
      (
        (
      		SELECT SUM(I2.MONTO)
        	FROM ingresos AS I2
        	WHERE I2.id_usuario = G.id_usuario
      	) 
      	-
      	(
      		SELECT SUM(G2.MONTO)
        	FROM gastos AS G2
        	WHERE G2.id_usuario = G.id_usuario
      	)
      )AS TOTAL
FROM GASTOS AS G 
GROUP BY G.id_usuario;
END$$

DROP PROCEDURE IF EXISTS `GET_TOTALESV2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_TOTALESV2` (IN `Id_User` INT(11))  BEGIN
DECLARE FECHA_INI DATETIME;
SET FECHA_INI= (SELECT DATE(NOW()) - INTERVAL DAY(NOW()) DAY + INTERVAL 1 DAY);
SELECT 	  (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
        AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
      ) AS GASTOS,
	 (
      	SELECT SUM(I2.MONTO)
        FROM ingresos AS I2
        WHERE I2.id_usuario = G.id_usuario
        AND I2.fecha BETWEEN FECHA_INI AND SYSDATE()
      ) AS INGRESOS,
      (
        (
      		SELECT SUM(I2.MONTO)
        	FROM ingresos AS I2
        	WHERE I2.id_usuario = G.id_usuario
        	AND I2.fecha BETWEEN FECHA_INI AND SYSDATE()
      	) 
      	-
      	(
      		SELECT SUM(G2.MONTO)
        	FROM gastos AS G2
        	WHERE G2.id_usuario = G.id_usuario
        	AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
      	)
      )AS TOTAL
      
FROM GASTOS AS G 
WHERE G.id_usuario = Id_User
GROUP BY G.id_usuario;
    END$$

DROP PROCEDURE IF EXISTS `INFO_DIARIA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `INFO_DIARIA` (IN `Id_User` INT(11))  BEGIN
DECLARE FECHA_INI DATETIME;
SET FECHA_INI= (SELECT DATE(NOW()) - INTERVAL DAY(NOW()) DAY + INTERVAL 1 DAY);
SELECT 
      (
      	SELECT SUM(G2.MONTO)
        FROM gastos AS G2
        WHERE G2.id_usuario = G.id_usuario
        AND G2.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G2.id_tipo_gasto = 1
      ) AS GASTOS_ALIMENTACION,
      (
      	SELECT SUM(G3.MONTO)
        FROM gastos AS G3        
        WHERE G3.id_usuario = G.id_usuario 
        AND G3.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G3.id_tipo_gasto = 7
      ) AS GASTOS_DISTRACCIONES,
      (
      	SELECT SUM(G4.MONTO)
        FROM gastos AS G4        
        WHERE G4.id_usuario = G.id_usuario 
        AND G4.fecha BETWEEN FECHA_INI AND CURDATE()
        AND G4.id_tipo_gasto = 11
      ) AS GASTOS_HORMIGA     
      
FROM GASTOS AS G 
WHERE G.id_usuario = Id_User
GROUP BY G.id_usuario;
END$$

DROP PROCEDURE IF EXISTS `TEST2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `TEST2` (IN `input_data` INT(11), OUT `output_data` VARCHAR(20))  BEGIN
SELECT descripcion INTO output_data FROM tipo_gasto WHERE id = @input_data;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

DROP TABLE IF EXISTS `gastos`;
CREATE TABLE IF NOT EXISTS `gastos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `comprobante` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` varchar(100) COLLATE utf8_spanish_ci DEFAULT 'Sin Observaciones',
  `id_tipo_gasto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_g` (`id_tipo_gasto`),
  KEY `fk_user_g` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `monto`, `fecha`, `comprobante`, `observaciones`, `id_tipo_gasto`, `id_usuario`) VALUES
(1, 1000, '2018-11-14', NULL, 'Sándwich Callejero de Desayuno', 1, 1),
(2, 7500, '2018-11-14', NULL, 'Once con Chaparra', 7, 1),
(4, 2800, '2018-11-26', NULL, 'Almuerzo Diario', 1, 1),
(5, 1100, '2018-11-26', NULL, 'Compra de Desayuno Ok Market', 1, 1),
(14, 1000, '2018-12-04', NULL, 'Galletas y Café', 11, 1),
(13, 2000, '2018-12-04', NULL, 'Almuerzo Diario', 1, 1),
(12, 8000, '2018-12-04', NULL, 'Lectura con Café', 7, 1),
(15, 250000, '2018-12-05', NULL, 'Arriendo Mensual', 2, 1),
(16, 6000, '2018-12-03', NULL, 'Luz Mensual', 3, 1),
(17, 4000, '2018-12-04', NULL, 'Sin Observaciones', 4, 1),
(18, 30989, '2018-12-03', NULL, 'Sin Observaciones', 5, 1),
(19, 10000, '2018-12-03', NULL, 'Sin Observaciones', 6, 1),
(20, 50000, '2018-12-10', NULL, 'Sin Observaciones', 12, 1),
(21, 5000, '2018-12-01', NULL, 'carga bip', 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE IF NOT EXISTS `ingresos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `observaciones` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Sin Observaciones',
  `id_tipo_ingreso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_i` (`id_tipo_ingreso`),
  KEY `fk_user_i` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `monto`, `fecha`, `observaciones`, `id_tipo_ingreso`, `id_usuario`) VALUES
(9, 750000, '2018-11-14', 'Prueba2', 1, 1),
(10, 20000, '2018-11-13', 'Sin Observaciones', 2, 1),
(14, 765000, '2018-12-01', 'Sin Observaciones', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_gasto`
--

DROP TABLE IF EXISTS `tipo_gasto`;
CREATE TABLE IF NOT EXISTS `tipo_gasto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_gasto`
--

INSERT INTO `tipo_gasto` (`id`, `descripcion`) VALUES
(1, 'Alimentación'),
(2, 'Arriendo'),
(3, 'Luz'),
(4, 'Agua'),
(5, 'Internet'),
(6, 'Teléfono'),
(7, 'Distracciones'),
(8, 'Supermercado'),
(9, 'Tecnología'),
(10, 'Donaciones'),
(11, 'Otros (Especifícar)'),
(12, 'Gastos Comunes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ingreso`
--

DROP TABLE IF EXISTS `tipo_ingreso`;
CREATE TABLE IF NOT EXISTS `tipo_ingreso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_ingreso`
--

INSERT INTO `tipo_ingreso` (`id`, `descripcion`) VALUES
(1, 'Sueldo'),
(2, 'Trabajos Clientes'),
(3, 'Aguinaldos'),
(4, 'Otros (Especificar)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `profile_pic` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`, `name`, `profile_pic`) VALUES
(1, 'ylopez', '11F72E83FA507C40E7B734E47C072175A39923BB9143EC7E8BD14EFBADAD6EF4', 'yuri_lopez@vtr.net', 'Yuri López', ''),
(2, 'cmontero', '11F72E83FA507C40E7B734E47C072175A39923BB9143EC7E8BD14EFBADAD6EF4', 'cmontero@empresasarmas.cl', 'Cristian Montero', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
