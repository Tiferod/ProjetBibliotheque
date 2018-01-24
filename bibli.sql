-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2018 at 02:35 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibli`
--

-- --------------------------------------------------------

--
-- Table structure for table `Abonnés`
--

CREATE TABLE `Abonnés` (
  `ID` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prénom` varchar(20) NOT NULL,
  `adresse` varchar(20) NOT NULL,
  `téléphone` varchar(20) DEFAULT NULL,
  `mail` varchar(20) NOT NULL,
  `date_de_naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Abonnés`
--

INSERT INTO `Abonnés` (`ID`, `pseudo`, `mdp`, `nom`, `prénom`, `adresse`, `téléphone`, `mail`, `date_de_naissance`) VALUES
(1, 'sroubaud', 'password', 'Roubaud', 'Séverine', '1 rue des Églantiers', '0123456789', 'e@mail.com', '1990-01-01'),
(2, 'jlantier', 'password', 'Lantier', 'Jacques', '1 rue des Acacias', NULL, 'e@mail.com', '1990-02-02'),
(3, 'gmacquart', 'password', 'Macquart', 'Gervaise', '1 rue des Chênes', NULL, 'e@mail.com', '1990-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `ID` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prénom` varchar(20) NOT NULL,
  `mail` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`ID`, `pseudo`, `mdp`, `nom`, `prénom`, `mail`) VALUES
(1, 'elantier', 'password', 'Lantier', 'Étienne', 'e@mail.com'),
(2, 'pnegrel', 'password', 'Négrel', 'Paul', 'e@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `Auteurs`
--

CREATE TABLE `Auteurs` (
  `ID` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Auteurs`
--

INSERT INTO `Auteurs` (`ID`, `nom`) VALUES
(1, 'Victor Hugo'),
(2, 'George R. R. Martin'),
(3, 'Jean Van Hamme'),
(4, 'Grzegorz Rosinski');

-- --------------------------------------------------------

--
-- Table structure for table `ContientThème`
--

CREATE TABLE `ContientThème` (
  `document` int(11) NOT NULL,
  `thème` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Cotisations`
--

CREATE TABLE `Cotisations` (
  `statut` varchar(20) NOT NULL,
  `prix` int(11) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Cotisations`
--

INSERT INTO `Cotisations` (`statut`, `prix`) VALUES
('bénévole', 0),
('chômeur', 0),
('enfant', 5),
('étudiant', 10),
('militaire', 10),
('retraité', 10),
('standard', 20);

-- --------------------------------------------------------

--
-- Table structure for table `Cotise`
--

CREATE TABLE `Cotise` (
  `ID` int(11) NOT NULL,
  `abonné` int(11) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Cotise`
--

INSERT INTO `Cotise` (`ID`, `abonné`, `statut`, `date_fin`) VALUES
(1, 1, 'étudiant', '2018-03-16'),
(2, 2, 'standard', '2018-01-27'),
(3, 3, 'chômeur', '2018-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `CrééPar`
--

CREATE TABLE `CrééPar` (
  `auteur` int(11) NOT NULL,
  `document` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CrééPar`
--

INSERT INTO `CrééPar` (`auteur`, `document`) VALUES
(1, 2),
(1, 5),
(2, 1),
(3, 3),
(3, 4),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Documents`
--

CREATE TABLE `Documents` (
  `ID` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `type` set('livre','BD','revue','CD','DVD') NOT NULL,
  `éditeur` varchar(20) DEFAULT NULL,
  `collection` varchar(20) DEFAULT NULL,
  `numéro` int(11) DEFAULT NULL,
  `date_publication` date NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Documents`
--

INSERT INTO `Documents` (`ID`, `titre`, `type`, `éditeur`, `collection`, `numéro`, `date_publication`, `disponible`) VALUES
(1, 'Le Trône de Fer', 'livre', 'Bantam Books', NULL, NULL, '2017-03-01', 1),
(2, 'Les Misérables', 'livre', 'Albert Lacroix', NULL, NULL, '2016-11-30', 1),
(3, 'La Magicienne trahie', 'BD', 'Le Lombard', 'Thorgal', 1, '2016-05-16', 0),
(4, 'La Galère Noire', 'BD', 'Le Lombard', 'Thorgal', 3, '2017-04-12', 1),
(5, 'Notre-Dame de Paris', 'livre', 'Charles Gosselin', NULL, NULL, '2015-01-13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Emprunts`
--

CREATE TABLE `Emprunts` (
  `ID` int(11) NOT NULL,
  `abonné` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Emprunts`
--

INSERT INTO `Emprunts` (`ID`, `abonné`, `document`, `date_emprunt`, `date_retour_prevue`) VALUES
(5, 1, 5, '2018-01-16', '2018-02-15'),
(6, 3, 3, '2017-12-18', '2018-01-17');

--
-- Triggers `Emprunts`
--
DELIMITER $$
CREATE TRIGGER `disponible` AFTER DELETE ON `Emprunts` FOR EACH ROW UPDATE Documents SET disponible = 1 WHERE ID = OLD.document
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pas_disponible` AFTER INSERT ON `Emprunts` FOR EACH ROW UPDATE Documents SET disponible = 0 WHERE ID = NEW.document
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `retard_et_historique` BEFORE DELETE ON `Emprunts` FOR EACH ROW BEGIN
IF OLD.date_retour_prevue < NOW() THEN
	INSERT INTO Retards(abonné, document, date_retour, amende)
		VALUES(OLD.abonné, OLD.document, NOW(), DATEDIFF(NOW(), OLD.date_retour_prevue));
END IF;
INSERT INTO EmpruntsRendus(ID, abonné, document, date_emprunt, date_retour)
	VALUES(OLD.ID, OLD.abonné, OLD.document, OLD.date_emprunt, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `EmpruntsRendus`
--

CREATE TABLE `EmpruntsRendus` (
  `ID` int(11) NOT NULL,
  `abonné` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `EmpruntsRendus`
--

INSERT INTO `EmpruntsRendus` (`ID`, `abonné`, `document`, `date_emprunt`, `date_retour`) VALUES
(1, 2, 1, '2018-01-01', '2018-01-20'),
(2, 2, 1, '2018-01-08', '2018-01-20'),
(3, 2, 1, '2018-01-15', '2018-01-20'),
(4, 1, 2, '2018-01-02', '2018-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `Exclusions`
--

CREATE TABLE `Exclusions` (
  `ID` int(11) NOT NULL,
  `abonné` int(11) NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Exclusions`
--

INSERT INTO `Exclusions` (`ID`, `abonné`, `date_fin`) VALUES
(1, 2, '2020-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `Retards`
--

CREATE TABLE `Retards` (
  `ID` int(11) NOT NULL,
  `abonné` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `date_retour` date NOT NULL,
  `amende` int(1) NOT NULL,
  `payé` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Retards`
--

INSERT INTO `Retards` (`ID`, `abonné`, `document`, `date_retour`, `amende`, `payé`) VALUES
(1, 2, 1, '2018-01-20', 16, 1),
(2, 2, 1, '2018-01-20', 8, 0),
(3, 2, 1, '2018-01-20', 2, 0);

--
-- Triggers `Retards`
--
DELIMITER $$
CREATE TRIGGER `exclusion` AFTER INSERT ON `Retards` FOR EACH ROW IF (SELECT count(*) FROM Retards
    WHERE abonné = NEW.abonné
    AND DATEDIFF(NOW(), date_retour) <= 365) >= 3 THEN
	INSERT INTO Exclusions(abonné, date_fin)
		VALUES(NEW.abonné, DATE_ADD(NOW(), INTERVAL 2 YEAR));
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Similaires`
--

CREATE TABLE `Similaires` (
  `thème1` int(11) NOT NULL,
  `thème2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Thèmes`
--

CREATE TABLE `Thèmes` (
  `ID` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Abonnés`
--
ALTER TABLE `Abonnés`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Indexes for table `Auteurs`
--
ALTER TABLE `Auteurs`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `ContientThème`
--
ALTER TABLE `ContientThème`
  ADD UNIQUE KEY `document` (`document`,`thème`);

--
-- Indexes for table `Cotisations`
--
ALTER TABLE `Cotisations`
  ADD PRIMARY KEY (`statut`);

--
-- Indexes for table `Cotise`
--
ALTER TABLE `Cotise`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `CrééPar`
--
ALTER TABLE `CrééPar`
  ADD UNIQUE KEY `auteur` (`auteur`,`document`);

--
-- Indexes for table `Documents`
--
ALTER TABLE `Documents`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `Emprunts`
--
ALTER TABLE `Emprunts`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `EmpruntsRendus`
--
ALTER TABLE `EmpruntsRendus`
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `Exclusions`
--
ALTER TABLE `Exclusions`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `Retards`
--
ALTER TABLE `Retards`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- Indexes for table `Similaires`
--
ALTER TABLE `Similaires`
  ADD UNIQUE KEY `thème1` (`thème1`,`thème2`);

--
-- Indexes for table `Thèmes`
--
ALTER TABLE `Thèmes`
  ADD PRIMARY KEY (`ID`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Abonnés`
--
ALTER TABLE `Abonnés`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Auteurs`
--
ALTER TABLE `Auteurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Cotise`
--
ALTER TABLE `Cotise`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Documents`
--
ALTER TABLE `Documents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Emprunts`
--
ALTER TABLE `Emprunts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Exclusions`
--
ALTER TABLE `Exclusions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Retards`
--
ALTER TABLE `Retards`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Thèmes`
--
ALTER TABLE `Thèmes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
