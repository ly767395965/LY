<?php
include '../clan_300.php';
/**
 * 通过对战日志批量查询部落信息
 */

$pdo_service = new pdoSerive($db_localhost);
$coc_api = new HttpUtils($api_cf);

$sql = "SELECT * FROM coc_clans";
$clans = $pdo_service->queryBySql($sql);
if ($clans){
    echo 'ok';
}else{
    echo 'no';
}
exit;

$start = 0;//开始位置
$get_num = 100; //一次查询的日志量
$count = 1;//轮数 或者 页数
$finish = 0;//用以判断结束的标志
$w_num = 0;
$run_num = 0;//跑的圈数

$logs_tab = 'coc_clans_war_log';//部落日志表
$logs_num = 1;//日志表后缀
$logs_max = 10;

$clan_info_tab = 'coc_clans_info';//部落详情表
$clan_info_num = 1;//详情表后缀
$clan_info_max = 10;

$logs_use = $logs_tab.$logs_num;
$clan_info_use = $clan_info_tab.$clan_info_num;
while (true){
    switch ($finish){
        case 1:
            echo 'HA HA!! Already completed!'."\r\n";
            break;
        case 2:
            echo 'Table is full!'."\r\n";
            break;
    }
    if ($finish > 0){
        echo 'Stop!';
        break;
    }

    $start = $start + $get_num * ($count - 1);
    $sql = "SELECT id,clan_tag1,clan_tag2 FROM {$logs_use} WHERE is_record = 0 LIMIT {$start},{$get_num}";
    $clan_logs = $pdo_service ->queryBySql($sql);

    if ($clan_logs){
        $finish = 0;
        foreach ($clan_logs as $val){
            $is_exist = clanIsExist($pdo_service,$val['clan_tag1']);
            if (!$is_exist){
                $data = getClanInfo($coc_api,$clan_tag);
                if ($data){
                    insertClan($pdo_service, $data);//添加索引表
                    $id = insertClanInfo($pdo_service, $clan_info_use, $data);//添加信息表
                    if ($id > 200000){//当一张表满了时 切换到下张表
                        $clan_info_num++;
                        if ($clan_info_num > $clan_info_max){
                            $finish = 1;//表已写完 结束
                            break;
                        }
                    }
                    $w_num++;
                    echo 'Finish '.$w_num."\r\n";
                }
            }

            $is_exist = clanIsExist($pdo_service,$val['clan_tag2']);
            if (!$is_exist){
                $data = getClanInfo($coc_api,$clan_tag);
                if ($data){
                    insertClan($pdo_service, $data);//添加索引表
                    $id = insertClanInfo($pdo_service, $clan_info_use, $data);//添加信息表
                    if ($id > 200000){//当一张表满了时 切换到下张表
                        $clan_info_num++;
                        if ($clan_info_num > $clan_info_max){
                            $finish = 1;//表已写完 结束
                            break;
                        }
                    }
                    $w_num++;
                    echo 'Finish '.$w_num."\r\n";
                }
            }

            $up_sql = "UPDATE {$logs_use} SET is_record = 1 WHERE id = {$val['id']}";
            $pdo_service->exexBySql($up_sql);
        }
        $count++;
    }else{
        $count = 1;
        $logs_num++;
        if ($logs_num > $logs_max){
            $finish = 2;//表已写完 结束
        }
        break;
    }

    if ($run_num > 1){
        echo 'Running tired'."\r\n";
        break;
    }
}

//判断部落是否存在
function clanIsExist($pdo,$clan_tag){
    $sql = "SELECT id FROM clans WHERE clan_tag = ?";
    $rs = $pdo->queryBySql($sql,[$clan_tag]);
    if ($rs){
        return true;
    }else{
        return false;
    }
}

//通过官方接口获取部落信息
function getClanInfo($coc_api, $clan_tag){
    $rs = $coc_api->reqCocApi('clan_info',['clanTag'=>$clan_tag]);
    if (!$rs['status']) return false;

    $content = json_decode($rs['content']);
    if (empty($content)) return false;
    return $content;
}

//添加部落索引信息
function insertClan($pdo, $data){
    $sql = "INSERT INTO coc_clans ('clan_tag', 'info_tab', 'logs_tab', 'update_time') VALUE (?, ?, ? ,?)";
    $ary = [
        $data['tag'],
        $data['info_tab'],
        $data['logs_tab'],
        $data['update_time'],
    ];
    return $pdo->exexBySql($sql,$ary);
}

//添加部落信息
function insertClanInfo($pdo, $tab, $data){
    $sql = "INSERT INTO {$tab} ('clan_tag', 'clan_name', 'description', 'type', 'location_id', 'badge_id', 'clan_level', 'clan_points', 'clan_versus_points', 'required_trophies', 'war_frequency', 'war_win_streak', 'war_wins', 'war_ties', 'war_losses', 'is_war_log_public', 'members') VALUE (?, ?, ? ,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    switch ($data->type){

    }

    $ary = [
        $data->tag,
        $data->name,
        $data->description,
        $data->type,
        $data->location->id,
    ];
    return $pdo->exexBySql($sql,$ary);
}

//保存图片信息
function saveImg(){

}

//查找图片id
function getImgId($url,$pdo){
    $pos = strripos($url,'/');
    if ($pos > 0){
        $rs = substr($url, $pos+1);
        $sql = 'SELECT * FROM ';
        $pdo->exexBySql();
    }else{
        return false;
    }
}

//添加成员索引信息
function addPlayer($pdo,$data){
    $sql = "INSERT INTO coc_players ('player_tag', 'clan_tag', 'update_time') VALUE ( ?, ? ,?)";
    $clan_tag = $data['tag'];
    $member_list = $data['memberList'];
    $time = $data['update_time'];
    $ary = array();
    foreach ($member_list as $val){
        $temp = array();
        $temp[] = $val['tag'];
        $temp[] = $clan_tag;
        $temp[] = $time;
        $ary[] = $temp;
    }
    return $pdo->exexBySql($sql,$ary,1);
}