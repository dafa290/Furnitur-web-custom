@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - FurniNest')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/pages/payment-success.css') }}">
@endsection

@section('content')
<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1>Pembayaran Berhasil!</h1>
    <div class="success-message">
        <i class="fas fa-check" style="margin-right: 6px;"></i> Transaksi Anda telah dikonfirmasi
    </div>
    
    <div class="transaction-detail">
        <div class="detail-row">
            <span class="detail-label">ID Transaksi</span>
            <span class="detail-value" id="transactionId">-</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value" id="transactionDate">-</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Total Pembayaran</span>
            <span class="detail-value amount" id="amount">-</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value" style="color: #2e7d32;"><i class="fas fa-check-circle"></i> Lunas</span>
        </div>
    </div>
    
    <div class="info-text">
        <i class="fas fa-truck"></i>
        <p>Pesanan Anda sedang diproses. Kami akan mengirimkan notifikasi melalui email ketika pesanan sudah dikirim.</p>
    </div>
    
    <div class="info-text">
        <i class="fas fa-receipt"></i>
        <p>Invoice dan detail pesanan telah dikirim ke email Anda. Simpan sebagai bukti pembayaran.</p>
    </div>
    
    <button class="btn-home" onclick="clearCartAndRedirect()">
        <i class="fas fa-home"></i> Kembali ke Beranda
    </button>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/payment-success.js') }}"></script>
@endsection
@endsection
