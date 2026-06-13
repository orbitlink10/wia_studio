@extends('layouts.app')

@section('title', 'Admin Sign Up | WIA Studio')

@section('content')
<section class="admin admin-login">
    <p class="eyebrow">Backend</p>
    <h1>Admin sign up</h1>

    <form class="admin-login-form" method="post" action="{{ route('admin.signup.store') }}">
        @csrf

        @if ($errors->any())
            <p class="notice error">{{ $errors->first() }}</p>
        @endif

        <label>Admin Gmail
            <input type="email" name="email" value="{{ old('email') }}" placeholder="company.admin@gmail.com" autocomplete="email" required autofocus>
        </label>

        <label>Password
            <input type="password" name="password" autocomplete="new-password" required>
        </label>

        <button type="submit">Create admin</button>
    </form>

    <p class="admin-auth-switch">
        Already have an account?
        <a href="{{ route('admin.login') }}">Sign in</a>
    </p>
</section>
@endsection
