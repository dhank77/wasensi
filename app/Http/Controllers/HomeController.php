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
        $pesanHariIni = Pesan::whereDate("created_at", "=", date("Y-m-d"))->count();
        $totalPesan = Pesan::count();
        
        $memberAktif = Member::where("expired_date", ">=", date("Y-m-d"))->count();
        $totalMember = Member::count();
        
        $member = Member::get();

        return view('home', compact('pesanHariIni', 'totalPesan', 'memberAktif', 'totalMember', 'member'));
    }
}
