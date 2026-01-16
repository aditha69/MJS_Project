@extends('layouts.app')
@section('title', 'Register Pasien')

@section('content')
<div class="container">
    <div class="card">
        <h1>Register Pasien</h1>

        <form method="POST" action="/pasien/register">
            @csrf

            <div class="form-group">
                <input type="text" name="nama" placeholder="Nama" required>
            </div>

            <div class="form-group">
                <input type="text" name="no_telp" placeholder="No Telepon" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Register</button>
            <div>
            <button>logout</button>
            </div>
        </form>
    </div>
</div>
@endsection
