<?php
namespace src\libs;
use src\libs\DbMysqli;

class Loader
{
    /**
     * 框架初始化
     */
    public static function getLoader()
    {
        date_default_timezone_set('PRC');
        new DbMysqli();
    }
}
