-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 sep. 2024 à 13:48
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `laboutiquefrancaise`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carrier`
--

CREATE TABLE `carrier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(7, 'Véhicule neufs', 'vehicule-neufs'),
(8, 'Véhicule d\'occasion', 'vehicule-doccasion'),
(9, 'Electrique et hybrid', 'electrique-et-hybrid'),
(10, 'Acheter', 'acheter');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240812103223', '2024-08-12 12:32:59', 109),
('DoctrineMigrations\\Version20240812103510', '2024-08-12 12:35:38', 11),
('DoctrineMigrations\\Version20240816054505', '2024-08-16 07:51:19', 65),
('DoctrineMigrations\\Version20240816061550', '2024-08-16 08:16:54', 96),
('DoctrineMigrations\\Version20240820091114', '2024-08-20 11:12:51', 143),
('DoctrineMigrations\\Version20240821081403', '2024-08-21 10:15:20', 69),
('DoctrineMigrations\\Version20240821085541', '2024-08-21 10:56:50', 109),
('DoctrineMigrations\\Version20240823085715', '2024-08-23 10:59:10', 144),
('DoctrineMigrations\\Version20240828051408', '2024-08-28 07:14:46', 131),
('DoctrineMigrations\\Version20240830081038', '2024-08-30 10:11:12', 81),
('DoctrineMigrations\\Version20240830082036', '2024-08-30 10:20:49', 48),
('DoctrineMigrations\\Version20240830100340', '2024-08-30 12:04:12', 209),
('DoctrineMigrations\\Version20240902044826', '2024-09-02 06:51:04', 62),
('DoctrineMigrations\\Version20240902104743', '2024-09-02 12:48:27', 178),
('DoctrineMigrations\\Version20240904074836', '2024-09-04 09:49:07', 370),
('DoctrineMigrations\\Version20240904120557', '2024-09-04 14:06:27', 19),
('DoctrineMigrations\\Version20240906114611', '2024-09-06 13:46:41', 68);

-- --------------------------------------------------------

