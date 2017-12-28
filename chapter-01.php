<?php

include ('line-bot.php');

$channelSecret = '81e31b8c15d77bef991fd13caae85506';
$access_token  = '7EmpPR9GthiSeWpv1q0dBDMlUi7DoYwdVTTkPcnod2IcMAwZ5qXnT6t0ZE+YJw3aqbZwl++iEfa2GkAR1yoQ4nZDxwNmNfMkzsnOTBZj7d2qsfYx2hOWU8BNgH8AqjjuGWAR6FDkoS2TL9ktLPWpPgdB04t89/1O/w1cDnyilFU=';

$bot = new BOT_API($channelSecret, $access_token);
	
if (!empty($bot->isEvents)) {
		
    $bot->replyMessageNew($bot->replyToken, json_encode($bot->message));

    if ($bot->isSuccess()) {
        echo 'Succeeded!';
        exit();
    }

    // Failed
    echo $bot->response->getHTTPStatus . ' ' . $bot->response->getRawBody(); 
    exit();

}
