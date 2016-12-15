<?php 

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/facebook-sdk/');
require_once __DIR__.'/facebook-sdk/autoload.php';

/////////////// APP CONFIG ////////////

$page_id ='575140232647743';
$appId = '116039698811536';
$appSecret = '59095f05e7b1c1ce2203b4716bf2dfa2';
$access_token="EAABpiZAkHCpABAPrPAlbYrIl6brnIZC1hi44Rvd7BXWIG2cqRo46uJehSZAEPysJlhG6hjv7ZC7XHXFH0JjFcBtIwirebSYITPRWySHzwKbqoukch1fPzZAqhPN7ZA4RWSjeCQd15IZAiWZC3BZBQaSEt"; // The access token you receieved above

/////////////// END APP CONFIG ////////////

$fb = new Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.6',
]);

try {
    $res = $fb->get('/me/accounts',$access_token)->getDecodedBody();

    if (isset($res['data'])) {
        foreach ($res['data'] as $account) {
            if ($page_id == $account['id']) {
                $page_token = $account['access_token'];
                break;
            }
        }
    }
} catch (Exception $e){

    echo "Error ! ".$e->getMessage();
}

//////////////////// AUTO POST CONTENT SECTION ////////////////

$message = "Hello Dharma !";

$post = array('access_token' => $page_token, 'message' => $message);

try{
    $res = $fb->post("/$page_id/feed",$post);
    echo "Succesfully posted on page";
} catch (Exception $e){
    echo $e->getMessage();
}

?>