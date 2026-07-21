@extends('layouts.app')

@section('title', 'Pembayaran Gagal - FurniNest')

@section('extra_css')
<!-- Styles now handled by Bootstrap -->
@endsection

@section('content')
<div class="container py-5 my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 500px; width: 100%;">
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
            </div>
            <h1 class="h3 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: var(--brown);">Pembayaran Gagal</h1>
            <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 mb-4 fw-medium" id="errorMessage">
                <i class="fas fa-exclamation-triangle me-1"></i> Silakan coba lagi
            </div>
            
            <p class="text-muted mb-2">Mohon maaf, transaksi Anda tidak dapat diproses.</p>
            <p class="text-muted mb-4 small">Silakan periksa kembali metode pembayaran Anda atau coba beberapa saat lagi.</p>
            
            <div class="d-grid gap-3 mb-4">
                <button class="btn btn-outline-dark py-3 fw-bold rounded-pill" onclick="window.location.href='/home'">
                    <i class="fas fa-home me-2"></i> Kembali ke Beranda
                </button>
                <button class="btn py-3 fw-bold rounded-pill text-white" style="background-color: var(--brown);" onclick="window.location.href='/checkout'">
                    <i class="fas fa-redo-alt me-2"></i> Coba Lagi
                </button>
            </div>
            
            <div class="text-muted small">
                <i class="fas fa-headset me-1"></i> Butuh bantuan? 
                <a href="/home#footer" class="text-decoration-none fw-bold" style="color: var(--gold);">Hubungi Customer Service</a>
            </div>
        </div>
    </div>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/payment-failed.js') }}"></script>
@endsection
@endsection
