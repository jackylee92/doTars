<?php
namespace src\conf;
class ENVConf
{
    public static $locator = 'tars.tarsregistry.QueryObj@tcp -h ${doTarsIP} -p 17890';
    public static $socketMode = 3;
    public static $socketModuleName = '${doTarsServerName}.${doTarsServantName}';
    public static function getTarsConf()
    {
        $table = $_SERVER->table;
        $result = $table->get('tars:php:tarsConf');
        $tarsConf = unserialize($result['tarsConfig']);
        return $tarsConf;
    }
}
