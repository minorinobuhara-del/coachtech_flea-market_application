<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'postcode' => ['required'],
            'address' => ['required'],
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
            'profile_completed' => true,
        ]);

        return redirect('/mypage');
    }
}
