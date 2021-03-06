<?php
/**
 * 服务函数文件: 查询部落战情况,并记录
 */
$db_localhost = array(
    'host' => '127.0.0.1',
    'username'=>'root',
    'password'=>'',
    'database'=>'coc',
    'port' => '3306',
    'charset'=>'utf8'
);
$redis_conf = array('host'=>'127.0.0.1', 'port'=>6379, 'db'=>1);
$api_cf = array(
    'key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6IjNkMzVkMTZhLTk1NjUtNDMzYS05NmY3LWVkZjhmYWZmN2YzOSIsImlhdCI6MTUzNzQ1MDk4Mywic3ViIjoiZGV2ZWxvcGVyL2E3NjM3MGY1LWU1Y2YtMzdiNy0yNzAzLWZkNmQ4NGQ0NGRkMyIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjEuMjA0LjkuODAiXSwidHlwZSI6ImNsaWVudCJ9XX0.fZv0A-LSDdqk4JXxu-PKUISCpIJzZpgXlD-7i3n8o20QRU48cBjkGme0yBNeruRzbSuMZcijYNLaU8oDdDASdA',  //cocapi请求key
    'all_url' => 'https://api.clashofclans.com/v1', //总url

    'clans' => array('url' => '/clans'),
    'clan_info' => '/clans/{clanTag}',  //查询clan具体情况
    'clan_member' => '/clans/{clanTag}/members', //查询clan成员信息
    'clan_warlog' => '/clans/{clanTag}/warlog',  //对战日志
    'clan_currentwar' => '/clans/{clanTag}/currentwar', //当前对战情况
    'locations' => '/locations', //获取所有可用地区
    'locations_players' => '/locations/{locationId}/rankings/players',
    'leagues' => '/leagues',
    'lea_id' => '/leagues/{leagueId}',
    'lea_seasons' => '/leagues/{leagueId}/seasons', //查看杯段赛季(仅限传奇)
    'lea_season_info' => '/leagues/{leagueId}/seasons/{seasonId}',
    'players' => '/players/{playerTag}'
);
try{
//    $http_util = new HttpUtils($api_cf);
////    $rs = $http_util->reqCocApi('locations_players',['locationId'=>'32000007'],['limit'=>120, 'after'=>'eyJwb3MiOjEyMH0']);
//    $rs = $http_util->reqCocApi('clan_currentwar',['clanTag'=>'#L8YRPL89']);
//    print_r($rs);
//    exit;
//
//    $redis = getRedis($redis_conf);
//    $api_key = $redis->get('config:api_key');//获取设置的key
//    if ($api_key) $api_cf['key'] = $api_key;
//
//    CommonFun::signOut($redis, 'currentwar300:sign_out', 1);//判断将要退出本次操作
//    CommonFun::lock($redis, 'currentwar300:lock', 1);//判断将要进行的操作是否锁住,及给当前进程加锁
//
//    $op_start = $redis->get('currentwar300:op_start');//操作开始的score
//    $op_num = $redis->get('currentwar300:op_num');//获取操作的数量
//    $time = time()+300;
//    $clan_arys = $redis->zRangeByScore('waring',$op_start,$time,array('limit'=>array(0,$op_num)));//获取待操作数据
//    $clan_scores = $redis->zRangeByScore('waring',$op_start,$time,array('withscores'=>true,'limit'=>array(0,$op_num+1)));//获取待操作scores
//    $clan_num = count($clan_scores);
//
//    if ($clan_num <= $op_num){
//        $redis->setex('currentwar300:sign_out',240,1);//设置时长为四分钟的休息标识
//        $redis->set('currentwar300:op_start',$time);//设置下一组开始的score
//    }else{
//        $redis->set('currentwar300:op_start',end($clan_scores));//设置下一组开始的score
//    }
//    $redis->set('currentwar300:lock',0);//已拿取到数据解开锁
//
//    foreach ($clan_arys as $key => $val){
//        if ($val){
//            $double_clans = explode('|', $val);
//            $war_res = $http_util->reqCocApi('clan_currentwar',['clanTag'=>'#'.$double_clans[0]]);
//            if ($war_res['status']){
//                $content = json_decode($war_res['content']);
//                /*if (isset()){
//
//                }*/
//            }
//        }
//    }

}catch (\Exception $e){
    echo 'error:'.$e->getMessage();
}


