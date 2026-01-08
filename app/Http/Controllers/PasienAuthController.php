<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasienAuthController extends Controller
{
    public function loginForm()
    {
        return view('pasien.login');
    }

    public function login(Request $request)
{
    $pasien = DB::table('pasiens')
        ->where('email', $request->email)
        ->first();

    if (!$pasien || !Hash::check($request->password, $pasien->password)) {
        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    session(['pasien_id' => $pasien->id]);

    return redirect('/pasien/ambil-antrian');
}


    public function registerForm()
    {
        return view('pasien.register');
    }

    public function register(Request $request)
    {
        DB::table('pasiens')->insert([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/pasien/login')->with('success', 'Registrasi berhasil');
    }

    public function logout()
    {
        session()->forget('pasien_id');
        return redirect('/pasien/login');
    }
}
