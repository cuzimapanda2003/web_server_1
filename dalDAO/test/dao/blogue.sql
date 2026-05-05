DROP DATABASE IF EXISTS `blogue`;
CREATE DATABASE `blogue`;
USE `blogue`;

CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_UNIQUE` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_UNIQUE` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `utilisateur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `chemin_avatar` text NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  UNIQUE KEY `nom_utilisateur_UNIQUE` (`nom_utilisateur`),
  UNIQUE KEY `courriel_UNIQUE` (`courriel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime NOT NULL,
  `publie` tinyint(1) NOT NULL DEFAULT 0,
  `utilisateur_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `commentaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `texte` text NOT NULL,
  `date_publication` datetime NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  `utilisateur_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `article_tag` (
  `tag_id` int(10) unsigned NOT NULL,
  `article_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`, `article_id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `blogue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `utilisateur_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY `utilisateur_UNIQUE` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tag` VALUES(NULL, 'Cuisine');
INSERT INTO `tag` VALUES(NULL, 'Sport');
INSERT INTO `tag` VALUES(NULL, 'Politique');
INSERT INTO `tag` VALUES(NULL, 'Économie');
INSERT INTO `tag` VALUES(NULL, 'Divers');

INSERT INTO `role` VALUES(NULL, 'Administrateur');
INSERT INTO `role` VALUES(NULL, 'Blogueur');

/* Le mot de passe est "bonjour" pour tous les utilisateurs */
INSERT INTO `utilisateur` VALUES(NULL, 'root', 'root', 'root', 'root@gmail.com', 1, NULL, '$2y$10$HYeLAxdInF2N6tGbYKYqBOpAcnXyPX9.hgHMnjb7PJOUnlqUm7Qqu');
INSERT INTO `utilisateur` VALUES(NULL, 'tremblayj', 'Jean', 'Tremblay', 'tremblayj@gmail.com', 2, 'assets/img/troll.png', '$2y$10$BVjmnMgch0a0jqJKbFWmGeel/IlQkNtnwGkJb8dAUvaAJuFo72VnO');
INSERT INTO `utilisateur` VALUES(NULL, 'gendronm', 'Marie', 'Gendron', 'gendronm@gmail.com', 2, 'assets/img/marie.jpg', '$2y$10$H3qx/AB5A7jHrVug8pNBsOrpBhEJxpscjOMvttyH1M5Zuxm.oHsv6');
INSERT INTO `utilisateur` VALUES(NULL, 'monchampf', 'Frédéric', 'Monchamp', 'prof@gmail.com', 2, NULL, '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');

INSERT INTO `blogue` VALUES(NULL, 'Troll', 'Je suis un troll... et je trolle tout le monde, mouhahahahaha!', '2022-02-05 06:24:12', 2);
INSERT INTO `blogue` VALUES(NULL, 'Méli-mélo', 'J''écris sur tout et sur rien...', '2022-04-05 07:33:22', 3);
INSERT INTO `blogue` VALUES(NULL, 'Un blogue vide', 'J''écris jamais d''article...', '2022-10-08 09:21:56', 4);

INSERT INTO `article` VALUES(NULL,'Mon premier article!','Ceci est mon premier article. Fin de l''histoire', '2022-02-06 12:25:19', '2022-02-06 12:25:55', 1, 2);
INSERT INTO `article` VALUES(NULL,'Ma présentation','Bonjour, je me présente, je m''appelle Marie!', '2022-10-13 08:56:21', '2022-10-14 10:33:24', 1, 3);
INSERT INTO `article` VALUES(NULL,'Constat','Finalement, je constate que je n''aime pas avoir un blogue! C''est long écrire... et il faut penser!', '2022-11-14 04:44:24', '2022-11-14 04:44:24', 0, 3);

INSERT INTO `commentaire` VALUES(NULL, 'J''ai une plume magnifique!', '2022-02-06 12:55:16', 1, 2);
INSERT INTO `commentaire` VALUES(NULL, 'Oui, c''est vrai!', '2022-02-07 06:35:40', 1, 3);
INSERT INTO `commentaire` VALUES(NULL, 'Zzzzzzzzzzzzzzzzzzzzzz', '2022-10-13 08:58:25', 2, 2);
INSERT INTO `commentaire` VALUES(NULL, 'C''est méchant!', '2022-10-14 06:36:19', 2, 3);
INSERT INTO `commentaire` VALUES(NULL, 'Spam spam spam!', '2022-10-15 08:12:43', 2, 2);
INSERT INTO `commentaire` VALUES(NULL, 'Spam spam spam!', '2022-10-15 08:12:44', 2, 2);
INSERT INTO `commentaire` VALUES(NULL, 'Spam spam spam!', '2022-10-15 08:12:45', 2, 2);

INSERT INTO `article_tag` VALUES(3,1);
INSERT INTO `article_tag` VALUES(5,1);
INSERT INTO `article_tag` VALUES(1,2);
INSERT INTO `article_tag` VALUES(2,2);





