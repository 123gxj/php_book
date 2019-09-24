/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : book

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-09-04 20:32:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pre_admin
-- ----------------------------
DROP TABLE IF EXISTS `pre_admin`;
CREATE TABLE `pre_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(200) DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `salt` varchar(150) DEFAULT NULL COMMENT '密码盐',
  `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
  `email` varchar(150) DEFAULT NULL COMMENT '邮箱',
  `register_time` int(11) DEFAULT NULL COMMENT '时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of pre_admin
-- ----------------------------
INSERT INTO `pre_admin` VALUES ('16', 'gxj', 'e2dbc076ee7dd535f463fd3b7f8464fe', 'muN58&*>./', '/uploads/20190826164613cegmstzCEIMNQR5.png', 'gxj1@qq.com', '1566835200');

-- ----------------------------
-- Table structure for pre_book
-- ----------------------------
DROP TABLE IF EXISTS `pre_book`;
CREATE TABLE `pre_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '小说标题',
  `author` varchar(255) DEFAULT NULL COMMENT '作者',
  `register_time` int(11) DEFAULT NULL COMMENT '时间',
  `content` text COMMENT '描述内容',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片封面',
  `recycle` tinyint(1) unsigned DEFAULT NULL,
  `flagid` int(10) unsigned DEFAULT NULL,
  `cateid` int(10) unsigned DEFAULT NULL COMMENT '分类外键',
  PRIMARY KEY (`id`),
  KEY `key_book_cateid` (`cateid`) USING BTREE,
  CONSTRAINT ` foreign_book_cateid` FOREIGN KEY (`cateid`) REFERENCES `pre_cate` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='书籍表';

-- ----------------------------
-- Records of pre_book
-- ----------------------------
INSERT INTO `pre_book` VALUES ('4', 'tses3', 'fd', '1566921600', '', '/uploads/20190826170110dikoruwyzHMP136.png', '1', '1', '12');
INSERT INTO `pre_book` VALUES ('5', 'tses32', 'fd', '1565798400', 'oyp', '/uploads/20190826170534ahijmzINRTXYZ08.png', '1', '2', '12');
INSERT INTO `pre_book` VALUES ('6', '一世繁花开', 'GN粒子', '1566835200', '<a href=\"https://www.17k.com/list/3016329.html\" target=\"_blank\">苏彼岸刚醒来的时候就发现现在的身体里住着两个灵魂，可她却不是主导着。<br />\r\n她看着另一个灵魂慕清安长大。<br />\r\n她是栖梧国的镇国长公主，尊贵异常，时而淡然冷漠，时而慵懒嗜杀。<br />\r\n她们是一座戏台上的戏子，共同谱写这一世繁花。</a>', '/uploads/20190827145110denopwABCDHPQ67.jpg', '0', '3', '12');
INSERT INTO `pre_book` VALUES ('7', '默默的爱之咫尺天涯', '芸窗', '1567008000', '年少时期的喜欢，埋藏心间。随着时间的推移，没有消散，反而成为心中最美的期待。徐少杰和韩晓璇高中时相互喜欢，但高考后两人就此别离，杳无音讯。10年后，同一个公司再次相遇，却是咫尺天涯的距离。但心中的爱让他们努力冲破阻碍，勇敢向前。', '/uploads/20190829152822bdgksyKMNWY1239.jpg', '0', '2', '4');
INSERT INTO `pre_book` VALUES ('8', '龙族1·火之晨曦', '江南', '1567008000', '<span style=\"color:#343434;font-family:Tahoma, &quot;background-color:#FFFFFF;\">他叫路明非，一个平凡普通的学生。他过着周而复始的生活，就在他以为他的一生就将如此度过的时候，一封来自美国神秘学院的来信改变了他平淡的人生——世间有龙！你的使命是屠龙。在热血与神秘的呼唤下，在爱与梦想的抉择下，他毅</span>', '/uploads/20190829155327bcdjpvzHIPQRX46.jpg', '0', '1', '5');

-- ----------------------------
-- Table structure for pre_cate
-- ----------------------------
DROP TABLE IF EXISTS `pre_cate`;
CREATE TABLE `pre_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of pre_cate
-- ----------------------------
INSERT INTO `pre_cate` VALUES ('4', '都市娱乐');
INSERT INTO `pre_cate` VALUES ('5', '仙侠武侠');
INSERT INTO `pre_cate` VALUES ('12', '古装言情');

