<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();

        return view('member.index', compact('members'));
    }

    public function add()
    {
        $member = new Member();

        return view('member.add', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('member.add', compact('member'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'code' => 'required',
            'expired_date' => 'required',
            'no_pj' => 'nullable',
            'no_request' => 'nullable',
            'notif_pj' => 'nullable',
        ]);

        $data['name'] = strtolower(request('name'));

        $id = request('id');

        $cr = Member::updateOrCreate(['id' => $id], $data);

        if($cr){
            return redirect(route('member.index'))->with('success', 'Berhasil');
        }else{
            return redirect(route('member.index'))->with('error', 'Gagal');
        }
    }
}
