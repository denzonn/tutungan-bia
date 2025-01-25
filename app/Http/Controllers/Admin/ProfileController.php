<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $data = Profile::first();

        return view('pages.admin.profile.index', compact('data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Profile::first()->update($request->all());

        return redirect()->route('admin.profile')->with('toast_success', 'Profile updated successfully');
    }
}
