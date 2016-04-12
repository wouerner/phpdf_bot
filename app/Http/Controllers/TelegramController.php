<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Telegram;
use Config;

class TelegramController extends Controller
{
    public function webhook()
    {
        $update = Telegram::getWebhookUpdates();

        $update = end($update);
        $update = $update['message'];

        #$comando = explode(' ', $update['text']) ;
        #$chatId =  $update['chat']['id'] ;


        $this->falar($update);
    }

    public function manual()
    {
        $update = Telegram::getUpdates();

        dd($update);

        $update = end($update);
        $update = $update->recentMessage();

        $this->falar($update);
    }

    private function falar($update)
    {
        $comando = explode(' ', $update['text']) ;
        $chatId =  $update['chat']['id'] ;


        switch ($comando[1]) {
            case 'oi':
                Telegram::sendMessage(
                    [
                        'chat_id' => $chatId,
                        'text' => 'PHP é lindo!'
                    ]
                );

                break;
            case 'java':
                Telegram::sendMessage(
                    [
                        'chat_id' => $chatId,
                        'text' => 'Tenho um conhecido que falou: Java é mais perfomático que PHP! Hoje ele está desempregado'
                    ]
                );

                break;
            case 'noob':
                Telegram::sendMessage(
                    [
                        'chat_id' => $chatId,
                        'text' => 'Tenho um conhecido que falou: Java é mais perfomático que PHP! Hoje ele está desempregado'
                    ]
                );

                break;
            default:
                Telegram::sendMessage(
                    [
                        'chat_id' => $chatId,
                        'text' => 'Cesar Draw que eu conheço é muito noob!'
                    ]
                );

                break;
        }
    }

    public function create()
    {
        $token = Config::get('telegram.bot_token');

        $response = Telegram::setWebhook([
            'url' => "https://phpdfbot.wouerner.in/$token/webhook",
        ]);
        dd($response);
    }

    public function destroy($id)
    {
        $response = Telegram::removeWebhook();
        dd($response);
    }
}
