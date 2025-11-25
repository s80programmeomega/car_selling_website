@extends('mail.car.layouts.base')

@section('header')
    <h2>💬 New Contact Message</h2>
    <p>You've received a new message</p>
@endsection

@section('content')
    <div class="field">
        <div class="label">👤 From</div>
        <div class="value">{{ $contactMessage->name }}</div>
    </div>
    <div class="field">
        <div class="label">📧 Email</div>
        <div class="value">{{ $contactMessage->email }}</div>
    </div>
    <div class="field">
        <div class="label">📋 Subject</div>
        <div class="value">{{ $contactMessage->subject }}</div>
    </div>
    <div class="field">
        <div class="label">💭 Message</div>
        <div class="value">{{ $contactMessage->message }}</div>
    </div>
    <div class="field">
        <div class="label">🕐 Received</div>
        <div class="value">{{ $contactMessage->created_at->format('M d, Y h:i A') }}</div>
    </div>
@endsection

@section('footer')
    This message was sent via {{ config('app.name') }} contact form
@endsection
