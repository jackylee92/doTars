<?php
// 以namespace的方式,在psr4的框架下对代码进行加载
return [
    '${doTarsObjName}' => [
        'home-api'=> '\src\servant\${doTarsServerName}\${doTarsServantName}\${doTarsObjName}\${doTarsServantImplName}',
        'home-class'=> '\src\impl\IndexServantImpl',
        'namespaceName'  => 'src\\',
        'protocolName' => 'tars', //http, json, tars or other
        'serverType' => 'tcp', //http(no_tars default), websocket, tcp(tars default), udp
    ],
];
