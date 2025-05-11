-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 05, 2025 alle 12:49
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strutturalocale_pizzolini`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cameriere`
--

CREATE TABLE `cameriere` (
  `cod_cameriere` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `PassID` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `cameriere`
--

INSERT INTO `cameriere` (`cod_cameriere`, `nome`, `cognome`, `username`, `password`, `PassID`) VALUES
(1, 'Francesco', 'Pinto', 'Pintsus', 'Pintsus01', '717d591f22ad46c77d8ff666dc2f5e86ee96ff17071747a7a80bfc8c483c5f32'),
(2, 'Cristiano', 'Pizzolini', 'Kripiz', 'Kripiz$2024!!', ''),
(3, 'Andrea', 'Venerus', 'Vinny', 'MagicaMusica', ''),
(4, 'Cristiano', 'Pizzolini', 'Kripiz', 'Kripiz$2024!!', ''),
(5, 'Andrea', 'Venerus', 'Vinny', 'MagicaMusica', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `n_coperti` int(11) NOT NULL,
  `n_tavolo` int(11) NOT NULL,
  `stato` tinyint(1) NOT NULL,
  `ora` time NOT NULL,
  `data` date NOT NULL,
  `cameriere` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `comanda`
--

INSERT INTO `comanda` (`id_comanda`, `n_coperti`, `n_tavolo`, `stato`, `ora`, `data`, `cameriere`) VALUES
(1, 1, 1, 1, '09:28:33', '2024-12-04', 'Pintsus'),
(2, 4, 2, 0, '11:16:06', '2025-03-05', 'Pintsus'),
(3, 5, 4, 1, '11:59:39', '2025-03-05', 'Pintsus'),
(5, 2, 5, 0, '12:22:12', '2025-03-05', 'Kripiz'),
(6, 10, 5, 1, '12:22:35', '2025-03-05', 'Kripiz');

-- --------------------------------------------------------

--
-- Struttura della tabella `dettaglio_comanda`
--

CREATE TABLE `dettaglio_comanda` (
  `id_dettagliocomanda` int(11) NOT NULL,
  `stato` tinyint(1) NOT NULL,
  `modifica` varchar(50) NOT NULL,
  `n_uscita` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  `id_piatto` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `dettaglio_comanda`
--

INSERT INTO `dettaglio_comanda` (`id_dettagliocomanda`, `stato`, `modifica`, `n_uscita`, `costo`, `prezzo`, `quantità`, `id_piatto`, `id_comanda`) VALUES
(1, 1, 'null', 1, 3, 7, 1, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `piatto`
--

CREATE TABLE `piatto` (
  `id_piatto` int(11) NOT NULL,
  `des_piatto` varchar(50) NOT NULL,
  `des_ingredienti` varchar(50) NOT NULL,
  `attivo` tinyint(1) NOT NULL,
  `costo` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL,
  `id_tipologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `piatto`
--

INSERT INTO `piatto` (`id_piatto`, `des_piatto`, `des_ingredienti`, `attivo`, `costo`, `prezzo`, `id_tipologia`) VALUES
(1, 'misto_formaggi', 'formaggio asiago e fondina accompagnato con miele ', 1, 3, 7, 1),
(2, 'misto_salumi', 'salame e prosciutto crudo, accompagnato con crosti', 1, 6, 9, 1),
(6, 'polpette_di_melanzane', 'carne-melanzane-yoghurt', 1, 4, 8, 1),
(7, 'fioriZucca_ripieni', 'fiori di zucca-ricotta', 1, 5, 10, 1),
(8, 'bruschette_miste', 'pane-pomodoro-basilico-stracciatella-alce-funghi-t', 1, 5, 12, 1),
(9, 'gamberi_fritti', 'gambero-pasta kataifi-salsa agrumi', 1, 8, 16, 1),
(10, 'mini_parmigiana', 'pomodoro-grana-melanzane-', 1, 5, 10, 1),
(11, 'baccala_polenta', 'baccala-polenta-pane', 1, 6, 12, 1),
(12, 'carpaccio', 'manzo-rucola-grana-aceto', 1, 6, 12, 1),
(14, 'RisottoNero', 'Riso, nero di seppia, gamberi, aglio, prezzemolo', 1, 9, 18, 2),
(15, 'TagliatelleFunghi', 'Tagliatelle, funghi porcini, crema di tartufo, pan', 1, 8, 16, 2),
(16, 'LasagnaZucca', 'Pasta fresca, zucca, ricotta, speck, besciamella', 1, 7, 14, 2),
(17, 'SpaghettiVongole', 'Spaghetti, vongole veraci, pomodorini, aglio, prez', 1, 8, 15, 2),
(18, 'RavioliCarne', 'Ravioli ripieni di carne, burro, salvia', 1, 9, 17, 2),
(19, 'PastaNorma', 'Rigatoni, melanzane fritte, ricotta salata, basili', 1, 7, 13, 2),
(20, 'GnocchiPatate_ragù', 'Gnocchi di patate, ragù di cinghiale, parmigiano', 1, 8, 16, 2),
(21, 'Fagottini_pesceSpada', 'Pesce spada, ricotta, pomodoro, basilico', 1, 9, 18, 2),
(22, 'Risotto_fruttiDiMare', 'Riso, frutti di mare, pomodoro, aglio, prezzemolo', 1, 10, 20, 2),
(23, 'Pappardelle_anatra', 'Pappardelle, sugo di anatra, pepe nero, vino rosso', 1, 9, 18, 2),
(24, 'FilettoManzo', 'Filetto di manzo, pepe verde, panna, patate, rosma', 1, 14, 28, 3),
(25, 'Branzino', 'Branzino, pomodorini, olive taggiasche, aglio, pre', 1, 12, 24, 3),
(26, 'AgnelloScottadito', 'Agnello, purè di patate, verdure grigliate', 1, 13, 26, 3),
(27, 'CostataMaiale', 'Costata di maiale, salsa BBQ, cavolo, carote, maio', 1, 11, 22, 3),
(28, 'TagliataTonno', 'Tonno, sesamo, zucchine, peperoni, carote', 1, 13, 25, 3),
(29, 'BaccalàUmido', 'Baccalà, ceci, pomodorini, cipolla, vino bianco', 1, 12, 23, 3),
(30, 'PolloRuspante', 'Pollo, patate, cipolle, miele, rosmarino', 1, 9, 18, 3),
(31, 'FritturaMista', 'Calamari, gamberi, zucchine, carote, farina', 1, 11, 22, 3),
(32, 'Entrecôte', 'Entrecôte, chimichurri, patate, tartufo', 1, 13, 26, 3),
(33, 'FagianoArrosto', 'Fagiano, vino rosso, funghi, burro, rosmarino', 1, 14, 27, 3),
(34, 'TiramisùLimone', 'Mascarpone, limone, limoncello, savoiardi, zuccher', 1, 4, 8, 4),
(35, 'CrostataFrutta', 'Pasta frolla, crema pasticcera, frutta di stagione', 1, 4, 7, 4),
(36, 'TortaCioccolato', 'Cioccolato fondente, burro, zucchero, uova, farina', 1, 5, 9, 4),
(37, 'PannaCotta', 'Panna, pistacchio, zucchero, frutti di bosco', 1, 4, 8, 4),
(38, 'MillefoglieCrema', 'Pasta sfoglia, crema chantilly, frutti di bosco', 1, 4, 8, 4),
(39, 'Chardonnay', 'Chardonnay, fresco, fruttato, perfetto con pesce', 1, 13, 25, 5),
(40, 'Chianti_Classico', 'Chianti Classico, morbido, sentori di frutti rossi', 1, 15, 30, 5),
(41, 'AcquaFriz', 'Acqua frizzante, San Pellegrino, 500 ml', 1, 2, 3, 5),
(42, 'AcquaNat', 'Acqua naturale, Levissima, 500 ml', 1, 1, 3, 5),
(43, 'Birra', 'Birra Weiss, morbida, fruttata, adatta per antipas', 1, 3, 6, 5),
(44, 'BevandaLattina', 'Coca-Cola, lattina 330 ml, dolce e rinfrescante', 1, 2, 3, 5),
(45, 'SuccoFrutta', 'Arancia, spremuta fresca, bevanda analcolica', 1, 3, 5, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologiapiatto`
--

CREATE TABLE `tipologiapiatto` (
  `id_tipologia` int(11) NOT NULL,
  `des_tipologia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipologiapiatto`
--

INSERT INTO `tipologiapiatto` (`id_tipologia`, `des_tipologia`) VALUES
(1, 'antipasti'),
(2, 'primi'),
(3, 'secondi'),
(4, 'dolci'),
(5, 'bevande');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cameriere`
--
ALTER TABLE `cameriere`
  ADD PRIMARY KEY (`cod_cameriere`);

--
-- Indici per le tabelle `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id_comanda`);

--
-- Indici per le tabelle `dettaglio_comanda`
--
ALTER TABLE `dettaglio_comanda`
  ADD PRIMARY KEY (`id_dettagliocomanda`),
  ADD KEY `id_piatto` (`id_piatto`,`id_comanda`);

--
-- Indici per le tabelle `piatto`
--
ALTER TABLE `piatto`
  ADD PRIMARY KEY (`id_piatto`),
  ADD KEY `id_tipologia` (`id_tipologia`);

--
-- Indici per le tabelle `tipologiapiatto`
--
ALTER TABLE `tipologiapiatto`
  ADD PRIMARY KEY (`id_tipologia`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cameriere`
--
ALTER TABLE `cameriere`
  MODIFY `cod_cameriere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `dettaglio_comanda`
--
ALTER TABLE `dettaglio_comanda`
  MODIFY `id_dettagliocomanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `piatto`
--
ALTER TABLE `piatto`
  MODIFY `id_piatto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT per la tabella `tipologiapiatto`
--
ALTER TABLE `tipologiapiatto`
  MODIFY `id_tipologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
