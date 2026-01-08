@extends('layouts.app')
@section('title', 'Login Dokter')

@section('content')
<div class="container">
    <div class="card">
        <h1>Login Dokter</h1>

        @if(session('error'))
            <p style="color:red; text-align:center">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('dokter.login') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
