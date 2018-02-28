/*
Navicat MySQL Data Transfer

Source Server         : 智慧海洋
Source Server Version : 50718
Source Host           : 192.168.102.4:3306
Source Database       : robotfish_platform_admin

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-07-25 08:26:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `parent` varchar(30) NOT NULL DEFAULT '' COMMENT '父菜单名',
  `moduleId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '声明菜单的模块',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(30) NOT NULL DEFAULT '',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接',
  `permission` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单权限',
  `weight` smallint(6) NOT NULL DEFAULT '0',
  `visible` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否可见',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='菜单表';

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('', '51', 'consumer', '消费者端', 'fa fa-shopping-cart', '', '', '0', '1');
INSERT INTO `menu` VALUES ('consumer', '51', 'consumer-goods', '商品', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('consumer-goods', '51', 'consumer-goods-category-index', '类目', '', 'consumer/goods/category/index', 'CONSUMER_GOODS_CATEGORY_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('consumer-goods', '51', 'consumer-goods-goods-index', '商品', '', 'consumer/goods/goods/index', 'CONSUMER_GOODS_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('consumer', '51', 'consumer-purchase-index', '购买/评价', '', 'consumer/purchase/index', 'CONSUMER_PURCHASE_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('consumer', '51', 'consumer-shopping-platform-index', '电商平台', '', 'consumer/shopping-platform/index', 'CONSUMER_SHOPPING_PLATFORM_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('', '49', 'content', '内容管理', 'fa fa-pencil-square-o', '', '', '-100', '1');
INSERT INTO `menu` VALUES ('content', '49', 'content-info', '资讯', 'fa fa-book', '', '', '0', '1');
INSERT INTO `menu` VALUES ('content-info', '49', 'content-info-category-index', '分类', 'fa fa-list', 'content/info/category/index', 'CONTENT_INFO_CATEGORY_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('content-info', '49', 'content-info-index', '资讯', 'fa fa-book', 'content/info/info/index', 'CONTENT_INFO_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('content', '49', 'content-page', '页面', 'fa fa-book', 'content/page/index', 'CONTENT_PAGE_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('', '3', 'home-index', '控制面板', 'fa fa-dashboard', 'dashboard', '', '-1000', '1');
INSERT INTO `menu` VALUES ('', '53', 'producer', '企业端', 'fa fa-industry', '', '', '0', '1');
INSERT INTO `menu` VALUES ('producer', '53', 'producer-company', '企业管理', '', '', '', '-1', '1');
INSERT INTO `menu` VALUES ('producer-company', '53', 'producer-company-company-index', '企业信息', '', 'producer/company/company/index', 'PRODUCER_COMPANY_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer-company', '53', 'producer-company-credit-index', '企业诚信', '', 'producer/company/credit/index', 'PRODUCER_CREDIT_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer-company', '53', 'producer-company-qualification-index', '企业资质', '', 'producer/company/qualification/index', 'PRODUCER_COMPANY_QUALIFICATION_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer', '53', 'producer-device', '设备管理', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('producer-device', '53', 'producer-device-maintenance-index', '设备维护记录', '', 'producer/device/maintenance/index', 'PRODUCER_DEVICE_MAINTENANCE_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer-device', '53', 'producer-device-power-index', '设备开关机记录', '', 'producer/device/power/index', 'PRODUCER_DEVICE_POWER_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer', '53', 'producer-farming', '养殖管理', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('producer-farming', '53', 'producer-farming-env', '养殖环境管理', '', 'producer/farming/env/index', 'PRODUCER_FARMING_ENV_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer-farming', '53', 'producer-farming-video', '视频管理', '', 'producer/farming/video/index', 'PRODUCER_FARMING_VIDEO_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('producer', '53', 'producer-statistics', '统计管理', '', '', '', '-1', '1');
INSERT INTO `menu` VALUES ('producer-statistics', '53', 'producer-statistics-annual-trend-index', '企业年度营收趋势', '', 'producer/statistics/annual-trend/index', 'PRODUCER_STATISTICS_ANNUAL_TREND', '0', '1');
INSERT INTO `menu` VALUES ('producer-statistics', '53', 'producer-statistics-channel-weight-index', '企业渠道比重', '', 'producer/statistics/channel-weight/index', 'PRODUCER_STATISTICS_CHANNEL_WEIGHT', '0', '1');
INSERT INTO `menu` VALUES ('producer-statistics', '53', 'producer-statistics-industry-weight-index', '企业产业比重', '', 'producer/statistics/industry-weight/index', 'PRODUCER_STATISTICS_INDUSTRY_WEIGHT', '0', '1');
INSERT INTO `menu` VALUES ('producer', '53', 'producer-storage', '仓储管理', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('producer-storage', '53', 'producer-storage-warehouse-env', '仓储环境', '', 'producer/storage/warehouse-env/index', 'PRODUCER_STORAGE_WAREHOUSE_ENV_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('', '48', 'project', '项目管理', 'fa fa-cubes', '', '', '0', '1');
INSERT INTO `menu` VALUES ('project', '48', 'project-index', '项目管理', '', 'project/project/index', 'PROJECT_PROJECT_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('project', '48', 'project-product-type-category-index', '产品分类', '', 'project/product-type-category/index', 'PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('project', '48', 'project-product-type-index', '产品类型管理', '', 'project/product-type/index', 'PROJECT_PRODUCT_TYPE_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisior', '52', 'supervisior-complaint-index', '投诉管理', '', 'supervisior/complaint/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior', '52', 'supervisior-data', '环境数据', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior-data', '52', 'supervisior-data-species-index', '生物多样性数据', '', 'supervisior/data/species/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior-data', '52', 'supervisior-data-video-index', '视频数据', '', 'supervisior/data/video/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior-data', '52', 'supervisior-data-water-index', '水质数据', '', 'supervisior/data/water/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior', '52', 'supervisior-department-index', '部门管理', '', 'supervisior/department/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior', '52', 'supervisior-device-index', '设备管理', '', 'supervisior/device/index', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisior', '52', 'supervisior-point-check-index', '抽检管理', '', 'supervisior/point-check/index', '', '0', '1');
INSERT INTO `menu` VALUES ('', '54', 'supervisor', '政府端', 'fa fa-gavel', '', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-statistics', '54', 'supervisor-annual-trend-index', '行业年度营收趋势', '', 'supervisor/annual-trend/index', 'SUPERVISOR_ANNUAL_TREND_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor', '54', 'supervisor-complaint-index', '投诉管理', '', 'supervisor/complaint/index', 'SUPERVISOR_COMPLAINT_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor', '54', 'supervisor-data', '环境数据', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-data', '54', 'supervisor-data-species-index', '生物多样性数据', '', 'supervisor/species/index', 'SUPERVISOR_SPECIES_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-data', '54', 'supervisor-data-video-index', '视频数据', '', 'supervisor/video/index', 'SUPERVISOR_VIDEO_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-data', '54', 'supervisor-data-warning-index', '环境污染预警', '', 'supervisor/warning/index', 'SUPERVISOR_WARNING_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-data', '54', 'supervisor-data-water-index', '水质数据', '', 'supervisor/water/index', 'SUPERVISOR_WATER_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor', '54', 'supervisor-department-index', '部门管理', '', 'supervisor/department/index', 'SUPERVISOR_DEPARTMENT_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor-statistics', '54', 'supervisor-industry-weight-index', '行业分布', '', 'supervisor/industry-weight/index', 'SUPERVISOR_INDUSTRY_WEIGHT_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor', '54', 'supervisor-spot-check-index', '抽检管理', '', 'supervisor/spot-check/index', 'SUPERVISOR_SPOT_CHECK_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('supervisor', '54', 'supervisor-statistics', '统计管理', '', '', '', '0', '1');
INSERT INTO `menu` VALUES ('', '35', 'system', '系统设置', 'fa fa-cog', '', '', '-100', '1');
INSERT INTO `menu` VALUES ('system', '35', 'system-admin', '管理员管理', 'fa fa-users', 'system/admin/index', 'SYSTEM_ADMIN_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('system', '35', 'system-menu', '菜单管理', 'fa fa-list', 'system/menu/index', 'SYSTEM_MENU_MANAGE', '3', '1');
INSERT INTO `menu` VALUES ('system', '35', 'system-module', '模块管理', 'fa fa-cubes', 'system/module/index', 'SYSTEM_MODULE_MANAGE', '2', '1');
INSERT INTO `menu` VALUES ('system', '35', 'system-role', '角色管理', 'fa fa-user', 'system/role/index', 'SYSTEM_ROLE_MANAGE', '1', '1');
INSERT INTO `menu` VALUES ('user', '47', 'user-index', '用户管理', '', 'user/user/index', 'USER_USER_MANAGE', '0', '1');
INSERT INTO `menu` VALUES ('user', '47', 'user-role', '角色权限', '', 'user/role/index', 'USER_ROLE_MANAGE', '0', '1');

-- ----------------------------
-- Table structure for module
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) NOT NULL COMMENT '模块名',
  `title` varchar(30) NOT NULL,
  `path` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',
  `author` varchar(255) NOT NULL DEFAULT '' COMMENT '作者信息',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `version` varchar(10) NOT NULL DEFAULT '' COMMENT '版本号',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `isLocked` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定？',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理平台模块表';

-- ----------------------------
-- Records of module
-- ----------------------------
INSERT INTO `module` VALUES ('3', 'home', '管理主页模块', 'Home', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '管理平台控制面板', '', '1479181583', '1');
INSERT INTO `module` VALUES ('35', 'system', '系统模块', 'System', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '系统管理', '', '1494219529', '1');
INSERT INTO `module` VALUES ('48', 'project', '项目管理模块', 'Project', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '管理项目', '', '1494219528', '1');
INSERT INTO `module` VALUES ('49', 'content', '内容模块', 'Content', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '内容管理', '', '1494219527', '1');
INSERT INTO `module` VALUES ('51', 'consumer', '消费者端', 'Consumer', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '管理消费者端数据', '', '1494219526', '1');
INSERT INTO `module` VALUES ('53', 'producer', '企业端', 'Producer', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '管理企业端数据', '', '1494219525', '1');
INSERT INTO `module` VALUES ('54', 'supervisor', '政府端', 'Supervisor', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '管理政府端数据', '', '1494219524', '1');
INSERT INTO `module` VALUES ('55', 'statistic', '统计模块', 'Statistic', 'a:3:{s:4:\"name\";s:6:\"xlight\";s:5:\"email\";s:9:\"i@im87.cn\";s:8:\"homepage\";s:18:\"http://www.im87.cn\";}', '平台信息统计报表。', '', '1494219523', '1');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `name` varchar(50) NOT NULL COMMENT '权限',
  `parent` varchar(50) NOT NULL DEFAULT '' COMMENT '父权限',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `moduleId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员权限表';

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('CONSUMER_GOODS_CATEGORY_MANAGE', '', '管理商品类目', '51');
INSERT INTO `permission` VALUES ('CONSUMER_GOODS_MANAGE', '', '管理商品', '51');
INSERT INTO `permission` VALUES ('CONSUMER_PURCHASE_MANAGE', '', '管理购买/评价', '51');
INSERT INTO `permission` VALUES ('CONSUMER_SHOPPING_PLATFORM_MANAGE', '', '管理电商平台', '51');
INSERT INTO `permission` VALUES ('CONTENT_INFO_CATEGORY_MANAGE', '', '管理资讯分类', '49');
INSERT INTO `permission` VALUES ('CONTENT_INFO_MANAGE', '', '管理资讯', '49');
INSERT INTO `permission` VALUES ('CONTENT_PAGE_MANAGE', '', '管理页面', '49');
INSERT INTO `permission` VALUES ('PRODUCER_COMPANY_MANAGE', '', '管理企业信息', '53');
INSERT INTO `permission` VALUES ('PRODUCER_COMPANY_QUALIFICATION_MANAGE', '', '管理企业资质', '53');
INSERT INTO `permission` VALUES ('PRODUCER_CREDIT_MANAGE', '', '管理企业诚信', '53');
INSERT INTO `permission` VALUES ('PRODUCER_DEVICE_MAINTENANCE_MANAGE', '', '管理设备维护记录', '53');
INSERT INTO `permission` VALUES ('PRODUCER_DEVICE_POWER_MANAGE', '', '管理设备开关机记录', '53');
INSERT INTO `permission` VALUES ('PRODUCER_FARMING_ENV_MANAGE', '', '养殖环境管理', '53');
INSERT INTO `permission` VALUES ('PRODUCER_FARMING_VIDEO_MANAGE', '', '养殖视频管理', '53');
INSERT INTO `permission` VALUES ('PRODUCER_STATISTICS_ANNUAL_TREND', '', '管理企业年度营收趋势', '53');
INSERT INTO `permission` VALUES ('PRODUCER_STATISTICS_CHANNEL_WEIGHT', '', '管理企业渠道比重', '53');
INSERT INTO `permission` VALUES ('PRODUCER_STATISTICS_INDUSTRY_WEIGHT', '', '管理企业产业比重', '53');
INSERT INTO `permission` VALUES ('PRODUCER_STORAGE_WAREHOUSE_ENV_MANAGE', '', '仓储环境管理', '53');
INSERT INTO `permission` VALUES ('PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE', '', '管理产品类型分类', '48');
INSERT INTO `permission` VALUES ('PROJECT_PRODUCT_TYPE_MANAGE', '', '管理产品类型', '48');
INSERT INTO `permission` VALUES ('PROJECT_PROJECT_MANAGE', '', '管理项目', '48');
INSERT INTO `permission` VALUES ('SUPERVISOR_ANNUAL_TREND_MANAGE', '', '行业年度营收趋势', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_COMPLAINT_MANAGE', '', '投诉管理', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_DEPARTMENT_MANAGE', '', '部门管理', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_INDUSTRY_WEIGHT_MANAGE', '', '行业分布', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_SPECIES_MANAGE', '', '生物多样性数据', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_SPOT_CHECK_MANAGE', '', '抽检管理', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_VIDEO_MANAGE', '', '视频数据', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_WARNING_MANAGE', '', '环境污染预警', '54');
INSERT INTO `permission` VALUES ('SUPERVISOR_WATER_MANAGE', '', '水质数据', '54');
INSERT INTO `permission` VALUES ('SYSTEM_ADMIN_MANAGE', '', '管理管理员', '35');
INSERT INTO `permission` VALUES ('SYSTEM_MENU_MANAGE', '', '管理菜单', '35');
INSERT INTO `permission` VALUES ('SYSTEM_MODULE_MANAGE', '', '管理模块', '35');
INSERT INTO `permission` VALUES ('SYSTEM_ROLE_MANAGE', '', '管理角色', '35');
INSERT INTO `permission` VALUES ('USER_USER_MANAGE', '', '管理用户', '47');
INSERT INTO `permission` VALUES ('VIEW_PLATFORM_STATISTIC', '', '查看平台统计', '55');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `parentId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父角色id',
  `name` varchar(30) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `timeCreated` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员角色表';

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '0', '系统管理员', '可进行后台设置、管理员管理和基础数据维护', '1384480294');
INSERT INTO `role` VALUES ('11', '0', '用户管理员', '可管理平台注册用户等', '1415285432');
INSERT INTO `role` VALUES ('15', '0', '超级管理员', '项目、消费者端、企业端、政府端全部的管理权限', '1467941631');
INSERT INTO `role` VALUES ('16', '0', '产品经理', '产品经理权限', '1467950668');

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `roleId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `permission` varchar(30) NOT NULL DEFAULT '' COMMENT '权限名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员角色权限表';

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES ('1', 'SYSTEM_ADMIN_MANAGE');
INSERT INTO `role_permission` VALUES ('1', 'SYSTEM_MODULE_MANAGE');
INSERT INTO `role_permission` VALUES ('1', 'SYSTEM_ROLE_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONTENT_INFO_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONTENT_PAGE_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'SYSTEM_ADMIN_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'SYSTEM_MODULE_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'SYSTEM_ROLE_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'USER_USER_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONSUMER_GOODS_CATEGORY_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONSUMER_GOODS_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONSUMER_PURCHASE_MANAGE');
INSERT INTO `role_permission` VALUES ('16', 'CONSUMER_SHOPPING_PLATFORM_MAN');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(60) NOT NULL COMMENT '邮箱',
  `tel` varchar(20) NOT NULL COMMENT '手机号',
  `pass` varchar(64) NOT NULL COMMENT '密码',
  `salt` varchar(6) NOT NULL DEFAULT '' COMMENT 'salt',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `timeCreated` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'root', 'root@robotfish.com.cn', '', '20ce9ed80d0218aef8ca51796f8b248d', 'aK5.qK', '1', '1401017386');
INSERT INTO `user` VALUES ('2', 'kevin', 'i@im87.cn', '', '73dba84486e7b97810d2189b815a6b6d', 'a(I$$/', '1', '1415193508');
INSERT INTO `user` VALUES ('3', 'twang', 'twang@lucasgc.com', '18910278319', 'b646156956bc495e15e6690f9229de21', 'iG{Tza', '1', '1467444214');
INSERT INTO `user` VALUES ('10', 'Iris Liu', 'iliu@lucasgc.com', '17777861150', '7dc466a9fe81dbb520e665e619dae811', 'hAR=:E', '0', '1468209496');
INSERT INTO `user` VALUES ('12', 'test', 'test@robotfish.com.cn', '', '8d962d446081ee131a24eba4ed6c78f7', '(s9vo7', '1', '1494849700');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `userId` int(10) unsigned NOT NULL COMMENT '用户id',
  `roleId` int(10) unsigned NOT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理用户-角色';

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES ('2', '16');
INSERT INTO `user_role` VALUES ('3', '15');
INSERT INTO `user_role` VALUES ('4', '14');
INSERT INTO `user_role` VALUES ('5', '13');
INSERT INTO `user_role` VALUES ('6', '14');
INSERT INTO `user_role` VALUES ('7', '15');
INSERT INTO `user_role` VALUES ('8', '19');
INSERT INTO `user_role` VALUES ('0', '1');
INSERT INTO `user_role` VALUES ('4', '14');
INSERT INTO `user_role` VALUES ('5', '15');
INSERT INTO `user_role` VALUES ('6', '12');
INSERT INTO `user_role` VALUES ('7', '12');
INSERT INTO `user_role` VALUES ('8', '12');
INSERT INTO `user_role` VALUES ('9', '12');
INSERT INTO `user_role` VALUES ('10', '16');
INSERT INTO `user_role` VALUES ('11', '14');
INSERT INTO `user_role` VALUES ('12', '16');
INSERT INTO `user_role` VALUES ('13', '14');
INSERT INTO `user_role` VALUES ('14', '14');
INSERT INTO `user_role` VALUES ('15', '14');
INSERT INTO `user_role` VALUES ('16', '14');
INSERT INTO `user_role` VALUES ('17', '14');
INSERT INTO `user_role` VALUES ('18', '14');
INSERT INTO `user_role` VALUES ('19', '18');
INSERT INTO `user_role` VALUES ('20', '14');
INSERT INTO `user_role` VALUES ('21', '14');
INSERT INTO `user_role` VALUES ('22', '19');
INSERT INTO `user_role` VALUES ('23', '17');
INSERT INTO `user_role` VALUES ('24', '14');
INSERT INTO `user_role` VALUES ('25', '14');
INSERT INTO `user_role` VALUES ('26', '17');
INSERT INTO `user_role` VALUES ('27', '17');
INSERT INTO `user_role` VALUES ('28', '14');
INSERT INTO `user_role` VALUES ('29', '14');
INSERT INTO `user_role` VALUES ('30', '14');
INSERT INTO `user_role` VALUES ('31', '14');
INSERT INTO `user_role` VALUES ('32', '14');
INSERT INTO `user_role` VALUES ('33', '14');
INSERT INTO `user_role` VALUES ('34', '12');
INSERT INTO `user_role` VALUES ('35', '14');
INSERT INTO `user_role` VALUES ('36', '14');
INSERT INTO `user_role` VALUES ('37', '14');
INSERT INTO `user_role` VALUES ('38', '14');
INSERT INTO `user_role` VALUES ('39', '14');
INSERT INTO `user_role` VALUES ('40', '14');
INSERT INTO `user_role` VALUES ('41', '14');
INSERT INTO `user_role` VALUES ('42', '14');
INSERT INTO `user_role` VALUES ('43', '14');
INSERT INTO `user_role` VALUES ('44', '14');
INSERT INTO `user_role` VALUES ('45', '14');
INSERT INTO `user_role` VALUES ('46', '14');
INSERT INTO `user_role` VALUES ('47', '14');
INSERT INTO `user_role` VALUES ('48', '14');
INSERT INTO `user_role` VALUES ('49', '14');
INSERT INTO `user_role` VALUES ('50', '14');
INSERT INTO `user_role` VALUES ('51', '14');
INSERT INTO `user_role` VALUES ('52', '20');
INSERT INTO `user_role` VALUES ('53', '19');
INSERT INTO `user_role` VALUES ('54', '14');
INSERT INTO `user_role` VALUES ('55', '16');
INSERT INTO `user_role` VALUES ('11', '16');
INSERT INTO `user_role` VALUES ('12', '16');
