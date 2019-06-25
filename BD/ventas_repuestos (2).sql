-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2019 a las 01:26:46
-- Versión del servidor: 10.1.35-MariaDB
-- Versión de PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas_repuestos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

CREATE TABLE `bodegas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `seleccion_ventas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`id`, `nombre`, `estado`, `seleccion_ventas`) VALUES
(1, 'Repuestos', 1, 0),
(2, 'Accesorios', 1, 0),
(3, 'Devoluciones', 1, 0),
(4, 'Principal', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega_sucursal`
--

CREATE TABLE `bodega_sucursal` (
  `id` int(11) NOT NULL,
  `bodega_id` int(11) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bodega_sucursal`
--

INSERT INTO `bodega_sucursal` (`id`, `bodega_id`, `sucursal_id`, `estado`) VALUES
(1, 2, 1, 1),
(2, 1, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 1, 2, 1),
(6, 2, 2, 1),
(7, 4, 2, 1),
(8, 4, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega_sucursal_producto`
--

CREATE TABLE `bodega_sucursal_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `bodega_id` int(11) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bodega_sucursal_producto`
--

INSERT INTO `bodega_sucursal_producto` (`id`, `producto_id`, `bodega_id`, `sucursal_id`, `estado`, `stock`) VALUES
(1, 1, 2, 1, 1, 0),
(2, 2, 2, 1, 1, 10),
(3, 1, 1, 1, 1, 0),
(4, 2, 1, 1, 1, 0),
(5, 1, 3, 1, 1, 0),
(6, 2, 3, 1, 1, 12),
(7, 1, 1, 2, 1, 0),
(8, 2, 1, 2, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_apertura` decimal(10,2) DEFAULT NULL,
  `monto_efectivo` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `observaciones` text,
  `sucursal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `usuario_id`, `fecha_apertura`, `fecha_cierre`, `monto_apertura`, `monto_efectivo`, `estado`, `observaciones`, `sucursal_id`) VALUES
(1, 1, '2019-06-21 22:20:01', NULL, '200.00', NULL, 1, NULL, 1),
(2, 1, '2019-06-21 22:43:07', NULL, '200.00', NULL, 1, NULL, 2),
(3, 1, '2019-06-21 22:43:16', NULL, '300.00', NULL, 1, NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calidades`
--

CREATE TABLE `calidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `calidades`
--

INSERT INTO `calidades` (`id`, `nombre`, `estado`, `descripcion`) VALUES
(1, 'China', 1, 'calidad de china'),
(2, 'Japon', 1, 'calidad de japon'),
(3, 'tailandia', 1, 'calidad de tailandia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `estado`, `descripcion`) VALUES
(1, 'Categoria 01', 1, NULL),
(2, 'Categoria 012', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(200) DEFAULT NULL,
  `apellidos` varchar(200) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `cedula`, `telefono`, `direccion`, `nit`, `estado`) VALUES
(1, 'juan miguel', 'Manqirue', '12121212', '988898989', 'miramar d-14 pb', '212121', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobros`
--

CREATE TABLE `cobros` (
  `id` int(11) NOT NULL,
  `cuenta_cobrar_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compatibilidades`
--

CREATE TABLE `compatibilidades` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compatibilidades`
--

INSERT INTO `compatibilidades` (`id`, `producto_id`, `modelo_id`) VALUES
(1, 1, 2),
(7, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `numero_comprobante` varchar(45) DEFAULT NULL,
  `comprobante_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `tipo_pago` tinyint(1) DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha`, `serie`, `numero_comprobante`, `comprobante_id`, `estado`, `subtotal`, `total`, `tipo_pago`, `proveedor_id`, `sucursal_id`) VALUES
(1, '2019-06-21', '001', '000012', 2, 1, '300.00', '300.00', 1, 1, 1),
(2, '2019-06-21', '001', '000013', 2, 1, '300.00', '300.00', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `permitir_anular` tinyint(1) DEFAULT NULL,
  `solicitar_nit` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id`, `nombre`, `descripcion`, `estado`, `permitir_anular`, `solicitar_nit`) VALUES
(1, 'FACTURA', 'Comprobante Factura', 1, 0, NULL),
(2, 'BOLETA', 'Comprobante Boleta', 1, 1, NULL),
(3, 'TICKET', 'Comprobante Ticket', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_sucursal`
--

CREATE TABLE `comprobante_sucursal` (
  `id` int(11) NOT NULL,
  `comprobante_id` int(11) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `serie` varchar(20) DEFAULT NULL,
  `numero_inicial` int(11) DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `fecha_aprobacion_sat` date DEFAULT NULL,
  `fecha_vencimiento_sat` date DEFAULT NULL,
  `dias_vencimiento` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `realizados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comprobante_sucursal`
--

INSERT INTO `comprobante_sucursal` (`id`, `comprobante_id`, `sucursal_id`, `serie`, `numero_inicial`, `limite`, `fecha_aprobacion_sat`, `fecha_vencimiento_sat`, `dias_vencimiento`, `estado`, `realizados`) VALUES
(1, 1, 1, '001', 1, 100, '2019-06-10', '2019-09-09', 90, 1, 0),
(3, 2, 1, '001', 1, 100, '2019-06-02', '2019-09-03', 90, 1, 1),
(4, 1, 2, '002', 1, 100, '2019-06-02', '2019-06-03', 90, 1, 0),
(5, 2, 2, '001', 1, 200, '2019-01-02', '2019-06-05', 90, 1, 0),
(6, 3, 1, '001', 1, 100, '2019-05-04', '2019-08-02', 90, 1, 0),
(7, 1, 3, '001', 1, 100, '2019-02-01', '2019-06-03', 60, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id` int(11) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_cobrar`
--

CREATE TABLE `cuentas_cobrar` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_pagar`
--

CREATE TABLE `cuentas_pagar` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuentas_pagar`
--

INSERT INTO `cuentas_pagar` (`id`, `compra_id`, `monto`, `fecha`, `estado`) VALUES
(1, 2, '300.00', '2019-06-21', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `compra_id`, `producto_id`, `precio`, `cantidad`, `importe`) VALUES
(1, 1, 2, '25.00', 12, '300.00'),
(2, 2, 2, '25.00', 12, '300.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio`, `importe`) VALUES
(1, 8, 2, 2, '30.00', '60.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabricantes`
--

CREATE TABLE `fabricantes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fabricantes`
--

INSERT INTO `fabricantes` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Fabricante 01', 'descripcion de la fabricante 01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`, `estado`, `descripcion`) VALUES
(1, 'Marca 01', 1, 'descripcion Marca 01'),
(2, 'Marca 02', 1, 'Descripcion Marca 02'),
(3, 'Marca 03', 1, 'descripcion de la marca 03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `icono` varchar(150) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `url`, `nombre`, `icono`, `parent`, `orden`, `estado`) VALUES
(1, 'backend/dashboard', 'Dashboard', 'fa fa-dashboard', 0, 1, 1),
(2, '#', 'Almacén', 'fa fa-database', 0, 2, 1),
(4, '#', 'Caja', 'fa fa-calculator', 0, 3, 1),
(5, '#', 'Movimientos', 'fa fa-cart-plus', 0, 4, 1),
(6, '#', 'Reportes', 'fa fa-print', 0, 5, 1),
(7, 'backend/cuentas_cobrar', 'Cuentas por Cobrar', 'fa fa-money', 0, 6, 1),
(8, 'backend/cuentas_pagar', 'Cuentas por Pagar', 'fa fa-money', 0, 7, 1),
(9, '#', 'Administrador', 'fa fa-user', 0, 8, 1),
(10, 'almacen/bodegas', 'Bodegas', 'fa fa-circle-o', 2, 1, 1),
(11, 'almacen/traslados', 'Traslados', 'fa fa-circle-o', 2, 2, 1),
(12, 'almacen/devoluciones', 'Devoluciones', 'fa fa-circle-o', 2, 3, 1),
(13, 'almacen/productos', 'Productos', 'fa fa-circle-o', 2, 4, 1),
(14, 'almacen/categorias', 'Categorias', 'fa fa-circle-o', 2, 5, 1),
(15, 'almacen/subcategorias', 'Subcategorias', 'fa fa-circle-o', 2, 6, 1),
(16, 'almacen/calidades', 'Calidades', 'fa fa-circle-o', 2, 7, 1),
(17, 'almacen/marcas', 'Marcas', 'fa fa-circle-o', 2, 8, 1),
(18, 'almacen/fabricantes', 'Fabricantes', 'fa fa-circle-o', 2, 9, 1),
(19, 'almacen/modelos', 'Modelos', 'fa fa-circle-o', 2, 10, 1),
(20, 'almacen/years', 'Años', 'fa fa-circle-o', 2, 11, 1),
(21, 'almacen/presentaciones', 'Presentaciones', 'fa fa-circle-o', 2, 12, 1),
(22, 'almacen/proveedores', 'Proveedores', 'fa fa-circle-o', 2, 13, 1),
(23, 'almacen/ajuste', 'Ajuste de Inventario', 'fa fa-circle-o', 2, 14, 1),
(24, 'caja/apertura_cierre', 'Aperturas y Cierre', 'fa fa-circle-o', 4, 1, 1),
(25, 'caja/gastos', 'Gastos', 'fa fa-circle-o', 4, 2, 1),
(26, 'movimientos/compras', 'Compras', 'fa fa-circle-o', 5, 1, 1),
(27, 'movimientos/ventas', 'Ventas', 'fa fa-circle-o', 5, 2, 1),
(28, 'backend/reportes/ventas', 'Reporte de Ventas', 'fa fa-circle-o', 6, 1, 1),
(29, 'backend/reportes/productos', 'Reporte de Productos', 'fa fa-circle-o', 6, 2, 1),
(30, 'backend/reportes/compras', 'Reporte de Compras', 'fa fa-circle-o', 6, 3, 1),
(31, 'backend/reportes/ganancias', 'Reporte de Ganancias', 'fa fa-circle-o', 6, 4, 1),
(32, 'backend/reportes/inventario', 'Reporte de Inventario', 'fa fa-circle-o', 6, 5, 1),
(33, 'administrador/usuarios', 'Usuarios', 'fa fa-circle-o', 9, 1, 1),
(34, 'administrador/permisos', 'Permisos', 'fa fa-circle-o', 9, 2, 1),
(35, 'administrador/correos', 'Correos', 'fa fa-circle-o', 9, 3, 1),
(36, 'administrador/tarjetas', 'Tarjetas', 'fa fa-circle-o', 9, 4, 1),
(37, 'administrador/tipo_comprobantes', 'Tipos de Comprobantes', 'fa fa-circle-o', 9, 5, 1),
(38, 'administrador/comprobantes', 'Comprobantes', 'fa fa-circle-o', 9, 6, 1),
(39, 'administrador/sucursales', 'Sucursales', 'fa fa-circle-o', 9, 7, 1),
(40, 'administrador/roles', 'Roles', 'fa fa-circle-o', 9, 8, 1),
(41, 'administrador/menus', 'Menús', 'fa fa-circle-o', 9, 9, 1),
(42, 'almacen/tipo_bodegas', 'Tipo de Bodegas', 'fa fa-circle-o', 2, 15, 1),
(43, 'almacen/tipo_precios', 'Tipo de Precios', 'fa fa-circle-o', 2, 16, 1),
(44, '#', 'Inventario', 'fa fa-cogs', 0, 9, 1),
(45, 'inventario/productos', 'Inventario productos', 'fa fa-circle-o', 44, 1, 1),
(46, 'almacen/clientes', 'Clientes', 'fa fa-circle-o', 2, 17, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `estado`, `descripcion`) VALUES
(1, 'Modelo 01', 1, 'descripcion del modelo 01'),
(2, 'Modelo 02', 1, 'descripcion del modelo 02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `cuenta_pagar_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `read` int(11) DEFAULT NULL,
  `insert` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  `delete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `menu_id`, `rol_id`, `read`, `insert`, `update`, `delete`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 2, 1, 1, 1, 1, 1),
(3, 4, 1, 1, 1, 1, 1),
(4, 5, 1, 1, 1, 1, 1),
(5, 6, 1, 1, 1, 1, 1),
(6, 7, 1, 1, 1, 1, 1),
(7, 8, 1, 1, 1, 1, 1),
(8, 9, 1, 1, 1, 1, 1),
(9, 10, 1, 1, 1, 1, 1),
(10, 11, 1, 1, 1, 1, 1),
(11, 12, 1, 1, 1, 1, 1),
(12, 13, 1, 1, 1, 1, 1),
(13, 14, 1, 1, 1, 1, 1),
(14, 15, 1, 1, 1, 1, 1),
(15, 16, 1, 1, 1, 1, 1),
(16, 17, 1, 1, 1, 1, 1),
(17, 18, 1, 1, 1, 1, 1),
(18, 19, 1, 1, 1, 1, 1),
(19, 20, 1, 1, 1, 1, 1),
(20, 21, 1, 1, 1, 1, 1),
(21, 22, 1, 1, 1, 1, 1),
(22, 23, 1, 1, 1, 1, 1),
(23, 24, 1, 1, 1, 1, 1),
(24, 25, 1, 1, 1, 1, 1),
(25, 26, 1, 1, 1, 1, 1),
(26, 27, 1, 1, 1, 1, 1),
(27, 28, 1, 1, 1, 1, 1),
(28, 29, 1, 1, 1, 1, 1),
(29, 30, 1, 1, 1, 1, 1),
(30, 31, 1, 1, 1, 1, 1),
(31, 32, 1, 1, 1, 1, 1),
(32, 33, 1, 1, 1, 1, 1),
(33, 34, 1, 1, 1, 1, 1),
(34, 35, 1, 1, 1, 1, 1),
(35, 36, 1, 1, 1, 1, 1),
(36, 37, 1, 1, 1, 1, 1),
(37, 38, 1, 1, 1, 1, 1),
(38, 39, 1, 1, 1, 1, 1),
(39, 40, 1, 1, 1, 1, 1),
(40, 41, 1, 1, 1, 1, 1),
(41, 1, 2, 1, 1, 1, 1),
(42, 4, 2, 1, 1, 1, 1),
(43, 5, 2, 1, 1, 1, 1),
(44, 6, 2, 1, 1, 1, 1),
(45, 7, 2, 1, 1, 1, 1),
(46, 8, 2, 1, 1, 1, 1),
(47, 9, 2, 1, 1, 1, 1),
(48, 28, 2, 1, 1, 1, 1),
(49, 38, 2, 1, 0, 0, 0),
(50, 42, 1, 1, 1, 1, 1),
(51, 2, 2, 1, 1, 1, 1),
(52, 10, 2, 1, 1, 1, 1),
(53, 43, 1, 1, 1, 1, 1),
(54, 44, 1, 1, 1, 1, 1),
(55, 45, 1, 1, 1, 1, 1),
(56, 44, 2, 1, 1, 1, 1),
(57, 45, 2, 1, 1, 1, 1),
(58, 24, 2, 1, 1, 1, 1),
(59, 46, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Menorista', 'precio a compradores normales', 1),
(2, 'Mayoristas', 'precio para negociantes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Botella', 'presentaciones en botella', 1),
(2, 'Galonera', 'presentacion en galonera', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `fabricante_id` int(11) DEFAULT NULL,
  `modelo_id` int(11) DEFAULT NULL,
  `calidad_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `subcategoria_id` int(11) DEFAULT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `presentacion_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_barras`, `nombre`, `descripcion`, `year_id`, `fabricante_id`, `modelo_id`, `calidad_id`, `categoria_id`, `subcategoria_id`, `marca_id`, `presentacion_id`, `estado`, `stock_minimo`) VALUES
(1, '1100911112', 'Aceite Castrol 20W-50', 'Aceite Castrol 20W-50', 1, 1, 2, 2, 2, 2, 1, 2, 1, 10),
(2, '1100911112', 'Juego de Destornilladores', 'Juego de Destornilladores', 1, 1, 2, 2, 2, 2, 1, 2, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_asociados`
--

CREATE TABLE `productos_asociados` (
  `id` int(11) NOT NULL,
  `producto_original` int(11) DEFAULT NULL,
  `producto_asociado` int(11) DEFAULT NULL,
  `cantidad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_precio`
--

CREATE TABLE `producto_precio` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `precio_id` int(11) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_precio`
--

INSERT INTO `producto_precio` (`id`, `producto_id`, `precio_id`, `precio_venta`, `precio_compra`, `estado`) VALUES
(7, 2, 1, '30.00', '25.00', 1),
(8, 2, 2, '35.00', '30.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nit` varchar(45) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nit`, `nombre`, `direccion`, `telefono`, `email`, `estado`) VALUES
(1, '10101010', 'Proveedor 01', 'miramar d-14 pb', '484804', 'fesun.servicios@fesun.com.co', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` text,
  `total_access` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `estado`, `descripcion`, `total_access`) VALUES
(1, 'Superadmin', 1, 'tiene acceso a todas las funciones y sucursales', 1),
(2, 'administrador', 1, 'administrador de sucursal', 0),
(3, 'Cajero ', 1, 'Funciones de caja', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `nombre`, `categoria_id`, `descripcion`, `estado`) VALUES
(1, 'subcategoria 01', 2, 'subcategoria 01 ', 1),
(2, 'subcategoria 02', 2, 'subcategoria 02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `clave_especial` varchar(100) DEFAULT NULL,
  `correo_remitente` varchar(150) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `nombre`, `ubicacion`, `telefono`, `email`, `clave_especial`, `correo_remitente`, `estado`) VALUES
(1, 'Sucursal 1', 'Calle pichincha 204', '454848', 'sucursal1@gmail.com', '123456', 'sucursal1@gmail.com', 1),
(2, 'Sucursal 02', 'Calle moquegua 204', '484848', 'sucursal2@gmail.com', '123456', 'yony_brondy@hotmail.com', 1),
(3, 'Sucursal 03', 'Calle Junin 204', '454848', 'sucursal3@gmail.com', '123456', 'sucursal03@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'VISA', 'TARJETA VISA', 1),
(2, 'Master Card', 'tarjeta master cad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslados`
--

CREATE TABLE `traslados` (
  `id` int(11) NOT NULL,
  `sucursal_envia` int(11) DEFAULT NULL,
  `bodega_envia` int(11) DEFAULT NULL,
  `sucursal_recibe` int(11) DEFAULT NULL,
  `bodega_recibe` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(200) DEFAULT NULL,
  `apellidos` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `username`, `password`, `rol_id`, `sucursal_id`, `estado`) VALUES
(1, 'yony brondy', 'mamani fuentes', 'yonybrondy17@gmail.com', '962655577', 'yonilo', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, NULL, 1),
(2, 'admin', 'admin', 'admin@gmail.com', '454545', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 2, 1, 1),
(3, 'juan miguel', 'Manqirue', 'juan@gmail.com', '454545', 'admin2', '315f166c5aca63a157f7d41007675cb44a948b33', 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `numero_comprobante` varchar(50) DEFAULT NULL,
  `comprobante_id` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `tipo_pago` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `monto_efectivo` decimal(10,2) DEFAULT NULL,
  `monto_credito` decimal(10,2) DEFAULT NULL,
  `monto_tarjeta` decimal(10,2) DEFAULT NULL,
  `tarjeta_id` int(11) DEFAULT '0',
  `caja_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `numero_comprobante`, `comprobante_id`, `estado`, `fecha`, `tipo_pago`, `cliente_id`, `subtotal`, `iva`, `descuento`, `total`, `monto_efectivo`, `monto_credito`, `monto_tarjeta`, `tarjeta_id`, `caja_id`) VALUES
(8, '00000001', 2, 1, '2019-06-24 12:02:39', 1, 1, '60.00', '0.00', '0.00', '60.00', '60.00', '0.00', '0.00', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `years`
--

INSERT INTO `years` (`id`, `year`, `estado`, `descripcion`) VALUES
(1, 2011, 1, 'año del 2011');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `bodega_sucursal`
--
ALTER TABLE `bodega_sucursal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bodega_idx` (`bodega_id`),
  ADD KEY `fk_sucursal_idx` (`sucursal_id`);

--
-- Indices de la tabla `bodega_sucursal_producto`
--
ALTER TABLE `bodega_sucursal_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_idx` (`producto_id`),
  ADD KEY `fk_bodega_idx` (`bodega_id`),
  ADD KEY `fk_sucursal_idx` (`sucursal_id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_idx` (`usuario_id`),
  ADD KEY `fk_sucursales_idx` (`sucursal_id`);

--
-- Indices de la tabla `calidades`
--
ALTER TABLE `calidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula_UNIQUE` (`cedula`);

--
-- Indices de la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fl_cuenta_cobrar_idx` (`cuenta_cobrar_id`);

--
-- Indices de la tabla `compatibilidades`
--
ALTER TABLE `compatibilidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_modelos_idx` (`modelo_id`),
  ADD KEY `fk_productos_idx` (`producto_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedor_idx` (`proveedor_id`),
  ADD KEY `fk_comprobante_idx` (`comprobante_id`),
  ADD KEY `fk_sucursal_compra_idx` (`sucursal_id`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `comprobante_sucursal`
--
ALTER TABLE `comprobante_sucursal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sucursal_idx` (`sucursal_id`),
  ADD KEY `fk_comprobante_idx` (`comprobante_id`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sucursal_idx` (`sucursal_id`);

--
-- Indices de la tabla `cuentas_cobrar`
--
ALTER TABLE `cuentas_cobrar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venta_idx` (`venta_id`);

--
-- Indices de la tabla `cuentas_pagar`
--
ALTER TABLE `cuentas_pagar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_idx` (`compra_id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_idx` (`compra_id`),
  ADD KEY `fk_producto_idx` (`producto_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venta_idx` (`venta_id`),
  ADD KEY `fk_producto_idx` (`producto_id`);

--
-- Indices de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cuenta_pagar_idx` (`cuenta_pagar_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_idx` (`menu_id`),
  ADD KEY `fk_rol_idx` (`rol_id`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_fabricante_idx` (`fabricante_id`),
  ADD KEY `fk_producto_modelo_idx` (`modelo_id`),
  ADD KEY `fk_producto_calidad_idx` (`calidad_id`),
  ADD KEY `fk_producto_categoria_idx` (`categoria_id`),
  ADD KEY `fk_producto_subcategoria_idx` (`subcategoria_id`),
  ADD KEY `fk_producto_marca_idx` (`marca_id`),
  ADD KEY `fk_producto_año_idx` (`year_id`),
  ADD KEY `fk_producto_presentacion_idx` (`presentacion_id`);

--
-- Indices de la tabla `productos_asociados`
--
ALTER TABLE `productos_asociados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_original_idx` (`producto_original`),
  ADD KEY `fk_producto_asociado_idx` (`producto_asociado`);

--
-- Indices de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_presentacion_idx` (`precio_id`),
  ADD KEY `fk_producto_idx` (`producto_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nit_UNIQUE` (`nit`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_subcategoria_categoria_idx` (`categoria_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sucursal_envia_idx` (`sucursal_envia`),
  ADD KEY `fk_bodega_envia_idx` (`bodega_envia`),
  ADD KEY `fk_sucursal_recibe_idx` (`sucursal_recibe`),
  ADD KEY `fk_bodega_recibe_idx` (`bodega_recibe`),
  ADD KEY `fk_producto_idx` (`producto_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_rol_idx` (`rol_id`),
  ADD KEY `fk_sucursal_idx` (`sucursal_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprobante_idx` (`comprobante_id`),
  ADD KEY `fk_cliente_idx` (`cliente_id`),
  ADD KEY `fk_caja_idx` (`caja_id`);

--
-- Indices de la tabla `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `año_UNIQUE` (`year`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bodega_sucursal`
--
ALTER TABLE `bodega_sucursal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `bodega_sucursal_producto`
--
ALTER TABLE `bodega_sucursal_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `calidades`
--
ALTER TABLE `calidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cobros`
--
ALTER TABLE `cobros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compatibilidades`
--
ALTER TABLE `compatibilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comprobante_sucursal`
--
ALTER TABLE `comprobante_sucursal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas_cobrar`
--
ALTER TABLE `cuentas_cobrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas_pagar`
--
ALTER TABLE `cuentas_pagar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fabricantes`
--
ALTER TABLE `fabricantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos_asociados`
--
ALTER TABLE `productos_asociados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `traslados`
--
ALTER TABLE `traslados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodega_sucursal`
--
ALTER TABLE `bodega_sucursal`
  ADD CONSTRAINT `fk_bodega` FOREIGN KEY (`bodega_id`) REFERENCES `bodegas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `bodega_sucursal_producto`
--
ALTER TABLE `bodega_sucursal_producto`
  ADD CONSTRAINT `fk_bodega_sb` FOREIGN KEY (`bodega_id`) REFERENCES `bodegas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_sb` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_sb` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `fk_sucursales` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cobros`
--
ALTER TABLE `cobros`
  ADD CONSTRAINT `fl_cuenta_cobrar` FOREIGN KEY (`cuenta_cobrar_id`) REFERENCES `cuentas_cobrar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compatibilidades`
--
ALTER TABLE `compatibilidades`
  ADD CONSTRAINT `fk_modelos` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_comprobante_compra` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_compra` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comprobante_sucursal`
--
ALTER TABLE `comprobante_sucursal`
  ADD CONSTRAINT `fk_comprobantes` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_comprobante` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `fk_sucursal_correo` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuentas_cobrar`
--
ALTER TABLE `cuentas_cobrar`
  ADD CONSTRAINT `fk_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuentas_pagar`
--
ALTER TABLE `cuentas_pagar`
  ADD CONSTRAINT `fk_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_compra_detalle` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_detallec` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_producto_detalle` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_detalle` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_cuenta_pagar` FOREIGN KEY (`cuenta_pagar_id`) REFERENCES `cuentas_pagar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol_permiso` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_año` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_calidad` FOREIGN KEY (`calidad_id`) REFERENCES `calidades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_fabricante` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_marca` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_modelo` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_presentacion` FOREIGN KEY (`presentacion_id`) REFERENCES `presentaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_subcategoria` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_asociados`
--
ALTER TABLE `productos_asociados`
  ADD CONSTRAINT `fk_producto_asociado` FOREIGN KEY (`producto_asociado`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_original` FOREIGN KEY (`producto_original`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  ADD CONSTRAINT `fk_precio_producto` FOREIGN KEY (`precio_id`) REFERENCES `precios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_precio` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `traslados`
--
ALTER TABLE `traslados`
  ADD CONSTRAINT `fk_bodega_envia` FOREIGN KEY (`bodega_envia`) REFERENCES `bodegas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_recibe` FOREIGN KEY (`bodega_recibe`) REFERENCES `bodegas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_envia` FOREIGN KEY (`sucursal_envia`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_recibe` FOREIGN KEY (`sucursal_recibe`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sucursal_usuario` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_caja_venta` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_venta` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprobante_venta` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
