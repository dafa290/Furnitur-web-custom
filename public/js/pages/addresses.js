function toggleAddressForm() {
    const form = document.getElementById('addAddressForm');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    if (form.style.display === 'block') form.scrollIntoView({ behavior: 'smooth' });
}
