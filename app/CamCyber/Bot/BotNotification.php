<?php

namespace App\CamCyber\Bot;

use TelegramBot;
use App\Http\Controllers\Controller;

class BotNotification extends Controller
{
    
    public static function Order($order){
        // $chatID = "747808881"; //server 

        $chatID = "-1001270503780";  //local
        // $chatID = "-1001347027599"; //server

        $str = ''; 
        $i = 1; 
        foreach($order->details as $detail){
$str.= $i.'. '.$detail->menu->name.' x '.$detail->pending_notification_qty.'
'; 
            $i++; 
        }

        $type = !is_null($order->last_notify_at) ? 'ហៅថែម':'ការកម្មង់ថ្មី'; 
        
        $botRes = TelegramBot::sendMessage([
            'chat_id' =>  $chatID, 
            'text' => '<b> '.$type.' : វិក័យបត្រលេខ #'.$order->receipt_number. '</b>
'.$str, 
            'parse_mode' => 'HTML'
        ]);

        return $botRes; 
        
    }

    public static function DeleteOrderNotification($deleteOrder){
        // $chatID = "747808881"; //server 

        $chatID = "-1001270503780";  //local
        // $chatID = "-1001347027599"; //server

        $botResDeleteOrder = TelegramBot::sendMessage([
            'chat_id' =>  $chatID, 
            'text' => '<b>Order has been cancel On Table: #'.$deleteOrder->table->number.' #'.$deleteOrder->receipt_number.'</b>', 
            'parse_mode' => 'HTML'
        ]);

        return $botResDeleteOrder; 
        
    }
}