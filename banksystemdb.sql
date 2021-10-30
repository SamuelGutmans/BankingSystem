-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Okt 2021 um 14:59
-- Server-Version: 10.4.14-MariaDB
-- PHP-Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `banksystemdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_transaktionen`
--

CREATE TABLE `tbl_transaktionen` (
  `ID` int(11) NOT NULL,
  `User` varchar(250) NOT NULL,
  `Betrag` decimal(10,0) NOT NULL,
  `NeueSaldo` decimal(10,0) NOT NULL,
  `Methode` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_ueberweisungen`
--

CREATE TABLE `tbl_ueberweisungen` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) NOT NULL,
  `EmpfaengerID` int(11) NOT NULL,
  `Grund` varchar(245) NOT NULL,
  `Datum` date NOT NULL,
  `Betrag` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_users`
--

CREATE TABLE `tbl_users` (
  `ID` int(11) NOT NULL,
  `Vorname` varchar(45) NOT NULL,
  `Nachname` varchar(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_users`
--

INSERT INTO `tbl_users` (`ID`, `Vorname`, `Nachname`, `Username`, `Password`, `Email`, `balance`, `isAdmin`) VALUES
(10, 'AdminVorname', 'AdminNachname', 'AdminBenutzername', '$2y$10$7kNH1JkTNET9aZs.2jn.u.O7xWBdGH9FPdorKeUl0ryls4PQ4anLS', 'AdminEmaill@gmai.com', '0', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_transaktionen`
--
ALTER TABLE `tbl_transaktionen`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `tbl_ueberweisungen`
--
ALTER TABLE `tbl_ueberweisungen`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_senderID` (`SenderID`),
  ADD KEY `fk_empfaengerID` (`EmpfaengerID`);

--
-- Indizes für die Tabelle `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_transaktionen`
--
ALTER TABLE `tbl_transaktionen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tbl_ueberweisungen`
--
ALTER TABLE `tbl_ueberweisungen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_ueberweisungen`
--
ALTER TABLE `tbl_ueberweisungen`
  ADD CONSTRAINT `fk_empfaengerID` FOREIGN KEY (`EmpfaengerID`) REFERENCES `tbl_users` (`ID`),
  ADD CONSTRAINT `fk_senderID` FOREIGN KEY (`SenderID`) REFERENCES `tbl_users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
