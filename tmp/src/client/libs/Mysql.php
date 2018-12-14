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
        $data = $this->db->where($where,$param)->get($this->dbTable);
        Common::logInfo('NOTICE ['. date('Y-m-d H:i:s') .']SQL:'.$this->db->getLastQuery());
        return $data;
    }

    public function doSql($sql)
    {
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
        return $this->db->where($where,$param)->getOne($this->dbTable);
    }
    public function getModelDb()
    {
        return $this->db;
    }
    public function getAllData()
    {
        return $this->db->get($this->dbTable);
    }

    public function getLastSqlError()
    {
        return $this->db->getLastErrno();
    }

    public function getLastSql() 
    {
        return $this->db->getLastQuery();
    }

    public function saveData($data)
    {
        $res = $this->db->insert($this->dbTable,$data);
        Common::logInfo('INFO : Sql [' . $this->getLastSql().']');
        return $res ? $this->db->getInsertId() : false;
    }
    public function saveAllData($data) 
    {
        return $this->db->insertMulti($this->dbTable,$data);
    }
    public function deleteByWhere($where,$param)
    {
        return $this->db->where($where,$param)->delete($this->dbTable);
    }
    public function updateData($where,$param,$data)
    {
        return $this->db->where($where,$param)->update($this->dbTable, $data);
    }
}




