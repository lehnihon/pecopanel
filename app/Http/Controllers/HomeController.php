<?php

namespace App\Http\Controllers;
use App\Server;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user()->role->id == 1){
            $servers = Server::orderBy('server_name', 'asc')->with('user')->get();
        }else{
            $servers = Server::where('user_id',auth()->user()->id)->orderBy('server_name', 'asc')->get();
        }
                
        return view("dashboard",['servers' => $servers]);
    }
}
