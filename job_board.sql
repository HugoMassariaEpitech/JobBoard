-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 13 oct. 2022 à 15:29
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `job_board`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisements`
--

CREATE TABLE `advertisements` (
  `id_advertisement` int(11) NOT NULL,
  `advertisement_name` text NOT NULL,
  `advertisement_company` text NOT NULL,
  `advertisement_location` text NOT NULL,
  `advertisement_type` text NOT NULL,
  `advertisement_description` text NOT NULL,
  `advertisement_salary` text,
  `advertisement_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `advertisements`
--

INSERT INTO `advertisements` (`id_advertisement`, `advertisement_name`, `advertisement_company`, `advertisement_location`, `advertisement_type`, `advertisement_description`, `advertisement_salary`, `advertisement_date`) VALUES
(24, 'Réseau informatique', 'Groupe T2MC', '91420 Morangis', 'CDI', 'Le Groupe T2MC, entreprise nationale à forte croissance, est aujourd\'hui un des leaders du secteur du nettoyage.\r\n\r\nNous recrutons un/une technicien réseau informatique. Doté-e d\'une expérience significative, vous savez gérer les besoins en solutions informatiques et répondre aux demandes des salariés. Vous assurez la maintenance du parc informatique et veillez à la sécurité des systèmes de gestion des données. Vous managez l\'équipe de techniciens.', '36000 €', '2022-10-11 11:20:58'),
(26, 'Technicien informatique', 'Julia', '75013 Paris', 'CDI', 'Julia, c’est une start-up spécialisée dans l’assurance santé qui a vue le jour en mars 2020, dont la mission principale est d’accompagner nos clients dans le choix de leur couverture santé en leur proposant l’offre de mutuelle la plus adaptée à leurs besoins.\r\n\r\nComment ? Grâce à une techno de feu faite maison, des leads qualifiés, des conseillers à l’écoute, une découverte des besoins, un closing naturel et surtout, une qualité des échanges exceptionnelle !\r\n\r\nNos valeurs ? Honnêteté, efficacité et satisfaction.\r\n\r\nJulia, c’est une entreprise en pleine croissance depuis son apparition sur le marché de la mutuelle santé. Notre ambition est d’agrandir notre équipe pour atteindre encore plus nos objectifs.\r\n\r\nTu souhaites rejoindre l’aventure ?\r\n\r\nPlus on est nombreux, mieux c’est ! Julia recrute son/sa futur(e) technicien(ne) support informatique afin d’agrandir sa dream team.', '25000 €', '2022-10-11 11:24:40'),
(28, 'Technicien en Informatique', 'Ville de Paris', 'Paris (75)', 'CDI', 'En 2022, la majorité des postes est à pourvoir à la Direction des Systèmes d’Information et du Numérique (DSIN) qui est chargée de développer et de mettre en œuvre, au bénéfice de l’ensemble des services de la Ville, les systèmes de traitement et de transmission de l’information. La DSIN accompagne les autres directions et leurs agent·es dans l’exercice de leur activité.', '2300 €', '2022-10-13 15:13:11'),
(29, 'Apprentis Systèmes', 'Guerbet', 'Paris (75)', 'CDI', 'Chez Guerbet, nous tissons des liens durables pour permettre de vivre mieux. C’est notre Raison d’Etre. Nous sommes un leader de l’imagerie médicale au niveau mondial, offrant une gamme étendue de produits pharmaceutiques, de dispositifs médicaux, de solutions digitales et IA, pour l’imagerie diagnostique et interventionnelle. (2600 collaborateurs)', '12500 €', '2022-10-13 15:33:00'),
(30, 'Technicien IT', 'Pullman Paris Tour Eiffel', '75015 Paris', 'CDD', 'Au pied de la Tour Eiffel et à deux pas des plus grands monuments parisiens, le Pullman Paris Tour Eiffel est une institution : 430 chambres, un restaurant, un rooftop iconique, plus de 20 salles de séminaire et une équipe dynamique font du Pullman un lieu de vie qui ne cesse de se réinventer.', '2200 €', '2022-10-13 15:34:02');

-- --------------------------------------------------------

--
-- Structure de la table `applications`
--

CREATE TABLE `applications` (
  `id_application` int(11) NOT NULL,
  `user_email` text NOT NULL,
  `id_advertisement` int(11) NOT NULL,
  `user_phone` text NOT NULL,
  `user_firstname` text NOT NULL,
  `user_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `applications`
--

INSERT INTO `applications` (`id_application`, `user_email`, `id_advertisement`, `user_phone`, `user_firstname`, `user_name`) VALUES
(29, 'hugo.merrir@gmail.com', 24, '0612546789', 'Hugo', 'Merrir'),
(30, 'hugo.merrir@gmail.com', 26, '0612546789', 'Hugo', 'Merrir'),
(32, 'hugo.merrir@gmail.com', 28, '0612546789', 'Hugo', 'Merrir');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_email` text NOT NULL,
  `user_phone` text NOT NULL,
  `user_birthdate` date NOT NULL,
  `user_civility` text NOT NULL,
  `user_password` text NOT NULL,
  `user_firstname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `user_name`, `admin`, `user_email`, `user_phone`, `user_birthdate`, `user_civility`, `user_password`, `user_firstname`) VALUES
(22, 'Massaria', 1, 'hugo.massaria@gmail.com', '0627495848', '1999-09-01', 'M.', '$2y$10$UugP3gdZ5gPfQ2u1NMqvSOcOduaVXGsfd8vDzp/ZKfBeDRZJM8ciW', 'Hugo'),
(24, 'Merrir', 0, 'hugo.merrir@gmail.com', '0612546789', '1999-04-01', 'M.', '$2y$10$yugEaXsuLJOf8niizoOejenfwxRt2rpOvhMZokmtlhAJDAOJYGfY2', 'Hugo');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id_advertisement`);

--
-- Index pour la table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id_application`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id_advertisement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `applications`
--
ALTER TABLE `applications`
  MODIFY `id_application` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
