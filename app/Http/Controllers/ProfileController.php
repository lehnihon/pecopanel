<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $payment_profiles = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->get(env('APP_VINDI_URL', false).'/payment_profiles',[
                'query' => 'customer_id:'.auth()->user()->vindi_id.' status:active',
                'sort_order' => 'desc'
            ])->json();
        return view('profile.edit',$payment_profiles);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymethods(Request $request)
    {
        $data = $this->validator($request);

        $response = Http::withBasicAuth(env('APP_VINDI_TOKEN', false), '')
            ->post(env('APP_VINDI_URL', false).'/payment_profiles',[
                "holder_name" => $data['holder_name'],
                "card_expiration" =>  $data['card_expiration'],
                "card_number" =>  $data['card_number'],
                "card_cvv" =>  $data['card_cvv'],
                "payment_company_code" =>  $data['payment_company_code'],
                "payment_method_code" => "credit_card",
                "customer_id" => auth()->user()->vindi_id
            ]);

        return back()->withStatus(__('Perfil atualizado'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    protected function validator($request)
    {
        return $request->validate([
            "holder_name" => ['required'],
            "card_expiration" => ['required'],
            "card_number" => ['required', 'numeric', 'min:16'],
            "card_cvv" => ['required', 'numeric', 'min:3'],
            "payment_company_code" => ['required']
        ]);
    }
}
