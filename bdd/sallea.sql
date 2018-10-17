-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 22 avr. 2018 à 23:52
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sallea`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_salle` int(3) DEFAULT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(6, 9, 33, 'Très belle salle ', 3, '2018-04-22 00:23:04'),
(4, 23, 6, 'Message !', 5, '2018-04-11 23:29:00');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_enregistrement`) VALUES
(21, 15, 24, '2018-04-23 01:38:39');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(9, 'eric', '327cff5d40cbfef703ef87a322770d54', 'tanguy', 'eric', 'tanguy@yahoo.fr', 'm', 1, '2018-04-03 10:28:34'),
(15, 'natacha', 'a6702776e96babb80f1326fd271644ce', 'lukasi', 'natacha', 'ghfi@yahoo.fr', 'f', 1, '2018-04-04 09:18:59'),
(17, 'nathan', '1404834e52a4c6cac9444f1fb3c62d3c', 'tanguy', 'nathan', 'jdoe@gmail.com', 'm', 0, '2018-04-04 09:24:50'),
(18, 'nolan', 'f66c8824d7520d7f1fdb689f2815b5d9', 'tanguy', 'nolan', 'jdoe@gmail.com', 'm', 0, '2018-04-04 09:25:22'),
(19, 'ayiana', '579740022ab9f8c441e83d8cf232887b', 'tanguy', 'ayiana', 'uize@gmail.com', 'f', 0, '2018-04-04 09:27:20'),
(20, 'david', '172522ec1028ab781d9dfd17eaca4427', 'tanguy', 'david', 'fgbh@yahoo.fr', 'm', 0, '2018-04-04 09:30:46'),
(21, 'lionel', '800a0e21225906fe82d141def1a9202d', 'tanguy', 'lionel', 'fgbgh@yahoo.fr', 'm', 0, '2018-04-04 09:32:23'),
(22, 'ornelie', 'dbd27f51597bbb5b717d9207a0932283', 'tanguy', 'ornelie', 'yiuyuiy@jljkl.fr', 'f', 0, '2018-04-04 09:34:04');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `id_salle` int(3) DEFAULT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` int(3) NOT NULL,
  `etat` enum('libre','reservation') NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 11, '2018-04-09 09:00:04', '2018-04-13 19:00:00', 120, 'reservation'),
