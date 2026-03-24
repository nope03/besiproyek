@extends('layouts.app')

@section('title', 'Product Besi dan Baja – PT Mitra Abadi Metalindo')

@section('content')

<!-- Page Hero -->
<div class="page-hero">
    <div class="hero-bg">
        <div class="hero-grid-lines"></div>
        <div class="hero-glow"></div>
    </div>
    <div class="page-hero__content">
        <span class="section-tag">// PRODUCT</span>
        <h1 class="page-hero__title">PRODUCT</h1>
        <p class="page-hero__sub">We'd Love To Hear From You</p>
    </div>
</div>

<!-- Intro -->
<section class="section section--sm">
    <div class="container">
        <div class="product-intro">
            <h2 class="section-title">Product – PT Mitra Abadi Metalindo</h2>
            <p>
                Halaman product ini menyajikan rangkaian <strong>product besi dan baja</strong> yang tersedia di PT Mitra Abadi Metalindo.
                Setiap proyek tentu memiliki kebutuhan berbeda, sehingga kami menyediakan pilihan material yang lengkap untuk mendukung
                berbagai jenis pekerjaan konstruksi. Selain itu, proses pemilihan produk dilakukan melalui standar kualitas yang ketat
                agar pelanggan memperoleh material yang kuat, presisi, dan tahan lama.
            </p>
            <p style="margin-top:1rem;">
                Sebagai <strong>distributor besi dan baja</strong>, kami tidak hanya menyediakan produk lengkap, tetapi juga layanan
                konsultasi serta pengiriman. PT Mitra Abadi Metalindo siap menjadi mitra terpercaya untuk semua kebutuhan material konstruksi.
            </p>
        </div>
    </div>
</section>

