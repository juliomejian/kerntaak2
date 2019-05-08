-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 mei 2019 om 15:12
-- Serverversie: 10.1.38-MariaDB
-- PHP-versie: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `drink`
--

DROP TABLE IF EXISTS `drink`;
CREATE TABLE `drink` (
  `drink_code` int(11) NOT NULL,
  `drink_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `drink`
--

INSERT INTO `drink` (`drink_code`, `drink_name`) VALUES
(1, 'Warme Drink'),
(2, 'Koude Drink');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `drink_item`
--

DROP TABLE IF EXISTS `drink_item`;
CREATE TABLE `drink_item` (
  `drink_item_id` int(11) NOT NULL,
  `subdrink_code` int(11) NOT NULL,
  `drink_item_name` varchar(100) NOT NULL,
  `drink_item_prijs` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `drink_item`
--

INSERT INTO `drink_item` (`drink_item_id`, `subdrink_code`, `drink_item_name`, `drink_item_prijs`) VALUES
(1, 1, 'Zwarte Koffe', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `drink_subcat`
--

DROP TABLE IF EXISTS `drink_subcat`;
CREATE TABLE `drink_subcat` (
  `subdrink_code` int(11) NOT NULL,
  `subdrink_name` varchar(100) NOT NULL,
  `drink_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `drink_subcat`
--

INSERT INTO `drink_subcat` (`subdrink_code`, `subdrink_name`, `drink_code`) VALUES
(1, 'Coffe', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `eten`
--

DROP TABLE IF EXISTS `eten`;
CREATE TABLE `eten` (
  `eten_code` int(11) NOT NULL,
  `eten_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `eten`
--

INSERT INTO `eten` (`eten_code`, `eten_name`) VALUES
(1, 'Gerechten'),
(2, 'Voorgerechten');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `eten_item`
--

DROP TABLE IF EXISTS `eten_item`;
CREATE TABLE `eten_item` (
  `eten_item_id` int(11) NOT NULL,
  `subeten_code` int(11) NOT NULL,
  `eten_item_name` varchar(100) NOT NULL,
  `eten_item_prijs` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `eten_item`
--

INSERT INTO `eten_item` (`eten_item_id`, `subeten_code`, `eten_item_name`, `eten_item_prijs`) VALUES
(1, 1, 'Griek Salad', 12.65),
(2, 1, 'Other salad', 34.98);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

DROP TABLE IF EXISTS `klant`;
CREATE TABLE `klant` (
  `klantcode` int(11) NOT NULL,
  `voorletters` varchar(45) NOT NULL,
  `tussenvoegsels` varchar(45) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `telefoon` varchar(45) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`klantcode`, `voorletters`, `tussenvoegsels`, `achternaam`, `telefoon`, `wachtwoord`) VALUES
(3, 'M', 'N', 'julio', '0645689799', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mederwerkers`
--

DROP TABLE IF EXISTS `mederwerkers`;
CREATE TABLE `mederwerkers` (
  `mederwerkerscode` int(11) NOT NULL,
  `voorletters` varchar(45) NOT NULL,
  `tussenvoegsels` varchar(45) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `gebruikersnaam` varchar(255) NOT NULL,
  `wachtwoord` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `mederwerkers`
--

INSERT INTO `mederwerkers` (`mederwerkerscode`, `voorletters`, `tussenvoegsels`, `achternaam`, `gebruikersnaam`, `wachtwoord`) VALUES
(1, 'M', 'N', 'Gemignani', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten warme gerechten`
--

DROP TABLE IF EXISTS `producten warme gerechten`;
CREATE TABLE `producten warme gerechten` (
  `Productnaam` varchar(45) NOT NULL,
  `prijs` int(11) NOT NULL,
  `product id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `producten warme gerechten`
--

INSERT INTO `producten warme gerechten` (`Productnaam`, `prijs`, `product id`) VALUES
('pizza', 15, 1),
('lasagne', 8, 2),
('nassi', 10, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `pnaam` varchar(45) NOT NULL,
  `prijs` int(45) NOT NULL,
  `PId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`pnaam`, `prijs`, `PId`) VALUES
(' 	Other salad', 12, 3),
('Griek Salad', 10, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subeten`
--

DROP TABLE IF EXISTS `subeten`;
CREATE TABLE `subeten` (
  `subeten_code` int(11) NOT NULL,
  `subeten_name` varchar(100) NOT NULL,
  `eten_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `subeten`
--

INSERT INTO `subeten` (`subeten_code`, `subeten_name`, `eten_code`) VALUES
(1, 'Salad', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tafel`
--

DROP TABLE IF EXISTS `tafel`;
CREATE TABLE `tafel` (
  `tafelnummer` int(11) NOT NULL,
  `tijd` varchar(255) NOT NULL,
  `betaald` float NOT NULL,
  `datum` datetime NOT NULL,
  `tafel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tafel`
--

INSERT INTO `tafel` (`tafelnummer`, `tijd`, `betaald`, `datum`, `tafel_id`) VALUES
(1, '19:00', 0, '2019-04-03 00:00:00', 30),
(2, '16:00', 0, '2019-04-03 00:00:00', 31),
(4, '21:00', 0, '2019-04-03 00:00:00', 33),
(3, '16:00', 0, '2019-04-03 00:00:00', 36);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tafel_product`
--

DROP TABLE IF EXISTS `tafel_product`;
CREATE TABLE `tafel_product` (
  `tafel_id` int(11) NOT NULL,
  `eten_item_id` int(11) DEFAULT NULL,
  `eten_aantal` int(11) DEFAULT NULL,
  `drink_item_id` int(11) DEFAULT NULL,
  `drink_aantal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tafel_product`
--

INSERT INTO `tafel_product` (`tafel_id`, `eten_item_id`, `eten_aantal`, `drink_item_id`, `drink_aantal`) VALUES
(32, 1, 3, NULL, NULL),
(3, 1, 3, NULL, NULL),
(31, 2, 6, 1, 9),
(33, 1, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tafel_reservering`
--

DROP TABLE IF EXISTS `tafel_reservering`;
CREATE TABLE `tafel_reservering` (
  `tafel_id` int(11) NOT NULL,
  `Naam` varchar(60) DEFAULT NULL,
  `aantal_personen` int(11) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `tijd` time NOT NULL,
  `telefoonnr` int(11) NOT NULL,
  `allergieen` varchar(45) NOT NULL,
  `overigeinfo` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tafel_reservering`
--

INSERT INTO `tafel_reservering` (`tafel_id`, `Naam`, `aantal_personen`, `datum`, `tijd`, `telefoonnr`, `allergieen`, `overigeinfo`) VALUES
(1, 'mejia ', 2, '2019-05-08', '09:05:00', 68611887, 'niks', 'niks'),
(2, 'soekhai', 2, '2019-05-08', '14:05:00', 68547841, 'nee', 'nvt');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `drink`
--
ALTER TABLE `drink`
  ADD PRIMARY KEY (`drink_code`);

--
-- Indexen voor tabel `drink_item`
--
ALTER TABLE `drink_item`
  ADD PRIMARY KEY (`drink_item_id`);

--
-- Indexen voor tabel `drink_subcat`
--
ALTER TABLE `drink_subcat`
  ADD PRIMARY KEY (`subdrink_code`);

--
-- Indexen voor tabel `eten`
--
ALTER TABLE `eten`
  ADD PRIMARY KEY (`eten_code`);

--
-- Indexen voor tabel `eten_item`
--
ALTER TABLE `eten_item`
  ADD PRIMARY KEY (`eten_item_id`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantcode`);

--
-- Indexen voor tabel `mederwerkers`
--
ALTER TABLE `mederwerkers`
  ADD PRIMARY KEY (`mederwerkerscode`);

--
-- Indexen voor tabel `producten warme gerechten`
--
ALTER TABLE `producten warme gerechten`
  ADD PRIMARY KEY (`product id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PId`);

--
-- Indexen voor tabel `subeten`
--
ALTER TABLE `subeten`
  ADD PRIMARY KEY (`subeten_code`);

--
-- Indexen voor tabel `tafel`
--
ALTER TABLE `tafel`
  ADD PRIMARY KEY (`tafel_id`);

--
-- Indexen voor tabel `tafel_reservering`
--
ALTER TABLE `tafel_reservering`
  ADD PRIMARY KEY (`tafel_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `drink`
--
ALTER TABLE `drink`
  MODIFY `drink_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `drink_item`
--
ALTER TABLE `drink_item`
  MODIFY `drink_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `drink_subcat`
--
ALTER TABLE `drink_subcat`
  MODIFY `subdrink_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `eten`
--
ALTER TABLE `eten`
  MODIFY `eten_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `eten_item`
--
ALTER TABLE `eten_item`
  MODIFY `eten_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantcode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `mederwerkers`
--
ALTER TABLE `mederwerkers`
  MODIFY `mederwerkerscode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `producten warme gerechten`
--
ALTER TABLE `producten warme gerechten`
  MODIFY `product id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `PId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `subeten`
--
ALTER TABLE `subeten`
  MODIFY `subeten_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `tafel`
--
ALTER TABLE `tafel`
  MODIFY `tafel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
