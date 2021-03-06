<?php
function modelid($alias)
{
	static $_modelid;
	if (!isset($_modelid[$alias]))
	{
		$model = table('model');
		foreach ($model as $modelid=>$m)
		{
			if (array_search($alias, $m))
			{
				$_GET['modelid'] = $_REQUEST['modelid'] = $_modelid[$alias] = $modelid;
				break;
			}
		}
	}
	return $_modelid[$alias];
}

function channel()
{
	static $_channel;
	if (!isset($_channel))
	{
    	$_channel = array();
    	$category = table('category');
    	foreach ($category as $catid=>$r)
    	{
    		if (empty($r['parentid'])) $_channel[$r['catid']] = $r;
    	}
    	uasort($_channel, 'category_sort');
	}
	return $_channel;
}

function subcategory($catid, $tree = false, & $subcategory = array())
{
	static $_category;
	if (!isset($_category)) $_category = table('category');
	foreach ($_category as $id=>$r)
	{
		if ($r['parentid'] == $catid)
		{
			$subcategory[$r['catid']] = $r;
			if ($tree && $r['childids']) subcategory($r['catid'], $tree, $subcategory);
		}
	}
	uasort($subcategory, 'category_sort');
	return $subcategory;
}

function category_sort($a, $b)
{
    if ($a['sort'] == $b['sort']) return ($a['catid'] > $b['catid']);
    return ($a['sort'] < $b['sort']) ? -1 : 1;
}

/**
 * 对栏目 ID 进行规范化处理，去除无效的和重复的，同时如果有子栏目，子栏目 ID 会增加进去，可选返回栏目层级关系
 *
 * @param array|string $categoryids 要处理的栏目 ID，可以为逗号分隔的字符串或一维栏目 ID
 * @param bool $parents 是否返回父栏目 ID，适合需要展现栏目层级关系的地方，如仅选择了部分 3 级或 4 级栏目，需要展示栏目导航的情况
 * @param bool $implode 返回的结果是否使用逗号连结
 * @return array|string 数组或字符串格式的栏目 ID
 */
function normalize_categoryids($categoryids = array(), $parents = false, $implode = true)
{
    if (! is_array($categoryids))
    {
        $categoryids = explode(',', $categoryids);
    }

    $result = array();

    if ($categoryids)
    {
        $categorys = table('category');
        foreach ($categoryids as $categoryid)
        {
            if (isset($categorys[$categoryid]))
            {
                $result[] = $categoryid;

                if ($parents)
                {
                    $parentids = value($categorys[$categoryid], 'parentids');
                    if ($parentids)
                    {
                        $result = array_merge($result, array_filter(explode(',', $parentids)));
                    }
                }

                $childids = value($categorys[$categoryid], 'childids');
                if ($childids)
                {
                    $result = array_merge($result, array_filter(explode(',', $childids)));
                }
            }
        }
        unset($categorys);
        $result = array_unique($result);
    }

    return $implode ? implode_ids($result) : $result;
}

function subdepartment($departmentid)
{
	$data = array();
	$department = table('department');
	foreach ($department as $id=>$r)
	{
		if ($r['parentid'] == $departmentid) $data[$r['departmentid']] = $r;
	}
	return $data;
}

