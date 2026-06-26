@extends('layouts.app')

@section('title', 'Alamat Saya - FurniNest')

@section('content')
<div class="address-container">
    <h1 class="page-title"><i class="fas fa-map-pin"></i> Alamat Saya</h1>
    
    <div class="address-grid">
        @foreach($addresses as $addr)
            <div class="address-card {{ $addr->is_default ? 'default' : '' }}">
                <div class="address-label">
                    <span><i class="fas fa-tag"></i> {{ $addr->label }}</span>
                    @if($addr->is_default)
                        <span class="badge-default">Utama</span>
                    @endif
                </div>
                <div class="address-detail">
                    <strong>{{ $addr->recipient_name }}</strong><br>
                    📞 {{ $addr->phone }}<br>
                    📍 {{ $addr->address_line }}<br>
                    {{ $addr->city }}, {{ $addr->province }}<br>
                    ✉️ {{ $addr->postal_code }}
                </div>
                <div class="address-actions">
                    <a href="/alamat/edit/{{ $addr->id }}" class="btn-sm btn-edit-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @if(!$addr->is_default)
                        <form action="/alamat/set-default/{{ $addr->id }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-primary-sm">
                                <i class="fas fa-star"></i> Jadikan Utama
                            </button>
                        </form>
                    @endif
                    <form action="/alamat/delete/{{ $addr->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus alamat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger-sm">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        
        <!-- Card Tambah Alamat -->
        <div class="address-card add-card" onclick="toggleAddressForm()">
            <div class="add-card-content">
                <i class="fas fa-plus-circle"></i>
                <p>Tambah Alamat Baru</p>
            </div>
        </div>
    </div>
    
    <!-- Form Tambah Alamat -->
    <div id="addAddressForm" style="display: none;">
        <div class="form-card">
            <h3><i class="fas fa-plus-circle" style="color: var(--gold);"></i> Tambah Alamat Baru</h3>
            <form method="post" action="/alamat/add">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Label</label>
                        <input type="text" name="label" required placeholder="Contoh: Rumah, Kantor">
                    </div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" name="recipient_name" required placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="tel" name="phone" required placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input type="text" name="postal_code" required placeholder="12345">
                    </div>
                    <div class="form-group full-width">
                        <label>Alamat Lengkap</label>
                        <textarea name="address_line" rows="2" required placeholder="Jl. Contoh No. 123, RT/RW"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" name="city" required placeholder="Contoh: Jakarta Selatan">
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="province" required placeholder="Contoh: DKI Jakarta">
                    </div>
                    <div class="form-group full-width">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_default" value="1">
                            <label>Jadikan alamat utama</label>
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 12px; margin-top: 20px;">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Alamat</button>
                    <button type="button" onclick="toggleAddressForm()" class="btn-cancel">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .address-container { max-width: 1200px; margin: 40px auto 60px; padding: 0 20px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 600; color: var(--brown); margin-bottom: 32px; }
    .page-title i { color: var(--gold); margin-right: 12px; }
    .address-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px; margin-bottom: 40px; }
    .address-card { background: white; border-radius: 24px; padding: 24px; box-shadow: var(--shadow); border: 1px solid var(--border-light); position: relative; transition: all 0.3s; }
    .address-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }
    .address-card.default { border-left: 4px solid var(--gold); }
    .address-label { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: var(--brown); }
    .badge-default { background: var(--gold); color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 600; }
    .address-detail { color: var(--text-light); font-size: 14px; line-height: 1.7; margin-bottom: 20px; }
    .address-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .btn-sm { padding: 8px 16px; border-radius: 30px; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 6px; border: none; }
    .btn-primary-sm { background: var(--gold); color: white; }
    .btn-edit-sm { background: rgba(92, 61, 46, 0.1); color: var(--brown); border: 1px solid var(--border-light); }
    .btn-danger-sm { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.3); }
    .add-card { display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px dashed var(--border-light); background: rgba(255,255,255,0.5); min-height: 200px; }
    .add-card:hover { border-color: var(--gold); background: white; }
    .add-card-content { text-align: center; }
    .add-card-content i { font-size: 48px; color: var(--gold); margin-bottom: 12px; }
    .form-card { background: white; border-radius: 24px; padding: 32px; box-shadow: var(--shadow); border: 1px solid var(--border-light); margin-top: 20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: var(--brown); text-transform: uppercase; }
    .form-group input, .form-group textarea { width: 100%; padding: 12px 16px; background: var(--warm-white); border: 1px solid var(--border-light); border-radius: 16px; font-family: 'Inter', sans-serif; font-size: 14px; }
    .full-width { grid-column: span 2; }
    .checkbox-group { display: flex; align-items: center; gap: 12px; }
    .btn-submit { background: var(--brown); color: white; padding: 12px 28px; border: none; border-radius: 40px; font-weight: 600; cursor: pointer; }
    .btn-cancel { background: transparent; border: 1px solid var(--border-light); color: var(--text-light); padding: 12px 28px; border-radius: 40px; font-weight: 600; cursor: pointer; }

    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
</style>

<script>
    function toggleAddressForm() {
        const form = document.getElementById('addAddressForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        if (form.style.display === 'block') form.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection
