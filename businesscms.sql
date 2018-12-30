/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : businesscms

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-12-30 18:03:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_num` int(11) DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `last_login_time` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '$2y$10$HNeKvEnaNrcsngfbB92wVOON.6hPiIEMPEiVhdoLrAC3/p7uGDWpm', null, '127.0.0.1', '1546151230', '1545811861', '1546151230');

-- ----------------------------
-- Table structure for `articles`
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `content` text,
  `sort` int(11) DEFAULT NULL,
  `is_show` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`) USING BTREE,
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES ('1', '18', 'fegwegew方位格无法', 'fegewg', 'fewgewg', 'gewgewgfe', null, null, 'gewegew', '5', '1', null, '1544694209', '1544694858');
INSERT INTO `articles` VALUES ('3', '17', '分为各位', '', '', '', '/uploads/articles/20181226\\e696e369cb119971a11baffa237f379f.png', '', '<p style=\"line-height: 16px;\"><img src=\"http://www.businesscms.com/plugins/tyeditor/dialogs/attachment/fileTypeImages/icon_doc.gif\"/><a style=\"font-size:12px; color:#0066cc;\" href=\"http://www.businesscms.com/uploads/details/files/20181226\\a994f1d63d5c8ceedc6ee2d71ff29116.docx\" title=\"http://www.businesscms.com/uploads/details/files/20181226\\a994f1d63d5c8ceedc6ee2d71ff29116.docx\">http://www.businesscms.com/uploads/details/files/20181226\\a994f1d63d5c8ceedc6ee2d71ff29116.docx</a></p><p>fewgwefewgew<br/></p><p><br/></p>', '50', '1', null, '1545828160', '1545828160');

-- ----------------------------
-- Table structure for `configs`
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `qq` varchar(255) DEFAULT NULL,
  `wechat` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('1', '网站名称', 'web_title', 'jxcat', '/uploads/common/20181226\\eec6e6095152a7384083bcf19a49823e.jpg', 'fwegwe', 'fewgew', 'fewgweg', 'fewgewf', '', '', '', '', '', '1544521226', '1545804877');

-- ----------------------------
-- Table structure for `feedbacks`
-- ----------------------------
DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of feedbacks
-- ----------------------------
INSERT INTO `feedbacks` VALUES ('1', '5', 'fwee', '125487', '', '', 'fewgwe', 'fewgewg', '1544767694', '1546157751');

-- ----------------------------
-- Table structure for `friend_links`
-- ----------------------------
DROP TABLE IF EXISTS `friend_links`;
CREATE TABLE `friend_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend_links
-- ----------------------------
INSERT INTO `friend_links` VALUES ('1', 'ggsa', 'hthrth', null, '4', '0', '0');
INSERT INTO `friend_links` VALUES ('2', '法山豆根的完全放弃', '过问过问过问士大夫 ', null, '6', '0', '0');
INSERT INTO `friend_links` VALUES ('3', 'tesst', 'test', null, '6', '0', '0');
INSERT INTO `friend_links` VALUES ('4', '分为各位各位', 'twetwet', null, '8', '0', '0');
INSERT INTO `friend_links` VALUES ('5', '过热各五个五个', '伟哥伟哥伟哥和外国', null, '8', '0', '0');
INSERT INTO `friend_links` VALUES ('6', '各五个五个', '各位各位官方', null, '9', '0', '0');
INSERT INTO `friend_links` VALUES ('7', 'fdsgafds', 'gewgewg', null, '6', '1544520454', '1544520454');

-- ----------------------------
-- Table structure for `photos`
-- ----------------------------
DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `image` varchar(255) DEFAULT NULL,
  `images` text,
  `is_show` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`) USING BTREE,
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photos
-- ----------------------------
INSERT INTO `photos` VALUES ('1', '0', '分为各位', '', '', '', '/uploads/photos/20181226\\8dc92cdbf358acfd1bee716455a95110.png', '[\"/uploads/photos/20181226\\\\f5675acd0d25f7432644991bc22a2d9a.png\",\"/uploads/photos/20181226\\\\f0007e6cff8d86587dc6c4b9f4aa44f4.png\"]', '1', '50', null, '1545809199', '1545809199');

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `image` varchar(255) DEFAULT NULL,
  `images` text,
  `video` varchar(255) DEFAULT NULL,
  `content` text,
  `sort` int(11) DEFAULT NULL,
  `is_show` int(11) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`) USING BTREE,
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '9', 'fsfweg', 'fwegewg', 'fewgweg', 'fewgweg', null, null, null, 'fgwegew', '5', '1', null, null, '1544767694', '1544767694');
INSERT INTO `products` VALUES ('3', '9', 'wefgwegw', 'fewgew', 'fewgweg', 'fwegew', '/uploads/products/20181226\\0f2ba0cc29b04ff989a0a04468b4fc82.png', '[\"/uploads/products/20181226\\\\20b1a445a72d47c3cb4ba9aa21d76fac.jpg\",\"/uploads/products/20181226\\\\cc80e639735d8cdbe0fb09919b8bd996.jpg\"]', '/uploads/products/20181226\\49406a3230335d4ce84927a3f3592804.mp4', 'fwegweg', '50', '1', null, null, '1545807118', '1545807118');
INSERT INTO `products` VALUES ('5', '9', 'fwegewg', '', '', '', '', '', '', '<p>fwegewg</p>', '50', '1', null, '', '1546071197', '1546071197');
INSERT INTO `products` VALUES ('6', '19', 'fsdgweg', '', '', '', '', '', '', '<p>fwegew</p>', '50', '1', null, '', '1546075400', '1546075400');
INSERT INTO `products` VALUES ('7', '19', 'fegweggewg', '', '', '', '', '', '', '<p>fwegegwewg</p>', '50', '1', null, '', '1546075411', '1546075411');
INSERT INTO `products` VALUES ('8', '19', 'fwegewgewg', '', '', '', '', '', '', '<p>fewgfwegew</p>', '50', '1', null, '', '1546075422', '1546075422');

-- ----------------------------
-- Table structure for `taxons`
-- ----------------------------
DROP TABLE IF EXISTS `taxons`;
CREATE TABLE `taxons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` varchar(20) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` text,
  `content` text,
  `is_show` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of taxons
