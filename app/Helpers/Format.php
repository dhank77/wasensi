<?php

use App\Models\Device;
use App\Models\Pesan;

function number_indo($num, $des = 0)
{
    return number_format($num, $des, ',', '.');
}

function format62($number)
{
    // kadang ada penulisan no hp 0811 239 345
    $number = str_replace(" ","",$number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace("(","",$number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace(")","",$number);
    // kadang ada penulisan no hp 0811.239.345
    $number = str_replace(".","",$number);

     // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($number))){
        // cek apakah no hp karakter 1 adalah 0
        if(substr(trim($number), 0, 1)=='0'){
            $number = '62'.substr(trim($number), 1);
        }
    }

    return $number;
}

function randString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function numberTraning($number_server) {

    if($number_server->is_training == 1){
        $tanggal_saat_ini = date("Y-m-d");
        $tanggal_tambah = date("Y-m-d", strtotime($number_server->created_at));

        $jumlah_pesan_terkirim = Pesan::where('from', $number_server->no_hp)->whereDate('created_at', $tanggal_saat_ini)->count();
        $selisih_hari = floor((strtotime($tanggal_saat_ini) - strtotime($tanggal_tambah)) / (60 * 60 * 24));
        $batas_maksimal_pesan = $selisih_hari + 1; 

        if($batas_maksimal_pesan >= 60){
            $number_server->update(['is_training' => false]);
        }

        if ($jumlah_pesan_terkirim > $batas_maksimal_pesan) {
            $number_server = Device::where('id', '!=', $number_server->id)
                                    ->inRandomOrder()
                                    ->first();
        }
    }

    return $number_server;
}

function get_pesan_member($code)
{
    $pesan = Pesan::where('code', $code);
    
    return [
        'total' => $pesan->count(),
        'hari_ini' => $pesan->whereDate('created_at', date("Y-m-d"))->count(),
    ];
}