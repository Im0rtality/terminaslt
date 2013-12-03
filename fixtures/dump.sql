-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2013 at 08:40 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `term`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `term_id`, `content`) VALUES
(1, 1, 2, 'neturetu buti "2"'),
(5, 1, 5, 'Protingas komentaras'),
(6, 7, 5, 'Dar gudresnis atsakymas!!!'),
(7, 7, 5, 'Papildymas: atsakymas nebuvo toks jau gudrus :('),
(8, 1, 7, '<b>labas</b>'),
(9, 1, 7, 'labas'),
(10, 1, 7, 'labas'),
(11, 1, 7, 'labas'),
(12, 1, 7, 'labas'),
(13, 1, 7, 'labas'),
(14, 1, 7, 'a'),
(15, 1, 7, 'a'),
(16, 1, 7, 'a'),
(17, 1, 7, 'a'),
(18, 1, 7, '&lt;b&gt;a&lt;/b&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `term` varchar(64) NOT NULL,
  `meaning` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `ip`, `term`, `meaning`, `comment`) VALUES
(1, '::1', 'aibė', 'Objektų, laikomų visuma, rinkinys. Aibės sąvoka yra viena pagrindinių sąvokų matematikoje.', 'http://lt.wikipedia.org/wiki/Aibė'),
(2, '::1', 'a', '&lt;b&gt;a&lt;/b&gt;', '&lt;b&gt;a&lt;/b&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(64) NOT NULL,
  `meaning` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `term`, `meaning`, `hits`) VALUES
(2, 'aibė2', 'Matematinė abstrakcija, reiškianti rinkinį kokių nors objektų, sujungtų į vienumą pagal kurį nors požymį.\r\n\r\n Kai kuriose programavimo kalbose vartojama aibės duomenų struktūra (išreikštiniu pavidalu). Jos nesant aibė modeliuojama kitomis duomenų struktūromis.\r\n\r\n Su aibėmis atliekamos aibių sąjungos, sankirtos, atimties ir kitos operacijos.', 14),
(3, 'aktyvinti', 'Pakeisti objekto būseną siekiant jo veiksmingumo.', 2),
(4, 'algoritmas', 'Baigtinė seka aiškiai suformuluotų nurodymų, kuriuos reikia atlikti tam tikram uždaviniui išspręsti (tikslui pasiekti).\r\n\r\n Algoritmas, užrašytas kompiuteriui suprantamu pavidalu, pavyzdžiui, programavimo kalba, vadinamas programa.\r\n\r\nPavyzdžiai: adaptyvusis algoritmas, baigtinis algoritmas, euristinis algoritmas, iteratyvusis algoritmas, kombinatorinis algoritmas, lygiagretusis algoritmas, loginis algoritmas, nuoseklusis algoritmas, rekursinis algoritmas, tiesinis algoritmas.', 1),
(5, 'alfa testavimas', 'Pirmieji kuriamos programos bandymai.\r\n\r\n Testuojama programos alfa versija, kuri gali būti tik būsimos programos prototipas. Pastebėtos klaidos taisomos, išleidžiama nauja alfa versija. Po to vėl testuojama, kol galiausiai išleidžiama beta versija.\r\n\r\n Paprastai testuoja patys programos autoriai arba jų talkininkai.', 41),
(6, 'apostrofas', 'Ženklas '' . Kodai: 39 (ASCII, dešimtainis), U+0027.\r\n\r\n Programuojant vartojamas tekstui arba atskiram rašmeniui išskirti, kurie traktuojami kaip duomenys.\r\n\r\n Pavyzdžiui, Paskalio kalbos programoje, rašymo sakinyje write(''write'') pirmasis žodis write reiškia rašymo (spausdinimo) komandą, o antrasis, tarp apostrofų, yra šios komandos parametras – ženklų eilutės reikšmė, kurią reikia išspausdinti.\r\n\r\n Tipografijoje apostrofas dažnai padailinamas ir virsta viengubų kabučių ženklu ’. Dėl to kartais nepagrįstai vadinamas kabutėmis.', 10),
(7, 'apvalinimo paklaida', 'Skaičiaus tiksliosios reikšmės (a) ir jo suapvalintos reikšmės (a_1) skirtumo modulis: |a – a_1|.', 26),
(8, 'archyvas', '1. Duomenys, padėti saugoti, kad jais būtų galima pakeisti prarastus duomenis.\r\n\r\n Plg. atsarginė kopija.\r\n\r\n2. Rečiau naudojamų duomenų sankaupa FTP duomenų saugykloje arba savame kompiuteryje. \r\n\r\n Duomenis, kurie supakuojami laikinai, taupant vietą atmintyje arba norint daugelį failų ir katalogų sudėti į vieną failą, reikėtų vadinti paku.', 15),
(9, 'ąselė', 'Išsikišusi kortelės dalis, kurią spustelėjus atveriama visa kortelė.', 6),
(10, 'atlaisvinti', 'Padaryti laisvą anksčiau užimtą (paskirtą kam nors) atmintį.\r\n\r\n Tai rodyklės į tą atminties vietą panaikinimas.', 1),
(11, 'atributas', 'Esminis arba savitas daikto požymis arba savybė.\r\n\r\n Gali būti vartojamas kaip požymio sinonimas.', 9),
(12, 'automatas', '1. Aparatas veiksmams atlikti, nedalyvaujant žmogui.\r\n\r\n 2. Skaitmeninio aparato modelis, kurio išėjimo simbolis priklauso nuo įėjimo simbolio ir nuo jo būsenos, o tolesnė būsena – nuo esamos būsenos ir įėjimo simbolio.\r\n\r\n Matematiškai apibūdinamas kaip objektas, kurį sudaro trys aibės: 1) įėjimo simbolių, 2) išėjimo simbolių ir 3) būsenų simbolių, ir dvi dvivietės funkcijos: 1) apskaičiuojanti įėjimo simbolį, priklausantį nuo įėjimo simbolio ir būsenos simbolio, ir 2) apskaičiuojanti naują būseną, priklausančią nuo tų pačių argumentų.\r\n\r\n Naudojamas skaitmeninei aparatinės įrangai projektuoti ir programuoti. Patogus, kai programos veiksmai priklauso nuo apdorojamų duomenų būsenos, pavyzdžiui, analizuojant ženklų eilutę galima išskirti skaičiaus būseną (kai pradėti analizuoti skaičių sudarantys skaitmenys) ir žodžio būseną (kai pradėtos analizuoti žodį sudarančios raidės).\r\n\r\nPavyzdžiai: abstraktusis automatas, baigtinis automatas, dėklinis automatas, determinuotasis automatas.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `a` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(128) NOT NULL,
  `flags` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `flags`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@terminas.lt', 1),
(7, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '', 0),
(8, 'jonas', 'SHA1(jonas)', 'jonas@gmail.com', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
