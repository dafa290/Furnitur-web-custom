@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - FurniNest')

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

<style>
    .success-container { max-width: 500px; margin: 40px auto 60px; text-align: center; background: white; border-radius: 32px; padding: 48px 40px; box-shadow: var(--shadow); border: 1px solid var(--border-light); }
    .success-icon { width: 100px; height: 100px; background: rgba(46, 125, 50, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
    .success-icon i { font-size: 52px; color: #2e7d32; }
    .success-container h1 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: var(--brown); margin-bottom: 12px; }
    .success-message { color: #2e7d32; background: rgba(46, 125, 50, 0.08); padding: 10px 20px; border-radius: 30px; font-size: 13px; display: inline-block; margin-bottom: 20px; }
    .transaction-detail { background: var(--warm-white); border-radius: 20px; padding: 20px; margin: 20px 0; text-align: left; border: 1px solid var(--border-light); }
    .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border-light); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { font-weight: 600; color: var(--brown); font-size: 13px; }
    .detail-value { color: var(--text-dark); font-size: 14px; font-weight: 500; }
    .detail-value.amount { color: var(--gold-dark); font-size: 18px; font-weight: 700; }
    .info-text { background: rgba(198, 161, 91, 0.08); border-left: 3px solid var(--gold); padding: 14px 16px; border-radius: 12px; margin: 20px 0; text-align: left; }
    .info-text p { color: var(--text-light); font-size: 13px; line-height: 1.5; }
    .info-text i { color: var(--gold); margin-right: 8px; }
    .btn-home { background: var(--brown); border: none; padding: 14px 32px; border-radius: 40px; color: white; font-weight: 600; cursor: pointer; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; width: 100%; justify-content: center; }
    .btn-home:hover { background: var(--gold); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(198, 161, 91, 0.2); }
</style>

<script>
    function clearCartAndRedirect() {
        localStorage.removeItem('cart');
        window.location.href = '/home';
    }
    
    document.addEventListener('DOMContentLoaded', async () => {
        const urlParams = new URLSearchParams(window.location.search);
        
        // DOKU Sandbox parameters variations: invoice_number, order_id, orderId, etc.
        const orderId = urlParams.get('orderId') || 
                        urlParams.get('invoice_number') || 
                        urlParams.get('order_id') || 
                        urlParams.get('TRANSACTIONID');
        
        const result = (urlParams.get('result') || urlParams.get('status') || 'SUCCESS').toUpperCase();
        
        console.log('Detected OrderId:', orderId, 'Result:', result);

        if (orderId) {
            // Force verify status if coming back from DOKU (Simulate Webhook for Local)
            // DOKU Sandbox often uses SUCCESS or DONE or 0000
            const isSuccess = ['SUCCESS', 'DONE', '0000', 'PAID', 'CAPTURE'].includes(result);
            
            if (isSuccess) {
                try {
                    console.log('Triggering verification for:', orderId);
                    const verifyResponse = await fetch('/api/payments/verify', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orderId: orderId, status: 'SUCCESS' })
                    });
                    const verifyData = await verifyResponse.json();
                    console.log('Verification response:', verifyData);
                } catch (e) { 
                    console.error('Verification failed', e); 
                }
            }

            try {
                // Fetch latest status from database
                const response = await fetch(`/api/orders/status/${orderId}`);
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('transactionId').textContent = data.orderId;
                    document.getElementById('transactionDate').textContent = data.date;
                    document.getElementById('amount').textContent = 'Rp ' + data.amount.toLocaleString('id-ID');
                    
                    if (data.status === 'SUCCESS' || data.status === 'Sedang dikemas') {
                        document.querySelector('.success-message').innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i> Pembayaran Berhasil & Terverifikasi';
                    }
                } else {
                    document.getElementById('transactionId').textContent = orderId;
                }
            } catch (e) {
                console.error('Status check failed', e);
                document.getElementById('transactionId').textContent = orderId;
            }
        } else {
            document.getElementById('transactionId').textContent = 'FN-' + Date.now();
        }
        
        // Clear only purchased items from server cart and localStorage
        const purchasedIds = JSON.parse(localStorage.getItem('purchased_ids') || '[]');
        let localCart = JSON.parse(localStorage.getItem('cart') || '[]');
        
        if (purchasedIds.length > 0) {
            // Filter local cart
            localCart = localCart.filter(item => !purchasedIds.includes(item.id));
            localStorage.setItem('cart', JSON.stringify(localCart));
            
            // Tell server to remove only these IDs
            fetch('/api/cart/clear', { 
                method: 'POST', 
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids: purchasedIds })
            });
            
            // Clean up
            localStorage.removeItem('purchased_ids');
        } else {
            // Fallback: if no specific IDs, don't clear anything blindly to be safe
            // OR if you want to support direct access, maybe do nothing.
        }
    });
</script>
@endsection
