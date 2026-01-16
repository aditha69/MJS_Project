@extends('layouts.app')
@section('title', 'Ambil Antrian')

@section('content')
<div class="container">
    <div class="card">
        <h1>Ambil Nomor Antrian</h1>

        <form method="POST" action="/pasien/ambil-antrian">
            @csrf

<div class="form-group">
    <label>Nama Pasien</label>
    <input type="text" name="nama" value="{{ $pasien->nama }}" required>
</div>

<div class="form-group">
    <label>Nomor Telepon</label>
    <input type="text" value="{{ $pasien->no_telp }}" readonly>
</div>

            <div class="form-group">
                <select name="dokters_id" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($dokters as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }} - {{ $d->spesialis }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Ambil Antrian</button>
            <div>
            </div>
        </form>
         <div>
            <a href="/pasien/login" class="logout"
             onclick="return confirm('Yakin logout?')">
            Keluar
            </a>
        </div>
</div>
@endsection
