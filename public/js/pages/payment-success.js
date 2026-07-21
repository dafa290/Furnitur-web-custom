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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
