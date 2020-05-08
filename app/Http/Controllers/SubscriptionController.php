<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Subscription;
use App\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role->id == 1){
            $subscriptions = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
                ->get(env('APP_VINDI_URL', false).'/subscriptions',[
                    'query' => ' status:active',
                    'sort_order' => 'desc'
                ])->json();
        }else{
            $subscriptions = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
                ->get(env('APP_VINDI_URL', false).'/subscriptions',[
                    'query' => 'customer_id:'.auth()->user()->vindi_id.' status:active',
                    'sort_order' => 'desc'
                ])->json();
        }
        
        return view("subscription.index",$subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plans = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/plans',[
                ' status:active'
            ])->json();

        foreach($plans['plans'] as $i => $plan){
            $total = 0;
            foreach($plan['plan_items'] as $product){
                $total += $product['pricing_schema']['price'];
            }
            $plans['plans'][$i]['total'] = $total;
        }
    
        return view("subscription.create",$plans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->post(env('APP_VINDI_URL', false).'/subscriptions',[
                'plan_id' => $request->input('plan'),
                'customer_id' => auth()->user()->vindi_id,
                'payment_method_code' => "credit_card"
            ]);
        $status = ($response->successful()) ? "Plano assinado" : "Erro ao assinar o plano";
        return redirect('subscription')->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscriptions = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/subscriptions',[
            'query' => 'id:'.$id.' status:active'
        ]);
        $bills = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/bills',[
            'query' => 'subscription_id:'.$id,
            'sort_order' => 'desc'
        ]);
        $server = Server::where('subscription_id', $id)->first();

        return view("subscription.show",array_merge($subscriptions->json(),$bills->json(),['server' => $server]));
    }

    public function connectCreate($id){
        $servers = Http::withBasicAuth(env('APP_RUNCLOUD_USER', false), env('APP_RUNCLOUD_PASS', false))
            ->get(env('APP_RUNCLOUD_URL', false).'/servers',[])->json();
        $subscriptions = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/subscriptions',[
                'query' => 'customer_id:'.$id.' status:active',
                'sort_order' => 'asc'
            ])->json();
        return view("server.create",array_merge(['servers' => $servers['data'], 'user' => $id], $subscriptions));
    }

    public function connectStore(Request $request)
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

        return redirect('user')->with('status', $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
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
