<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::latest()->get();

        return view('device.index', compact('devices'));
    }

    public function add()
    {
        $devices = new Device();

        return view('device.add', compact('devices'));
    }

    public function delete(Device $device)
    {
        $cr = $device->delete();
        if($cr){
            return redirect(route('device.index'))->with('success', 'Berhasil');
        }else{
            return redirect(route('device.index'))->with('error', 'Gagal');
        }
    }

    public function scan(Device $device)
    {
        $response = Http::post(env('URL_WA_SERVER').'/sessions/add', ['sessionId' => $device->session]);
        $res = json_decode($response->getBody());

        if(property_exists($res, 'error') && $res->error == "Session already exists"){
            $hapus = Http::delete(env('URL_WA_SERVER').'/sessions/'.$device->session);
            $res = json_decode($hapus->getBody());
            
            $newsessionID = $device->session;
            sleep(1);
            $response = Http::post(env('URL_WA_SERVER').'/sessions/add', ['sessionId' => $newsessionID]);
            $res = json_decode($response->getBody());

            $device->update(['session' => $newsessionID]);
        }
        $image = $res->qr;
                
        return view('device.scan', compact('device', 'image'));
    }

    public function store()
    {
        $data = request()->validate([
            'no_hp' => 'required',
            'session' => 'required',
        ]);

        $id = request('id');

        $cr = Device::updateOrCreate(['id' => $id], $data);

        $id = $id ?? $cr->id;

        if($cr){
            return redirect(route('device.scan', $id))->with('success', 'Berhasil');
        }else{
            return redirect(route('device.scan', $id))->with('error', 'Gagal');
        }
    }
}
