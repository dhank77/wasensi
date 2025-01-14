<?php

use Illuminate\Support\Facades\Http;

function get_status($session, $cek = true)
{
    if($cek == false){
        return "Not Check";
    }else{
        $find = Http::get(env('URL_WA_SERVER').'/sessions/'.$session.'/status');
        $getres = json_decode($find->getBody());
        if(property_exists($getres, 'error')){
            return $getres->error;
        }
    
        return $getres->status;
    }
}