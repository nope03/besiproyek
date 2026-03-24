@extends('admin.layouts.app')

@section('title', 'Kelola Produk')
@section('breadcrumb', 'Kelola Produk')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Produk</h1>
        <p class="page-subtitle">{{ $products->total() }} produk terdaftar dalam sistem</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn--primary">+ Tambah Produk</a>
</div>

<!-- Filter & Search Bar -->
<div class="admin-card" style="margin-bottom:1.5rem;">
    <div class="admin-card__body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="filter-form">
            <div class="filter-form__row">
                <div class="filter-form__search">
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="form-control">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
                <div class="filter-form__selects">
                    <select name="category" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categoryList as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <select name="status" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @if(request('search') || request('category') || request('status'))
                    <a href="{{ route('admin.products.index') }}" class="btn-reset">✕ Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="admin-card">
    <div class="admin-card__body p-0">
        @if($products->count())
        <table class="admin-table admin-table--full">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Slug / URL</th>
                    <th style="width:90px">Status</th>
                    <th style="width:110px">Dibuat</th>
                    <th style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($products as $i => $product)
                <tr>
                    <td class="table-num">{{ $products->firstItem() + $i }}</td>
                    <td>
                        <div class="table-product-name">{{ $product->name }}</div>
                        <div class="table-product-subtitle">{{ Str::limit($product->subtitle, 55) }}</div>
                    </td>
                    <td><span class="badge badge--category">{{ $product->category }}</span></td>
                    <td>
                        <a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="table-slug">
                            /product/{{ $product->slug }}
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="toggle-btn {{ $product->is_active ? 'toggle-btn--active' : 'toggle-btn--inactive' }}">
                                {{ $product->is_active ? '● Aktif' : '○ Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="table-date">{{ $product->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="table-actions">
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" style="margin: 0; padding: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="table-btn" 
                                        style="color: {{ $product->is_featured ? '#eab308' : '#9ca3af' }}; padding: 0.35rem; display: flex; align-items: center; justify-content: center;"
                                        title="{{ $product->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="{{ $product->is_featured ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('admin.products.edit', $product->slug) }}" class="table-btn table-btn--edit" title="Edit">✏ Edit</a>
                            <a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="table-btn table-btn--view" title="Lihat">↗</a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="table-btn table-btn--delete" title="Hapus">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-wrap">
            {{ $products->appends(request()->query())->links('admin.partials.pagination') }}
        </div>

        @else
        <div class="empty-state">
            <div class="empty-state__icon">◈</div>
            <h3>Belum Ada Produk</h3>
            <p>
                @if(request('search') || request('category') || request('status'))
                    Tidak ada produk yang cocok dengan filter yang dipilih.
                    <a href="{{ route('admin.products.index') }}">Reset filter</a>
                @else
                    Mulai tambahkan produk pertama Anda.
                @endif
            </p>
            @if(!request('search') && !request('category') && !request('status'))
            <a href="{{ route('admin.products.create') }}" class="btn btn--primary" style="margin-top:1rem;">
                + Tambah Produk Pertama
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen input pencarian dan isi tabel
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        
        // Pastikan kedua elemen ditemukan
        if (searchInput && tableBody) {
            const rows = tableBody.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                // Ubah teks pencarian menjadi huruf kecil semua agar tidak case-sensitive
                const filterText = this.value.toLowerCase();

                // Looping semua baris di dalam tabel
                for (let i = 0; i < rows.length; i++) {
                    // Ambil seluruh teks di dalam satu baris tersebut
                    let rowText = rows[i].textContent || rows[i].innerText;
                    
                    // Jika teks baris cocok dengan kata kunci, tampilkan. Jika tidak, sembunyikan.
                    if (rowText.toLowerCase().indexOf(filterText) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }
    });
</script>

@endsection