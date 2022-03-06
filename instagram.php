<?php 
header("Content-Type: application/json; charset=UTF-8");
if($_GET['vid']){
  $curl = curl_init();
  curl_setopt($curl , CURLOPT_URL , "https://downloadgram.org/#downloadhered");
  curl_setopt($curl , CURLOPT_POST , true);
  curl_setopt($curl , CURLOPT_RETURNTRANSFER , true);
  curl_setopt($curl , CURLOPT_HTTPHEADER ,array("referer: https://downloadgram.org/","user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36"));
  curl_setopt($curl , CURLOPT_POSTFIELDS , array("url" =>$_GET['vid']));
  $result = curl_exec($curl);
  curl_close($curl);
  for ($i=1; $i < count(explode('<a download=',$result)); $i++) {
    preg_match('#rel="noopener noreferrer" href="(.*?)"#',explode('<a download=',$result)[$i],$url_download);
    $headers = get_headers($url_download[1], 1);
    $bytes   = $headers["Content-Length"];
    $Type   = $headers["Content-Type"];
  }
  echo json_encode(["ok"=>"true","url"=>$url_download[1], "type"=>$Type,"bytes"=>(int) $bytes],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}else{
  echo json_encode(["Result"=>"GET:null"],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}   