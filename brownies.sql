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

 Date: 27/03/2025 22:31:48
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
  `stock` bigint(20) NULL DEFAULT 0,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `food_name_unique`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of food
-- ----------------------------
INSERT INTO `food` VALUES (1, 'Bolu Tape Keju', 70000.00, 'Bolu lembut dengan rasa tape keju 20 X 20', 0, 'Bolu', 'storage/menu/bolu-tape.jpeg', '2025-01-16 15:28:40', '2025-01-16 15:28:40');
INSERT INTO `food` VALUES (2, 'Brownies Panggang', 65000.00, 'Brownies dengan tekstur renyah di luar dan lembut di dalam. Ukuran 20x20', 0, 'brownies', 'storage/menu/brownies-panggang.jpeg', '2025-01-16 15:28:40', '2025-01-16 15:28:40');
INSERT INTO `food` VALUES (3, 'Brownies Ulang tahun', 70000.00, 'Brownies spesial untuk hari ulang tahun. Bisa request ucapan dan free lilin', 0, 'brownies', 'storage/menu/brownis-ultah.jpeg', '2025-01-16 15:28:40', '2025-01-16 15:28:40');
INSERT INTO `food` VALUES (4, 'Fuggie Brownies', 35000.00, 'Brownies fudgy dengan rasa cokelat yang pekat. Ukuran 22x10cm.', 0, 'brownies', 'storage/menu/fuggie-brownies.jpeg', '2025-01-16 15:28:40', '2025-01-16 15:28:40');
INSERT INTO `food` VALUES (5, 'Marmer Cake', 75000.00, 'Cake dengan motif marmer yang cantik dan lembut. Diameter 24cm.', 2, 'Brownies', 'storage/menu/marmer-cake.jpeg', '2025-01-16 15:28:40', '2025-01-16 15:28:40');

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
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of food_order
-- ----------------------------
INSERT INTO `food_order` VALUES (6, 3, 1, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (7, 3, 3, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (12, 7, 1, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (13, 7, 2, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (14, 8, 2, 1, NULL, NULL);
INSERT INTO `food_order` VALUES (15, 8, 3, 3, NULL, NULL);
INSERT INTO `food_order` VALUES (16, 8, 4, 2, 70000, 1400000);
INSERT INTO `food_order` VALUES (17, 11, 3, 1, 70000, 70000);
INSERT INTO `food_order` VALUES (21, 14, 3, 2, 70000, 140000);
INSERT INTO `food_order` VALUES (22, 15, 2, 4, 65000, 260000);
INSERT INTO `food_order` VALUES (23, 16, 2, 4, 65000, 260000);
INSERT INTO `food_order` VALUES (24, 18, 2, 2, 65000, 130000);
INSERT INTO `food_order` VALUES (25, 20, 2, 1, 65000, 65000);
INSERT INTO `food_order` VALUES (26, 21, 2, 1, 65000, 65000);
INSERT INTO `food_order` VALUES (27, 22, 2, 2, 65000, 130000);
INSERT INTO `food_order` VALUES (28, 23, 2, 1, 65000, 65000);
INSERT INTO `food_order` VALUES (29, 24, 2, 1, 65000, 65000);
INSERT INTO `food_order` VALUES (30, 24, 3, 1, 70000, 70000);
INSERT INTO `food_order` VALUES (31, 25, 3, 1, 70000, 70000);
INSERT INTO `food_order` VALUES (32, 26, 2, 5, 65000, 325000);
INSERT INTO `food_order` VALUES (33, 28, 2, 1, 65000, 65000);
INSERT INTO `food_order` VALUES (34, 29, 5, 4, 75000, 300000);
INSERT INTO `food_order` VALUES (35, 37, 5, 3, 75000, 225000);
INSERT INTO `food_order` VALUES (36, 39, 2, 2, 65000, 130000);

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
  `status` enum('selesai','proses','batal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'proses',
  `status_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deliveryAddress` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` decimal(15, 0) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orders_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (3, 2, '2025-01-16 15:59:32', 'delivery', 'batal', NULL, NULL, 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (7, 3, '2025-02-12 13:28:53', 'delivery', 'proses', NULL, NULL, 'jl harapan', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (8, 3, '2025-02-12 13:34:24', 'pickup', 'proses', NULL, NULL, 'jl harapan', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (9, 2, '2025-03-12 14:06:54', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (10, 2, '2025-03-12 14:07:41', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (11, 2, '2025-03-12 14:09:15', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, NULL, NULL);
INSERT INTO `orders` VALUES (14, 2, '2025-03-19 20:41:21', 'delivery', 'proses', NULL, NULL, 'Jl Tj seneng', 140000, '2025-03-19 20:41:21', '2025-03-19 20:41:21');
INSERT INTO `orders` VALUES (15, 2, '2025-03-19 20:42:44', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', 260000, '2025-03-19 20:42:44', '2025-03-19 20:42:44');
INSERT INTO `orders` VALUES (16, 2, '2025-03-19 20:48:55', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, '2025-03-19 20:48:55', '2025-03-19 20:48:55');
INSERT INTO `orders` VALUES (17, 2, '2025-03-19 20:49:11', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, '2025-03-19 20:49:11', '2025-03-19 20:49:11');
INSERT INTO `orders` VALUES (18, 2, '2025-03-19 20:54:21', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', 130000, '2025-03-19 20:54:21', '2025-03-19 20:54:21');
INSERT INTO `orders` VALUES (19, 2, '2025-03-19 20:55:53', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, '2025-03-19 20:55:53', '2025-03-19 20:55:53');
INSERT INTO `orders` VALUES (20, 2, '2025-03-19 20:56:07', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', 65000, '2025-03-19 20:56:07', '2025-03-19 20:56:07');
INSERT INTO `orders` VALUES (21, 2, '2025-03-19 20:56:48', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', 65000, '2025-03-19 20:56:48', '2025-03-19 20:56:48');
INSERT INTO `orders` VALUES (22, 2, '2025-03-19 20:57:33', 'pickup', 'proses', NULL, NULL, 'Jl Tj seneng', 130000, '2025-03-19 20:57:33', '2025-03-19 20:57:33');
INSERT INTO `orders` VALUES (23, 2, '2025-03-19 21:05:17', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/abd6c6b0-1657-45bf-a65a-4da5848df71d', 'Jl Tj seneng', 65000, '2025-03-19 21:05:17', '2025-03-19 21:05:17');
INSERT INTO `orders` VALUES (24, 2, '2025-03-19 21:07:01', 'pickup', 'proses', 'success', 'https://app.sandbox.midtrans.com/snap/v4/redirection/cc5e4ba1-98e4-4720-bee7-2b35c06a1304', 'Jl Tj seneng', 135000, '2025-03-19 21:07:01', '2025-03-19 21:07:02');
INSERT INTO `orders` VALUES (25, 2, '2025-03-19 21:14:54', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/8b26a9a3-68e2-4452-b2e7-3ab1b7557dc4', 'Jl Tj seneng', 70000, '2025-03-19 21:14:54', '2025-03-19 21:14:55');
INSERT INTO `orders` VALUES (26, 2, '2025-03-19 21:27:05', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/37769d93-e9cc-4cea-843d-1782b6b23f7d', 'Jl Tj seneng', 325000, '2025-03-19 21:27:05', '2025-03-19 21:27:05');
INSERT INTO `orders` VALUES (27, 2, '2025-03-19 21:27:33', 'delivery', 'proses', NULL, NULL, 'Jl Tj seneng', NULL, '2025-03-19 21:27:33', '2025-03-19 21:27:33');
INSERT INTO `orders` VALUES (28, 2, '2025-03-19 21:27:49', 'delivery', 'selesai', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/2b5895c8-8bcf-4786-933b-ab4e201d9066', 'Jl Tj seneng', 65000, '2025-03-19 21:27:49', '2025-03-19 21:28:15');
INSERT INTO `orders` VALUES (29, 2, '2025-03-27 21:50:13', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/a0fc8e6d-0849-462f-a1dc-790aefedd83c', 'Jl Tj seneng', 300000, '2025-03-27 21:50:13', '2025-03-27 21:50:14');
INSERT INTO `orders` VALUES (37, 2, '2025-03-27 21:55:51', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/19a557d4-04d4-49b3-b1c1-48823ec31c9e', 'Jl Tj seneng', 225000, '2025-03-27 21:55:51', '2025-03-27 21:55:52');
INSERT INTO `orders` VALUES (39, 2, '2025-03-27 22:31:06', 'pickup', 'proses', 'pending', 'https://app.sandbox.midtrans.com/snap/v4/redirection/c008a840-1d15-40de-a98f-7f2a8734e679', 'Jl Tj seneng', 130000, '2025-03-27 22:31:06', '2025-03-27 22:31:06');

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
INSERT INTO `users` VALUES (1, 'admin', 'admin@gmail.com', NULL, 1, '$2y$10$PEE7ThNK4Ami5ealjyJ/WO6aoz.KTD6gvYqPqnBJ/DE54VW98lc/u', '123 Main St', 'z4pNu0jY2cYw7fFqxLirnfty6C947k477QRdjTS4Ik59m6dvzNIcrBvX68jd');
INSERT INTO `users` VALUES (2, 'Fadly Putra 1', 'fadlyputra909@gmail.com', NULL, 0, '$2y$10$FseKE85yoBVDPkeaFtV3aubaMWRiQUKbny21kvU4NY3QiDSSXYjIW', 'Jl Tj seneng', 'ZVlYknSWqPJkrS6b1vhkbeehSmguzUGbXcQbbe03FFrYKNuPuorV9dEDMZ32');
INSERT INTO `users` VALUES (3, 'FADLY PUTRA PRATAMA', 'pandawap364@gmail.com', NULL, 0, '$2y$10$DiRZnU5UAEI3hW/tQbXwS.Hl4TUFADNBRVz6/OvNmsTOA5bv3hx4u', 'jl harapan', NULL);

SET FOREIGN_KEY_CHECKS = 1;