(24, 23, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 1300, 'libre'),
(7, 15, '2018-04-09 09:00:02', '2018-04-13 19:40:00', 150, 'libre'),
(23, 19, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 1200, 'libre'),
(22, 26, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 850, 'libre'),
(21, 22, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 800, 'libre'),
(20, 18, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 900, 'libre'),
(25, 27, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 1200, 'libre'),
(26, 24, '2018-04-25 00:00:00', '2018-05-02 00:00:00', 1700, 'libre'),
(27, 39, '2018-04-26 00:00:00', '2018-05-03 00:00:00', 3000, 'libre'),
(28, 34, '2018-04-23 00:00:00', '2018-04-27 00:00:00', 1800, 'libre'),
(29, 33, '2018-04-27 00:00:00', '2018-05-04 00:00:00', 1250, 'libre'),
(30, 35, '2018-04-25 00:00:00', '2018-05-02 00:00:00', 2400, 'libre'),
(31, 30, '2018-05-07 00:00:00', '2018-05-11 00:00:00', 1250, 'libre'),
(32, 47, '2018-04-23 00:00:00', '2018-04-25 00:00:00', 800, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('reunion','bureau','formation') NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(21, 'Salle Comite', 'Découvrez et louez cet espace pour vos entretiens et réunions. La proximité avec le RER A fait de ce bureau un emplacement de choix. Le bureau très lumineux est idéal pour des entretiens ou réunions en petit comité ou bien pour des séances de travail efficace.\r\n', 'img/Salle Comite_bur4.jpg', 'France', 'Paris', '2 Rue Auber', 75009, 8, 'bureau'),
(20, 'Salle Extra', 'Disponible à la location un agréable bureau bien agencé,et très lumineux avec vue sur jardin. Pc portable avec internet. Une place de parking vous sera réservée sur demande. Belle terrasse aménagée pour vos pauses.\r\nVous aurez à disposition avec la réservation de la salle l&#039;accès à la connexion Wifi.\r\nLa location de ce bureau est possible à l&#039;heure, à la demi journée et à la journée. ', 'img/Salle Extra_bur2.jpg', 'France', 'Paris', '32 Avenue de la grande armée', 75008, 6, 'bureau'),
(18, 'Salle Prestige', 'Dans un bel immeuble haussmannien restructuré, proche de l&#039;Etoile.\r\nSurface de très bon standing, en excellent état d&#039;usage, composée de 7 bureaux. Surface très lumineuse, parquet et faux plafond en staff et terrasse de 70 m².\r\n', 'img/Salle Prestige_bur5.jpg', 'France', 'Paris', '2 Boulevard Suchet', 75016, 2, 'bureau'),
(19, 'Salle Carre', 'Avenue Franklin Roosevelt, à deux pas du Rond Point des Champs Elysées.\r\nLocaux traversants et lumineux belle hauteur sous plafond, en excellent état.', 'img/Salle Carre_bur1.jpg', 'France', 'Paris', '37 Avenue Franklin Roosevelt', 75008, 4, 'bureau'),
(22, 'Salle Gaullois', 'Ce bureau fermé de 12m² est idéal pour les entretiens individuels ou les mini-réunions. Il peut accueillir 2 postes de travail.\r\n\r\n', 'img/Salle Gaullois_bur3.jpg', 'France', 'Lyon', '34 Avenue Jean Jaurès', 69007, 2, 'bureau'),
(23, 'Salle Gerland', 'Cet espace rare, atypique et plein de charme propose Indépendant : il a sa propre entrée, sa kitchenette et un coin détente. Il donne sur une cour intérieure calme. ', 'img/Salle Gerland_bur9.jpg', 'France', 'Lyon', '1 Avenue Félix Faure', 69007, 4, 'bureau'),
(24, 'Salle Magistra', '6 postes de travail sont disponibles dans cet espace de 100m². L&#039;open space bénéficie d&#039;une mezzanine. Les espaces sont relativement silencieux.\r\n\r\nIl est proche de la Part-Dieu et desservi par le tramway et le bus', 'img/Salle Magistra_bur8.jpg', 'France', 'Lyon', '74 Rue de Bonnel', 69003, 6, 'bureau'),
(25, 'Salle Artiste', 'La location de notre salle de réunion inclut : Grand bureau de direction + Table de réunion de 8 places et chaises. Toilette indépendante. Grande fenêtre donnant sur la cour de l’immeuble et offrant une grande luminosité. WIFI et internet fibré. Vidéo projecteur.', 'img/Salle Artiste_bur7.jpg', 'France', 'Lyon', '60 Rue Molière', 69003, 8, 'bureau'),
(26, 'Salle Liberation', 'Nous vous proposons un grand bureau avec accès indépendant dans le 1er arrondissement de Marseille. Notre espace de travail est idéal pour des entretiens de recrutement,  Le bureau est disponible tous les jours de la semaine en journée complète.', 'img/Salle Liberation_bur6.jpg', 'France', 'Marseille', '25 Boulevard de la Liberation', 13001, 2, 'bureau'),
(27, 'Salle Minot', 'Nouvel espace de coworking ou bureau particulier à louer au centre ville de Marseille. Calme, confortable et convivial dans une ambiance studieuse et animée. Entièrements rénovés, les bureaux se composent: d&#039;un open space de poste de travail, d&#039;une salle d&#039;attente, une salle de réunion, un ou deux bureaux privatisables, une cuisine et un coin détente', 'img/Salle Minot_bur13.jpg', 'France', 'Marseille', '125 Boulevard Camille Flammarion', 13004, 4, 'bureau'),
(28, 'Salle Revolution', 'Situé à coté de ce nouveau quartier d&#039;affaires de la Joliette (périmètre Euroméditérranée), le 1er arrondissement jouit de l&#039;attraction que représente cette phase de renouvellement du secteur. De plus en plus d&#039;entreprises évoluant dans le domaine tertiaire choisissent le nouveau coeur économique de la ville afin d&#039;y installer durablement leurs bureaux.', 'img/Salle Revolution_bur10.jpg', 'France', 'Paris', '13 Boulevard de Saîgon', 13010, 6, 'bureau'),
(29, 'Salle Sud', 'En louant cette salle, il vous sera mis à disposition du café torréfié ainsi qu&#039;un distributeur de produits sélectionnés. Il vous sera également possible de prendre vos pauses dans un espace de détente avec TV. Il vous sera également mis à disposition une imprimante laser.\r\nToutes les conditions sont réunies pour que votre événement professionnel se déroule à merveille.', 'img/Salle Sud_bur11.jpg', 'France', 'Marseille', '27 Boulevard du Commandeur', 13009, 8, 'bureau'),
(30, 'Salle La Chapelle', 'formations et conférences louez un espace de travail unique, idéalement situé à Paris. Cet espace de conseil est idéal pour vos réunions et formations de 20 personnes. ', 'img/Salle La Chapelle_form3.jpg', 'France', 'Paris', '10 Rue du Faubourg Saint-Martin', 75010, 20, 'formation'),
(31, 'Salle Opéra', 'Louez cet espace chaleureux et polyvalent de près de 35 m2, entièrement privatisé, dans lequel tous les événements sont envisageables: formations, séminaires, ateliers, projections, expositions, réunions, rendez-vous d&#039;affaire, etc..\r\n\r\nOuvert sur l’extérieur par une verrière, cet espace vous permet d&#039;accueillir jusqu&#039;à 30 personnes', 'img/Salle Opéra_form1.jpg', 'France', 'Paris', '27 Rue Godefroy Cavaignac', 75011, 30, 'formation'),
(32, 'Salle Format', 'La salle peut accueillir jusqu&#039;à 22 personnes autour des tables. Elle est idéale pour les formations grace à la TV grand écran que vous pouvez accorder aux ordinateurs.\r\n', 'img/Salle Format_form4.jpg', 'France', 'Paris', '23 Rue de Bucarest', 75009, 22, 'formation'),
(33, 'Salle Associés', 'Bel établissement Restaurant / Bar / Pub, à la déco industrielle chic, à l&#039;orée du nouveau quartier de Confluence.\r\n- Equipement son et lumière haut de gamme.\r\n- Vidéo projection et écran géant.\r\n- Bar professionnel.\r\n- Cuisine professionnelle.\r\n- Magnifique terrasse privative de 100 m2 à l&#039;année, chauffée l&#039;hiver.\r\n- Accès et parking aisés.\r\nPossibilité de location sèche ou prestations clés en main sur devis.', 'img/Salle Associés_form8.jpg', 'France', 'Lyon', '42 cours Suchet', 69002, 20, 'formation'),
(34, 'Salle Learning', 'Nous mettons à votre disposition trois espaces de formation pouvant accueillir 15 à 22 personnes. La sale offre un cadre de travail agréable et fonctionnel, climatisée, modulable et très bien agencée. \r\ncette salle peut accueillir des séminaires, réunions ou même des formations.', 'img/_form11.jpg', 'France', 'Lyon', '21 quai Antoine Riboud La Confluence', 69002, 22, 'formation'),
(35, 'Salle Lyonnaise', 'Cet espace moderne et très lumineux est idéal pour vos déplacements professionnels\r\nCette grande salle de 150m² peut être modulée afin d&#039;accueillir entre 20 et 40 personnes selon la disposition. Elle est équipée d&#039;une connexion WIFI, d&#039;un paperboard et d&#039;un accès à un espace de pause. ', 'img/Salle Lyonnaise_form7.jpg', 'France', 'Lyon', '30 rue Pré Gaudry', 69007, 40, 'formation'),
(36, 'Salle Touristes', 'Nous mettons à votre disposition un espace de travail pouvant accueillir de 5 à 20 personnes assises pour des formations dans le septième arrondissement de Marseille', 'img/Salle Touristes_form6.jpg', 'France', 'Marseille', '34 Place Jean Jaurès', 13001, 20, 'formation'),
(37, 'Salle Phocéenne', 'Réservez votre salle de formation dans un appartement d’un des immeubles les plus emblématiques du 1er arrondissement de Marseille! A l’intérieur, au 1er étage, après la traversée d’un hall en marbre, vous accédez à un appartement très chaleureux qui accueille aujourd&#039;hui une communauté d’entrepreneurs et de créatifs.\r\n', 'img/Salle Phocéenne_form12.jpg', 'France', 'Paris', '23 Rue de Rome', 13001, 30, 'formation'),
(38, 'Salle Reine', 'La location de cet espace unique comprend une connexion Wifi, un vidéo-projecteur, un écran, une prise HDMI, un micro HF ainsi qu&#039;un paper board. Pour régaler vos collaborateurs, vous avez la possibilité d&#039;ajouter des formules de restauration, pauses café et formules petits déjeuners lors de votre réservation. Vous pourrez prendre vos repas dans le bar adjacent à la salle.Votre journée d&#039;étude se déroulera dans d&#039;excellentes conditions.', 'img/Salle Reine_form9.jpg', 'France', 'Marseille', '1 Rue Reine Elisabeth', 13001, 25, 'formation'),
(39, 'Salle Aéropage', 'Magnifique salle de conférence pouvant accueillir jusqu&#039;à 80 personnes.\r\nÉquipée de micro sur chaque siège avec un grand écran.', 'img/Salle Aéropage_reu1.jpg', 'France', 'Paris', '58 Avenue Raymond Poincaré', 75016, 80, 'reunion'),
(40, 'Salle Esthétique', 'Il est composé d&#039;une table de réunion pour 25 personnes et d&#039;un magnifique coin salon cosy. Un adaptateur mac, un paperboard, une connexion WIFI seront à votre disposition sur place. Pour vos présentations, vous pourrez brancher vos ordinateurs sur un branchement HDMI .', 'img/Salle Esthétique_reu2.jpg', 'France', 'Paris', '6 Avenue des Ternes', 75017, 25, 'reunion'),
(41, 'Salle Dali', 'La location de cette salle vous permettra d&#039;organiser vos réunions et séminaires en petit comité, mais aussi pour tout cocktail de mariage, anniversaire, thèse dans un lieu qui s&#039;y prête elle propose un service de qualité.', 'img/Salle Dali_reu9.jpg', 'France', 'Paris', '54 Rue Beliar', 75018, 30, 'reunion'),
(42, 'Salle Robles', 'Louez ce magnifique espace qui dispose d’un salon, d&#039;une bibliothèque et se situe à l’abri des regards, dans le recoin d&#039;une jolie cour intérieure.\r\n', 'img/Salle Robles_reu6.jpg', 'France', 'Lyon', '12 Rue de Bourgogne', 69009, 30, 'reunion'),
(43, 'Salle Noble', 'La salle pourra accueillir 16 à 25 personnes selon la disposition pour vos réunions.\r\nPetite particularité : un feu de cheminée pourra vous accompagner tout au long de vos journées de travail ! ', 'img/Salle Noble_reu5.jpg', 'France', 'Lyon', '31 Rue Duquesne', 69006, 25, 'reunion'),
(44, 'Salle Rouge', 'une Salle de réunion pouvant accueillir entre 10 et 12 personnes. Cette salle est équipée d&#039;un écran plat pour connecter un ordinateur et travailler confortablement en groupe. Vous disposerez également pendant la durée de votre location d&#039;une connexion WIFI gratuite. ', 'img/Salle Rouge_reu4.jpg', 'France', 'Lyon', 'Rue Saint-Jean-de-Dieu', 69007, 12, 'reunion'),
(45, 'Salle Methodique', 'Cette salle de réunion est située en plein cœur du 8ème arrondissement de Marseille. Il s&#039;agit d&#039;un espace de 30m2 pouvant accueillir de 10 à 20 personnes, selon la disposition de la salle.', 'img/Salle Methodique_reu10.jpg', 'France', 'Marseille', '63 Boulevard Périer', 13008, 20, 'reunion'),
(46, 'Salle Expert', 'Cet endroit chaleureux est idéal pour vos événements professionnels tels que vos réunions de travail ou vos formations.', 'img/Salle Expert_reu7.jpg', 'France', 'Marseille', '41 Rue Antoine Re', 13008, 30, 'reunion'),
(47, 'Salle Premium', 'Découvrez cette belle et moderne salle de réunion, pouvant compter jusqu&#039;à 25 personnes. La salle de conseil est parfaite pour votre réunion professionnelle, formation, assemblée générale', 'img/Salle Premium_reu13.jpg', 'France', 'Marseille', '15 Boulevard du Dr Parini', 13012, 25, 'reunion');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
