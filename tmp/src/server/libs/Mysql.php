<?php
namespace src\libs;

use src\common\Common;

class Mysql extends \dbObject
{
    public $error_msg;
    /**
     * 扩展：指定数据库
     * @param $dbName
     * @return dbObject
     */
    public function setDB($dbName):\dbObject
    {
        $this->db->connection($dbName);
        return $this;
    }

    /**
     * @Content : 获取多条数据
     * @Param   :
     *            where string : "id = ? or id = ?"
     *            param array : [1,2];
     * @Return  : array(
     *                    'status' => true/false,
     *                    'msg'     => string,
     *                    'data'     => array()
     *                )
     * @Author  : lijundong
     * @Time    : 2018/9/6  下午4:00
     *
     */
    public function getDataByWhere($where,$param)
    {
        $this->updateDb();
        $data = $this->db->where($where,$param)->get($this->dbTable);
        Common::logInfo('NOTICE ['. date('Y-m-d H:i:s') .']SQL:'.$this->db->getLastQuery());
        return $data;
    }

    public function doSql($sql)
    {
        $this->updateDb();
        try{
            $data = $this->db->query($sql);
        } catch(\Exception $e) {
            Common::logInfo('ERROR SQL ['.$sql.'] CODE ['.$e->getCode().'] MSG ['.$e->getMessage().']');
            return [];
        }
        return $data;
    }

    /**
     * @Content : 获取单条数据
     * @Param   :
     *            where string : "id = ? or id = ?"
     *            param array : [1,2];
     * @Return  : array(
     *                    'status' => true/false,
     *                    'msg'     => string,
     *                    'data'     => array()
     *                )
     * @Author  : lijundong
     * @Time    : 2018/9/6  下午4:00
     *
     */
    public function findDataByWhere($where,$param)
    {
        $this->updateDb();
        return $this->db->where($where,$param)->getOne($this->dbTable);
    }
    public function getModelDb()
    {
        $this->updateDb();
        return $this->db;
    }
    public function getAllData()
    {
        $this->updateDb();
        return $this->db->get($this->dbTable);
    }

    public function getLastSqlError()
    {
        $this->updateDb();
        return $this->db->getLastErrno();
    }

    public function getLastSql() 
    {
        $this->updateDb();
        return $this->db->getLastQuery();
    }

    public function saveData($data)
    {
        $this->updateDb();
        try{
            $res = $this->db->insert($this->dbTable,$data);
        }catch (\Exception $e) {
            Common::logInfo('Error Code['.$e->getCode().']; Msg['.$e->getMessage().']');
            return false;
        }
        return $res;
    }
    public function saveAllData($data) 
    {
        $this->updateDb();
        return $this->db->insertMulti($this->dbTable,$data);
    }
    public function deleteByWhere($where,$param)
    {
        $this->updateDb();
        return $this->db->where($where,$param)->delete($this->dbTable);
    }
    public function updateData($where,$param,$data)
    {
        $this->updateDb();
        return $this->db->where($where,$param)->update($this->dbTable, $data);
    }
    public function getDbObj()
    {
        $this->updateDb();
        return \dbObject::table($this->dbTable);
    }
    public function getCount($where)
    {
        $this->updateDb();
        return $this->getDbObj()->where(...$where)->count();
    }
    private function updateDb()
    {
        if(isset($this->dbName) && $this->db->defConnectionName != $this->dbName) {
            $this->db->connection($this->dbName);
        }
    }
}




