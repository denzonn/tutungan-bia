<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Fitur pencarian berdasarkan judul
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination dengan 10 item per halaman
        $data = $query->paginate(10);

        return view('pages.admin.user.index', compact('data')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('pages.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $images = $request->file('profile_photo');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "profile_photo" . $random . "." . $extension;

            $data['profile_photo'] = $images->storeAs('profile_photo', $file_name, 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_photo' => $data['profile_photo'] ?? null,
        ]);
    
        // Assign role ke user
        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('toast_success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);
        $roles = Role::all();

        return view('pages.admin.user.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string|exists:roles,name',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('profile_photo')) {
            $images = $request->file('profile_photo');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "profile_photo" . $random . "." . $extension;

            // Hapus file lama jika ada
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }

            $data['profile_photo'] = $images->storeAs('profile_photo', $file_name, 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile_photo' => $data['profile_photo'] ?? $user->profile_photo,
        ]);

        // Assign role ke user
        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('toast_success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus file foto profil jika ada
        if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $user->delete();

        return redirect()->route('user.index')->with('toast_success', 'User berhasil dihapus');
    }
}
