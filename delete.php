<?php
// 輸入
$guid=trim($argv[1]);

// 取得token
$string = file_get_contents("tcga_data/credentials.json");
$json_data = json_decode($string, true);
$key_id=$json_data["key_id"];
$api_key=$json_data["api_key"];

// 設定
$program="jnkns";
$project="jenkins";
$url_Origin= "https://google-gen4.biobank.org.tw";
$url_Target = "$url_Origin/api/v0/submission/$program/$project/";
$url_Referer = "$url_Origin/$program-$project";
$url_Token = "$url_Origin/user/credentials/cdis/access_token";


// 送出
$token = get_token($url_Token,$key_id,$api_key);
delete_data($url_Origin,$url_Target,$url_Referer,$guid,$token);

function get_token($url_Token,$key_id,$api_key){
        $data = json_encode(["key_id" => $key_id, "api_key" => $api_key]);
        $curl = curl_init($url_Token);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $tmp=curl_exec($curl);
        curl_close($curl);
        $arr=explode('"',$tmp);
        $access_token=$arr[3];
        return  $access_token;
}


function delete_data($url_Origin,$url_Target,$url_Referer,$guid,$token){
        $cmd="curl '".$url_Target."/entities/".$guid."' \
-X 'DELETE' \
-H 'Connection: keep-alive' \
-H 'sec-ch-ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"98\", \"Google Chrome\";v=\"98\"' \
-H 'Accept: application/json' \
-H 'Content-Type: application/json' \
-H 'x-csrf-token: ' \
-H 'sec-ch-ua-mobile: ?1' \
-H 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Mobile Safari/537.36' \
-H 'sec-ch-ua-platform: \"Android\"' \
-H 'Origin: ".$url_Origin."' \
-H 'Sec-Fetch-Site: same-origin' \
-H 'Sec-Fetch-Mode: cors' \
-H 'Sec-Fetch-Dest: empty' \
-H 'Referer: ".$url_Referer."' \
-H 'Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7,zh-CN;q=0.6' \
-H 'Cookie: _ga=GA1.3.2062287654.1645285323; _gid=GA1.3.1321658377.1645285323; access_token=".$token."' \
--compressed
";
 echo $cmd;
 exec($cmd);
}

