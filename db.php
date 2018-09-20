<?php
$db_localhost = array(
    'host' => '127.0.0.1',
    'username'=>'root',
    'password'=>'',
    'database'=>'test',
    'port' => '3306',
    'charset'=>'utf8'
);
$redis_conf = array('host'=>'127.0.0.1', 'port'=>3306);

$pdo_service = new pdoSerive($db_localhost);
//$sql = "SELECT * FROM user_info ";
//$sql = "UPDATE user_info SET flag=? ";
//$rs = $pdo_service->queryBySql($sql,['1381a74a0550bbab81ecd364d21466bb']);
try{
//    $sql = "INSERT INTO city (`province_id`,`name`) VALUE (?,?)";
    $sql = "UPDATE city SET province_id = ?,status=1";
    $rs = $pdo_service->exexBySql($sql,['fdfd2']);
    echo '<pre>';
    print_r($rs);
}catch (\PDOException $e){
    echo $e->getMessage();
}


class pdoSerive{
    private $db_config;
    public function __construct($db=null){
        if ($db!=null){
            $this->db_config = $db;
        }
    }

    private function db_connect(){
        $db = $this->db_config;
        $pdo = new PDO('mysql:host='.$db['host'].':'.$db['port'].';dbname='.$db['database'],$db['username'],$db['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names '.$db['charset']));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//设置报错格式
        if ($pdo){
            return $pdo;
        }else{
            return false;
        }
    }

    /**
     * 执行查询sql
     */
    public function queryBySql($sql, $where=array()){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
        $pdo = null;
        $sth->execute($where);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//获取结果集
//        $rs_sql = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 执行更新,插入,删除sql  返回影响行数
     */
    public function exexBySql($sql, $where=array()){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
//        $pdo = null;
        $rs_ex = $sth->execute($where);
        if ($rs_ex){
            return $sth->rowCount();//获取影响行数
        }else{
            return false;
        }
    }

    /**
     * 执行插入sql  可返回插入的自增主键id
     */
    public function insertBySql($sql, $where=array()){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
        $rs_ex = $sth->execute($where);
        if ($rs_ex){
            $insert_id = $pdo->lastInsertId();
            $pdo = null;
            return $insert_id;//获取插入的自增id
        }else{
            return false;
        }
    }
}

/**
 * 连接redis
 */
function getRedis($config){
    $redis = new Redis();
    $rs = $redis->connect($config['host'], $config['post']);
    if ($rs){
        $db_num = isset($config['db']) ? $config['db'] : 1;
        $redis->select($db_num);
        return $redis;
    }else{
        return false;
    }
}