<?php
namespace Server\Impl;
use Server\servant\Article\Server\Obj\ArticleServant;
use Server\servant\Article\Server\Obj\classes\ListParam;
use Server\servant\Article\Server\Obj\classes\ArticleList;
use Server\service\article\Article;
use Server\common\Common;

class ArticleServantImpl implements ArticleServant
{
	/**
	 * @param string $version 
	 * @param string $param 
	 * @return int
	 */
    public function add($version,$param)
    {
        Common::logInfo('INFO [添加文章] Param :' . $param);
        try {
            $event = new Article();
            $event->param = $param;
            $code = $event->add();
        } catch (\Exception $e) {
            $code = $e->getCode();
            Common::logInfo('ERROR : CODE ['. $e->getCode().'] MSG :'. $e->getMessage());
        }
        return $code;
    }
	/**
	 * @param string $version 
	 * @param string $where 
	 * @return int
	 */
    public function delete($version,$param)
    {
        Common::logInfo('INFO [删除文章] Param :' . $param);
        try {
            $event = new Article();
            $event->param = $param;
            $code = $event->delete();
        } catch (\Exception $e) {
            $code = $e->getCode();
            Common::logInfo('ERROR : CODE ['. $e->getCode().'] MSG :'. $e->getMessage());
        }
        return $code;
    }
	/**
	 * @param string $version 
	 * @param string $where 
	 * @param string $data 
	 * @return int
	 */
	public function update($version,$param)
    {
        Common::logInfo('INFO [更新文章] Param :' . $param);
        try {
            $event = new Article();
            $event->param = $param;
            $code = $event->update();
        } catch (\Exception $e) {
            $code = $e->getCode();
            Common::logInfo('ERROR : CODE ['. $e->getCode().'] MSG :'. $e->getMessage());
        }
        return $code;
    }
	/**
	 * @param string $version 
	 * @param struct $where \Server\servant\Article\Server\Obj\classes\Where
	 * @param  =out=
	 * @return int
	 */
	public function get($version,ListParam $where,ArticleList &$data)
    {
        Common::logInfo('INFO [查询列表] Where : ' . $where->where. ', needPage : '. $where->needPage. ', Page : '. $where->page . ', Count : '. $where->count);
        try {
            $event = new Article();
            $event->param = $where;
            $code = $event->get($data);
        } catch (\Exception $e) {
            $code = $e->getCode();
            Common::logInfo('ERROR : CODE ['. $e->getCode().'] MSG :'. $e->getMessage());
        }
        return $code;
    }
	/**
	 * @param string $version 
	 * @param string $where 
	 * @param string $data =out=
	 * @return int
	 */
    public function find($version,$where,&$data)
    {
        Common::logInfo('INFO [查询单条] Where : ' . $where->where. ', needPage : '. $where->needPage. ', Page : '. $where->page . ', Count : '. $where->count);
        try {
            $event = new Article();
            $event->param = $where;
            $code = $event->find($data);
        } catch (\Exception $e) {
            $code = $e->getCode();
            Common::logInfo('ERROR : CODE ['. $e->getCode().'] MSG :'. $e->getMessage());
        }
        return $code;
    }
}
?>
