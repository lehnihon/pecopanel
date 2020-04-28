<?php

namespace App\Http\Controllers;

use App\User;
use App\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role->id == 1){
            $servers = Server::orderBy('server_name', 'asc')->get();
        }else{
            $servers = Server::where('user_id',auth()->user()->id)->orderBy('server_name', 'asc')->get();
        }
                
        return view("server.index",['servers' => $servers]);
    }

    public function list(){
        $users = User::with('role')->orderBy('email', 'asc')->get();
                
        return view("server.list",['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $servers = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers',[])->json();
        $subscriptions = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/subscriptions',[
                'query' => 'customer_id:'.$id.' status:active',
                'sort_order' => 'asc'
            ])->json();
        return view("server.create",array_merge(['servers' => $servers['data'], 'user' => $id], $subscriptions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validator($request);

        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$data['server'])->json();
        $user = User::where('vindi_id',$data['user'])->first();

        $status = (Server::create([
            'server_ip' => $server['ipAddress'],
            'server_name' => $server['name'],
            'server_provider' => $server['provider'],
            'server_os' => $server['os'],
            'subscription_id' => $data['subscription'],
            'server_id' => $data['server'],
            'user_id' => $user->id
        ])) ? "Servidor associado!" : "Erro ao associar o servidor";

        return redirect('server')->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id)->json();
        
        $hardware = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/hardwareinfo')->json();
        if(!isset($server['id'])){
            return redirect('home')->with('status', "Servidor não existe");
        }else{
            return view("server.show",['server' => $server, 'hardware' => $hardware]);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        //
    }

    protected function validator($request)
    {
        return $request->validate([
            'server' => ['required'],
            'subscription' => ['required'],
            'user' => ''
        ]);
    }
}
