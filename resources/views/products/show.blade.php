@extends('layouts.app')

@php
    // Normalisasi: pastikan $product bisa diakses sebagai array
    // baik dari Eloquent model maupun static array (ProductController lama)
    if (is_object($product) && method_exists($product, 'toArray')) {
        $p = $product->toArray();
        // Kembalikan field JSON yang sudah di-cast sebagai array (sudah benar dari model)
        $p['fungsi']       = $product->fungsi       ?? [];
        $p['jenis']        = $product->jenis         ?? [];
        $p['keunggulan']   = $product->keunggulan    ?? [];
        $p['tabel_header'] = $product->tabel_header  ?? [];
        $p['tabel_data']   = $product->tabel_data    ?? [];
        $p['spesifikasi']  = $product->spesifikasi   ?? [];
        $p['title']        = $product->name; // model tidak punya field 'title', fallback ke name
        $imgUrl            = $product->image_url;
        $imgAlt            = $product->name;
    } else {
        $p      = $product;
        $slug   = $p['slug'];
        $imgUrl = asset('images/products/' . $slug . '.svg');
        $imgAlt = $p['name'];
    }
@endphp

@section('title', ($p['title'] ?? $p['name']) . ' – PT Mitra Abadi Metalindo')

@section('content')

<!-- Page Hero -->
<div class="page-hero page-hero--product">
    <div class="hero-bg">
        <div class="hero-grid-lines"></div>
        <div class="hero-glow"></div>
    </div>
    <div class="page-hero__content">
        <div class="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/product') }}">Product</a>
            <span>/</span>
            <span>{{ $p['name'] }}</span>
        </div>
        <span class="section-tag">// {{ strtoupper($p['category']) }}</span>
        <h1 class="page-hero__title">{{ $p['name'] }}</h1>
        <p class="page-hero__sub">{{ $p['subtitle'] }}</p>
    </div>
</div>

