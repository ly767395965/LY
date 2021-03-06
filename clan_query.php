<?php
/**
 * 服务函数文件: 根据部落战日志情况,查询其他部落的对战日志并记录
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
    'key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImIwYzUxODhmLWQ3NzEtNDgxOC04YTkwLTZkNmY1ZTM3YjAyNiIsImlhdCI6MTUzNzMyNDQ1OSwic3ViIjoiZGV2ZWxvcGVyL2E3NjM3MGY1LWU1Y2YtMzdiNy0yNzAzLWZkNmQ4NGQ0NGRkMyIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjU4LjQyLjIzMS4yNDQiXSwidHlwZSI6ImNsaWVudCJ9XX0.-fmjpEL4bMlISFkMl9wkQf2LH3Wu5AM3zzcV3ae4WHBJWUMfjmasJWQmsG-lSvCQasU3Q1_Ns_gmd1x-ldGg3w',  //cocapi请求key
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
    $http_util = new HttpUtils($api_cf);
    $pdo = new pdoSerive($db_localhost);

    $tab_record = array();
    $tab_record['tab_name'] = 'coc_clans_war_log';
    $tab_record['tab_num'] = 3; //从那张表开始写
    $tab_record['tab'] = $tab_record['tab_name'].$tab_record['tab_num'];//写入表

    $tab_record['query_tab_num'] = 1;//从那张表开始查
    $tab_record['query_tab'] = $tab_record['tab_name'].$tab_record['query_tab_num'];//查询表

//    $war_logs = CommonFun::queryWarlog($http_util,'#RYUJ902L', $pdo, $tab);
    $start = microtime(true);
    $i = 0;//记录成功数
    $error_count = 0;//记录失败数
    $exam_time = 10;//检测时间段 单位:minute
    $exam_last = 0;

    while (true){
        $sql = "SELECT id,clan_tag2,clan_name2 FROM {$tab_record['query_tab']} WHERE is_record = 0 ORDER BY add_time ASC LIMIT 1";
        $clan = $pdo->queryBySql($sql);
        if ($clan){
            $clan = $clan[0];
            $war_logs = CommonFun::queryWarlog($http_util,$clan['clan_tag2'], $pdo,$tab_record['tab']);
            if ($war_logs){
                $sql = "UPDATE {$tab_record['query_tab']} SET is_record = 1 WHERE id=?";
                $i++;
            }else{
                $sql = "UPDATE {$tab_record['query_tab']} SET is_record = 3 WHERE id=?";
                $error_count++;
            }
        }else{
            $tab_record['query_tab_num']++;
            if ($tab_record['query_tab_num'] > $tab_record['tab_num']){//判断查询的表是否超过写入的表,如果超过,这说明已处理完成
                echo 'The All End! :'.$use_time. ' success:'.$i. ' error:'.$error_count."\r\n";
                break;
            }
            $tab_record['query_tab'] = $tab_record['tab_name'].$tab_record['query_tab_num'];
        }
        $pdo->exexBySql($sql,[$clan['id']]);
        $use_time = microtime(true) - $start;
        $use_time = round($use_time/60);

        if ($use_time - $exam_last >= $exam_time){
            $exam_last = $use_time;
            $sql = "SELECT COUNT(id) as num FROM {$tab_record['tab']}";
            $log_num = $pdo->queryBySql($sql);

            if ($log_num[0]['num'] > 100000){
                $tab_record['tab_num']++;
                if ($tab_record['tab_num'] > 10){//判断是否超出当前库中存储表数量
                    echo 'Tab is full! :'.$use_time. ' success:'.$i. ' error:'.$error_count."\r\n";
                    break;
                }
                $tab_record['tab'] = $tab_record['tab_name'].$tab_record['tab_num'];
            }
        }

        echo 'success:'.$i.' error:'.$error_count.' cost_time:'.$use_time."\r\n";
    }

    exit('QAQ!!!');

//    $rs = $http_util->reqCocApi('locations_players',['locationId'=>'32000007'],['limit'=>120, 'after'=>'eyJwb3MiOjEyMH0']);
    $rs = $http_util->reqCocApi('clan_warlog',['clanTag'=>'#L8YRPL89']);

    $redis = getRedis($redis_conf);
    $api_key = $redis->get('config:api_key');//获取设置的key
    if ($api_key) $api_cf['key'] = $api_key;

    CommonFun::signOut($redis, 'currentwar300:sign_out', 1);//判断将要退出本次操作
    CommonFun::lock($redis, 'currentwar300:lock', 1);//判断将要进行的操作是否锁住,及给当前进程加锁

    $op_start = $redis->get('currentwar300:op_start');//操作开始的score
    $op_num = $redis->get('currentwar300:op_num');//获取操作的数量
    $time = time()+300;
    $clan_arys = $redis->zRangeByScore('waring',$op_start,$time,array('limit'=>array(0,$op_num)));//获取待操作数据
    $clan_scores = $redis->zRangeByScore('waring',$op_start,$time,array('withscores'=>true,'limit'=>array(0,$op_num+1)));//获取待操作scores
    $clan_num = count($clan_scores);

    if ($clan_num <= $op_num){
        $redis->setex('currentwar300:sign_out',240,1);//设置时长为四分钟的休息标识
        $redis->set('currentwar300:op_start',$time);//设置下一组开始的score
    }else{
        $redis->set('currentwar300:op_start',end($clan_scores));//设置下一组开始的score
    }
    $redis->set('currentwar300:lock',0);//已拿取到数据解开锁

    foreach ($clan_arys as $key => $val){
        if ($val){
            $double_clans = explode('|', $val);
            $war_res = $http_util->reqCocApi('clan_currentwar',['clanTag'=>'#'.$double_clans[0]]);
            if ($war_res['status']){
                $content = json_decode($war_res['content']);
                /*if (isset()){

                }*/
            }
        }
    }

}catch (\Exception $e){
    exit( 'error:'.$e->getMessage() );
}


