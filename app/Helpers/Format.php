<?php

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
