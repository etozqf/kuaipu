<?php

include_once 'lib/ads.php';

/**
 * CmsTop广告平台
 *
 * 管理地址：http://adm.cmstop.cn
 */
$adsInfo = array(
    'company_name' => '', // 公司名称，如：北京思拓合众科技有限公司
    'company_url' => '', // 公司主页，如：http://www.cmstop.com
    'user_email' => '', // 管理员帐号，如：admin@cmstop.com，用于登录广告系统
    'email_cc' => '', // 邮件抄送, 多个帐号以逗号隔开
    'user_password' => '' // 管理密码
);

try {
    $adsClient = new AdsClient($adsInfo);
    $ret = $adsClient->install();
    echo 'success';
} catch (Exception $e) {
    echo 'failed: ' . $e->getMessage();
}