-- ----------------------------
INSERT INTO `taxons` VALUES ('1', '0', '关于我们', 'pages', 'about', null, null, 'fwegew', 'ewge', 'egewgewgfdsfwegewg', null, '1', '0', '1544600381', '1544600985');
INSERT INTO `taxons` VALUES ('2', '0', '新闻中心', 'articles', 'news', null, null, 'fwegew', 'fewgweg', 'fewgweg', null, '1', '2', '1544601026', '1544601026');
INSERT INTO `taxons` VALUES ('3', '0', '产品中心', 'products', 'products', null, null, 'ewgewg', 'fwegweg', 'efewgew', null, '1', '2', '1544601049', '1544601049');
INSERT INTO `taxons` VALUES ('4', '0', '案例展示', 'photos', 'photos', null, null, 'fewgew', 'fwegew', 'gewgew', null, '1', '3', '1544601066', '1544601066');
INSERT INTO `taxons` VALUES ('5', '0', '留言', 'feedbacks', 'feedbacks', null, null, 'fewgew', 'gewgw', 'wegewg', null, '1', '5', '1544601082', '1544601082');
INSERT INTO `taxons` VALUES ('6', '2', '公司新闻', 'articles', '', null, null, '', '', '', null, '1', '5', '1545209597', '1545209597');
INSERT INTO `taxons` VALUES ('7', '6', '公告', 'articles', '', null, null, '', '', '', null, '0', '50', '1545212547', '1545212547');
INSERT INTO `taxons` VALUES ('8', '1', '团队建设', 'pages', '', '/uploads/icon/20181226\\3ae996133ec4e8d36f1348ecf66a8547.png', null, '', '', '', '<p>团队建设1团队建设1团队建设1团队建设1团队建设1团队建设1团队建设1</p><p>团队建设1团队建设1团队建设1团队建设1团队建设1团队建设1团队建设1</p>', '1', '50', '1545792187', '1546051330');
INSERT INTO `taxons` VALUES ('9', '3', '封边机', 'products', '', '', null, '', '', '', null, '1', '50', '1545962287', '1545962287');
INSERT INTO `taxons` VALUES ('11', '1', '荣誉', 'articles', '', '', null, '', '', '', null, '1', '50', '1545976222', '1545976222');
INSERT INTO `taxons` VALUES ('13', '0', '服务', 'pages', '', '', null, '', '', '', null, '1', '50', '1545976866', '1545976866');
INSERT INTO `taxons` VALUES ('15', '6', '签约', 'articles', '', '', null, '', '', '', null, '1', '50', '1545979334', '1545979334');
INSERT INTO `taxons` VALUES ('16', '2', '行业新闻', 'articles', '', '', null, '', '', '', null, '1', '50', '1545979350', '1545979350');
INSERT INTO `taxons` VALUES ('17', '16', '前沿技术', 'photos', '', '', null, '', '', '', null, '1', '50', '1545979374', '1545979374');
INSERT INTO `taxons` VALUES ('18', '16', '市场动态', 'articles', '', '', null, '', '', '', null, '1', '50', '1545979390', '1545979390');
INSERT INTO `taxons` VALUES ('19', '3', '砂光机', 'products', '', '', null, '', '', '', null, '1', '50', '1546071242', '1546071242');
