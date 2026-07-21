document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    let msg = urlParams.get('message') || 'Pembayaran gagal, silakan coba lagi';
    document.getElementById('errorMessage').innerHTML = `<i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> ${msg}`;
});
