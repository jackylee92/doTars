<?php
namespace Server\conf;
class ENVConf
{
    public static $locator = 'tars.tarsregistry.QueryObj@tcp -h 192.168.163.128 -p 17890';
    public static $socketMode = 3;
    public static function getTarsConf()
    {
        $table = $_SERVER->table;
        $result = $table->get('tars:php:tarsConf');
        $tarsConf = unserialize($result['tarsConfig']);
        return $tarsConf;
    }
}
