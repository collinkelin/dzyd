<?php

include 'config.php';
$url = "http://127.0.0.1:81/paytype/jinzhuanPay/sycNotice.php?sign=jason&name=hellow&key=123456";
$dataArray = array(
'test1'=>1,
'test2'=>2,
);
$res = $Db->curl_post($url, $dataArray);
print_r($res);
?>