<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
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

    public function index()
    {
        return view('account');
    }

    public function games()
    {
        return view('account.games');
    }

    public function badges()
    {
        return view('account.badges');
    }

    public function edit()
    {
        return view('account.edit');
    }

    public function update(Request $request)
    {
        dd($request->all());
    }
}
