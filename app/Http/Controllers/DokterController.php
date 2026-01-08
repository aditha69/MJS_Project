<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index()
{
    $dokterId = session('dokter_id');

    if (!$dokterId) {
        return redirect('/dokter/login');
    }

    $dokter = DB::table('dokters')
        ->where('id', $dokterId)
        ->first();

    $antrians = DB::table('queues')
        ->where('dokters_id', $dokterId)
        ->whereIn('status', ['menunggu', 'dipanggil'])
        ->orderBy('queue_number', 'asc')
        ->get();

    return view('dokter.dashboard', compact('dokter', 'antrians'));
}


    public function panggil($id)
{
    $dokterId = session('dokter_id');

    // Reset hanya antrian dokter ini
    DB::table('queues')
        ->where('dokters_id', $dokterId)
        ->whereDate('queue_date', now())
        ->where('status', 'dipanggil')
        ->update(['status' => 'menunggu']);

    // Set antrian ini jadi dipanggil
    DB::table('queues')
        ->where('id', $id)
        ->where('dokters_id', $dokterId)
        ->whereDate('queue_date', now())
        ->update(['status' => 'dipanggil']);

    return redirect()->back();
}


   public function selesai($id)
{
    $dokterId = session('dokter_id');

    DB::table('queues')
        ->where('id', $id)
        ->where('dokters_id', $dokterId)
        ->update(['status' => 'selesai']);

    return redirect()->back();
}




}
