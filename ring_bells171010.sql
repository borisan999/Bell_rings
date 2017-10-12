-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2017 at 04:43 PM
-- Server version: 5.5.54-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ring_bells`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
`ID` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Dia` int(11) NOT NULL DEFAULT '0',
  `Hora` time NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Mes` int(11) NOT NULL DEFAULT '0',
  `Deshabilitada` int(11) NOT NULL DEFAULT '0',
  `Repeticiones` int(11) NOT NULL DEFAULT '0',
  `Repetido` int(11) NOT NULL DEFAULT '0',
  `Melodia` varchar(250) NOT NULL,
  `Fecha_creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_Usuario` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`ID`, `Nombre`, `Dia`, `Hora`, `Fecha`, `Mes`, `Deshabilitada`, `Repeticiones`, `Repetido`, `Melodia`, `Fecha_creado`, `ID_Usuario`) VALUES
(69, 'audio', 3, '16:33:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Coin-collect-sound-effect.mp3', '2017-10-09 16:01:16', 1),
(70, 'audio', 3, '16:30:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Magic-zing-sound-effect.mp3', '2017-10-09 16:01:16', 1),
(71, 'audio', 3, '16:31:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Dinner-triangle.mp3', '2017-10-09 16:01:16', 1),
(72, 'audio', 3, '16:32:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Magical-chime-sound-effect.mp3', '2017-10-09 16:01:16', 1),
(73, 'audio2', 3, '16:29:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Coin-collect-sound-effect.mp3', '2017-10-10 21:06:50', 1),
(74, 'audio2', 3, '16:24:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Dinner-triangle.mp3', '2017-10-10 21:06:50', 1),
(75, 'audio2', 3, '16:25:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Good-idea-bell.mp3', '2017-10-10 21:06:50', 1),
(76, 'audio2', 3, '16:26:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Magic-zing-sound-effect.mp3', '2017-10-10 21:06:50', 1),
(77, 'audio2', 3, '16:27:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Magical-chime-sound-effect.mp3', '2017-10-10 21:06:50', 1),
(78, 'audio2', 3, '16:28:00', '0000-00-00', 0, 0, 0, 0, '/home/pi/Music/Coin-collect-sound-effect.mp3', '2017-10-10 21:06:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Configuracion`
--

CREATE TABLE IF NOT EXISTS `Configuracion` (
  `ID` int(11) NOT NULL,
  `Pin_gpio` int(11) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Retardo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Configuracion`
--

INSERT INTO `Configuracion` (`ID`, `Pin_gpio`, `Duracion`, `Retardo`) VALUES
(1, 22, 10, 11);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
`ID` int(11) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `ID_Alarma` int(11) NOT NULL,
  `Fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Clave` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Clave`) VALUES
(2, 'CNG', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Configuracion`
--
ALTER TABLE `Configuracion`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`ID`), ADD KEY `ID` (`ID`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
