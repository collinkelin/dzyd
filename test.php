<?php
date_default_timezone_set('Asia/shanghai');
//echo date('Y-m-d H:i:s');exit;
function getSignature($str, $key) {
    $signature = "";
    if (function_exists('hash_hmac')) {
        $signature = base64_encode(hash_hmac("sha1", $str, $key, true));
    } else {
        $blocksize = 64;
        $hashfunc = 'sha1';
        if (strlen($key) > $blocksize) {
            $key = pack('H*', $hashfunc($key));
        }
        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack(
            'H*', $hashfunc(
                ($key ^ $opad) . pack(
                    'H*', $hashfunc(
                        ($key ^ $ipad) . $str
                    )
                )
            )
        );
        $signature = base64_encode($hmac);
    }
    return $signature;
}


$url = "http://dysmsapi.ap-southeast-1.aliyuncs.com/";

// Setup request to send json via POST
$time_iso8601_type = substr(date('c',time()-8*3600),0,-6).'Z';
$data = array(
    'Action' => 'SendMessageToGlobe',
    'Message' => '你的验证码是111111',
    'To' => '1245533267',
    'TaskId' => '100001',
    'Format' => 'JSON',
    'Version' => '2018-05-01',
    'AccessKeyId' => 'LTAI4GH7shb9zZ5kTJaxfACF',
//    'Timestamp' => '2020-12-27T15:54:00Z',
    'Timestamp' => $time_iso8601_type,
    'SignatureNonce' => 'ACadYad'.time(),
);
$CanonicalizedLOGHeaders = 'x-log-apiversion:0.6.0\nx-log-bodyrawsize:50\nx-log-signaturemethod:hmac-sha1';
$CanonicalizedResource = '/logstores/';

$DATE = 'Mon,3 Jan 2010 08:33:47 GMT';
$time_rfc_type = gmdate(DATE_RFC1123);
echo gmdate(DATE_RFC1123);exit;
$SignString = 'POST'.'\n'.'\n'.'\n'.date('GMT');
$AccessKeyId = 'LTAI4GH7shb9zZ5kTJaxfACF';
$AccessKeySecret = 'HZ7D9wvjhEi9LptEZeDlkGaC9SPzEg';
//$Signature = base64(hash_hmac('sha256',$SignString,$AccessKeySecret));
$Signature = getSignature($SignString,$AccessKeySecret);
//$pre_json_str = json_encode( $data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array("x-log-signaturemethod:hmac-sha1"));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization:LOG" . $AccessKeyId .":". $AccessKeySecret));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
var_dump(json_decode($result,true));
