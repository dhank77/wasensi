<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Http;

class SendController extends Controller
{
    public function index()
    {
        $session = request('name');
        $receiver = request('receiver');
        $message = request('message');
        $code = request('code');

        $send = [
            'jid' => format62($receiver) . "@s.whatsapp.net",
            'type' => "number",
            'message' => [
                'text' => $message,
            ],
        ];

        $number_server = Device::inRandomOrder()->first();

        $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);

        $res = json_decode($response->body());

        $try = 1;
        if(property_exists($res, 'key')){
            return [
                'status' => true,
                'number' => $number_server,
                'try' => $try,
            ];
        }
        if(property_exists($res, 'error')){
            $sendGagal = [
                'jid' => "6282396151291@s.whatsapp.net",
                'type' => "number",
                'message' => [
                    'text' => "Oi ada nomor tidak connect $number_server->no_hp",
                ],
            ];
            
            $number_server = Device::inRandomOrder()->where('id', '!=', $number_server->id)->first();
            Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $sendGagal);

            $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);
            $res = json_decode($response->body());

            if(property_exists($res, 'key')){
                $try += 1;
                return [
                    'status' => true,
                    'number' => $number_server,
                    'try' => $try,
                ];
            }
        }

        return [
            'status' => false,
            'number' => $number_server,
            'try' => $try,
        ];
    }
}
