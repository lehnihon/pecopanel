<?php

namespace App\Http\Controllers;

use App\WebApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = auth()->user()->servers;
        return view("webapp.index",['servers' => $servers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($id)
    {
        $webapps = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps')->json();

        return view("webapp.list",['webapps' => $webapps['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users')->json();
        return view("webapp.create",['server' => $id, 'users' => $users['data']]);
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

        if(empty($data['user-check'])){
            $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
                ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$data['server'].'/users',['username' => $data['user']])->json();
            if(isset($user['errors'])){
                $status = "Erro ao criar o usuário";
                return redirect('webapp')->with('status', $status);
            }else{
                $data['user'] = $user['id'];
            }               
        }
        
        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$data['server'].'/webapps/custom',[
                'name' => $data['name'],
                'user' => $data['user'],
                'domainName' => $data['domain'],
                'stack' => $data['stack'],
                'stackMode' => $data['stackmode'],
                'phpVersion' => 'php73rc',
                'clickjackingProtection' => true,
                'xssProtection' => true,
                'mimeSniffingProtection' => true,
                'processManager' => 'ondemand',
                'processManagerMaxChildren'=> 50,
                'processManagerMaxRequests' => 500,
                'timezone' => 'America/Sao_Paulo',
                'maxExecutionTime' => 30,
                'maxInputTime' => 60,
                'maxInputVars' => 1000,
                'memoryLimit' => 256,
                'postMaxSize' => 256,
                'uploadMaxFilesize' => 256,
                'sessionGcMaxlifetime' => 1440,
                'allowUrlFopen' => true
            ])->json();
            
        $status = (!isset($server['errors'])) ? "Aplicação Web criada com sucesso" : "Erro ao cadastrar aplicação web";
        return redirect('webapp')->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WebApp  $webApp
     * @return \Illuminate\Http\Response
     */
    public function show(WebApp $webApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WebApp  $webApp
     * @return \Illuminate\Http\Response
     */
    public function edit(WebApp $webApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WebApp  $webApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebApp $webApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WebApp  $webApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebApp $webApp)
    {
        //
    }

    protected function validator($request)
    {
        return $request->validate([
            'user-check' => '',
            'user' => ['required'],
            'server' => '',
            'name' => ['required'],
            'domain' => ['required'],
            'stack' => ['required'],
            'stackmode' => ['required']
        ]);
    }
}
