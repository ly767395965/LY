<?php

$myfile = fopen("db.php", "r") or die("Unable to open file!");
echo fread($myfile,filesize("db.php"));
fclose($myfile);


function http_get($url, $timeOut = 5, $connectTimeOut = 5) {
    $oCurl = curl_init ();
    if (stripos ( $url, "http://" ) !== FALSE || stripos ( $url, "https://" ) !== FALSE) {
        curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, FALSE );
    }
    curl_setopt($oCurl, CURLOPT_URL, $url );
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_TIMEOUT, $timeOut);
    curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $connectTimeOut);
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