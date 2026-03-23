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

{{-- enctype WAJIB multipart untuk upload file --}}
<form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
      method="POST"
      enctype="multipart/form-data"
      id="productForm"
      novalidate>
    @csrf
    @if(isset($product)) @method('PUT') @endif

<div class="form-layout">

    <!-- ═══ LEFT: Main Fields ═══════════════════════════════ -->
    <div class="form-main">

        {{-- ─── 1. IDENTITAS ─────────────────────────────── --}}
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
                            <span class="label-hint">— auto-generate dari nama</span>
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
                            @foreach(['Baja Tulangan','Baja Profil','Plat & Sheet','Pipa','Hollow','Baja Ringan','Wiremesh','Pagar','Aksesori','Kawat','Bondek'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Subtitle / Tagline <span class="req">*</span></label>
                        <input type="text" id="subtitle" name="subtitle"
                               value="{{ old('subtitle', $product->subtitle ?? '') }}"
                               placeholder="Deskripsi singkat satu baris"
                               required>
                        @error('subtitle')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- ─── 2. GAMBAR PRODUK ──────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">2</span> Gambar Produk</h3>
                <span class="card-header-hint">JPG / PNG / WebP — Maks. 2 MB</span>
            </div>
            <div class="admin-card__body">

                {{-- Preview gambar saat ini (mode edit) --}}
                @if(isset($product) && $product->hasUploadedImage())
                <div class="img-current-wrap" id="imgCurrentWrap">
                    <div class="img-current-label">Gambar saat ini:</div>
                    <div class="img-current-preview">
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             id="imgCurrentPreview"
                             class="img-preview-thumb">
                        <div class="img-current-info">
                            <span class="img-filename">{{ $product->image }}</span>
                            <label class="img-remove-check">
                                <input type="checkbox" name="remove_image" value="1"
                                       id="removeImage"
                                       {{ old('remove_image') ? 'checked' : '' }}>
                                <span>Hapus gambar ini</span>
                            </label>
                        </div>
                    </div>
                    <p class="field-hint">Upload gambar baru akan otomatis menggantikan gambar di atas.</p>
                </div>
                @elseif(isset($product))
                {{-- Produk ada tapi belum upload gambar — tampilkan SVG fallback --}}
                <div class="img-fallback-notice">
                    <img src="{{ asset('images/products/' . $product->slug . '.svg') }}"
                         alt="{{ $product->name }}"
                         class="img-preview-thumb img-preview-thumb--svg">
                    <p>Menggunakan ilustrasi SVG default. Upload gambar asli produk untuk tampilan lebih baik.</p>
                </div>
                @endif

                {{-- Drop zone upload --}}
                <div class="img-upload-zone" id="imgUploadZone">
                    <input type="file"
                           id="imageInput"
                           name="image"
                           accept="image/jpeg,image/png,image/webp"
                           class="img-file-input">
                    <div class="img-upload-inner" id="imgUploadInner">
                        <div class="img-upload-icon">📷</div>
                        <p class="img-upload-text">
                            <strong>Klik untuk pilih gambar</strong> atau drag & drop ke sini
                        </p>
                        <p class="img-upload-hint">JPG, PNG, WebP — Maks. 2 MB — Rekomendasi 800×600 px</p>
                    </div>
                    {{-- Preview setelah pilih file baru --}}
                    <div class="img-new-preview" id="imgNewPreview" style="display:none;">
                        <img src="" alt="Preview" id="imgNewPreviewImg" class="img-preview-thumb">
                        <div class="img-new-preview-info">
                            <span id="imgNewFilename" class="img-filename"></span>
                            <span id="imgNewSize" class="img-filesize"></span>
                            <button type="button" id="imgClearBtn" class="img-clear-btn">✕ Batal</button>
                        </div>
                    </div>
                </div>
                @error('image')
                <span class="field-error">{{ $message }}</span>
                @enderror

            </div>
        </div>

        {{-- ─── 3. DESKRIPSI ──────────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">3</span> Deskripsi Produk</h3>
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
                              placeholder="Penjelasan teknis mendalam tentang produk ini...">{{ old('pengertian', $product->pengertian ?? '') }}</textarea>
                    @error('pengertian')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="kesimpulan">Kesimpulan <span class="req">*</span></label>
                    <textarea id="kesimpulan" name="kesimpulan" rows="3" required
                              placeholder="Paragraf penutup yang merangkum manfaat produk...">{{ old('kesimpulan', $product->kesimpulan ?? '') }}</textarea>
                    @error('kesimpulan')<span class="field-error">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>

        {{-- ─── 4. FUNGSI ─────────────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">4</span> Fungsi dalam Sistem Struktur</h3>
                <span class="card-header-hint">Min. 2, Maks. 6</span>
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
                                       placeholder="Judul fungsi">
                                <textarea name="fungsi[{{ $fi }}][isi]" rows="2"
                                          placeholder="Penjelasan fungsi...">{{ $f['isi'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addFungsi">+ Tambah Fungsi</button>
                @error('fungsi')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- ─── 5. JENIS ──────────────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">5</span> Jenis-Jenis Produk</h3>
                <span class="card-header-hint">Min. 2, Maks. 8</span>
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
                                       placeholder="Nama jenis">
                                <textarea name="jenis[{{ $ji }}][deskripsi]" rows="2"
                                          placeholder="Deskripsi singkat...">{{ $j['deskripsi'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addJenis">+ Tambah Jenis</button>
            </div>
        </div>

        {{-- ─── 6. KEUNGGULAN ─────────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">6</span> Keunggulan Produk</h3>
                <span class="card-header-hint">Min. 3, Maks. 10</span>
            </div>
            <div class="admin-card__body">
                <div id="keunggulanList">
                    @php $keunggulanItems = old('keunggulan', $product->keunggulan ?? ['','','']) @endphp
                    @foreach($keunggulanItems as $ki => $k)
                    <div class="repeater-item repeater-item--inline">
                        <span class="repeater-item__check">✓</span>
                        <input type="text" name="keunggulan[]"
                               value="{{ $k }}"
                               placeholder="Poin keunggulan">
                        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addKeunggulan">+ Tambah Poin</button>
            </div>
        </div>

        {{-- ─── 7. TABEL UKURAN ───────────────────────────── --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><span class="card-step">7</span> Tabel Ukuran Standar</h3>
            </div>
            <div class="admin-card__body">

                <div class="form-group">
                    <label for="ukuran_intro">Kalimat Pengantar Tabel</label>
                    <input type="text" id="ukuran_intro" name="ukuran_intro"
                           value="{{ old('ukuran_intro', $product->ukuran_intro ?? '') }}"
                           placeholder="cth: Besi beton tersedia dalam berbagai diameter sesuai kebutuhan.">
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
                                   placeholder="Nama kolom">
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-add-repeater" id="addTabelHeader">+ Tambah Kolom</button>
                </div>

                <div class="form-group">
                    <label>Baris Data Tabel <span class="req">*</span></label>
                    <span class="field-hint">Jumlah nilai per baris harus sama dengan jumlah kolom header.</span>
                    <div id="tabelDataList">
                        @php $dataItems = old('tabel_data', $product->tabel_data ?? [['','','','',''],['','','','','']]) @endphp
                        @foreach($dataItems as $di => $row)
                        <div class="repeater-item repeater-item--row" data-index="{{ $di }}">
                            <span class="repeater-item__row-num">{{ $di + 1 }}</span>
                            <div class="repeater-item__row-cells">
                                @foreach($row as $ci => $cell)
                                <input type="text" name="tabel_data[{{ $di }}][]"
                                       value="{{ $cell }}"
                                       placeholder="Nilai {{ $ci + 1 }}">
                                @endforeach
                            </div>
                            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-add-repeater" id="addTabelRow">+ Tambah Baris</button>
                </div>

            </div>
        </div>

    </div><!-- /.form-main -->

    <!-- ═══ RIGHT: Sidebar ══════════════════════════════════ -->
    <div class="form-sidebar">

        {{-- Publikasi --}}
        <div class="admin-card admin-card--sticky">
            <div class="admin-card__header">
                <h3>Publikasi</h3>
            </div>
            <div class="admin-card__body">
                <div class="form-group">
                    <label>Status Tampil</label>
                    <div class="toggle-group">
                        <label class="toggle-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="toggleLabel">
                            {{ old('is_active', $product->is_active ?? true) ? 'Aktif – ditampilkan' : 'Nonaktif – disembunyikan' }}
                        </span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="action" value="save" class="btn btn--primary btn--full">
                        💾 {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                    </button>
                    @if(!isset($product))
                    <button type="submit" name="action" value="save_and_new" class="btn btn--ghost btn--full">
                        + Simpan & Tambah Lagi
                    </button>
                    @endif
                    <a href="{{ route('admin.products.index') }}" class="btn btn--ghost btn--full">Batal</a>
                </div>

                @if(isset($product))
                <div class="danger-zone">
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus produk ini? Gambar juga akan dihapus.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-full">🗑 Hapus Produk Ini</button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        {{-- Spesifikasi Singkat --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3>Spesifikasi Singkat</h3>
                <span class="card-header-hint">Tampil di sidebar halaman produk</span>
            </div>
            <div class="admin-card__body">
                <div id="spesifikasiList">
                    @php
                    $specItems = old('spesifikasi',
                        isset($product)
                            ? collect($product->spesifikasi)->map(fn($v,$k)=>['key'=>$k,'value'=>$v])->values()->toArray()
                            : [['key'=>'','value'=>''],['key'=>'','value'=>'']]
                    )
                    @endphp
                    @foreach($specItems as $si => $spec)
                    <div class="repeater-item repeater-item--spec">
                        <input type="text" name="spesifikasi_key[]"
                               value="{{ $spec['key'] ?? '' }}"
                               placeholder="Label (cth: Standar)">
                        <input type="text" name="spesifikasi_val[]"
                               value="{{ $spec['value'] ?? '' }}"
                               placeholder="Nilai (cth: SNI)">
                        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-repeater" id="addSpesifikasi">+ Tambah Baris</button>
            </div>
        </div>

        {{-- Petunjuk --}}
        <div class="admin-card admin-card--info">
            <div class="admin-card__header"><h3>ℹ Petunjuk</h3></div>
            <div class="admin-card__body">
                <ul class="info-tips">
                    <li>Slug dibuat otomatis dari nama produk.</li>
                    <li>Gambar: JPG/PNG/WebP, maks. 2 MB, rekomendasi 800×600 px.</li>
                    <li>Jika tidak upload gambar, sistem pakai ilustrasi SVG default.</li>
                    <li>Jumlah kolom header tabel harus sama dengan kolom di setiap baris data.</li>
                    <li>Produk nonaktif tidak muncul di halaman publik.</li>
                    <li>Field bertanda <span class="req">*</span> wajib diisi.</li>
                </ul>
            </div>
        </div>

    </div><!-- /.form-sidebar -->

</div><!-- /.form-layout -->
</form>

@endsection

@push('scripts')
<script>
// ── Slug auto-generate ────────────────────────────────────────
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
let slugEdited  = {{ isset($product) ? 'true' : 'false' }};

slugInput.addEventListener('input', () => { slugEdited = true; });
nameInput.addEventListener('input', () => {
    if (!slugEdited) {
        slugInput.value = nameInput.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }
});

// ── Toggle label ──────────────────────────────────────────────
const toggleCb    = document.querySelector('input[name="is_active"][type="checkbox"]');
const toggleLabel = document.getElementById('toggleLabel');
if (toggleCb) {
    toggleCb.addEventListener('change', () => {
        toggleLabel.textContent = toggleCb.checked ? 'Aktif – ditampilkan' : 'Nonaktif – disembunyikan';
    });
}

// ── Image Upload Preview ──────────────────────────────────────
const imageInput    = document.getElementById('imageInput');
const imgUploadZone = document.getElementById('imgUploadZone');
const imgUploadInner= document.getElementById('imgUploadInner');
const imgNewPreview = document.getElementById('imgNewPreview');
const imgNewImg     = document.getElementById('imgNewPreviewImg');
const imgNewFilename= document.getElementById('imgNewFilename');
const imgNewSize    = document.getElementById('imgNewSize');
const imgClearBtn   = document.getElementById('imgClearBtn');
const removeCheck   = document.getElementById('removeImage');

// Click zone -> trigger file input
imgUploadZone.addEventListener('click', (e) => {
    if (e.target !== imgClearBtn && !imgClearBtn?.contains(e.target)) {
        imageInput.click();
    }
});

// Drag & drop
imgUploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    imgUploadZone.classList.add('drag-over');
});
imgUploadZone.addEventListener('dragleave', () => {
    imgUploadZone.classList.remove('drag-over');
});
imgUploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    imgUploadZone.classList.remove('drag-over');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        setImageFile(files[0]);
    }
});

// File selected via input
imageInput.addEventListener('change', () => {
    if (imageInput.files.length > 0) {
        setImageFile(imageInput.files[0]);
    }
});

function setImageFile(file) {
    // Validate type
    const allowed = ['image/jpeg','image/png','image/webp'];
    if (!allowed.includes(file.type)) {
        alert('Format gambar harus JPG, PNG, atau WebP.');
        clearImage();
        return;
    }
    // Validate size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2 MB. File Anda: ' + (file.size/1024/1024).toFixed(2) + ' MB.');
        clearImage();
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = (e) => {
        imgNewImg.src     = e.target.result;
        imgNewFilename.textContent = file.name;
        imgNewSize.textContent     = (file.size / 1024).toFixed(1) + ' KB';
        imgUploadInner.style.display = 'none';
        imgNewPreview.style.display  = 'flex';

        // Uncheck "hapus gambar" jika admin pilih gambar baru
        if (removeCheck) removeCheck.checked = false;
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    imageInput.value  = '';
    imgNewImg.src     = '';
    imgNewFilename.textContent = '';
    imgNewSize.textContent     = '';
    imgUploadInner.style.display = '';
    imgNewPreview.style.display  = 'none';
}

if (imgClearBtn) {
    imgClearBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        clearImage();
    });
}

// "Hapus gambar" checkbox disables upload zone visually
if (removeCheck) {
    removeCheck.addEventListener('change', () => {
        if (removeCheck.checked) {
            clearImage();
            imgUploadZone.style.opacity = '0.4';
            imgUploadZone.style.pointerEvents = 'none';
        } else {
            imgUploadZone.style.opacity = '';
            imgUploadZone.style.pointerEvents = '';
        }
    });
}

// ── Remove repeater item ──────────────────────────────────────
function removeRepeaterItem(btn) {
    btn.closest('.repeater-item').remove();
    renumberAll();
}
function renumberAll() {
    ['#fungsiList','#jenisList'].forEach(sel => {
        document.querySelectorAll(sel + ' .repeater-item').forEach((el, i) => {
            const n = el.querySelector('.repeater-item__num');
            if (n) n.textContent = i + 1;
        });
    });
    document.querySelectorAll('#tabelDataList .repeater-item').forEach((el, i) => {
        const n = el.querySelector('.repeater-item__row-num');
        if (n) n.textContent = i + 1;
    });
}

// ── Add Fungsi ────────────────────────────────────────────────
document.getElementById('addFungsi').addEventListener('click', () => {
    const list  = document.getElementById('fungsiList');
    const count = list.querySelectorAll('.repeater-item').length;
    const div   = document.createElement('div');
    div.className = 'repeater-item';
    div.innerHTML = `
        <div class="repeater-item__header">
            <span class="repeater-item__num">${count + 1}</span>
            <div class="repeater-item__fields">
                <input type="text" name="fungsi[${count}][judul]" placeholder="Judul fungsi">
                <textarea name="fungsi[${count}][isi]" rows="2" placeholder="Penjelasan fungsi..."></textarea>
            </div>
            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
        </div>`;
    list.appendChild(div);
});

// ── Add Jenis ─────────────────────────────────────────────────
document.getElementById('addJenis').addEventListener('click', () => {
    const list  = document.getElementById('jenisList');
    const count = list.querySelectorAll('.repeater-item').length;
    const div   = document.createElement('div');
    div.className = 'repeater-item';
    div.innerHTML = `
        <div class="repeater-item__header">
            <span class="repeater-item__num">${count + 1}</span>
            <div class="repeater-item__fields">
                <input type="text" name="jenis[${count}][nama]" placeholder="Nama jenis">
                <textarea name="jenis[${count}][deskripsi]" rows="2" placeholder="Deskripsi singkat..."></textarea>
            </div>
            <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>
        </div>`;
    list.appendChild(div);
});

// ── Add Keunggulan ────────────────────────────────────────────
document.getElementById('addKeunggulan').addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'repeater-item repeater-item--inline';
    div.innerHTML = `
        <span class="repeater-item__check">✓</span>
        <input type="text" name="keunggulan[]" placeholder="Poin keunggulan">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>`;
    document.getElementById('keunggulanList').appendChild(div);
});

// ── Add Tabel Header ──────────────────────────────────────────
document.getElementById('addTabelHeader').addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'repeater-item repeater-item--inline repeater-item--header';
    div.innerHTML = `
        <span class="repeater-item__col-icon">⊞</span>
        <input type="text" name="tabel_header[]" placeholder="Nama kolom">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>`;
    document.getElementById('tabelHeaderList').appendChild(div);
});

// ── Add Tabel Row ─────────────────────────────────────────────
document.getElementById('addTabelRow').addEventListener('click', () => {
    const list    = document.getElementById('tabelDataList');
    const count   = list.querySelectorAll('.repeater-item').length;
    const headers = document.querySelectorAll('#tabelHeaderList input[name="tabel_header[]"]');
    const colCount = Math.max(headers.length, 1);
    let cells = '';
    for (let i = 0; i < colCount; i++) {
        cells += `<input type="text" name="tabel_data[${count}][]" placeholder="Nilai ${i + 1}">`;
    }
    const div = document.createElement('div');
    div.className = 'repeater-item repeater-item--row';
    div.innerHTML = `
        <span class="repeater-item__row-num">${count + 1}</span>
        <div class="repeater-item__row-cells">${cells}</div>
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>`;
    list.appendChild(div);
});

// ── Add Spesifikasi ───────────────────────────────────────────
document.getElementById('addSpesifikasi').addEventListener('click', () => {
    const div = document.createElement('div');
    div.className = 'repeater-item repeater-item--spec';
    div.innerHTML = `
        <input type="text" name="spesifikasi_key[]" placeholder="Label">
        <input type="text" name="spesifikasi_val[]" placeholder="Nilai">
        <button type="button" class="repeater-remove" onclick="removeRepeaterItem(this)">✕</button>`;
    document.getElementById('spesifikasiList').appendChild(div);
});

// ── Dirty form warning ────────────────────────────────────────
let formDirty = false;
document.getElementById('productForm').addEventListener('input', () => formDirty = true);
document.getElementById('productForm').addEventListener('change', () => formDirty = true);
window.addEventListener('beforeunload', e => {
    if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});
document.getElementById('productForm').addEventListener('submit', () => { formDirty = false; });
</script>
@endpush