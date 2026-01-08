<h2>Nomor Antrian Anda</h2>

<h1 style="font-size:60px">{{ $antrian->nomor_antrian }}</h1>

<p>Status: {{ $antrian->status }}</p>

<p>Antrian Sekarang:
    {{ $antrianSekarang ?? 'Belum ada' }}
</p>

<button onclick="window.print()">Cetak Antrian</button>
