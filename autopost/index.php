<?php 

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/facebook-sdk/');
require_once __DIR__.'/facebook-sdk/autoload.php';

/////////////// APP CONFIG ////////////

$page_id =" "; // your page id
$appId = " "; // your app id
$appSecret = ""; /// app secret
$access_token=""; // The access token you receieved 

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