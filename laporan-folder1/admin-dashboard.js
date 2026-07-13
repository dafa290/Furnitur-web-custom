// ===== ADMIN DASHBOARD SCRIPT =====

// Tandai menu aktif berdasarkan link yang diklik
document.querySelectorAll('.menu-item').forEach(function (item) {
    item.addEventListener('click', function () {
        document.querySelectorAll('.menu-item').forEach(function (el) {
            el.classList.remove('active');
        });
        this.classList.add('active');
    });
});
