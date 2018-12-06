<?php

namespace Server\service\validate;

use Server\common\Common;
use Server\service\Basic;

class Validate extends Basic
{

    //验证的数据
    public $data;
    public $error_msg;

    public function __construct()
    {
    }

    public function isJson($data)
    {
        return !is_null(json_decode($data,true));
    }
}
