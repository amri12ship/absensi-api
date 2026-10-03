@extends('layouts.app')

@section('title', $location->exists ? 'Edit Lokasi' : 'Tambah Lokasi')
@section('heading', $location->exists ? 'Edit Lokasi' : 'Tambah Lokasi')

@section('content')
    <div class="card">
        <form method="POST"
              action="{{ $location->exists ? route('admin.locations.update', $location) : route('admin.locations.store') }}">
            @csrf
            @if ($location->exists)
                @method('PUT')
            @endif

            <div class="grid cols-2">
                <div class="field">
                    <label for="name">Nama Lokasi</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $location->name) }}" required>
                </div>
                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="active" @selected(old('status', $location->status) === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status', $location->status) === 'inactive')>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" rows="2">{{ old('address', $location->address) }}</textarea>
            </div>

            <div class="grid cols-3">
                <div class="field">
                    <label for="latitude">Latitude</label>
                    <input id="latitude" type="number" step="0.0000001" name="latitude"
                           value="{{ old('latitude', $location->latitude) }}" required>
                </div>
                <div class="field">
                    <label for="longitude">Longitude</label>
                    <input id="longitude" type="number" step="0.0000001" name="longitude"
                           value="{{ old('longitude', $location->longitude) }}" required>
                </div>
                <div class="field">
                    <label for="radius">Radius (meter)</label>
                    <input id="radius" type="number" name="radius" min="20" max="5000"
                           value="{{ old('radius', $location->radius ?? 200) }}" required>
                </div>
            </div>

            <div class="toolbar" style="margin-bottom:0">
                <button type="submit" class="btn">Simpan Lokasi</button>
                <a class="btn secondary" href="{{ route('admin.locations.index') }}">Batal</a>
            </div>
        </form>
    </div>

    @if ($location->exists)
        <div class="card">
            <h2>QR Code Lokasi</h2>
            <p style="color:var(--muted);margin-top:0">
                QR hanya dapat dibaca melalui aplikasi mobile untuk menerbitkan ticket validasi sekali pakai.
                Token QR tidak pernah dikirim ke API.
            </p>
            <div class="toolbar" style="margin-bottom:0">
                <a class="btn" href="{{ route('admin.locations.qr', $location) }}">Buka QR Code</a>
                <form method="POST" action="{{ route('admin.locations.rotate', $location) }}"
                      onsubmit="return confirm('Token QR lama tidak akan berlaku lagi. Lanjutkan?')">
                    @csrf
                    <button class="btn danger" type="submit">Rotasi Token QR</button>
                </form>
            </div>
        </div>
    @endif
@endsection
