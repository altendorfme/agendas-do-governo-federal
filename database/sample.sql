/*
 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : agendas-do-gov

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 24/05/2021 13:05:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `schedule_id` int(11) NULL DEFAULT NULL,
  INDEX `date`(`date`) USING BTREE,
  INDEX `schedule`(`schedule_id`) USING BTREE,
  CONSTRAINT `schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for schedule
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
