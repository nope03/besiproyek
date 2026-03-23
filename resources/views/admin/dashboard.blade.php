@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}!</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn--primary">
        + Tambah Produk
    </a>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--blue">◈</div>
        <div class="stat-card__body">
            <div class="stat-card__number">{{ $totalProducts }}</div>
            <div class="stat-card__label">Total Produk</div>
        </div>
        <div class="stat-card__trend trend--up">↑ Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--green">✓</div>
        <div class="stat-card__body">
            <div class="stat-card__number">{{ $activeProducts }}</div>
            <div class="stat-card__label">Produk Aktif</div>
        </div>
        <div class="stat-card__trend trend--up">Ditampilkan</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--orange">⊞</div>
        <div class="stat-card__body">
            <div class="stat-card__number">{{ $categories }}</div>
            <div class="stat-card__label">Kategori</div>
        </div>
        <div class="stat-card__trend">Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-card__icon stat-card__icon--red">◷</div>
        <div class="stat-card__body">
            <div class="stat-card__number">{{ $latestProduct ?? '—' }}</div>
            <div class="stat-card__label">Terakhir Ditambah</div>
        </div>
        <div class="stat-card__trend">Produk baru</div>
    </div>
</div>

<!-- Recent Products -->
<div class="dashboard-grid">
    <div class="admin-card">
        <div class="admin-card__header">
            <h3>Produk Terbaru</h3>
            <a href="{{ route('admin.products.index') }}" class="card-header-link">Lihat Semua →</a>
        </div>
        <div class="admin-card__body">
            @if($recentProducts->count())
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProducts as $product)
                    <tr>
                        <td>
                            <div class="table-product-name">{{ $product->name }}</div>
                            <div class="table-product-slug">/product/{{ $product->slug }}</div>
                        </td>
                        <td><span class="badge badge--category">{{ $product->category }}</span></td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'badge--active' : 'badge--inactive' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="table-date">{{ $product->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.products.edit', $product->slug) }}" class="table-btn table-btn--edit">Edit</a>
                                <a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="table-btn table-btn--view">Lihat</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-state__icon">◈</div>
                <p>Belum ada produk. <a href="{{ route('admin.products.create') }}">Tambah produk pertama</a>.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card">
        <div class="admin-card__header">
            <h3>Aksi Cepat</h3>
        </div>
        <div class="admin-card__body">
            <div class="quick-actions">
                <a href="{{ route('admin.products.create') }}" class="quick-action">
                    <span class="quick-action__icon">+</span>
                    <div>
                        <strong>Tambah Produk Baru</strong>
                        <span>Tambahkan produk besi/baja ke katalog</span>
                    </div>
                </a>
                <a href="{{ route('admin.products.index') }}" class="quick-action">
                    <span class="quick-action__icon">◈</span>
                    <div>
                        <strong>Kelola Semua Produk</strong>
                        <span>Edit, hapus, atau nonaktifkan produk</span>
                    </div>
                </a>
                <a href="{{ url('/product') }}" target="_blank" class="quick-action">
                    <span class="quick-action__icon">↗</span>
                    <div>
                        <strong>Halaman Produk Publik</strong>
                        <span>Lihat tampilan katalog di website</span>
                    </div>
                </a>
                <a href="{{ url('/') }}" target="_blank" class="quick-action">
                    <span class="quick-action__icon">🌐</span>
                    <div>
                        <strong>Buka Website</strong>
                        <span>Lihat tampilan website secara keseluruhan</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection