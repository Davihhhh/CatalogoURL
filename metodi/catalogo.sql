-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Mar 27, 2024 alle 10:30
-- Versione del server: 5.7.11
-- Versione PHP: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalogo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `case_produttrici`
--

CREATE TABLE `case_produttrici` (
  `Nome` varchar(50) NOT NULL,
  `Data_Fondazione` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `case_produttrici`
--

INSERT INTO `case_produttrici` (`Nome`, `Data_Fondazione`) VALUES
('Apple', '1976-04-01'),
('Samsung', '13 gennaio 1969');

-- --------------------------------------------------------

--
-- Struttura della tabella `dispositivi`
--

CREATE TABLE `dispositivi` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Data_Rilascio` varchar(50) DEFAULT NULL,
  `Marca` varchar(50) NOT NULL,
  `Modello` varchar(50) NOT NULL,
  `Casa_Produttrice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `dispositivi`
--

INSERT INTO `dispositivi` (`Id`, `Nome`, `Data_Rilascio`, `Marca`, `Modello`, `Casa_Produttrice`) VALUES
(1, 'iphone 14', '2022-10-07', 'Apple', 'iPhone 14 Plus', 'Apple'),
(2, 'samsung galay 24 ultra', '10 gennaio 2024', 'Samsung', 'Galaxy', 'Samsung');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `Numero_Serie` int(11) NOT NULL,
  `Dispositivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`Numero_Serie`, `Dispositivo`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_sede`
--

CREATE TABLE `prodotto_sede` (
  `Id` int(11) NOT NULL,
  `Prodotto` int(11) NOT NULL,
  `Sede` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto_sede`
--

INSERT INTO `prodotto_sede` (`Id`, `Prodotto`, `Sede`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `sedi`
--

CREATE TABLE `sedi` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Casa_Produttrice` varchar(50) NOT NULL,
  `Indirizzo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sedi`
--

INSERT INTO `sedi` (`Id`, `Nome`, `Casa_Produttrice`, `Indirizzo`) VALUES
(1, 'principaleApple', 'Apple', 'via apple'),
(2, 'principaleSamsung', 'Samsung', 'via samsung');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `Nome` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Data_Crezione` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`Nome`, `Password`, `Data_Crezione`) VALUES
('Davide', 'davide', '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `case_produttrici`
--
ALTER TABLE `case_produttrici`
  ADD PRIMARY KEY (`Nome`);

--
-- Indici per le tabelle `dispositivi`
--
ALTER TABLE `dispositivi`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nome` (`Nome`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`Numero_Serie`);

--
-- Indici per le tabelle `prodotto_sede`
--
ALTER TABLE `prodotto_sede`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `sedi`
--
ALTER TABLE `sedi`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`Nome`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `dispositivi`
--
ALTER TABLE `dispositivi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `Numero_Serie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `prodotto_sede`
--
ALTER TABLE `prodotto_sede`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `sedi`
--
ALTER TABLE `sedi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
