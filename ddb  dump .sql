-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla buenbuceo.administradores
CREATE TABLE IF NOT EXISTS `administradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.administradores: ~0 rows (aproximadamente)
INSERT INTO `administradores` (`id`, `nombre`, `foto`, `usuario`, `password`, `tipo`) VALUES
  (1, 'Cholo', 'admin_profile_pic.jpg', 'cholodiver', '81aae10cc2e8712ae7bb18cbb92f7a2c', 1);

-- Volcando estructura para tabla buenbuceo.cursos
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(11) DEFAULT NULL,
  `cursoTipoId` varchar(50) DEFAULT NULL,
  `fecha_inicio` varchar(50) DEFAULT NULL,
  `fecha_fin` varchar(50) DEFAULT NULL,
  `diaSemanaId` varchar(50) DEFAULT NULL,
  `valorCurso` varchar(50) DEFAULT NULL,
  `valorCertificacion` varchar(50) DEFAULT NULL,
  `observaciones` varchar(50) DEFAULT NULL,
  `sedeId` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.cursos: ~0 rows (aproximadamente)

-- Volcando estructura para tabla buenbuceo.cursos_usuarios
CREATE TABLE IF NOT EXISTS `cursos_usuarios` (
  `cursoUsuarioId` int(11) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `cursoId` int(11) DEFAULT NULL,
  `codigoELearning` int(11) DEFAULT NULL,
  `observaciones` int(11) DEFAULT NULL,
  `fechaExamen` int(11) DEFAULT NULL,
  `pensar_deuda_certificacion` int(11) DEFAULT NULL,
  `deuda_curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.cursos_usuarios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla buenbuceo.curso_clases
