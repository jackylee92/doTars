<?php
namespace src\common;
use Tars\client\CommunicatorConfig;
use Tars\registry\QueryFWrapper;
use src\conf\ENVConf;
/**
 * 通用类
 */
class Common
{
    /**
     * 下划线转驼峰
     * @author lijundong
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
     * @author lijundong
     * @param  string $word
     * @return string
     */
    public static function humpToUndline($str = '')
    {
        return ($str ? strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str)) : '');
    }

    /**
     * 批量转换字段
     * @author lijundong
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
    public static function getPHPServant($nameSpace,$locator=false,$socketModuleName=false)
    {
        return self::getServant('php',$nameSpace,$locator,$socketModuleName);
    }

    public static function getJAVAServant($nameSpace,$locator=false,$socketModuleName=false)
    {
        return self::getServant('java',$nameSpace,$locator,$socketModuleName);
    }

    private static function getServant($type,$nameSpace,$locator,$socketModuleName)
    {
        try{
            $locator = ($locator) ? $locator : ENVConf::$locator;
            $socketModuleName = ($socketModuleName) ? $socketModuleName : ENVConf::$socketModuleName;

            $config = new CommunicatorConfig();
            $config->setLocator($locator);
            $config->setModuleName($socketModuleName);
            if($type == 'java') {
                $config->setIVersion(1);
            }
            $servant = new $nameSpace($config);
            $result = self::checkServer($servant);
            if(!$result) {
                throw new \Exception(''.$nameSpace.'服务不可用',500);
            }
        }catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
            self::logInfo('ERROR', '链接服务失败['.$nameSpace.']; Code:['. $code. ']; Msg:['.$msg.']');
            $servant = false;
        }
        return $servant;
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

    public static function logInfo($type, $content)
    {
        echo "\r\n".'LOG ['.date('Y-m-d H:i:s').'] : type : ['. $type . '] Msg : ['. $content."]\r\n";
    }


}
