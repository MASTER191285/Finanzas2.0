-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-11-2018 a las 20:21:48
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
WHERE G.id_usuario = Id_User
GROUP BY G.id_usuario;
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `monto`, `fecha`, `comprobante`, `observaciones`, `id_tipo_gasto`, `id_usuario`) VALUES
(1, 1000, '2018-11-14', NULL, 'Sándwich Callejero de Desayuno', 1, 1),
(2, 7500, '2018-11-14', NULL, 'Once con Chaparra', 7, 1),
(4, 2800, '2018-11-26', NULL, 'Almuerzo Diario', 1, 1),
(5, 1100, '2018-11-26', NULL, 'Compra de Desayuno Ok Market', 1, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id`, `monto`, `fecha`, `observaciones`, `id_tipo_ingreso`, `id_usuario`) VALUES
(9, 750000, '2018-11-14', 'Prueba2', 1, 1),
(10, 20000, '2018-11-13', 'Sin Observaciones', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_gasto`
--

DROP TABLE IF EXISTS `tipo_gasto`;
CREATE TABLE IF NOT EXISTS `tipo_gasto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(10, 'Donaciones');

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
(1, 'ylopez', '11F72E83FA507C40E7B734E47C072175A39923BB9143EC7E8BD14EFBADAD6EF4', 'yuri_lopez@vtr.net', 'Yuri', ''),
(2, 'cmontero', '11F72E83FA507C40E7B734E47C072175A39923BB9143EC7E8BD14EFBADAD6EF4', 'cmontero@empresasarmas.cl', 'Cristian', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
