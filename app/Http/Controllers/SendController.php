<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Member;
use App\Models\Pesan;
use Illuminate\Support\Facades\Http;

class SendController extends Controller
{
    public function index()
    {
        $session = request('name');
        $receiver = request('receiver');
        $message = request('message');
        $code = request('code');

        $rand = randString(15);

        $user = Member::where('name', strtolower($session))->where('code', $code)->first();

        if (!$user) {
            return [
                'status' => false,
                'messages' => 'User not exist'
            ];
        }

        if (!str_contains(strtolower($message), strtolower($session))) {
            return [
                'status' => false,
                'messages' => 'User not found'
            ];
        }

        if (strtotime('now') > strtotime($user->expired_date)) {
            return [
                'status' => false,
                'messages' => 'Member is expired'
            ];
        }

        $message = str_replace([".co.id", ".go.id", ".com", ".id", ".sch.id"], "", $message);
        $pattern = '/(?:https?:\/\/)?([^\s\/]+)(?=\s*$|\s*[:;,.!?])/';
        $message = preg_replace_callback($pattern, function($matches) {
            $domain_without_dots = str_replace('.', '', $matches[1]);
            return $domain_without_dots;
        }, $message);

        $message = $message . "
~$rand
";
        $number_server = Device::inRandomOrder()->value('no_hp');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wag.jamkerja.id/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('api_key' => 'pe4iBE61GyZyRYY7pzmJLzvGyPdTN9', 'sender' => $number_server, 'message' => $message, 'number' => format62($receiver)),
        ));

        $response = curl_exec($curl);

        Pesan::create([
            'from' => $number_server,
            'to' => $receiver,
            'isi' => $message,
            'code' => $code,
        ]);
        sleep(5);

        curl_close($curl);
        return $response;
    }

    public function index_old()
    {
        $session = request('name');
        $receiver = request('receiver');
        $message = request('message');
        $code = request('code');

        $rand = randString(15);

        $user = Member::where('name', strtolower($session))->where('code', $code)->first();

        if (!$user) {
            return [
                'status' => false,
                'messages' => 'User not exist'
            ];
        }

        if (!str_contains(strtolower($message), strtolower($session))) {
            return [
                'status' => false,
                'messages' => 'User not found'
            ];
        }

        if (strtotime('now') > strtotime($user->expired_date)) {
            if ($user->no_pj != "" && $user->notif_pj == 0) {
                $name = ucwords($user->name);
                $tgl = tanggal_indo($user->expired_date);
                $sendPj = [
                    'jid' => format62($user->no_pj) . "@s.whatsapp.net",
                    'type' => "number",
                    'message' => [
                        'text' => "Mohon maaf waktu berlangganan WA-Server atas nama $name telah expired pada tanggal $tgl, Silahkan lakukan perpanjangan untuk mengirimkan pesan lagi!",
                    ],
                ];
                $user->update(['notif_pj' => 1]);
                $number_server = Device::inRandomOrder()->first();
                $number_server = numberTraning($number_server);

                $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $sendPj);
                $res = json_decode($response->body());
            }

            return [
                'status' => false,
                'messages' => 'Member is expired'
            ];
        }

        $message = $message . "
kodeRef: $rand
";

        $send = [
            'jid' => format62($receiver) . "@s.whatsapp.net",
            'type' => "number",
            'message' => [
                'text' => $message,
            ],
        ];

        if ($user->no_request == '') {
            $number_server = Device::inRandomOrder()->first();
            $number_server = numberTraning($number_server);

            $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);

            $res = json_decode($response->body());

            $try = 1;
            if (property_exists($res, 'key')) {
                Pesan::create([
                    'from' => $number_server->no_hp,
                    'to' => $receiver,
                    'isi' => $message,
                    'code' => $code,
                    'kodeRef' => $rand,
                ]);
                sleep(5);
                return [
                    'status' => true,
                    'number' => $number_server,
                    'try' => $try,
                ];
            }
            if (property_exists($res, 'error')) {

                $number_server = Device::inRandomOrder()->where('id', '!=', $number_server->id)->first();
                $number_server = numberTraning($number_server);

                $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);
                $res = json_decode($response->body());

                if (property_exists($res, 'key')) {
                    $try += 1;
                    Pesan::create([
                        'from' => $number_server->no_hp,
                        'to' => $receiver,
                        'isi' => $message,
                        'code' => $code,
                        'kodeRef' => $rand,
                    ]);
                    sleep(5);
                    return [
                        'status' => true,
                        'number' => $number_server,
                        'try' => $try,
                    ];
                }
            }
        } else {
            $number_server = Device::where('no_hp', $user->no_request)->first();
            $number_server = numberTraning($number_server);

            $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);
            $res = json_decode($response->body());
            $try = 1;
            if (property_exists($res, 'key')) {
                Pesan::create([
                    'from' => $number_server->no_hp,
                    'to' => $receiver,
                    'isi' => $message,
                    'code' => $code,
                    'kodeRef' => $rand,
                ]);
                sleep(5);
                return [
                    'status' => true,
                    'number' => $number_server,
                    'try' => $try,
                ];
            }

            if (property_exists($res, 'error')) {
                $response = Http::post(env('URL_WA_SERVER') . "/$number_server->session/messages/send", $send);
                $res = json_decode($response->body());

                if (property_exists($res, 'key')) {
                    $try += 1;
                    Pesan::create([
                        'from' => $number_server->no_hp,
                        'to' => $receiver,
                        'isi' => $message,
                        'code' => $code,
                        'kodeRef' => $rand,
                    ]);
                    sleep(5);
                    return [
                        'status' => true,
                        'number' => $number_server,
                        'try' => $try,
                    ];
                }
            }
        }

        return [
            'status' => false,
            'number' => $number_server,
            'try' => $try,
        ];
    }
}
