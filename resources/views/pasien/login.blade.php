@extends('layouts.app')
@section('title', 'Login Pasien')

@section('content')
<div class="container">
    <div class="card">
        <h1>Login Udin</h1>

        @if(session('error'))
            <p style="color:red; text-align:center">{{ session('error') }}</p>
        @endif

        @if(session('success'))
            <p style="color:green; text-align:center">{{ session('success') }}</p>
        @endif

        <form method="POST" action="/pasien/login">
            @csrf

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="link">
            <a href="/pasien/register">Register</a>
        </div>
    </div>
</div>
@endsection
