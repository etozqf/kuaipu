<?php
ini_set('error_reporting', E_ERROR | E_PARSE);
ini_set('display_errors', 0);	// 是否开启错误日志显示
define('XHPROF_DEBUG', 0);
define('LOG_ERROR', TRUE);      // 是否记录致命错误

define('DOMAIN', 'cmstop.loc');
define('ADMIN_URL', 'http://admin.cmstop.loc/');   //后台网址
define('APP_URL', 'http://app.cmstop.loc/');       //动态访问网址
define('IMG_URL', 'http://img.cmstop.loc/');       //公共图片、JS、CSS网址
define('UPLOAD_URL', 'http://upload.cmstop.loc/'); //附件网址
define('WWW_URL', 'http://www.cmstop.loc/');       //静态网页网址
define('WAP_URL', 'http://wap.cmstop.loc/');       //WAP网址
define('SPACE_URL', 'http://space.cmstop.loc/');       //专栏网址
define('API_URL', 'http://api.cmstop.loc/');       //接口网址
define('MOBILE_URL', 'http://m.cmstop.loc/');      //移动网址
define('MOBILE_PROTOCOL', 'cmstop');                //移动端注册的协议

define('FW_PATH', ROOT_PATH.'framework'.DS);
define('CACHE_PATH', ROOT_PATH.'data'.DS.'cache'.DS);
define('PUBLIC_PATH', ROOT_PATH.'public'.DS);
define('WWW_PATH', PUBLIC_PATH.'www'.DS);
define('UPLOAD_PATH', PUBLIC_PATH.'upload'.DS);
define('WAP_PATH', PUBLIC_PATH.'wap'.DS);
define('IMG_PATH', PUBLIC_PATH.'img'.DS);
define('MOBILE_PATH', PUBLIC_PATH.'mobile'.DS);

define('CT_DEBUG', false);
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' && CT_DEBUG)
{
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 0);
}

/*允许上传的文件类型 ，开始和末尾不加|，*代表任意格式  */
//define('UPLOAD_FILE_EXTS','gif|jpg|jpeg|bmp|png|txt|zip|rar|doc|docx|xls|ppt|pdf');
define('UPLOAD_FILE_EXTS','*');

//constants
define('MALE',			1);
define('FEMALE',		2);

//message
define('MESSAGE_NEW',			1);
define('MESSAGE_READ',			2);
define('MESSAGE_REPLIED',		3);
define('MESSAGE_DELETE',		4);

//page
define('FRAG_AUTO',				1);
define('FRAG_FEED',				2);
define('FRAG_MANUL',			3);
define('FRAG_HTML',				4);

//page state
define('PAGE_LOCK',				1);
define('PAGE_UNLOCK',			1);
define('PAGE_DELETE',			1);
define('SECTION_PUBLISHED', 	1);

//explain rows
define('EXPLAIN_ROWS',          20);
define('EXPLAIN_PUBLISHED',     120);
