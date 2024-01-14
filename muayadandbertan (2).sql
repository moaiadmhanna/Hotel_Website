-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Jan 2024 um 22:12
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `muayadandbertan`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beitrag`
--

CREATE TABLE `beitrag` (
  `beitragid` int(11) NOT NULL,
  `ueberschrift` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `fotopfad` varchar(255) NOT NULL,
  `beitragsdatum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `beitrag`
--

INSERT INTO `beitrag` (`beitragid`, `ueberschrift`, `beschreibung`, `fotopfad`, `beitragsdatum`) VALUES
(65214, 'SILVESTERDINNER IN WIEN 2023 | 2024', 'Planen Sie, Silvester 2023-2024 in Wien zu feiern? Vor den Fenstern des Restaurants Veranda erstrahlt der Wiener Nachthimmel vor Festlichkeit. Doch die wahren Highlights des Neujahrsfests finden sich auf den Tellern und in den Gläsern unserer Gäste. Das diesjährige Silvester-Galadinner ist ein wahres Feuerwerk der Kulinarik.', 'styles/fotos/news/wout-vanacker-l4HBYkURqvE-unsplash.jpg', '2023-12-18 21:47:05'),
(65215, 'WEIHNACHTSDINNER IN WIEN', 'Lassen Sie sich zu Weihnachten von den kulinarischen Highlights unseres Küchenteams verwöhnen. Mit dem bewährten Sans Souci Service überlassen Sie nichts dem Zufall.', 'styles/fotos/news/libby-penner-TgdGlcJX75A-unsplash.jpg', '2023-12-18 20:48:13'),
(65216, 'SOMMERAKTIVITÄTEN IN WIEN', 'Genießen Sie die Sonnenseiten der Stadt. Wir präsentieren Ihnen die besten Sommeraktivitäten in Wien für Kunstfans und Outdoor-Begeisterte', 'styles/fotos/news/vicko-mozara-m82uh_vamhg-unsplash.jpg', '2023-12-18 19:49:08'),
(65221, 'BÄLLE IN WIEN', 'In unserem Ballkalender finden Sie die schönsten Bälle in Wien. Die Ballsaison erreicht traditionell ihren Höhepunkt im Jänner und Februar und wir haben ein besonderes Angebot während dieser Zeit.', 'styles/fotos/news/658dc8f8a2523_img.jpg', '2023-12-28 19:14:01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `benutzerid` int(11) NOT NULL,
  `anrede` char(1) NOT NULL,
  `username` varchar(48) NOT NULL,
  `vorname` varchar(48) NOT NULL,
  `nachname` varchar(48) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'Aktiv',
  `erstelldatum` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`benutzerid`, `anrede`, `username`, `vorname`, `nachname`, `email`, `passwort`, `status`, `erstelldatum`) VALUES
(10922, 'M', 'admin', 'Muayad', 'Mhanna', 'admin@gmail.com', '$2y$10$xjCl8TLHq1FzqGgiJ/7vte6451Nl7d164fAP/f1fLj3dzWDoPex/.', 'Aktiv', '2023-12-28 19:25:38');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservierung`
--

CREATE TABLE `reservierung` (
  `reservierungid` int(11) NOT NULL,
  `anreisedatum` date NOT NULL,
  `abreisedatum` date NOT NULL,
  `fruehstuck` tinyint(1) NOT NULL DEFAULT 0,
  `parkplatz` tinyint(1) NOT NULL DEFAULT 0,
  `haustier` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL DEFAULT 'neu',
  `reservierungsdatum` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gesamtpreis` int(11) NOT NULL,
  `benutzerid` int(11) NOT NULL,
  `zimmerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zimmer`
--

CREATE TABLE `zimmer` (
  `zimmerid` int(11) NOT NULL,
  `name` varchar(48) NOT NULL,
  `groesse` int(11) NOT NULL,
  `beschreibung` text NOT NULL,
  `preis` int(11) NOT NULL,
  `verfuegber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zimmer`
--

INSERT INTO `zimmer` (`zimmerid`, `name`, `groesse`, `beschreibung`, `preis`, `verfuegber`) VALUES
(20521, 'EleganzSuite', 20, 'Das Hotelzimmer ist geräumig, stilvoll eingerichtet und verfügt über ein komfortables Doppelbett, einen Flachbildfernseher, eine kleine Sitzecke und ein modernes Bad. Große Fenster sorgen für natürliches Licht, während der Schreibtisch und die Annehmlichkeiten wie ein Minikühlschrank und eine Kaffeemaschine den Aufenthalt angenehm gestalten.', 200, 10),
(20522, 'RoyalRetreat', 30, 'Die Luxus-Suite strahlt opulenten Charme aus. Das Kingsize-Himmelbett, kunstvolle Möbel und der Panoramablick durch bodentiefe Fenster verleihen dem Raum Eleganz. Ein Lounge-Bereich mit edlen Details und ein Arbeitsbereich mit stilvollem Schreibtisch bieten höchsten Komfort. Das luxuriöse Badezimmer punktet mit Marmorelementen, freistehender Badewanne und Regendusche.', 250, 10),
(20523, 'RoyalSplendorSuite', 35, 'Die Luxus-Suite besticht durch königlichen Komfort und raffinierte Eleganz. Das großzügige Himmelbett mit exquisiter Bettwäsche, kunstvollen Möbeln und bodentiefen Fenstern schafft eine opulente Atmosphäre. Ein Lounge-Bereich mit edlen Details und ein stilvoller Arbeitsbereich bieten höchsten Luxus. Im Badezimmer erwarten Sie Marmorelemente, eine freistehende Badewanne und eine Regendusche.', 300, 10),
(20524, 'Sonnenuntergangs-Suite', 25, 'Genießen Sie spektakuläre Sonnenuntergänge von dieser eleganten Suite aus. Die warmen Farbtöne und das stilvolle Interieur schaffen eine romantische Atmosphäre für einen unvergesslichen Aufenthalt zu zweit.', 150, 10),
(20525, 'Sonnenaufgangs-Suite', 20, 'Erleben Sie den Zauber eines jeden Morgens im Sonnenaufgangs-Deluxe-Zimmer. Mit einem erhöhten Blick auf die aufgehende Sonne, stilvollem Interieur und Komfort ist es der perfekte Start in den Tag.', 100, 10),
(20526, 'Goldene-Horizont-Suite', 30, 'Diese Suite strahlt puren Luxus aus, mit goldenen Akzenten und einem weiten Horizontblick. Das geräumige Interieur, das komfortable Bett und die hochwertigen Ausstattungen schaffen eine royale Atmosphäre.', 350, 10);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `beitrag`
--
ALTER TABLE `beitrag`
  ADD PRIMARY KEY (`beitragid`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`benutzerid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `reservierung`
--
ALTER TABLE `reservierung`
  ADD PRIMARY KEY (`reservierungid`),
  ADD KEY `zimmer_fk` (`zimmerid`),
  ADD KEY `benutzer_fk` (`benutzerid`);

--
-- Indizes für die Tabelle `zimmer`
--
ALTER TABLE `zimmer`
  ADD PRIMARY KEY (`zimmerid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `beitrag`
--
ALTER TABLE `beitrag`
  MODIFY `beitragid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65225;

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `benutzerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `reservierung`
--
ALTER TABLE `reservierung`
  MODIFY `reservierungid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1102;

--
-- AUTO_INCREMENT für Tabelle `zimmer`
--
ALTER TABLE `zimmer`
  MODIFY `zimmerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20527;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `reservierung`
--
ALTER TABLE `reservierung`
  ADD CONSTRAINT `benutzer_fk` FOREIGN KEY (`benutzerid`) REFERENCES `benutzer` (`benutzerid`) ON DELETE CASCADE,
  ADD CONSTRAINT `zimmer_fk` FOREIGN KEY (`zimmerid`) REFERENCES `zimmer` (`zimmerid`);

DELIMITER $$
--
-- Ereignisse
--
CREATE DEFINER=`admin`@`gmail.com@localhost` EVENT `cleanup_event` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-01-02 00:10:57' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE todaydate DATE;
    SET todaydate = CURRENT_DATE;

    DELETE FROM reservierung WHERE DATE(abreisedatum) <= todaydate;
    
    -- Assuming zimmerid is a foreign key in reservierung, update availability accordingly
    UPDATE zimmer 
    SET verfuegber = verfuegber + 1
    WHERE zimmerid IN (SELECT zimmerid FROM reservierung WHERE DATE(abreisedatum) <= todaydate);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
