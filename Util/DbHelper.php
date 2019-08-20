<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/1/12
 * Time: 11:21
 */

namespace Ido\Tools\Util;

use PDO;

class DbHelper
{
    protected $pdo;
    protected $host, $dbname, $user, $pwd, $port;

    function __construct($host, $dbname, $user, $pwd, $port = null)
    {
        $port = $port ? $port : 3306;
        list($this->host, $this->dbname, $this->user, $this->pwd, $this->port) = [$host, $dbname, $user, $pwd, $port];
        $this->pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $user, $pwd);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//设置以异常的形式报错
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);//设置fetch时返回数据形式为数组
    }

    /**
     * @return array[
     * 'table_name' => [
     * ['name'=>'', 'column_type'=>'', 'type'=>'', 'comment'=>'','is_nullable'],
     * ]
     * ]
     */
    function getTables()
    {
        $tbs = $this->execute("select table_name from information_schema.tables  where table_schema = ?",
            [$this->dbname]);
        $rs = [];
        foreach ($tbs as $v) {
            //取得表信息
            $rs[$v['table_name']] = $this->getTableInfo($v['table_name']);
        }

        return $rs;
    }

    public function getTableInfo($tableName)
    {
        $fieldInfo = $this->execute("SELECT COLUMN_NAME `name`,COLUMN_TYPE `column_type` ,DATA_TYPE `type`,COLUMN_COMMENT `comment`,IS_NULLABLE `is_nullable`,CHARACTER_MAXIMUM_LENGTH `length`,NUMERIC_PRECISION `numeric_precision`,
NUMERIC_SCALE `numeric_scale` FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=?",
            [$this->dbname, $tableName]);
        $fields = [];
        foreach ($fieldInfo as $field) {
            if ($field['type'] == 'tinyint') {
                $field['data_types'] = $this->getDataTypes($field['name'], $tableName);
            }

            $field['is_nullable'] = $field['is_nullable'] == 'YES';
            $fields[$field['name']] = $field;
        }

        return $fields;
    }

    // type `is_nullable`, `length`, `numeric_precision`,
    //  `numeric_scale`
    /**
     * @param $columnType  array [type,column_type  is_nullable, length, numeric_precision, numeric_scale]
     * @param $value
     */
    public function checkTypes($columnType, $value)
    {



        if (is_null($value)) {
            if (!$columnType['is_nullable']) {
                return [false, '不能为空', 1];
            }
        }
        if (in_array($columnType['type'], ['char','enum', 'text', 'varchar', 'longtext','tinytext','mediumtext','longtext', 'varbinary','set','blob','mediumblob','longblob'])) {
            if(in_array($columnType['type'], ['char','enum', 'text', 'varchar', 'longtext','tinytext','mediumtext','longtext'])){
                if (!is_string($value)) {
                    return [false, '类型不正确'];
                }
            }
            $length = strlen($value);
            if ($length > $columnType['length']) {
                return [false, '长度超过限制'];
            }
        } else if (in_array($columnType['type'], [ 'tinyint', 'smallint', 'mediumint', 'int', 'bigint'])) {
            if (!is_int($value)) {
                return [false, '类型不正确'];
            }
            if(strripos($columnType['column_type'],'unsigned')>0) {
                $limits = [
                    'bigint'    => ['min' => 0, 'max' => 18446744073709551615],
                    'int'       => ['min' => 0, 'max' => 4294967295],
                    'tinyint'   => ['min' => 0, 'max' => 255],
                    'smallint'  => ['min' => 0, 'max' => 65535],
                    'mediumint' => ['min' => 0, 'max' => 8388607],
                ];
            }else{
                $limits= [
                    'bigint'    => ['min' => -9223372036854775808, 'max' => 9223372036854775807],
                    'int'       => ['min' => -2147483648, 'max' => 2147483647],
                    'tinyint'   => ['min' => -128, 'max' => 127],
                    'smallint'  => ['min' => -32768, 'max' => 32767],
                    'mediumint' => ['min' => -8388608, 'max' => 8388607],
                ];
            }
            $limit = $limits[$columnType['type']];
            if(!($value<=$limit['max'] && $value>=$limit['min'])){
                return [false, '数字范围不正确'];
            }

        }else if (in_array($columnType['type'], ['bit', 'double','float', 'decimal',])) {
            if (!is_int($value)) {
                return [false, '类型不正确'];
            }
            //todo
        }else if (in_array($columnType['type'], ['date', 'timestamp', 'datetime','date'])) {
            //todo
        }

        return [true, '成功'];
    }

    public function getDataTypes($column, $tb)
    {
        $sql = "select {$column} from {$this->dbname}.{$tb} GROUP  by {$column} limit 100";
        $rs = $this->execute($sql);
        $r = [];
        foreach ($rs as $v) {
            $r[] = $v[$column];
        }

        return $r;
    }


    public static function generateInsertSql($tb, $data)
    {
        $fields = implode(',', array_keys($data));
        $values = '\'' . implode('\',\'', $data) . '\'';

        return "insert into {$tb}({$fields})values({$values});";
    }

    /**
     * @param $tb1
     * @param $columns [['field' => $v['B'], 'type' => get_type($v['C']), 'is_pri_key' => false]]
     * @return string
     */
    public static function generateTableSql($tb1, $columns)
    {
        $column_sqls = [];
        $primary_key = '';
        foreach ($columns as $column) {
            $column['type'] = strtolower($column['type']);
            $column['field'] = strtolower($column['field']);
            if ($column['type'] == 'varchar') {
                $column['type'] = 'varchar(255)';
            }
            /*字段创建*/
            if ($column['is_pri_key']) {
                $primary_key = $column['field'];
                $column_sqls[] = "`{$column['field']}` " . $column['type'] . "  NOT NULL AUTO_INCREMENT";
            } else {
                $column_sqls[] = "`{$column['field']}` " . $column['type'] . "  NOT NULL";
            }
        }
        if (!empty($primary_key)) {
            $column_sqls[] = "PRIMARY KEY (`{$primary_key}`)";
        }
        $create_sql = "CREATE TABLE IF NOT EXISTS   `{$tb1}` (" . PHP_EOL . implode(',' . PHP_EOL,
                $column_sqls) . PHP_EOL . ") DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB;" . PHP_EOL;

        return $create_sql;
    }


    public static function generateUpSql($tb1, $tb2, $up_columns)
    {

        foreach ($up_columns as $k => $v) {
            /*字段更新*/
            $up_columns['`' . $k . '`'] = "{$v} as `{$k}`";
        }
        $up_sql = PHP_EOL . "INSERT into {$tb1}(" . implode(',', array_keys($up_columns)) . ") select " . implode(',',
                $up_columns) . " from {$tb2};" . PHP_EOL . PHP_EOL;

        return $up_sql;
    }

    function execute($sql, $option = [])
    {
        $ps = $this->pdo->prepare($sql);//生成一个PDOStatement实例
        if (!empty($option)) {

            foreach ($option as $k => $v) {
                $ps->bindValue($k + 1, $v);//第一个？处的参数换成 文章，不需要附加任何处理
            }
        }
        $rs = $ps->execute(); //正式执行。
        //得到查询结果
        try {
            return $ps->fetchAll();
        } catch (\Exception $e) {
            return $rs;
        }
    }

    /**
     * @param string $sql
     * @param array $param
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public function paginateSql($sql, $param = [], $page = 1, $page_size = 100000)
    {

        $rs = $this->query("select count(*) as tp_count from ({$sql}) as _think_tb", $param);
        $count = isset($rs[0]) ? $rs[0]['tp_count'] : 0;
        $total_page = (int)ceil($count / $page_size);
        $start = ($page - 1) * $page_size;
        $rs = $this->query("{$sql} limit {$start},{$page_size}", $param);
        if (empty($rs)) {
            return [
                'page_size'    => $page_size,
                'page'         => $page,
                'total_page'   => $total_page,
                'total_record' => $count,
                'list'         => []
            ];
        }

        return [
            'page_size'    => $page_size,
            'page'         => $page,
            'total_page'   => $total_page,
            'total_record' => $count,
            'list'         => $rs
        ];
    }


    /**
     * @return \PDO
     */
    protected function getPdo()
    {
        if (!$this->pdo) {
            $port = C('DB_PORT') ?: 3306;
            $host = C('DB_HOST');
            $dbname = C('DB_NAME');
            $dbuser = C('DB_USER');
            $dbpwd = C('DB_PWD');
            $dbcharset = C('DB_CHARSET');
            $dsn = "mysql:dbname={$dbname};host={$host};port={$port};charset={$dbcharset}";
            $this->pdo = new \PDO($dsn, $dbuser, $dbpwd, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }

        return $this->pdo;
    }

    /** 使用pdo查询sql
     * @param $sql
     * @param array $param [1,2,3] 或 [':name1'=>1,':name2'=>2,':name3'=>3,]形式的数组
     * in查询:select * from tb where id in (:id) ,[id=>[1,2,3]]数组绑定为  [id_0=>1,id_1=>2,id_2=>3] sql为 select * from tb where id in (:id_0,:id_1,:id_2)
     * @return bool
     * @throws \Exception
     */
    public function query($sql, $param = [])
    {

        $bindArr = $this->getBindArr($param, $sql);
        try {
            $statement = $this->getPdo()->prepare($sql);
            $statement->execute($bindArr);
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage() . ' sql:' . $sql . ' param:' . var_export($bindArr, true));
        }

        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function findOne($sql, $param)
    {
        $rs = $this->query($sql, $param);

        return isset($rs[0]) ? $rs[0] : null;
    }

    /** 绑定数据
     * @param $param
     * @param $sql
     * @return array
     */
    protected function getBindArr($param, &$sql)
    {
        $bindArr = [];

        foreach ($param as $k => $v) {
            if (is_int($k)) {
                $bindArr[$k + 1] = $v;
            } else {
                //in形式的数组支持
                if (is_array($v)) {//select * from tb where id in (:id) ,[id=>[1,2,3]]数组绑定为  [id_0=>1,id_1=>2,id_2=>3] sql为 select * from tb where id in (:id_0,:id_1,:id_2)
                    $replace = [];
                    foreach ($v as $k1 => $v1) {
                        $key = $k . '_tmp_' . $k1;
                        $bindArr[$key] = $v1;
                        $replace[] = $key;
                    }
                    $sql = preg_replace('/' . preg_quote($k) . '\b/', implode(',', $replace), $sql);
                } else {
                    $bindArr[$k] = $v;
                }
            }
        }
        //预处理sql //若有多个重复变量则替换成name_tmp_1形式
        $tmpBindArr = $bindArr;
        foreach ($tmpBindArr as $k => $v) {
            $i = 0;
            $sql = preg_replace_callback(
                '/' . preg_quote($k) . '\b/',
                function ($matches) use (&$i, &$bindArr, $k, $v) {
                    if ($i == 0) {
                        $key = $matches[0];
                    } else {
                        $key = $matches[0] . '_tmp_' . $i;
                        $bindArr[$key] = $v;
                    }
                    $i++;

                    return $key;
                },
                $sql
            );
        }

        return $bindArr;
    }
}