<!-- Product Detail -->
<section class="section">
    <div class="container">
        <div class="product-detail-layout">

            <!-- ── Main Content ─────────────────────────────── -->
            <div class="product-detail-main">

                <!-- Intro -->
                <div class="pd-section">
                    <h2 class="pd-title">
                        {{ strtoupper($p['name']) }}: Pengertian, Fungsi, Jenis, dan Ukuran Standar untuk Konstruksi
                    </h2>
                    <p class="pd-lead">{{ $p['intro'] }}</p>
                </div>

                <!-- Pengertian + Gambar -->
                <div class="pd-section">
                    <h3 class="pd-heading">Pengertian</h3>
                    <div class="pd-image-wrap">
                        <img src="{{ $imgUrl }}"
                             alt="Ilustrasi {{ $imgAlt }}"
                             class="pd-product-image"
                             width="800" height="420" loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/products/' . ($p['slug'] ?? 'besi-beton') . '.svg') }}'">
                    </div>
                    <p>{{ $p['pengertian'] }}</p>
                </div>

                <!-- Fungsi -->
                <div class="pd-section">
                    <h3 class="pd-heading">Fungsi dalam Sistem Struktur</h3>
                    <p class="pd-section-intro">{{ $p['name'] }} memiliki beberapa fungsi utama dalam konstruksi:</p>
                    <div class="pd-fungsi-list">
                        @foreach($p['fungsi'] as $i => $f)
                        <div class="pd-fungsi-item">
                            <div class="pd-fungsi-num">{{ $i + 1 }}</div>
                            <div class="pd-fungsi-body">
                                <strong>{{ $f['judul'] }}</strong>
                                <p>{{ $f['isi'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Jenis -->
                <div class="pd-section">
                    <h3 class="pd-heading">Jenis–Jenis {{ $p['name'] }}</h3>
                    <div class="pd-jenis-grid">
                        @foreach($p['jenis'] as $j)
                        <div class="pd-jenis-card">
                            <h5>{{ $j['nama'] }}</h5>
                            <p>{{ $j['deskripsi'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Keunggulan -->
                <div class="pd-section">
                    <h3 class="pd-heading">Keunggulan {{ $p['name'] }}</h3>
                    <ul class="pd-keunggulan-list">
                        @foreach($p['keunggulan'] as $k)
                        <li>
                            <span class="pd-check">✓</span>
                            <span>{{ $k }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <p class="pd-keunggulan-note">
                        Dengan keunggulan tersebut, {{ $p['name'] }} menjadi komponen penting pada proyek konstruksi modern.
                    </p>
                </div>

                <!-- Ukuran Standar -->
                <div class="pd-section">
                    <h3 class="pd-heading">Ukuran Standar</h3>
                    @if(!empty($p['ukuran_intro']))
                    <p>{{ $p['ukuran_intro'] }}</p>
                    @endif
                    <div class="pd-table-wrap">
                        <table class="pd-table">
                            <thead>
                                <tr>
                                    @foreach($p['tabel_header'] as $h)
                                    <th>{{ $h }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($p['tabel_data'] as $row)
                                <tr>
                                    @foreach($row as $cell)
                                    <td>{{ $cell }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Kesimpulan -->
                <div class="pd-section pd-section--conclusion">
                    <h3 class="pd-heading">Kesimpulan</h3>
                    <p>{{ $p['kesimpulan'] }}</p>
                </div>

                <!-- CTA -->
                <div class="pd-cta">
                    <p>Butuh <strong>{{ $p['name'] }}</strong> untuk proyek Anda? Hubungi kami untuk konsultasi dan penawaran harga terbaik.</p>
                    <a href="https://wa.me/6281130556500?text=Halo%20kak,%20saya%20butuh%20informasi%20mengenai%20{{ urlencode($p['name']) }}%20untuk%20proyek%20saya."
                       target="_blank" rel="noopener" class="btn btn--primary">
                        💬 Tanya via WhatsApp
                    </a>
                    <a href="{{ url('/contact-us') }}" class="btn btn--ghost">Contact Us →</a>
                </div>

            </div><!-- /.product-detail-main -->

            <!-- ── Sidebar ────────────────────────────────── -->
            <aside class="product-detail-sidebar">

                <!-- Gambar di sidebar -->
                <div class="sidebar-card sidebar-card--image">
                    <img src="{{ $imgUrl }}"
                         alt="{{ $imgAlt }}"
                         class="sidebar-product-image"
                         width="300" height="200" loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('images/products/' . ($p['slug'] ?? 'besi-beton') . '.svg') }}'">
                </div>

                <!-- Spesifikasi -->
                @if(!empty($p['spesifikasi']))
                <div class="sidebar-card">
                    <h4>Spesifikasi Singkat</h4>
                    <table class="spec-table">
                        @foreach($p['spesifikasi'] as $key => $val)
                        <tr>
                            <th>{{ $key }}</th>
                            <td>{{ $val }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                <!-- WhatsApp CTA -->
                <div class="sidebar-card sidebar-card--cta">
                    <h4>Minta Penawaran</h4>
                    <p>Tim kami siap membantu Anda mendapatkan harga terbaik dan ketersediaan stok.</p>
                    <a href="https://wa.me/6281130556500?text=Halo%20kak,%20saya%20butuh%20{{ urlencode($p['name']) }}."
                       target="_blank" rel="noopener" class="btn btn--primary btn--full">
                        💬 WhatsApp Kami
                    </a>
                    <div class="sidebar-contact">
                        <a href="tel:0313597511">📞 031 359 75 111</a>
                        <a href="tel:0313597599">📞 031 359 75 999</a>
                    </div>
                </div>

                <!-- Navigasi Produk Lain -->
                <div class="sidebar-card">
                    <h4>Produk Lainnya</h4>
                    <ul class="sidebar-nav">
                        @php
                        $navProducts = [
                            ['slug'=>'besi-beton',      'name'=>'Besi Beton'],
                            ['slug'=>'besi-siku',       'name'=>'Besi Siku'],
                            ['slug'=>'besi-virkan',     'name'=>'Besi Virkan (WF)'],
                            ['slug'=>'h-beam',          'name'=>'H-Beam'],
                            ['slug'=>'unp',             'name'=>'Kanal UNP'],
                            ['slug'=>'cnp',             'name'=>'Kanal CNP'],
                            ['slug'=>'plat-hitam',      'name'=>'Plat Hitam'],
                            ['slug'=>'plat-bordes',     'name'=>'Plat Bordes'],
                            ['slug'=>'pipa-galvanis',   'name'=>'Pipa Galvanis'],
                            ['slug'=>'pipa-stainless',  'name'=>'Pipa Stainless Steel'],
                            ['slug'=>'hollow-hitam',    'name'=>'Hollow Hitam'],
                            ['slug'=>'hollow-galvalum', 'name'=>'Hollow Galvalum'],
                            ['slug'=>'atap-galvalum',   'name'=>'Atap Galvalum'],
                            ['slug'=>'canal-galvalum',  'name'=>'Canal Galvalum'],
                            ['slug'=>'wiremesh',        'name'=>'Wiremesh'],
                            ['slug'=>'pagar-brc',       'name'=>'Pagar BRC'],
                            ['slug'=>'bondek',          'name'=>'Bondek'],
                            ['slug'=>'angkur',          'name'=>'Angkur'],
                            ['slug'=>'mur-baut',        'name'=>'Mur dan Baut'],
                            ['slug'=>'kawat',           'name'=>'Kawat Duri & Harmonika'],
                        ];
                        $currentSlug = $p['slug'];
                        @endphp
                        @foreach($navProducts as $nav)
                        @if($nav['slug'] !== $currentSlug)
                        <li>
                            <a href="{{ url('/product/' . $nav['slug']) }}">
                                <img src="{{ asset('images/products/' . $nav['slug'] . '.svg') }}"
                                     alt="{{ $nav['name'] }}"
                                     class="sidebar-nav-thumb"
                                     width="44" height="30" loading="lazy">
                                {{ $nav['name'] }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>

            </aside>

        </div>
    </div>
</section>

@endsection