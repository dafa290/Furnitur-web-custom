@extends('layouts.app')

@section('title', 'Custom Furniture | FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/customize.css') }}">
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Canvas Container -->
        <div class="col-lg-9 col-md-8 position-relative bg-light" id="canvas-container" style="min-height: 60vh;">
            <div id="loading" class="position-absolute top-0 start-0 w-100 h-100 bg-white d-flex justify-content-center align-items-center" style="z-index: 100; transition: opacity 0.5s;">
                <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <!-- Controls Panel -->
        <div class="col-lg-3 col-md-4 bg-white shadow-sm" style="z-index: 10;">
            <div class="p-4">
                <h3 class="mb-4 pb-2 border-bottom text-dark" style="font-family: 'Playfair Display', serif;">Kustomisasi</h3>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">Tipe Furniture</label>
                    <select id="furniture-type" class="form-select border-0 bg-light">
                        <option value="wardrobe">Lemari</option>
                        <option value="bed">Tempat Tidur</option>
                        <option value="chair">Kursi</option>
                        <option value="table">Meja</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">
                        Lebar <span id="width-val" class="text-dark">120 cm</span>
                    </label>
                    <input type="range" class="form-range" id="width-range" min="40" max="300" step="10" value="120" style="accent-color: #C6A15B;">
                </div>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">
                        Tinggi <span id="height-val" class="text-dark">200 cm</span>
                    </label>
                    <input type="range" class="form-range" id="height-range" min="40" max="250" step="10" value="200" style="accent-color: #C6A15B;">
                </div>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">
                        Kedalaman <span id="depth-val" class="text-dark">60 cm</span>
                    </label>
                    <input type="range" class="form-range" id="depth-range" min="30" max="100" step="5" value="60" style="accent-color: #C6A15B;">
                </div>

                <div class="mb-4" id="door-config-group">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">Jumlah Pintu</label>
                    <select id="door-config" class="form-select border-0 bg-light">
                        <option value="1">1 Pintu</option>
                        <option value="2" selected>2 Pintu</option>
                        <option value="3">3 Pintu</option>
                        <option value="4">4 Pintu</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label d-flex justify-content-between text-muted small fw-bold">Warna & Material</label>
                    <div class="row g-2">
                        <div class="col-3"><div class="ratio ratio-1x1 color-option active rounded-3 shadow-sm border border-2 border-warning" data-color="#5d4037" title="Dark Walnut" style="background-color: #5d4037; cursor: pointer;"></div></div>
                        <div class="col-3"><div class="ratio ratio-1x1 color-option rounded-3 shadow-sm border border-2 border-transparent" data-color="#d9c5b2" title="Light Oak" style="background-color: #d9c5b2; cursor: pointer;"></div></div>
                        <div class="col-3"><div class="ratio ratio-1x1 color-option rounded-3 shadow-sm border border-2 border-transparent" data-color="#2c1b18" title="Mahogany" style="background-color: #2c1b18; cursor: pointer;"></div></div>
                        <div class="col-3"><div class="ratio ratio-1x1 color-option rounded-3 shadow-sm border border-2 border-transparent" data-color="#e8dfd5" title="Birch" style="background-color: #e8dfd5; cursor: pointer;"></div></div>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small fw-bold">Estimasi Harga</span>
                        <h4 id="price-display" class="text-dark fw-bold mb-0">Rp 4.500.000</h4>
                    </div>
                    <button class="btn w-100 py-3 fw-bold rounded-4 shadow" style="background-color: #2c1b18; color: white;" onclick="saveConfiguration()">
                        Pesan Desain Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('extra_js')
<!-- Three.js and OrbitControls from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="{{ asset('js/pages/customize.js') }}"></script>
@endsection
@endsection