function online()
{
	static $online;
	if (isset($online)) return $online;
	$online = false;

    if (defined('IN_API'))
    {
        switch (IN_API) {
            case 1:
                $api_instance = new api_controller_abstract(NULL);
                break;
            case 2:
                $api_instance = new api_mobile_controller_abstract(NULL);
                break;
        }
        if (isset($api_instance))
        {
            $online = $api_instance->online();
            return $online;
        }
    }

	$cookie = factory::cookie();
	if (defined('INTERNAL'))
	{
		list($userid, $username, $groupid) = loader::model('admin/admin', 'system')->internalLogin();
	}
    elseif (defined('IN_ADMIN') && IN_ADMIN)
    {
        $str = $cookie->get('admin_auth');
        list($userid, $username, $groupid, $userAgent, $ip) = explode("\t", str_decode($str, config('config', 'admin_authkey')));
		if (!is_numeric($userid) || !is_numeric($groupid)) {
            return false;
        }

        if (IP != '127.0.0.1' && (IP != $_SERVER['SERVER_ADDR'])) {
            if ($ip != IP || !(stristr($_SERVER['HTTP_USER_AGENT'], ' flash') || $userAgent == md5($_SERVER['HTTP_USER_AGENT']))) {
                return false;
            }
        }
    }
	elseif (($str = $cookie->get('auth')) || ($str = value($_POST, 'userauth')))
	{
        list($userid, $username, $groupid, $userAgent, $ip) = explode("\t", str_decode($str, config('config', 'authkey')));
		if (!is_numeric($userid) || !is_numeric($groupid)) {
            return false;
        }

        if ($ip != IP || !(stristr($_SERVER['HTTP_USER_AGENT'], ' flash') || $userAgent == md5($_SERVER['HTTP_USER_AGENT']))) {
            return false;
        }
	}
	else
	{
		return false;
	}
	if ($groupid == 1)
	{
		$r = factory::db()->get('SELECT roleid, departmentid, disabled FROM #table_admin WHERE userid=?', array($userid));
		$roleid = $r['roleid'];
		$departmentid = $r['departmentid'];
		require_once ROOT_PATH.'apps/system/lib/priv.php';
		priv::cache($userid, $roleid);
		$online = compact('userid', 'username', 'groupid', 'roleid', 'departmentid');
	}
	else
	{
		$online = compact('userid', 'username', 'groupid');
	}
	return $online;
}

function username($userid)
{
	static $_usernames;
	if (!isset($_usernames[$userid]))
	{
		$db = factory::db();
		$r = $db->get("SELECT `username` FROM `#table_member` WHERE `userid`=?", array($userid));
		$_usernames[$userid] = $r ? $r['username'] : false;
	}
	return $_usernames[$userid];
}

function userid($username)
{
	static $_userids;
	if (!isset($_userids[$username]))
	{
		$db = factory::db();
		$r = $db->get("SELECT `userid` FROM `#table_member` WHERE `username`=?", array($username));
		$_userids[$username] = $r ? $r['userid'] : false;
	}
	return $_userids[$username];
}

function space_url($spaceid)
{
	static $_spaces;
	if (!isset($_spaces[$spaceid]))
	{
		$db = factory::db();
		$r = $db->get("SELECT `alias` FROM `#table_space` WHERE `spaceid`=?", array($spaceid));
		$_spaces[$spaceid] = $r ? $r['alias'] : false;
	}
	return SPACE_URL.$_spaces[$spaceid];
}

function content_url($contentid, $modelid = null)
{
	$app = table('model', $modelid, 'alias');
	return "?app=$app&controller=$app&action=view&contentid=$contentid";
}

function description($contentid, $modelid = null)
{
	$contentid = intval($contentid);
	$db = factory::db();
	if (is_null($modelid)) 
	{
		$r = $db->get("SELECT `modelid` FROM `#table_content` WHERE `contentid`=?", array($contentid));
		if (!$r) return false;
		$modelid = $r['modelid'];
	}
	else 
	{
		$modelid = intval($modelid);
	}
	$model = table('model', $modelid, 'alias');
	$r = $db->get("SELECT `description` FROM `#table_$model` WHERE `contentid`=?", array($contentid));
	return $r ? $r['description'] : false;
}

/**
 * 输出不同模型、不同状态的右键菜单、用于内容列表
 * 需要读取配置文件,请参考app_dir('interview').'config/right_menu.php'文件配置
 * 
 * @param string $model	模型英文名
 * @param int $status	内容状态
 * @param int $catid	分类id
 * @return html $menu		html右键菜单
 */
