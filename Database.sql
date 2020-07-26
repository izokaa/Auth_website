-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 26 juil. 2020 à 12:23
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `logintest`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `accounts`
--

REPLACE INTO `accounts` (`id`, `username`, `password`, `email`) VALUES
(1, 'test', '$2y$10$dDQ.Y6//3S3dO4BFY86mxesqe7li7KDyKdArAigga7b0nOHLBM4K.', 'test@test.com'),
(2, 'tsta', '$2y$10$J8n0S29YpHb0Z96kE9zUx.PDImaHtb4FjS1PZ1BB2dYdyy.6RatwS', 'hightwarrior123@gmail.com'),
(3, 'izokaa', '$2y$10$1T2BawIedU5mVuMhWpovn.bg.s1.yC8zW/fg3oWP.UiMnTMnU6psC', 'mail@mail.com'),
(4, 'izokaaa', '$2y$10$admkomNlZIvvhBUp2OTDDuov8ocXgL.19LpWmIdxbOeNcL5tCeTYa', 'mail@mail.com');

-- --------------------------------------------------------

--
-- Structure de la table `passwors_reset`
--

CREATE TABLE `passwors_reset` (
  `id` int(11) NOT NULL,
  `reset_key` text NOT NULL,
  `username` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `passwors_reset`
--

REPLACE INTO `passwors_reset` (`id`, `reset_key`, `username`, `created_at`) VALUES
(2, '325a586b1e434a69838902e71d4e5c0e0ec448eee8b49e25324c3c101ab1', 'test', '2020-07-06 22:39:59');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `passwors_reset`
--
ALTER TABLE `passwors_reset`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `passwors_reset`
--
ALTER TABLE `passwors_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
