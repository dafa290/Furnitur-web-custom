@extends('layouts.app')

@section('title', 'Alamat Saya - FurniNest')

@section('extra_css')
<!-- Styles now handled by Bootstrap -->
@endsection

@section('content')
<div class="container py-5 my-5">
    <h1 class="h2 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-map-pin text-warning me-2"></i> Alamat Saya</h1>
    
    <div class="row g-4 mb-5">
        @foreach($addresses as $addr)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm {{ $addr->is_default ? 'border-start border-4 border-warning' : '' }}">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h6 fw-bold mb-0" style="font-family: 'Playfair Display', serif; color: var(--brown);">
                                <i class="fas fa-tag text-warning me-2"></i> {{ $addr->label }}
                            </span>
                            @if($addr->is_default)
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Utama</span>
                            @endif
                        </div>
                        <div class="text-muted small mb-4 flex-grow-1">
                            <strong class="text-dark">{{ $addr->recipient_name }}</strong><br>
                            <span class="d-inline-block mt-2">📞 {{ $addr->phone }}</span><br>
                            <span class="d-inline-block mt-1">📍 {{ $addr->address_line }}</span><br>
                            {{ $addr->city }}, {{ $addr->province }}<br>
                            ✉️ {{ $addr->postal_code }}
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-auto">
                            <a href="/alamat/edit/{{ $addr->id }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            @if(!$addr->is_default)
                                <form action="/alamat/set-default/{{ $addr->id }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold">
                                        <i class="fas fa-star me-1"></i> Jadikan Utama
                                    </button>
                                </form>
                            @endif
                            <form action="/alamat/delete/{{ $addr->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus alamat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Card Tambah Alamat -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border border-dashed rounded-4 bg-light cursor-pointer" onclick="toggleAddressForm()" style="min-height: 200px; cursor: pointer;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted hover-shadow transition">
                    <i class="fas fa-plus-circle fa-3x text-warning mb-3"></i>
                    <p class="fw-bold mb-0">Tambah Alamat Baru</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Tambah Alamat -->
    <div id="addAddressForm" style="display: none;">
        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
            <h3 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif; color: var(--brown);"><i class="fas fa-plus-circle text-warning me-2"></i> Tambah Alamat Baru</h3>
            <form method="post" action="/alamat/add">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Label</label>
                        <input type="text" name="label" class="form-control form-control-lg bg-light" required placeholder="Contoh: Rumah, Kantor">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-control form-control-lg bg-light" required placeholder="Nama lengkap">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">No. Telepon</label>
                        <input type="tel" name="phone" class="form-control form-control-lg bg-light" required placeholder="08123456789">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Kode Pos</label>
                        <input type="text" name="postal_code" class="form-control form-control-lg bg-light" required placeholder="12345">
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold text-uppercase">Alamat Lengkap</label>
                        <textarea name="address_line" rows="2" class="form-control form-control-lg bg-light" required placeholder="Jl. Contoh No. 123, RT/RW"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Kota</label>
                        <input type="text" name="city" class="form-control form-control-lg bg-light" required placeholder="Contoh: Jakarta Selatan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold text-uppercase">Provinsi</label>
                        <input type="text" name="province" class="form-control form-control-lg bg-light" required placeholder="Contoh: DKI Jakarta">
                    </div>
                    <div class="col-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input border-warning" type="checkbox" name="is_default" value="1" id="defaultCheck">
                            <label class="form-check-label text-muted fw-bold" for="defaultCheck">
                                Jadikan alamat utama
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3 mt-4 pt-4 border-top">
                    <button type="submit" class="btn py-3 px-4 fw-bold rounded-pill text-white" style="background-color: var(--brown);">
                        <i class="fas fa-save me-2"></i> Simpan Alamat
                    </button>
                    <button type="button" onclick="toggleAddressForm()" class="btn btn-outline-secondary py-3 px-4 fw-bold rounded-pill">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/addresses.js') }}"></script>
@endsection
@endsection
