<?php
return array(
    'appName' => 'Article',
    'serverName' => 'Server',//发布服务器时需要注意使用此名称
    'objName' => 'Obj',
    'withServant' => true, //决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './ArticleService.tars',
    ),
    'dstPath' => '../src/servant',
    'namespacePrefix' => 'Server\servant',
);
