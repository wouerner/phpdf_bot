<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Telegram;
use Config;

class TelegramController extends Controller
{
    public function index()
    {
        $update = Telegram::getWebhookUpdates();

        $this->falar($update);
    }

    public function webhook()
    {
        $update = Telegram::getWebhookUpdates();

        $this->falar($update);
    }

    public function manual()
    {
        $update = Telegram::getUpdates();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $path = public_path() . '/phpdfbot_public.pem';
        $token = Config::get('telegram.bot_token');
        // Or if you are supplying a self-signed-certificate
        $response = Telegram::setWebhook([
            'url' => "https://phpdfbot.wouerner.in/$token/index",
            'certificate' => $path
        ]);
        dd($response);

    }

    /**
     * Remove webhook.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Telegram::removeWebhook();
        dd($response);
    }

}
