<?php
namespace src\model\mysql\user;
use src\libs\Mysql;

class User extends Mysql
{
    protected $dbName = "default";
    protected $dbTable = "user";
    protected $primaryKey = "id";
    protected $dbFields = Array(
        'id' => Array('int'),
        'age' => Array('int'),
        'name' => Array('text'),
    );
    protected $timestamps = '';
}
?>
