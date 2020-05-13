<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Server;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected function validator($request)
    {
        return $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'role' => ['required']
        ]);
    }

    protected function validatorServer($request)
    {
        return $request->validate([
            'server' => ['required'],
            'obs' => ''
        ]);
    }

    protected function validatorUpdate($request)
    {
        return $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'role' => ['required'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role')->orderBy('email', 'asc')->get();

        $servers = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers',[])->json();
                
        return view("user.index",['users' => $users, 'servers' => $servers['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();

        return view("user.create",['roles' => $roles]);
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

        $status = (User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'vindi_id' => '0',
            'role_id' => $data['role']
        ])) ? "Usuário criado!" : "Erro ao criar o usuário";

        return redirect('user')->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('role')->find($id);
        $roles = Role::orderBy('name', 'asc')->get();

        return view("user.edit",['user'=> $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validatorUpdate($request);   

        if(!empty($data['password'])){
            $status = ($user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'vindi_id' => '0',
                'role_id' => $data['role']
            ])) ? "Usuário atualizado!" : "Erro ao atualizar o usuário"; 
        }else{
            $status = ($user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'vindi_id' => '0',
                'role_id' => $data['role']
            ])) ? "Usuário atualizado!" : "Erro ao atualizar o usuário";
        }
        
        return redirect('user')->with('status', $status);
    }

    public function connectStore($user, Request $request)
    {
        $data = $this->validatorServer($request);

        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$data['server'])->json();
        
        $status = (Server::create([
            'server_ip' => $server['ipAddress'],
            'server_name' => $server['name'],
            'server_provider' => $server['provider'],
            'server_os' => $server['os'],
            'obs' => $data['obs'],
            'server_id' => $data['server'],
            'user_id' => $user
        ])) ? "Servidor associado!" : "Erro ao associar o servidor";

        return redirect('user')->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
