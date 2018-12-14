<?php
return array(
    'appName' => '${doTarsServerName}',
    'serverName' => '${doTarsServantName}',//发布服务器时需要注意使用此名称
    'objName' => '${doTarsObjName}',
    'withServant' => true, //决定是服务端,还是客户端的自动生成
    'tarsFiles' => array(
        './${doTarsServerName}${doTarsServantName}.tars',
    ),
    'dstPath' => '../src/servant',
    'namespacePrefix' => 'src\servant',
);