-- ----------------------------
-- Table structure for pre_chapter
-- ----------------------------
DROP TABLE IF EXISTS `pre_chapter`;
CREATE TABLE `pre_chapter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `register_time` int(11) DEFAULT NULL COMMENT '章节更新时间',
  `title` varchar(255) DEFAULT NULL COMMENT '章节标题',
  `content` varchar(255) DEFAULT NULL COMMENT '章节的内容是一个路径',
  `bookid` int(10) unsigned DEFAULT NULL COMMENT '书籍外键',
  PRIMARY KEY (`id`),
  KEY `key_chapter_bookid` (`bookid`) USING BTREE,
  CONSTRAINT `foreign_chapter_bookid` FOREIGN KEY (`bookid`) REFERENCES `pre_book` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='章节表';

-- ----------------------------
-- Records of pre_chapter
-- ----------------------------
INSERT INTO `pre_chapter` VALUES ('1', '1566890073', '\n																	楔子\n															', '/book/20190827/cfklmorsCDGHLNRY1357.json', '6');
INSERT INTO `pre_chapter` VALUES ('2', '1566890073', '\n																	第一章:生辰\n															', '/book/20190827/cdgikltuCDFHJMNOPSV7.json', '6');
INSERT INTO `pre_chapter` VALUES ('3', '1566890074', '\n																	第二章：长安宫\n															', '/book/20190827/kmnpstwxBDEHJPQRW469.json', '6');
INSERT INTO `pre_chapter` VALUES ('4', '1566890076', '\n																	第三章：遇见元祁\n															', '/book/20190827/bdfgimuwxAEIPRTU0489.json', '6');
INSERT INTO `pre_chapter` VALUES ('5', '1566890076', '\n																	第四章：醒来\n															', '/book/20190827/bdeioptwxyzBGHJVW467.json', '6');
INSERT INTO `pre_chapter` VALUES ('6', '1566890077', '\n																	第五章：彼岸出现\n															', '/book/20190827/dfgikrsuvABHIMNQUWX3.json', '6');
INSERT INTO `pre_chapter` VALUES ('7', '1566890079', '\n																	第六章：得救\n															', '/book/20190827/afhipxyACNOPQTW12346.json', '6');
INSERT INTO `pre_chapter` VALUES ('8', '1566890079', '\n																	第七章：回宫\n															', '/book/20190827/abfhnortxCFGNOPV2459.json', '6');
INSERT INTO `pre_chapter` VALUES ('9', '1566890080', '\n																	第八章:白子风\n															', '/book/20190827/amnruvwyAFGHIKRVXY02.json', '6');
INSERT INTO `pre_chapter` VALUES ('10', '1566890081', '\n																	第九章：冷云漠\n															', '/book/20190827/cdhlmnopvzACKOPQVZ15.json', '6');
INSERT INTO `pre_chapter` VALUES ('11', '1566890082', '\n																	第十章：皇后\n															', '/book/20190827/cfikmquwCFIKLMOPT378.json', '6');
INSERT INTO `pre_chapter` VALUES ('12', '1566890082', '\n																	第十一章：公子世无双\n															', '/book/20190827/fgknoptvwzFGJQSWXZ14.json', '6');
INSERT INTO `pre_chapter` VALUES ('13', '1566890083', '\n																	第十二章∶惩治兰心\n															', '/book/20190827/dloqvyDHJNOPRSVWY017.json', '6');
INSERT INTO `pre_chapter` VALUES ('14', '1566890083', '\n																	第十三章：清安出宫\n															', '/book/20190827/adknrtCFGIMOSXZ03578.json', '6');
INSERT INTO `pre_chapter` VALUES ('15', '1566890084', '\n																	第十四章∶七夕\n															', '/book/20190827/bekoruwADHLMNPY25689.json', '6');
INSERT INTO `pre_chapter` VALUES ('16', '1566890084', '\n																	第十五章∶七夕盛宴\n															', '/book/20190827/cdgtuwxzBEFJOPST0489.json', '6');
INSERT INTO `pre_chapter` VALUES ('17', '1566890085', '\n																	第十六章:唠家常\n															', '/book/20190827/efhoqsuvxyCDGSUXZ168.json', '6');
INSERT INTO `pre_chapter` VALUES ('18', '1566890086', '\n																	第十七章：变相相亲\n															', '/book/20190827/dfikmqtvxyACDHTY0245.json', '6');
INSERT INTO `pre_chapter` VALUES ('19', '1566890087', '\n																	第十八章：全员到齐\n															', '/book/20190827/cijloptBFHIJORU04579.json', '6');
INSERT INTO `pre_chapter` VALUES ('20', '1566890087', '\n																	第十九章：解围楚离\n															', '/book/20190827/dfghkopqruyDNQUVWZ35.json', '6');
INSERT INTO `pre_chapter` VALUES ('21', '1566890088', '\n																	第二十章：爆炸\n															', '/book/20190827/agijmnrvwzBIKPSZ5689.json', '6');
INSERT INTO `pre_chapter` VALUES ('22', '1566890088', '\n																	第二十一章：张翰飞\n															', '/book/20190827/abmnruvwyCDLRTXYZ389.json', '6');
INSERT INTO `pre_chapter` VALUES ('23', '1566890089', '\n																	第二十二章：灯会\n															', '/book/20190827/efhjmstvxyABILMOPVWY.json', '6');
INSERT INTO `pre_chapter` VALUES ('24', '1566890089', '\n																	第二十三章:生死无悔全为你\n															', '/book/20190827/acefhjkmtzACJNOPRY25.json', '6');
INSERT INTO `pre_chapter` VALUES ('25', '1566890090', '\n																	第二十四章：不悔\n															', '/book/20190827/bdgkmnrsuvwxzCGLOT17.json', '6');
INSERT INTO `pre_chapter` VALUES ('26', '1566890090', '\n																	第二十五章：卿卿漠漠\n															', '/book/20190827/cefinqstvyGHIJMNTW13.json', '6');
INSERT INTO `pre_chapter` VALUES ('27', '1566890091', '\n																	第二十六章：梦\n															', '/book/20190827/afhjopqruvwJUXY34679.json', '6');
INSERT INTO `pre_chapter` VALUES ('28', '1566890091', '\n																	第二十七章：佳琪来访\n															', '/book/20190827/foqtvwABCDJLPQSUWYZ1.json', '6');
INSERT INTO `pre_chapter` VALUES ('29', '1566890092', '\n																	第二十八章：皇帝来接\n															', '/book/20190827/bcfhlmptILNOPSVYZ125.json', '6');
INSERT INTO `pre_chapter` VALUES ('30', '1566890092', '\n																	第二十九章：回宫\n															', '/book/20190827/bciopqwyADKLNPSVXY39.json', '6');
INSERT INTO `pre_chapter` VALUES ('31', '1566890093', '\n																	第三十章：后宫来访\n															', '/book/20190827/cfjmnqstuyBCFHINUVWZ.json', '6');
INSERT INTO `pre_chapter` VALUES ('32', '1566890093', '\n																	第三十一章：红瞳\n															', '/book/20190827/bfknqtvyBDJLMPQTU458.json', '6');
INSERT INTO `pre_chapter` VALUES ('33', '1566890094', '\n																	第三十二章：病\n															', '/book/20190827/beghpqrvyzCHIJMY0289.json', '6');
INSERT INTO `pre_chapter` VALUES ('34', '1566890094', '\n																	第三十三章：药不是皇贵妃给的\n															', '/book/20190827/acdfqrxyAFIQRX123569.json', '6');
INSERT INTO `pre_chapter` VALUES ('35', '1566890095', '\n																	第三十四章：出头\n															', '/book/20190827/dghkquvwAEGHMNOSTW12.json', '6');
INSERT INTO `pre_chapter` VALUES ('36', '1566890095', '\n																	第三十五章：请封世子\n															', '/book/20190827/afklpsuwxBFILSXZ0478.json', '6');
INSERT INTO `pre_chapter` VALUES ('37', '1566890096', '\n																	第三十六章：冷氏\n															', '/book/20190827/bfkmvwyzCEHJNQRSVY02.json', '6');
INSERT INTO `pre_chapter` VALUES ('38', '1566890097', '\n																	第三十七章：晴儿 倾儿\n															', '/book/20190827/abceghjqtvwCDKLNXZ03.json', '6');
INSERT INTO `pre_chapter` VALUES ('39', '1566890098', '\n																	第三十八章:闹事\n															', '/book/20190827/cforvxyAIJKLNRUVY469.json', '6');
INSERT INTO `pre_chapter` VALUES ('40', '1566890098', '\n																	第三十九章：处理\n															', '/book/20190827/abefgiuyEGIJLORTU237.json', '6');
INSERT INTO `pre_chapter` VALUES ('41', '1566890099', '\n																	第四十章：偶遇陆羽宁\n															', '/book/20190827/ablntyzADGJNOSTY0149.json', '6');
INSERT INTO `pre_chapter` VALUES ('42', '1566890100', '\n																	第四十一章:惩治\n															', '/book/20190827/aefklmopCFGKLOQS2589.json', '6');
INSERT INTO `pre_chapter` VALUES ('43', '1566890100', '\n																	第四十二章：皇帝来了\n															', '/book/20190827/dijstvwzDGIKLQTUXY02.json', '6');
INSERT INTO `pre_chapter` VALUES ('44', '1566890101', '\n																	第四十三章:住在长安宫\n															', '/book/20190827/adefgjklqwxzGHLNO025.json', '6');
INSERT INTO `pre_chapter` VALUES ('45', '1566890102', '\n																	第四十四章：沉睡\n															', '/book/20190827/hjkmoprzCIKNQRUVY125.json', '6');
INSERT INTO `pre_chapter` VALUES ('46', '1566890103', '\n																	第四十五章：事成\n															', '/book/20190827/aefghiqrtuCFIJLY1458.json', '6');
INSERT INTO `pre_chapter` VALUES ('47', '1566890104', '\n																	第四十六章:揭穿\n															', '/book/20190827/gklmnpyzACKLOSTUXZ79.json', '6');
INSERT INTO `pre_chapter` VALUES ('48', '1566890104', '\n																	第四十七章：皇后病\n															', '/book/20190827/adghiuwyzFGHNOQT2589.json', '6');
INSERT INTO `pre_chapter` VALUES ('49', '1566890105', '\n																	第四十八章;异宝现世\n															', '/book/20190827/hjlovwADEIKLPQSUWZ46.json', '6');
INSERT INTO `pre_chapter` VALUES ('50', '1567064842', '第一章  咫尺天涯', '/book/20190829/achimosxzCDKQRX01269.json', '7');
INSERT INTO `pre_chapter` VALUES ('51', '1567064843', '第二章  多梦的17岁', '/book/20190829/adfiklnyCJMNWY125678.json', '7');
INSERT INTO `pre_chapter` VALUES ('52', '1567064843', '第三章    精彩的18岁', '/book/20190829/befgikmtuABDFIQSTVZ1.json', '7');
INSERT INTO `pre_chapter` VALUES ('53', '1567064844', '第四章  无奈的19岁', '/book/20190829/aegilmovxyCFJKNRTW27.json', '7');
INSERT INTO `pre_chapter` VALUES ('54', '1567064844', '第五章 咫尺天涯的爱', '/book/20190829/moptwAJKSTVWXYZ23479.json', '7');
INSERT INTO `pre_chapter` VALUES ('55', '1567064845', '第六章   神秘助理', '/book/20190829/befhikmorBEIKLMSU235.json', '7');
INSERT INTO `pre_chapter` VALUES ('56', '1567064845', '第七章   绯闻满天', '/book/20190829/knrwxyABDILORTVWZ026.json', '7');
INSERT INTO `pre_chapter` VALUES ('57', '1567064846', '第八章   彼此祝福', '/book/20190829/dhjkpvwACDJLMRS01378.json', '7');
INSERT INTO `pre_chapter` VALUES ('58', '1567064846', '第九章     订婚典礼', '/book/20190829/efgikmorsvwEHJQUW369.json', '7');
INSERT INTO `pre_chapter` VALUES ('59', '1567064846', '第十章     重走青春路', '/book/20190829/egknpstyzADHKNQV5789.json', '7');
INSERT INTO `pre_chapter` VALUES ('60', '1567064847', '第十一章     说出你的爱', '/book/20190829/bfgijknpstwxzEHINSZ4.json', '7');
INSERT INTO `pre_chapter` VALUES ('61', '1567065260', '序幕 白帝城', '/book/20190829/ckmoqrwxABIKLNPTZ156.json', '8');
INSERT INTO `pre_chapter` VALUES ('62', '1567065262', '第一幕 卡塞尔之门', '/book/20190829/agmqtyzACGJKNQUVWY08.json', '8');
INSERT INTO `pre_chapter` VALUES ('63', '1567065263', '第二幕 神秘的学院', '/book/20190829/afhjswyzBCDHIPSXYZ04.json', '8');
INSERT INTO `pre_chapter` VALUES ('64', '1567065265', '第三幕 自由一日', '/book/20190829/abcimovwyzCDEFOQRTW7.json', '8');
INSERT INTO `pre_chapter` VALUES ('65', '1567065266', '第四幕 考试之前', '/book/20190829/fnoruwxzACGNPRTXZ357.json', '8');
INSERT INTO `pre_chapter` VALUES ('66', '1567065268', '第五幕 青铜城', '/book/20190829/akrvzADHIJKLMQVZ2379.json', '8');
INSERT INTO `pre_chapter` VALUES ('67', '1567065270', '第六幕 龙影', '/book/20190829/abefjknwyBFGMOVZ3468.json', '8');
INSERT INTO `pre_chapter` VALUES ('68', '1567065272', '第七幕 星与花', '/book/20190829/abcdfjlnzBGLNOVXZ479.json', '8');
INSERT INTO `pre_chapter` VALUES ('69', '1567065274', '第八幕 兄弟', '/book/20190829/cdeimnrxCHIJMNQUZ038.json', '8');
INSERT INTO `pre_chapter` VALUES ('70', '1567065276', '第九幕 龙墓', '/book/20190829/bcdekpvCDKMPSXYZ3568.json', '8');
INSERT INTO `pre_chapter` VALUES ('71', '1567065278', '第十幕 龙墓', '/book/20190829/adefiprxzDFGHJPSU679.json', '8');
INSERT INTO `pre_chapter` VALUES ('72', '1567065280', '第十一幕 七宗罪', '/book/20190829/bfijopqsFGJKNOPRSUZ4.json', '8');

-- ----------------------------
-- Table structure for pre_config
-- ----------------------------
DROP TABLE IF EXISTS `pre_config`;
CREATE TABLE `pre_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_config
-- ----------------------------
INSERT INTO `pre_config` VALUES ('1', 'webname', '名称', '小说网');
INSERT INTO `pre_config` VALUES ('2', 'logo', 'logo', '/uploads/20190904200654acegimsAEHLMPRX.png');
INSERT INTO `pre_config` VALUES ('3', 'keywords', '关键字', '关键字');
INSERT INTO `pre_config` VALUES ('4', 'description', '描述', '描述');
INSERT INTO `pre_config` VALUES ('5', 'copyright', '版权', '版权');

-- ----------------------------
-- Table structure for pre_flag
-- ----------------------------
DROP TABLE IF EXISTS `pre_flag`;
CREATE TABLE `pre_flag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_flag
-- ----------------------------
INSERT INTO `pre_flag` VALUES ('1', 'new', '最新书籍');
INSERT INTO `pre_flag` VALUES ('2', 'hot', '网友推荐');
INSERT INTO `pre_flag` VALUES ('3', 'top', '书籍置顶');

-- ----------------------------
-- Table structure for pre_website
-- ----------------------------
DROP TABLE IF EXISTS `pre_website`;
CREATE TABLE `pre_website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `node` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_website
-- ----------------------------
INSERT INTO `pre_website` VALUES ('1', '纵横', 'zongheng.php');
INSERT INTO `pre_website` VALUES ('2', '云中书库', 'yunxs.php');
INSERT INTO `pre_website` VALUES ('3', '17k小说', '17k.php');
