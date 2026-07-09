@extends('layouts.app')

@section('title', 'Admin Login | WIA Studio')

@section('content')
<section class="admin admin-login">
    <p class="eyebrow">Backend</p>
    <h1>Admin login</h1> 

    <form class="admin-login-form" method="post" action="{{ route('admin.login.store') }}">
        @csrf

        @if ($errors->any())
            <p class="notice error">{{ $errors->first() }}</p>
        @endif

        <label>Email address
            <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
        </label>

        <label>Password
            <input type="password" name="password" autocomplete="current-password" required>
        </label>

        <label class="admin-remember">
            <input type="checkbox" name="remember" value="1">
            <span>Remember this device</span>
        </label>

        <button type="submit">Sign in</button>
    </form>

    <p class="admin-auth-switch">
        Need an admin account?
        <a href="{{ route('admin.signup') }}">Create admin sign up</a>
    </p>
</section>
@endsection
