<?php
// ¡Ã³ÕµéÍ§¡ÒÃµÃÇ¨ÊÍº¡ÒÃá¨é§ error ãËéà»Ô´ 3 ºÃÃ·Ñ´ÅèÒ§¹ÕéãËé·Ó§Ò¹ ¡Ã³ÕäÁè ãËé comment »Ô´ä»
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// include composer autoload
require_once './vendor/autoload.php';
 
// ¡ÒÃµÑé§à¡ÕèÂÇ¡Ñº bot
require_once 'bot_settings.php';
 
// ติดต่อฐานข้อมูล
//require_once("dbconnect.php");
 
///////////// ÊèÇ¹¢Í§¡ÒÃàÃÕÂ¡ãªé§Ò¹ class ¼èÒ¹ namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
 
// àª×èÍÁµèÍ¡Ñº LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// ¤ÓÊÑè§ÃÍÃÑº¡ÒÃÊè§¤èÒÁÒ¢Í§ LINE Messaging API
$content = file_get_contents('php://input');
 
// á»Å§¢éÍ¤ÇÒÁÃÙ»áºº JSON  ãËéÍÂÙèã¹â¤Ã§ÊÃéÒ§µÑÇá»Ã array
$events = json_decode($content, true);
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    switch ($typeMessage){
        case 'text':
            switch ($userMessage) {
                case "เว็บโรงพยาบาล":
                    $textReplyMessage = "http://www.bphosp.or.th/";
                    break;
                case "สวัสดี":
                    $textReplyMessage = "สวัสดีครับ";
                    break;
                default:
                    $textReplyMessage = "http://61.90.186.213/line-bot-api-master/dbconnect.php";
                    break;                                      
            }
            break;
        default:
            $textReplyMessage = json_encode($events);
            break;  
    }
}
// ส่วนของคำสั่งจัดเตียมรูปแบบข้อความสำหรับส่ง
$textMessageBuilder = new TextMessageBuilder($textReplyMessage);
 
//l ÊèÇ¹¢Í§¤ÓÊÑè§µÍº¡ÅÑº¢éÍ¤ÇÒÁ
$response = $bot->replyMessage($replyToken,$textMessageBuilder);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
 
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>
