@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')

<h1>Dashboard Saya</h1>
<h2>{{ $dokter->nama }}</h2>
<h3>{{ $dokter->spesialis }}</h3>
<table class="table">
    <tr>
        <th>No Antrian</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($antrians as $a)
    <tr>
        <td>{{ $a->queue_number }}</td>
        <td>
            <span class="status status-{{ $a->status }}">
                {{ strtoupper($a->status) }}
            </span>
        </td>
        <td>
            @if($a->status == 'menunggu')
                <form method="POST" action="{{ route('dokter.panggil', $a->id) }}">
                    @csrf
                    <button>Panggil</button>
                </form>
            @elseif($a->status == 'dipanggil')
                <form method="POST" action="{{ route('dokter.selesai', $a->id) }}">
                    @csrf
                    <button>Selesai</button>
                </form>
            @endif
        </td>
    </tr>
    @endforeach
</table>

<a href="/dokter/logout" class="logout"
   onclick="return confirm('Yakin logout?')">
   Logout
</a>

@endsection
