<?php

class cache_storage_redis extends cache_storage
{
    protected $redis = NULL;

    function __construct($settings)
    {
        parent::__construct($settings);

        $this->redis = new Redis();
        $server = $this->settings['redis'];
        $port = isset($server['port']) ? $server['port'] : 6379;
        if (empty($server['persistent'])) {
            $rs = $this->redis->connect($server['host'], $port);
        } else {
            $rs = $this->redis->pconnect($server['host'], $port);
        }
        if (!$rs) {
            throw new ct_exception('can not connect to redis!');
        }

        if (isset($server['auth']) && !empty($server['auth'])) {
            $auth = $this->redis->auth($server['auth']);
            if (!$auth) {
                throw new ct_exception('redis client require auth password');
            }
        }

        $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
        $this->redis->setOption(Redis::OPT_PREFIX, $this->settings['prefix']);
    }

    function __call($method, $args)
    {
        if (method_exists($this->redis, $method)) {
            return call_user_func_array(array($this->redis, $method), $args);
        }

        throw new ct_exception('method ' . $method . ' not exists');
    }

    function set($key, $value, $ttl = 0)
    {
        if ($this->debug) {
            $this->log->add('cache set: key[' . $key . '], ttl[' . $ttl . ']');
        }
        return $this->redis->set($key, $value, $ttl);
    }

    function get($key)
    {
        if ($this->debug) {
            $this->log->add('cache get: key[' . $key . ']');
        }
        return $this->redis->get($key);
    }

    function rm($key)
    {
        if ($this->debug) {
            $this->log->add('cache rm: key[' . $key . ']');
        }
        $this->redis->delete($key);
    }

    function clear()
    {
        if ($this->debug) {
            $this->log->add('cache clear');
        }
        return $this->redis->flushDB();
    }

    /**
     * 返回Redis实例
     *
     * @return Redis
     */
    function get_client()
    {
        return $this->redis;
    }

}
