<?php
class wechat_live
{
    const API_BASE = 'http://app.cmstop.cn/live/wechat';

    const SIGN_EXPIRES = 3600;

    protected $appid;

    protected $secret;

    protected $errno;

    protected $error;

    public function __construct($appid, $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function ping()
    {
        $url = self::API_BASE . '/ping';
        return $this->request($url);
    }

    public function request_userbind_qrcode(array $data)
    {
        $url = self::API_BASE . '/userbindqrcode';

        $data = array(
            'userkey' => $data['userkey']
        );

        return $this->request($url, $data);
    }

    public function post_url(array $data)
    {
        $url = self::API_BASE . '/post';
        return $this->prepare($url, $data);
    }

    public function members_url(array $data)
    {
        $url = self::API_BASE . '/members';
        return $this->prepare($url, $data);
    }

    public function edit_url(array $data)
    {
        $url = self::API_BASE . '/edit';
        return $this->prepare($url, $data);
    }

    public function errno()
    {
        return $this->errno;
    }

    public function error()
    {
        return $this->error;
    }

    protected function prepare($url, array $data = array())
    {
        $data['time'] = time();
        $sign = $this->sign($this->appid, $this->secret, $data);

        $data['appid'] = $this->appid;
        $data['sign'] = $sign;

        if (strpos($url, '?') === false) {
            $url .= '?';
        } else {
            $url .= '&';
        }
        $url .= http_build_query($data);

        return $url;
    }

    protected function request($url, array $data = array())
    {
        $this->errno = null;
        $this->error = null;

        $url = $this->prepare($url, $data);
        $result = request($url);
        if (!$result || $result['httpcode'] != 200 || empty($result['content'])) {
            return false;
        }

        $content = json_decode($result['content'], true);
        if (empty($content)) {
            return false;
        }

        if (!$content['state']) {
            $this->error = isset($content['error']) ? $content['error'] : '微信直播接口请求失败';
            return false;
        }

        if (isset($content['data'])) {
            return $content['data'];
        }

        return true;
    }

    public static function sign($appid, $secret, array $data)
    {
        $time = $data['time'];

        foreach (array('appid', 'sign', 'time') as $exclude) {
            if (isset($data[$exclude])) {
                unset($data[$exclude]);
            }
        }

        ksort($data);
        $query = http_build_query($data);
        $sign = md5(md5($query) . $appid . $secret . $time);
        return $sign;
    }

    public function verify_sign($sign, array $data)
    {
        $time = value($data, 'time');
        if (empty($time)) {
            return false;
        }

        if ($time < time() - self::SIGN_EXPIRES) {
            return false;
        }

        return self::sign($this->appid, $this->secret, $data) === $sign;
    }
}