CREATE TABLE IF NOT EXISTS `curso_clases` (
  `cursoClaseID` int(11) DEFAULT NULL,
  `fecha` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.curso_clases: ~0 rows (aproximadamente)

-- Volcando estructura para tabla buenbuceo.curso_clase_presentismo
CREATE TABLE IF NOT EXISTS `curso_clase_presentismo` (
  `cursoClaseId` int(11) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `presente` int(11) DEFAULT NULL,
  `motivoId` int(11) DEFAULT NULL,
  `comentario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.curso_clase_presentismo: ~0 rows (aproximadamente)

-- Volcando estructura para tabla buenbuceo.curso_clase_presentismo_motivos
CREATE TABLE IF NOT EXISTS `curso_clase_presentismo_motivos` (
  `id` int(11) DEFAULT NULL,
  `motivo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.curso_clase_presentismo_motivos: ~2 rows (aproximadamente)
INSERT INTO `curso_clase_presentismo_motivos` (`id`, `motivo`) VALUES
  (1, 'no justificado'),
  (2, 'justificado');

-- Volcando estructura para tabla buenbuceo.deudas
CREATE TABLE IF NOT EXISTS `deudas` (
  `deudaId` int(11) NOT NULL AUTO_INCREMENT,
  `deuda` double DEFAULT NULL,
  `monedaId` int(1) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `viajesId` int(11) DEFAULT NULL,
  `pagosSubrubroId` int(11) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`deudaId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.deudas: ~2 rows (aproximadamente)
INSERT INTO `deudas` (`deudaId`, `deuda`, `monedaId`, `usuarioId`, `viajesId`, `pagosSubrubroId`, `comentario`, `habilitado_sys`) VALUES
  (1, 150000, 1, 1, NULL, 1, NULL, 1),
  (2, 1233, 2, 2, NULL, 2, '', 1);

-- Volcando estructura para tabla buenbuceo.hospedajes
CREATE TABLE IF NOT EXISTS `hospedajes` (
  `hospedajesId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `paisId` int(11) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `estrellas` double NOT NULL DEFAULT 0,
  `comentario` text DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`hospedajesId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.hospedajes: ~3 rows (aproximadamente)
INSERT INTO `hospedajes` (`hospedajesId`, `nombre`, `paisId`, `direccion`, `estrellas`, `comentario`, `telefono`, `email`) VALUES
  (1, 'NH hotels', 15, 'Rosario 440', 4.2, 'masa', '', ''),
  (2, 'Cholo Hostel', 15, 'Chololandia 1234', 4.5, 'The Cholets', '', ''),
  (3, 'Hotel México', 15, 'Rosario 440', 3.8, 'Esta copado', '01131306779', 'nykolasvs@gmail.com');

-- Volcando estructura para tabla buenbuceo.hospedaje_habitaciones_bases
CREATE TABLE IF NOT EXISTS `hospedaje_habitaciones_bases` (
  `baseHospedajeId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`baseHospedajeId`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.hospedaje_habitaciones_bases: ~5 rows (aproximadamente)
INSERT INTO `hospedaje_habitaciones_bases` (`baseHospedajeId`, `nombre`) VALUES
  (4, 'Cuádruple'),
  (2, 'Doble'),
  (5, 'Quíntuple'),
  (1, 'Single'),
  (3, 'Triple');

-- Volcando estructura para tabla buenbuceo.hospedaje_habitaciones_tarifas
CREATE TABLE IF NOT EXISTS `hospedaje_habitaciones_tarifas` (
  `hospedajeTarifaId` int(11) NOT NULL AUTO_INCREMENT,
  `baseHospedajeId` int(11) NOT NULL,
  `tipoHospedajeId` int(11) NOT NULL,
  `hospedajesId` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `noches` int(11) DEFAULT NULL,
  `fecha_checkin` date DEFAULT NULL,
  `fecha_checkout` date DEFAULT NULL,
  PRIMARY KEY (`hospedajeTarifaId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.hospedaje_habitaciones_tarifas: ~6 rows (aproximadamente)
INSERT INTO `hospedaje_habitaciones_tarifas` (`hospedajeTarifaId`, `baseHospedajeId`, `tipoHospedajeId`, `hospedajesId`, `precio`, `alias`, `noches`, `fecha_checkin`, `fecha_checkout`) VALUES
  (12, 2, 1, 3, 1042.83, 'Base Doble 9 dias', NULL, NULL, NULL),
  (13, 1, 1, 3, 1512.18, 'Sigle 9 dias', NULL, NULL, NULL),
  (14, 2, 2, 3, 1390.44, 'Base doble 12 noches', NULL, NULL, NULL),
  (15, 1, 2, 3, 2016.24, 'Base single 12 noches', NULL, NULL, NULL),
  (16, 2, 3, 3, 1856.25, 'Base doble 15 noches', NULL, NULL, NULL),
  (17, 1, 3, 3, 2700.00, 'Singles 15 noches', NULL, NULL, NULL);

-- Volcando estructura para tabla buenbuceo.hospedaje_habitaciones_tipos
CREATE TABLE IF NOT EXISTS `hospedaje_habitaciones_tipos` (
  `tipoHospedajeId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`tipoHospedajeId`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.hospedaje_habitaciones_tipos: ~6 rows (aproximadamente)
INSERT INTO `hospedaje_habitaciones_tipos` (`tipoHospedajeId`, `nombre`) VALUES
  (1, 'Tipo 1'),
  (2, 'Tipo 2'),
  (3, 'Tipo 3'),
  (4, 'Tipo 4'),
  (5, 'Tipo 5'),
  (6, 'Tipo 6');

-- Volcando estructura para tabla buenbuceo.medios_de_pago
CREATE TABLE IF NOT EXISTS `medios_de_pago` (
  `medioPagoId` int(11) NOT NULL AUTO_INCREMENT,
  `medioPago` varchar(50) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`medioPagoId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.medios_de_pago: ~5 rows (aproximadamente)
INSERT INTO `medios_de_pago` (`medioPagoId`, `medioPago`, `icono`, `habilitado_sys`) VALUES
  (1, 'Efectivo', 'ni ni-money-coins', 1),
  (2, 'Transferencia bancaria', 'ni ni-world-2', 1),
  (3, 'Transferencia MP', 'ni ni-mobile-button', 1),
  (4, 'PayPal', 'fa fa-paypal', 0),
  (5, 'Tarjeta crédito', 'ni ni-credit-card', 1);

-- Volcando estructura para tabla buenbuceo.monedas
CREATE TABLE IF NOT EXISTS `monedas` (
  `monedaId` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(50) DEFAULT NULL,
  `simbolo` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`monedaId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.monedas: ~3 rows (aproximadamente)
INSERT INTO `monedas` (`monedaId`, `moneda`, `simbolo`) VALUES
  (1, 'Pesos ', '$'),
  (2, 'Dolares', 'US$'),
  (3, 'Euros', '€');

-- Volcando estructura para tabla buenbuceo.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `pagoId` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(50) DEFAULT NULL,
  `pagosSubrubroId` varchar(50) NOT NULL,
  `pagoTransaccionTipoId` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monedaId` int(11) NOT NULL DEFAULT 1,
  `cotizacion` double DEFAULT NULL,
  `monto` double NOT NULL,
  `medioPagoId` int(11) NOT NULL DEFAULT 1,
  `habilitado_sys` int(1) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `deudaId` int(11) DEFAULT NULL,
  `viajesId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pagoId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.pagos: ~4 rows (aproximadamente)
INSERT INTO `pagos` (`pagoId`, `comentario`, `pagosSubrubroId`, `pagoTransaccionTipoId`, `fecha`, `monedaId`, `cotizacion`, `monto`, `medioPagoId`, `habilitado_sys`, `usuarioId`, `deudaId`, `viajesId`) VALUES
  (1, '', '14', 2, '2024-11-03', 2, 1180, 1500, 1, 1, 1, 1, 7),
  (2, '', '14', 1, '2024-11-03', 1, 0, 12312, 1, 1, 1, 1, NULL),
  (3, '0', '14', 2, '2024-11-06', 1, NULL, 1500, 1, 1, NULL, NULL, NULL),
  (4, '0', '18', 1, '2024-11-20', 2, 1125, 1205, 2, 1, NULL, NULL, 7);

-- Volcando estructura para tabla buenbuceo.pagos_rubros
CREATE TABLE IF NOT EXISTS `pagos_rubros` (
  `pagosRubroId` int(11) NOT NULL AUTO_INCREMENT,
  `rubro` char(50) DEFAULT NULL,
  `comentario` char(50) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`pagosRubroId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.pagos_rubros: ~7 rows (aproximadamente)
INSERT INTO `pagos_rubros` (`pagosRubroId`, `rubro`, `comentario`, `habilitado_sys`) VALUES
  (1, 'Redes sociales', '', 1),
  (2, 'Viajes', '', 1),
  (3, 'Cursos', '', 1),
  (4, 'Varios', '', 1),
  (5, 'Equipos - Compra/Venta', '', 1),
  (6, 'Alquileres', '', 1),
  (7, 'Certificaciones', '', 1);

-- Volcando estructura para tabla buenbuceo.pagos_subrubros
CREATE TABLE IF NOT EXISTS `pagos_subrubros` (
  `pagosSubrubroId` int(11) NOT NULL AUTO_INCREMENT,
  `subrubro` varchar(50) DEFAULT NULL,
  `pagosRubrosId` int(11) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`pagosSubrubroId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.pagos_subrubros: ~17 rows (aproximadamente)
INSERT INTO `pagos_subrubros` (`pagosSubrubroId`, `subrubro`, `pagosRubrosId`, `habilitado_sys`) VALUES
  (1, 'Pileta Hurlingham', 6, 1),
  (2, 'Pileta CABA', 6, 1),
  (3, 'Local', 6, 1),
  (4, 'Curso Rescue', 3, 1),
  (5, 'Curso Open', 3, 1),
  (6, 'Certificacion de Rescue', 7, 1),
  (7, 'Certificacion de Open', 7, 1),
  (8, 'Aletas', 5, 1),
  (9, 'Mascaras', 5, 1),
  (10, 'Promociones Instagram', 1, 1),
  (11, 'Promociones Facebook', 1, 1),
  (12, 'Alquileres de equipo', 2, 1),
  (13, 'Varios', 4, 1),
  (14, 'Vuelos', 2, 1),
  (15, 'Traslados IN/OUT', 2, 1),
  (16, 'Paquete de buceos', 2, 1),
  (17, 'Tasa Ambiental', 2, 1),
  (18, 'Excursiones', 2, 1),
  (19, 'Paquetes turísticos', 2, 1),
  (20, 'Hospedajes', 2, 1);

-- Volcando estructura para tabla buenbuceo.pagos_transaccion_tipo
CREATE TABLE IF NOT EXISTS `pagos_transaccion_tipo` (
  `pagoTransaccionTipoId` int(11) NOT NULL AUTO_INCREMENT,
  `transaccion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pagoTransaccionTipoId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.pagos_transaccion_tipo: ~2 rows (aproximadamente)
INSERT INTO `pagos_transaccion_tipo` (`pagoTransaccionTipoId`, `transaccion`) VALUES
  (1, 'Egreso'),
  (2, 'Ingreso');

-- Volcando estructura para tabla buenbuceo.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `paisId` int(11) NOT NULL AUTO_INCREMENT,
  `pais` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`paisId`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.paises: ~44 rows (aproximadamente)
INSERT INTO `paises` (`paisId`, `pais`) VALUES
  (1, 'Argentina'),
  (2, 'Australia'),
  (3, 'Alemania'),
  (4, 'Brasil'),
  (5, 'Canadá'),
  (6, 'China'),
  (7, 'Corea del Sur'),
  (8, 'Croacia'),
  (9, 'España'),
  (10, 'Estados Unidos'),
  (11, 'Francia'),
  (12, 'India'),
  (13, 'Italia'),
  (14, 'Japón'),
  (15, 'México'),
  (16, 'Países Bajos'),
  (17, 'Polonia'),
  (18, 'Portugal'),
  (19, 'Reino Unido'),
  (20, 'Rusia'),
  (21, 'Suecia'),
  (22, 'Suiza'),
  (23, 'Turquía'),
  (24, 'Ucrania'),
  (25, 'Venezuela'),
  (26, 'Austria'),
  (27, 'Bélgica'),
  (28, 'Chile'),
  (29, 'Colombia'),
  (30, 'Czech Republic'),
  (31, 'Dinamarca'),
  (32, 'Egipto'),
  (33, 'Emiratos Árabes Unidos'),
  (34, 'Finlandia'),
  (35, 'Grecia'),
  (36, 'Irlanda'),
  (37, 'Israel'),
  (38, 'Malasia'),
  (39, 'Noruega'),
  (40, 'Nueva Zelanda'),
  (41, 'Perú'),
  (42, 'Singapur'),
  (43, 'Sudáfrica'),
  (44, 'Tailandia');

-- Volcando estructura para tabla buenbuceo.redes_sociales
CREATE TABLE IF NOT EXISTS `redes_sociales` (
  `redSocialId` int(11) DEFAULT NULL,
  `red` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.redes_sociales: ~4 rows (aproximadamente)
INSERT INTO `redes_sociales` (`redSocialId`, `red`) VALUES
  (1, 'Instagram'),
  (2, 'Facebook'),
  (3, 'Linkedin'),
  (4, 'TikTok');

-- Volcando estructura para tabla buenbuceo.sexo
CREATE TABLE IF NOT EXISTS `sexo` (
  `sexoId` int(11) NOT NULL AUTO_INCREMENT,
  `sexo` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sexoId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.sexo: ~2 rows (aproximadamente)
INSERT INTO `sexo` (`sexoId`, `sexo`) VALUES
  (1, 'Hombre'),
  (2, 'Mujer');

-- Volcando estructura para tabla buenbuceo.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuarioId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `apodo` varchar(100) DEFAULT NULL,
  `altura` varchar(100) DEFAULT NULL,
  `peso` varchar(100) DEFAULT NULL,
  `talle` varchar(100) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT 1,
  `paisId` int(11) DEFAULT NULL,
  `sexoId` int(1) DEFAULT NULL,
  PRIMARY KEY (`usuarioId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.usuarios: ~27 rows (aproximadamente)
INSERT INTO `usuarios` (`usuarioId`, `nombre`, `apellido`, `email`, `dni`, `apodo`, `altura`, `peso`, `talle`, `comentario`, `direccion`, `ciudad`, `fecha_registro`, `fecha_nacimiento`, `imagen`, `habilitado_sys`, `paisId`, `sexoId`) VALUES
  (1, 'Nicolas', 'Erriquenz', 'nykolasvs@gmail.com', 29767357, 'Nykkodor', NULL, NULL, NULL, 'Good person', 'Rosario 440', 'Buenos Aires', '2024-11-03', '1982-09-16', '4_small.jpg', 0, 1, 1),
  (2, 'Facundo', 'Mior', 'nykolasvs@gmail.com', 0, 'cholo', '', '', '', '', 'Rosario 440', 'Buenos Aires', '2024-11-05', '0000-00-00', '2_small.jpg', 0, 1, 0),
  (3, 'Chris', 'Russo', 'pocho@pochopack.com', 0, 'Pochoclo', '178', '95', 'xl', '', '', '', '2024-11-05', '0000-00-00', '3_small.jpg', 0, 0, 0),
  (4, 'Cintia', 'escobar', 'asdasd@asdasd.asd', 2147483647, 'Chola', '', '', '', '', '3011 Av 25 de Mayo', 'GERLI (PDO.DE LANUS)', NULL, '1988-11-30', NULL, 0, 1, 2),
  (5, 'Lucila', '', 'asdasd@asdasd.asd', 2147483647, 'Chola1', '', '', '', '', '3011 Av 25 de Mayo', 'GERLI (PDO.DE LANUS)', NULL, '1988-11-30', '5_small.jpg', 0, 1, 2),
  (6, 'Manu', '', 'asdasd@asdasd.asd', 2147483647, 'Chola', '', '', '', '', '3011 Av 25 de Mayo', 'GERLI (PDO.DE LANUS)', NULL, '1988-11-30', '6_small.jpg', 0, 3, 2),
  (7, 'Dani ', 'Calabrese', 'asdad@asdasd.asd', 235698465, 'El loco', '', '', '', 'que groso el loco', '', '', NULL, '0000-00-00', NULL, 0, 1, 0),
  (8, 'Pablo ', 'Jazma', 'asdad@asdasd.asd', 235698465, 'El loco', '', '', '', 'que groso el loco', '', '', NULL, '1982-09-16', NULL, 0, 1, 0),
  (9, 'Alberto ', 'Sanchez', 'asdasda@sdasd.asd', 0, 'asdasd', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 0, 1, 0),
  (10, 'Enrique', '', 'asdasda@sdasd.asd', 0, 'asdasd', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 0, 1, 0),
  (11, 'Graciela ', 'Merino', 'asdasda@sdasd.asd', 0, 'asdasd', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 0, 1, 0),
  (12, 'Nora ', 'Amago', 'asdasda@asdasd.asd', 0, 'asdads', '', '', '', '', '', '', NULL, '0000-00-00', '12_small.jpg', 0, 1, 0),
  (13, 'Adrián ', 'Robaina', 'asdasda@asdasd.asd', 0, 'asdads', '', '', '', '', '', '', NULL, '0000-00-00', '13_small.jpg', 0, 1, 0),
  (14, 'Ana', 'Carabajal', 'ana@gmail.com', 0, 'Ana', '', '', '', '', '', '', NULL, '0000-00-00', '14_small.jpg', 0, 1, 0),
  (15, 'Meli', '', 'Meli@Meli.com', 0, 'Meli', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (16, 'Eli ', '', 'elimama@mama.com', 0, 'Mamá Meli', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (17, 'Monica', '', 'Monica@Monica.vom', 0, 'Monica', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (18, 'Agustín', '', 'Agustin@Agustin.com', 0, 'Agustín', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (19, 'Adriana ', 'Calabrese', 'Calabrese@Calabrese.com', 0, 'Calabrese', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (20, 'Hernán ', 'Diaz', 'Diaz@Diaz.com', 0, 'Diaz', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (21, 'Carina ', 'Guaragna', 'Guaragna@Guaragna.com', 0, 'Guaragna', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (22, 'María ', 'Gallo', 'Gallo@Gallo.com', 0, 'Gallo', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (23, 'José Manuel ', 'Alvarez', 'Alvarez@Alvarez.com', 0, 'Alvarez', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (24, 'Soledad ', 'Alvarez', 'Alvarez@Alvarez.com', 0, 'Alvarez', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (25, 'Silvia Elizabeth ', 'Encina', 'Encina@Encina.com', 0, 'Encina', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (26, 'Brisa ', 'Diaz', 'Diaz@Diaz.com', 0, 'Diaz', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0),
  (27, 'Adri', '', 'Adri@Adri.com', 0, 'Adri', '', '', '', '', '', '', NULL, '0000-00-00', NULL, 1, 1, 0);

-- Volcando estructura para tabla buenbuceo.usuarios_redes_sociales
CREATE TABLE IF NOT EXISTS `usuarios_redes_sociales` (
  `usuariosRedSocialId` int(11) NOT NULL AUTO_INCREMENT,
  `redId` int(11) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`usuariosRedSocialId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.usuarios_redes_sociales: ~0 rows (aproximadamente)
INSERT INTO `usuarios_redes_sociales` (`usuariosRedSocialId`, `redId`, `usuarioId`, `link`, `username`) VALUES
  (1, 1, 1, 'https://www.instagram.com/nykolasvs/', 'nykolasvs');

-- Volcando estructura para tabla buenbuceo.viajes
CREATE TABLE IF NOT EXISTS `viajes` (
  `viajesId` int(11) NOT NULL AUTO_INCREMENT,
  `paisId` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` int(1) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `viaje_pdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`viajesId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes: ~5 rows (aproximadamente)
INSERT INTO `viajes` (`viajesId`, `paisId`, `anio`, `fecha_inicio`, `fecha_fin`, `activo`, `descripcion`, `viaje_pdf`) VALUES
  (4, 2, 2024, '2024-10-31', '2024-11-04', 0, '', NULL),
  (5, 1, 2024, '2024-11-02', '2024-11-04', 0, '', NULL),
  (6, 26, 2024, '2024-11-02', '2024-11-04', 0, '', NULL),
  (7, 15, 2024, '2024-11-22', '2024-11-30', 1, 'nada', 'Mexico_2024_7_1731872092.pdf');

-- Volcando estructura para tabla buenbuceo.viajes_costos
CREATE TABLE IF NOT EXISTS `viajes_costos` (
  `viajeCostoId` int(11) NOT NULL AUTO_INCREMENT,
  `viajesId` int(11) DEFAULT NULL,
  `pagosSubrubroId` int(11) NOT NULL,
  `monto` double NOT NULL,
  `cotizacion` double DEFAULT NULL,
  `monedaId` int(11) NOT NULL,
  `soloBuzos` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  PRIMARY KEY (`viajeCostoId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_costos: ~9 rows (aproximadamente)
INSERT INTO `viajes_costos` (`viajeCostoId`, `viajesId`, `pagosSubrubroId`, `monto`, `cotizacion`, `monedaId`, `soloBuzos`, `comentario`) VALUES
  (3, 7, 18, 0, 1125, 2, 0, 'Tour Río Secreto o Cobá\n'),
  (4, 7, 18, 129, 1125, 2, 0, 'Tour Chichen Itza\n'),
  (7, 7, 16, 180, 1125, 2, 1, 'Día 3: Tiburón Toro\n'),
  (8, 7, 16, 100, 1125, 2, 1, 'Dia 1: Playa del Carmen'),
  (9, 7, 16, 185, 1125, 2, 1, 'Dia 4: Cozumel\n'),
  (10, 7, 16, 185, 1125, 2, 1, 'Dia 5: Cozumel\n'),
  (11, 7, 16, 185, 1125, 2, 1, 'Día 2: Cozumel\n'),
  (12, 7, 16, 150, 1125, 2, 1, 'Dia 6: Cenote DOS OJOS\n'),
  (13, 7, 15, 30, 1125, 2, 0, 'Bus para 10 personas\n'),
  (17, 7, 17, 5, 1125, 2, 0, '');

-- Volcando estructura para tabla buenbuceo.viajes_costos_usuarios
CREATE TABLE IF NOT EXISTS `viajes_costos_usuarios` (
  `viajesCostosUsuariosId` int(11) NOT NULL AUTO_INCREMENT,
  `viajesUsuariosId` int(11) NOT NULL,
  `viajeCostoId` int(11) NOT NULL,
  `viajesId` int(11) NOT NULL,
  `monto` double NOT NULL,
  PRIMARY KEY (`viajesCostosUsuariosId`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_costos_usuarios: ~194 rows (aproximadamente)
INSERT INTO `viajes_costos_usuarios` (`viajesCostosUsuariosId`, `viajesUsuariosId`, `viajeCostoId`, `viajesId`, `monto`) VALUES
  (47, 12, 4, 7, 129),
  (48, 14, 4, 7, 129),
  (49, 15, 4, 7, 129),
  (50, 18, 4, 7, 129),
  (51, 19, 4, 7, 129),
  (52, 20, 4, 7, 129),
  (53, 21, 4, 7, 129),
  (54, 22, 4, 7, 129),
  (55, 23, 4, 7, 129),
  (56, 24, 4, 7, 129),
  (57, 27, 4, 7, 129),
  (58, 28, 4, 7, 129),
  (59, 29, 4, 7, 129),
  (60, 30, 4, 7, 129),
  (61, 31, 4, 7, 129),
  (62, 32, 4, 7, 129),
  (63, 33, 4, 7, 129),
  (64, 34, 4, 7, 129),
  (65, 35, 4, 7, 129),
  (66, 36, 4, 7, 129),
  (67, 37, 4, 7, 129),
  (68, 38, 4, 7, 129),
  (69, 39, 4, 7, 129),
  (70, 12, 13, 7, 30),
  (71, 14, 13, 7, 30),
  (72, 15, 13, 7, 30),
  (73, 18, 13, 7, 30),
  (74, 19, 13, 7, 30),
  (75, 20, 13, 7, 30),
  (76, 21, 13, 7, 30),
  (77, 22, 13, 7, 30),
  (78, 23, 13, 7, 30),
  (79, 24, 13, 7, 30),
  (80, 27, 13, 7, 30),
  (81, 28, 13, 7, 30),
  (82, 29, 13, 7, 30),
  (83, 30, 13, 7, 30),
  (84, 31, 13, 7, 30),
  (85, 32, 13, 7, 30),
  (86, 33, 13, 7, 30),
  (87, 34, 13, 7, 30),
  (88, 35, 13, 7, 30),
  (89, 36, 13, 7, 30),
  (90, 37, 13, 7, 30),
  (91, 38, 13, 7, 30),
  (92, 39, 13, 7, 30),
  (93, 12, 12, 7, 150),
  (94, 14, 12, 7, 150),
  (95, 15, 12, 7, 150),
  (96, 18, 12, 7, 150),
  (97, 19, 12, 7, 150),
  (98, 20, 12, 7, 150),
  (99, 21, 12, 7, 150),
  (100, 22, 12, 7, 150),
  (101, 23, 12, 7, 150),
  (102, 24, 12, 7, 150),
  (103, 27, 12, 7, 150),
  (104, 30, 12, 7, 150),
  (105, 33, 12, 7, 150),
  (106, 34, 12, 7, 150),
  (107, 35, 12, 7, 150),
  (108, 36, 12, 7, 150),
  (109, 38, 12, 7, 150),
  (110, 12, 11, 7, 185),
  (111, 14, 11, 7, 185),
  (112, 15, 11, 7, 185),
  (113, 18, 11, 7, 185),
  (114, 19, 11, 7, 185),
  (115, 20, 11, 7, 185),
  (116, 21, 11, 7, 185),
  (117, 22, 11, 7, 185),
  (118, 23, 11, 7, 185),
  (119, 24, 11, 7, 185),
  (120, 27, 11, 7, 185),
  (121, 30, 11, 7, 185),
  (122, 33, 11, 7, 185),
  (123, 34, 11, 7, 185),
  (124, 35, 11, 7, 185),
  (125, 36, 11, 7, 185),
  (126, 38, 11, 7, 185),
  (127, 12, 10, 7, 185),
  (128, 14, 10, 7, 185),
  (129, 15, 10, 7, 185),
  (130, 18, 10, 7, 185),
  (131, 19, 10, 7, 185),
  (132, 20, 10, 7, 185),
  (133, 21, 10, 7, 185),
  (134, 22, 10, 7, 185),
  (135, 23, 10, 7, 185),
  (136, 24, 10, 7, 185),
  (137, 27, 10, 7, 185),
  (138, 30, 10, 7, 185),
  (139, 33, 10, 7, 185),
  (140, 34, 10, 7, 185),
  (141, 35, 10, 7, 185),
  (142, 36, 10, 7, 185),
  (143, 38, 10, 7, 185),
  (144, 12, 9, 7, 185),
  (145, 14, 9, 7, 185),
  (146, 15, 9, 7, 185),
  (147, 18, 9, 7, 185),
  (148, 19, 9, 7, 185),
  (149, 20, 9, 7, 185),
  (150, 21, 9, 7, 185),
  (151, 22, 9, 7, 185),
  (152, 23, 9, 7, 185),
  (153, 24, 9, 7, 185),
  (154, 27, 9, 7, 185),
  (155, 30, 9, 7, 185),
  (156, 33, 9, 7, 185),
  (157, 34, 9, 7, 185),
  (158, 35, 9, 7, 185),
  (159, 36, 9, 7, 185),
  (160, 38, 9, 7, 185),
  (161, 12, 8, 7, 100),
  (162, 14, 8, 7, 100),
  (163, 15, 8, 7, 100),
  (164, 18, 8, 7, 100),
  (165, 19, 8, 7, 100),
  (166, 20, 8, 7, 100),
  (167, 21, 8, 7, 100),
  (168, 22, 8, 7, 100),
  (169, 23, 8, 7, 100),
  (170, 24, 8, 7, 100),
  (171, 27, 8, 7, 100),
  (172, 30, 8, 7, 100),
  (173, 33, 8, 7, 100),
  (174, 34, 8, 7, 100),
  (175, 35, 8, 7, 100),
  (176, 36, 8, 7, 100),
  (177, 38, 8, 7, 100),
  (178, 12, 7, 7, 180),
  (179, 14, 7, 7, 180),
  (180, 15, 7, 7, 180),
  (181, 18, 7, 7, 180),
  (182, 19, 7, 7, 180),
  (183, 20, 7, 7, 180),
  (184, 21, 7, 7, 180),
  (185, 22, 7, 7, 180),
  (186, 23, 7, 7, 180),
  (187, 24, 7, 7, 180),
  (188, 27, 7, 7, 180),
  (189, 30, 7, 7, 180),
  (190, 33, 7, 7, 180),
  (191, 34, 7, 7, 180),
  (192, 35, 7, 7, 180),
  (193, 36, 7, 7, 180),
  (194, 38, 7, 7, 180),
  (264, 12, 17, 7, 5),
  (265, 14, 17, 7, 5),
  (266, 15, 17, 7, 5),
  (267, 18, 17, 7, 5),
  (268, 19, 17, 7, 5),
  (269, 20, 17, 7, 5),
  (270, 21, 17, 7, 5),
  (271, 22, 17, 7, 5),
  (272, 23, 17, 7, 5),
  (273, 24, 17, 7, 5),
  (274, 27, 17, 7, 5),
  (275, 28, 17, 7, 5),
  (276, 29, 17, 7, 5),
  (277, 30, 17, 7, 5),
  (278, 31, 17, 7, 5),
  (279, 32, 17, 7, 5),
  (280, 33, 17, 7, 5),
  (281, 34, 17, 7, 5),
  (282, 35, 17, 7, 5),
  (283, 36, 17, 7, 5),
  (284, 37, 17, 7, 5),
  (285, 38, 17, 7, 5),
  (286, 39, 17, 7, 5),
  (287, 12, 3, 7, 0),
  (288, 14, 3, 7, 0),
  (289, 15, 3, 7, 0),
  (290, 18, 3, 7, 0),
  (291, 19, 3, 7, 0),
  (292, 20, 3, 7, 0),
  (293, 21, 3, 7, 0),
  (294, 22, 3, 7, 0),
  (295, 23, 3, 7, 0),
  (296, 24, 3, 7, 0),
  (297, 27, 3, 7, 0),
  (298, 28, 3, 7, 0),
  (299, 29, 3, 7, 0),
  (300, 30, 3, 7, 0),
  (301, 31, 3, 7, 0),
  (302, 32, 3, 7, 0),
  (303, 33, 3, 7, 0),
  (304, 34, 3, 7, 0),
  (305, 35, 3, 7, 0),
  (306, 36, 3, 7, 0),
  (307, 37, 3, 7, 0),
  (308, 38, 3, 7, 0),
  (309, 39, 3, 7, 0);

-- Volcando estructura para tabla buenbuceo.viajes_hospedajes
CREATE TABLE IF NOT EXISTS `viajes_hospedajes` (
  `viajesHospedajesId` int(11) NOT NULL AUTO_INCREMENT,
  `viajesId` int(11) NOT NULL,
  `hospedajesId` int(11) NOT NULL,
  PRIMARY KEY (`viajesHospedajesId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_hospedajes: ~1 rows (aproximadamente)
INSERT INTO `viajes_hospedajes` (`viajesHospedajesId`, `viajesId`, `hospedajesId`) VALUES
  (4, 7, 3);

-- Volcando estructura para tabla buenbuceo.viajes_hospedajes_habitaciones
CREATE TABLE IF NOT EXISTS `viajes_hospedajes_habitaciones` (
  `viajesHospedajesHabitacionId` int(11) NOT NULL AUTO_INCREMENT,
  `viajesHospedajesId` int(11) DEFAULT NULL,
  `hospedajeTarifaId` int(11) DEFAULT NULL,
  `camas_dobles` int(11) DEFAULT NULL,
  `camas_simples` int(11) DEFAULT NULL,
  `comentario` varchar(100) DEFAULT NULL,
  `codigo_reserva` varchar(10) DEFAULT NULL,
  `reserva_nombre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`viajesHospedajesHabitacionId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_hospedajes_habitaciones: ~5 rows (aproximadamente)
INSERT INTO `viajes_hospedajes_habitaciones` (`viajesHospedajesHabitacionId`, `viajesHospedajesId`, `hospedajeTarifaId`, `camas_dobles`, `camas_simples`, `comentario`, `codigo_reserva`, `reserva_nombre`) VALUES
  (59, 4, 12, 1, 0, NULL, 'CGKBW456', 'Ana'),
  (60, 4, 17, 0, 1, NULL, 'CGKBW456', 'Cholo'),
  (61, 4, 16, 1, 0, NULL, '', ''),
  (62, 4, 12, 1, 0, NULL, '', ''),
  (63, 4, 17, 0, 1, NULL, '', ''),
  (64, 4, 17, 0, 1, NULL, '', '');

-- Volcando estructura para tabla buenbuceo.viajes_hospedajes_habitaciones_usuarios
CREATE TABLE IF NOT EXISTS `viajes_hospedajes_habitaciones_usuarios` (
  `viajesUsuariosId` int(11) NOT NULL,
  `viajesHospedajesHabitacionId` int(11) DEFAULT NULL,
  `viajesHospedajesId` int(11) DEFAULT NULL,
  `cama_doble` int(1) DEFAULT NULL,
  `cama_simple` int(1) DEFAULT NULL,
  PRIMARY KEY (`viajesUsuariosId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_hospedajes_habitaciones_usuarios: ~8 rows (aproximadamente)
INSERT INTO `viajes_hospedajes_habitaciones_usuarios` (`viajesUsuariosId`, `viajesHospedajesHabitacionId`, `viajesHospedajesId`, `cama_doble`, `cama_simple`) VALUES
  (18, 62, 4, 1, 0),
  (20, 59, 4, 1, 0),
  (22, 60, 4, 0, 1),
  (23, 61, 4, 1, 0),
  (27, 62, 4, 1, 0),
  (33, 61, 4, 1, 0),
  (34, 64, 4, 0, 1),
  (35, 63, 4, 0, 1),
  (38, 59, 4, 1, 0);

-- Volcando estructura para tabla buenbuceo.viajes_usuarios
CREATE TABLE IF NOT EXISTS `viajes_usuarios` (
  `viajesUsuariosId` int(11) NOT NULL AUTO_INCREMENT,
  `viajesId` int(11) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL,
  `viajeroTipoId` int(11) DEFAULT NULL,
  `venta_paquete` double DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`viajesUsuariosId`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_usuarios: ~26 rows (aproximadamente)
INSERT INTO `viajes_usuarios` (`viajesUsuariosId`, `viajesId`, `usuarioId`, `viajeroTipoId`, `venta_paquete`, `habilitado_sys`) VALUES
  (7, 6, 1, 5, NULL, 1),
  (8, 6, 3, 2, NULL, 1),
  (9, 6, 2, 5, NULL, 1),
  (12, 7, 5, 7, 3200, 1),
  (14, 7, 6, 5, 2900, 1),
  (15, 7, 11, 7, 2900, 1),
  (18, 7, 2, 2, NULL, 1),
  (19, 7, 7, 5, 3900, 1),
  (20, 7, 8, 1, 2529, 1),
  (21, 7, 9, 7, 2900, 1),
  (22, 7, 10, 2, NULL, 1),
  (23, 7, 12, 5, 2900, 1),
  (24, 7, 13, 2, 2900, 1),
  (27, 7, 14, 1, NULL, 1),
  (28, 7, 17, 3, NULL, 1),
  (29, 7, 16, 3, 2180, 1),
  (30, 7, 15, 4, 2900, 1),
  (31, 7, 18, 3, NULL, 1),
  (32, 7, 19, 3, 2750, 1),
  (33, 7, 21, 1, 2900, 1),
  (34, 7, 22, 4, 4000, 1),
  (35, 7, 20, 4, 4000, 1),
  (36, 7, 23, 4, 3200, 1),
  (37, 7, 24, 3, 2400, 1),
  (38, 7, 25, 6, 3200, 1),
  (39, 7, 27, 3, 3500, 1);

-- Volcando estructura para tabla buenbuceo.viajes_viajero_tipo
CREATE TABLE IF NOT EXISTS `viajes_viajero_tipo` (
  `viajeroTipoId` int(11) NOT NULL AUTO_INCREMENT,
  `viajero_tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`viajeroTipoId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo.viajes_viajero_tipo: ~7 rows (aproximadamente)
INSERT INTO `viajes_viajero_tipo` (`viajeroTipoId`, `viajero_tipo`) VALUES
  (1, 'Buzo - Instructor'),
  (2, 'Buzo - Divemaster'),
  (3, 'Acompañante'),
  (4, 'Buzo - Open'),
  (5, 'Buzo - Advanced'),
  (6, 'Buzo - Rescue'),
  (7, 'Buzo - Checkout');

-- Volcando estructura para tabla buenbuceo._deuda_tipo
CREATE TABLE IF NOT EXISTS `_deuda_tipo` (
  `deudaTipoId` int(11) NOT NULL AUTO_INCREMENT,
  `deuda` varchar(50) DEFAULT NULL,
  `comentario` varchar(50) DEFAULT NULL,
  `habilitado_sys` int(1) DEFAULT NULL,
  PRIMARY KEY (`deudaTipoId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla buenbuceo._deuda_tipo: ~3 rows (aproximadamente)
INSERT INTO `_deuda_tipo` (`deudaTipoId`, `deuda`, `comentario`, `habilitado_sys`) VALUES
  (1, 'Curso de Open', '', 1),
  (2, 'Alquiler de equipos', '', 1),
  (3, 'Viajes - Paquetes', '', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
