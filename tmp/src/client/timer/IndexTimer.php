<?php
namespace src\timer;

use src\common\Common;

class IndexTimer
{
    public $interval;
    public function __construct()
    {
        $this->interval = 3000; //单位为毫秒
    }
    public function execute() {
        $uniqid = md5(uniqid(microtime(true),true));
        Common::logInfo('INFO : 定时任务['.__CLASS__.'] uniqid : ' . $uniqid);
    }
}
