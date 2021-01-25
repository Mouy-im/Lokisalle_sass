-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : mouyimv619.mysql.db
-- Généré le :  lun. 25 jan. 2021 à 14:07
-- Version du serveur :  5.6.50-log
-- Version de PHP :  7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mouyimv619`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL,
  `id_salle` int(5) NOT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date`) VALUES
(49, 43, 2, 'Génial', 10, '2021-01-10 13:55:29'),
(55, 37, 5, 'Salle lumineuse et agréable.\r\nJe recommande.', 9, '2021-01-15 22:48:29'),
(64, 41, 6, 'Salle au top', 9, '2021-01-15 22:58:17'),
(77, 36, 20, 'Bureau au top, bien situé et facile d\\\'accès.', 10, '2021-01-15 23:16:14'),
(83, 36, 5, 'Cadre sympa.\r\nSalle idéale pour une réunion d\\\'entreprise.', 9, '2021-01-16 10:45:09'),
(86, 60, 16, 'Salle lumineuse et bien équipée. \r\nÀ Relouer prochainement.', 9, '2021-01-16 22:46:10'),
(87, 47, 19, 'Salle spacieuse mais manque de modernité.', 7, '2021-01-16 22:52:28'),
(89, 65, 16, 'Grande salle agréable & chaleureuse. \r\nTrès satisfaite !', 7, '2021-01-19 10:16:49'),
(90, 64, 1, 'Bravo. Réservation simple et efficace. Service client au top ????', 10, '2021-01-24 14:51:52');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(6) NOT NULL,
  `montant` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `montant`, `id_membre`, `date`) VALUES
(1, 600, 43, '2021-01-12 13:27:24'),
(2, 350, 36, '2021-01-16 15:57:37'),
(8, 355, 36, '2021-01-14 21:16:59'),
(9, 250, 38, '2021-01-16 22:33:00'),
(10, 570, 41, '2021-01-16 22:38:39'),
(11, 200, 66, '2021-01-20 22:18:13'),
(12, 350, 66, '2021-01-21 14:45:16'),
(13, 400, 66, '2021-01-23 15:07:45'),
(14, 650, 65, '2021-01-23 21:25:33'),
(15, 450, 64, '2021-01-24 14:49:16');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(6) NOT NULL,
  `id_commande` int(6) NOT NULL,
  `id_produit` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 2, 3),
(4, 8, 2),
(5, 9, 7),
(6, 10, 12),
(7, 10, 13),
(8, 11, 22),
(9, 12, 23),
(10, 13, 5),
(11, 14, 32),
(12, 15, 18);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(5) NOT NULL,
  `pseudo` varchar(15) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `cp` int(5) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `ville`, `cp`, `adresse`, `statut`) VALUES
