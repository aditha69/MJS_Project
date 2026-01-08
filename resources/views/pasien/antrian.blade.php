@extends('layouts.app')
@section('title', 'Nomor Antrian')

@section('content')
<div class="container">
    <div class="card antrian-box">

        @if($antrian)
            <h2>Nomor Antrian Anda</h2>

            <div class="nomor-antrian">
                <h1 id="nomorSaya">{{ $antrian->queue_number }}</h1>
            </div>

            <p><strong>Dokter:</strong> {{ $antrian->nama }} ({{ $antrian->spesialis }})</p>

            <div class="status status-{{ $antrian->status }}">
                <p>
                     Status:
                     <span id="statusSaya" class="status status-{{ $antrian->status }}">
                         {{ strtoupper($antrian->status) }}
                     </span>
                </p>
            </div>

            <p style="margin-top:15px">
                Nomor Antrian yang Sedang Dipanggil:
                <strong id="sekarang">
                     {{ $currentQueue->queue_number ?? '-' }}
                </strong>
            </p>

            <button onclick="window.print()">Cetak Antrian</button>
        @endif

    </div>
</div>

<script>
setInterval(function () {
    fetch('/pasien/realtime')
        .then(response => response.json())
        .then(data => {

            if (data.logout) {
                window.location.href = '/pasien/login';
                return;
            }

            if (!data.antrian) return;

            document.getElementById('nomorSaya').innerText =
                data.antrian.queue_number;

            document.getElementById('statusSaya').innerText =
                data.antrian.status.toUpperCase();

            document.getElementById('statusSaya').className =
                'status status-' + data.antrian.status;

            document.getElementById('sekarang').innerText =
                data.sekarang ?? '-';
        });
}, 2000);
</script>

@endsection
