<?php
namespace src\libs;

use src\conf\DBConf;

class DbMysqli extends \dbObject
{
    protected $db = 'default';
    protected $prefix = '';

    public function __construct($connection = 'default')
    {
        $defaultConf = DBConf::$config[$connection];
        $db = new \MysqliDb($defaultConf);
        foreach (DBConf::$config as $dbName => $conn) {
            if ($dbName == $connection) {
                continue;
            }
            $db->addConnection($dbName, $conn);
        }
        $this->db = $db;
        $this->db->setPrefix($this->prefix);
        return $this;
    }

    /**
     * db类
     * @return mixed 
     * :\MysqliDb 类型限定写法，返回类型必须这个类型
     */
    public static function db():\MysqliDb
    {
        $instance = (new static);
        return $instance->db;
    }
}
