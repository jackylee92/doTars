<?php
return [
    'obj' => [
        'namespaceName' => 'src\\',
        'saveTarsConfigFileDir' => 'src/conf/', //从tarsconfig拉下来的文件保存目录 默认src目录下的conf
        'saveTarsConfigFileName' => [ '',], //需要从tarsconfig拉下来的文件名 在web上配置
        'monitorStoreConf' => [
            //使用redis缓存主调上报信息
            //'className' => Tars\monitor\cache\RedisStoreCache::class,
            //'config' => [
            // 'host' => '127.0.0.1',
            // 'port' => 6379,
            // 'password' => ':'
            //],
            //使用swoole_table缓存主调上报信息（默认）
            'className' => Tars\monitor\cache\SwooleTableStoreCache::class,
            'config' => [
                'size' => 40960
            ]
        ],
        'registryStoreConf' => [
            'className' => Tars\registry\RouteTable::class,
            'config' => [
                'size' => 200
            ]
        ],
        'protocolName' => 'http', //http, json, tars or other
        'serverType' => 'http', //http(no_tars default), websocket, tcp(tars default), udp
    ],
];
