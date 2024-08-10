<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{

    // Authenticated
    public function Login()
    {
        return view('auth.login');
    }

    public function Page()
    {
        return view('layouts.master');
    }

    public function AuthLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login Successfully');
        } else {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        }
    }

    
    public function Logout()
    {
        Auth::logout();

        return redirect('/')->with('success', 'Logout Success');
    }

    // CRUD Karyawan

    public function index()
    {
        // Get all data Karyawan
        $karyawan = User::all();
        return view ('pegawai.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'posisi' => 'required|string|max:255',
            'gaji' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);


        $karyawan = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'posisi' => $validated['posisi'],
            'gaji' => $validated['gaji'],
        ]);

        return redirect()->back()->with('success', 'Data karyawan berhasil di tambahkan');
    }

    public function show($id)
    {
        // Get data karyawan by ID
        $karyawan = User::findOrFail($id);
        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'password' => 'nullable|string|min:6|confirmed',
            'posisi' => 'required|string|max:255',
            'gaji' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        // Cari Karyawan berdasarkan Id
        $karyawan = User::find($id);

        // Update data karyawan
        // Jika ada password baru, hash dan set ke atribut
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Hapus password dari array jika tidak diubah
        }
    
        // Update atribut user dengan data yang sudah divalidasi
        $karyawan->update($validated);
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        // Delete user by ID
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
