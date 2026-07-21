@extends('layouts.app')

@section('title', 'Pembayaran Gagal - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/payment-failed.css') }}">
@endsection

@section('content')
<div class="failed-container">
    <div class="failed-icon">
        <i class="fas fa-times-circle"></i>
    </div>
    <h1>Pembayaran Gagal</h1>
    <div class="error-message" id="errorMessage">
        <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
        Silakan coba lagi
    </div>
    <p>Mohon maaf, transaksi Anda tidak dapat diproses.</p>
    <p>Silakan periksa kembali metode pembayaran Anda atau coba beberapa saat lagi.</p>
    
    <div class="button-group">
        <button class="btn-home" onclick="window.location.href='/home'">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </button>
        <button class="btn-retry" onclick="window.location.href='/checkout'">
            <i class="fas fa-redo-alt"></i> Coba Lagi
        </button>
    </div>
    
    <div class="help-text">
        <i class="fas fa-headset"></i> Butuh bantuan? 
        <a href="/home#footer">Hubungi Customer Service</a>
    </div>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/payment-failed.js') }}"></script>
@endsection
@endsection
