/*
 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : agendas-do-gov

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 21/05/2021 15:04:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for daily
-- ----------------------------
DROP TABLE IF EXISTS `daily`;
CREATE TABLE `daily`  (
  `date` date NULL DEFAULT NULL,
  `week_day` int(1) NULL DEFAULT NULL,
  `interval` int(4) NULL DEFAULT NULL,
  `appointment_id` int(11) NULL DEFAULT NULL,
  INDEX `appointment_id`(`appointment_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events`  (
  `date` date NULL DEFAULT NULL,
  `week_day` int(1) NULL DEFAULT NULL,
  `hour_start` time(0) NULL DEFAULT NULL,
  `hour_end` time(0) NULL DEFAULT NULL,
  `interval` int(4) NULL DEFAULT NULL,
  `title` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `place` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `appointment_id` int(11) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
