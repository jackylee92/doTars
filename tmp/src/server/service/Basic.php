<?php

namespace  src\service;
use  SearchSyncJob\conf\RedisConf;
use  SearchSyncJob\libs\Redis;

/**
 * 基类
 */
class Basic
{
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
