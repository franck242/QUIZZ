-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 11 jan. 2025 à 14:30
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `qcm_simple`
--

-- --------------------------------------------------------

--
-- Structure de la table `game_history`
--

DROP TABLE IF EXISTS `game_history`;
CREATE TABLE IF NOT EXISTS `game_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `difficulty` enum('facile','moyen','difficile') NOT NULL,
  `score` int NOT NULL,
  `played_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id_question` int NOT NULL AUTO_INCREMENT,
  `quiz_name` varchar(255) NOT NULL,
  `question_text` text NOT NULL,
  `difficulty` enum('facile','moyen','difficile') NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `quiz_name`, `question_text`, `difficulty`, `correct_answer`, `answer1`, `answer2`, `answer3`) VALUES
(1, 'Culture Générale', 'Quelle est la capitale de la France?', 'facile', 'Paris', 'Berlin', 'Madrid', 'Rome'),
(2, 'Culture Générale', 'Qui a peint la Joconde?', 'moyen', 'Léonard de Vinci', 'Michel-Ange', 'Raphaël', 'Donatello'),
(3, 'Culture Générale', 'Quel est le plus grand océan du monde?', 'difficile', 'Pacifique', 'Atlantique', 'Indien', 'Arctique'),
(4, 'Culture Générale', 'Combien font 2 + 2 ?', 'facile', '4', '2', '3', '5'),
(5, 'Culture Générale', 'Quel est le symbole chimique de l\'or ?', 'moyen', 'Au', 'Ag', 'Fe', 'Cu'),
(6, 'Culture Générale', 'Quelle est la vitesse de la lumière dans le vide ?', 'difficile', '300 000 km/s', '200 000 km/s', '400 000 km/s', '500 000 km/s'),
(7, 'Culture Générale', 'Quel est le plus grand pays du monde en superficie ?', 'facile', 'Russie', 'Chine', 'Canada', 'États-Unis'),
(8, 'Culture Générale', 'Qui a écrit \"Le Rouge et le Noir\" ?', 'moyen', 'Stendhal', 'Balzac', 'Hugo', 'Zola'),
(9, 'Culture Générale', 'Quel est le plus haut sommet du monde ?', 'difficile', 'Mont Everest', 'K2', 'Kangchenjunga', 'Lhotse'),
(10, 'Culture Générale', 'Quel est le symbole chimique du fer ?', 'facile', 'Fe', 'Au', 'Ag', 'Cu'),
(11, 'Culture Générale', 'Qui a inventé le téléphone ?', 'moyen', 'Alexander Graham Bell', 'Thomas Edison', 'Nikola Tesla', 'Guglielmo Marconi'),
(12, 'Culture Générale', 'Quelle est la capitale de l\'Italie ?', 'difficile', 'Rome', 'Milan', 'Naples', 'Florence'),
(13, 'Culture Générale', 'Quel est le plus grand désert du monde ?', 'facile', 'Antarctique', 'Sahara', 'Gobi', 'Arctique'),
(14, 'Culture Générale', 'Qui a écrit \"Les Misérables\" ?', 'moyen', 'Victor Hugo', 'Balzac', 'Stendhal', 'Zola'),
(15, 'Culture Générale', 'Quel est le plus long fleuve d\'Afrique ?', 'difficile', 'Nil', 'Congo', 'Niger', 'Zambèze'),
(16, 'Culture Générale', 'Quel est le plus grand lac du monde ?', 'facile', 'Mer Caspienne', 'Lac Supérieur', 'Lac Victoria', 'Lac Baïkal'),
(17, 'Culture Générale', 'Qui a découvert la pénicilline ?', 'moyen', 'Alexander Fleming', 'Louis Pasteur', 'Marie Curie', 'Robert Koch'),
(18, 'Culture Générale', 'Quelle est la capitale du Japon ?', 'difficile', 'Tokyo', 'Kyoto', 'Osaka', 'Hiroshima'),
(19, 'Culture Générale', 'Quel est le plus grand animal terrestre ?', 'facile', 'Éléphant d\'Afrique', 'Baleine bleue', 'Girafe', 'Rhinocéros'),
(20, 'Culture Générale', 'Qui a peint \"La Nuit étoilée\" ?', 'moyen', 'Vincent van Gogh', 'Claude Monet', 'Paul Cézanne', 'Edgar Degas'),
(21, 'Culture Générale', 'Quelle est la planète la plus proche du soleil ?', 'difficile', 'Mercure', 'Vénus', 'Mars', 'Jupiter'),
(22, 'Culture Générale', 'Quel est le plus grand pays d\'Amérique du Sud ?', 'facile', 'Brésil', 'Argentine', 'Pérou', 'Colombie'),
(23, 'Culture Générale', 'Qui a écrit \"Madame Bovary\" ?', 'moyen', 'Gustave Flaubert', 'Émile Zola', 'Honoré de Balzac', 'Stendhal'),
(24, 'Culture Générale', 'Quel est le plus haut sommet d\'Europe ?', 'difficile', 'Mont Elbrouz', 'Mont Blanc', 'Mont Rose', 'Mont Cervin'),
(25, 'Culture Générale', 'Quel est le plus grand océan du monde ?', 'facile', 'Pacifique', 'Atlantique', 'Indien', 'Arctique'),
(26, 'Culture Générale', 'Qui a inventé l\'imprimerie ?', 'moyen', 'Johannes Gutenberg', 'Thomas Edison', 'Benjamin Franklin', 'Leonardo da Vinci'),
(27, 'Culture Générale', 'Quelle est la capitale de l\'Espagne ?', 'difficile', 'Madrid', 'Barcelone', 'Séville', 'Valence'),
(28, 'Culture Générale', 'Quel est le plus grand désert chaud du monde ?', 'facile', 'Sahara', 'Gobi', 'Arabique', 'Australien'),
(29, 'Culture Générale', 'Qui a écrit \"Les Fleurs du Mal\" ?', 'moyen', 'Charles Baudelaire', 'Arthur Rimbaud', 'Paul Verlaine', 'Stéphane Mallarmé'),
(30, 'Culture Générale', 'Quel est le plus long fleuve d\'Asie ?', 'difficile', 'Yang-Tsé', 'Gange', 'Mékong', 'Indus'),
(31, 'Culture Générale', 'Quel est le plus grand lac d\'Afrique ?', 'facile', 'Lac Victoria', 'Lac Tanganyika', 'Lac Malawi', 'Lac Turkana'),
(32, 'Culture Générale', 'Qui a découvert la radioactivité ?', 'moyen', 'Henri Becquerel', 'Marie Curie', 'Pierre Curie', 'Wilhelm Röntgen'),
(33, 'Culture Générale', 'Quelle est la capitale du Canada ?', 'difficile', 'Ottawa', 'Toronto', 'Montréal', 'Vancouver'),
(34, 'Culture Générale', 'Quel est le plus grand pays d\'Europe ?', 'facile', 'Russie', 'Allemagne', 'France', 'Ukraine'),
(35, 'Culture Générale', 'Qui a écrit \"La Divine Comédie\" ?', 'moyen', 'Dante Alighieri', 'Giovanni Boccaccio', 'Pétrarque', 'Machiavel'),
(36, 'Culture Générale', 'Quel est le plus haut sommet d\'Amérique du Nord ?', 'difficile', 'Denali', 'Mont Whitney', 'Mont Rainier', 'Mont Logan'),
(37, 'Culture Générale', 'Quelle est la capitale de l\'Espagne?', 'facile', 'Madrid', 'Barcelone', 'Séville', 'Valence'),
(38, 'Culture Générale', 'Quel est l\'animal symbole de la France?', 'facile', 'Le coq', 'L\'aigle', 'Le lion', 'Le taureau'),
(39, 'Culture Générale', 'Quelle est la plus grande planète du système solaire?', 'facile', 'Jupiter', 'Mars', 'Saturne', 'Vénus'),
(40, 'Culture Générale', 'Qui a écrit \"Les Misérables\"?', 'facile', 'Victor Hugo', 'Émile Zola', 'Gustave Flaubert', 'Honoré de Balzac'),
(41, 'Culture Générale', 'Quel est le plus grand pays du monde?', 'facile', 'Russie', 'Canada', 'Chine', 'États-Unis'),
(42, 'Culture Générale', 'Qui a découvert la pénicilline?', 'moyen', 'Alexander Fleming', 'Louis Pasteur', 'Marie Curie', 'Robert Koch'),
(43, 'Culture Générale', 'En quelle année a eu lieu la Révolution française?', 'moyen', '1789', '1799', '1769', '1779'),
(44, 'Culture Générale', 'Quel est le plus long fleuve d\'Europe?', 'moyen', 'La Volga', 'Le Danube', 'Le Rhin', 'La Loire'),
(45, 'Culture Générale', 'Qui a peint \"Le Cri\"?', 'moyen', 'Edvard Munch', 'Vincent van Gogh', 'Pablo Picasso', 'Claude Monet'),
(46, 'Culture Générale', 'Quel est le symbole chimique de l\'or?', 'moyen', 'Au', 'Ag', 'Fe', 'Cu'),
(47, 'Culture Générale', 'Qui a formulé la théorie de la relativité restreinte?', 'difficile', 'Albert Einstein', 'Isaac Newton', 'Niels Bohr', 'Max Planck'),
(48, 'Culture Générale', 'Quel est le théorème fondamental de l\'algèbre?', 'difficile', 'Tout polynôme a une racine complexe', 'Le théorème de Pythagore', 'Le théorème de Thalès', 'Le théorème de Fermat'),
(49, 'Culture Générale', 'Qui a écrit \"Ainsi parlait Zarathoustra\"?', 'difficile', 'Friedrich Nietzsche', 'Jean-Paul Sartre', 'Emmanuel Kant', 'Arthur Schopenhauer'),
(50, 'Culture Générale', 'Quelle est la constante de Planck?', 'difficile', '6.626 x 10^-34 J⋅s', '6.022 x 10^23 mol^-1', '3.14159', '9.81 m/s^2'),
(51, 'Culture Générale', 'Qui a composé \"La Symphonie du Nouveau Monde\"?', 'difficile', 'Antonín Dvořák', 'Ludwig van Beethoven', 'Wolfgang Amadeus Mozart', 'Johann Sebastian Bach'),
(52, 'Culture Générale', 'Quelle est la capitale de l\'Espagne?', 'facile', 'Madrid', 'Barcelone', 'Séville', 'Valence'),
(53, 'Culture Générale', 'Quel est l\'animal symbole de la France?', 'facile', 'Le coq', 'L\'aigle', 'Le lion', 'Le taureau'),
(54, 'Culture Générale', 'Quelle est la plus grande planète du système solaire?', 'facile', 'Jupiter', 'Mars', 'Saturne', 'Vénus'),
(55, 'Culture Générale', 'Qui a écrit \"Les Misérables\"?', 'facile', 'Victor Hugo', 'Émile Zola', 'Gustave Flaubert', 'Honoré de Balzac'),
(56, 'Culture Générale', 'Quel est le plus grand pays du monde?', 'facile', 'Russie', 'Canada', 'Chine', 'États-Unis'),
(57, 'Culture Générale', 'Qui a découvert la pénicilline?', 'moyen', 'Alexander Fleming', 'Louis Pasteur', 'Marie Curie', 'Robert Koch'),
(58, 'Culture Générale', 'En quelle année a eu lieu la Révolution française?', 'moyen', '1789', '1799', '1769', '1779'),
(59, 'Culture Générale', 'Quel est le plus long fleuve d\'Europe?', 'moyen', 'La Volga', 'Le Danube', 'Le Rhin', 'La Loire'),
(60, 'Culture Générale', 'Qui a peint \"Le Cri\"?', 'moyen', 'Edvard Munch', 'Vincent van Gogh', 'Pablo Picasso', 'Claude Monet'),
(61, 'Culture Générale', 'Quel est le symbole chimique de l\'or?', 'moyen', 'Au', 'Ag', 'Fe', 'Cu'),
(62, 'Culture Générale', 'Qui a formulé la théorie de la relativité restreinte?', 'difficile', 'Albert Einstein', 'Isaac Newton', 'Niels Bohr', 'Max Planck'),
(63, 'Culture Générale', 'Quel est le théorème fondamental de l\'algèbre?', 'difficile', 'Tout polynôme a une racine complexe', 'Le théorème de Pythagore', 'Le théorème de Thalès', 'Le théorème de Fermat'),
(64, 'Culture Générale', 'Qui a écrit \"Ainsi parlait Zarathoustra\"?', 'difficile', 'Friedrich Nietzsche', 'Jean-Paul Sartre', 'Emmanuel Kant', 'Arthur Schopenhauer'),
(65, 'Culture Générale', 'Quelle est la constante de Planck?', 'difficile', '6.626 x 10^-34 J⋅s', '6.022 x 10^23 mol^-1', '3.14159', '9.81 m/s^2'),
(66, 'Culture Générale', 'Qui a composé \"La Symphonie du Nouveau Monde\"?', 'difficile', 'Antonín Dvořák', 'Ludwig van Beethoven', 'Wolfgang Amadeus Mozart', 'Johann Sebastian Bach');

-- --------------------------------------------------------

--
-- Structure de la table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id_quiz` int NOT NULL AUTO_INCREMENT,
  `nom_quiz` varchar(255) NOT NULL,
  PRIMARY KEY (`id_quiz`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `quizzes`
--

INSERT INTO `quizzes` (`id_quiz`, `nom_quiz`) VALUES
(1, 'Culture Générale'),
(2, 'Histoire du Monde'),
(3, 'Géographie'),
(4, 'Science et Nature'),
(5, 'Cinéma'),
(6, 'Musique'),
(7, 'Littérature'),
(8, 'Art'),
(9, 'Sports'),
(10, 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_admin`, `reset_token`, `reset_token_expiry`, `security_question`, `security_answer`) VALUES
(1, 'zaylen@gmx.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NULL, NULL, '', ''),
(2, 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, NULL, NULL, '', ''),
(4, 'lily14789@gmx.fr', '$2y$10$Hd/PWd69upMH/jvV8gqibOBlfewD.xotrlvVqKQrGtKL26XUwTJoe', 0, NULL, NULL, 'Quel est mon vampire préféré ?', '$2y$10$D2wkFj3OTFU03xg50z7Ksu8RxuWW3kOgTl5l.5vKa1G5xjjMSg8ju');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `game_history`
--
ALTER TABLE `game_history`
  ADD CONSTRAINT `game_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
