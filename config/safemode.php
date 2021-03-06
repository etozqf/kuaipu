<?php
return array(
    'status' => 1,
    'admin_onlyone' => 1,
    'message' => '出于安全考虑，系统不允许您进行此操作',
    'aca' => array(
        'system/template/add' => 'post',
        'system/template/edit' => 'post',
        'system/template/delete' => '*',
        'system/template/preview' => '*',
        'system/template/upload' => '*',

        'system/file/editunsafe' => '*',
        'system/file/delunsafe' => '*',
        'system/file/download' => '*',

        'page/page/delete' => '*',
        'page/page/preview' => '*',
        'page/section/add' => 'post',
        'page/section/preview' => 'post',
        'page/section/property' => 'post',

        'special/online/addTemplate' => '*',
        'special/online/editTemplate' => 'post',
        'special/online/addWidget' => 'post',
        'special/online/useWidget' => 'post',
        
	// 后台-工具-系统安全-域名安全
        'safe/domain/index' => '*',
        'safe/domain/page' => '*',
        'safe/domain/cron' => '*',

	// 后台-工具-系统安全-登陆日志
        'safe/log/index' => '*',
        'safe/log/page' => '*',
        'safe/log/delete' => '*',

	// 后台-工具-系统安全-木马扫描
        'safe/trojan/update_trojan' => '*',
        'safe/trojan/scan' => '*',
        'safe/trojan/stopTest' => '*',
        'safe/trojan/pingTest' => '*',
        'safe/trojan/index' => '*',

	// 后台-工具-系统安全-文件校验
        'safe/verify/index' => '*',
        'safe/verify/page' => '*',
        'safe/verify/enable' => '*',
        'safe/verify/addition' => '*',
        'safe/verify/del' => '*',
        'safe/verify/check' => '*',
        'safe/verify/create_filemd5' => '*',
        'safe/verify/view' => '*',
    ),
);
