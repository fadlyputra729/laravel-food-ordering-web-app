/*
 Navicat Premium Dump SQL

 Source Server         : Mariadb
 Source Server Type    : MariaDB
 Source Server Version : 110405 (11.4.5-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : brownies

 Target Server Type    : MariaDB
 Target Server Version : 110405 (11.4.5-MariaDB)
 File Encoding         : 65001

 Date: 12/03/2025 21:53:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for food
-- ----------------------------
DROP TABLE IF EXISTS `food`;
CREATE TABLE `food`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8, 2) NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `food_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of food
-- ----------------------------
INSERT INTO `food` VALUES (1, 'Bolu Tape Keju', 70000.00, 'Bolu lembut dengan rasa tape keju 20 X 20', 'Bolu', 'storage/menu/bolu-tape.jpeg', '2025-01-16 08:28:40', '2025-01-16 08:28:40');
INSERT INTO `food` VALUES (2, 'Brownies Panggang', 65000.00, 'Brownies dengan tekstur renyah di luar dan lembut di dalam. Ukuran 20x20', 'brownies', 'storage/menu/brownies-panggang.jpeg', '2025-01-16 08:28:40', '2025-01-16 08:28:40');
INSERT INTO `food` VALUES (3, 'Brownies Ulang tahun', 70000.00, 'Brownies spesial untuk hari ulang tahun. Bisa request ucapan dan free lilin', 'brownies', 'storage/menu/brownis-ultah.jpeg', '2025-01-16 08:28:40', '2025-01-16 08:28:40');
INSERT INTO `food` VALUES (4, 'Fuggie Brownies', 35000.00, 'Brownies fudgy dengan rasa cokelat yang pekat. Ukuran 22x10cm.', 'brownies', 'storage/menu/fuggie-brownies.jpeg', '2025-01-16 08:28:40', '2025-01-16 08:28:40');
INSERT INTO `food` VALUES (5, 'Marmer Cake', 75000.00, 'Cake dengan motif marmer yang cantik dan lembut. Diameter 24cm.', 'Brownies', 'storage/menu/marmer-cake.jpeg', '2025-01-16 08:28:40', '2025-01-16 08:28:40');

-- ----------------------------
-- Table structure for food_order
-- ----------------------------
DROP TABLE IF EXISTS `food_order`;
CREATE TABLE `food_order`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `food_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `harga_item` decimal(15, 0) NULL DEFAULT NULL,
  `total_item` decimal(15, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `food_order_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `food_order_food_id_foreign`(`food_id` ASC) USING BTREE,
  CONSTRAINT `food_order_food_id_foreign` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `food_order_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of food_order
-- ----------------------------
INSERT INTO `food_order` VALUES (4, 2, 4, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (5, 2, 5, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (6, 3, 1, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (7, 3, 3, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (10, 6, 1, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (11, 6, 2, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (12, 7, 1, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (13, 7, 2, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (14, 8, 2, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (15, 8, 3, 3, NULL, NULL);
INSERT INTO `food_order` VALUES (16, 8, 4, 2, 70000, 1400000);
INSERT INTO `food_order` VALUES (17, 11, 3, 1, 70000, 70000);
INSERT INTO `food_order` VALUES (18, 12, 3, 4, NULL, NULL);
INSERT INTO `food_order` VALUES (19, 13, 2, 2, 65000, 130000);
INSERT INTO `food_order` VALUES (20, 13, 3, 1, 70000, 70000);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_02_27_193758_food', 1);
INSERT INTO `migrations` VALUES (6, '2022_02_27_202353_order', 1);
INSERT INTO `migrations` VALUES (7, '2022_02_27_204135_food_order', 1);
INSERT INTO `migrations` VALUES (8, '2022_04_05_055944_change_picture_column', 1);
INSERT INTO `migrations` VALUES (9, '2022_04_05_061005_change_food_name_unique', 1);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deliveryAddress` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` decimal(15, 0) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orders_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (2, 2, '2025-01-16 15:55:15', 'delivery', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (3, 2, '2025-01-16 15:59:32', 'delivery', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (6, 3, '2025-02-12 13:15:54', 'delivery', 'jl harapan', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (7, 3, '2025-02-12 13:28:53', 'delivery', 'jl harapan', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (8, 3, '2025-02-12 13:34:24', 'pickup', 'jl harapan', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (9, 2, '2025-03-12 14:06:54', 'pickup', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (10, 2, '2025-03-12 14:07:41', 'pickup', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (11, 2, '2025-03-12 14:09:15', 'pickup', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (12, 2, '2025-03-12 14:14:13', 'pickup', 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (13, 2, '2025-03-12 14:32:37', 'pickup', 'Jl Tj seneng', 200000, '2025-03-12 07:32:37', '2025-03-12 07:32:38');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin@gmail.com', NULL, 1, '$2y$10$PEE7ThNK4Ami5ealjyJ/WO6aoz.KTD6gvYqPqnBJ/DE54VW98lc/u', '123 Main St', 'Y6XnMs56LQZPbPk6a1PhQDmJLDnXzLDIohrchGQ34D4zVZUkKRp44A6PcOBv');
INSERT INTO `users` VALUES (2, 'Fadly Putra 1', 'fadlyputra909@gmail.com', NULL, 0, '$2y$10$FseKE85yoBVDPkeaFtV3aubaMWRiQUKbny21kvU4NY3QiDSSXYjIW', 'Jl Tj seneng', NULL);
INSERT INTO `users` VALUES (3, 'FADLY PUTRA PRATAMA', 'pandawap364@gmail.com', NULL, 0, '$2y$10$DiRZnU5UAEI3hW/tQbXwS.Hl4TUFADNBRVz6/OvNmsTOA5bv3hx4u', 'jl harapan', NULL);

SET FOREIGN_KEY_CHECKS = 1;
