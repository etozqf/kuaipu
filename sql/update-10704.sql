SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;
SET time_zone = "+00:00";

-- 会员是否进行了手机号认证
ALTER TABLE cmstop_member_detail ADD `mobileauth` tinyint(1);
UPDATE cmstop_member_detail SET mobileauth=1 WHERE `userid`=1 AND `name`='cmstop.com';
replace into cmstop_setting(`app`, `var`, `value`) values('cloud','mobile_verification_info','{"key":"","message":"\u6b22\u8fce\u60a8\u6ce8\u518c\uff0c\u60a8\u7684\u9a8c\u8bc1\u7801\u4e3a\uff1a{{code}}\uff0c\u8bf7\u4e0d\u8981\u6cc4\u9732\u3010\u5317\u4eac\u601d\u62d3\u5408\u4f17\u3011","requestURL":"https:\/\/sms-api.luosimao.com\/v1\/send.json"}');