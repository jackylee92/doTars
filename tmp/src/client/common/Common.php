<?php
namespace src\common;
use Tars\client\CommunicatorConfig;
use Tars\registry\QueryFWrapper;
use src\component\Controller;
use src\conf\ENVConf;
/**
 * 通用类
 */
class Common extends Controller
{
    /**
     * 下划线转驼峰
     * @author LiuFajun
     * @param  string $word
     * @return string
     */
    public static function undlineToHump($str = '')
    {
        if (!$str) return $str;

        $_str = ucwords(str_replace('_', ' ', $str));
        return str_replace(' ', '', lcfirst($_str));
    }

    /**
     * 驼峰转下划线
     * @author LiuFajun
     * @param  string $word
     * @return string
     */
    public static function humpToUndline($str = '')
    {
        return ($str ? strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str)) : '');
    }

    /**
     * 批量转换字段
     * @author LiuFajun
     * @param array $fields
     * @param string $action
     * @return array
     */
    public static function convertFields($fields = [], $action = 'tohump')
    {
        if (!$fields || in_array($action, ['tohump', 'undline'])) return [];

        $_fileds = [];
        foreach ($fields as $fieldName) {
            if ($action == 'tohump') {
                $_fields[] = self::undlineToHump($fieldName);
            }

            if ($action == 'toundline') {
                $_fields[] = self::humpToUndline($fieldName);
            }
        }

        return $_fields;
    }
    public static function getServant($nameSpace,$locator=false,$socketModuleName=false,$socketMode=false)
    {
        try{
            $locator = ENVConf::$locator;
            $socketModuleName = ENVConf::$socketModuleName;
            $socketMode = ENVConf::$socketMode;
            $config = new CommunicatorConfig();
            $config->setLocator($locator);
            $config->setModuleName($socketModuleName);
            $config->setSocketMode($socketMode);
            $servant = new $nameSpace($config);
            $servantName = $servant->_servantName;
            $wrapper = new QueryFWrapper($locator, 1, 60000);
            $result = $wrapper->findObjectById($servantName);
            if(!$result) {
                throw new \Exception(''.$nameSpace.'服务不可用',500);
            }
        }catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
            self::logInfo('ERROR 链接服务失败['.$nameSpace.']; Code:['. $code. ']; Msg:['.$msg.']');
            $servant = false;
        }
        return $servant;
    }
    public static function logInfo($content)
    {
        echo "\r\n".'LOG ['.date('Y-m-d H:i:s').'] : '.$content."\r\n";
    }
}