<!-- Filter Bar -->
<div class="filter-bar">
    <div class="container">
        <div class="filter-bar__inner">
            <span class="filter-label">Filter:</span>
            <div class="filter-tabs" id="filterTabs">
                <button class="filter-tab active" data-filter="all">Semua</button>
                <button class="filter-tab" data-filter="tulangan">Baja Tulangan</button>
                <button class="filter-tab" data-filter="profil">Baja Profil</button>
                <button class="filter-tab" data-filter="plat">Plat & Sheet</button>
                <button class="filter-tab" data-filter="pipa">Pipa & Hollow</button>
                <button class="filter-tab" data-filter="ringan">Baja Ringan</button>
                <button class="filter-tab" data-filter="lainnya">Lainnya</button>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<section class="section">
    <div class="container">
        <div class="catalog-grid" id="catalogGrid">

        {{--
            Supports two data sources:
            1. $products = Eloquent Collection dari DB (ProductController pakai DB)
               — gambar dari $p->image_url (upload atau fallback SVG)
            2. $products = array statis (ProductController pakai hardcoded array)
               — gambar dari asset('images/products/{slug}.svg')
        --}}
        @isset($products)
            {{-- ── DATA DARI DATABASE ─────────────────────────── --}}
            @foreach($products as $p)
            @php
                $slug     = is_object($p) ? $p->slug     : $p['slug'];
                $name     = is_object($p) ? $p->name     : $p['name'];
                $category = is_object($p) ? $p->category : $p['category'];
                $desc     = is_object($p) ? $p->subtitle : ($p['subtitle'] ?? $p['desc'] ?? '');
                $imgUrl   = is_object($p) ? $p->image_url : asset('images/products/' . $slug . '.svg');
                $catFilter= match(true) {
                    str_contains($category, 'Tulangan')  => 'tulangan',
                    str_contains($category, 'Profil')    => 'profil',
                    str_contains($category, 'Plat')      => 'plat',
                    str_contains($category, 'Pipa')      => 'pipa',
                    str_contains($category, 'Hollow')    => 'pipa',
                    str_contains($category, 'Ringan')    => 'ringan',
                    default                              => 'lainnya',
                };
                $specs = is_object($p)
                    ? collect($p->spesifikasi)->take(4)->map(fn($v,$k)=>[$k,$v])->values()->toArray()
                    : ($p['specs'] ?? []);
            @endphp
            <article class="catalog-card" data-cat="{{ $catFilter }}">
                <a href="{{ url('/product/' . $slug) }}" class="catalog-card__img-link">
                    <img src="{{ $imgUrl }}"
                         alt="Ilustrasi {{ $name }}"
                         class="catalog-card__img"
                         width="400" height="220"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='{{ asset('storage/products/' . $slug . '.svg') }}'">
                    <span class="catalog-card__cat-badge">{{ $category }}</span>
                </a>
                <div class="catalog-card__body">
                    <h3 class="catalog-card__name">{{ $name }}</h3>
                    <p class="catalog-card__desc">{{ $desc }}</p>
                    @if(count($specs))
                    <table class="spec-table">
                        @foreach($specs as $spec)
                        <tr><th>{{ $spec[0] }}</th><td>{{ $spec[1] }}</td></tr>
                        @endforeach
                    </table>
                    @endif
                    <a href="{{ url('/product/' . $slug) }}" class="catalog-card__cta">Selengkapnya →</a>
                </div>
            </article>
            @endforeach

        @else
            {{-- ── FALLBACK: DATA STATIS (jika $products tidak ada) ── --}}
            @php
            $staticProducts = [
                ['slug'=>'besi-beton',      'cat'=>'tulangan', 'catLabel'=>'Baja Tulangan', 'name'=>'Besi Beton',            'desc'=>'Besi tulangan beton (BJTD) untuk konstruksi bangunan, jembatan, dan infrastruktur. Memiliki lekukan (ulir) yang meningkatkan daya cengkeram dengan beton.',     'specs'=>[['Standar','SNI 2052:2017'],['Grade','BJTD 40 / BJTD 50'],['Diameter','Ø8 – Ø32 mm'],['Panjang','12 meter']]],
                ['slug'=>'besi-siku',       'cat'=>'profil',   'catLabel'=>'Baja Profil',   'name'=>'Besi Siku',             'desc'=>'Besi profil siku (L) untuk rangka atap, rak, bracing, dan berbagai konstruksi ringan maupun berat. Tersedia ukuran sama sisi dan tidak sama sisi.',           'specs'=>[['Standar','JIS G3101 / SNI'],['Grade','SS400'],['Ukuran','25×25 – 200×200 mm'],['Panjang','6m / 12m']]],
                ['slug'=>'besi-virkan',     'cat'=>'profil',   'catLabel'=>'Baja Profil',   'name'=>'Besi Virkan (WF)',      'desc'=>'Baja Wide Flange (WF) untuk balok dan kolom struktur bangunan bertingkat, jembatan, dan konstruksi berat lainnya.',                                            'specs'=>[['Standar','JIS G3101'],['Grade','SS400 / A36'],['Ukuran','WF 100×100 – 400×400'],['Panjang','6m / 9m / 12m']]],
                ['slug'=>'h-beam',          'cat'=>'profil',   'catLabel'=>'Baja Profil',   'name'=>'H-Beam',                'desc'=>'Baja profil H-Beam untuk kolom struktur bangunan, jembatan, dan konstruksi pelabuhan. Memiliki rasio kekuatan terhadap berat yang sangat baik.',               'specs'=>[['Standar','JIS G3101 / ASTM'],['Grade','SS400'],['Ukuran','H 100 – H 400'],['Panjang','6m / 12m']]],
                ['slug'=>'unp',             'cat'=>'profil',   'catLabel'=>'Baja Profil',   'name'=>'Kanal UNP',             'desc'=>'Profil kanal U (UNP) untuk rangka bangunan, purlin, gording atap, dan berbagai aplikasi struktural lainnya.',                                                'specs'=>[['Standar','DIN 1025 / JIS'],['Grade','ST37 / SS400'],['Ukuran','UNP 80 – UNP 300'],['Panjang','6m / 12m']]],
                ['slug'=>'cnp',             'cat'=>'profil',   'catLabel'=>'Baja Profil',   'name'=>'Kanal CNP',             'desc'=>'Kanal C dengan bibir (Lips Channel) untuk gording atap, rangka dinding, dan struktur ringan pada bangunan industri dan komersial.',                          'specs'=>[['Standar','SNI / JIS'],['Ukuran','60×30 – 200×75 mm'],['Tebal','2.3 – 4.5 mm'],['Panjang','6m / 12m']]],
                ['slug'=>'plat-hitam',      'cat'=>'plat',     'catLabel'=>'Plat & Sheet',  'name'=>'Plat Hitam',            'desc'=>'Plat baja hitam hasil proses hot rolling untuk fabrikasi berat, dudukan mesin, konstruksi kapal, tangki, dan berbagai kebutuhan industri.',                  'specs'=>[['Standar','ASTM A36 / JIS G3101'],['Tebal','3 – 100 mm'],['Lebar','hingga 2500 mm'],['Panjang','hingga 12000 mm']]],
                ['slug'=>'plat-bordes',     'cat'=>'plat',     'catLabel'=>'Plat & Sheet',  'name'=>'Plat Bordes',           'desc'=>'Plat bordes dengan pola timbul anti-selip untuk lantai tangga, dek kendaraan, platform industri, dan area yang memerlukan keamanan pijakan.',                'specs'=>[['Standar','JIS G3101 / SNI'],['Tebal','3 – 12 mm'],['Pola','Diamond / 5-bar'],['Lebar','1000 / 1200 / 1500 mm']]],
                ['slug'=>'pipa-galvanis',   'cat'=>'pipa',     'catLabel'=>'Pipa',          'name'=>'Pipa Galvanis',         'desc'=>'Pipa baja berlapis galvanis (zinc coating) untuk instalasi air, gas, scaffolding, dan konstruksi yang memerlukan ketahanan korosi.',                         'specs'=>[['Standar','JIS G3452 / SNI'],['Diameter','½ in – 6 in'],['Tebal','2.0 – 6.0 mm'],['Panjang','6m standar']]],
                ['slug'=>'pipa-stainless',  'cat'=>'pipa',     'catLabel'=>'Pipa',          'name'=>'Pipa Stainless Steel',  'desc'=>'Pipa stainless steel untuk industri makanan, farmasi, kimia, dan aplikasi yang memerlukan ketahanan korosi tinggi dan higienis.',                            'specs'=>[['Grade','SS304 / SS316'],['Diameter','¼ in – 12 in'],['Finish','2B / Hairline / Mirror'],['Panjang','6m standar']]],
                ['slug'=>'hollow-hitam',    'cat'=>'pipa',     'catLabel'=>'Hollow',        'name'=>'Hollow Hitam (SHS/RHS)','desc'=>'Hollow baja hitam profil persegi dan persegi panjang untuk rangka bangunan, kanopi, furniture metal, dan berbagai konstruksi ringan.',                   'specs'=>[['Standar','JIS G3466 / SNI'],['Ukuran','20×20 – 200×200 mm'],['Tebal','1.6 – 6.0 mm'],['Panjang','6m standar']]],
                ['slug'=>'atap-galvalum',   'cat'=>'ringan',   'catLabel'=>'Baja Ringan',   'name'=>'Atap Galvalum',         'desc'=>'Atap baja ringan galvalum (campuran zinc dan aluminium) untuk atap bangunan hunian, pabrik, dan gudang. Ringan, kuat, dan tahan karat.',                   'specs'=>[['Material','Zincalume / Galvalum'],['Tebal','0.25 – 0.40 mm BMT'],['Panjang','Custom (potong sesuai order)'],['Warna','Silver / Natural']]],
                ['slug'=>'hollow-galvalum', 'cat'=>'ringan',   'catLabel'=>'Baja Ringan',   'name'=>'Hollow Galvalum',       'desc'=>'Hollow baja ringan galvalum untuk rangka atap, plafon, partisi dinding, dan berbagai kebutuhan konstruksi baja ringan modern.',                             'specs'=>[['Material','Galvalum / Zincalume'],['Ukuran','25×50, 40×40, 40×60 mm'],['Tebal','0.6 – 1.2 mm'],['Panjang','6m standar']]],
                ['slug'=>'canal-galvalum',  'cat'=>'ringan',   'catLabel'=>'Baja Ringan',   'name'=>'Canal Galvalum (CNP)',  'desc'=>'Kanal C baja ringan galvalum untuk gording, reng, dan rangka atap sistem baja ringan. Lebih ekonomis dan tahan korosi.',                                    'specs'=>[['Material','Galvalum'],['Ukuran','60×30 – 150×65 mm'],['Tebal','0.75 – 1.0 mm'],['Panjang','6m standar']]],
                ['slug'=>'wiremesh',        'cat'=>'lainnya',  'catLabel'=>'Wiremesh',      'name'=>'Wiremesh',              'desc'=>'Wiremesh (anyaman kawat las) untuk tulangan pelat lantai beton, jalan, landasan, dan precast. Mempercepat pekerjaan tulangan di lapangan.',                 'specs'=>[['Standar','SNI 03-6812-2002'],['Tipe','M4 – M12'],['Ukuran Sheet','2.1 × 5.4 m'],['Mesh','100×100 / 150×150 mm']]],
                ['slug'=>'mur-baut',        'cat'=>'lainnya',  'catLabel'=>'Aksesori',      'name'=>'Mur dan Baut',          'desc'=>'Mur dan baut baja untuk sambungan struktur, mesin, dan konstruksi. Tersedia berbagai ukuran dan grade kekuatan.',                                           'specs'=>[['Grade','4.8 / 8.8 / 10.9'],['Ukuran','M6 – M36'],['Tipe','Hex / Carriage / Anchor'],['Finish','Galvanis / Black']]],
                ['slug'=>'pagar-brc',       'cat'=>'lainnya',  'catLabel'=>'Pagar',         'name'=>'Pagar BRC',             'desc'=>'Pagar BRC (Welded Mesh Fence) untuk keamanan area pabrik, perumahan, sekolah, dan fasilitas umum. Kokoh, estetis, dan tahan lama.',                        'specs'=>[['Standar','SNI / BS'],['Diameter Kawat','4 – 6 mm'],['Tinggi','0.9 – 2.4 m'],['Panjang Panel','2.4 m / 3.0 m']]],
                ['slug'=>'bondek',          'cat'=>'lainnya',  'catLabel'=>'Bondek',        'name'=>'Bondek (Floor Deck)',   'desc'=>'Bondek (steel floor deck) sebagai bekisting permanen sekaligus tulangan pelat lantai beton komposit pada gedung bertingkat.',                              'specs'=>[['Material','Galvalum / Zincalume'],['Tebal','0.75 – 1.0 mm'],['Lebar Efektif','600 mm'],['Panjang','Sesuai pesanan']]],
                ['slug'=>'angkur',          'cat'=>'lainnya',  'catLabel'=>'Aksesori',      'name'=>'Angkur (Anchor Bolt)',  'desc'=>'Angkur baja untuk pemasangan kolom struktur ke pondasi beton, peralatan industri, dan berbagai kebutuhan yang memerlukan pengikat ke beton.',              'specs'=>[['Grade','4.8 / 8.8'],['Ukuran','M12 – M48'],['Tipe','L-bolt / J-bolt / Straight'],['Finish','Galvanis / Hitam']]],
                ['slug'=>'kawat',           'cat'=>'lainnya',  'catLabel'=>'Kawat',         'name'=>'Kawat Duri & Harmonika','desc'=>'Kawat berduri dan kawat harmonika untuk pengamanan perimeter, pagar keamanan, dan pembatas area. Tersedia juga kawat loket untuk kandang dan saringan.',  'specs'=>[['Tipe','Kawat Duri / Harmonika / Loket'],['Material','Baja galvanis / hitam'],['Panjang Roll','10m / 25m / 50m'],['Lebar','Berbagai ukuran']]],
            ];
            @endphp

            @foreach($staticProducts as $p)
            <article class="catalog-card" data-cat="{{ $p['cat'] }}">
                <a href="{{ url('/product/' . $p['slug']) }}" class="catalog-card__img-link">
                    <img src="{{ asset('images/products/' . $p['slug'] . '.svg') }}"
                         alt="Ilustrasi {{ $p['name'] }}"
                         class="catalog-card__img"
                         width="400" height="220"
                         loading="lazy">
                    <span class="catalog-card__cat-badge">{{ $p['catLabel'] }}</span>
                </a>
                <div class="catalog-card__body">
                    <h3 class="catalog-card__name">{{ $p['name'] }}</h3>
                    <p class="catalog-card__desc">{{ $p['desc'] }}</p>
                    <table class="spec-table">
                        @foreach($p['specs'] as $spec)
                        <tr><th>{{ $spec[0] }}</th><td>{{ $spec[1] }}</td></tr>
                        @endforeach
                    </table>
                    <a href="{{ url('/product/' . $p['slug']) }}" class="catalog-card__cta">Selengkapnya →</a>
                </div>
            </article>
            @endforeach
        @endisset

        </div>

        <!-- CTA Panel -->
        <div class="product-cta-panel">
            <div class="product-cta-panel__inner">
                <div>
                    <h3>Tidak menemukan produk yang dicari?</h3>
                    <p>Hubungi tim kami untuk konsultasi kebutuhan material dan penawaran harga terbaik.</p>
                </div>
                <a href="https://wa.me/6281130556500?text=Halo%20kak,%20kami%20ada%20kebutuhan%20urgent%20untuk%20besi%20dan%20baja%20konstruksi.%20bisa%20segera%20menghubungi%20kontak%20saya?"
                   target="_blank" rel="noopener" class="btn btn--primary">💬 Konsultasi via WhatsApp</a>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
const tabs  = document.querySelectorAll('.filter-tab');
const cards = document.querySelectorAll('.catalog-card');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const filter = tab.dataset.filter;
        cards.forEach(card => {
            const show = filter === 'all' || card.dataset.cat === filter;
            card.style.display = show ? '' : 'none';
            if (show) card.style.animation = 'fadeInUp 0.35s ease forwards';
        });
    });
});
</script>
@endpush