<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
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
                
        return view("user.index",['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/customers',[
                'sort_by' => 'name',
                'sort_order' => 'asc'
            ]);

        $roles = Role::orderBy('name', 'asc')->get();

        return view("user.create",array_merge(['roles' => $roles],$customers->json()));
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
        
        if(empty($data['customer'])){
            $vindi_id = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
                ->post(env('APP_VINDI_URL', false).'/customers',[
                    'name' => $data['name'],
                    'email' => $data['email']
                ])["customer"]["id"];
        }else{
            $vindi_id = $data['customer'];
        }

        $status = (User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'vindi_id' => $vindi_id,
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
        $customers = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/customers',[
                'sort_by' => 'name',
                'sort_order' => 'asc'
            ]);

        return view("user.edit",array_merge(['user'=> $user, 'roles' => $roles],$customers->json()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validator($request);
        
        if(empty($data['customer'])){
            $vindi_id = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
                ->post(env('APP_VINDI_URL', false).'/customers',[
                    'name' => $data['name'],
                    'email' => $data['email']
                ])["customer"]["id"];
        }else{
            $vindi_id = $data['customer'];
        }

        $status = ($user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'vindi_id' => $vindi_id,
            'role_id' => $data['role']
        ])) ? "Usuário atualizado!" : "Erro ao atualizar o usuário";

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
