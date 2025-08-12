-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3000
-- Tiempo de generación: 04-10-2021 a las 16:19:24
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tareas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editar_tareas`
--

CREATE TABLE `editar_tareas` (
  `Id_edition` int(10) NOT NULL,
  `ID_TAREA_MES` int(10) DEFAULT NULL,
  `Id_usuario` int(10) NOT NULL,
  `NOMBRE_TAREA` varchar(120) DEFAULT NULL,
  `MES` varchar(25) DEFAULT NULL,
  `YEA` varchar(10) DEFAULT NULL,
  `ESTATUS` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `editar_tareas`
--

INSERT INTO `editar_tareas` (`Id_edition`, `ID_TAREA_MES`, `Id_usuario`, `NOMBRE_TAREA`, `MES`, `YEA`, `ESTATUS`) VALUES
(313, 1, 1, 'Conciliación Banrural', 'ENERO', '2021', 1),
(315, 1, 1, 'Conciliación Banrural', 'FEBRERO', '2021', 0),
(318, 5, 1, 'Conciliacion Coosajo R.L Principal', 'ENERO', '2021', 1),
(319, 6, 1, 'Conciliacion Coosajo R.L Peces', 'ENERO', '2021', 1),
(320, 7, 1, 'Conciliacion BAC Quetzal', 'ENERO', '2021', 1),
(321, 8, 1, 'Conciliacion BAC Dolar', 'ENERO', '2021', 1),
(347, 9, 1, 'Integración Construcciones en proceso', 'ENERO', '2021', 1),
(349, 5, 1, 'Conciliacion Coosajo R.L Principal', 'FEBRERO', '2021', 0),
(350, 6, 1, 'Conciliacion Coosajo R.L Peces', 'FEBRERO', '2021', 0),
(351, 7, 1, 'BAC Quetzal', 'FEBRERO', '2021', 1),
(352, 8, 1, 'BAC Dolar', 'FEBRERO', '2021', 1),
(384, 1, 1, 'Conciliación Banrural', 'JULIO', '2021', 1),
(385, 5, 1, 'Conciliacion Coosajo R.L Principal', 'JULIO', '2021', 1),
(386, 6, 1, 'Conciliacion Coosajo R.L Peces', 'JULIO', '2021', 1),
(387, 7, 1, 'Conciliacion BAC Quetzal', 'JULIO', '2021', 1),
(388, 8, 1, 'Conciliacion BAC Dolar', 'JULIO', '2021', 0),
(389, 9, 1, 'Integración Construcciones en proceso', 'JULIO', '2021', 1),
(390, 10, 1, 'Conciliacion Coosajo TD', 'JULIO', '2021', 1),
(391, 11, 1, 'conciliacion Coosajo Dolares', 'JULIO', '2021', 1),
(392, 12, 1, 'Conciliacion G&T Continental', 'JULIO', '2021', 1),
(393, 13, 1, 'Integracion Funcionarios y empleados', 'JULIO', '2021', 1),
(394, 14, 1, 'Integracion cuentas por pagar', 'JULIO', '2021', 1),
(395, 15, 1, 'Integracion anticipo para gastos', 'JULIO', '2021', 1),
(396, 16, 1, 'Integracion anticipo para eventos', 'JULIO', '2021', 1),
(410, 17, 1, 'Amortizacion Monitoreo GPS', 'JULIO', '2021', 1),
(411, 18, 1, 'Amortizacion Seguro Anticipado', 'JULIO', '2021', 1),
(412, 19, 1, 'Pago de IVA', 'JULIO', '2021', 1),
(413, 20, 1, 'Registro Pago de ISR', 'JULIO', '2021', 1),
(414, 21, 1, 'Registro Pago de IGSS', 'JULIO', '2021', 1),
(415, 22, 1, 'Registro Pago de Impuestos Retenidos', 'JULIO', '2021', 1),
(416, 23, 1, 'Registro IPF', 'JULIO', '2021', 1),
(417, 24, 1, 'Regularizacion IVA', 'JULIO', '2021', 1),
(418, 25, 1, 'Diferencial Cambiario', 'JULIO', '2021', 1),
(441, 26, 1, 'Transferencia a proveedores', 'JULIO', '2021', 1),
(442, 27, 1, 'Nota Coosajo a Proveedores', 'JULIO', '2021', 1),
(443, 28, 1, 'Facturas Especiales (Temporales)', 'JULIO', '2021', 1),
(444, 29, 1, 'Contabilizar facturas de Compra', 'JULIO', '2021', 1),
(445, 30, 1, 'Registro Anticipo para Gastos', 'JULIO', '2021', 1),
(446, 31, 1, 'Factura Seguro (Colaboradores)', 'JULIO', '2021', 1),
(447, 32, 1, 'Pago de telefonos', 'JULIO', '2021', 1),
(448, 33, 1, 'Factura Cable (Intercable)', 'JULIO', '2021', 1),
(449, 34, 1, 'Factura Visanet', 'JULIO', '2021', 1),
(450, 35, 1, 'Factura Credomatic', 'JULIO', '2021', 1),
(451, 36, 1, 'Factura Combustible (Texaco)', 'JULIO', '2021', 1),
(452, 37, 1, 'Factura Combustible (Shell)', 'JULIO', '2021', 1),
(453, 38, 1, 'Factura Lavanderia', 'JULIO', '2021', 1),
(454, 39, 1, 'Factura Infile', 'JULIO', '2021', 1),
(455, 40, 1, 'Factura Navega.Com', 'JULIO', '2021', 1),
(456, 1, 1, 'Conciliación Banrural', 'AGOSTO', '2021', 1),
(457, 5, 1, 'Conciliacion Coosajo R.L Principal', 'AGOSTO', '2021', 1),
(458, 6, 1, 'Conciliacion Coosajo R.L Peces', 'AGOSTO', '2021', 1),
(459, 7, 1, 'BAC Quetzal', 'AGOSTO', '2021', 1),
(460, 8, 1, 'BAC Dolar', 'AGOSTO', '2021', 0),
(461, 9, 1, 'Integración Construcciones en proceso', 'AGOSTO', '2021', 1),
(462, 10, 1, 'Conciliacion Coosajo TD', 'AGOSTO', '2021', 1),
(463, 11, 1, 'conciliacion Coosajo Dolares', 'AGOSTO', '2021', 1),
(464, 12, 1, 'Conciliacion G&T Continental', 'AGOSTO', '2021', 1),
(465, 13, 1, 'Integracion Funcionarios y empleados', 'AGOSTO', '2021', 1),
(466, 14, 1, 'Integracion cuentas por pagar', 'AGOSTO', '2021', 1),
(467, 15, 1, 'Integracion anticipo para gastos', 'AGOSTO', '2021', 1),
(468, 16, 1, 'Integracion anticipo para eventos', 'AGOSTO', '2021', 1),
(469, 17, 1, 'Amortizacion Monitoreo GPS', 'AGOSTO', '2021', 1),
(470, 18, 1, 'Amortizacion Seguro Anticipado', 'AGOSTO', '2021', 1),
(471, 19, 1, 'Pago de IVA', 'AGOSTO', '2021', 1),
(472, 20, 1, 'Registro Pago de ISR', 'AGOSTO', '2021', 1),
(473, 21, 1, 'Registro Pago de IGSS', 'AGOSTO', '2021', 1),
(474, 22, 1, 'Registro Pago de Impuestos Retenidos', 'AGOSTO', '2021', 1),
(475, 23, 1, 'Registro IPF', 'AGOSTO', '2021', 1),
(476, 24, 1, 'Regularizacion IVA', 'AGOSTO', '2021', 1),
(477, 25, 1, 'Diferencial Cambiario', 'AGOSTO', '2021', 1),
(478, 26, 1, 'Transferencia a proveedores', 'AGOSTO', '2021', 1),
(479, 27, 1, 'Nota Coosajo a Proveedores', 'AGOSTO', '2021', 1),
(480, 28, 1, 'Facturas Especiales (Temporales)', 'AGOSTO', '2021', 1),
(481, 29, 1, 'Contabilizar facturas de Compra', 'AGOSTO', '2021', 1),
(482, 30, 1, 'Registro Anticipo para Gastos', 'AGOSTO', '2021', 1),
(483, 31, 1, 'Factura Seguro (Colaboradores)', 'AGOSTO', '2021', 1),
(484, 32, 1, 'Pago de telefonos', 'AGOSTO', '2021', 1),
(485, 33, 1, 'Factura Cable (Intercable)', 'AGOSTO', '2021', 1),
(486, 34, 1, 'Factura Visanet', 'AGOSTO', '2021', 1),
(487, 35, 1, 'Factura Credomatic', 'AGOSTO', '2021', 1),
(488, 36, 1, 'Factura Combustible (Texaco)', 'AGOSTO', '2021', 1),
(489, 37, 1, 'Factura Combustible (Shell)', 'AGOSTO', '2021', 1),
(490, 38, 1, 'Factura Lavanderia', 'AGOSTO', '2021', 1),
(491, 39, 1, 'Factura Infile', 'AGOSTO', '2021', 1),
(492, 40, 1, 'Factura Navega.Com', 'AGOSTO', '2021', 1),
(530, 41, 1, 'Integracion Cuentas por cobrar Restaurante', 'AGOSTO', '2021', 1),
(531, 42, 1, 'Integracion Cuentas por cobrar Pesca', 'AGOSTO', '2021', 1),
(571, 43, 1, 'Archivo Conciliaciones Bancarias', 'AGOSTO', '2021', 1),
(612, 44, 1, 'Regularizacion Caja Restaurante', 'AGOSTO', '2021', 1),
(613, 45, 1, 'RegularizaciÃ³n Caja Kiosco Los Abuelos', 'AGOSTO', '2021', 1),
(614, 46, 1, 'Regularizacion Caja Rest El Mirador', 'AGOSTO', '2021', 1),
(615, 47, 1, 'Regularizacion Caja Helados', 'AGOSTO', '2021', 1),
(616, 48, 1, 'Regularizacion Caja Souvenir', 'AGOSTO', '2021', 1),
(617, 49, 1, 'Regularizacion Caja kiosco Restaurante', 'AGOSTO', '2021', 1),
(618, 50, 1, 'Regularizacion Caja Taquilla', 'AGOSTO', '2021', 1),
(619, 51, 1, 'Regularizacion Caja Kiosco Pesca', 'AGOSTO', '2021', 1),
(620, 52, 1, 'Regularizacion Caja Hoteles', 'AGOSTO', '2021', 1),
(621, 53, 1, 'Regularizacion Caja Eventos', 'AGOSTO', '2021', 1),
(622, 54, 1, 'Regularizacion Caja General', 'AGOSTO', '2021', 1),
(623, 55, 1, 'Integracion Tarjeta de Credito Visanet', 'AGOSTO', '2021', 1),
(624, 56, 1, 'Integracion Tarjeta de Credito Credomatic', 'AGOSTO', '2021', 1),
(625, 57, 1, 'Integracion Tarjeta de Debito Coosajo R.L', 'AGOSTO', '2021', 1),
(626, 1, 1, 'Conciliación Banrural', 'SEPTIEMBRE', '2021', 1),
(627, 5, 1, 'Conciliacion Coosajo R.L Principal', 'SEPTIEMBRE', '2021', 0),
(628, 6, 1, 'Conciliacion Coosajo R.L Peces', 'SEPTIEMBRE', '2021', 1),
(629, 7, 1, 'BAC Quetzal', 'SEPTIEMBRE', '2021', 1),
(630, 8, 1, 'BAC Dolar', 'SEPTIEMBRE', '2021', 1),
(631, 9, 1, 'Integración Construcciones en proceso', 'SEPTIEMBRE', '2021', 1),
(632, 10, 1, 'Conciliacion Coosajo TD', 'SEPTIEMBRE', '2021', 1),
(633, 11, 1, 'conciliacion Coosajo Dolares', 'SEPTIEMBRE', '2021', 1),
(634, 12, 1, 'Conciliacion G&T Continental', 'SEPTIEMBRE', '2021', 1),
(635, 13, 1, 'Integracion Funcionarios y empleados', 'SEPTIEMBRE', '2021', 1),
(636, 14, 1, 'Integracion cuentas por pagar', 'SEPTIEMBRE', '2021', 1),
(637, 15, 1, 'Integracion anticipo para gastos', 'SEPTIEMBRE', '2021', 0),
(638, 16, 1, 'Integracion anticipo para eventos', 'SEPTIEMBRE', '2021', 1),
(639, 17, 1, 'Amortizacion Monitoreo GPS', 'SEPTIEMBRE', '2021', 1),
(640, 18, 1, 'Amortizacion Seguro Anticipado', 'SEPTIEMBRE', '2021', 1),
(641, 19, 1, 'Pago de IVA', 'SEPTIEMBRE', '2021', 1),
(642, 20, 1, 'Registro Pago de ISR', 'SEPTIEMBRE', '2021', 1),
(643, 21, 1, 'Registro Pago de IGSS', 'SEPTIEMBRE', '2021', 1),
(644, 22, 1, 'Registro Pago de Impuestos Retenidos', 'SEPTIEMBRE', '2021', 1),
(645, 23, 1, 'Registro IPF', 'SEPTIEMBRE', '2021', 1),
(646, 24, 1, 'Regularizacion IVA', 'SEPTIEMBRE', '2021', 0),
(647, 25, 1, 'Diferencial Cambiario', 'SEPTIEMBRE', '2021', 1),
(648, 26, 1, 'Transferencia a proveedores', 'SEPTIEMBRE', '2021', 1),
(649, 27, 1, 'Nota Coosajo a Proveedores', 'SEPTIEMBRE', '2021', 1),
(650, 28, 1, 'Facturas Especiales (Temporales)', 'SEPTIEMBRE', '2021', 1),
(651, 29, 1, 'Contabilizar facturas de Compra', 'SEPTIEMBRE', '2021', 1),
(652, 30, 1, 'Registro Anticipo para Gastos', 'SEPTIEMBRE', '2021', 1),
(653, 31, 1, 'Factura Seguro (Colaboradores)', 'SEPTIEMBRE', '2021', 0),
(654, 32, 1, 'Pago de telefonos', 'SEPTIEMBRE', '2021', 1),
(655, 33, 1, 'Factura Cable (Intercable)', 'SEPTIEMBRE', '2021', 1),
(656, 34, 1, 'Factura Visanet', 'SEPTIEMBRE', '2021', 1),
(657, 35, 1, 'Factura Credomatic', 'SEPTIEMBRE', '2021', 1),
(658, 36, 1, 'Factura Combustible (Texaco)', 'SEPTIEMBRE', '2021', 1),
(659, 37, 1, 'Factura Combustible (Shell)', 'SEPTIEMBRE', '2021', 1),
(660, 38, 1, 'Factura Lavanderia', 'SEPTIEMBRE', '2021', 1),
(661, 39, 1, 'Factura Infile', 'SEPTIEMBRE', '2021', 1),
(662, 40, 1, 'Factura Navega.Com', 'SEPTIEMBRE', '2021', 1),
(663, 41, 1, 'Integracion Cuentas por cobrar Restaurante', 'SEPTIEMBRE', '2021', 1),
(664, 42, 1, 'Integracion Cuentas por cobrar Pesca', 'SEPTIEMBRE', '2021', 1),
(665, 43, 1, 'Archivo Conciliaciones Bancarias', 'SEPTIEMBRE', '2021', 0),
(666, 44, 1, 'Regularizacion Caja Restaurante', 'SEPTIEMBRE', '2021', 1),
(667, 45, 1, 'RegularizaciÃ³n Caja Kiosco Los Abuelos', 'SEPTIEMBRE', '2021', 1),
(668, 46, 1, 'Regularizacion Caja Rest El Mirador', 'SEPTIEMBRE', '2021', 1),
(669, 47, 1, 'Regularizacion Caja Helados', 'SEPTIEMBRE', '2021', 1),
(670, 48, 1, 'Regularizacion Caja Souvenir', 'SEPTIEMBRE', '2021', 1),
(671, 49, 1, 'Regularizacion Caja kiosco Restaurante', 'SEPTIEMBRE', '2021', 1),
(672, 50, 1, 'Regularizacion Caja Taquilla', 'SEPTIEMBRE', '2021', 1),
(673, 51, 1, 'Regularizacion Caja Kiosco Pesca', 'SEPTIEMBRE', '2021', 1),
(674, 52, 1, 'Regularizacion Caja Hoteles', 'SEPTIEMBRE', '2021', 1),
(675, 53, 1, 'Regularizacion Caja Eventos', 'SEPTIEMBRE', '2021', 1),
(676, 54, 1, 'Regularizacion Caja General', 'SEPTIEMBRE', '2021', 1),
(677, 55, 1, 'Integracion Tarjeta de Credito Visanet', 'SEPTIEMBRE', '2021', 1),
(678, 56, 1, 'Integracion Tarjeta de Credito Credomatic', 'SEPTIEMBRE', '2021', 1),
(679, 57, 1, 'Integracion Tarjeta de Debito Coosajo R.L', 'SEPTIEMBRE', '2021', 1),
(736, 59, 1, 'Libro de compras ACERCATE', 'SEPTIEMBRE', '2021', 0),
(737, 60, 1, 'Libro de compras ACERCATE II', 'SEPTIEMBRE', '2021', 0),
(800, 69, 1, 'Libro de Ventas ACERCATE', 'SEPTIEMBRE', '2021', 0),
(801, 70, 1, 'Libro de Ventas ACERCATE II', 'SEPTIEMBRE', '2021', 0),
(802, 71, 1, 'Constancias IVA Retenido', 'SEPTIEMBRE', '2021', 0),
(862, 72, 1, 'Cuentas por cobrar Souvenir', 'SEPTIEMBRE', '2021', 1),
(923, 73, 2, 'prueba 1', 'SEPTIEMBRE', '2021', 0),
(924, 73, 2, 'prueba 1', 'OCTUBRE', '2021', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meses_year`
--

