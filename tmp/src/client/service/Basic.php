<?php

namespace  SearchSyncJob\service;

use  SearchSyncJob\conf\DataConf;
use  SearchSyncJob\conf\ENVConf;
use  SearchSyncJob\conf\ESConf;
use  SearchSyncJob\conf\RedisConf;
use  SearchSyncJob\libs\Redis;

/**
 * 基类
 */
class Basic
{
    public $orderPayType = [
        1 => '余额',
        21 => '授信',
        31 => '微信',
        32 => '支付宝',
        33 => '银行卡',
    ];
    public $orderStatus = [
        1 => '预订单',
        2 => '支付中',
        3 => '成功订单',
        0 => '取消订单',
        -1 => '退款订单'
    ];
    public $orderPayStatus = [
        10 => '待付款',
        20 => '付款中',
        30 => '付款成功',
        40 => '付款失败'
    ];
    public $ossType = [
        1 => '固定网点'
    ];
    public $ContractType = [
        5 => '完成',
        3 => '有效',
        2 => '审批',
        1 => '草稿',
        0 => '终止',
        -1 => '作废'
    ];
    public $ospContractType = [
        11 => '我方供油',
        31 => '他方供油'
    ];
    public $ossStatus = [
        1 => '有效',
        0 => '无效'
    ];
    public $ossOpenStatus = [
        1 => '对外开放',
        0 => '内部使用'
    ];
    public $refundStatus = [
        10 => '退款申请',
        20 => '退款审核中',
        21 => '退款审核通过',
        22 => '退款审核不通过',
        30 => '待退款',
        40 => '退款中',
        50 => '退款成功',
        60 => '退款失败',
    ];

    public function getOssOpenStatusVal($open_status)
    {
        return isset($this->ossOpenStatus[$open_status]) ? $this->ossOpenStatus[$open_status] : '-';
    }
    public function getOrderTypeVal($status)
    {
        return isset($this->orderPayType[$status]) ? $this->orderPayType[$status] : '-';
    }

    public function getOrderStatusVal($status, $refundStatus)
    {
        if ($status == -1) {
            //10退款申请20退款审核中21退款审核通过22退款审核不通过30待退款40退款中50退款成功60退款失败
            return isset($this->refundStatus[$refundStatus]) ? $this->refundStatus[$refundStatus] : '-';
        } else {
            return isset($this->orderStatus[$status]) ? $this->orderStatus[$status] : '-';
        }
    }
    public function getOrderStatus($status, $refundStatus)
    {
        if ($status == -1) {
            //10退款申请20退款审核中21退款审核通过22退款审核不通过30待退款40退款中50退款成功60退款失败
            //1,"待支付" 2,"支付中" 3,"成功订单" 4,"支付失败" 0,"订单取消" 5,"退款申请提交" 6,"退款审核成功 7,"退款中" 8,"退款成功" -6,"退款审核失败" -8,"退款失败" 9,"未知状态"
            switch($refundStatus){
                case 10 : $status = 5; break;
                case 20 : $status = 5; break;
                case 21 : $status = 6; break;
                case 22 : $status = -6; break;
                case 30 : $status = 7; break;
                case 40 : $status = 7; break;
                case 50 : $status = 8; break;
                case 60 : $status = -8; break;
                default : $status = 0;
            }
        }
        return $status;
    }

    public function getOrderPayStatus($status)
    {
        return isset($this->orderPayStatus[$status]) ? $this->orderPayStatus[$status] : '-';
    }

    public function getOssTypeVal($status)
    {
        return reset($this->ossType);
    }

    public function getContractTypeVal($status)
    {
        return isset($this->ContractType[$status]) ? $this->ContractType[$status] : '-';
    }

    public function getOspContractType($status)
    {
        return isset($this->ospContractType[$status]) ? $this->ospContractType[$status] : '-';
    }
    public function getOssStatusVal($status)
    {
        return isset($this->ossStatus[$status]) ? $this->ossStatus[$status] : '-';
    }

    /*
    public function isLat($val)
    {
        if (preg_match("/^-?(?:90(?:\.0{1,15})?|(?:[1-8]?\d(?:\.\d{1,15})?))$/", $val)) {
            return true;
        }
        return false;
    }

    public function isLon($val)
    {
        if (preg_match("/^-?(?:(?:180(?:\.0{1,15})?)|(?:(?:(?:1[0-7]\d)|(?:[1-9]?\d))(?:\.\d{1,15})?))$/", $val)) {
            return true;
        }
        return false;
    }
     */

    public static function getBaseOrderFieldList()
    {
        return array_keys(DataConf::$OrderIndex['fields']);
    }

    public static function getHumpOrderFieldList()
    {
        $list = self::getBaseOrderFieldList();
        $return = [];
        foreach ($list as $item) {
            $return[] = Common::undlineToHump($item);
        }
        return $return;
    }

    public static function getLineOrderFieldList()
    {
        $list = self::getBaseOrderFieldList();
        $return = [];
        foreach ($list as $item) {
            $return[] = Common::humpToUndline($item);
        }
        return $return;
    }

    public static function getAllOrderFieldList()
    {
        return array_merge(self::getHumpOrderFieldList(), self::getLineOrderFieldList());
    }

    public static function getBaseOssFieldList()
    {
        return array_keys(DataConf::$OssIndex['fields']);
    }

    public static function getHumpOssFieldList()
    {
        $list = self::getBaseOssFieldList();
        $return = [];
        foreach ($list as $item) {
            $return[] = Common::undlineToHump($item);
        }
        return $return;
    }

