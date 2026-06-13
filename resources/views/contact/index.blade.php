@extends('layouts.app')

@section('title', 'Contact | WIA Studio')
@section('body_class', 'big-white-page contact-page')

@section('content')
<section class="contact-index">
    <h1>CONTACT</h1>

    <div class="contact-index-grid">
        <article>
            <span>Email</span>
            <a href="mailto:{{ $studioProfile->contact_email ?: 'studio@wia.com' }}">
                {{ $studioProfile->contact_email ?: 'studio@wia.com' }}
            </a>
        </article>
        <article>
            <span>Phone</span>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $studioProfile->phone_number ?: '+254700000000') }}">
                {{ $studioProfile->phone_number ?: '+254 700 000 000' }}
            </a>
        </article>
        <article>
            <span>Studio</span>
            <p>Nairobi, Kenya</p>
        </article>
    </div>
</section>
@endsection
