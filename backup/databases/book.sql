/*
 Navicat Premium Data Transfer

 Source Server         : dancefunk
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : book

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 22/08/2019 10:57:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of pre_admin
-- ----------------------------
BEGIN;
INSERT INTO `pre_admin` VALUES (1, 'admin', 'e64e3f59b3fb352c38b8fa36b1b0b999', 'gmFHOPR7]~', NULL, NULL, 1231231);
COMMIT;

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
  `cateid` int(10) unsigned DEFAULT NULL COMMENT '分类外键',
  PRIMARY KEY (`id`),
  KEY `key_book_cateid` (`cateid`) USING BTREE,
  CONSTRAINT `foreign_book_cateid` FOREIGN KEY (`cateid`) REFERENCES `pre_cate` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='书籍表';

-- ----------------------------
-- Table structure for pre_cate
-- ----------------------------
DROP TABLE IF EXISTS `pre_cate`;
CREATE TABLE `pre_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of pre_cate
-- ----------------------------
BEGIN;
INSERT INTO `pre_cate` VALUES (1, '武侠');
INSERT INTO `pre_cate` VALUES (2, '言情');
COMMIT;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='章节表';

SET FOREIGN_KEY_CHECKS = 1;
