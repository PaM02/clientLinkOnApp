-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 23 nov. 2020 à 20:44
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `linkonprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `username` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `numcompteur` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`username`, `prenom`, `nom`, `tel`, `password`, `numcompteur`, `site`) VALUES
('wxcx', 'ncwkc', 'wkcnw', 454, 'wxcwxc', 'wxcwx', ''),
('username', 'username', 'nguÃ©tte', 777574580, '1Ou04mmLpbgnxvLDtdB0RA==\n', '47000564758', ''),
('username', 'username', 'nguÃ©ttear', 777574580, '1Ou04mmLpbgnxvLDtdB0RA==\n', '47000564758', ''),
('ghh', 'hhh', 'hhh', 555, 'ggg', '88', ''),
('ff', 'gfg', 'gvv', 999, 'vg', '88', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