CREATE TABLE `meses_year` (
  `ID_MES` int(10) NOT NULL,
  `MES` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `meses_year`
--

INSERT INTO `meses_year` (`ID_MES`, `MES`) VALUES
(1, 'ENERO'),
(2, 'FEBRERO'),
(3, 'MARZO'),
(4, 'ABRIL'),
(5, 'MAYO'),
(6, 'JUNIO'),
(7, 'JULIO'),
(8, 'AGOSTO'),
(9, 'SEPTIEMBRE'),
(10, 'OCTUBRE'),
(11, 'NOVIEMBRE'),
(12, 'DICIEMBRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_mes`
--

CREATE TABLE `tareas_mes` (
  `Id_tarea_mes` int(10) NOT NULL,
  `Tarea` varchar(90) DEFAULT NULL,
  `Tipo_tarea` varchar(120) DEFAULT NULL,
  `Usuario` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas_mes`
--

INSERT INTO `tareas_mes` (`Id_tarea_mes`, `Tarea`, `Tipo_tarea`, `Usuario`) VALUES
(1, 'Conciliación Banrural', 'Conciliaciones', '1'),
(5, 'Conciliacion Coosajo R.L Principal', 'Conciliaciones', '1'),
(6, 'Conciliacion Coosajo R.L Peces', 'Conciliaciones', '1'),
(7, 'BAC Quetzal', 'Conciliaciones', '1'),
(8, 'BAC Dolar', 'Conciliaciones', '1'),
(9, 'Integración Construcciones en proceso', 'Integraciones', '1'),
(10, 'Conciliacion Coosajo TD', 'Conciliaciones', '1'),
(11, 'conciliacion Coosajo Dolares', 'Conciliaciones', '1'),
(12, 'Conciliacion G&T Continental', 'Conciliaciones', '1'),
(13, 'Integracion Funcionarios y empleados', 'Integraciones', '1'),
(14, 'Integracion cuentas por pagar', 'Integraciones', '1'),
(15, 'Integracion anticipo para gastos', 'Integraciones', '1'),
(16, 'Integracion anticipo para eventos', 'Integraciones', '1'),
(17, 'Amortizacion Monitoreo GPS', 'Ajustes', '1'),
(18, 'Amortizacion Seguro Anticipado', 'Ajustes', '1'),
(19, 'Pago de IVA', 'Ajustes', '1'),
(20, 'Registro Pago de ISR', 'Ajustes', '1'),
(21, 'Registro Pago de IGSS', 'Ajustes', '1'),
(22, 'Registro Pago de Impuestos Retenidos', 'Ajustes', '1'),
(23, 'Registro IPF', 'Ajustes', '1'),
(24, 'Regularizacion IVA', 'Ajustes', '1'),
(25, 'Diferencial Cambiario', 'Ajustes', '1'),
(26, 'Transferencia a proveedores', 'Ajustes', '1'),
(27, 'Nota Coosajo a Proveedores', 'Ajustes', '1'),
(28, 'Facturas Especiales (Temporales)', 'Facturas', '1'),
(29, 'Contabilizar facturas de Compra', 'Facturas', '1'),
(30, 'Registro Anticipo para Gastos', 'Ajustes', '1'),
(31, 'Factura Seguro (Colaboradores)', 'Facturas', '1'),
(32, 'Pago de telefonos', 'Ajustes', '1'),
(33, 'Factura Cable (Intercable)', 'Facturas', '1'),
(34, 'Factura Visanet', 'Facturas', '1'),
(35, 'Factura Credomatic', 'Facturas', '1'),
(36, 'Factura Combustible (Texaco)', 'Facturas', '1'),
(37, 'Factura Combustible (Shell)', 'Facturas', '1'),
(38, 'Factura Lavanderia', 'Facturas', '1'),
(39, 'Factura Infile', 'Facturas', '1'),
(40, 'Factura Navega.Com', 'Facturas', '1'),
(41, 'Integracion Cuentas por cobrar Restaurante', 'Integraciones', '1'),
(42, 'Integracion Cuentas por cobrar Pesca', 'Integraciones', '1'),
(43, 'Archivo Conciliaciones Bancarias', 'Integraciones', '1'),
(44, 'Regularizacion Caja Restaurante', 'Cajas', '1'),
(45, 'RegularizaciÃ³n Caja Kiosco Los Abuelos', 'Cajas', '1'),
(46, 'Regularizacion Caja Rest El Mirador', 'Cajas', '1'),
(47, 'Regularizacion Caja Helados', 'Cajas', '1'),
(48, 'Regularizacion Caja Souvenir', 'Cajas', '1'),
(49, 'Regularizacion Caja kiosco Restaurante', 'Cajas', '1'),
(50, 'Regularizacion Caja Taquilla', 'Cajas', '1'),
(51, 'Regularizacion Caja Kiosco Pesca', 'Cajas', '1'),
(52, 'Regularizacion Caja Hoteles', 'Cajas', '1'),
(53, 'Regularizacion Caja Eventos', 'Cajas', '1'),
(54, 'Regularizacion Caja General', 'Cajas', '1'),
(55, 'Integracion Tarjeta de Credito Visanet', 'Integraciones', '1'),
(56, 'Integracion Tarjeta de Credito Credomatic', 'Integraciones', '1'),
(57, 'Integracion Tarjeta de Debito Coosajo R.L', 'Integraciones', '1'),
(59, 'Libro de compras ACERCATE', 'Ajustes', '1'),
(60, 'Libro de compras ACERCATE II', 'Ajustes', '1'),
(69, 'Libro de Ventas ACERCATE', 'Ajustes', '1'),
(70, 'Libro de Ventas ACERCATE II', 'Ajustes', '1'),
(71, 'Constancias IVA Retenido', 'Ajustes', '1'),
(72, 'Cuentas por cobrar Souvenir', 'Integraciones', '1'),
(73, 'prueba 1', 'Ajustes', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id_usuario` int(10) NOT NULL,
  `Usuario` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_usuario`, `Usuario`) VALUES
(1, 'Auxiliar Contable'),
(2, 'Compras'),
(3, 'Contador General'),
(4, 'Cajero General'),
(5, 'Bodega');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `year1`
--

CREATE TABLE `year1` (
  `ID_YEAR` int(10) NOT NULL,
  `AN` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `year1`
--

INSERT INTO `year1` (`ID_YEAR`, `AN`) VALUES
(1, 2021),
(2, 2022),
(3, 2023),
(4, 2024),
(5, 2025);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `editar_tareas`
--
ALTER TABLE `editar_tareas`
  ADD PRIMARY KEY (`Id_edition`),
  ADD UNIQUE KEY `copersonas` (`MES`,`YEA`,`ID_TAREA_MES`);

--
-- Indices de la tabla `meses_year`
--
ALTER TABLE `meses_year`
  ADD PRIMARY KEY (`ID_MES`);

--
-- Indices de la tabla `tareas_mes`
--
ALTER TABLE `tareas_mes`
  ADD PRIMARY KEY (`Id_tarea_mes`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_usuario`);

--
-- Indices de la tabla `year1`
--
ALTER TABLE `year1`
  ADD PRIMARY KEY (`ID_YEAR`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `editar_tareas`
--
ALTER TABLE `editar_tareas`
  MODIFY `Id_edition` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=925;

--
-- AUTO_INCREMENT de la tabla `meses_year`
--
ALTER TABLE `meses_year`
  MODIFY `ID_MES` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tareas_mes`
--
ALTER TABLE `tareas_mes`
  MODIFY `Id_tarea_mes` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `year1`
--
ALTER TABLE `year1`
  MODIFY `ID_YEAR` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
