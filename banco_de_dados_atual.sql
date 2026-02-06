-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/02/2026 às 21:09
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u364550838_csa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_banners`
--

CREATE TABLE `csa_banners` (
  `banner_id` int(11) NOT NULL,
  `path_desktop` varchar(250) NOT NULL,
  `path_mobile` varchar(250) NOT NULL,
  `position` varchar(150) NOT NULL,
  `link` varchar(150) NOT NULL,
  `banner_order` int(11) DEFAULT NULL,
  `banner_status` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_banners_positions`
--

CREATE TABLE `csa_banners_positions` (
  `banner_position_id` int(11) NOT NULL,
  `position_title` varchar(250) NOT NULL,
  `position_value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_cities`
--

CREATE TABLE `csa_cities` (
  `idcity` int(11) NOT NULL,
  `city` varchar(120) DEFAULT NULL,
  `uf` int(2) DEFAULT NULL,
  `ibge` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Municipios das Unidades Federativas';

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_clubs`
--

CREATE TABLE `csa_clubs` (
  `club_id` int(11) NOT NULL,
  `club_title` varchar(300) NOT NULL,
  `club_description` mediumtext NOT NULL,
  `club_image` varchar(250) NOT NULL,
  `club_status` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_companies`
--

CREATE TABLE `csa_companies` (
  `company_id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `company_description` mediumtext DEFAULT NULL,
  `company_image` varchar(200) DEFAULT NULL,
  `company_category_id` int(11) DEFAULT NULL,
  `has_place` tinyint(1) NOT NULL DEFAULT 0,
  `address_zipcode` varchar(12) DEFAULT NULL,
  `address_state` int(11) DEFAULT NULL,
  `address_city` int(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `address_number` varchar(50) DEFAULT NULL,
  `address_neighborhood` varchar(100) DEFAULT NULL,
  `address_complement` varchar(150) DEFAULT NULL,
  `cellphone` varchar(15) DEFAULT NULL,
  `instagram_url` varchar(150) DEFAULT NULL,
  `site_url` varchar(150) DEFAULT NULL,
  `facebook_url` varchar(150) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0 - Disabled;\r\n1 - Approved;\r\n2 - Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_companies_categories`
--

CREATE TABLE `csa_companies_categories` (
  `id_company_category` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_contents`
--

CREATE TABLE `csa_contents` (
  `idcontent` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `excerpt` varchar(350) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `featured_image` varchar(250) DEFAULT NULL,
  `featured_video` varchar(250) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_contents_comments`
--

CREATE TABLE `csa_contents_comments` (
  `idcomment` int(11) NOT NULL,
  `idcontent` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_contents_terms`
--

CREATE TABLE `csa_contents_terms` (
  `idterm` int(11) NOT NULL,
  `term_name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `term_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_coupons`
--

CREATE TABLE `csa_coupons` (
  `coupon_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percent','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expiration_date` datetime NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_events`
--

CREATE TABLE `csa_events` (
  `idevent` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_excerpt` varchar(250) DEFAULT NULL,
  `event_datetime` datetime NOT NULL,
  `event_poster` varchar(255) DEFAULT NULL,
  `event_content` mediumtext DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `qrcode_uuid` uuid DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_events_checkins`
--

CREATE TABLE `csa_events_checkins` (
  `events_checkin_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `checkin_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_logs`
--

CREATE TABLE `csa_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` text DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_medias`
--

CREATE TABLE `csa_medias` (
  `media_id` int(11) NOT NULL,
  `path` varchar(250) NOT NULL,
  `attributes` varchar(1500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_memberships`
--

CREATE TABLE `csa_memberships` (
  `membership_id` int(11) NOT NULL,
  `membership_title` varchar(255) NOT NULL,
  `membership_description` mediumtext DEFAULT NULL,
  `membership_duration` int(11) NOT NULL COMMENT 'Duração em dias',
  `membership_price_incash` decimal(10,2) NOT NULL,
  `membership_price_cc` decimal(10,2) NOT NULL,
  `membership_status` tinyint(1) DEFAULT 1 COMMENT '0 = inativo, 1 = ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_notices`
--

CREATE TABLE `csa_notices` (
  `idnotice` int(11) NOT NULL,
  `notice_title` varchar(250) NOT NULL,
  `notice_content` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_plans`
--

CREATE TABLE `csa_plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(250) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `access_length` int(5) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_posts`
--

CREATE TABLE `csa_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `excerpt` varchar(350) DEFAULT NULL,
  `post_content` mediumtext DEFAULT NULL,
  `featured_image` varchar(250) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_posts_comments`
--

CREATE TABLE `csa_posts_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `comment` mediumtext NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `ip` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_publis`
--

CREATE TABLE `csa_publis` (
  `publi_id` int(11) NOT NULL,
  `publi_title` varchar(255) DEFAULT NULL,
  `publi_content` mediumtext NOT NULL,
  `publi_image` varchar(250) DEFAULT NULL,
  `publi_status` tinyint(1) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `published_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_publis_comments`
--

CREATE TABLE `csa_publis_comments` (
  `publi_comment_id` int(11) NOT NULL,
  `publi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_publis_likes`
--

CREATE TABLE `csa_publis_likes` (
  `publi_likes_id` int(11) NOT NULL,
  `publi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_remember_tokens`
--

CREATE TABLE `csa_remember_tokens` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_states`
--

CREATE TABLE `csa_states` (
  `idstate` int(11) NOT NULL,
  `state` varchar(75) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Unidades Federativas';

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_terms`
--

CREATE TABLE `csa_terms` (
  `term_id` int(11) NOT NULL,
  `term_name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_terms_relationships`
--

CREATE TABLE `csa_terms_relationships` (
  `object_id` bigint(20) NOT NULL,
  `term_id` bigint(20) NOT NULL,
  `term_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_tutorials`
--

CREATE TABLE `csa_tutorials` (
  `tutorial_id` uuid NOT NULL DEFAULT uuid(),
  `tutorial_title` varchar(450) NOT NULL,
  `tutorial_video_url` varchar(550) DEFAULT NULL,
  `tutorial_content` text NOT NULL,
  `tutorial_order` tinyint(3) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_users`
--

CREATE TABLE `csa_users` (
  `iduser` int(11) NOT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `profile_photo` varchar(150) DEFAULT NULL,
  `biography` mediumtext DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `address_state` int(11) DEFAULT NULL,
  `address_city` int(11) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `address_number` varchar(50) DEFAULT NULL,
  `address_neighborhood` varchar(100) DEFAULT NULL,
  `address_complement` varchar(150) DEFAULT NULL,
  `cellphone` varchar(15) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` char(62) DEFAULT NULL,
  `user_type` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_users_consulting`
--

CREATE TABLE `csa_users_consulting` (
  `user_consulting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `consulting_date` datetime NOT NULL,
  `consulting_observation` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_users_memberships`
--

CREATE TABLE `csa_users_memberships` (
  `idusermembership` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_code` int(255) DEFAULT NULL,
  `coupon_discount_type` varchar(25) DEFAULT NULL,
  `coupon_discount_value` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_value` decimal(10,2) DEFAULT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_users_memberships_original`
--

CREATE TABLE `csa_users_memberships_original` (
  `idusermembership` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_value` decimal(10,2) DEFAULT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_users_passwords_resets`
--

CREATE TABLE `csa_users_passwords_resets` (
  `password_reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `csa_user_diamonds`
--

CREATE TABLE `csa_user_diamonds` (
  `user_diamonds_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `diamond_value` int(11) NOT NULL,
  `diamond_origin_id` int(11) DEFAULT NULL,
  `diamond_origin_type` varchar(100) DEFAULT NULL,
  `diamond_observation` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `csa_banners`
--
ALTER TABLE `csa_banners`
  ADD PRIMARY KEY (`banner_id`);

--
-- Índices de tabela `csa_banners_positions`
--
ALTER TABLE `csa_banners_positions`
  ADD PRIMARY KEY (`banner_position_id`);

--
-- Índices de tabela `csa_cities`
--
ALTER TABLE `csa_cities`
  ADD PRIMARY KEY (`idcity`);

--
-- Índices de tabela `csa_clubs`
--
ALTER TABLE `csa_clubs`
  ADD PRIMARY KEY (`club_id`);

--
-- Índices de tabela `csa_companies`
--
ALTER TABLE `csa_companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Índices de tabela `csa_companies_categories`
--
ALTER TABLE `csa_companies_categories`
  ADD PRIMARY KEY (`id_company_category`);

--
-- Índices de tabela `csa_contents`
--
ALTER TABLE `csa_contents`
  ADD PRIMARY KEY (`idcontent`);

--
-- Índices de tabela `csa_contents_comments`
--
ALTER TABLE `csa_contents_comments`
  ADD PRIMARY KEY (`idcomment`);

--
-- Índices de tabela `csa_contents_terms`
--
ALTER TABLE `csa_contents_terms`
  ADD PRIMARY KEY (`idterm`);

--
-- Índices de tabela `csa_coupons`
--
ALTER TABLE `csa_coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Índices de tabela `csa_events`
--
ALTER TABLE `csa_events`
  ADD PRIMARY KEY (`idevent`);

--
-- Índices de tabela `csa_events_checkins`
--
ALTER TABLE `csa_events_checkins`
  ADD PRIMARY KEY (`events_checkin_id`);

--
-- Índices de tabela `csa_logs`
--
ALTER TABLE `csa_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Índices de tabela `csa_medias`
--
ALTER TABLE `csa_medias`
  ADD PRIMARY KEY (`media_id`);

--
-- Índices de tabela `csa_memberships`
--
ALTER TABLE `csa_memberships`
  ADD PRIMARY KEY (`membership_id`);

--
-- Índices de tabela `csa_notices`
--
ALTER TABLE `csa_notices`
  ADD PRIMARY KEY (`idnotice`);

--
-- Índices de tabela `csa_plans`
--
ALTER TABLE `csa_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Índices de tabela `csa_posts`
--
ALTER TABLE `csa_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Índices de tabela `csa_posts_comments`
--
ALTER TABLE `csa_posts_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Índices de tabela `csa_publis`
--
ALTER TABLE `csa_publis`
  ADD PRIMARY KEY (`publi_id`);

--
-- Índices de tabela `csa_publis_comments`
--
ALTER TABLE `csa_publis_comments`
  ADD PRIMARY KEY (`publi_comment_id`);

--
-- Índices de tabela `csa_publis_likes`
--
ALTER TABLE `csa_publis_likes`
  ADD PRIMARY KEY (`publi_likes_id`);

--
-- Índices de tabela `csa_remember_tokens`
--
ALTER TABLE `csa_remember_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `csa_states`
--
ALTER TABLE `csa_states`
  ADD PRIMARY KEY (`idstate`);

--
-- Índices de tabela `csa_terms`
--
ALTER TABLE `csa_terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Índices de tabela `csa_tutorials`
--
ALTER TABLE `csa_tutorials`
  ADD PRIMARY KEY (`tutorial_id`);

--
-- Índices de tabela `csa_users`
--
ALTER TABLE `csa_users`
  ADD PRIMARY KEY (`iduser`);

--
-- Índices de tabela `csa_users_consulting`
--
ALTER TABLE `csa_users_consulting`
  ADD PRIMARY KEY (`user_consulting_id`);

--
-- Índices de tabela `csa_users_memberships`
--
ALTER TABLE `csa_users_memberships`
  ADD PRIMARY KEY (`idusermembership`);

--
-- Índices de tabela `csa_users_memberships_original`
--
ALTER TABLE `csa_users_memberships_original`
  ADD PRIMARY KEY (`idusermembership`);

--
-- Índices de tabela `csa_users_passwords_resets`
--
ALTER TABLE `csa_users_passwords_resets`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `csa_user_diamonds`
--
ALTER TABLE `csa_user_diamonds`
  ADD PRIMARY KEY (`user_diamonds_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `csa_banners`
--
ALTER TABLE `csa_banners`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_banners_positions`
--
ALTER TABLE `csa_banners_positions`
  MODIFY `banner_position_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_clubs`
--
ALTER TABLE `csa_clubs`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_companies`
--
ALTER TABLE `csa_companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_companies_categories`
--
ALTER TABLE `csa_companies_categories`
  MODIFY `id_company_category` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_contents`
--
ALTER TABLE `csa_contents`
  MODIFY `idcontent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_contents_comments`
--
ALTER TABLE `csa_contents_comments`
  MODIFY `idcomment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_contents_terms`
--
ALTER TABLE `csa_contents_terms`
  MODIFY `idterm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_coupons`
--
ALTER TABLE `csa_coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_events`
--
ALTER TABLE `csa_events`
  MODIFY `idevent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_events_checkins`
--
ALTER TABLE `csa_events_checkins`
  MODIFY `events_checkin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_logs`
--
ALTER TABLE `csa_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_medias`
--
ALTER TABLE `csa_medias`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_memberships`
--
ALTER TABLE `csa_memberships`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_notices`
--
ALTER TABLE `csa_notices`
  MODIFY `idnotice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_plans`
--
ALTER TABLE `csa_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_posts`
--
ALTER TABLE `csa_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_posts_comments`
--
ALTER TABLE `csa_posts_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_publis`
--
ALTER TABLE `csa_publis`
  MODIFY `publi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_publis_comments`
--
ALTER TABLE `csa_publis_comments`
  MODIFY `publi_comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_publis_likes`
--
ALTER TABLE `csa_publis_likes`
  MODIFY `publi_likes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_remember_tokens`
--
ALTER TABLE `csa_remember_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_terms`
--
ALTER TABLE `csa_terms`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_users`
--
ALTER TABLE `csa_users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_users_consulting`
--
ALTER TABLE `csa_users_consulting`
  MODIFY `user_consulting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_users_memberships`
--
ALTER TABLE `csa_users_memberships`
  MODIFY `idusermembership` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_users_memberships_original`
--
ALTER TABLE `csa_users_memberships_original`
  MODIFY `idusermembership` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_users_passwords_resets`
--
ALTER TABLE `csa_users_passwords_resets`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `csa_user_diamonds`
--
ALTER TABLE `csa_user_diamonds`
  MODIFY `user_diamonds_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