function right_menu($model='article', $status=6, $catid=0)
{
	static $workflow;
	if(!is_file(app_dir($model).'config/right_menu.php')) 
	{
		return;
	}
	$config = @include (app_dir($model).'config/right_menu.php');
	//是否需要工作流审核
	if(!is_int($workflow)) {
		$roleid = $GLOBALS['cmstop']->roleid;
		$workflowid = table('category', $catid, 'workflowid');
		if($roleid >= 3 && $workflowid) {
			$workflow = 1;
		}else {
			$workflow = 0;
		}
	}
	//输出菜单项
	$menu = "\r\n".'<ul id="right_menu_'.$model.'" class="contextMenu">'."\r\n";
	foreach($config AS $r) {
		//１.权限过滤
		$app = $ctrl = $model;
		$action = $r['class'];
		if($r['aca'])
		{
			$aca = array_reverse(explode('/', $r['aca']));
			$action = $aca[0];
			$aca[1] && $ctrl = $aca[1];
			$aca[2] && $app = $aca[2];
		}
		if(!priv::aca($app,$ctrl,$action)) continue;
		
		//２.状态过滤
		if(isset($r['status']))
		{
			if($r['status'][0] == '!')
			{
				$statusArr = explode(',', substr($r['status'], 1));
				if(in_array($status, $statusArr)) continue;
			}else{
				$statusArr = explode(',', $r['status']);
				if(!in_array($status, $statusArr)) continue;
			}
		}

		//3.工作流过滤
		if($workflow)
		{
			if($status == 1 && $r['class'] == 'publish') continue;
			if($status == 2 && ($r['class'] == 'pass' || $r['class'] == 'reject')) continue;
		}else {
			if($status == 1 && $r['class'] == 'publish' && $catid == 0) continue;
			if($status == 2 && $r['class'] == 'approve') continue;
		}
		
		if(!$r['handler']) $r['handler'] = 'content.'.$r['class'];
		if($r['separator']) $r['class'] .= ' separator';
		$menu .= "\t".'<li class="'.$r['class'].'"><a href="#'.$r['handler'].'">'.$r['text'].'</a></li>'."\r\n";
	}
	$menu .= "</ul>\r\n";
	
	return $menu;
}

/**
 * 获取扩展字段值
 *
 * @param $contentid  文章ID
 * @param $key	所需字段 如不填则返回该ID的所有字段值
 * @return array | sting
 */
function field($contentid, $key = null)
{
	$data = unserialize(table('content_meta', $contentid, 'data'));
	foreach($data as $num => $vs)
	{
		if($key && isset($vs[$key])) return $vs[$key];
		foreach($vs as $k => $v)
		{
			$r[$k] = $v;
		}
	}
	return $r;
}

/**
 * 获取指定图片的原始图片链接
 *
 * 注意：如果指定了 $full 参数，则结果一定是绝对地址，不管原始图片存在与否
 *
 * @param $image_url 要获取的图片，URL 格式，兼容绝对和相对（UPLOAD_URL）的情况
 * @param bool $full 是否返回绝对地址
 * @return string 成功则返回图片的原始链接，失败时返回指定图片的相对或绝对地址（根据 $full 参数指定）
 */
function image_origin_url($image_url, $full = true)
{
    $image_url = trim($image_url);
    if (! $image_url)
    {
        return $image_url;
    }

    $prefix = 'orig_';
    $regex = '#^' . preg_quote(UPLOAD_URL) . '#i';
    $isfull = stripos($image_url, '://') !== false;

    // 站外图片
    if (! $isfull || preg_match($regex, $image_url))
    {
        $localpath = preg_replace($regex, '', $image_url);
        $pathinfo = pathinfo($localpath);
        $guesspath = $pathinfo['dirname'] . DS . $prefix . $pathinfo['basename'];

        // 原始文件存在
        if (is_file(UPLOAD_PATH . $guesspath))
        {
            return ($full ? UPLOAD_URL : '') . str_replace(array('\\', '//'), '/', $guesspath);
        }
    }

    // 未找到原始文件
    return ($isfull ? '' : UPLOAD_URL) . $image_url;
}

/**
 * 获取图片的原始图片路径
 *
 * 推荐以如下的方式使用该函数：
 * @code
 *
 * $origin_path = image_origin_path($content['thumb']);
 * if ($origin_path)
 * {
 *     // 正常处理逻辑
 *     // $origin_path 类似 /www/cmstop/public/upload/2012/0315/orig_1330506918452.jpg
 * }
 * else
 * {
 *     // 处理原始图片不存在的情况
 * }
 *
 * @endcode
 *
 * @param $image_url 要获取的图片，URL 格式，兼容绝对和相对（UPLOAD_URL）的情况
 * @return bool|string 成功时返回原始图片路径，失败时返回 false
 */
function image_origin_path($image_url)
{
    $image_url = trim($image_url);
    if (! $image_url)
    {
        return $image_url;
    }

    $prefix = 'orig_';
    $regex = '#^' . preg_quote(UPLOAD_URL) . '#i';
    $isfull = stripos($image_url, '://') !== false;

    // 站外图片
    if (! $isfull || preg_match($regex, $image_url))
    {
        $localpath = preg_replace($regex, '', $image_url);
        $pathinfo = pathinfo($localpath);
        $guesspath = $pathinfo['dirname'] . DS . $prefix . $pathinfo['basename'];

        // 原始文件存在
        if (is_file(UPLOAD_PATH . $guesspath))
        {
            return UPLOAD_PATH . $guesspath;
        }
    }

    return false;
}

