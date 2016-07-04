<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Telegram;
use Config;
use GuzzleHttp\Client;
use Storage;

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

        //dd($update);

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
                Telegram::sendPhoto([
                    'chat_id' => $chatId,
                    'photo' => public_path().'/noob.jpg',
                    'caption' => 'Noob!!!'
                ]);

                break;
            case 'tirinhas':
                $this->tirinhas($chatId);
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

    public function tirinhas($chatId)
    {
        $update = Telegram::getUpdates();

        $client = new Client();
        $res = $client->request('GET', 'http://vdpr.org/rand');
        //echo $res->getStatusCode();
        //echo $res->getHeader('content-type');
         $text = ($res->getBody()->getContents());

        $dom = new \DOMDocument('1.0');
        @$dom->loadHTML($text);

        $l = '/html/body/div[2]/div/div[3]/div[2]/div/article/p[1]/a/img';
        $xpath = new \DOMXPath($dom);
        // returns a list of all links with rel=nofollow
        $nlist = $xpath->query($l);

        $img =null;
        foreach($nlist as $n){
             $img= $n->getAttribute('src');
        }

        $file = file_get_contents($img);

        $rand = rand();

        Storage::disk('local')->put($rand.'.png', $file);

        $path = storage_path('app/'.$rand.'.png');
        //dd($path);

        //die;

        Telegram::sendPhoto([
            'chat_id' => $chatId,
            'photo' => $path,
            'caption' => ''
        ]);

        //header("content-type: image/png");
        //echo $file;
    }

}