--
-- Structure de la table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `button_title` varchar(255) NOT NULL,
  `button_link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `illustration` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `header`
--

INSERT INTO `header` (`id`, `button_title`, `button_link`, `title`, `content`, `illustration`) VALUES
(11, 'Découvrir Nos Produit', 'produit/bentley', 'BENTLEY', 'VOITURES DE LUXE', '2024-09-09-00959e63b9599414441590dcac30f77bd274f18a.jpg'),
(12, 'Découvrir nos produit', 'produit/continental-gt', 'Model', 'Continental GT Convertible', '2024-09-09-bba8911964fd9d2e5963ef775d2c73878fa91e34.jpg'),
(13, 'Découvrir nos produit', 'produit/lamborghini', 'Lamborghini', 'NEW PRE OWNED', '2024-09-09-294be825d1f1800c382250950978e07857282dad.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `carrier_name` varchar(255) NOT NULL,
  `carrier_price` double NOT NULL,
  `delivery` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `stripe_session_id` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `created_at`, `state`, `carrier_name`, `carrier_price`, `delivery`, `user_id`, `stripe_session_id`) VALUES
(63, '2024-08-28 08:05:20', 1, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b1sxxgw2rxHedmgCuIA0pMpKedaofKMffumXCCMKGsLdBzPyB4Pqm1eA9Q'),
(64, '2024-08-28 08:13:25', 5, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b1hgV066CnKv9KQmoghzJyFvHHUyDC9n4XmDC6zmTjFbrNN6m0iktpkqoV'),
(65, '2024-08-28 10:55:58', 4, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b1qnQjBqkTXImjZc5jqqeBJSatwJd2vSzCftXObsgdJdKfxJvzavVWbHQW'),
(66, '2024-08-28 13:27:35', 5, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b1RN3zV6BT9CY3R1eYXE8RfzfR5tnlHkYEJyBzKdB8uOzIgelBi6EMa89S'),
(67, '2024-08-28 13:33:15', 2, 'Transporteur 2', 14, 'rakotovao rakotovao<br/>iha 023 Ivandry<br/>1122 Itaosy<br/>GA<br/>032', 17, 'cs_test_b1DXygZ3hpw9VDyNrQoq0rBozgQr38MhRFCfLpJbvL6zzteR38939uCgpH'),
(68, '2024-08-29 09:38:18', 1, 'Transporteur 2', 14, 'rakotovao rakotovao<br/>iha 023 Ivandry<br/>1122 Itaosy<br/>GA<br/>032', 17, 'cs_test_b10R7JAg9wnAkTkAtWsr1qkCjopYMhXWA3SaZmOkfrVJrTnwqhtpVveewD'),
(69, '2024-08-30 13:19:19', 3, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b15cm6Gk3ubZB9WjhmAROXgvMah7KSa51YOnSgfbsBKbGF53u27P9LsySg'),
(70, '2024-08-30 13:49:37', 1, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, NULL),
(71, '2024-09-02 09:05:12', 1, 'Transporteur 2', 14, 'Ramala m Mahery<br/>iha<br/>032 tana<br/>AU<br/>032', 16, 'cs_test_b1AGB3F6FicWPn5ghQL4yg3V82ojem4hFOD2JXNEynGJCuiseCNMS9715H');

-- --------------------------------------------------------

--
-- Structure de la table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `my_order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_illustration` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` double NOT NULL,
  `product_tva` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_detail`
--

INSERT INTO `order_detail` (`id`, `my_order_id`, `product_name`, `product_illustration`, `product_quantity`, `product_price`, `product_tva`) VALUES
(56, 63, 'voiture vao2', '2024-08-16-b7baced1674aa919fc486be5d60a8029dd9de774.jpg', 2, 10, 5.5),
(57, 63, 'last Produit', '2024-08-26-dba8b5a7837e5ec2d8753eba95c5394bfa112097.jpg', 4, 23, 20),
(58, 64, 'voiture vao2', '2024-08-16-b7baced1674aa919fc486be5d60a8029dd9de774.jpg', 2, 10, 5.5),
(59, 64, 'last Produit', '2024-08-26-dba8b5a7837e5ec2d8753eba95c5394bfa112097.jpg', 4, 23, 20),
(60, 65, 'Sac nouv', '2024-08-16-343b7206d8ed653908c20f9cb7e0e47e9b98a1a8.jpg', 1, 23, 20),
(61, 66, 'Voiture Rouge', '2024-08-16-11e9eef500cf2929528e2674137d27f15d238036.jpg', 1, 456, 10),
(62, 67, 'Lambun JS', '2024-08-16-50657bcfbbae61ba42f52843127db289ea9ab3fc.jpg', 1, 789, 20),
(63, 68, 'Voiture NAME', '2024-08-16-bf20c0d9c29cb4b7a5ae44d531aff9ffa0f0c5ff.jpg', 1, 23, 10),
(64, 69, 'Voiture Rouge', '2024-08-16-11e9eef500cf2929528e2674137d27f15d238036.jpg', 1, 456, 10),
(65, 70, 'qfdgqdf', '2024-08-30-3349c468d32733e58d29fe610327a544e3b8cd2a.jpg', 2, 10, 10),
(66, 71, 'Voiture Rouge', '2024-08-16-11e9eef500cf2929528e2674137d27f15d238036.jpg', 1, 456, 10);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `illustration` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `tva` double NOT NULL,
  `is_homepage` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `description`, `illustration`, `price`, `tva`, `is_homepage`) VALUES
(29, 7, 'Bentley', 'bentley', '<div>LUXURY CARS MODEL</div>', '2024-09-09-00959e63b9599414441590dcac30f77bd274f18a.jpg', 50000, 20, 0),
(30, 7, 'Audi Q3', 'audi-q3', '<div>CHOISISSEZ VOTRE AUDI 100% ÉLECTRIQUE.<br><br></div>', '2024-09-09-550f86b8f4bc112a03096864a5f2310090161273.png', 30000, 10, 1),
(31, 8, 'RS e-tron GT performance', 'rs-e-tron-gt-performance', '<div>Consommation d\'énergie mixte:</div>', '2024-09-09-a834310a2f7ee9c6a4207d74234e35af760a17f4.png', 60000, 5.5, 1),
(32, 8, 'KIA FORD', 'kia-ford', '<div>Inspirée des modèles de course</div>', '2024-09-09-759c1a2744b41b84490cd290983981f89a04f04d.png', 10000, 5.5, 1),
(33, 8, 'Voiture de Sport', 'voiture-de-sport', '<div>Voiiture de Sport</div>', '2024-09-09-ea9dacac917bdbfe12f34943c049d54575c7bc06.jpg', 10000, 5.5, 0),
(34, 9, 'NISSAN SENTRA', 'nissan-sentra', '<div>Voyagez en 100% électrique<br><br></div>', '2024-09-09-719605b1d254ad786fea74e4e94c93f6904fec89.png', 20000, 20, 1),
(35, 8, 'BMW I5', 'bmw-i5', '<div><strong>AUTONOMIE (WLTP), JUSQU\'À 500 KILOMETRES<br></strong><br></div>', '2024-09-09-ac0a234aa12e7062557f22c07fbb72984c522484.png', 20000, 5.5, 1),
(36, 9, 'LAMBORGHINI', 'lamborghini', '<div><a href=\"https://www.lamborghini.com/en-en/news/lamborghini-lounge-porto-cervo-its-here-again\"><strong>Lamborghini Lounge Porto Cervo it’s here again</strong></a></div>', '2024-09-09-fd570fbe047359ba84bf823dec2eaa93a3439f28.jpg', 80000, 20, 1),
(37, 7, 'Continental GT', 'continental-gt', '<div>GTC STAGE MAIN</div>', '2024-09-09-bba8911964fd9d2e5963ef775d2c73878fa91e34.jpg', 50000, 20, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expire_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `token`, `token_expire_at`, `last_login_at`) VALUES
(13, 'henintsoa@gmail.com', '{\"1\":\"ROLE_ADMIN\"}', '$2y$13$x1EGkrPbjGuMMl.b1HHlNuXwbuKnKHEX5tVZ14kOImOVlUiv0293G', 'HentsAdmin', 'RazAdmin', NULL, NULL, '2024-09-09 13:34:05'),
(16, 'test@gmail.com', '[]', '$2y$13$tbseL4.lb8UPWuyUJLKAX./se0DxSSrP8Jxr/XXuLET/51gUG5Qyq', 'test', 'test', '30d5769d4519710331dd32823c2e3f', '2024-09-04 10:17:00', NULL),
(17, 'vao@gmail.com', '[]', '$2y$13$KmqkDXNzQMxN25c4bSJ5L.o1oPiNBbXdlZLpmrKZ6Mhc0V4moAyOS', 'vao', 'vao', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_product`
--

CREATE TABLE `user_product` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_product`
--

INSERT INTO `user_product` (`user_id`, `product_id`) VALUES
(13, 31);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D4E6F81A76ED395` (`user_id`);

--
-- Index pour la table `carrier`
--
ALTER TABLE `carrier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ED896F46BFCDF877` (`my_order_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `user_product`
--
ALTER TABLE `user_product`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `IDX_8B471AA7A76ED395` (`user_id`),
  ADD KEY `IDX_8B471AA74584665A` (`product_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `carrier`
--
ALTER TABLE `carrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_D4E6F81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `FK_ED896F46BFCDF877` FOREIGN KEY (`my_order_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `user_product`
--
ALTER TABLE `user_product`
  ADD CONSTRAINT `FK_8B471AA74584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8B471AA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
