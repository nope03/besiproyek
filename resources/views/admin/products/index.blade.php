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
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama produk...">
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
            <tbody>
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

@endsection