ALTER TABLE  `cmstop_mobile_content` ADD  `style` varchar(10) default NULL COMMENT '模型列表样式';
ALTER TABLE  `cmstop_mobile_content` ADD  `isdescription` int(1) unsigned default '1' COMMENT '是否显示简介';

ALTER TABLE  `cmstop_member` CHANGE  `username`  `username` char(15) NOT NULL;

ALTER TABLE  `cmstop_mobile_app` ADD  `model` varchar(10) NOT NULL default 'drawer' COMMENT '模板风格';

ALTER TABLE  `cmstop_mobile_app` DROP INDEX  `name` , ADD UNIQUE  `name` (  `name` ,  `type` ,  `version` , `model`);
ALTER TABLE  `cmstop_mobile_app` DROP INDEX  `url` ,ADD UNIQUE  `url` (  `url` ,  `type` ,  `version` , `model`);

INSERT INTO `cmstop_mobile_app` VALUES ('33', '新闻', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_xw_btn.png', 'app:news', '0', '1', '1', '1', '1', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('34', '组图', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_tps_btn.png', 'app:picture', '0', '1', '0', '1', '4', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('35', '视频', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_sp_btn.png', 'app:video', '0', '1', '0', '1', '2', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('36', '专题', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_zt_btn.png', 'app:special', '0', '1', '0', '0', '8', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('38', '报料', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_bl_btn.png', 'app:baoliao', '0', '1', '0', '0', '2', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('39', '二维码', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_ewm_btn.png', 'app:qrcode', '0', '1', '0', '0', '6', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('40', '投票', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_tp_btn.png', 'app:vote', '0', '1', '0', '0', '9', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('41', '活动', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_hd_btn.png', 'app:activity', '0', '1', '0', '0', '8', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('42', '调查', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_dc_btn.png', 'app:survey', '0', '1', '0', '0', '26', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('44', '直播', 'http://m.cmstop.loc/templates/default/app/images/icon/mobile/2.0/app_zb.png', 'app:live', '0', '0', '0', '0', '5', 'mobile', '3.0', 'drawer');
INSERT INTO `cmstop_mobile_app` VALUES ('46', '新闻', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_xw_btn.png', 'app:news', '0', '1', '1', '1', '1', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('47', '图片', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_tps_btn.png', 'app:picture', '0', '1', '0', '1', '3', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('48', '视频', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_sp_btn.png', 'app:video', '0', '1', '0', '1', '2', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('49', '专题', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_zt_btn.png', 'app:special', '0', '1', '0', '0', '11', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('51', '报料', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_bl_btn.png', 'app:baoliao', '0', '1', '0', '0', '7', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('52', '二维码', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_ewm_btn.png', 'app:qrcode', '1', '1', '0', '0', '1', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('53', '投票', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_tp_btn.png', 'app:vote', '0', '1', '0', '0', '14', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('54', '活动', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_hd_btn.png', 'app:activity', '0', '1', '0', '0', '13', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('55', '调查', 'http://m.cmstop.dev/templates/default/app/images/icon/mobile/2.0/app_dc_btn.png', 'app:survey', '0', '1', '0', '0', '4', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('57', '直播', 'http://m.cmstop.loc/templates/default/app/images/icon/mobile/2.0/app_zb.png', 'app:live', '0', '0', '0', '0', '1', 'mobile', '3.0', 'bar');
INSERT INTO `cmstop_mobile_app` VALUES ('58', '直播', 'http://m.cmstop.loc/templates/default/app/images/icon/mobile/2.0/app_zb.png', 'app:live', '0', '0', '0', '1', '3', 'pad', '1.0', 'drawer');

INSERT INTO `cmstop_menu` VALUES ('212', '171', '168,171', null, '编辑考核', '?app=mobile&controller=stat_examine&action=index', null, '3');


DELETE FROM `cmstop_mobile_app` WHERE `name`='微博' AND `url`='app:weibo';

CREATE TABLE `cmstop_baoliao` (
  `baoliaoid` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(120) NOT NULL,
  `content` mediumtext,
  `image` varchar(500) default NULL,
  `video` varchar(500) default NULL,
  `topicid` mediumint(8) unsigned default NULL,
  `pv` mediumint(8) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned default NULL,
  `name` varchar(40) default NULL,
  `email` varchar(255) default NULL,
  `phone` varchar(20) default NULL,
  `qq` varchar(255) default NULL,
  `address` varchar(200) default NULL,
  `createtime` int(10) unsigned NOT NULL,
  `ip` int(10) NOT NULL,
  `reply` tinyint(1) unsigned NOT NULL default '0',
  `replytext` mediumtext,
  `replytime` int(10) unsigned NOT NULL default '10',
  `related` varchar(500) default NULL,
  `otherinfo` text COMMENT '爆料人其他信息',
  `location` varchar(255) default NULL COMMENT '定位地址',
  PRIMARY KEY  (`baoliaoid`),
  KEY `topicid` (`topicid`),
  KEY `reply` (`reply`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

CREATE TABLE `cmstop_mobile_content_classify` (
  `contentid` mediumint(8) unsigned NOT NULL COMMENT '内容ID',
  `classifyid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  PRIMARY KEY  (`contentid`,`classifyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

UPDATE `cmstop_setting` SET `value`='{"id":"drawer","style":{"nav":"#0a78cd","button0":"#0a78cd","button1":"#0a78cd","background":{"0a78cd":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/00\/1242x2208.png","38aa2f":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/09\/1242x2208.png","2fbcab":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/02\/1242x2208.png","ff4400":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/03\/1242x2208.png","fabe00":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/04\/1242x2208.png","303132":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/05\/1242x2208.png","c80505":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/07\/1242x2208.png","682878":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/08\/1242x2208.png","ff7373":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/10\/1242x2208.png","othercolor":"http:\/\/m.cmstop.dev\/templates\/default\/app\/images\/background\/10\/1242x2208.png"}},"action":"save"}' WHERE `app`='mobile' AND `var`='style'