//$redis->zAdd('key', 1, 'val1');
//$redis->zAdd('key', 0, 'val0');
//$redis->zAdd('key', 5, 'val5');
//$redis->zAdd('key', 2, 'val2');
//$redis->zAdd('key', 10, 'val10');
//$rs = $redis->zRange('key', 0, -1,true);
//$clan_start = $redis->zRangeByScore('key',1,11,array('withscores'=>false,'limit'=>array(0,5)));
//$rs = $redis->set('test',1);
//$rs = $redis->get('test');
//var_dump($clan_start);

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
    public function queryBySql($sql, $where=array(),$type=0){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
        $pdo = null;
        if ($type == 0){
            $sth->execute($where);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);//获取结果集
        }else{
            $result = array();
            foreach ($where as $key => $val){
                $sth->execute($val);
                $tmp = $sth->fetchAll(PDO::FETCH_ASSOC);//获取结果集
                if ($tmp){
                    if ($type == 1){
                        foreach ($tmp as $v){
                            $result[$key] = $v;
                        }
                    }else{
                        $result[$key] = $tmp;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 执行更新,插入,删除sql  返回影响行数
     */
    public function exexBySql($sql, $where=array(),$type=0){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
        $pdo = null;
        if ($type == 0){
            $sth->execute($where);
        }else{
            foreach ($where as $val){
                $sth->execute($val);
            }
        }
        return $sth->rowCount();//获取影响行数(循环执行也返回的是1)
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
            $pdo = null;
            return false;
        }
    }

    /**
     * 插入数据
     * @param $table
     * @param $data 以字段名为键的一维数组
     * @return bool 返回插入的数据id,或者false
     */
    public function add($table,$data){
        if (!is_array($data) && count($data) == 0) return false;

        $where = array();
        $filed_str = '';
        $val_str = '';
        foreach ($data as $key=>$val){
            $filed_str .= $key.',';
            $val_str .= '?,';
            $where[] = $val;
        }
        $filed_str = rtrim($filed_str, ",");
        $val_str = rtrim($val_str, ",");

        $sql = "INSERT INTO {$table} ({$filed_str}) VALUE ({$val_str})";
        return $this->insertBySql($sql,$where);
    }

    /**更新数据
     * @param $table
     * @param $data  以字段名为键的一维数组
     * @param $where 条件语句
     * @param string $wh_ary 条件语句中的参数
     * @return bool|int 返回false或者影响行数
     */
    public function update($table,$data,$where='',$wh_ary=''){
        if (!is_array($data) && count($data) == 0) return false;

        $update_str = '';
        $update_ary = array();
        foreach ($data as $key => $val){
            $update_str .= $key.'=?,';
            $update_ary[] = $val;
        }

        if ($wh_ary){
            $update_ary = array_merge($update_ary,$wh_ary);
        }
        $update_str = rtrim($update_str, ",");
        $sql = "UPDATE {$table} SET {$update_str}";
        if ($where){
            $sql .= " WHERE {$where}";
        }
        return $this->exexBySql($sql,$update_ary);
    }

}

function getRedis($config){
    $redis = new Redis();
    $rs = $redis->connect($config['host'], $config['port']);
    if (isset($config['db'])) $redis->select($config['db']);
    if ($rs){
        return $redis;
    }else{
        return false;
    }
}

class HttpUtils {
    private $api_config;

    public function __construct($config){
        $this->api_config = $config;
    }
    /**
     * 发起GET请求(此方法包含了,coc_api key 专门用于发起coc接口请求)
     *
     * @param string $url
     * @return string content
     */
    public function http_coc($url,$headers, $timeOut = 10, $connectTimeOut = 5) {
        $oCurl = curl_init ();
        if (stripos ( $url, "http://" ) !== FALSE || stripos ( $url, "https://" ) !== FALSE) {
            curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
            curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, FALSE );
        }
        curl_setopt($oCurl, CURLOPT_URL, $url );
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $connectTimeOut);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);
        $sContent = curl_exec ( $oCurl );
        $aStatus = curl_getinfo ( $oCurl );
        $error = curl_error( $oCurl );
        curl_close ( $oCurl );
        if (intval ( $aStatus ["http_code"] ) == 200) {
            return array(
                'status' => true,
                'content' => $sContent,
                'code' => $aStatus ["http_code"],
            );
        } else {
            return array(
                'status' => false,
                'content' => json_encode(array("error" => $error, "url" => $url)),
                'code' => $aStatus ["http_code"],
            );
        }
    }

    //发起cocapi接口请求
    public function reqCocApi($name, $must_param='',$choice_param='', $timeOut = 10, $connectTimeOut = 5){
        $api_config = $this->api_config;
        $url = $api_config['all_url'];
        $api_key = $api_config['key'];

        $api_name = $api_config[$name];
        if (is_string($api_name)){
            $url .= $api_name;
            if ($must_param != ''){
                foreach ($must_param as $key => $val){
                    $key = '{'.$key.'}';
                    $val = urlencode($val);
                    $url = str_replace($key, $val, $url); //将url中的参数字符替换成参数
                }
            }
        }else{
            $url .= $api_name['url'];
        }
        if ($choice_param != ''){
            $url .= '?';
            foreach ($choice_param as $key => $val){
                if ($val){
                    $url .= $key.'='.urlencode($val).'&';
                }
            }
            $url = rtrim($url,'&');
        }
        $headers = array(
            'authorization: Bearer '.$api_key
        );

        return $this->http_coc($url, $headers, $timeOut, $connectTimeOut);
    }
}