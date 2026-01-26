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
            'name' => 'required|string|max:20',
            'postcode' => 'required|string',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $user = auth()->user();

        // プロフィール更新
        $user->update([
            'name' => $request->name,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building,
            'profile_completed' => true,
        ]);

        return redirect('/?tab=mylist');
    }
}
