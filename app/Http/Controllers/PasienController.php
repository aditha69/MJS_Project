<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // Halaman ambil antrian
    public function ambilAntrianForm()
{
    $dokters = DB::table('dokters')->get();

    $pasien = DB::table('pasiens')
        ->where('id', session('pasien_id'))
        ->first();

    return view('pasien.ambil_antrian', compact('dokters', 'pasien'));
}


    // Proses ambil antrian (INI YANG PENTING)
    public function ambilAntrian(Request $request)
    {
        $dokterId = $request->dokters_id;
        $today = date('Y-m-d');

        // Hitung nomor antrian terakhir
          $lastQueue = DB::table('queues')
        ->where('dokters_id', $dokterId)
        ->whereDate('queue_date', date('Y-m-d'))
        ->max('queue_number');

        $queueNumber = $lastQueue ? $lastQueue + 1 : 1;

        DB::table('queues')->insert([
            'pasiens_id' => session('pasien_id'),
            'dokters_id' => $dokterId,
            'queue_number' => $queueNumber,
            'queue_date' => $today,
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/pasien/antrian');
    }

    // Halaman lihat antrian
  public function antrian()
{
    $pasienId = session('pasien_id');

    if (!$pasienId) {
        return redirect('/pasien/login');
    }

    $antrian = DB::table('queues')
        ->join('dokters', 'queues.dokters_id', '=', 'dokters.id')
        ->where('queues.pasiens_id', $pasienId)
        ->whereDate('queues.queue_date', now())
        ->orderByDesc('queues.id')
        ->select(
            'queues.*',
            'dokters.nama',
            'dokters.spesialis'
        )
        ->first();

    if (!$antrian) {
        return view('pasien.antrian', [
            'antrian' => null
        ]);
    }

    $antrianSekarang = DB::table('queues')
        ->where('dokters_id', $antrian->dokters_id)
        ->whereDate('queue_date', now())
        ->where('status', 'dipanggil')
        ->orderBy('queue_number')
        ->value('queue_number');

    return view('pasien.antrian', [
        'antrian' => $antrian,
        'antrianSekarang' => $antrianSekarang
    ]);
}

}
