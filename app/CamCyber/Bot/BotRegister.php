<?php

namespace App\CamCyber\Bot;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotRegister extends Controller
{

public static function newRegister($user, $chanel = "JongTinh", $code = ""){
    $chatID = env('JONGTINH_CHANNEL_ID', '-1001224190361'); 

    $ID         = $user->id ?? '';
    $Phone      = $user->phone ?? '';
    $Chanel     = $chanel ?? '';
    $Code       = $code ?? '';
    $Name       = $user->name ?? '';
    $Created    =  Carbon::parse($user->created_at  ?? '')->format('d M Y h:i:s a');

    $text =
    "- ID: $ID\n" 
    ."-  Phone:$Phone\n" 
    ."- Chanel: $Chanel\n"
    ."- Code: $Code\n"
    ."- Name: $Name\n"
    ."- Created Date: $Created\n"

    ;
    $res = Telegram::sendMessage([
        'chat_id' => $chatID, 
        'text' => $text,  
        'parse_mode' => 'HTML'
    ]);
    return $res; 
}
  
 
}