/**
 * 移除字符串中可能存在的的 XSS 字符串
 *
 * @link http://doxygen.frozenkiwi.com/typo3/html/d4/dee/RemoveXSS_8php_source.html#l00036
 * @param $val 要过滤的字符串
 * @param string $replaceString XSS 字符串的替换字符
 * @return mixed 替换结果
 */
function remove_xss($val, $replaceString = '<x>')
{
    // don't use empty $replaceString because then no XSS-remove will be done
    if ($replaceString == '')
    {
        $replaceString = '<x>';
    }
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
    $searchHexEncodings = '/&#[xX]0{0,8}(21|22|23|24|25|26|27|28|29|2a|2b|2d|2f|30|31|32|33|34|35|36|37|38|39|3a|3b|3d|3f|40|41|42|43|44|45|46|47|48|49|4a|4b|4c|4d|4e|4f|50|51|52|53|54|55|56|57|58|59|5a|5b|5c|5d|5e|5f|60|61|62|63|64|65|66|67|68|69|6a|6b|6c|6d|6e|6f|70|71|72|73|74|75|76|77|78|79|7a|7b|7c|7d|7e);?/ie';
    $searchUnicodeEncodings = '/&#0{0,8}(33|34|35|36|37|38|39|40|41|42|43|45|47|48|49|50|51|52|53|54|55|56|57|58|59|61|63|64|65|66|67|68|69|70|71|72|73|74|75|76|77|78|79|80|81|82|83|84|85|86|87|88|89|90|91|92|93|94|95|96|97|98|99|100|101|102|103|104|105|106|107|108|109|110|111|112|113|114|115|116|117|118|119|120|121|122|123|124|125|126);?/ie';
    while (preg_match($searchHexEncodings, $val) || preg_match($searchUnicodeEncodings, $val))
    {
        $val = preg_replace($searchHexEncodings, "chr(hexdec('\\1'))", $val);
        $val = preg_replace($searchUnicodeEncodings, "chr('\\1')", $val);
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra_tag = array('applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra_attribute = array('style', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra_protocol = array('javascript', 'vbscript', 'expression');

    //remove the potential &#xxx; stuff for testing
    $val2 = preg_replace('/(&#[xX]?0{0,8}(9|10|13|a|b);)*\s*/i', '', $val);
    $ra = array();

    foreach ($ra1 as $ra1word)
    {
        //stripos is faster than the regular expressions used later
        //and because the words we're looking for only have chars < 0x80
        //we can use the non-multibyte safe version
        if (stripos($val2, $ra1word ) !== false )
        {
            //keep list of potential words that were found
            if (in_array($ra1word, $ra_protocol))
            {
                $ra[] = array($ra1word, 'ra_protocol');
            }
            if (in_array($ra1word, $ra_tag))
            {
                $ra[] = array($ra1word, 'ra_tag');
            }
            if (in_array($ra1word, $ra_attribute))
            {
                $ra[] = array($ra1word, 'ra_attribute');
            }
            //some keywords appear in more than one array
            //these get multiple entries in $ra, each with the appropriate type
        }
    }
    //only process potential words
    if (count($ra) > 0)
    {
        // keep replacing as long as the previous round replaced something
        $found = true;
        while ($found == true)
        {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++)
            {
                $pattern = '';
                for ($j = 0; $j < strlen($ra[$i][0]); $j++)
                {
                    if ($j > 0)
                    {
                        $pattern .= '((&#[xX]0{0,8}([9ab]);)|(&#0{0,8}(9|10|13);)|\s)*';
                    }
                    $pattern .= $ra[$i][0][$j];
                }
                //handle each type a little different (extra conditions to prevent false positives a bit better)
                switch ($ra[$i][1])
                {
                    case 'ra_protocol':
                        //these take the form of e.g. 'javascript:'
                        $pattern .= '((&#[xX]0{0,8}([9ab]);)|(&#0{0,8}(9|10|13);)|\s)*(?=:)';
                        break;
                    case 'ra_tag':
                        //these take the form of e.g. '<SCRIPT[^\da-z] ....';
                        $pattern = '(?<=<)' . $pattern . '((&#[xX]0{0,8}([9ab]);)|(&#0{0,8}(9|10|13);)|\s)*(?=[^\da-z])';
                        break;
                    case 'ra_attribute':
                        //these take the form of e.g. 'onload='  Beware that a lot of characters are allowed
                        //between the attribute and the equal sign!
                        $pattern .= '[\s\!\#\$\%\&\(\)\*\~\+\-\_\.\,\:\;\?\@\[\/\|\\\\\]\^\`]*(?==)';
                        break;
                }
                $pattern = '/' . $pattern . '/i';
                // add in <x> to nerf the tag
                $replacement = substr_replace($ra[$i][0], $replaceString, 2, 0);
                // filter out the hex tags
                $val = preg_replace($pattern, $replacement, $val);
                if ($val_before == $val)
                {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }
    }

    return $val;
}

/**
 * 获取应用配置
 *
 * 作用同 config() 函数类似，区别在于 config() 函数获取系统配置，该函数获取应用配置。
 * 应用的配置保存在应用目录下的 config/ 目录，可能为一个或多个文件。
 *
 * 使用时，配置名支持 . 分隔符，如：
 * @code
 *
 * // 将返回 member_fields.php 这整个数组
 * $var = app_config('system', 'member_fields');
 *
 * // 将返回 member_fields.php 数组中的 userid 元素
 * $var = app_config('system', 'member_fields.userid');
 *
 * @endcode
 *
 * @param $app 应用名
 * @param null $key 配置名
 * @param null $default 要获取的配置不存在时的默认值
 * @return mixed|null 返回值
 */
function app_config($app, $key, $default = NULL)
{
    static $_cache = array();

    if (strpos($key, '.') === FALSE)
    {
        $config = $key;
        $key = NULL;
    }
    else
    {
        list($config, $key) = explode('.', $key);
    }

    if (! isset($_cache[$app]) || ! isset($_cache[$app][$config]))
    {
        $config_file = app_dir($app) . 'config' . DS . $config . '.php';
        if (is_file($config_file))
        {
            $_cache[$app][$config] = (array) @include_once $config_file;
        }
        else
        {
            $_cache[$app][$config] = array();
        }
    }

    if ($key === NULL)
    {
        if ($_cache[$app][$config])
        {
            return $_cache[$app][$config];
        }
        return $default;
    }

    if ($_cache[$app][$config][$key])
    {
        return $_cache[$app][$config][$key];
    }
    return $default;
}

/**
 * 使用队列发送邮件
 *
 * @param $to 要发送到的地址
 * @param $subject 邮件主题
 * @param $content 邮件正文
 * @param $from null 发件人，在使用需要验证的 SMTP 方式发送邮件时不建议传递该值，因为
 *                   实际发件人和声明的发件人不同会很容易被判为垃圾邮件，导致邮件发送失败
 * @return mixed 发送成功或失败
 */
function send_email($to, $subject, $content, $from = null)
{
    $queue = factory::queue('mail');
    $setting = (array) setting('system', 'mail');

    // 使用需要认证的 SMTP 方式发送邮件，但未配置 SMTP 服务器
    if (value($setting, 'mailer') == 2 && ! value($setting, 'smtp_host'))
    {
        return false;
    }

    $params = array(
        'from' => is_null($from) ? $setting['from'] : $from,
        'to' => $to,
        'subject' => $subject,
        'content' => $content
    );
    return $queue->add($params);
}

/**
 * 生成指定内容和位置上的内容挂件
 *
 * @param $contentid 内容ID
 * @param $place 挂件位置
 * @return string 内容挂件的 SSI 引用代码
 */
function addon_place($contentid, $place)
{
    if (isset($contentid) && isset($place))
    {
        loader::import('lib.addonEngine', app_dir('addon'));
        return addonEngine::renderPlace($contentid, $place);
    }
    return '';
}

/**
 * 生成指定内容对应的内容挂件所需的资源
 *
 * @param $contentid 内容ID
 * @return string 内容挂件所需资源
 */
function addon_resource($contentid)
{
    loader::import('lib.addonEngine', app_dir('addon'));
    return addonEngine::renderResource($contentid);
}

/**
 * 将文件后缀转换为 cmstop.uploader 所需的文件类型限制
 *
 * @param $exts 要转换的文件后缀，如 php 或 php,js,css 或 .php,.js,.css 等
 * @return string 形如  *.* 或 *.php 或 *.php;*.js;*.css
 */
function ext_to_uploader_limit($exts)
{
    $limit = array();
    if ($exts)
    {
        foreach (explode(',', $exts) as $ext)
        {
            $ext = trim($ext);
            if (($pos = strpos($ext, '.')) !== false) $ext = substr($ext, $pos + 1);
            $limit[] = '*.'.$ext;
        }
    }
    if (!count($limit)) return '*.*';
    return implode(';', $limit);
}

/**
 * 生成区块更多列表链接
 *
 * @param $sectionid 区块ID
 * @return string 列表的绝对 URL
 */
function section_list_url($sectionid)
{
    $sectionid = intval($sectionid);
    return WWW_URL.'list/s'.$sectionid.'/';
}

/**
 * 生成区块更多列表存储目录
 *
 * @param $sectionid 区块 ID
 * @return string 列表存储目录
 */
function section_list_path($sectionid)
{
    $sectionid = intval($sectionid);
    return WWW_PATH.'list/s'.$sectionid.'/';
}

/**
 * 获取栏目下可用的模型
 *
 * 非终极栏目始终返回所有模型
 *
 * @param $catid 栏目ID
 * @return array 可用的模型
 */
function category_model($catid)
{
    static $models = null;
    if (is_null($models))
    {
        $models = table('model');
    }
    $catid = intval($catid);
    if (!$catid) return $models;
    $category = table('category', $catid);
    if (!$category || $category['childids']) return $models;
    $avaiable_models = array();
    foreach ((array) decodeData($category['model'], 1) as $modelid => $model)
    {
        if (isset($model['show']) && intval($model['show']))
        {
            $avaiable_models[$modelid] = $models[$modelid];
        }
    }
    return $avaiable_models;
}

function read_kvdata($key)
{
    static $cache = null;
    if (is_null($cache))
    {
        $cache = factory::cache();
    }
    $return = $cache->get('data_'.$key);
    if ($return === false)
    {
        $return = factory::db()->get("SELECT `value` FROM `#table_kvdata` WHERE `key` = ?", array($key));
        $return = $return ? json_decode($return['value'], 1) : null;
        $cache->set('data_'.$key, $return);
    }
    return $return;
}

function store_kvdata($key, $value)
{
    static $cache = null;
    $return = factory::db()->replace("REPLACE INTO `#table_kvdata` VALUES (?, ?);", array(
        $key, json_encode($value)
    ));
    if ($return)
    {
        if (is_null($cache))
        {
            $cache = factory::cache();
        }
        $cache->set('data_'.$key, $value);
    }
    return $return;
}

function short_url($url)
{
    $short = str_short($url);
    $key = 'surl_' . $short;
    store_kvdata($key, $url);
    return APP_URL . 'r/' . $short;
}

function short_url_decode($short)
{
    if (filter_var($short, FILTER_VALIDATE_URL)) {
        $short = preg_replace('#^'.preg_quote(APP_URL . 'r/').'#', '', $short);
    }
    return read_kvdata('surl_' . $short);
}

function explain_rows($table, $rows = EXPLAIN_ROWS)
{
    $explain = factory::db()->get("EXPLAIN SELECT * FROM #table_{$table}");
    return $explain['rows'] > $rows ? true : false;
}

function explain_where($where, $filter)
{
    $published = false;
    if (explain_rows('content')) {
        $published = EXPLAIN_PUBLISHED;
        $where = array_map('trim', $where);
        $diffs = array_diff_key($where, $filter);
        foreach ($diffs as $diff) {
            if (!empty($diff))  {
                $published = false;
                break;
            }
        }
    }
    return $published;
}

/**
 *	前台页面生成二维码
 *	@param $url 需要生成的URL
 * 	@return string 二维码图片路径
 */
function generate_qrcode($url, $img)
{
    import('helper.qrcode');
    $size = 7;
    $level = QR_ECLEVEL_H;
    $version = 4;
    $margin = 0;

    $filename = md5($url) . '-' . $size;
    $basename = 'qrcode/' . date('Y') . '/' . date('md') . '/' . $filename . '.png';
    $filename = UPLOAD_PATH . $basename;
    
    // 生成二维码
    folder::create(dirname($filename));
    QRcode::png($url, $filename, $level, $size, $margin, false, $version);
    if (file_get_contents($img)) {
    	$qrcode = loader::model('admin/qrcode', 'system');
    	$qrcode->image_to_qrcode($filename, $img);
    }

 	if (!is_file($filename)) {
 		return '';
 		exit;
 	}

    return $filename;
}