<?php
require_once __DIR__.'/vendor/autoload.php';
use \Tars\cmd\Command;
use src\libs\Loader;
//php tarsCmd.php  conf restart
$config_path = $argv[1];
$pos = strpos($config_path, '--config=');
$config_path = substr($config_path,  + 9);
$cmd = strtolower($argv[2]);
//初始化数据库
if($cmd=='start'){
    Loader::getLoader();
}
$class = new Command($cmd, $config_path);
$class->run();