    public static function getLineOssFieldList()
    {
        $list = self::getBaseOssFieldList();
        $return = [];
        foreach ($list as $item) {
            $return[] = Common::undlineToHump($item);
        }
        return $return;
    }

    public static function getAllOssFieldList()
    {
        return array_merge(self::getHumpOssFieldList(), self::getLineOssFieldList());
    }

    public static function getIndexStruct($index)
    {
        $data = [];
        switch ($index) {
            case 'order' :
                $data = DataConf::$OrderIndex;
                break;
            case 'oss' :
                $data = DataConf::$OssIndex;
                break;
        }
        return $data;
    }

    public static function getAllEsType()
    {
        $esDataTypes = [];
        foreach (DataConf::$OrderIndex['fields'] as $item) {
            $esDataTypes[] = $item['type'];
        }
        foreach (DataConf::$OssIndex['fields'] as $item) {
            $esDataTypes[] = $item['type'];
        }
        foreach ($esDataTypes as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $i) {
                    if (is_string($i)) {
                        $esDataTypes[] = $i;
                    }
                }
                unset($esDataTypes[$key]);
            }
        }
        return $esDataTypes;
    }

    public static function arraySort($array, $keys, $sort = 'asc')
    {
        $newArr = $valArr = array();
        foreach ($array as $key => $value) {
            $valArr[$key] = $value[$keys];
        }
        ($sort == 'asc') ? asort($valArr) : arsort($valArr);
        reset($valArr);
        foreach ($valArr as $key => $value) {
            $newArr[$key] = $array[$key];
        }
        return $newArr;
    }

    public static function getRelations($type)
    {
        switch ($type) {
            case 'orders' :
                $data = DataConf::$OrderIndex['fields'];
                break;
            case 'osses' :
                $data = DataConf::$OssIndex['fields'];
                break;
            default :
                $data = [];
        }
        $list = [];
        foreach ($data as $item) {
            $list = array_merge($item['relation'], $list);
        }
        return $list;
    }

    public static function getSyncDataOrder($str)
    {
        $arr = json_decode($str, true);
        if (!isset($arr['msg'])) {
            return ['token' => '', 'orderSn' => ''];
        }
        $msg_arr = json_decode($arr['msg'], true);
        return [
            'token' => isset($arr['token']) ? $arr['token'] : '',
            'orderSn' => isset($msg_arr['orderSn']) ? $msg_arr['orderSn'] : '',
        ];
    }

    public static function getSyncDataOssId($str)
    {
        $arr = json_decode($str, true);
        if (!isset($arr['msg'])) {
            return ['token' => '', 'orderSn' => ''];
        }
        $msg_arr = json_decode($arr['msg'], true);
        return [
            'token' => isset($arr['token']) ? $arr['token'] : '',
            'ossId' => isset($msg_arr['ossId']) ? $msg_arr['ossId'] : '',
        ];
    }

    public static function checkServer($servant)
    {
        $wrapper = new \Tars\registry\QueryFWrapper(ENVConf::$locator, 1, 60000);
        $result = $wrapper->findObjectById($servant->_servantName);
        if ($result) {
            return true;
        }
        return false;

    }

    /**
     * 根据起点坐标和终点坐标测距离
     * @param  [array]   $from  [起点坐标(经纬度),例如:array(118.012951,36.810024)]
     * @param  [array]   $to    [终点坐标(经纬度)]
     * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
     * @param  [int]     $decimal   精度 保留小数位数
     * @return [string]  距离数值
     */
    public static function getDistance($from, $to, $km = false, $decimal = 2)
    {
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数

        $distance = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin(($from[0] * pi() / 180 - $to[0] * pi() / 180) / 2), 2) + cos($from[0] * pi() / 180) * cos($to[0] * pi() / 180) * pow(sin(($from[1] * pi() / 180 - $to[1] * pi() / 180) / 2), 2))) * 1000;

        if ($km) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }
    //获取订单锁的key
    public static function getOrderRedisKey()
    {
        return RedisConf::$keys['php_search_order'];
    }
    //获取站点锁的key
    public static function getOssRedisKey()
    {
        return RedisConf::$keys['php_search_oss'];
    }
    //获取站点待同步id的key
    public static function getEsOssRedisKey()
    {
        return RedisConf::$keys['php_es_oss'];
    }
    //获取订单待同步订单号的key
    public static function getEsOrderRedisKey()
    {
        return RedisConf::$keys['php_es_order'];
    }

    public static function getEsSyncLock()
    {
        return RedisConf::$keys['php_es_sync_lock'].DataConf::$syncLock;
    }
    public static function getEsSyncTime()
    {
        return RedisConf::$keys['php_es_sync_time'];
    }
    public static function getCreateOssIndexVersion()
    {
        return isset(DataConf::$createOssVersion) ? DataConf::$createOssVersion : false;
    }
    public static function getCreateOrderIndexVersion()
    {
        return isset(DataConf::$createOrderVersion) ? DataConf::$createOrderVersion : false;
    }

    /**
     * @Content :
     * @Param   :
     * @Return  : array(
     *                    'status' => true/false,
     *                    'msg'     => string,
     *                    'data'     => array()
     *                )
     * @Author  : lijundong
     * @Time    : 2018/9/15  下午3:18
     *
     * $redis->sAdd($key,$val);
     * redis->sIsMember($key,$val);
     */
    public static function getRedis()
    {
        $redis = Redis::getInstance(RedisConf::$config,['isRedisCluster' => 1]);
        return $redis;
    }
}
