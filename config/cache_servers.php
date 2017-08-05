<?php
/**
 * 如果cache使用本地缓存，那么应该配置cache_servers为所有前台本地缓存实例
 * 目的是为了同步更新缓存，注意该配置为多维数组
 */
return array(

);
/*
return array (
    array(
        'storage' => 'redis',
        'caching' => 1,
        'prefix' => 'cmstop_',
        'redis' => array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'persistent'=> 0,
            'auth' => '',
        ),
    ),
    array(
        'storage' => 'redis',
        'caching' => 1,
        'prefix' => 'cmstop_',
        'redis' => array(
            'host' => '127.0.0.1',
            'port' => 6380,
            'persistent'=> 0,
            'auth' => '',
        ),
    ),
);
*/