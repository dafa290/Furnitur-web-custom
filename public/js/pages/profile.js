async function saveAccountInfo(e) {
    e.preventDefault();
    const msgDiv = document.getElementById('profileMessage');
    msgDiv.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menyimpan...';
    
    try {
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await fetch('/api/profile/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.status === 'SUCCESS') {
            msgDiv.innerHTML = '<div class="message-success"><i class="fas fa-check-circle"></i> Profil berhasil diperbarui!</div>';
            if (typeof showToast === 'function') showToast('✓ Profil diperbarui');
        } else {
            msgDiv.innerHTML = '<div class="message-error"><i class="fas fa-times-circle"></i> ' + result.message + '</div>';
        }
    } catch (err) {
        msgDiv.innerHTML = '<div class="message-error">Terjadi kesalahan sistem</div>';
    }
}

async function handleChangePassword(e) {
    e.preventDefault();
    const msgDiv = document.getElementById('passwordMessage');
    const pass = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    
    if (pass !== confirm) {
        msgDiv.innerHTML = '<div class="message-error">Konfirmasi password tidak cocok</div>';
        return;
    }

    msgDiv.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengubah password...';
    try {
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const response = await fetch('/api/profile/password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.status === 'SUCCESS') {
            msgDiv.innerHTML = '<div class="message-success"><i class="fas fa-check-circle"></i> Password berhasil diubah!</div>';
            e.target.reset();
            if (typeof showToast === 'function') showToast('✓ Password diubah');
        } else {
            msgDiv.innerHTML = '<div class="message-error">' + result.message + '</div>';
        }
    } catch (err) {
        msgDiv.innerHTML = '<div class="message-error">Terjadi kesalahan sistem</div>';
    }
}
