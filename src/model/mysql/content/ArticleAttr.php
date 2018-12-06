<?php
namespace Server\model\mysql\content;
use Server\libs\Mysql;

class ArticleAttr extends Mysql
{
    protected $dbName = "8mvs_content";
    protected $dbTable = "article_attr";
    protected $primaryKey = "aa_id";
    protected $dbFields = Array(
        'aa_id' => Array('int'),
        'ab_id' => Array('int'),
        'view' => Array('int'),
        'upvote' => Array('int'),
        'comment_count' => Array('int'),
        'remark' => Array('text'),
        'create_time' => Array('int'),
        'update_time' => Array('int'),
        'del_flag' => Array('int'),
        'collection_count' => Array('int'),
    );
    protected $timestamps = '';

    public function saveAttr($data)
    {
        $fields = array_keys($this->dbFields);
        $save = [
            'ab_id' => $data['ab_id'],
            'view' => isset($data['view']) ? isset($data['view']) : 0,
            'upvote' => isset($data['upvote']) ? isset($data['upvote']) : 0,
            'comment_count' => 0,
            'collection_count' => isset($data['collection_count']) ? isset($data['collection_count']) : 0,
            'remark' => '-',
            'create_time' => time(),
            'update_time' => time(),
            'del_flag' => 1,
        ];
        return $this->saveMvs($save);
    }
    public function deleteAttrById($ab_id)
    {
        $where = 'ab_id = ?';
        $param = [$ab_id];
        return $this->deleteByWhere($where,$param);
    }
}
?>
