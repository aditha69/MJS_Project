<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterAuthController extends Controller
{
    public function loginForm()
    {
        return view('dokter.login');
    }

   public function login(Request $request)
{
    // HANCURKAN SESSION LAMA
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $dokter = DB::table('dokters')
        ->where('email', $request->email)
        ->first();

    if (!$dokter || !Hash::check($request->password, $dokter->password)) {
        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    // SET SESSION BARU
    $request->session()->put('dokter_id', $dokter->id);

    return redirect('/dokter/dashboard');
}



}
