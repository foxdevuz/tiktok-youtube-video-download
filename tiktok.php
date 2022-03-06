<?php
error_reporting(0);
header('Content-Type: application/json');
$url = $_GET['url'];

function ajax($link)
{
    $curl = curl_init();
    $config = array(
        CURLOPT_URL            => "https://api.tikmate.app/api/lookup",
        CURLOPT_HTTPHEADER     => array(
            'origin: https://tikmate.app',
            'referer: https://tikmate.app/',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36'
        ),
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => 'url=' . $link
    );
    curl_setopt_array($curl, $config);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}

$modes = json_decode(ajax($url), true);

$response = array('ok'=> false, 'descrption'=> 'Missing a vaild url');
if( $url ) {
    if(strpos($url, 'tiktok.com') !== false ) {
        if( $modes ) {
            $response = array(
                'ok'=> true,
                'result' => [
                    'like'=> $modes['like_count'],
                    'comment'=> $modes['comment_count'],
                    'share'=> $modes['share_count'],
                    'created'=> $modes['create_time'],
                    'download'=> 'https://tikmate.app/download/' . $modes['token'] . '/' . $modes['id'] . '.mp4'
                ]
            );
        }
    }
    else
    {
        $response = array('ok'=> false, 'descrption'=> 'invaild tiktok url');
    }
}
echo json_encode($response);