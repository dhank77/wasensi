<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Member;
use Illuminate\Support\Facades\Http;

class SendController extends Controller
{
    public function index()
    {
        $session = request('name');
        $receiver = request('receiver');
        $message = request('message');
        $code = request('code');

        $rand = randString();

        $user = Member::where('name', strtolower($session))->where('code', $code)->first();

        if(!$user){
            return [
                'status' => false,
                'messages' => 'User not exist'                
            ];
        }

        if(!str_contains(strtolower($message), strtolower($session))){
            return [
                'status' => false,
                'messages' => 'User not found'                
            ];
        }

        if(strtotime('now') > strtotime($user->expired_date)){
            if($user->no_pj != "" && $user->notif_pj == 0){
                $sendPj = [
                    'jid' => format62($user->no_pj) . "@s.whatsapp.net",
                    'type' => "number",
                    'message' => [
                        'text' => "Mohon maaf waktu berlangganan WA-Server anda telah habis!",
                    ],
                ];
                $user->update(['notif_pj' => 1]);
                $number_server = Device::inRandomOrder()->first();
                $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $sendPj);
                $res = json_decode($response->body());
            }


            return [
                'status' => false,
                'messages' => 'Member is expired'                
            ];
        }

        $message = $message . "
kodeRef: $code-$rand
";

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
