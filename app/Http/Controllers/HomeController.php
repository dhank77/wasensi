<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Pesan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pesan = Pesan::get();
        $member = Member::get();

        $pesanHariIni = Pesan::whereDate("created_at", "=", date("Y-m-d"))->count();
        $totalPesan = $pesan->count();
        
        $memberAktif = $member->where("expired_date", ">=", date("Y-m-d"))->count();
        $totalMember = $member->count();

        return view('home', compact('pesanHariIni', 'totalPesan', 'memberAktif', 'totalMember', 'member'));
    }
}
