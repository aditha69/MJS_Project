<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    // halaman ambil antrian
    public function formAmbilAntrian()
    {
        // proteksi login
        if (!session('pasien_id')) {
            return redirect('/pasien/login');
        }

        $pasien = DB::table('pasiens')->where('id', session('pasien_id'))->first();
        $dokters = DB::table('dokters')->get();

        return view('pasien.ambil_antrian', compact('pasien', 'dokters'));
    }

    // proses ambil antrian
    public function simpanAntrian(Request $request)
    {

        DB::table('pasiens')
            ->where('id', session('pasien_id'))
            ->update([
                'nama' => $request->nama
            ]);

        if (!session('pasien_id')) {
            return redirect('/pasien/login');
        }

        $today = date('Y-m-d');

        // cari nomor antrian terakhir hari ini untuk dokter tsb
        $lastQueue = DB::table('queues')
            ->where('dokters_id', $request->dokters_id)
            ->where('queue_date', $today)
            ->max('queue_number');

        $nextQueueNumber = $lastQueue ? $lastQueue + 1 : 1;

        DB::table('queues')->insert([
            'pasiens_id'   => session('pasien_id'),
            'dokters_id'   => $request->dokters_id,
            'queue_number' => $nextQueueNumber,
            'queue_date'   => $today,
            'status'       => 'menunggu',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect('/pasien/antrian');
    }

    // halaman lihat antrian
    public function lihatAntrian()
    {
        if (!session('pasien_id')) {
            return redirect('/pasien/login');
        }

        $antrian = DB::table('queues')
            ->join('dokters', 'queues.dokters_id', '=', 'dokters.id')
            ->where('queues.pasiens_id', session('pasien_id'))
            ->whereDate('queues.queue_date', date('Y-m-d'))
            ->orderByDesc('queues.id')
            ->first();
            
        if (!$antrian) {
             return redirect('/pasien/ambil-antrian')
                ->with('error', 'Belum ada antrian hari ini');
        }


        // antrian sekarang (yang sedang dipanggil)
        $currentQueue = DB::table('queues')
            ->where('dokters_id', $antrian->dokters_id)
            ->where('queue_date', date('Y-m-d'))
            ->where('status', 'dipanggil')
            ->orderBy('queue_number')
            ->first();

        return view('pasien.antrian', compact('antrian', 'currentQueue'));
    }


public function realtime(Request $request)
{
    $pasienId = session('pasien_id');

    if (!$pasienId) {
        return response()->json(['logout' => true]);
    }

    $antrian = DB::table('queues')
        ->join('dokters', 'queues.dokters_id', '=', 'dokters.id')
        ->where('queues.pasiens_id', $pasienId)
        ->whereDate('queues.queue_date', date('Y-m-d'))
        ->select(
            'queues.queue_number',
            'queues.status',
            'queues.dokters_id',
            'dokters.nama',
            'dokters.spesialis'
        )
        ->first();

    if (!$antrian) {
        return response()->json(['antrian' => null]);
    }

    $antrianSekarang = DB::table('queues')
        ->where('dokters_id', $antrian->dokters_id)
        ->where('status', 'dipanggil')
        ->whereDate('queue_date', date('Y-m-d'))
        ->value('queue_number');

    return response()->json([
        'antrian' => $antrian,
        'sekarang' => $antrianSekarang
    ]);
}

}
