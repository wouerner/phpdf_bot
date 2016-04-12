<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Irazasyed\Telegram\Telegram;
use Telegram;
use Config;

class TelegramController extends Controller
{
    private $db = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$update = (Telegram::getUpdates());
        $update = Telegram::getWebhookUpdates();

        $update = end($update);
        $update = $update->recentMessage();

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
    public function manual()
    {
        $update = Telegram::getUpdates();

        $update = end($update);
        $update = $update->recentMessage();

        dd($update);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = Config::get('telegram.bot_token');
        // Or if you are supplying a self-signed-certificate
        $response = Telegram::setWebhook([
            'url' => "https://phpdfbot.wouerner.in/$token/webhook",
            'certificate' => '/etc/apache2/ssl/phpdfbot_public.pem'
        ]);
        dd($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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
