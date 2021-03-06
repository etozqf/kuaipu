<?php
class thirdparty_default extends thirdparty_api
{
    function get_category()
    {
        $params = array();
        $catid = intval(value($_GET, 'catid', 0));
        if($catid) $params['catid'] = $catid;
        $url = $this->getUrl('get_category', $params);
        $result = $this->exec($url);
        if(!$result['state'])
        {
            $this->error = $result['error'];
            return false;
        }
        return $result['data'];
    }

    function get_video()
    {
        $params = array();
        $catid = intval(value($_GET, 'catid', 0));
        if($catid) $params['catid'] = $catid;
        $created = '';
        $created_min = value($_GET, 'created_min', null);
        $created_max = value($_GET, 'created_max', null);
        if($created_min) $created = $created_min .',';
        if($created_max)
        {
            if($created)
            {
                $created .= $created_max;
            }
            else{
                $created = ',' .$created_max;
            }
        }
        if($created) $params['created'] = $created;
        $keyword = value($_GET, 'keyword', null);
        if($keyword) $params['keyword'] = $keyword;
        $pagesize = value($_GET, 'pagesize', 10);
        if($pagesize) $params['pagesize'] = $pagesize;
        $page = value($_GET, 'page', 1);
        if($page) $params['page'] = $page;
        $url = $this->getUrl('get_video', $params);
        $result = $this->exec($url);
        if(!$result['state'])
        {
            $this->error = $result['error'];
            return false;
        }
        return $result;
    }

    function get_playcount()
    {
        $params = array();
        $vid = intval(value($_GET, 'vid', 0));
        if(!$vid)
        {
            $this->error ='视频编号不能为空';
            return false;
        }
        $params['vid'] = $vid;
        $url = $this->getUrl('get_playcount', $params);
        $result = $this->exec($url);
        if(!$result['state'])
        {
            $this->error = $result['error'];
            return false;
        }
        return $result;
    }

    function get_live()
    {
        $params = array();
        $url = $this->getUrl('get_live', $params);
        $result = $this->exec($url);
        if(!$result['state'])
        {
            $this->error = $result['error'];
            return false;
        }
        return $result;
    }

    function output_ads()
    {
        $ads = $this->config['ads'];
        foreach($ads as $key=>&$row)
        {
            $fileext = fileext($row['file']);
            $fileext = strtolower($fileext);
            switch($fileext)
            {
                case 'mp4':
                    $row['type'] = 'video';
                    break;
                case 'flv':
                    $row['type'] = 'video';
                    break;
                case 'swf':
                    $row['type'] = 'flash';
                    break;
                default:
                    $row['type'] = 'image';
                    break;
            }
            if(!$row['open'])
            {
                $row['file'] = $row['url'] = '';
                $row['time'] = 0;
            }
        };
        return $ads;
    }

    function output_recommend($data=array())
    {
        return $data;
    }
}