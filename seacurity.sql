/*
Navicat MySQL Data Transfer

Source Server         : hebeit
Source Server Version : 50173
Source Host           : 101.132.166.57:3306
Source Database       : security

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2017-12-19 14:37:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sc_admin_info
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin_info`;
CREATE TABLE `sc_admin_info` (
`info_id`  int(11) NOT NULL AUTO_INCREMENT ,
`admin_id`  int(11) NOT NULL DEFAULT 0 ,
`scan_times_count`  int(11) NULL DEFAULT NULL COMMENT '扫描次数' ,
`admin_url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网址' ,
`contact_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系人名字' ,
`address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系地址' ,
`contact_mobile`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系人手机号' ,
`company_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '单位名称' ,
`position`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '职位' ,
`department`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '部门' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`info_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=39

;

-- ----------------------------
-- Records of sc_admin_info
-- ----------------------------
BEGIN;
INSERT INTO `sc_admin_info` VALUES ('1', '1', '391', '#', null, null, null, '管理员', '', '', null, '2017-11-16 16:50:41', null), ('2', '2', null, null, 'ceshi', null, '13111111111', 'ceshi', 'ceshi', 'ceshi', '2017-12-09 15:03:30', '2017-12-09 15:03:30', null), ('3', '3', null, null, '测试运维', null, '13111111111', '测试运维', '测试运维', '测试运维', '2017-12-09 15:04:16', '2017-12-09 15:04:16', null), ('4', '4', '0', null, '测试业主', null, '1311111111', '测试业主', '测试业主', '测试业主', '2017-12-09 15:07:34', '2017-12-11 13:22:17', null);
COMMIT;

-- ----------------------------
-- Table structure for sc_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin_log`;
CREATE TABLE `sc_admin_log` (
`log_id`  int(10) NOT NULL AUTO_INCREMENT COMMENT '后台操作日志记录id' ,
`admin_name`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员名称' ,
`admin_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员id' ,
`operate_target`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作模块' ,
`operate_ip`  varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作ip' ,
`operate_content`  longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '日志记录内容（不能记录sql）' ,
`operate_time`  datetime NULL DEFAULT NULL COMMENT '操作时间' ,
`operate_status`  tinyint(1) NOT NULL COMMENT '操作状态：1成功，2失败' ,
`remark`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '备注' ,
PRIMARY KEY (`log_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='后台操作日志表'
AUTO_INCREMENT=18906

;

-- ----------------------------
-- Records of sc_admin_log
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_admin_record
-- ----------------------------
DROP TABLE IF EXISTS `sc_admin_record`;
CREATE TABLE `sc_admin_record` (
`record_id`  int(11) NOT NULL AUTO_INCREMENT ,
`record_ip`  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '登录ip' ,
`admin_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陸賬號' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`record_status`  int(1) NOT NULL COMMENT '1 登录成功  2登录失败  ' ,
PRIMARY KEY (`record_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=530

;

-- ----------------------------
-- Records of sc_admin_record
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_admins
-- ----------------------------
DROP TABLE IF EXISTS `sc_admins`;
CREATE TABLE `sc_admins` (
`admin_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`admin_name`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '账号' ,
`admin_nick`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '昵称' ,
`admin_sex`  tinyint(1) NULL DEFAULT 1 COMMENT '性别（-1保密，1男，0.女）' ,
`admin_password`  varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码' ,
`admin_birthday`  date NULL DEFAULT NULL COMMENT '生日' ,
`admin_mobile`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '手机' ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`is_super`  tinyint(1) NULL DEFAULT 0 COMMENT '是否超级管理员（0否，1是）' ,
`province`  varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '省' ,
`city`  varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '市' ,
`district`  varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '区' ,
`address`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '详细地址' ,
`login_ip`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '最后登录ip' ,
`login_at`  timestamp NULL DEFAULT NULL COMMENT '最后登录时间' ,
`is_first`  tinyint(4) NULL DEFAULT 0 COMMENT '是否第一次登录|修改过密码 0 未登录|未修改 1 已修改' ,
`remark`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '备注' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`admin_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='管理员表'
AUTO_INCREMENT=41

;

-- ----------------------------
-- Records of sc_admins
-- ----------------------------
BEGIN;
INSERT INTO `sc_admins` VALUES ('1', 'Security', '管理员', '1', '$2y$10$QawGBmx0EjUHp4dGZatcqO6Sc.5BfkzrScOvFQQNORQDex44DLNLq', null, '', null, '1', '', '', '', '', '', null, '1', '', '2017-07-25 17:11:30', '2017-12-11 10:28:29', null), ('2', 'policetest', '测试民警', '1', '$2y$10$KxDe4I9HXb7H9F2TwNJI0uavStKz.V0BTL9Us9QdbgUp46MP7/X3K', null, '', null, '0', '', '', '', '', '', null, '1', '', '2017-12-09 15:03:30', '2017-12-09 15:38:33', null), ('3', 'editceshi', '测试运维', '1', '$2y$10$aj8SElpEVQrGhLH0EJe2delLIxz8h4NCaqXYuZgaXMaDojQjPLjU6', null, '', null, '0', '', '', '', '', '', null, '1', '', '2017-12-09 15:04:16', '2017-12-09 15:32:47', null), ('4', 'ceshiowner', '测试业主', '1', '$2y$10$YVpW42f6HEJczea4zubqv.Rccy00AKlkNZ8JQhgjvRtcydLj6w92e', null, '', null, '0', '', '', '', '', '', null, '1', '', '2017-12-09 15:07:34', '2017-12-09 15:40:23', null);
COMMIT;

-- ----------------------------
-- Table structure for sc_encrypt_token
-- ----------------------------
DROP TABLE IF EXISTS `sc_encrypt_token`;
CREATE TABLE `sc_encrypt_token` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '项目名' ,
`token`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'token值' ,
`publickey_path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '公钥路径' ,
`is_used`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否适用' ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='RSA加密、解密秘钥'
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of sc_encrypt_token
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_inmail
-- ----------------------------
DROP TABLE IF EXISTS `sc_inmail`;
CREATE TABLE `sc_inmail` (
`inmail_id`  int(11) NOT NULL AUTO_INCREMENT ,
`inmail_title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '主题' ,
`inmail_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '站内信内容' ,
`sender_id`  int(11) NOT NULL COMMENT '发件人id(创建人)' ,
`receiver_id`  int(11) NOT NULL COMMENT '收件人ID' ,
`status_at`  timestamp NULL DEFAULT NULL COMMENT '(读取时间 当状态从未读到已读)' ,
`status`  tinyint(1) NULL DEFAULT 0 COMMENT '发送状态（是否已经读取 0未读 1已读 ）' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`inmail_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=358

;

-- ----------------------------
-- Records of sc_inmail
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_migrations
-- ----------------------------
DROP TABLE IF EXISTS `sc_migrations`;
CREATE TABLE `sc_migrations` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`migration`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`batch`  int(11) NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of sc_migrations
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_notices
-- ----------------------------
DROP TABLE IF EXISTS `sc_notices`;
CREATE TABLE `sc_notices` (
`notice_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`notice_title`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '标题' ,
`notice_content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容' ,
`desc`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '警告描述' ,
`admin_id`  int(11) NOT NULL DEFAULT 0 COMMENT '操作者ID' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`notice_id`),
UNIQUE INDEX `notice_id` USING BTREE (`notice_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=33

;

-- ----------------------------
-- Records of sc_notices
-- ----------------------------
BEGIN;
INSERT INTO `sc_notices` VALUES ('28', 'ceshi', 'ceshi', null, '1', '2017-12-11 20:46:00', '2017-12-11 20:46:00', null), ('29', 'ceshi02', '<p>werwerwer</p>', 'ceshi', '1', '2017-12-11 20:49:40', '2017-12-12 11:28:57', null), ('30', 'ceshi345345', '<p><img src=\"http://hmfilesa.d.youjiadv.com/files/1513049204/h_line.png\"></p>', 'ceshi', '1', '2017-12-12 09:53:11', '2017-12-12 11:31:21', null), ('31', 'ceshi0012', '<p><img src=\"http://hmfilesa.d.youjiadv.com/files/1513049187/bar_border.png\"></p>', 'ceshi', '1', '2017-12-12 11:06:44', '2017-12-12 11:31:26', null), ('32', 'ceshiserrtet', '<p><img src=\"http://hmfilesa.d.youjiadv.com/files/1513049551/h_line.png\"></p>', 'ceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshiceshi', '1', '2017-12-12 11:32:36', '2017-12-12 11:32:46', null);
COMMIT;

-- ----------------------------
-- Table structure for sc_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `sc_permission_role`;
CREATE TABLE `sc_permission_role` (
`permission_id`  int(10) UNSIGNED NOT NULL ,
`role_id`  int(10) UNSIGNED NOT NULL ,
PRIMARY KEY (`permission_id`, `role_id`),
FOREIGN KEY (`permission_id`) REFERENCES `sc_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (`role_id`) REFERENCES `sc_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `permission_role_role_id_foreign` USING BTREE (`role_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of sc_permission_role
-- ----------------------------
BEGIN;
INSERT INTO `sc_permission_role` VALUES ('1', '1'), ('3', '1'), ('4', '1'), ('5', '1'), ('6', '1'), ('7', '1'), ('8', '1'), ('9', '1'), ('10', '1'), ('11', '1'), ('15', '1'), ('16', '1'), ('17', '1'), ('18', '1'), ('19', '1'), ('22', '1'), ('23', '1'), ('24', '1'), ('25', '1'), ('26', '1'), ('27', '1'), ('28', '1'), ('29', '1'), ('33', '1'), ('34', '1'), ('35', '1'), ('36', '1'), ('37', '1'), ('38', '1'), ('39', '1'), ('41', '1'), ('44', '1'), ('45', '1'), ('46', '1'), ('47', '1'), ('48', '1'), ('49', '1'), ('50', '1'), ('51', '1'), ('52', '1'), ('53', '1'), ('54', '1'), ('56', '1'), ('57', '1'), ('58', '1'), ('60', '1'), ('61', '1'), ('62', '1'), ('63', '1'), ('64', '1'), ('65', '1'), ('66', '1'), ('67', '1'), ('68', '1'), ('70', '1'), ('71', '1'), ('72', '1'), ('74', '1'), ('75', '1'), ('76', '1'), ('82', '1'), ('83', '1'), ('84', '1'), ('85', '1'), ('86', '1'), ('87', '1'), ('88', '1'), ('89', '1'), ('90', '1'), ('91', '1'), ('97', '1'), ('99', '1'), ('100', '1'), ('101', '1'), ('108', '1'), ('109', '1'), ('110', '1'), ('111', '1'), ('112', '1'), ('125', '1'), ('126', '1'), ('1', '2'), ('3', '2'), ('4', '2'), ('5', '2'), ('6', '2'), ('7', '2'), ('8', '2'), ('11', '2'), ('12', '2'), ('15', '2'), ('16', '2'), ('17', '2'), ('18', '2'), ('19', '2'), ('23', '2'), ('24', '2'), ('25', '2'), ('26', '2'), ('27', '2');
INSERT INTO `sc_permission_role` VALUES ('28', '2'), ('29', '2'), ('35', '2'), ('36', '2'), ('37', '2'), ('38', '2'), ('39', '2'), ('41', '2'), ('44', '2'), ('45', '2'), ('46', '2'), ('47', '2'), ('48', '2'), ('49', '2'), ('50', '2'), ('51', '2'), ('52', '2'), ('53', '2'), ('54', '2'), ('56', '2'), ('67', '2'), ('68', '2'), ('70', '2'), ('82', '2'), ('83', '2'), ('84', '2'), ('85', '2'), ('86', '2'), ('87', '2'), ('88', '2'), ('89', '2'), ('90', '2'), ('91', '2'), ('97', '2'), ('99', '2'), ('100', '2'), ('101', '2'), ('103', '2'), ('107', '2'), ('109', '2'), ('110', '2'), ('111', '2'), ('112', '2'), ('113', '2'), ('114', '2'), ('115', '2'), ('116', '2'), ('119', '2'), ('120', '2'), ('121', '2'), ('122', '2'), ('123', '2'), ('126', '2'), ('7', '3'), ('8', '3'), ('9', '3'), ('10', '3'), ('19', '3'), ('22', '3'), ('28', '3'), ('29', '3'), ('35', '3'), ('36', '3'), ('37', '3'), ('38', '3'), ('39', '3'), ('41', '3'), ('44', '3'), ('52', '3'), ('53', '3'), ('54', '3'), ('56', '3'), ('64', '3'), ('65', '3'), ('66', '3'), ('67', '3'), ('68', '3'), ('70', '3'), ('85', '3'), ('88', '3'), ('89', '3'), ('91', '3'), ('97', '3'), ('99', '3'), ('100', '3'), ('106', '3'), ('109', '3'), ('110', '3'), ('111', '3'), ('112', '3'), ('113', '3'), ('114', '3'), ('115', '3'), ('116', '3'), ('117', '3'), ('126', '3'), ('5', '4'), ('6', '4'), ('7', '4'), ('8', '4');
INSERT INTO `sc_permission_role` VALUES ('11', '4'), ('15', '4'), ('16', '4'), ('17', '4'), ('18', '4'), ('19', '4'), ('24', '4'), ('25', '4'), ('26', '4'), ('27', '4'), ('28', '4'), ('29', '4'), ('36', '4'), ('37', '4'), ('38', '4'), ('39', '4'), ('41', '4'), ('44', '4'), ('45', '4'), ('47', '4'), ('70', '4'), ('85', '4'), ('86', '4'), ('91', '4'), ('101', '4'), ('103', '4'), ('119', '4'), ('120', '4'), ('121', '4'), ('122', '4'), ('123', '4'), ('124', '4');
COMMIT;

-- ----------------------------
-- Table structure for sc_permissions
-- ----------------------------
DROP TABLE IF EXISTS `sc_permissions`;
CREATE TABLE `sc_permissions` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`display_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`pid`  int(10) NULL DEFAULT 0 COMMENT '父级ID' ,
`level`  tinyint(1) NULL DEFAULT 1 COMMENT '栏目所属层级' ,
`path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '页面url' ,
`show`  tinyint(1) NULL DEFAULT 0 COMMENT '是否显示 0 不显示 1显示' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `permissions_name_unique` USING BTREE (`name`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=127

;

-- ----------------------------
-- Records of sc_permissions
-- ----------------------------
BEGIN;
INSERT INTO `sc_permissions` VALUES ('1', 'onDuty', '值班概述', '值班概述', '0', '1', '/onDuty', '1', '2017-11-01 10:42:14', '2017-11-21 10:18:10'), ('3', 'schedule', '值班信息', '值班信息', '1', '2', '', '1', '2017-11-01 10:44:16', '2017-11-01 10:44:16'), ('4', 'scheduleEdit', '值班编辑', '值班编辑', '3', '3', '', '1', '2017-11-01 10:44:58', '2017-11-01 10:44:58'), ('5', 'owner', '业主情况', '业主情况', '0', '1', '/owner', '1', '2017-11-01 10:46:50', '2017-11-01 10:51:34'), ('6', 'todo', '待办事务', '待办事务', '0', '1', '/todo', '1', '2017-11-01 10:52:41', '2017-11-06 18:31:57'), ('7', 'file', '文档流转', '文档流转', '0', '1', '/file', '1', '2017-11-01 10:53:09', '2017-12-11 14:29:59'), ('8', 'network', '网络预警', '网络预警', '0', '1', '/network', '1', '2017-11-01 11:01:21', '2017-11-01 11:01:21'), ('9', 'log', '日志管理', '日志管理', '0', '1', '/log', '1', '2017-11-01 11:02:15', '2017-11-01 11:02:15'), ('10', 'rbac', '权限管理', '权限管理', '0', '1', '/rbac', '1', '2017-11-01 11:03:43', '2017-11-01 11:03:43'), ('11', 'clientInfo', '业主概述', '业主概述', '5', '2', '/owner/overview', '1', '2017-11-01 11:04:59', '2017-11-06 17:58:24'), ('12', 'clientInfoCount', '业主统计', '业主统计', '5', '2', '/owner/statistics', '0', '2017-11-01 11:10:07', '2017-12-07 13:04:16'), ('15', 'clientInfoList', '业主概述列表', '业主概述列表', '11', '3', '', '1', '2017-11-06 17:58:43', '2017-11-06 18:34:17'), ('16', 'affair', '事务列表', '事务列表', '6', '2', '/todo/list', '1', '2017-11-01 11:23:23', '2017-11-06 17:40:04'), ('17', 'affairAll', '全部事务', '全部事务', '16', '3', '', '1', '2017-11-01 11:25:38', '2017-12-08 16:35:37'), ('18', 'overReport', '已完成事务', '已完成事务', '16', '3', '', '1', '2017-11-06 18:30:33', '2017-11-30 15:43:19'), ('19', 'unfinishedAll', '未完成事务', '未完成事务', '125', '2', '', '1', '2017-11-06 18:32:36', '2017-11-29 18:32:34'), ('22', 'reportAdd', '添加公文', '添加公文', '88', '3', '/file/All', '1', '2017-11-01 11:30:25', '2017-11-01 11:30:25'), ('23', 'reportEdit', '编辑公文', '编辑公文', '45', '3', '/file/Fail', '1', '2017-11-01 11:31:31', '2017-11-01 11:31:31'), ('24', 'reportList', '公文列表', '传输成功公文', '45', '3', '/file/Passed', '1', '2017-11-01 11:32:01', '2017-11-01 11:32:01'), ('25', 'reportDetail', '公文详情', '某一报告详细信息 + 回执', '45', '3', '', '1', '2017-11-01 11:32:48', '2017-11-01 11:32:48'), ('26', 'receiptAdd', '回执添加', '回执添加', '45', '3', '', '1', '2017-11-01 11:33:29', '2017-11-01 11:33:29'), ('27', 'receiptEdit', '回执编辑', '回执编辑', '45', '3', '', '1', '2017-11-01 11:33:47', '2017-11-01 11:33:47'), ('28', 'noticeNew', '最新预警', '最新预警', '8', '2', '/network/new', '1', '2017-11-01 11:37:54', '2017-11-07 11:50:07'), ('29', 'networkPast', '往期预警', '往期预警', '8', '2', '/network/past', '1', '2017-11-01 11:38:25', '2017-11-07 10:59:12'), ('33', 'permission', '权限管理', '权限管理', '10', '2', '/rbac/permission', '1', '2017-11-01 11:42:37', '2017-11-07 11:47:42'), ('34', 'role', '角色管理', '角色管理', '10', '2', '/rbac/role', '1', '2017-11-01 11:43:19', '2017-11-07 11:47:56'), ('35', 'admin', '用户管理', '用户管理', '0', '1', '/users', '1', '2017-11-01 11:44:44', '2017-12-11 20:20:25'), ('36', 'mail', '站内信管理', '站内信', '0', '1', '', '0', '2017-11-03 13:56:33', '2017-11-07 10:11:16'), ('37', 'inmail', '站内信', '站内信信息', '36', '2', '', '1', '2017-11-08 10:29:13', '2017-11-07 13:18:40'), ('38', 'inmailList', '站内信列表', '站内信列表', '37', '3', '', '1', '2017-11-03 13:57:03', '2017-11-03 13:57:03'), ('39', 'inmailAdd', '发送站内信', '发送站内信', '37', '3', '', '1', '2017-11-03 13:58:18', '2017-11-03 13:58:18'), ('41', 'inmailDelete', '删除站内信', '删除站内信', '37', '3', '', '1', '2017-11-03 13:58:40', '2017-11-03 13:58:40'), ('44', 'inmailDetail', '信息详情查看', '站内信信息详情', '37', '3', '', '1', '2017-11-03 14:00:02', '2017-11-08 11:28:16'), ('45', 'report', '文档管理', '公文回执控制器', '7', '2', '/file/all', '1', '2017-11-03 15:02:36', '2017-12-11 20:07:02'), ('46', 'scheduleAdd', '班次批量添加', '批量的班次添加-附带排班初始化', '3', '3', '', '1', '2017-11-03 15:01:17', '2017-11-07 09:26:39'), ('47', 'downloadRecord', '下载记录', '下载记录', '45', '3', '', '1', '2017-11-03 15:33:34', '2017-11-03 15:33:41'), ('48', 'reportSuccess', '审核通过', '审核通过', '45', '3', '', '1', '2017-11-03 15:36:12', '2017-11-03 15:36:15'), ('49', 'scheduleWeekList', '周排班信息', '一周排班的信息', '3', '3', '', '1', '2017-11-03 16:08:55', '2017-11-03 16:08:55'), ('50', 'scheduleDetail', '班次详情', '班次详情', '3', '3', '', '1', '2017-11-03 16:09:47', '2017-11-03 16:09:47'), ('51', 'scheduleNow', '当前值班者', '当前时间值班人员信息', '3', '3', '', '1', '2017-11-03 16:10:34', '2017-11-07 09:24:39'), ('52', 'adminList', '用户列表', '用户列表', '126', '3', '', '1', '2017-11-06 13:50:22', '2017-11-06 13:50:57'), ('53', 'adminAdd', '用户添加', '用户添加', '126', '3', '', '1', '2017-11-06 13:50:46', '2017-11-06 13:50:46'), ('54', 'adminEdit', '用户编辑', '用户编辑', '126', '3', '', '1', '2017-11-06 13:51:34', '2017-11-06 13:51:34'), ('56', 'adminDetail', '用户详情', '用户详情', '126', '3', '', '1', '2017-11-06 13:58:37', '2017-11-06 13:58:37'), ('57', 'roleAdd', '角色添加', '角色添加', '34', '3', '', '1', '2017-11-06 14:00:13', '2017-11-06 14:00:13'), ('58', 'roleEdit', '角色编辑', '角色编辑', '34', '3', '', '1', '2017-11-06 14:00:37', '2017-11-06 14:00:37'), ('60', 'roleList', '角色列表', '角色列表', '34', '3', '', '1', '2017-11-06 14:01:09', '2017-11-06 14:01:09'), ('61', 'roleDetail', '角色详细', '角色详细', '34', '3', '', '1', '2017-11-06 14:01:23', '2017-11-06 14:01:23'), ('62', 'permissionList', '权限列表', '权限列表', '33', '3', '', '1', '2017-11-06 14:07:17', '2017-11-06 14:07:17'), ('63', 'permissionDetail', '权限详细', '权限详细', '33', '3', '', '1', '2017-11-06 14:07:33', '2017-11-06 14:07:33'), ('64', 'logAll', '日志信息', '日志信息', '9', '2', '/log/log', '1', '2017-11-06 15:14:24', '2017-11-06 15:14:24'), ('65', 'logList', '日志列表', '日志列表', '64', '3', '', '1', '2017-11-06 15:15:08', '2017-11-06 15:15:08'), ('66', 'logDetail', '日志详情', '日志详情', '64', '3', '', '1', '2017-11-06 15:15:39', '2017-11-06 15:15:39'), ('67', 'noticeAdd', '添加预警', '添加预警', '29', '3', '', '1', '2017-11-06 15:18:17', '2017-11-06 15:18:17'), ('68', 'noticeEdit', '编辑预警', '编辑预警', '29', '3', '', '1', '2017-11-06 15:20:54', '2017-11-06 15:20:54'), ('70', 'noticeDetail', '查看预警详情', '查看预警详情', '29', '3', '', '1', '2017-11-06 15:21:47', '2017-11-06 15:22:00'), ('71', 'permissionAdd', '权限添加', '权限添加', '33', '3', '', '1', '2017-11-06 15:31:27', '2017-11-06 15:31:27'), ('72', 'permissionEdit', '权限编辑', '权限编辑', '33', '3', '', '1', '2017-11-06 15:31:49', '2017-11-06 15:31:49'), ('74', 'permissionRoleList', '角色权限列表', '角色权限列表', '33', '3', '', '1', '2017-11-06 16:07:49', '2017-11-06 16:07:49'), ('75', 'permissionRoleAdd', '角色权限添加', '角色权限添加', '33', '3', '', '1', '2017-11-06 16:08:08', '2017-11-06 16:08:08'), ('76', 'permissionRoleDetail', '角色权限详细', '角色权限详细', '33', '3', '', '1', '2017-11-06 16:08:29', '2017-11-06 16:08:29'), ('82', 'weekScheduleAdd', '排班初始化', '初始化某一周排班', '3', '3', '', '1', '2017-11-07 09:22:19', '2017-11-07 09:22:19'), ('83', 'scheduleList', '总排班信息', '总排班信息列表', '3', '3', '', '1', '2017-11-07 09:24:02', '2017-11-07 09:24:02'), ('84', 'scheduleAddSingle', '班次添加', '针对时间添加上班人员、使用前请初始化排班', '3', '3', '', '1', '2017-11-07 09:27:52', '2017-11-07 09:27:52'), ('85', 'noticeList', '预警列表', '预警列表', '29', '3', '', '1', '2017-11-07 10:24:54', '2017-11-07 10:24:54'), ('86', 'fileUpLoad', '文件上传', '文件上传', '45', '3', '', '1', '2017-11-07 13:18:11', '2017-11-07 13:18:11'), ('87', 'scheduleDelete', '班次删除', '班次删除', '3', '3', '', '1', '2017-11-08 14:09:32', '2017-11-09 15:34:30'), ('88', 'verify', '文档审核', '', '7', '2', '/file/tobeannounced', '1', '2017-11-14 10:52:22', '2017-12-11 20:08:51'), ('89', 'reportListByExamine', '审核列表', '民警审核列表', '88', '3', '', '1', '2017-11-15 09:49:01', '2017-11-15 09:49:04'), ('90', 'reportExamineEdit', '审核公文', '民警审核通过运维发布的公文', '88', '3', '', '1', '2017-11-15 09:51:52', '2017-11-15 09:51:55'), ('91', 'changePwd', '修改密码(初始化)', '', '0', '1', '/changePwd', '1', '2017-11-15 15:15:28', '2017-11-15 17:57:42'), ('97', 'reportEditByExamine', '修改公文内容', '民警修改发布前的公文', '88', '3', '', '0', null, null), ('99', 'reportDetailYW', '运维公文详情', '运维公文详情', '88', '3', '', '1', '2017-11-16 14:38:34', '2017-11-16 14:38:34'), ('100', 'policeLists', '民警列表', '民警列表', '125', '2', '', '0', null, null), ('101', 'policeList', '民警列表', '民警列表', '125', '2', '', '0', null, null), ('103', 'finishReport', '公文审核完成', '公文审核完成', '45', '3', '', '0', null, null), ('106', 'examineFileUpLoad', '审核时文件上传', '', '88', '3', '', '0', '2017-11-30 09:50:30', '2017-11-30 09:50:30'), ('107', 'unexamineCount', '获取未审核公文数量', '', '88', '3', '', '0', '2017-11-30 17:46:19', '2017-11-30 17:46:19'), ('108', '234', '登录日志', '记录登录相关信息', '10', '2', '/rbac/loginlog', '1', '2017-12-07 11:39:50', '2017-12-07 11:39:50'), ('109', 'webAdd', '业主系统添加', '', '126', '3', '', '0', '2017-12-07 16:15:50', '2017-12-07 16:15:50'), ('110', 'webEdit', '业主系统信息编辑', '', '126', '3', '', '0', '2017-12-07 16:16:11', '2017-12-07 16:16:11'), ('111', 'webList', '业主系统列表', '', '126', '3', '', '0', '2017-12-07 16:16:27', '2017-12-07 16:16:27'), ('112', 'webDelete', '业主系统列表删除', '', '126', '3', '', '0', '2017-12-07 16:16:51', '2017-12-07 16:16:51'), ('113', 'reportSystemDetail', '异常系统详情', '异常系统详情', '88', '3', '', '0', '2017-12-08 14:33:01', '2017-12-08 14:33:01'), ('114', 'reportSystemWebList', '用户所有系统列表', '用户所有系统列表', '88', '3', '', '0', '2017-12-08 14:47:48', '2017-12-08 14:47:48'), ('115', 'reportSystemAdd', '添加系统异常', '添加系统异常', '88', '3', '', '0', '2017-12-08 15:33:46', '2017-12-08 15:33:46'), ('116', 'reportSystemEdit', '修改系统异常', '修改系统异常', '88', '3', '', '0', '2017-12-08 15:34:06', '2017-12-08 15:34:06'), ('117', 'reportSystemDelete', '删除异常系统', '删除异常系统', '88', '3', '', '0', '2017-12-08 16:22:11', '2017-12-08 16:22:11'), ('119', 'reportWebList', '业主查看系统列表', '业主查看系统列表', '45', '3', '', '0', '2017-12-08 17:21:10', '2017-12-08 17:21:10'), ('120', 'reportOwnerDetail', '业主查看异常系统详情', '业主查看异常系统详情', '45', '3', '', '0', '2017-12-08 17:26:18', '2017-12-08 17:26:18'), ('121', 'clientDetail', '业主详情', '业主详情', '11', '3', '', '0', '2017-12-09 10:44:14', '2017-12-09 10:44:14'), ('122', 'sysList', '系统漏洞情况', '系统漏洞情况', '11', '3', '', '0', '2017-12-09 10:44:51', '2017-12-09 10:44:51'), ('123', 'clientInfoGradeList', '系统等级保护情况', '系统等级保护情况', '11', '3', '', '0', '2017-12-09 10:45:09', '2017-12-09 10:45:09'), ('124', 'reportSystemDetailByOwner', '系统漏洞详情', '系统漏洞详情', '11', '3', '', '0', '2017-12-09 13:05:07', '2017-12-09 13:05:07'), ('125', 'others', '其他权限', '其他权限', '0', '1', '', '0', null, null), ('126', 'users', '用户管理', '', '35', '2', '/users/list', '1', '2017-12-11 20:24:10', '2017-12-11 20:24:10');
COMMIT;

-- ----------------------------
-- Table structure for sc_receipt
-- ----------------------------
DROP TABLE IF EXISTS `sc_receipt`;
CREATE TABLE `sc_receipt` (
`receipt_id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '回执 prikey' ,
`report_id`  int(11) NOT NULL DEFAULT 0 COMMENT '报告id' ,
`report_info`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '暂定 回执的信息或者留言' ,
`admin_id`  int(11) NULL DEFAULT NULL COMMENT '回执发送人' ,
`report_admin_id`  int(11) NULL DEFAULT 0 COMMENT '该公文所属人的ID(即to_admin_id)' ,
`file_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '回执附件名' ,
`file_path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '回执附件路径' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`receipt_nick`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发回执的人的nick' ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`is_read`  int(1) NULL DEFAULT 0 COMMENT '已读未读 0未读' ,
PRIMARY KEY (`receipt_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='回执流水表'
AUTO_INCREMENT=115

;

-- ----------------------------
-- Records of sc_receipt
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_report
-- ----------------------------
DROP TABLE IF EXISTS `sc_report`;
CREATE TABLE `sc_report` (
`report_id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '报告ID' ,
`report_type`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公文类型' ,
`report_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公文名称' ,
`sys_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`admin_id`  int(11) NOT NULL COMMENT '发送人' ,
`report_title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '报告标题' ,
`deal_opinion`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '处理意见' ,
`to_admin_id`  int(11) NOT NULL DEFAULT 0 COMMENT '接收人 0,1,2,3' ,
`status`  int(5) NOT NULL DEFAULT 0 COMMENT '状态 暂定0整改发送，1整改中，2整改回执，3再次整改发送，4审核通过  5已超时  6再次整改回执' ,
`company_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '业主名称' ,
`file_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '附件文件名' ,
`file_path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '附件path' ,
`is_read`  int(1) NULL DEFAULT 0 COMMENT '已读未读 0未读  1已读' ,
`risk_level`  int(1) NULL DEFAULT 0 COMMENT '风险等级 1 绝对安全  2 比较安全  3 相对危险   4 绝对危险' ,
`scan_times`  int(11) NULL DEFAULT NULL COMMENT '扫描次数' ,
`deal_time`  timestamp NULL DEFAULT NULL COMMENT '建议处理时间 （截止时间）' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`is_examine`  int(1) NULL DEFAULT 0 ,
`examine_admin_id`  int(11) NULL DEFAULT 0 COMMENT '审核员ID （民警ID）' ,
`police_id`  int(11) NOT NULL DEFAULT 0 COMMENT '主送民警' ,
PRIMARY KEY (`report_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='报告基础表'
AUTO_INCREMENT=86

;

-- ----------------------------
-- Records of sc_report
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_report_examine
-- ----------------------------
DROP TABLE IF EXISTS `sc_report_examine`;
CREATE TABLE `sc_report_examine` (
`examine_id`  int(11) NOT NULL AUTO_INCREMENT ,
`report_id`  int(11) NULL DEFAULT NULL ,
`report_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公文标题' ,
`examine_admin_id`  int(11) NULL DEFAULT 0 COMMENT '审核的人（民警）' ,
`examine_admin_nick`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`examine_add_admin_id`  int(11) NULL DEFAULT 0 COMMENT '添加的人（运维）' ,
`examine_add_admin_nick`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' ,
`examine_info`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '审核留言' ,
`is_examine`  int(1) NULL DEFAULT 0 COMMENT '是否审核通过  0未通过 1通过 2拒绝' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`police_id`  int(11) NOT NULL DEFAULT 0 COMMENT '主送民警' ,
PRIMARY KEY (`examine_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=84

;

-- ----------------------------
-- Records of sc_report_examine
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_report_grade
-- ----------------------------
DROP TABLE IF EXISTS `sc_report_grade`;
CREATE TABLE `sc_report_grade` (
`grade_id`  int(11) NOT NULL AUTO_INCREMENT ,
`grade_title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '等级保护说明' ,
`grade_level`  tinyint(1) NULL DEFAULT NULL COMMENT '等级保护等级' ,
`grade_files`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '等级保护附件' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`grade_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=8

;

-- ----------------------------
-- Records of sc_report_grade
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_report_system
-- ----------------------------
DROP TABLE IF EXISTS `sc_report_system`;
CREATE TABLE `sc_report_system` (
`sys_id`  int(11) NOT NULL AUTO_INCREMENT ,
`web_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '网站id' ,
`bug_title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '漏洞等级' ,
`bug_files_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
`bug_files_path`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '文件路徑' ,
`grade_level`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`grade_files_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`grade_files_path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
PRIMARY KEY (`sys_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=102

;

-- ----------------------------
-- Records of sc_report_system
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_role_admin
-- ----------------------------
DROP TABLE IF EXISTS `sc_role_admin`;
CREATE TABLE `sc_role_admin` (
`admin_id`  int(10) UNSIGNED NOT NULL ,
`role_id`  int(10) UNSIGNED NOT NULL ,
PRIMARY KEY (`admin_id`, `role_id`),
FOREIGN KEY (`admin_id`) REFERENCES `sc_admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (`role_id`) REFERENCES `sc_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `role_user_role_id_foreign` USING BTREE (`role_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of sc_role_admin
-- ----------------------------
BEGIN;
INSERT INTO `sc_role_admin` VALUES ('1', '1'), ('2', '2'), ('3', '3'), ('4', '4');
COMMIT;

-- ----------------------------
-- Table structure for sc_roles
-- ----------------------------
DROP TABLE IF EXISTS `sc_roles`;
CREATE TABLE `sc_roles` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`display_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '' ,
`r_level`  int(11) NULL DEFAULT 2 COMMENT 'role等级 1 2 ' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `roles_name_unique` USING BTREE (`name`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=8

;

-- ----------------------------
-- Records of sc_roles
-- ----------------------------
BEGIN;
INSERT INTO `sc_roles` VALUES ('1', 'admin', '超级管理员', '系统管理员，拥有所有权限(市公安局)', '1', '2017-07-27 14:11:09', '2017-08-01 14:46:06', null), ('2', 'police', '民警', '区公安局', '3', '2017-07-28 10:55:17', '2017-11-08 10:22:30', null), ('3', 'editor', '运维', '区网站管理者', '2', '2017-07-28 10:55:47', '2017-11-15 15:10:55', null), ('4', 'owner', '业主', '业主单元', '2', '2017-10-09 16:09:23', '2017-10-09 16:09:30', null);
COMMIT;

-- ----------------------------
-- Table structure for sc_web
-- ----------------------------
DROP TABLE IF EXISTS `sc_web`;
CREATE TABLE `sc_web` (
`web_id`  int(11) NOT NULL AUTO_INCREMENT ,
`admin_id`  int(11) NOT NULL COMMENT '业主ID' ,
`web_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网站名称' ,
`web_link`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网站链接' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`web_id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=13

;

-- ----------------------------
-- Records of sc_web
-- ----------------------------
BEGIN;
INSERT INTO `sc_web` VALUES ('8', '2', 'ceshi', 'http://ceshi.com', '2017-12-09 15:02:53', '2017-12-09 15:21:41', '2017-12-09 15:21:41'), ('9', '0', 'ceshi002', 'http://ceshi002.com', '2017-12-09 15:18:40', '2017-12-09 15:18:40', null), ('10', '2', 'ceshi003', 'http://ceshi003.com', '2017-12-09 15:21:23', '2017-12-09 15:21:43', '2017-12-09 15:21:43'), ('11', '4', 'ceshi006', 'http://ceshi006.com', '2017-12-09 15:21:59', '2017-12-09 15:21:59', null), ('12', '4', 'ceshi007', 'http://ceshi007.com', '2017-12-09 15:22:27', '2017-12-09 15:22:27', null);
COMMIT;

-- ----------------------------
-- Table structure for sc_work_schedule
-- ----------------------------
DROP TABLE IF EXISTS `sc_work_schedule`;
CREATE TABLE `sc_work_schedule` (
`schedule_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '排班id' ,
`schedule_date`  date NULL DEFAULT NULL COMMENT '排班时间（某天）' ,
`schedule_time_begin`  timestamp NULL DEFAULT NULL COMMENT '当天排班-开始时间' ,
`schedule_time_end`  timestamp NULL DEFAULT NULL COMMENT '当天排班-结束时间' ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`schedule_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='排班表'
AUTO_INCREMENT=57

;

-- ----------------------------
-- Records of sc_work_schedule
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for sc_work_schedule_allot
-- ----------------------------
DROP TABLE IF EXISTS `sc_work_schedule_allot`;
CREATE TABLE `sc_work_schedule_allot` (
`allot_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '排排班分配id班id' ,
`work_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '值班人名' ,
`schedule_id`  int(11) NULL DEFAULT NULL COMMENT '排班id' ,
`time_begin`  timestamp NULL DEFAULT NULL COMMENT '上班时间' ,
`time_end`  timestamp NULL DEFAULT NULL COMMENT '下班时间' ,
`remark`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
`deleted_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`allot_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='排班关联表'
AUTO_INCREMENT=54

;

-- ----------------------------
-- Records of sc_work_schedule_allot
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Auto increment value for sc_admin_info
-- ----------------------------
ALTER TABLE `sc_admin_info` AUTO_INCREMENT=39;

-- ----------------------------
-- Auto increment value for sc_admin_log
-- ----------------------------
ALTER TABLE `sc_admin_log` AUTO_INCREMENT=18906;

-- ----------------------------
-- Auto increment value for sc_admin_record
-- ----------------------------
ALTER TABLE `sc_admin_record` AUTO_INCREMENT=530;

-- ----------------------------
-- Auto increment value for sc_admins
-- ----------------------------
ALTER TABLE `sc_admins` AUTO_INCREMENT=41;

-- ----------------------------
-- Auto increment value for sc_encrypt_token
-- ----------------------------
ALTER TABLE `sc_encrypt_token` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for sc_inmail
-- ----------------------------
ALTER TABLE `sc_inmail` AUTO_INCREMENT=358;

-- ----------------------------
-- Auto increment value for sc_migrations
-- ----------------------------
ALTER TABLE `sc_migrations` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for sc_notices
-- ----------------------------
ALTER TABLE `sc_notices` AUTO_INCREMENT=33;

-- ----------------------------
-- Auto increment value for sc_permissions
-- ----------------------------
ALTER TABLE `sc_permissions` AUTO_INCREMENT=127;

-- ----------------------------
-- Auto increment value for sc_receipt
-- ----------------------------
ALTER TABLE `sc_receipt` AUTO_INCREMENT=115;

-- ----------------------------
-- Auto increment value for sc_report
-- ----------------------------
ALTER TABLE `sc_report` AUTO_INCREMENT=86;

-- ----------------------------
-- Auto increment value for sc_report_examine
-- ----------------------------
ALTER TABLE `sc_report_examine` AUTO_INCREMENT=84;

-- ----------------------------
-- Auto increment value for sc_report_grade
-- ----------------------------
ALTER TABLE `sc_report_grade` AUTO_INCREMENT=8;

-- ----------------------------
-- Auto increment value for sc_report_system
-- ----------------------------
ALTER TABLE `sc_report_system` AUTO_INCREMENT=102;

-- ----------------------------
-- Auto increment value for sc_roles
-- ----------------------------
ALTER TABLE `sc_roles` AUTO_INCREMENT=8;

-- ----------------------------
-- Auto increment value for sc_web
-- ----------------------------
ALTER TABLE `sc_web` AUTO_INCREMENT=13;

-- ----------------------------
-- Auto increment value for sc_work_schedule
-- ----------------------------
ALTER TABLE `sc_work_schedule` AUTO_INCREMENT=57;

-- ----------------------------
-- Auto increment value for sc_work_schedule_allot
-- ----------------------------
ALTER TABLE `sc_work_schedule_allot` AUTO_INCREMENT=54;
