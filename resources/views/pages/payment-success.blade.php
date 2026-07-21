@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - FurniNest')

@section('extra_css')
<!-- Styles now handled by Bootstrap -->
@endsection

@section('content')
<div class="container py-5 my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 500px; width: 100%;">
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
            </div>
            <h1 class="h3 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: var(--brown);">Pembayaran Berhasil!</h1>
            <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 mb-4 fw-medium">
                <i class="fas fa-check me-1"></i> Transaksi Anda telah dikonfirmasi
            </div>
            
            <div class="bg-light rounded-3 p-4 text-start mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">ID Transaksi</span>
                    <span class="fw-bold" id="transactionId">-</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Tanggal</span>
                    <span class="fw-bold" id="transactionDate">-</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Pembayaran</span>
                    <span class="fw-bold text-success" id="amount">-</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Status</span>
                    <span class="fw-bold text-success"><i class="fas fa-check-circle"></i> Lunas</span>
                </div>
            </div>
            
            <div class="d-flex align-items-start gap-3 text-start bg-light p-3 rounded-3 mb-3">
                <i class="fas fa-truck text-muted mt-1"></i>
                <p class="mb-0 small text-muted">Pesanan Anda sedang diproses. Kami akan mengirimkan notifikasi melalui email ketika pesanan sudah dikirim.</p>
            </div>
            
            <div class="d-flex align-items-start gap-3 text-start bg-light p-3 rounded-3 mb-4">
                <i class="fas fa-receipt text-muted mt-1"></i>
                <p class="mb-0 small text-muted">Invoice dan detail pesanan telah dikirim ke email Anda. Simpan sebagai bukti pembayaran.</p>
            </div>
            
            <button class="btn w-100 py-3 fw-bold rounded-pill text-white" style="background-color: var(--brown);" onclick="clearCartAndRedirect()">
                <i class="fas fa-home me-2"></i> Kembali ke Beranda
            </button>
        </div>
    </div>
</div>

@section('extra_js')
<script src="{{ asset('js/pages/payment-success.js') }}"></script>
@endsection
@endsection
