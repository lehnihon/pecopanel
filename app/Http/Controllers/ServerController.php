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
        if(isset($hardware['message'])){
            $status = "Servidor não está respondendo";
            return redirect()->route('home')->with('status', $status);
        }

        $hardware['percMemory'] = $this->percCalc($hardware['totalMemory'],$hardware['freeMemory']);
        $hardware['diskPerc'] = $this->percCalc($hardware['diskTotal'],$hardware['diskFree']);

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

    public function webApp($id){
        $webapps = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
        ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps')->json();

        return view("webapp.index",['webapps' => $webapps['data']]);
    }

    public function webAppSsl($id, $idwa){
        $ssl = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/ssl')->json();

        return view("webapp.ssl",['ssl' => $ssl]);
    }

    public function webAppEdit($id, $idwa){
        $webapp = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa)->json();
        $setting = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/settings')->json();
        $php_versions = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/php/version')->json();

        return view("webapp.edit",['webapp' => $webapp, 'setting' => $setting, 'php_versions' => $php_versions]);
    }

    public function webAppScript($id, $idwa){
        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/installer')->json();

        return view("webapp.script",['wascript' => $wascript]);
    }

    public function webAppSslStore($id, $idwa, Request $request){
        if($request->input('provider') == 'letsencrypt'){
            $data = $this->validatorSslA($request);
        }else{
            $data = $this->validatorSslB($request);
        }
        $data['enableHttp'] = (isset($data['enableHttp'])) ? '1': '0';
        $data['enableHsts'] = (isset($data['enableHsts'])) ? '1': '0';

        $ssl = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/ssl',$data)->json();

        $status = (!isset($ssl['errors'])) ? "Ssl instalado" : "Erro ao instalar ssl";
        return redirect()->route('webapp.ssl', ['id' => $id, 'idwa' => $idwa])->with('status', $status);

    }

    public function webAppSslUpdate($id, $idwa,$idssl, Request $request){
        if($request->input('method') == 'letsencrypt'){
            $data = $this->validatorSslD($request);
        }else{
            $data = $this->validatorSslC($request);
        }
        $data['enableHttp'] = (isset($data['enableHttp'])) ? '1': '0';
        $data['enableHsts'] = (isset($data['enableHsts'])) ? '1': '0';

        $ssl = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/ssl/'.$idssl,$data)->json();
 
        $status = (!isset($ssl['errors'])) ? "Ssl atualizado" : "Erro ao atualizar ssl";
        return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);

    }

    public function webAppSslDestroy($id, $idwa,$idssl, Request $request){
        $ssl = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/ssl/'.$idssl)->json();

        if(isset($ssl['message'])){
            $status = "Erro ao remover ssl";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Ssl removido";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }

    }

    public function webAppDomain($id, $idwa){
        $domains = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/domains')->json();
        return view("domains.index",['domains' => $domains['data']]);
    }

    public function webAppDomainStore($id, $idwa, Request $request){;
        $data = $this->validatorDomain($request);

        $domain = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/domains',['name' => $data['domain']])->json();

        $status = (!isset($domain['errors'])) ? "Domínio vinculado" : "Erro ao vincular domínio";
        return redirect()->route('webapp.domain.index', ['id' => $id, 'idwa' => $idwa])->with('status', $status);

    }

    public function webAppDomainDestroy($id, $idwa,$domain){
        $domain = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/domains/'.$domain)->json();

        if(isset($domain['message'])){
            $status = "Erro ao desvincular o domínio";
            return redirect()->route('webapp.domain.index', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Domínio desvinculado";
            return redirect()->route('webapp.domain.index', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }
    }

    public function webAppCreate($id){
        $php_versions = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/php/version')->json();
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users')->json();
        return view("webapp.create",['server' => $id, 'users' => $users['data'], 'php_versions' => $php_versions]);
    }

    public function webAppUpdate($id, $idwa, Request $request){
        $data = $this->validatorWebAppB($request);

        if(empty($data['clickjackingProtection'])){
            $data['clickjackingProtection'] = 1;
        }
        if(empty($data['xssProtection'])){
            $data['xssProtection'] = 1;
        }
        if(empty($data['mimeSniffingProtection'])){
            $data['mimeSniffingProtection'] = 1;
        }

        if(empty($data['processManager'])){
            $data['processManager'] = 'ondemand';
        }
        if(empty($data['processManagerMaxChildren'])){
            $data['processManagerMaxChildren'] = '50';
        }
        if(empty($data['processManagerMaxRequests'])){
            $data['processManagerMaxRequests'] = '500';
        }

        if(empty($data['maxExecutionTime'])){
            $data['maxExecutionTime'] = '30';
        }
        if(empty($data['maxInputTime'])){
            $data['maxInputTime'] = '60';
        }
        if(empty($data['maxInputVars'])){
            $data['maxInputVars'] = '1000';
        }
        if(empty($data['memoryLimit'])){
            $data['memoryLimit'] = '256';
        }
        if(empty($data['postMaxSize'])){
            $data['postMaxSize'] = '256';
        }
        if(empty($data['uploadMaxFilesize'])){
            $data['uploadMaxFilesize'] = '256';
        }
        if(empty($data['sessionGcMaxlifetime'])){
            $data['sessionGcMaxlifetime'] = '1440';
        }
        if(empty($data['allowUrlFopen'])){
            $data['allowUrlFopen'] = 1;
        }

        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/settings/fpmnginx',[
                'stack' => $data['stack'],
                'stackMode' => $data['stackmode'],
                'clickjackingProtection' => $data['clickjackingProtection'],
                'xssProtection' => $data['xssProtection'],
                'mimeSniffingProtection' => $data['mimeSniffingProtection'],
                'processManager' => $data['processManager'],
                'processManagerMaxChildren'=> $data['processManagerMaxChildren'],
                'processManagerMaxRequests' => $data['processManagerMaxRequests'],
                'timezone' => 'America/Sao_Paulo',
                'maxExecutionTime' => $data['maxExecutionTime'],
                'maxInputTime' => $data['maxInputTime'],
                'maxInputVars' => $data['maxInputVars'],
                'memoryLimit' => $data['memoryLimit'],
                'postMaxSize' => $data['postMaxSize'],
                'uploadMaxFilesize' => $data['uploadMaxFilesize'],
                'sessionGcMaxlifetime' => $data['sessionGcMaxlifetime'],
                'allowUrlFopen' => $data['allowUrlFopen']
            ]);

        $status = (!isset($server['errors'])) ? "Aplicação Web atualizada com sucesso" : "Erro ao atualizar aplicação web";
        return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
    }

    public function webAppStore($id, Request $request){
        $data = $this->validatorWebApp($request);

        if(empty($data['user-check'])){
            $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
                ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users',['username' => $data['user']])->json();
            if(isset($user['errors'])){
                $status = "Erro ao criar o usuário";
                return redirect('webapp')->with('status', $status);
            }else{
                $data['user'] = $user['id'];
            }               
        }

        if(empty($data['clickjackingProtection'])){
            $data['clickjackingProtection'] = 1;
        }
        if(empty($data['xssProtection'])){
            $data['xssProtection'] = 1;
        }
        if(empty($data['mimeSniffingProtection'])){
            $data['mimeSniffingProtection'] = 1;
        }

        if(empty($data['processManager'])){
            $data['processManager'] = 'ondemand';
        }
        if(empty($data['processManagerMaxChildren'])){
            $data['processManagerMaxChildren'] = '50';
        }
        if(empty($data['processManagerMaxRequests'])){
            $data['processManagerMaxRequests'] = '500';
        }

        if(empty($data['maxExecutionTime'])){
            $data['maxExecutionTime'] = '30';
        }
        if(empty($data['maxInputTime'])){
            $data['maxInputTime'] = '60';
        }
        if(empty($data['maxInputVars'])){
            $data['maxInputVars'] = '1000';
        }
        if(empty($data['memoryLimit'])){
            $data['memoryLimit'] = '256';
        }
        if(empty($data['postMaxSize'])){
            $data['postMaxSize'] = '256';
        }
        if(empty($data['uploadMaxFilesize'])){
            $data['uploadMaxFilesize'] = '256';
        }
        if(empty($data['sessionGcMaxlifetime'])){
            $data['sessionGcMaxlifetime'] = '1440';
        }
        if(empty($data['allowUrlFopen'])){
            $data['allowUrlFopen'] = 1;
        }

        $server = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/custom',[
                'name' => $data['name'],
                'user' => $data['user'],
                'domainName' => $data['domain'],
                'stack' => $data['stack'],
                'stackMode' => $data['stackmode'],
                'phpVersion' =>  $data['php'],
                'clickjackingProtection' => $data['clickjackingProtection'],
                'xssProtection' => $data['xssProtection'],
                'mimeSniffingProtection' => $data['mimeSniffingProtection'],
                'processManager' => $data['processManager'],
                'processManagerMaxChildren'=> $data['processManagerMaxChildren'],
                'processManagerMaxRequests' => $data['processManagerMaxRequests'],
                'timezone' => 'America/Sao_Paulo',
                'maxExecutionTime' => $data['maxExecutionTime'],
                'maxInputTime' => $data['maxInputTime'],
                'maxInputVars' => $data['maxInputVars'],
                'memoryLimit' => $data['memoryLimit'],
                'postMaxSize' => $data['postMaxSize'],
                'uploadMaxFilesize' => $data['uploadMaxFilesize'],
                'sessionGcMaxlifetime' => $data['sessionGcMaxlifetime'],
                'allowUrlFopen' => $data['allowUrlFopen']
            ])->json();

        $status = (!isset($server['errors'])) ? "Aplicação Web criada com sucesso" : "Erro ao cadastrar aplicação web";
        return redirect()->route('webapp.index', ['id' => $id])->with('status', $status);
    }

    public function webAppShow($id, $idwa){
        $webapp = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa)->json();

        return view("webapp.show",['webapp' => $webapp]);
    }

    public function webAppPHP($id, $idwa, Request $request){
        $data = $this->validatorPHP($request);
        $webapp = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/settings/php',['phpVersion' => $data['php']])->json();

        $status = (!isset($webapp['errors'])) ? "Versão PHP atualizada" : "Erro ao atualizar php";
        return redirect()->route('webapp.index', ['id' => $id])->with('status', $status);
    }

    public function webAppScriptStore($id, $idwa, Request $request){
        $data = $this->validatorWebAppScript($request);

        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/installer',
            ['name' => $data['script']])->json();

        if(isset($wascript['message'])){
            $status = "Erro ao instalar o script";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Script instalado com sucesso";
            return redirect()->route('webapp.script', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }
    }

    public function webAppRebuild($id, $idwa){
        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/rebuild')->json();
        if(isset($wascript['message'])){
            $status = "Erro ao reconstruir a aplicação web";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Aplicação web reconstruida";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }
    }

    public function webAppDestroy($id, $idwa){
        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa)->json();
        if(isset($wascript['message'])){
            $status = "Erro ao remover a aplicação web";
            return redirect()->route('webapp.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Aplicação web removida";
            return redirect()->route('webapp.index', ['id' => $id])->with('status', $status);
        }
    }

    public function webAppDefault($id, $idwa){
        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/default')->json();
        if(isset($wascript['message'])){
            $status = "Erro ao definir a aplicação web para padrão";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Aplicação web definida como padrão";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }
    }

    public function webAppScriptDestroy($id, $idwa, $script){
        $wascript = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/webapps/'.$idwa.'/installer/'.$script)->json();

        if(isset($wascript['message'])){
            $status = "Erro ao remover o script";
            return redirect()->route('webapp.show', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }else{
            $status = "Script removido";
            return redirect()->route('webapp.script', ['id' => $id, 'idwa' => $idwa])->with('status', $status);
        }
    }

    public function user($id){
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users')->json();

        return view("suser.index",['users' => $users['data']]);
    }


    public function userCreate($id){
        return view("suser.create");
    }

    public function userShow($id,$user){
        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users/'.$user)->json();

        return view("suser.show",['user' => $user]);
    }

    public function userStore($id, Request $request){
        $data = $this->validatorDatabaseUser($request);

        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users',['username' => $data['username'], 'password' => $data['password']])->json();

        $status = (!isset($user['errors'])) ? "Usuário criado" : "Erro ao cadastrar usuário";
        return redirect()->route('suser.index', ['id' => $id])->with('status', $status);
    }

    public function userUpdate($id, $idus, Request $request){
        $data = $this->validatorDatabasePassword($request);

        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users/'.$idus,['password' => $data['password']])->json();

        $status = (!isset($user['errors'])) ? "Senha atualizada" : "Erro ao atualizar senha";
        return redirect()->route('suser.index', ['id' => $id])->with('status', $status);    
    }

    public function userDestroy($id, $idus){
        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users/'.$idus)->json();
        if(isset($user['message'])){
            $status = "Erro ao remover o usuário";
            return redirect()->route('suser.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Usuário removido";
            return redirect()->route('suser.index', ['id' => $id])->with('status', $status);
        }
    }

    public function cron($id){
        $cron = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/cronjobs')->json();
      
        return view("cron.index",[
            'cron' => $cron['data'],
            'pagination' => $cron['meta']['pagination'],
            'initpage' => $this->initPage($cron)
            ]);
    }

    public function cronCreate($id){
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users')->json();
        return view("cron.create",['users' => $users['data']]);
    }

    public function cronStore($id, Request $request){
        $data = $this->validatorCron($request);

        $cron = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/cronjobs',
                ['label' => $data['label'],'username' => $data['username'],'command' => $data['command']
                ,'minute' => $data['minute'],'hour' => $data['hour'],'dayOfMonth' => $data['dayOfMonth']
                ,'month' => $data['month'],'dayOfWeek' => $data['dayOfWeek']
                ])->json();

        $status = (!isset($cron['errors'])) ? "Cron criada" : "Erro ao cadastrar cron";
        return redirect()->route('cron.index', ['id' => $id])->with('status', $status);
    }

    public function cronDestroy($id, $idcr){
        $cron = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/cronjobs/'.$idcr)->json();
        if(isset($cron['message'])){
            $status = "Erro ao remover o cron";
            return redirect()->route('cron.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Cron removido";
            return redirect()->route('cron.index', ['id' => $id])->with('status', $status);
        }
    }

    public function database($id){
        $databases = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases')->json();
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databaseusers')->json();

        return view("database.index",['databases' => $databases['data'], 'users' => $users['data']]);
    }

    public function databaseShow($id, $iddb){
        $database = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases/'.$iddb)->json();
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases/'.$iddb.'/grant')->json();

        return view("database.show",['database' => $database,'users' => $users['data']]);
    }

    public function databaseAttach($id, $iddb, Request $request){
        $data = $this->validatorDatabaseAttach($request);

        $database = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases/'.$iddb.'/grant',['id' => $data['username']])->json();

        $status = (!isset($database['errors'])) ? "Usuário vinculado ao banco de dados" : "Erro ao vincular usuário";
        return redirect()->route('database.index', ['id' => $id])->with('status', $status);
    }

    public function databaseCreate($id){
        return view("database.create");
    }

    public function databaseStore($id, Request $request){
        $data = $this->validatorDatabase($request);

        $database = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases',['name' => $data['name']])->json();

        $status = (!isset($database['errors'])) ? "Banco de dados criado" : "Erro ao cadastrar banco de dados";
        return redirect()->route('database.index', ['id' => $id])->with('status', $status);
    }

    public function databaseDestroy($id, $iddb){
        $database = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases/'.$iddb)->json();
        if(isset($database['message'])){
            $status = "Erro ao remover o banco de dados";
            return redirect()->route('database.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Banco de dados removido";
            return redirect()->route('database.index', ['id' => $id])->with('status', $status);
        }
    }

    public function databaseRevokeUser($id, $iddb,$user){
        $database = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databases/'.$iddb.'/grant',['id' => $user])->json();
        if(isset($database['message'])){
            $status = "Erro ao revogar o acesso do usuário";
            return redirect()->route('database.show', ['id' => $id, 'iddb' => $iddb])->with('status', $status);
        }else{
            $status = "Acesso revogado";
            return redirect()->route('database.show', ['id' => $id, 'iddb' => $iddb])->with('status', $status);
        }
    }

    public function databaseCreateUser($id){
        return view("database.create_user");
    }

    public function databaseStoreUser($id, Request $request){
        $data = $this->validatorDatabaseUser($request);

        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databaseusers',['username' => $data['username'], 'password' => $data['password']])->json();

        $status = (!isset($user['errors'])) ? "Usuário criado" : "Erro ao cadastrar usuário";
        return redirect()->route('database.index', ['id' => $id])->with('status', $status);
    }

    public function databaseUpdateUser($id, $idus, Request $request){
        $data = $this->validatorDatabasePassword($request);

        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databaseusers/'.$idus,['password' => $data['password']])->json();

        $status = (!isset($user['errors'])) ? "Senha atualizada" : "Erro ao atualizar senha";
        return redirect()->route('database.index', ['id' => $id])->with('status', $status);    
    }

    public function databaseDestroyUser($id, $idus){
        $user = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/databaseusers/'.$idus)->json();
        if(isset($user['message'])){
            $status = "Erro ao remover o usuário";
            return redirect()->route('database.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Usuário removido";
            return redirect()->route('database.index', ['id' => $id])->with('status', $status);
        }
    }

    public function security($id){
        $security = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/security/fail2ban/blockedip')->json();
        return view("security.index",['security' => $security]);
    }

    public function securityDestroy($id,$ip){
        $security = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/security/fail2ban/blockedip',['ip' => $ip])->json();
        if(isset($security['message'])){
            $status = "Erro ao remover o ip";
            return redirect()->route('security.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Ip removido";
            return redirect()->route('security.index', ['id' => $id])->with('status', $status);
        }
    }

    public function service($id){
        $service = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/services')->json();

        return view("service.index",['services' => $service]);
    }

    public function serviceUpdate($id, Request $request){
        $service = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->patch(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/services',$request->all())->json();

        $status = (!isset($service['errors'])) ? "Serviço atualizado" : "Erro ao atualizar serviço";
        return redirect()->route('service.index', ['id' => $id])->with('status', $status);  
    }

    public function ssh($id){
        $ssh = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/sshcredentials')->json();

        return view("ssh.index",['sshs' => $ssh['data']]);
    }

    public function sshCreate($id){
        $users = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/users')->json();

        return view("ssh.create",['users' => $users['data']]);
    }

    public function sshStore($id, Request $request){
        $data = $this->validatorSsh($request);

        $ssh = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->post(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/sshcredentials',[
                'label' => $data['label'],
                'username' => $data['user'],
                'publicKey' => $data['publick']
            ])->json();

        $status = (!isset($ssh['errors'])) ? "Chave SSH criada" : "Erro ao cadastrar chave ssh";
        return redirect()->route('ssh.index', ['id' => $id])->with('status', $status);
    }

    public function sshDestroy($id, $idssh){
        $ssh = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->delete(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/sshcredentials/'.$idssh)->json();
        if(isset($ssh['message'])){
            $status = "Erro ao remover o chave ssh";
            return redirect()->route('ssh.index', ['id' => $id])->with('status', $status);
        }else{
            $status = "Chave ssh removida";
            return redirect()->route('ssh.index', ['id' => $id])->with('status', $status);
        }
    }

    public function log($id,$pag = 1){
        $logs = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers/'.$id.'/logs?page='.$pag)->json();
        return view("logs.index",['logs' => $logs['data'],'pagination' => $logs['meta']['pagination'],'initpage' => $this->initPage($logs)]);
    }

    public function percCalc($total,$number){
        $diff = $total - $number;
        return (int)round($diff/$total*100);
    }

    public function initPage($current){
        $initpage = 0;
        if($current['meta']['pagination']['current_page']-5 > 0){
            $initpage = $current['meta']['pagination']['current_page']-5;
        }
        return $initpage;
    }

    protected function validatorWebApp($request)
    {
        return $request->validate([
            'user-check' => '',
            'user' => ['required'],
            'server' => '',
            'name' => ['required','alpha_dash'],
            'domain' => ['required'],
            'stack' => ['required'],
            'stackmode' => ['required'],
            'php' => ['required'],
            'clickjackingProtection' => '',
            'xssProtection' => '',
            'mimeSniffingProtection' => '',
            'processManager' => '',
            'processManagerMaxChildren'=> '',
            'processManagerMaxRequests' => '',
            'maxExecutionTime' => '',
            'maxInputTime' => '',
            'maxInputVars' => '',
            'memoryLimit' => '',
            'postMaxSize' => '',
            'uploadMaxFilesize' => '',
            'sessionGcMaxlifetime' => '',
            'allowUrlFopen' => ''
        ]);

    }

    protected function validatorWebAppB($request)
    {
        return $request->validate([
            'stack' => ['required'],
            'stackmode' => ['required'],
            'clickjackingProtection' => '',
            'xssProtection' => '',
            'mimeSniffingProtection' => '',
            'processManager' => '',
            'processManagerMaxChildren'=> '',
            'processManagerMaxRequests' => '',
            'maxExecutionTime' => '',
            'maxInputTime' => '',
            'maxInputVars' => '',
            'memoryLimit' => '',
            'postMaxSize' => '',
            'uploadMaxFilesize' => '',
            'sessionGcMaxlifetime' => '',
            'allowUrlFopen' => ''
        ]);

    }

    protected function validatorWebAppScript($request)
    {
        return $request->validate([
            'script' => ['required'],
        ]);
    }

    protected function validatorPHP($request)
    {
        return $request->validate([
            'php' => ['required'],
        ]);
    }

    protected function validatorCron($request)
    {
        return $request->validate([
            'label' => ['required'],
            'username' => ['required'],
            'command' => ['required'],
            'minute' => ['required'],
            'hour' => ['required'],
            'dayOfMonth' => ['required'],
            'month' => ['required'],
            'dayOfWeek' => ['required'],
        ]);
    }

    protected function validatorDatabase($request)
    {
        return $request->validate([
            'name' => ['required'],
        ]);
    }

    protected function validatorDatabaseUser($request)
    {
        return $request->validate([
            'username' => ['required','min:5'],
            'password' => ['required', 'confirmed']
        ]);
    }

    protected function validatorDatabasePassword($request)
    {
        return $request->validate([
            'password' => ['required', 'confirmed']
        ]);
    }

    protected function validatorDatabaseAttach($request)
    {
        return $request->validate([
            'username' => ['required']
        ]);
    }

    protected function validatorDomain($request)
    {
        return $request->validate([
            'domain' => ['required'],
        ]);
    }

    protected function validatorSsh($request)
    {
        return $request->validate([
            'label' => ['required','alpha_dash'],
            'user' => ['required'],
            'publick' => ['required']
        ]);
    }

    protected function validatorSslA($request){
        return $request->validate([
            'provider' => ['required'],
            'enableHttp' => '',
            'enableHsts' => '',
            'ssl_protocol_id' => '',
            'authorizationMethod' => ['required'],
            'environment' => ['required']
        ]);
    }

    protected function validatorSslB($request){
        return $request->validate([
            'provider' => ['required'],
            'enableHttp' => '',
            'enableHsts' => '',
            'ssl_protocol_id' => '',
            'privateKey' => ['required'],
            'certificate' => ['required']
        ]);
    }

    protected function validatorSslC($request){
        return $request->validate([
            'enableHttp' => '',
            'enableHsts' => '',
            'ssl_protocol_id' => '',
            'privateKey' => ['required'],
            'certificate' => ['required']
        ]);
    }

    protected function validatorSslD($request){
        return $request->validate([
            'enableHttp' => '',
            'enableHsts' => '',
            'ssl_protocol_id' => '',
        ]);
    }
}
