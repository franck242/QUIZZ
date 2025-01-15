SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
    START TRANSACTION;
    SET time_zone = "+00:00";

    --
    -- Base de données : `youtube_qcm`
    --
    CREATE DATABASE IF NOT EXISTS `youtube_qcm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
    USE `youtube_qcm`;

    -- --------------------------------------------------------

    --
    -- Table structure for table `quizzes`
    --

    DROP TABLE IF EXISTS `quizzes`;
    CREATE TABLE IF NOT EXISTS `quizzes` (
      `id_quiz` int(11) NOT NULL AUTO_INCREMENT,
      `nom_quiz` varchar(255) NOT NULL,
      PRIMARY KEY (`id_quiz`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- --------------------------------------------------------

    --
    -- Table structure for table `questions`
    --

    DROP TABLE IF EXISTS `questions`;
    CREATE TABLE IF NOT EXISTS `questions` (
      `idq` int(11) NOT NULL AUTO_INCREMENT,
      `id_quiz` int(11) NOT NULL,
      `libelleQ` varchar(255) NOT NULL,
      `niveau` ENUM('facile', 'moyen', 'difficile') NOT NULL,
      PRIMARY KEY (`idq`),
      FOREIGN KEY (`id_quiz`) REFERENCES `quizzes`(`id_quiz`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- --------------------------------------------------------

    --
    -- Table structure for table `reponses`
    --

    DROP TABLE IF EXISTS `reponses`;
    CREATE TABLE IF NOT EXISTS `reponses` (
      `idr` int(11) NOT NULL AUTO_INCREMENT,
      `idq` int(11) NOT NULL,
      `libeller` varchar(255) NOT NULL,
      `verite` tinyint(1) NOT NULL,
      PRIMARY KEY (`idr`),
      FOREIGN KEY (`idq`) REFERENCES `questions`(`idq`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- --------------------------------------------------------

    --
    -- Table structure for table `users`
    --

    DROP TABLE IF EXISTS `users`;
    CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `is_admin` tinyint(1) NOT NULL DEFAULT '0',
      `reset_token` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    --
    -- Dumping data for table `quizzes`
    --

    INSERT INTO `quizzes` (`nom_quiz`) VALUES
    ('Culture Générale 1'),
    ('Histoire du Monde'),
    ('Géographie'),
    ('Science et Nature'),
    ('Cinéma'),
    ('Musique'),
    ('Littérature'),
    ('Art'),
    ('Sports'),
    ('Informatique');

    --
    -- Dumping data for table `questions` and `reponses`
    --

    -- Culture Générale 1
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (1, 'Quelle est la capitale de la France ?', 'facile'),
    (1, 'Qui a peint la Joconde ?', 'moyen'),
    (1, 'Quel est le plus grand océan du monde ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (1, 'Berlin', 0), (1, 'Paris', 1), (1, 'Madrid', 0), (1, 'Rome', 0),
    (2, 'Michel-Ange', 0), (2, 'Léonard de Vinci', 1), (2, 'Raphaël', 0), (2, 'Donatello', 0),
    (3, 'Atlantique', 0), (3, 'Indien', 0), (3, 'Arctique', 0), (3, 'Pacifique', 1);

    -- Histoire du Monde
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (2, 'En quelle année a commencé la Première Guerre mondiale ?', 'facile'),
    (2, 'Qui était le premier empereur romain ?', 'moyen'),
    (2, 'Quel événement a marqué le début de la Révolution française ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (4, '1914', 1), (4, '1918', 0), (4, '1939', 0), (4, '1945', 0),
    (5, 'Jules César', 0), (5, 'Auguste', 1), (5, 'Néron', 0), (5, 'Caligula', 0),
    (6, 'La prise de la Bastille', 1), (6, 'La bataille de Valmy', 0), (6, 'Le serment du Jeu de paume', 0), (6, 'La déclaration des droits de l\'homme', 0);

    -- Géographie
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (3, 'Quel est le plus long fleuve du monde ?', 'facile'),
    (3, 'Quelle est la capitale de l\'Australie ?', 'moyen'),
    (3, 'Quel est le plus haut sommet d\'Afrique ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (7, 'Amazone', 1), (7, 'Nil', 0), (7, 'Yang-Tsé', 0), (7, 'Mississippi', 0),
    (8, 'Sydney', 0), (8, 'Melbourne', 0), (8, 'Canberra', 1), (8, 'Brisbane', 0),
    (9, 'Mont Blanc', 0), (9, 'Kilimandjaro', 1), (9, 'Mont Kenya', 0), (9, 'Mont Cameroun', 0);

    -- Science et Nature
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (4, 'Quelle est la formule chimique de l\'eau ?', 'facile'),
    (4, 'Quel est le plus grand mammifère terrestre ?', 'moyen'),
    (4, 'Quelle est la vitesse de la lumière dans le vide ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (10, 'H2O', 1), (10, 'CO2', 0), (10, 'NaCl', 0), (10, 'O2', 0),
    (11, 'Éléphant d\'Afrique', 1), (11, 'Baleine bleue', 0), (11, 'Girafe', 0), (11, 'Rhinocéros', 0),
    (12, '200 000 km/s', 0), (12, '300 000 km/s', 1), (12, '400 000 km/s', 0), (12, '500 000 km/s', 0);

    -- Cinéma
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (5, 'Qui a réalisé le film "Titanic" ?', 'facile'),
    (5, 'Quel acteur a joué le rôle de Tony Stark dans "Iron Man" ?', 'moyen'),
    (5, 'Quel film a remporté l\'Oscar du meilleur film en 2020 ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (13, 'Steven Spielberg', 0), (13, 'James Cameron', 1), (13, 'Christopher Nolan', 0), (13, 'Quentin Tarantino', 0),
    (14, 'Chris Hemsworth', 0), (14, 'Chris Evans', 0), (14, 'Robert Downey Jr.', 1), (14, 'Mark Ruffalo', 0),
    (15, 'Parasite', 1), (15, '1917', 0), (15, 'Joker', 0), (15, 'Once Upon a Time in Hollywood', 0);

    -- Musique
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (6, 'Qui est le roi de la pop ?', 'facile'),
    (6, 'Quel groupe a chanté "Bohemian Rhapsody" ?', 'moyen'),
    (6, 'Quel est le nom du premier album de Nirvana ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (16, 'Elvis Presley', 0), (16, 'Michael Jackson', 1), (16, 'Prince', 0), (16, 'Madonna', 0),
    (17, 'The Beatles', 0), (17, 'The Rolling Stones', 0), (17, 'Queen', 1), (17, 'Led Zeppelin', 0),
    (18, 'Nevermind', 0), (18, 'Bleach', 1), (18, 'In Utero', 0), (18, 'Unplugged in New York', 0);

    -- Littérature
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (7, 'Qui a écrit "Le Petit Prince" ?', 'facile'),
    (7, 'Quel est le nom du personnage principal de "L\'Étranger" d\'Albert Camus ?', 'moyen'),
    (7, 'Qui est l\'auteur de "1984" ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (19, 'Victor Hugo', 0), (19, 'Antoine de Saint-Exupéry', 1), (19, 'Albert Camus', 0), (19, 'Jules Verne', 0),
    (20, 'Jean Valjean', 0), (20, 'Meursault', 1), (20, 'Raskolnikov', 0), (20, 'Gatsby', 0),
    (21, 'Aldous Huxley', 0), (21, 'Ray Bradbury', 0), (21, 'George Orwell', 1), (21, 'Philip K. Dick', 0);

    -- Art
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (8, 'Qui a peint "La Nuit étoilée" ?', 'facile'),
    (8, 'Quel est le mouvement artistique associé à Salvador Dalí ?', 'moyen'),
    (8, 'Où se trouve la statue de la Liberté ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (22, 'Claude Monet', 0), (22, 'Vincent van Gogh', 1), (22, 'Paul Cézanne', 0), (22, 'Edgar Degas', 0),
    (23, 'Impressionnisme', 0), (23, 'Surréalisme', 1), (23, 'Cubisme', 0), (23, 'Réalisme', 0),
    (24, 'Londres', 0), (24, 'Paris', 0), (24, 'New York', 1), (24, 'Rome', 0);

    -- Sports
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (9, 'Quel sport utilise un ballon ovale ?', 'facile'),
    (9, 'Combien de joueurs composent une équipe de basketball ?', 'moyen'),
    (9, 'Quel pays a remporté la Coupe du Monde de football en 2018 ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (25, 'Football', 0), (25, 'Basketball', 0), (25, 'Rugby', 1), (25, 'Tennis', 0),
    (26, '5', 1), (26, '7', 0), (26, '9', 0), (26, '11', 0),
    (27, 'Allemagne', 0), (27, 'Brésil', 0), (27, 'France', 1), (27, 'Espagne', 0);

    -- Informatique
    INSERT INTO `questions` (`id_quiz`, `libelleQ`, `niveau`) VALUES
    (10, 'Que signifie HTML ?', 'facile'),
    (10, 'Quel langage de programmation est souvent utilisé pour le développement web côté serveur ?', 'moyen'),
    (10, 'Qu\'est-ce qu\'un algorithme ?', 'difficile');

    INSERT INTO `reponses` (`idq`, `libeller`, `verite`) VALUES
    (28, 'Hyper Text Markup Language', 1), (28, 'High Tech Machine Learning', 0), (28, 'Home Tool Management Language', 0), (28, 'Hyperlink and Text Management Language', 0),
    (29, 'JavaScript', 0), (29, 'Python', 1), (29, 'C++', 0), (29, 'Java', 0),
    (30, 'Une instruction de code', 0), (30, 'Une suite d\'instructions pour résoudre un problème', 1), (30, 'Un type de variable', 0), (30, 'Un système d\'exploitation', 0);

    --
    -- Dumping data for table `users`
    --

    DROP TABLE IF EXISTS `users`;
    CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `is_admin` tinyint(1) NOT NULL DEFAULT '0',
      `reset_token` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    INSERT INTO `users` (`email`, `password`, `is_admin`) VALUES
    ('admin@example.com', 'admin', 1),
    ('user@example.com', 'user', 0);
    COMMIT;
