@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('breadcrumb', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
        <p class="page-subtitle">{{ isset($product) ? 'Perbarui informasi produk: ' . $product->name : 'Isi formulir di bawah untuk menambahkan produk baru ke katalog' }}</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        @if(isset($product))
        <a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="btn btn--ghost">↗ Lihat Halaman</a>
        @endif
        <a href="{{ route('admin.products.index') }}" class="btn btn--ghost">← Kembali</a>
    </div>
</div>

{{-- Grid wrapper: form (kiri) + sidebar (kanan). Sidebar SENGAJA di luar <form> --}}
<div style="display:grid; grid-template-columns:1fr 320px; gap:1.5rem; align-items:start;">

<form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
      method="POST" id="productForm" enctype="multipart/form-data" novalidate>
    @csrf
    @if(isset($product)) @method('PUT') @endif

    <!-- LEFT: Main Fields -->
    <div class="form-main">

        <!-- IDENTITAS PRODUK -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">1</span> Identitas Produk</h3>
            </div>
            <div class="admin-card__body">

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nama Produk <span class="req">*</span></label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $product->name ?? '') }}"
                               placeholder="cth: Besi Beton, H-Beam, Pipa Galvanis"
                               required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">
                            Slug / URL
                            <span class="label-hint">— akan digenerate otomatis</span>
                        </label>
                        <div class="slug-wrap">
                            <span class="slug-prefix">/product/</span>
                            <input type="text" id="slug" name="slug"
                                   value="{{ old('slug', $product->slug ?? '') }}"
                                   placeholder="besi-beton">
                        </div>
                        @error('slug')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Kategori <span class="req">*</span></label>
                        <select id="category" name="category" required>
                            <option value="">-- Pilih Kategori --</option>
                            @php
                            $cats = ['Baja Tulangan','Baja Profil','Plat & Sheet','Pipa','Hollow','Baja Ringan','Wiremesh','Pagar','Aksesori','Kawat','Bondek'];
                            @endphp
                            @foreach($cats as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar Produk</label>
                        <input type="file" id="image" name="image" class="form-control">

                        @if(isset($product) && $product->image)
                            <div style="margin-top:10px;">
                                <img src="{{ asset('images/products/' . $product->image) }}" 
                                    width="120" 
                                    style="border-radius:8px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="subtitle">Subtitle / Tagline <span class="req">*</span></label>
                    <input type="text" id="subtitle" name="subtitle"
                           value="{{ old('subtitle', $product->subtitle ?? '') }}"
                           placeholder="Deskripsi singkat satu baris yang muncul di hero halaman produk"
                           required>
                    @error('subtitle')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

        <!-- DESKRIPSI PRODUK -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">2</span> Deskripsi Produk</h3>
            </div>
            <div class="admin-card__body">

                <div class="form-group">
                    <label for="intro">Paragraf Intro <span class="req">*</span></label>
                    <textarea id="intro" name="intro" rows="3" required
                              placeholder="Paragraf pembuka yang mendeskripsikan produk secara umum...">{{ old('intro', $product->intro ?? '') }}</textarea>
                    @error('intro')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="pengertian">Pengertian <span class="req">*</span></label>
                    <textarea id="pengertian" name="pengertian" rows="4" required
                              placeholder="Penjelasan teknis mendalam tentang apa produk ini dan bagaimana cara kerjanya...">{{ old('pengertian', $product->pengertian ?? '') }}</textarea>
                    @error('pengertian')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="kesimpulan">Kesimpulan <span class="req">*</span></label>
                    <textarea id="kesimpulan" name="kesimpulan" rows="3" required
                              placeholder="Paragraf penutup yang merangkum manfaat dan pentingnya produk...">{{ old('kesimpulan', $product->kesimpulan ?? '') }}</textarea>
                    @error('kesimpulan')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

        <!-- FUNGSI -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">3</span> Fungsi dalam Sistem Struktur</h3>
                <span class="card-header-hint">Min. 2 fungsi, maks. 6</span>
            </div>
            <div class="admin-card__body">
                <div id="fungsiList">
                    @php $fungsiItems = old('fungsi', $product->fungsi ?? [['judul'=>'','isi'=>''],['judul'=>'','isi'=>'']]) @endphp
                    @foreach($fungsiItems as $fi => $f)
                    <div class="repeater-item" data-index="{{ $fi }}">
                        <div class="repeater-item__header">
                            <span class="repeater-item__num">{{ $fi + 1 }}</span>
                            <div class="repeater-item__fields">
                                <input type="text" name="fungsi[{{ $fi }}][judul]"
                                       value="{{ $f['judul'] ?? '' }}"
                                       placeholder="Judul fungsi (cth: Menahan gaya tarik dan geser)">
                                <textarea name="fungsi[{{ $fi }}][isi]" rows="2"
                                          placeholder="Penjelasan fungsi tersebut...">{{ $f['isi'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addFungsi">+ Tambah Fungsi</button>
                @error('fungsi')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- JENIS -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">4</span> Jenis-Jenis Produk</h3>
                <span class="card-header-hint">Min. 2 jenis, maks. 8</span>
            </div>
            <div class="admin-card__body">
                <div id="jenisList">
                    @php $jenisItems = old('jenis', $product->jenis ?? [['nama'=>'','deskripsi'=>''],['nama'=>'','deskripsi'=>'']]) @endphp
                    @foreach($jenisItems as $ji => $j)
                    <div class="repeater-item" data-index="{{ $ji }}">
                        <div class="repeater-item__header">
                            <span class="repeater-item__num">{{ $ji + 1 }}</span>
                            <div class="repeater-item__fields">
                                <input type="text" name="jenis[{{ $ji }}][nama]"
                                       value="{{ $j['nama'] ?? '' }}"
                                       placeholder="Nama jenis (cth: H-Beam Standar (HW))">
                                <textarea name="jenis[{{ $ji }}][deskripsi]" rows="2"
                                          placeholder="Deskripsi singkat jenis ini...">{{ $j['deskripsi'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addJenis">+ Tambah Jenis</button>
            </div>
        </div>

        <!-- KEUNGGULAN -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">5</span> Keunggulan Produk</h3>
                <span class="card-header-hint">Min. 3 poin, maks. 10</span>
            </div>
            <div class="admin-card__body">
                <div id="keunggulanList">
                    @php $keunggulanItems = old('keunggulan', $product->keunggulan ?? ['','','']) @endphp
                    @foreach($keunggulanItems as $ki => $k)
                    <div class="repeater-item repeater-item--inline" data-index="{{ $ki }}">
                        <span class="repeater-item__check">✓</span>
                        <input type="text" name="keunggulan[]"
                               value="{{ $k }}"
                               placeholder="Poin keunggulan (cth: Kekuatan tarik tinggi sesuai SNI)">
                        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addKeunggulan">+ Tambah Poin</button>
            </div>
        </div>

        <!-- TABEL UKURAN -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">6</span> Tabel Ukuran Standar</h3>
            </div>
            <div class="admin-card__body">

                <div class="form-group">
                    <label for="ukuran_intro">Kalimat Pengantar Tabel</label>
                    <input type="text" id="ukuran_intro" name="ukuran_intro"
                           value="{{ old('ukuran_intro', $product->ukuran_intro ?? '') }}"
                           placeholder="cth: Besi beton tersedia dalam berbagai diameter sesuai kebutuhan struktur.">
                </div>

                <div class="form-group">
                    <label>Header Kolom Tabel <span class="req">*</span></label>
                    <div id="tabelHeaderList">
                        @php $headerItems = old('tabel_header', $product->tabel_header ?? ['','','','','']) @endphp
                        @foreach($headerItems as $hi => $h)
                        <div class="repeater-item repeater-item--inline repeater-item--header">
                            <span class="repeater-item__col-icon">⊞</span>
                            <input type="text" name="tabel_header[]"
                                   value="{{ $h }}"
                                   placeholder="Nama kolom (cth: Diameter, Grade, Panjang)">
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-add-repeater" id="addTabelHeader">+ Tambah Kolom</button>
                </div>

                <div class="form-group">
                    <label>Baris Data Tabel <span class="req">*</span></label>
                    <span class="field-hint">Setiap baris dipisahkan. Jumlah nilai per baris harus sama dengan jumlah kolom header.</span>
                    <div id="tabelDataList">
                        @php $dataItems = old('tabel_data', $product->tabel_data ?? [['','','','',''],['','','','','']]) @endphp
                        @foreach($dataItems as $di => $row)
                        <div class="repeater-item repeater-item--row" data-index="{{ $di }}">
                            <span class="repeater-item__row-num">{{ $di + 1 }}</span>
                            <div class="repeater-item__row-cells" id="rowCells_{{ $di }}">
                                @foreach($row as $ci => $cell)
                                <input type="text" name="tabel_data[{{ $di }}][]"
                                       value="{{ $cell }}"
                                       placeholder="Nilai kolom {{ $ci + 1 }}">
                                @endforeach
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus baris">✕</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-add-repeater" id="addTabelRow">+ Tambah Baris</button>
                </div>

            </div>
        </div>

    </div>{{-- /.form-main --}}

</form>{{-- ← form utama selesai di sini, sidebar berikutnya BUKAN bagian dari form ini --}}

{{-- SIDEBAR: sepenuhnya di luar #productForm --}}
<div class="form-sidebar">

        <!-- PUBLISH -->
        <div class="admin-card admin-card--sticky">
            <div class="admin-card__header">
                <h3>Publikasi</h3>
            </div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label>Status Tampil</label>
                    <div class="toggle-group">
                        <label class="toggle-switch">
                            {{-- form="productForm" wajib karena kedua input ini berada di LUAR tag <form> --}}
                            <input type="hidden" name="is_active" value="0" form="productForm">
                            <input type="checkbox" name="is_active" value="1" form="productForm"
                                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="toggleLabel">
                            {{ old('is_active', $product->is_active ?? true) ? 'Aktif – ditampilkan' : 'Nonaktif – disembunyikan' }}
                        </span>
                    </div>
                </div>

                <div class="form-actions">
                    {{-- BUG FIX: Sebelumnya isi tombol adalah URL route, bukan label teks --}}
                    {{-- form="productForm" menghubungkan tombol ini ke form utama meski berada di luar tag <form> --}}
                    <button type="submit" form="productForm" name="action" value="save" class="btn btn--primary btn--full">
                        💾 {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                    </button>
                    @if(!isset($product))
                    <button type="submit" form="productForm" name="action" value="save_and_new" class="btn btn--ghost btn--full">
                        + Simpan & Tambah Lagi
                    </button>
                    @endif
                    <a href="{{ route('admin.products.index') }}" class="btn btn--ghost btn--full">
                        Batal
                    </a>
                </div>
            </div>
        </div>

        <!-- DANGER ZONE: di luar <form> utama agar tidak ikut submit -->
        @if(isset($product))
        <div class="admin-card" style="border:1px solid #ef4444;">
            <div class="admin-card__header" style="background:rgba(239,68,68,.08);">
                <h3 style="color:#ef4444;">⚠ Zona Berbahaya</h3>
            </div>
            <div class="admin-card__body">
                <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:1rem;">
                    Tindakan ini permanen dan tidak dapat dibatalkan.
                </p>
                {{-- BUG FIX: Form hapus dipindah ke LUAR form utama (#productForm)
                     agar tidak bisa ikut ter-submit saat klik Simpan --}}
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus produk \'{{ addslashes($product->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-full">🗑 Hapus Produk Ini</button>
                </form>
            </div>
        </div>
        @endif

        <!-- SPESIFIKASI SINGKAT -->
        <div class="admin-card">
            <div class="admin-card__header">
                <h3>Spesifikasi Singkat</h3>
                <span class="card-header-hint">Tampil di sidebar halaman produk</span>
            </div>
            <div class="admin-card__body">
                <div id="spesifikasiList">
                    @php
                    $specItems = old('spesifikasi', isset($product) ? collect($product->spesifikasi)->map(fn($v,$k)=>['key'=>$k,'value'=>$v])->values()->toArray() : [['key'=>'','value'=>''],['key'=>'','value'=>'']])
                    @endphp
                    @foreach($specItems as $si => $spec)
                    <div class="repeater-item repeater-item--spec">
                        <input type="text" name="spesifikasi_key[]" form="productForm"
                               value="{{ $spec['key'] ?? '' }}"
                               placeholder="Label (cth: Standar)">
                        <input type="text" name="spesifikasi_val[]" form="productForm"
                               value="{{ $spec['value'] ?? '' }}"
                               placeholder="Nilai (cth: SNI 2052:2017)">
                        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addSpesifikasi">+ Tambah Baris</button>
            </div>
        </div>

        <!-- PREVIEW INFO -->
        <div class="admin-card admin-card--info">
            <div class="admin-card__header"><h3>ℹ Petunjuk</h3></div>
            <div class="admin-card__body">
                <ul class="info-tips">
                    <li>Slug dibuat otomatis dari nama produk. Bisa diedit manual.</li>
                    <li>Kolom header tabel harus sesuai jumlahnya dengan kolom nilai di tiap baris data.</li>
                    <li>Minimal 2 item untuk Fungsi, Jenis, dan Keunggulan.</li>
                    <li>Produk nonaktif tidak muncul di halaman publik.</li>
                    <li>Semua field bertanda <span class="req">*</span> wajib diisi.</li>
                </ul>
            </div>
        </div>

</div>{{-- /.form-sidebar --}}
</div>{{-- /.grid-wrapper --}}

@endsection

@push('scripts')
<script>
// ── Auto-generate slug dari name ──────────────────────
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
let slugManuallyEdited = {{ isset($product) ? 'true' : 'false' }};

slugInput.addEventListener('input', () => { slugManuallyEdited = true; });
nameInput.addEventListener('input', () => {
    if (!slugManuallyEdited) {
        slugInput.value = nameInput.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
});

// ── Toggle label update ───────────────────────────────
const toggleCb = document.querySelector('input[name="is_active"][type="checkbox"]');
const toggleLabel = document.getElementById('toggleLabel');
if (toggleCb) {
    toggleCb.addEventListener('change', () => {
        toggleLabel.textContent = toggleCb.checked ? 'Aktif – ditampilkan' : 'Nonaktif – disembunyikan';
    });
}

// ── Remove repeater item ──────────────────────────────
function removeRepeaterItem(btn) {
    btn.closest('.repeater-item').remove();
    renumberAll();
}

function renumberAll() {
    document.querySelectorAll('#fungsiList .repeater-item, #jenisList .repeater-item').forEach((item, i) => {
        const num = item.querySelector('.repeater-item__num');
        if (num) num.textContent = i + 1;
    });
    document.querySelectorAll('#tabelDataList .repeater-item').forEach((item, i) => {
        const num = item.querySelector('.repeater-item__row-num');
        if (num) num.textContent = i + 1;
    });
}

// ── Add Fungsi ────────────────────────────────────────
document.getElementById('addFungsi').addEventListener('click', () => {
    const list  = document.getElementById('fungsiList');
    const count = list.querySelectorAll('.repeater-item').length;
    const div   = document.createElement('div');
    div.className = 'repeater-item';
    div.dataset.index = count;
    div.innerHTML = `
        <div class="repeater-item__header">
            <span class="repeater-item__num">${count + 1}</span>
            <div class="repeater-item__fields">
                <input type="text" name="fungsi[${count}][judul]" placeholder="Judul fungsi">
                <textarea name="fungsi[${count}][isi]" rows="2" placeholder="Penjelasan fungsi..."></textarea>
            </div>
            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
        </div>`;
    list.appendChild(div);
});

// ── Add Jenis ─────────────────────────────────────────
document.getElementById('addJenis').addEventListener('click', () => {
    const list  = document.getElementById('jenisList');
    const count = list.querySelectorAll('.repeater-item').length;
    const div   = document.createElement('div');
    div.className = 'repeater-item';
    div.dataset.index = count;
    div.innerHTML = `
        <div class="repeater-item__header">
            <span class="repeater-item__num">${count + 1}</span>
            <div class="repeater-item__fields">
                <input type="text" name="jenis[${count}][nama]" placeholder="Nama jenis">
                <textarea name="jenis[${count}][deskripsi]" rows="2" placeholder="Deskripsi singkat..."></textarea>
            </div>
            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>
        </div>`;
    list.appendChild(div);
});

// ── Add Keunggulan ────────────────────────────────────
document.getElementById('addKeunggulan').addEventListener('click', () => {
    const list = document.getElementById('keunggulanList');
    const div  = document.createElement('div');
    div.className = 'repeater-item repeater-item--inline';
    div.innerHTML = `
        <span class="repeater-item__check">✓</span>
        <input type="text" name="keunggulan[]" placeholder="Poin keunggulan">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>`;
    list.appendChild(div);
});

// ── Add Tabel Header ──────────────────────────────────
document.getElementById('addTabelHeader').addEventListener('click', () => {
    const list = document.getElementById('tabelHeaderList');
    const div  = document.createElement('div');
    div.className = 'repeater-item repeater-item--inline repeater-item--header';
    div.innerHTML = `
        <span class="repeater-item__col-icon">⊞</span>
        <input type="text" name="tabel_header[]" placeholder="Nama kolom">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>`;
    list.appendChild(div);
});

// ── Add Tabel Row ─────────────────────────────────────
document.getElementById('addTabelRow').addEventListener('click', () => {
    const list    = document.getElementById('tabelDataList');
    const count   = list.querySelectorAll('.repeater-item').length;
    const headers = document.querySelectorAll('#tabelHeaderList input[name="tabel_header[]"]');
    const colCount = Math.max(headers.length, 1);
    let cells = '';
    for (let i = 0; i < colCount; i++) {
        cells += `<input type="text" name="tabel_data[${count}][]" placeholder="Nilai kolom ${i + 1}">`;
    }
    const div = document.createElement('div');
    div.className = 'repeater-item repeater-item--row';
    div.dataset.index = count;
    div.innerHTML = `
        <span class="repeater-item__row-num">${count + 1}</span>
        <div class="repeater-item__row-cells">${cells}</div>
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus baris">✕</button>`;
    list.appendChild(div);
});

// ── Add Spesifikasi ───────────────────────────────────
document.getElementById('addSpesifikasi').addEventListener('click', () => {
    const list = document.getElementById('spesifikasiList');
    const div  = document.createElement('div');
    div.className = 'repeater-item repeater-item--spec';
    div.innerHTML = `
        <input type="text" name="spesifikasi_key[]" form="productForm" placeholder="Label (cth: Standar)">
        <input type="text" name="spesifikasi_val[]" form="productForm" placeholder="Nilai (cth: SNI 2052:2017)">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)" title="Hapus">✕</button>`;
    list.appendChild(div);
});

// ── Auto-resize textarea ──────────────────────────────
document.querySelectorAll('textarea').forEach(ta => {
    ta.style.resize = 'vertical';
});

// ── Confirm leave if dirty ────────────────────────────
// BUG FIX: Tombol "Simpan" berada di LUAR <form> (form="productForm").
// Di Chrome/Edge, klik tombol eksternal memicu `beforeunload` SEBELUM
// event `submit` form terpanggil — akibatnya formDirty masih true dan
// browser menampilkan dialog "tinggalkan halaman?" yang memblokir submit.
//
// Solusi: tambahkan flag `isSubmitting` yang di-set langsung saat tombol
// diklik, sehingga `beforeunload` tahu untuk tidak memblokir navigasi ini.
let formDirty    = false;
let isSubmitting = false;

document.getElementById('productForm').addEventListener('input', () => formDirty = true);

// Set flag saat TOMBOL diklik (terjadi sebelum beforeunload)
document.querySelectorAll('[form="productForm"][type="submit"]').forEach(btn => {
    btn.addEventListener('click', () => { isSubmitting = true; });
});

document.getElementById('productForm').addEventListener('submit', () => {
    isSubmitting = true;
    formDirty    = false;
});

window.addEventListener('beforeunload', e => {
    if (formDirty && !isSubmitting) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endpush