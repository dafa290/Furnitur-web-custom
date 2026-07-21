@extends('layouts.app')

@section('title', 'Alamat Saya - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/addresses.css') }}">
@endsection

@section('content')
<div class="address-container">
    <h1 class="page-title"><i class="fas fa-map-pin"></i> Alamat Saya</h1>
    
    <div class="address-grid">
        @foreach($addresses as $addr)
            <div class="address-card {{ $addr->is_default ? 'default' : '' }}">
                <div class="address-label">
                    <span><i class="fas fa-tag"></i> {{ $addr->label }}</span>
                    @if($addr->is_default)
                        <span class="badge-default">Utama</span>
                    @endif
                </div>
                <div class="address-detail">
                    <strong>{{ $addr->recipient_name }}</strong><br>
                    📞 {{ $addr->phone }}<br>
                    📍 {{ $addr->address_line }}<br>
                    {{ $addr->city }}, {{ $addr->province }}<br>
                    ✉️ {{ $addr->postal_code }}
                </div>
                <div class="address-actions">
                    <a href="/alamat/edit/{{ $addr->id }}" class="btn-sm btn-edit-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @if(!$addr->is_default)
                        <form action="/alamat/set-default/{{ $addr->id }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-primary-sm">
                                <i class="fas fa-star"></i> Jadikan Utama
                            </button>
                        </form>
                    @endif
                    <form action="/alamat/delete/{{ $addr->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus alamat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger-sm">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        
        <!-- Card Tambah Alamat -->
        <div class="address-card add-card" onclick="toggleAddressForm()">
            <div class="add-card-content">
                <i class="fas fa-plus-circle"></i>
                <p>Tambah Alamat Baru</p>
            </div>
        </div>
    </div>
    
    <!-- Form Tambah Alamat -->
    <div id="addAddressForm" style="display: none;">
        <div class="form-card">
            <h3><i class="fas fa-plus-circle" style="color: var(--gold);"></i> Tambah Alamat Baru</h3>
            <form method="post" action="/alamat/add">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" required placeholder="Contoh: Rumah, Kantor">
                    </div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="recipient_name" required placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="tel" name="phone" required placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input type="text" name="postal_code" required placeholder="12345">
                    </div>
                    <div class="form-group full-width">
                        <label>Alamat Lengkap</label>
                        <textarea name="address_line" rows="2" required placeholder="Jl. Contoh No. 123, RT/RW"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" name="city" required placeholder="Contoh: Jakarta Selatan">
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="province" required placeholder="Contoh: DKI Jakarta">
                    </div>
                    <div class="form-group full-width">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_default" value="1">
                            <label>Jadikan alamat utama</label>
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 20px;">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Alamat</button>
                    <button type="button" onclick="toggleAddressForm()" class="btn-cancel">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/addresses.js') }}"></script>
@endsection
@endsection