(36, 'Jean', 'e10adc3949ba59abbe56e057f20f883e', 'Villert', 'Jean', 'jean@gmail.fr', 'm', 'Nantes', 44000, '25 Avenue des Martyrs', 0),
(37, 'Marie', '81dc9bdb52d04dc20036dbd8313ed055', 'Jarrier', 'Marie', 'marie@gmail.fr', 'f', 'Senlis', 60300, '24 Avenue de la Liberté ', 0),
(38, 'Romain', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'romain@gmail.fr', '', '', 0, '', 0),
(39, 'Paul', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'paul@gmail.fr', '', '', 0, '', 0),
(41, 'Lucie', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'lucie@gmail.fr', '', '', 0, '', 0),
(43, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Dupont', 'Jeanne', 'admin@gmail.fr', 'f', 'Paris', 75000, '10 avenue des Champs Elysées', 1),
(44, 'admin2', 'c84258e9c39059a89ab77d846ddab909', '', '', 'admin2@gmail.fr', '', '', 0, '', 1),
(45, 'admin3', '32cacb2f994f6b42183a1300d9a3e8d6', '', '', 'admin3@gmail.fr', '', '', 0, '', 1),
(46, 'admin4', 'fc1ebc848e31e0a68e868432225e3c82', '', '', 'admin4@gmail.fr', '', '', 0, '', 1),
(47, 'Melanie', 'e10adc3949ba59abbe56e057f20f883e', 'Jourdin', 'Mélanie', 'melanie@gmail.fr', 'f', 'Rennes', 35000, '15 Rue de Léo Lagrange', 0),
(58, 'Élise', '5d41402abc4b2a76b9719d911017c592', '', '', 'elise@gmail.fr', '', '', 0, '', 0),
(59, 'Géraldine', '6e809cbda0732ac4845916a59016f954', '', '', 'geraldine@gmail.fr', '', '', 0, '', 0),
(60, 'Marc', '7ce8be0fa3932e840f6a19c2b83e11ae', '', '', 'marc@gmail.fr', '', '', 0, '', 0),
(62, 'Pierre', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'pierre@gmail.fr', '', '', 0, '', 0),
(63, 'Mario', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'mario@gmail.fr', '', '', 0, '', 0),
(64, 'arnaud', 'ddb038e9c1705eccf6adc999d1008460', 'Fléchard', 'Arnaud', 'arnaud.flechard@free.fr', 'm', 'MASSY', 91300, '18 rue des testeurs', 0),
(65, 'mimi', '9de37a0627c25684fdd519ca84073e34', 'Pacher', 'Mouy Ly', 'mlsron@hotmail.com', 'f', 'SAINT-JEAN', 31240, '1 impasse Guillaume Apollinaire', 0),
(66, 'mouy', 'e10adc3949ba59abbe56e057f20f883e', '', '', 'mouyim.gibassier@hotmail.com', 'f', 'Laval', 53000, '24 allée des Maronniers', 0),
(67, 'admini', '21232f297a57a5a743894a0e4a801fc3', '', '', 'admini@gmail.fr', 'm', '', 0, '', 1),
(68, 'jojo', 'e10adc3949ba59abbe56e057f20f883e', 'Dalhe', 'John', 'jojo@gmail.fr', 'm', '', 0, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id_newsletter` int(5) NOT NULL,
  `id_membre` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id_newsletter`, `id_membre`) VALUES
(2, 36),
(9, 37),
(10, 38),
(8, 43),
(13, 64),
(12, 65);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(5) NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `id_salle` int(5) NOT NULL,
  `id_promo` int(2) DEFAULT NULL,
  `prix` int(5) NOT NULL,
  `etat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `date_arrivee`, `date_depart`, `id_salle`, `id_promo`, `prix`, `etat`) VALUES
(1, '2021-02-01 08:00:00', '2021-02-01 20:00:00', 1, 1, 250, 0),
(2, '2021-02-02 08:00:00', '2021-02-02 20:00:00', 1, 0, 355, 0),
(3, '2021-02-01 08:00:00', '2021-02-01 18:00:00', 2, 0, 350, 0),
(4, '2021-02-02 08:00:00', '2021-02-02 18:00:00', 2, 0, 350, 0),
(5, '2021-02-14 08:00:00', '2021-02-14 20:00:00', 5, 7, 400, 0),
(6, '2021-02-09 08:00:00', '2021-02-09 20:00:00', 6, 5, 400, 1),
(7, '2021-02-14 08:00:00', '2021-02-14 20:00:00', 3, 0, 250, 0),
(8, '2021-01-12 08:00:00', '2021-01-12 20:00:00', 8, 0, 400, 1),
(10, '2021-02-21 08:00:00', '2021-02-21 22:00:00', 6, 1, 400, 1),
(11, '2021-03-16 08:00:00', '2021-03-18 22:00:00', 10, 0, 650, 1),
(12, '2021-02-22 08:00:00', '2021-02-22 22:00:00', 10, 0, 370, 0),
(13, '2021-02-15 08:00:00', '2021-02-15 22:00:00', 16, 0, 200, 0),
(14, '2021-02-18 08:00:00', '2021-02-19 22:00:00', 19, 0, 750, 1),
(15, '2021-02-12 08:00:00', '2021-02-12 22:00:00', 20, 0, 380, 1),
(16, '2021-03-01 08:00:00', '2021-03-05 22:00:00', 12, 0, 1200, 1),
(17, '2021-03-01 08:00:00', '2021-03-05 20:00:00', 5, 0, 900, 1),
(18, '2021-02-03 08:00:00', '2021-02-05 20:00:00', 2, 0, 450, 0),
(19, '2021-02-22 08:00:00', '2021-02-26 22:00:00', 16, 0, 700, 1),
(20, '2021-05-17 08:00:00', '2021-05-21 20:00:00', 4, 7, 750, 1),
(21, '2021-03-01 08:00:00', '2021-03-05 20:00:00', 11, 0, 690, 1),
(22, '2021-02-08 08:00:00', '2021-02-08 20:00:00', 2, 0, 200, 0),
(23, '2021-02-09 08:00:00', '2021-02-09 20:00:00', 2, 0, 350, 0),
(24, '2021-02-01 08:00:00', '2021-02-05 20:00:00', 3, 0, 450, 1),
(25, '2021-02-21 08:00:00', '2021-02-26 20:00:00', 5, 0, 710, 1),
(26, '2021-04-05 08:00:00', '2021-04-09 20:00:00', 6, 0, 670, 1),
(27, '2021-02-08 08:00:00', '2021-02-12 20:00:00', 14, 0, 650, 1),
(28, '2021-08-02 08:00:00', '2021-08-06 20:00:00', 13, 0, 400, 1),
(29, '2021-05-10 08:00:00', '2021-05-14 20:00:00', 16, 0, 650, 1),
(30, '2021-04-12 08:00:00', '2021-04-12 20:00:00', 9, 0, 100, 1),
(31, '2021-03-01 08:00:00', '2021-03-05 20:00:00', 4, 0, 680, 1),
(32, '2021-03-01 08:00:00', '2021-03-05 20:00:00', 1, 0, 650, 0),
(33, '2021-05-03 08:00:00', '2021-05-07 20:00:00', 10, 0, 530, 1),
(34, '2021-02-22 08:00:00', '2021-02-26 20:00:00', 7, 0, 450, 1),
(35, '2021-09-06 08:00:00', '2021-09-10 20:00:00', 14, 0, 650, 1),
(36, '2021-05-10 08:00:00', '2021-05-14 20:00:00', 7, 0, 450, 1),
(37, '2021-03-08 08:00:00', '2021-03-12 20:00:00', 7, 0, 680, 1),
(38, '2021-05-10 08:00:00', '2021-05-14 20:00:00', 9, 0, 450, 1),
(39, '2021-05-17 08:00:00', '2021-05-21 20:00:00', 15, 0, 600, 1),
(40, '2021-10-04 08:00:00', '2021-10-08 20:00:00', 16, 0, 500, 1),
(41, '2021-03-22 08:00:00', '2021-03-26 20:00:00', 17, 0, 450, 1);

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id_promo` int(2) NOT NULL,
  `code_promo` varchar(10) NOT NULL,
  `reduction` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id_promo`, `code_promo`, `reduction`) VALUES
(1, 'HELLO15', 15),
(5, 'SOLDES50', 50),
(6, 'SOLDES30', 30),
(7, 'BLACKF35', 35),
(8, 'MASQUE', 50),
(9, 'SALLE', 32),
(10, 'HELLO15', 15);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(5) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `cp` varchar(5) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('Réunion','Bureau','Conférence') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `description`, `photo`, `capacite`, `categorie`) VALUES
(1, 'France', 'Paris', '10 rue de Paris', '75000', 'Salle Duval', 'Cet espace de co-working vous charme par sa luminosité et son modernisme avec un immeuble de verre qui offre des espaces aérés et entièrement équipées. Grimpez au dernier étage et plongez dans un océan de zinc et d\'ardoise avec une vue panoramique sur les toits parisiens. Si le soleil brille, venez profiter de notre grande terrasse de verdure et si la pluie fait des claquettes, notre belle cuisine conviviale vous réchauffera autour d\'un creamy latte. En cas de tempête, notre équipe de choc est toujours présente pour vous accompagner coûte que coûte au fil de votre événement.', '/images/1_salle1.jpg', 50, 'Réunion'),
(2, 'France', 'Paris', '10 rue Nationale', '75001', 'Salle Baron', 'Nous vous proposons à la location un espace de réception en plein coeur du XVIIème arrondissement à deux pas de la place Pereire. Le lieu s\\\\\\\'articule autour de deux espaces distincts : un amphithéâtre de 70 sièges (et 10 sièges d\\\\\\\'appoints) complété par une salle de réception permettant l\\\\\\\'organisation de vos petits-déjeuner, cocktail ou déjeuner assis.\r\nLe lieu est entièrement équipé en technique afin de vous accueillir dans les meilleurs conditions possibles.', '/images/1_salle2.jpg', 70, 'Réunion'),
(3, 'France', 'Paris', '50 rue Nation', '75015', 'Salle Bardin', 'Cet espace d’exception accueil jusqu’à 20 personnes pour vos réunions d’équipe, comités de direction, formation ou présentation client. Il propose une grande modularité et la présence d’une cuisine permet la mise à disposition du café, thé et la disposition des pauses. Espace à la luminosité traversante, ses 2 terrasses somptueuses aux vues imprenables, sur le Sacré Coeur et la Tour Eiffel.', '/images/salle3.jpg', 20, 'Réunion'),
(4, 'France', 'Paris', '109 avenue de la République', '75005', 'Salle Baille', 'Notre lieu chic, cosy et atypique est doté d\\\'une grande modularité lui permettant d\\\'accueillir, dans des conditions de confort optimales nombre d\\\'évènements variés (séminaire, conférence, présentation de produits, afterwork, cocktails...) Bénéficiant d\\\'une gamme d\\\'équipement complète nos locaux sont entièrement accessibles aux personnes en situation de handicap. De la location sèche à l\\\'évènement sur mesure nos équipes seront répondre à vos besoins de manière efficace et personnalisée.', '/images/salle4.jpg', 80, 'Réunion'),
(5, 'France', 'Paris', '9 rue des sentiers', '75003', 'Salle Ballerat', 'Localisé dans le 9ème arrondissement juste en face du théâtre Mogador, cette salle lumineuse vous offre confort et espace.  Ce cocoon de 28 places assises est idéal pour vos prochaines sessions off-site et show-room. Venez profiter de nos équipements et d’un espace lounge design.', '/images/salle5.jpg', 50, 'Réunion'),
(6, 'France', 'Marseille', '16 boulevard Réaumur Sébastopol', '13001', 'Salle Victoire', 'Le confort d\\\'un appartement associé aux services et équipements pour vos réunions et événements professionnels. Composé de 3 pièces, adaptables jusqu\\\'à 16 personnes en réunion. Notre espace se situe dans le quartier central d\\\'affaires, à 5 minutes à pied de la gare Saint-Lazare.', '/images/salle6.jpg', 30, 'Réunion'),
(7, 'France', 'Lyon', '29 avenue du Mail', '69003', 'Salle Ballerat', 'Cet espace d’exception accueil jusqu’à 20 personnes pour vos réunions d’équipe, comités de direction, formation ou présentation client. Il propose une grande modularité et la présence d’une cuisine permet la mise à disposition du café, thé et la disposition des pauses. Espace à la luminosité traversante, ses 2 terrasses somptueuses aux vues imprenables, sur le Sacré Coeur et la Tour Eiffel.', '/images/salle7.jpg', 15, 'Réunion'),
(8, 'France', 'Paris', '50 boulevard Henri IV', '75002', 'Salle Cabat', 'Salle au sein d\\\'un centre d\\\'affaires au coeur de la capitale, face au Louvre.', '/images/salle8.jpg', 25, 'Réunion'),
(9, 'France', 'Marseille', '60 Avenue de Paris', '13001', 'Salle Carrière', 'Parfaite pour vos comités de direction stratégique. La salle Millésime faite de fauteuils en cuir vous réunira pour prendre les décisions les plus importantes & celles qui auront le plus d’impact au sein de votre entreprise.', '/images/salle9.jpg', 10, 'Bureau'),
(10, 'France', 'Lyon', '45 rue André Mignot', '69001', 'Salle Cezanne', 'Projetez-vous dans les vignes Champenoises, pensez collectif, transformation dans le temps pour bonifier vos idées de façon pérenne afin d’agir durablement pour votre entreprise !', '/images/salle10.jpg', 30, 'Réunion'),
(11, 'France', 'Paris', '19 rue de l\\\'Opéra', '75009', 'Salle Clesinger', 'En 1969, on ne pensait pas 20 ans plus tôt que l’homme aurait mis un pas sur la lune. Pensez à vos idées disruptives pour le futur de vos entreprises, projetez vos commerciaux dans cette salle pour qu’ils puissent penser out of the box & créer l’impossible dans vos structures !', '/images/salle11.jpg', 45, 'Réunion'),
(12, 'France', 'Marseille', '49 chemin de Saint Jean du Désert', '13002', 'Salle Couture', 'Chaque humain de votre entreprise est unique, pour parvenir à la perfection que vous vous êtes fixés, armez-vous de patience & de vos meilleurs alliés pour qu’ils mettent en place tout leur savoir-faire au service de votre entreprise.', '/images/1_1_salle12.jpg', 20, 'Conférence'),
(13, 'France', 'Paris', '36 avenue des Champs Élysées', '75008', 'Salle Daubigny', 'Vos équipes doivent se réunir pour une notion importante, le partage du savoir entre elles. Comme le dit un proverbe africain, « tout seul on va plus vite, ensemble, on va plus loin »', '/images/1_salle13.jpg', 30, 'Réunion'),
(14, 'France', 'Lyon', '25 chemin de la Parette', '69001', 'Salle Delacroix', 'Dans le 15ème arrondissement de Lyon, le Art Hôtel Eiffel offre des salles de séminaires modernes et modulables pour vos réunions professionnelles. Réservez vos journées d\\\\\\\'études et séminaires résidentiels dans notre établissement pour un service de qualité garantie.', '/images/salle14.jpg', 20, 'Réunion'),
(15, 'France', 'Paris', '32 avenue du Mail', '75003', 'Salle Delaroche', 'Wereso, est un espace de coworking en plein centre de Paris. Les locaux sont agencés pour vous garantir convivialité et intimité. Des espaces détentes sont présents dans l\\\\\\\'open space. Deux grandes salles de réunion avec lumière du jour sont à votre disposition pour vos événements, ainsi que 2 plus petites salles pour des rendez-vous.\r\nUne équipe est présente pour vous accueillir et vous renseigner toute la journée !', '/images/1_salle15.jpg', 20, 'Réunion'),
(16, 'France', 'Marseille', '45 boulevard Henri IV', '13002', 'Salle Demanche', 'Entrez chez Deskeo Saint Honoré où l’on vous reçoit dans son petit paradis de 14 espaces situés au bout d’un patio de verdure à l’angle de la Concorde et de la Madeleine.\r\n\r\nSon cadre calme et atypique stimulera et fera naître vos idées les plus créatives.\r\n\r\nRéunissez-vous dans notre salle de flamants roses pour faire décoller votre esprit, éveillez le félin qui sommeille en vous dans notre espace panthère et venez brainstormer dans notre univers de palmiers.', '/images/salle16.jpg', 35, 'Conférence'),
(17, 'France', 'Lyon', '67 avenue Du Faubourg St Martin', '69004', 'Salle Latour', 'À seulement 3 minutes de marche de Paris Gare de Lyon, societyM vous offre 4 salles de réunions spacieuses, créatives et confortables. Chacune avec son matériel audiovisuel de pointe, des murs et des tableaux blancs pour prendre des notes et, bien sûr, plein de choses gratuites (café, thé, Wi-Fi, stylos, inspiration).\r\n\r\nSitué à l\\\'hôtel citizenM Paris Gare de Lyon, pourquoi ne pas rester pour un afterwork à notre skybar cloudM au 16e étage, vue sur la Tour Eiffel.', '/images/1_salle17.jpg', 20, 'Réunion'),
(18, 'France', 'Paris', '18 avenue Jules Beaudouin', '75003', 'Salle Jouvenet', 'L\\\'évasion est notre inspiration. EVASION est un lieu idéal pour vos séminaires ou vos évènements, avec un cadre atypique et un tempérament engagé. Auprès de l\\\'association HISA PROJECT, nous entreprenons pour la protection des animaux sauvages ou domestiques. Nous vous offrons des prestations sur mesure et vous accompagnons dans la réalisation de vos événements privés et professionnels.\r\nNous vous ferons voyager tout au long de vos séminaires au cœur des continents du monde.', '/images/1_salle18.jpg', 60, 'Bureau'),
(19, 'France', 'Lyon', '33 avenue des Clayes', '69003', 'Salle Grimaud', 'Cet espace d’exception accueil jusqu’à 20 personnes pour vos réunions d’équipe, comités de direction, formation ou présentation client. Il propose une grande modularité et la présence d’une cuisine permet la mise à disposition du café, thé et la disposition des pauses. Espace à la luminosité traversante, ses 2 terrasses somptueuses aux vues imprenables, sur le Sacré Coeur et la Tour Eiffel.', '/images/1_salle19.jpg', 65, 'Réunion'),
(20, 'France', 'Paris', '10 rue de la Pricnesse de Clèves', '69002', 'Salle Langlois', 'Venez profiter d\\\'un superbe espace situé à quelques minutes des jardins des Tuileries. Disposant d\\\'un coin réunion et salon, il sera parfait pour vous et votre équipe. Découvrez la salle Legrand avec une capacité de 9 personnes. Parfaitement localisé, ce Cocoon se situe à 4 minutes des transports.', '/images/1_salle20.jpg', 30, 'Bureau');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`),
  ADD KEY `fk_avis_membre` (`id_membre`),
  ADD KEY `jf_avis_salle` (`id_salle`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_commande_membre` (`id_membre`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD UNIQUE KEY `id_produit` (`id_produit`),
  ADD KEY `fk_commande_details_commande` (`id_commande`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id_newsletter`),
  ADD UNIQUE KEY `id_membre` (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD KEY `id_salle` (`id_salle`),
  ADD KEY `id_promo` (`id_promo`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id_promo`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id_newsletter` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id_promo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_membre` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jf_avis_salle` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_membre` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commande_details_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
