/*
 Navicat Premium Data Transfer

 Source Server         : wam
 Source Server Type    : MySQL
 Source Server Version : 50711
 Source Host           : localhost:3308
 Source Schema         : db_ward

 Target Server Type    : MySQL
 Target Server Version : 50711
 File Encoding         : 65001

 Date: 31/12/2019 20:23:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
 
-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'admin', 'admin', '郑院长', '男');

-- ----------------------------
-- Table structure for disease
-- ----------------------------
DROP TABLE IF EXISTS `disease`;
CREATE TABLE `disease`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `department` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `doctor_id` int(255) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE,
  INDEX `doctor_id`(`doctor_id`) USING BTREE,
  CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of disease
-- ----------------------------
INSERT INTO `disease` VALUES (1, '呼吸科', '支气管炎', 1);
INSERT INTO `disease` VALUES (2, '胸科', '喉咙发炎', 1);
INSERT INTO `disease` VALUES (3, '外科', '擦伤', 2);

-- ----------------------------
-- Table structure for ward
-- ----------------------------
DROP TABLE IF EXISTS `ward`;
CREATE TABLE `ward`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `building` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bed` int(2) NULL DEFAULT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ward
-- ----------------------------
INSERT INTO `ward` VALUES (1, 'A', '102', 4, '女');
INSERT INTO `ward` VALUES (2, 'A', '100', 4, '女');
INSERT INTO `ward` VALUES (3, 'A', '101', 4, '女');
INSERT INTO `ward` VALUES (4, 'B', '210', 4, '男');
INSERT INTO `ward` VALUES (5, 'B', '211', 4, '男');
INSERT INTO `ward` VALUES (6, 'C', '310', 6, '男');
INSERT INTO `ward` VALUES (7, 'C', '301', 6, '女');
INSERT INTO `ward` VALUES (8, 'C', '302', 6, '女');
INSERT INTO `ward` VALUES (9, 'B', '202', 4, '男');
INSERT INTO `ward` VALUES (10, 'B', '201', 4, '男');

-- ----------------------------
-- Table structure for ward_maintain
-- ----------------------------
DROP TABLE IF EXISTS `ward_maintain`;
CREATE TABLE `ward_maintain`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ward_id` int(10) UNSIGNED NOT NULL,
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `admin_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ward_id`(`ward_id`) USING BTREE,
  CONSTRAINT `ward_maintain_ibfk_1` FOREIGN KEY (`ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ward_maintain
-- ----------------------------
INSERT INTO `ward_maintain` VALUES (1, 1, '水龙头漏水', '已修复', '2019-12-25 23:11:57');
INSERT INTO `ward_maintain` VALUES (2, 4, '室内日光灯故障', '已换新的日光灯', '2019-12-25 23:13:15');
INSERT INTO `ward_maintain` VALUES (3, 6, '门锁故障', '已修复！', '2019-12-26 14:57:26');
INSERT INTO `ward_maintain` VALUES (4, 2, '空调异响', '已联系厂家维修', '2019-12-25 23:14:26');
INSERT INTO `ward_maintain` VALUES (5, 1, '厕所堵塞', '已维修', '2019-12-25 22:15:19');
INSERT INTO `ward_maintain` VALUES (6, 4, '插座没电', '已修复，请安全用电', '2019-12-26 15:31:23');
INSERT INTO `ward_maintain` VALUES (7, 4, '日光灯接触不良', NULL, '2019-12-26 15:29:09');
INSERT INTO `ward_maintain` VALUES (8, 10, '台灯损坏', 'yixiufu', '2019-12-26 16:38:57');

-- ----------------------------
-- Table structure for patient
-- ----------------------------
DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `disease_id` int(10) UNSIGNED NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account`) USING BTREE,
  INDEX `disease_id`(`disease_id`) USING BTREE,
  CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`disease_id`) REFERENCES `disease` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patient
-- ----------------------------
INSERT INTO `patient` VALUES (1, '888888888', 'password', '艾伦', 1, '男');
INSERT INTO `patient` VALUES (2, '888127211', 'password', '三笠', 3, '女');
INSERT INTO `patient` VALUES (3, '888127137', 'password', '嘉程', 1, '男');
INSERT INTO `patient` VALUES (4, '888127141', 'password', '志荣', 1, '男');
INSERT INTO `patient` VALUES (5, '888127134', 'password', '跃明', 1, '男');
INSERT INTO `patient` VALUES (6, '888127104', 'password', '志航', 2, '男');
INSERT INTO `patient` VALUES (8, '888127119', 'password', '英豪', 1, '男');
INSERT INTO `patient` VALUES (10, '888127132', 'password', '昌裕', 3, '男');
INSERT INTO `patient` VALUES (11, '888127102', 'password', '榕榕', 1, '女');
INSERT INTO `patient` VALUES (12, '888127133', 'password', '榆聪', 1, '男');
INSERT INTO `patient` VALUES (13, '888127103', 'password', '靖涵', 3, '男');
INSERT INTO `patient` VALUES (14, '888127128', 'password', '艳艳', 2, '女');
INSERT INTO `patient` VALUES (17, '888127101', 'password', '思婧', 1, '女');
INSERT INTO `patient` VALUES (18, '888127116', 'password', '晨曦', 1, '男');
INSERT INTO `patient` VALUES (19, '888127121', 'password', '毓铭', 3, '男');

-- ----------------------------
-- Table structure for patien_ward
-- ----------------------------
DROP TABLE IF EXISTS `patien_ward`;
CREATE TABLE `patien_ward`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) UNSIGNED NOT NULL,
  `ward_id` int(11) UNSIGNED NOT NULL,
  `supervisor` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `patient_id`(`patient_id`) USING BTREE,
  INDEX `ward_id`(`ward_id`) USING BTREE,
  CONSTRAINT `patien_ward_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `patien_ward_ibfk_2` FOREIGN KEY (`ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patien_ward
-- ----------------------------
INSERT INTO `patien_ward` VALUES (2, 2, 1, '否');
INSERT INTO `patien_ward` VALUES (50, 8, 5, '否');
INSERT INTO `patien_ward` VALUES (51, 19, 5, '否');
INSERT INTO `patien_ward` VALUES (53, 6, 6, '否');
INSERT INTO `patien_ward` VALUES (58, 10, 6, '否');
INSERT INTO `patien_ward` VALUES (66, 17, 1, '否');

-- ----------------------------
-- Table structure for ward_exchange
-- ----------------------------
DROP TABLE IF EXISTS `ward_exchange`;
CREATE TABLE `ward_exchange`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `to_ward_id` int(10) UNSIGNED NOT NULL,
  `date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `admin_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `patient_id`(`patient_id`) USING BTREE,
  INDEX `to_ward_id`(`to_ward_id`) USING BTREE,
  CONSTRAINT `ward_exchange_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ward_exchange_ibfk_2` FOREIGN KEY (`to_ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ward_exchange
-- ----------------------------
INSERT INTO `ward_exchange` VALUES (1, 1, 3, '2019-12-25 22:23:00', '行政调换', '行吧OK！', '同意');
INSERT INTO `ward_exchange` VALUES (2, 1, 5, '2019-12-25 23:16:19', '想和朋友去一个病房', '同意', '不同意');
INSERT INTO `ward_exchange` VALUES (3, 17, 7, '2019-12-26 14:57:37', '申请入住', '同意', '同意');
INSERT INTO `ward_exchange` VALUES (4, 17, 8, '2019-12-26 15:33:48', '申请入住', '该病房还在装修', '不同意');
INSERT INTO `ward_exchange` VALUES (5, 1, 10, '2019-12-26 15:35:38', '想和老乡一个病房', '同意', '同意');
INSERT INTO `ward_exchange` VALUES (6, 1, 5, '2019-12-26 16:44:08', '想去211', '同意', NULL);

-- ----------------------------
-- Table structure for patient_leave
-- ----------------------------
DROP TABLE IF EXISTS `patient_leave`;
CREATE TABLE `patient_leave`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `date_start` datetime(0) NOT NULL,
  `date_end` datetime(0) NOT NULL,
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `patient_id`(`patient_id`) USING BTREE,
  CONSTRAINT `patient_leave_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patient_leave
-- ----------------------------
INSERT INTO `patient_leave` VALUES (1, 1, '2019-12-11 14:00:00', '2019-12-05 16:00:00', '回家探亲', '批准');
INSERT INTO `patient_leave` VALUES (2, 1, '2019-12-04 11:19:00', '2020-01-23 11:19:00', '回家探亲', '不同意');
INSERT INTO `patient_leave` VALUES (3, 2, '2019-11-29 00:00:00', '2019-11-30 00:00:00', '发烧就医', '批准');
INSERT INTO `patient_leave` VALUES (4, 1, '2019-12-26 22:29:00', '2019-12-28 22:29:00', '搬家，回家帮忙', '批准');
INSERT INTO `patient_leave` VALUES (5, 17, '2019-12-27 14:38:00', '2019-12-31 14:38:00', '家里有事要回去帮忙', '不同意');
INSERT INTO `patient_leave` VALUES (6, 17, '2019-12-27 15:11:00', '2019-12-29 15:11:00', '工作原因', NULL);
INSERT INTO `patient_leave` VALUES (7, 1, '2019-12-27 16:40:00', '2019-12-28 16:40:00', '特殊情况', '批准');

-- ----------------------------
-- Table structure for patient_need
-- ----------------------------
DROP TABLE IF EXISTS `patient_need`;
CREATE TABLE `patient_need`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `patient_id`(`patient_id`) USING BTREE,
  CONSTRAINT `patient_need_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patient_need
-- ----------------------------
INSERT INTO `patient_need` VALUES (1, 1, '使用电磁炉', '2019-12-24 15:26:23', '已读');
INSERT INTO `patient_need` VALUES (2, 2, '私搭电线', '2019-12-25 22:36:31', '已读');
INSERT INTO `patient_need` VALUES (4, 17, '在病房养宠物狗', '2019-12-26 14:59:58', '已读');
INSERT INTO `patient_need` VALUES (5, 19, '吸烟违规', '2019-12-26 16:48:58', '已读');

-- ----------------------------
-- Table structure for doctor
-- ----------------------------
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`account`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doctor
-- ----------------------------
INSERT INTO `doctor` VALUES (1, '12345', 'password', '扁鹊医生', '女');
INSERT INTO `doctor` VALUES (2, '11111', 'password', '华佗医生', '男');

SET FOREIGN_KEY_CHECKS = 1;
