--
-- MySQL database dump
-- Created by DbManage class, Power By yanue. 
-- http://yanue.net 
--
-- 主机: localhost:3308
-- 生成日期: 2020 年  12 月 31 日 02:21
-- MySQL版本: 8.0.18
-- PHP 版本: 7.3.12

--
-- 数据库: `db_test`
--

-- -------------------------------------------------------

--
-- 表的结构admin
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 admin
--

INSERT INTO `admin` VALUES('1','admin','admin','郑院长','男');
--
-- 表的结构disease
--

DROP TABLE IF EXISTS `disease`;
CREATE TABLE `disease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `doctor_id` int(255) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `doctor_id` (`doctor_id`) USING BTREE,
  CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 disease
--

INSERT INTO `disease` VALUES('1','胸科','支气管炎','1');
INSERT INTO `disease` VALUES('2','胸科','喉咙发炎','1');
INSERT INTO `disease` VALUES('3','外科','擦伤','2');
INSERT INTO `disease` VALUES('4','胸科','肺气肿','2');
INSERT INTO `disease` VALUES('5','胸科','气管炎','2');
INSERT INTO `disease` VALUES('6','耳鼻喉科','鼻炎','1');
INSERT INTO `disease` VALUES('7','骨科','骨折','1');
INSERT INTO `disease` VALUES('8','化验科','高血糖','4');
INSERT INTO `disease` VALUES('9','化验科','高血脂','4');
INSERT INTO `disease` VALUES('10','胸科','肺炎','3');
--
-- 表的结构doctor
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 doctor
--

INSERT INTO `doctor` VALUES('1','doctor1','password','扁鹊医生','女');
INSERT INTO `doctor` VALUES('2','doctor2','password','华佗医生','男');
INSERT INTO `doctor` VALUES('3','doctor3','password','李医生','女');
INSERT INTO `doctor` VALUES('4','doctor4','password','林医生','男');
--
-- 表的结构patien_ward
--

DROP TABLE IF EXISTS `patien_ward`;
CREATE TABLE `patien_ward` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `ward_id` int(11) unsigned NOT NULL,
  `supervisor` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `patient_id` (`patient_id`) USING BTREE,
  KEY `ward_id` (`ward_id`) USING BTREE,
  CONSTRAINT `patien_ward_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `patien_ward_ibfk_2` FOREIGN KEY (`ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 patien_ward
--

INSERT INTO `patien_ward` VALUES('2','2','1','是');
INSERT INTO `patien_ward` VALUES('50','8','5','否');
INSERT INTO `patien_ward` VALUES('51','19','5','否');
INSERT INTO `patien_ward` VALUES('53','6','6','否');
INSERT INTO `patien_ward` VALUES('58','10','6','否');
INSERT INTO `patien_ward` VALUES('66','17','1','是');
--
-- 表的结构patient
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `disease_id` int(10) unsigned NOT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE,
  KEY `disease_id` (`disease_id`) USING BTREE,
  CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`disease_id`) REFERENCES `disease` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 patient
--

INSERT INTO `patient` VALUES('1','888888888','password','艾伦','1','男');
INSERT INTO `patient` VALUES('2','877777777','password','三笠','3','女');
INSERT INTO `patient` VALUES('3','888127137','password','嘉程','1','男');
INSERT INTO `patient` VALUES('4','888127141','password','志荣','1','男');
INSERT INTO `patient` VALUES('5','888127134','password','跃明','1','男');
INSERT INTO `patient` VALUES('6','888127104','password','志航','2','男');
INSERT INTO `patient` VALUES('8','888127119','password','英豪','1','男');
INSERT INTO `patient` VALUES('10','888127132','password','昌裕','3','男');
INSERT INTO `patient` VALUES('11','888127102','password','榕榕','1','女');
INSERT INTO `patient` VALUES('12','888127133','password','榆聪','1','男');
INSERT INTO `patient` VALUES('13','888127103','password','靖涵','3','男');
INSERT INTO `patient` VALUES('14','888127128','password','艳艳','2','女');
INSERT INTO `patient` VALUES('17','888127101','password','思婧','1','女');
INSERT INTO `patient` VALUES('18','888127116','password','晨曦','1','男');
INSERT INTO `patient` VALUES('19','888127121','password','毓铭','3','男');
--
-- 表的结构patient_leave
--

DROP TABLE IF EXISTS `patient_leave`;
CREATE TABLE `patient_leave` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `patient_id` (`patient_id`) USING BTREE,
  CONSTRAINT `patient_leave_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 patient_leave
--

INSERT INTO `patient_leave` VALUES('1','1','2020-12-25 14:00:00','2020-01-31 16:00:00','回家探亲','批准');
INSERT INTO `patient_leave` VALUES('2','1','2020-09-10 11:19:00','2020-10-08 11:19:00','回家探亲','不同意');
INSERT INTO `patient_leave` VALUES('3','2','2019-11-29 00:00:00','2019-11-30 00:00:00','发烧就医','批准');
INSERT INTO `patient_leave` VALUES('4','1','2019-12-26 22:29:00','2019-12-28 22:29:00','搬家，回家帮忙','批准');
INSERT INTO `patient_leave` VALUES('5','17','2019-12-27 14:38:00','2019-12-31 14:38:00','家里有事要回去帮忙','不同意');
INSERT INTO `patient_leave` VALUES('6','17','2019-12-27 15:11:00','2019-12-29 15:11:00','工作原因','');
INSERT INTO `patient_leave` VALUES('7','1','2019-12-27 16:40:00','2019-12-28 16:40:00','特殊情况','批准');
INSERT INTO `patient_leave` VALUES('8','2','2020-12-24 12:23:00','2020-12-26 12:29:00','朋友聚餐','');
--
-- 表的结构patient_need
--

DROP TABLE IF EXISTS `patient_need`;
CREATE TABLE `patient_need` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL,
  `detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `patient_id` (`patient_id`) USING BTREE,
  CONSTRAINT `patient_need_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 patient_need
--

INSERT INTO `patient_need` VALUES('2','2','桶装水没了','2020-12-23 17:01:43','已读');
INSERT INTO `patient_need` VALUES('4','17','想换只手输液','2020-12-23 17:01:43','已读');
INSERT INTO `patient_need` VALUES('5','19','恶心,想吃酸的东西','2020-12-23 17:01:43','已读');
INSERT INTO `patient_need` VALUES('6','2','需要验血,检查白细胞水平','2020-12-23 17:01:43','');
--
-- 表的结构ward
--

DROP TABLE IF EXISTS `ward`;
CREATE TABLE `ward` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `building` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bed` int(2) DEFAULT NULL,
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 ward
--

INSERT INTO `ward` VALUES('1','A','102','4','女');
INSERT INTO `ward` VALUES('2','A','100','4','女');
INSERT INTO `ward` VALUES('3','A','101','4','女');
INSERT INTO `ward` VALUES('4','B','210','4','男');
INSERT INTO `ward` VALUES('5','B','211','4','男');
INSERT INTO `ward` VALUES('6','C','310','6','男');
INSERT INTO `ward` VALUES('7','C','301','6','女');
INSERT INTO `ward` VALUES('8','C','302','6','女');
INSERT INTO `ward` VALUES('9','B','202','4','男');
INSERT INTO `ward` VALUES('10','B','201','4','男');
--
-- 表的结构ward_exchange
--

DROP TABLE IF EXISTS `ward_exchange`;
CREATE TABLE `ward_exchange` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(10) unsigned NOT NULL,
  `to_ward_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `admin_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `doctor_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `patient_id` (`patient_id`) USING BTREE,
  KEY `to_ward_id` (`to_ward_id`) USING BTREE,
  CONSTRAINT `ward_exchange_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `ward_exchange_ibfk_2` FOREIGN KEY (`to_ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 ward_exchange
--

INSERT INTO `ward_exchange` VALUES('1','1','3','2020-12-23 17:01:44','行政调换','行吧OK！','同意');
INSERT INTO `ward_exchange` VALUES('2','1','5','2020-12-23 17:01:44','想和朋友去一个病房','同意','不同意');
INSERT INTO `ward_exchange` VALUES('3','17','7','2020-12-23 17:01:44','申请入住','同意','同意');
INSERT INTO `ward_exchange` VALUES('4','17','8','2020-12-23 17:01:44','申请入住','该病房还在装修','不同意');
INSERT INTO `ward_exchange` VALUES('5','1','10','2020-12-23 17:01:44','想和老乡一个病房','同意','同意');
INSERT INTO `ward_exchange` VALUES('6','1','5','2020-12-23 17:01:44','想去211','同意','同意');
INSERT INTO `ward_exchange` VALUES('7','2','8','2020-12-23 17:01:44','病友太吵闹','','');
--
-- 表的结构ward_maintain
--

DROP TABLE IF EXISTS `ward_maintain`;
CREATE TABLE `ward_maintain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ward_id` int(10) unsigned NOT NULL,
  `request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `admin_response` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `ward_id` (`ward_id`) USING BTREE,
  CONSTRAINT `ward_maintain_ibfk_1` FOREIGN KEY (`ward_id`) REFERENCES `ward` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 ward_maintain
--

INSERT INTO `ward_maintain` VALUES('1','1','水龙头漏水','已修复','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('2','4','室内日光灯故障','已换新的日光灯','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('3','6','门锁故障','已修复！','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('4','2','空调异响','已联系厂家维修','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('5','1','厕所堵塞','已维修','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('6','4','插座没电','已修复，请安全用电','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('7','4','饮水机故障','即将派人维修','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('8','10','台灯损坏','等待后勤维修...','2020-12-23 17:01:45');
INSERT INTO `ward_maintain` VALUES('9','1','开关损坏','','2020-12-23 17:01:45');