//$redis->zAdd('key', 1, 'val1');
//$redis->zAdd('key', 0, 'val0');
//$redis->zAdd('key', 5, 'val5');
//$redis->zAdd('key', 2, 'val2');
//$redis->zAdd('key', 10, 'val10');
//$rs = $redis->zRange('key', 0, -1,true);
$clan_start = $redis->zRangeByScore('key',1,11,array('withscores'=>false,'limit'=>array(0,5)));
//$rs = $redis->set('test',1);
//$rs = $redis->get('test');
var_dump($clan_start);

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
    public function insertBySql($sql, $where=array(),$type=0){
        $pdo = $this->db_connect();
        $sth = $pdo->prepare($sql);//预处理sql
        $pdo = null;
        $rs_ex = $sth->execute($where);
        if ($rs_ex){
            $insert_id = $pdo->lastInsertId();
            return $insert_id;//获取插入的自增id
        }else{
            return false;
        }
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

class CommonFun {
    //判断是否退出执行程序
    public static function signOut($redis, $key, $out_str){
        $val = $redis->get($key);
        if ($val == $out_str) exit;
        return true;
    }

    //判断是否有锁及加锁
    public static function lock($redis, $key, $is_lock){
        $val = $redis->get($key);
        while (true){
            if ($val == $is_lock){
                sleep(1);
            }else{
                break;
            }
        }
        $redis->setex($key,60,$is_lock);
        return true;
    }

    public static function addsignOut(){
//        $test = $GLOBALS['test'];
//        print_r($test);
    }

    public static function queryWarlog($http_util,$clan_tag,$pdo,$tab){ //$tab是写入的表,并不是判断部落是否存在的表
        $rs = $http_util->reqCocApi('clan_warlog',['clanTag'=>$clan_tag]);
        if ($rs['status']){
            if ($rs['content']){
                $content = json_decode($rs['content']);
                if (isset($content->items)){
                    self::addWarLog($pdo,$content->items,$tab);
                }
            }
            return $rs['content'];
        }else{
            return false;
        }
    }

    public static function queryClan($http_util,$clan_tag,$pdo){
        $rs = $http_util->reqCocApi('clan_info',['clanTag'=>$clan_tag]);
        if ($rs['status']){
            return $rs['content'];
        }else{
            return false;
        }
    }

    public static function addWarLog($pdo,$data,$tab){
        $insert_ary = array();
        $update_ary = array();
        $tab_record = $GLOBALS['tab_record'];
        $tab_num = $tab_record['tab_num'];
        $query_tab_num = $tab_record['query_tab_num'];
        $round = $tab_num - $query_tab_num;

        foreach ($data as $key => $val){
            $clan_tag = $val->clan->tag;
            $opponent_tag = $val->opponent->tag;
            $where = array([$clan_tag, $opponent_tag], [$opponent_tag, $clan_tag]);

            for ($i=0; $i<= $round; $i++){
                $check_tab = $tab_record['tab_name'] . ($query_tab_num+$i);
                $sql_query = "SELECT id,attacks2 FROM {$check_tab} WHERE clan_tag1 = ? AND clan_tag2 = ?";
                $rs = $pdo->queryBySql($sql_query,$where, 1);
                if ($rs){
                    break;
                }
            }
            if (!isset($rs[0]) && !isset($rs[1])){
                switch ($val->result){
                    case 'win':
                        $val->result = 1;
                        break;
                    case 'lose':
                        $val->result = 0;
                        break;
                    default:
                        $val->result = 2;
                }
                $val->endTime = self::opTime($val->endTime);
                if ($val->teamSize === null){
                    continue;
                }

                $insert_ary[] = array(
                    $val->clan->tag,
                    $val->result,
                    $val->endTime,
                    $val->teamSize,
                    $val->clan->name,
                    $val->clan->clanLevel,
                    $val->clan->attacks,
                    $val->clan->stars,
                    $val->clan->destructionPercentage === null ? -1 : $val->clan->destructionPercentage,
                    $val->clan->expEarned,
                    $val->opponent->tag,
                    $val->opponent->name,
                    $val->opponent->clanLevel,
                    $val->opponent->stars,
                    $val->opponent->destructionPercentage === null ? -1 : $val->opponent->destructionPercentage,
                    time()
                );
            }else{
                if (isset($rs[1]) && $rs[1]['attacks2'] == -1){
                    $update_ary[] = array(
                        $val->clan->attacks,
                        $val->clan->expEarned,
                        $rs[1]['id']
                    );
                }
            };
        }
        if (!empty($insert_ary)){
            $sql = "INSERT INTO {$tab} (clan_tag1,result,end_time,team_size,clan_name1,clan_level1,attacks1,stars1,percentage1,exp_earned1,clan_tag2,clan_name2,clan_level2,stars2,percentage2,add_time) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $pdo->exexBySql($sql,$insert_ary,1);
        }

        if (!empty($insert_ary)){
            $sql = "UPDATE {$check_tab} SET attacks2=?,exp_earned2=? WHERE id=?";
            $pdo->exexBySql($sql,$update_ary,1);
        }
        return true;
    }

    //生成随机数
    public static function create_guid_md5($prefix=null){
        // mt_rand() 马特赛特旋转演算法，可以快速产生高质量的伪随机数，修正了古老随机数产生算法的很多缺陷
        return strtolower(md5(uniqid($prefix . mt_rand(), true)));
    }

    //分割时间串,并转换为UTC+8 时间
    public static function opTime($str){
        $str = substr($str, 0, 15);
        $ary = explode("T",$str);
        $ary[0] = substr_replace($ary[0],'-',-2,0);
        $ary[0] = substr_replace($ary[0],'-',-5,0);
        $ary[1] = substr_replace($ary[1],':',-2,0);
        $ary[1] = substr_replace($ary[1],':',-5,0);
        return strtotime($ary[0].' '.$ary[1])+28800;
    }
}