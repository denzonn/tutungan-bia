<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(){
        $data = Setting::first();
        return view('pages.admin.setting.index', compact('data'));
    }

    public function update(Request $request, $id){
        $data = $request->all();
        
        $setting = Setting::findOrFail($id);
        
        if ($request->hasFile('logo')) {
            $images = $request->file('logo');
            $extension = $images->getClientOriginalExtension();
            $random = \Str::random(10);
            $file_name = "logo" . $random . "." . $extension;

            // Hapus gambar lama jika ada
            if ($setting->image && Storage::exists('public/' . $setting->image)) {
                Storage::delete('public/' . $setting->image);
            }
            $data['logo'] = $images->storeAs('setting', $file_name, 'public');
        } else {
            $data['logo'] = $setting->logo;
        }

        $setting->update([
            'short_profile' => $data['short_profile'],
            'sosial_media_1' => $data['sosial_media_1'],
            'sosial_media_2' => $data['sosial_media_2'],
            'sosial_media_3' => $data['sosial_media_3'],
            'logo' => $data['logo'],
        ]);

        return redirect()->route('admin.setting')->with('success_toast', 'Berhasil Mengubah Setting');
    }
}
