-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2024 a las 01:30:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pos-copia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`) VALUES
(7, 'CLARO', '2024-09-27 06:58:41'),
(8, 'TIGO', '2024-09-27 06:58:51'),
(9, 'ACCESORIOS', '2024-09-27 06:59:02'),
(10, 'LIBERADO', '2024-09-27 07:04:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `documento` int(11) NOT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`) VALUES
(10, 'Ximena Restrepo', 436346346, 'ximena@gmail.com', '5434-6346', 'calle 45 # 23 - 45', '1999-03-04', 3, '0000-00-00 00:00:00', '2024-10-15 20:53:01'),
(13, 'JUAN LOPEZ RUIZ', 27649578, 'juandv12@gmail.com', '5024-2121', 'Guatemala', '2005-12-04', 4, '2024-10-06 12:05:14', '2024-10-15 20:53:58'),
(15, 'KEILA RAMIREZ', 25252556, 'keilara1515@gmail.com', '4557-7963', 'SANARATE EL PREOGRESO', '1998-12-17', 0, '0000-00-00 00:00:00', '2024-10-15 20:53:32'),
(16, 'SONIA DE PAZ ', 457898, 'sonipas2524@gmail.com', '7925-4646', 'SANARATE EL PREOGRESO', '1976-01-13', 4, '2011-10-24 02:37:57', '2024-10-15 20:52:44'),
(17, 'MARVIN CASTRO', 1515, 'marvincastro@gmail.com', '4578-9698', 'SANARATE EL PREOGRESO', '2005-12-05', 13, '2015-10-24 15:32:10', '2024-10-15 21:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` text NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
(71, 9, '512', 'PROTECTOR MOTO E20', 'vistas/img/productos/512/603.jpg', 19, 20, 50, 4, '2024-10-11 08:37:57'),
(72, 9, '0201', 'PROTECTOR A33', 'vistas/img/productos/0201/247.jpg', 15, 20, 25, 0, '2024-10-11 08:35:08'),
(73, 7, '0104', 'CAT B15 NEGRO', 'vistas/img/productos/0104/275.jpg', 7, 250, 675, 1, '2024-10-11 08:33:12'),
(74, 9, '0000', 'HIDROGEL', 'vistas/img/productos/0000/775.jpg', 105, 25, 85, 16, '2024-10-15 21:32:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(67, 'Zayda Carrera', 'zayda', '', 'Especial', 'vistas/img/usuarios/zayda/840.jpg', 1, '2024-10-06 16:45:21', '2024-10-11 08:26:07'),
(68, 'Maribel Moreno', 'maribel', '', 'Vendedor', 'vistas/img/usuarios/maribel/917.png', 1, '2024-10-08 22:59:41', '2024-10-11 08:28:04'),
(69, 'Especial', 'especial', '$2a$07$asxx54ahjppf45sd87a5auf9Eiqdn10E7o/jsGFivN12XE.wRwyp6', 'Especial', '', 1, '2024-10-08 22:42:16', '2024-10-09 03:42:16'),
(70, 'Kevin Rodas', 'kevin', '$2a$07$asxx54ahjppf45sd87a5au2fXYgiBckPHlskyXf9ZPVL5Mfo.zI1G', 'Administrador', 'vistas/img/usuarios/kevin/217.png', 1, '2024-10-10 01:58:14', '2024-10-10 06:58:14'),
(71, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/696.jpg', 1, '2024-10-14 18:38:19', '2024-10-14 23:38:19'),
(72, 'Velvet González', 'velvet', '$2a$07$asxx54ahjppf45sd87a5audTi5RA.xVhtFMt7r/Y3gqslwXVjrJ72', 'Administrador', 'vistas/img/usuarios/velvet/158.jpg', 1, '0000-00-00 00:00:00', '2024-10-11 08:27:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `fecha`) VALUES
(63, 63, 16, 71, '[{\"id\":\"74\",\"descripcion\":\"HIDROGEL\",\"cantidad\":\"1\",\"stock\":\"119\",\"precio\":\"85\",\"total\":\"85\"},{\"id\":\"73\",\"descripcion\":\"CAT B15 NEGRO\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"675\",\"total\":\"675\"}]', 0, 760, 760, 'Efectivo', '2024-10-11 08:33:12'),
(64, 64, 13, 71, '[{\"id\":\"64\",\"descripcion\":\"SM A15 4GB128GB WHITE\",\"cantidad\":\"1\",\"stock\":\"5\",\"precio\":\"140\",\"total\":\"140\"},{\"id\":\"66\",\"descripcion\":\"HONOR X7B 256GB 8GB CELESTE\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"1750\",\"total\":\"1750\"}]', 0, 1890, 1890, 'TC-252526', '2024-10-11 08:33:37'),
(65, 65, 14, 71, '[{\"id\":\"74\",\"descripcion\":\"HIDROGEL\",\"cantidad\":\"1\",\"stock\":\"118\",\"precio\":\"85\",\"total\":\"85\"},{\"id\":\"69\",\"descripcion\":\"CARGADOR TIPO C KBOD\",\"cantidad\":\"1\",\"stock\":\"21\",\"precio\":\"175\",\"total\":\"175\"}]', 0, 260, 260, 'Efectivo', '2024-10-11 08:33:58'),
(66, 66, 16, 71, '[{\"id\":\"74\",\"descripcion\":\"HIDROGEL\",\"cantidad\":\"1\",\"stock\":\"117\",\"precio\":\"85\",\"total\":\"85\"},{\"id\":\"71\",\"descripcion\":\"PROTECTOR MOTO E20\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"50\",\"total\":\"50\"}]', 0, 135, 135, 'TC-1515', '2024-10-11 08:37:57'),
(67, 67, 17, 71, '[{\"id\":\"74\",\"descripcion\":\"HIDROGEL\",\"cantidad\":\"1\",\"stock\":\"116\",\"precio\":\"85\",\"total\":\"85\"}]', 0, 85, 85, 'Efectivo', '2024-10-15 15:22:04'),
(68, 68, 17, 71, '[{\"id\":\"74\",\"descripcion\":\"HIDROGEL\",\"cantidad\":\"12\",\"stock\":\"105\",\"precio\":\"85\",\"total\":\"1020\"}]', 0, 1020, 1020, 'TD-199878', '2024-10-15 21:32:10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
