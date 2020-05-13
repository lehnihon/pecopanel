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
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $data = $request->all();
        $data['dark'] = (isset($data['dark']))?'1':'0';
        auth()->user()->update($data);

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
