@extends('layouts.app')

@section('title', 'QR Code ' . $location->name)
@section('heading', 'QR Code — ' . $location->name)

@section('content')
    <div class="card qr-sheet">
        <p style="margin-top:0">{{ $location->name }}</p>
        <p style="color:var(--muted)">{{ $location->address }}</p>

        <img src="{{ route('admin.locations.qr.image', $location) }}" alt="QR code {{ $location->name }}">

        <p style="margin-bottom:4px">Pindai QR ini dari aplikasi mobile saat check-in.</p>
        <p class="token">{{ $location->public_token }}</p>

        <div class="no-print" style="margin-top:18px">
            <a class="btn" href="{{ route('admin.locations.index') }}">Kembali</a>
            <button class="btn secondary" type="button" onclick="window.print()">Cetak</button>
            <form method="POST" action="{{ route('admin.locations.rotate', $location) }}" style="display:inline"
                  onsubmit="return confirm('Token QR lama tidak akan berlaku lagi. Lanjutkan?')">
                @csrf
                <button class="btn danger" type="submit">Rotasi Token</button>
            </form>
        </div>
    </div>
@endsection
