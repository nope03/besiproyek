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
                agar pelanggan memperoleh material yang kuat, presisi, dan tahan lama. Dengan pendekatan tersebut, setiap pelanggan
                dapat menyesuaikan spesifikasi material sesuai kebutuhan lapangan.
            </p>
            <p style="margin-top:1rem;">
                Sebagai <strong>distributor besi dan baja</strong>, kami tidak hanya menyediakan produk lengkap, tetapi juga layanan
                konsultasi serta pengiriman. Dukungan ini memudahkan pelanggan mendapatkan informasi teknis sebelum melakukan pemesanan.
                Melalui pelayanan yang terstruktur, PT Mitra Abadi Metalindo siap menjadi mitra terpercaya untuk semua kebutuhan
                material konstruksi.
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

            <!-- BAJA TULANGAN -->
            <article class="catalog-card" data-cat="tulangan">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="10" y1="20" x2="50" y2="20" stroke="currentColor" stroke-width="5"/>
                            <line x1="10" y1="30" x2="50" y2="30" stroke="currentColor" stroke-width="5"/>
                            <line x1="10" y1="40" x2="50" y2="40" stroke="currentColor" stroke-width="5"/>
                            <rect x="16" y="17" width="4" height="26" fill="currentColor" opacity="0.3"/>
                            <rect x="28" y="17" width="4" height="26" fill="currentColor" opacity="0.3"/>
                            <rect x="40" y="17" width="4" height="26" fill="currentColor" opacity="0.3"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Tulangan</span>
                </div>
                <h3 class="catalog-card__name">Besi Beton</h3>
                <p class="catalog-card__desc">Besi tulangan beton (BJTD) untuk konstruksi bangunan, jembatan, dan infrastruktur. Memiliki lekukan (ulir) yang meningkatkan daya cengkeram dengan beton.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>SNI 2052:2017</td></tr>
                    <tr><th>Grade</th><td>BJTD 40 / BJTD 50</td></tr>
                    <tr><th>Diameter</th><td>Ø8 – Ø32 mm</td></tr>
                    <tr><th>Panjang</th><td>12 meter</td></tr>
                </table>
                <a href="{{ url('/product/besi-beton') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <!-- BAJA PROFIL -->
            <article class="catalog-card" data-cat="profil">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="5" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="47" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="5" width="8" height="50" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Profil</span>
                </div>
                <h3 class="catalog-card__name">Besi Siku</h3>
                <p class="catalog-card__desc">Besi profil siku (L) untuk rangka atap, rak, bracing, dan berbagai konstruksi ringan maupun berat. Tersedia ukuran sama sisi dan tidak sama sisi.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3101 / SNI</td></tr>
                    <tr><th>Grade</th><td>SS400</td></tr>
                    <tr><th>Ukuran</th><td>25×25 – 200×200 mm</td></tr>
                    <tr><th>Panjang</th><td>6m / 12m</td></tr>
                </table>
                <a href="{{ url('/product/besi-siku') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="profil">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="5" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="47" width="44" height="8" fill="currentColor"/>
                            <rect x="22" y="5" width="16" height="50" fill="currentColor" opacity="0.6"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Profil</span>
                </div>
                <h3 class="catalog-card__name">Besi Virkan (WF)</h3>
                <p class="catalog-card__desc">Baja Wide Flange (WF/Besi Virkan) untuk balok dan kolom struktur bangunan bertingkat, jembatan, dan konstruksi berat lainnya.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3101</td></tr>
                    <tr><th>Grade</th><td>SS400 / A36</td></tr>
                    <tr><th>Ukuran</th><td>WF 100×100 – 400×400</td></tr>
                    <tr><th>Panjang</th><td>6m / 9m / 12m</td></tr>
                </table>
                <a href="{{ url('/product/besi-virkan') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="profil">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="22" y="5" width="16" height="50" fill="currentColor" opacity="0.15"/>
                            <rect x="8" y="5" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="47" width="44" height="8" fill="currentColor"/>
                            <rect x="22" y="5" width="16" height="50" fill="currentColor" opacity="0.6"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Profil</span>
                </div>
                <h3 class="catalog-card__name">H-Beam</h3>
                <p class="catalog-card__desc">Baja profil H-Beam untuk kolom struktur bangunan, jembatan, dan konstruksi pelabuhan. Memiliki rasio kekuatan terhadap berat yang sangat baik.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3101 / ASTM</td></tr>
                    <tr><th>Grade</th><td>SS400</td></tr>
                    <tr><th>Ukuran</th><td>H 100 – H 400</td></tr>
                    <tr><th>Panjang</th><td>6m / 12m</td></tr>
                </table>
                <a href="{{ url('/product/h-beam') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="profil">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="5" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="47" width="44" height="8" fill="currentColor"/>
                            <rect x="8" y="5" width="8" height="50" fill="currentColor"/>
                            <rect x="8" y="25" width="28" height="8" fill="currentColor" opacity="0.5"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Profil</span>
                </div>
                <h3 class="catalog-card__name">Kanal UNP</h3>
                <p class="catalog-card__desc">Profil kanal U (UNP) untuk rangka bangunan, purlin, gording atap, dan berbagai aplikasi struktural lainnya.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>DIN 1025 / JIS</td></tr>
                    <tr><th>Grade</th><td>ST37 / SS400</td></tr>
                    <tr><th>Ukuran</th><td>UNP 80 – UNP 300</td></tr>
                    <tr><th>Panjang</th><td>6m / 12m</td></tr>
                </table>
                <a href="{{ url('/product/unp') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="profil">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 8 L8 52 L52 52" stroke="currentColor" stroke-width="7" fill="none"/>
                            <path d="M8 8 L30 8" stroke="currentColor" stroke-width="7" fill="none"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Profil</span>
                </div>
                <h3 class="catalog-card__name">Kanal CNP (Lips Channel)</h3>
                <p class="catalog-card__desc">Kanal C dengan bibir (CNP/Lips Channel) untuk gording atap, rangka dinding, dan struktur ringan pada bangunan industri dan komersial.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>SNI / JIS</td></tr>
                    <tr><th>Ukuran</th><td>60×30 – 200×75 mm</td></tr>
                    <tr><th>Tebal</th><td>2.3 – 4.5 mm</td></tr>
                    <tr><th>Panjang</th><td>6m / 12m</td></tr>
                </table>
                <a href="{{ url('/product/cnp') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <!-- PLAT -->
            <article class="catalog-card" data-cat="plat">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="20" width="44" height="20" fill="currentColor" opacity="0.5"/>
                            <rect x="8" y="20" width="44" height="4" fill="currentColor"/>
                            <rect x="8" y="36" width="44" height="4" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Plat & Sheet</span>
                </div>
                <h3 class="catalog-card__name">Plat Hitam (Hot Rolled)</h3>
                <p class="catalog-card__desc">Plat baja hitam hasil proses hot rolling untuk fabrikasi berat, dudukan mesin, konstruksi kapal, tangki, dan berbagai kebutuhan industri.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>ASTM A36 / JIS G3101</td></tr>
                    <tr><th>Tebal</th><td>3 – 100 mm</td></tr>
                    <tr><th>Lebar</th><td>hingga 2500 mm</td></tr>
                    <tr><th>Panjang</th><td>hingga 12000 mm</td></tr>
                </table>
                <a href="{{ url('/product/plat-hitam') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="plat">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="20" width="44" height="20" fill="currentColor" opacity="0.5"/>
                            <line x1="15" y1="20" x2="20" y2="40" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                            <line x1="25" y1="20" x2="30" y2="40" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                            <line x1="35" y1="20" x2="40" y2="40" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                            <rect x="8" y="20" width="44" height="3" fill="currentColor"/>
                            <rect x="8" y="37" width="44" height="3" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Plat & Sheet</span>
                </div>
                <h3 class="catalog-card__name">Plat Bordes (Checker Plate)</h3>
                <p class="catalog-card__desc">Plat bordes dengan pola timbul anti-selip untuk lantai tangga, dek kendaraan, platform industri, dan area yang memerlukan keamanan pijakan.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3101 / SNI</td></tr>
                    <tr><th>Tebal</th><td>3 – 12 mm</td></tr>
                    <tr><th>Pola</th><td>Diamond / 5-bar</td></tr>
                    <tr><th>Lebar</th><td>1000 / 1200 / 1500 mm</td></tr>
                </table>
                <a href="{{ url('/product/plat-bordes') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <!-- PIPA & HOLLOW -->
            <article class="catalog-card" data-cat="pipa">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="20" stroke="currentColor" stroke-width="6" fill="none"/>
                            <circle cx="30" cy="30" r="10" stroke="currentColor" stroke-width="2" fill="none" opacity="0.5"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Pipa</span>
                </div>
                <h3 class="catalog-card__name">Pipa Galvanis</h3>
                <p class="catalog-card__desc">Pipa baja berlapis galvanis (zinc coating) untuk instalasi air, gas, scaffolding, dan konstruksi yang memerlukan ketahanan korosi.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3452 / SNI</td></tr>
                    <tr><th>Diameter</th><td>½" – 6"</td></tr>
                    <tr><th>Tebal</th><td>2.0 – 6.0 mm</td></tr>
                    <tr><th>Panjang</th><td>6m standar</td></tr>
                </table>
                <a href="{{ url('/product/pipa-galvanis') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="pipa">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="20" stroke="currentColor" stroke-width="6" fill="none"/>
                            <path d="M20 22 Q30 15 40 22" stroke="currentColor" stroke-width="2" fill="none" opacity="0.6"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Pipa</span>
                </div>
                <h3 class="catalog-card__name">Pipa Stainless Steel</h3>
                <p class="catalog-card__desc">Pipa stainless steel untuk industri makanan, farmasi, kimia, dan aplikasi yang memerlukan ketahanan korosi tinggi dan higienis.</p>
                <table class="spec-table">
                    <tr><th>Grade</th><td>SS304 / SS316</td></tr>
                    <tr><th>Diameter</th><td>¼" – 12"</td></tr>
                    <tr><th>Finish</th><td>2B / Hairline / Mirror</td></tr>
                    <tr><th>Panjang</th><td>6m standar</td></tr>
                </table>
                <a href="{{ url('/product/pipa-stainless') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="pipa">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="12" y="12" width="36" height="36" rx="2" stroke="currentColor" stroke-width="6" fill="none"/>
                            <rect x="22" y="22" width="16" height="16" rx="1" stroke="currentColor" stroke-width="2" fill="none" opacity="0.5"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Hollow</span>
                </div>
                <h3 class="catalog-card__name">Hollow Hitam (SHS/RHS)</h3>
                <p class="catalog-card__desc">Hollow baja hitam profil persegi dan persegi panjang untuk rangka bangunan, kanopi, furniture metal, dan berbagai konstruksi ringan.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>JIS G3466 / SNI</td></tr>
                    <tr><th>Ukuran</th><td>20×20 – 200×200 mm</td></tr>
                    <tr><th>Tebal</th><td>1.6 – 6.0 mm</td></tr>
                    <tr><th>Panjang</th><td>6m standar</td></tr>
                </table>
                <a href="{{ url('/product/hollow-hitam') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <!-- BAJA RINGAN -->
            <article class="catalog-card" data-cat="ringan">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="8,45 20,15 32,35 44,20 56,30" stroke="currentColor" stroke-width="5" fill="none"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Ringan</span>
                </div>
                <h3 class="catalog-card__name">Atap Galvalum</h3>
                <p class="catalog-card__desc">Atap baja ringan galvalum (campuran zinc dan aluminium) untuk atap bangunan hunian, pabrik, dan gudang. Ringan, kuat, dan tahan karat.</p>
                <table class="spec-table">
                    <tr><th>Material</th><td>Zincalume / Galvalum</td></tr>
                    <tr><th>Tebal</th><td>0.25 – 0.40 mm BMT</td></tr>
                    <tr><th>Panjang</th><td>Custom (potong sesuai order)</td></tr>
                    <tr><th>Warna</th><td>Silver / Natural</td></tr>
                </table>
                <a href="{{ url('/product/atap-galvalum') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="ringan">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="12" y="12" width="36" height="36" rx="2" stroke="currentColor" stroke-width="4" fill="none"/>
                            <line x1="12" y1="24" x2="48" y2="24" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                            <line x1="12" y1="36" x2="48" y2="36" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Ringan</span>
                </div>
                <h3 class="catalog-card__name">Hollow Galvalum</h3>
                <p class="catalog-card__desc">Hollow baja ringan galvalum untuk rangka atap, plafon, partisi dinding, dan berbagai kebutuhan konstruksi baja ringan modern.</p>
                <table class="spec-table">
                    <tr><th>Material</th><td>Galvalum / Zincalume</td></tr>
                    <tr><th>Ukuran</th><td>25×50, 40×40, 40×60 mm</td></tr>
                    <tr><th>Tebal</th><td>0.6 – 1.2 mm</td></tr>
                    <tr><th>Panjang</th><td>6m standar</td></tr>
                </table>
                <a href="{{ url('/product/hollow-galvalum') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="ringan">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 8 L8 52 L52 52" stroke="currentColor" stroke-width="5" fill="none"/>
                            <path d="M8 8 L22 8" stroke="currentColor" stroke-width="5" fill="none"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Baja Ringan</span>
                </div>
                <h3 class="catalog-card__name">Canal Galvalum (CNP)</h3>
                <p class="catalog-card__desc">Kanal C baja ringan galvalum untuk gording, reng, dan rangka atap sistem baja ringan. Lebih ekonomis dan tahan korosi.</p>
                <table class="spec-table">
                    <tr><th>Material</th><td>Galvalum</td></tr>
                    <tr><th>Ukuran</th><td>60×30 – 150×65 mm</td></tr>
                    <tr><th>Tebal</th><td>0.75 – 1.0 mm</td></tr>
                    <tr><th>Panjang</th><td>6m standar</td></tr>
                </table>
                <a href="{{ url('/product/canal-galvalum') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <!-- LAINNYA -->
            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="10" y1="10" x2="50" y2="50" stroke="currentColor" stroke-width="4"/>
                            <line x1="10" y1="22" x2="38" y2="50" stroke="currentColor" stroke-width="4"/>
                            <line x1="22" y1="10" x2="50" y2="38" stroke="currentColor" stroke-width="4"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Wiremesh</span>
                </div>
                <h3 class="catalog-card__name">Wiremesh</h3>
                <p class="catalog-card__desc">Wiremesh (anyaman kawat las) untuk tulangan pelat lantai beton, jalan, landasan, dan precast. Mempercepat pekerjaan tulangan di lapangan.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>SNI 03-6812-2002</td></tr>
                    <tr><th>Tipe</th><td>M4 – M12</td></tr>
                    <tr><th>Ukuran Sheet</th><td>2.1 × 5.4 m</td></tr>
                    <tr><th>Mesh</th><td>100×100 / 150×150 mm</td></tr>
                </table>
                <a href="{{ url('/product/wiremesh') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="6" stroke="currentColor" stroke-width="4" fill="none"/>
                            <circle cx="40" cy="40" r="6" stroke="currentColor" stroke-width="4" fill="none"/>
                            <line x1="24" y1="24" x2="36" y2="36" stroke="currentColor" stroke-width="4"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Aksesori</span>
                </div>
                <h3 class="catalog-card__name">Mur dan Baut</h3>
                <p class="catalog-card__desc">Mur dan baut baja untuk sambungan struktur, mesin, dan konstruksi. Tersedia berbagai ukuran dan grade kekuatan.</p>
                <table class="spec-table">
                    <tr><th>Grade</th><td>4.8 / 8.8 / 10.9</td></tr>
                    <tr><th>Ukuran</th><td>M6 – M36</td></tr>
                    <tr><th>Tipe</th><td>Hex / Carriage / Anchor</td></tr>
                    <tr><th>Finish</th><td>Galvanis / Black</td></tr>
                </table>
                <a href="{{ url('/product/mur-baut') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="8" y1="8" x2="8" y2="52" stroke="currentColor" stroke-width="4"/>
                            <line x1="52" y1="8" x2="52" y2="52" stroke="currentColor" stroke-width="4"/>
                            <line x1="8" y1="20" x2="52" y2="20" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                            <line x1="8" y1="30" x2="52" y2="30" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                            <line x1="8" y1="40" x2="52" y2="40" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Pagar</span>
                </div>
                <h3 class="catalog-card__name">Pagar BRC</h3>
                <p class="catalog-card__desc">Pagar BRC (Welded Mesh Fence) untuk keamanan area pabrik, perumahan, sekolah, dan fasilitas umum. Kokoh, estetis, dan tahan lama.</p>
                <table class="spec-table">
                    <tr><th>Standar</th><td>SNI / BS</td></tr>
                    <tr><th>Diameter Kawat</th><td>4 – 6 mm</td></tr>
                    <tr><th>Tinggi</th><td>0.9 – 2.4 m</td></tr>
                    <tr><th>Panjang Panel</th><td>2.4 m / 3.0 m</td></tr>
                </table>
                <a href="{{ url('/product/pagar-brc') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v3">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="12" y="25" width="36" height="10" fill="currentColor" opacity="0.4"/>
                            <circle cx="20" cy="30" r="6" stroke="currentColor" stroke-width="3" fill="none"/>
                            <circle cx="40" cy="30" r="6" stroke="currentColor" stroke-width="3" fill="none"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Bondek</span>
                </div>
                <h3 class="catalog-card__name">Bondek (Floor Deck)</h3>
                <p class="catalog-card__desc">Bondek (steel floor deck) sebagai bekisting permanen sekaligus tulangan pelat lantai beton komposit pada gedung bertingkat.</p>
                <table class="spec-table">
                    <tr><th>Material</th><td>Galvalum / Zincalume</td></tr>
                    <tr><th>Tebal</th><td>0.75 – 1.0 mm</td></tr>
                    <tr><th>Lebar Efektif</th><td>600 mm</td></tr>
                    <tr><th>Panjang</th><td>Sesuai pesanan</td></tr>
                </table>
                <a href="{{ url('/product/bondek') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v4">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="15" y1="8" x2="15" y2="52" stroke="currentColor" stroke-width="5"/>
                            <line x1="10" y1="35" x2="40" y2="35" stroke="currentColor" stroke-width="4"/>
                            <line x1="40" y1="35" x2="40" y2="52" stroke="currentColor" stroke-width="4"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Aksesori</span>
                </div>
                <h3 class="catalog-card__name">Angkur (Anchor Bolt)</h3>
                <p class="catalog-card__desc">Angkur baja untuk pemasangan kolom struktur ke pondasi beton, peralatan industri, dan berbagai kebutuhan yang memerlukan pengikat ke beton.</p>
                <table class="spec-table">
                    <tr><th>Grade</th><td>4.8 / 8.8</td></tr>
                    <tr><th>Ukuran</th><td>M12 – M48</td></tr>
                    <tr><th>Tipe</th><td>L-bolt / J-bolt / Straight</td></tr>
                    <tr><th>Finish</th><td>Galvanis / Hitam</td></tr>
                </table>
                <a href="{{ url('/product/angkur') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

            <article class="catalog-card" data-cat="lainnya">
                <div class="catalog-card__head">
                    <div class="catalog-card__icon catalog-card__icon--v2">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 15 Q18 8 26 15 Q34 22 42 15 Q50 8 58 15" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path d="M10 30 Q18 23 26 30 Q34 37 42 30 Q50 23 58 30" stroke="currentColor" stroke-width="4" fill="none"/>
                            <path d="M10 45 Q18 38 26 45 Q34 52 42 45 Q50 38 58 45" stroke="currentColor" stroke-width="4" fill="none"/>
                        </svg>
                    </div>
                    <span class="catalog-card__cat-tag">Kawat</span>
                </div>
                <h3 class="catalog-card__name">Kawat Duri & Harmonika</h3>
                <p class="catalog-card__desc">Kawat berduri dan kawat harmonika untuk pengamanan perimeter, pagar keamanan, dan pembatas area. Tersedia juga kawat loket untuk kandang dan saringan.</p>
                <table class="spec-table">
                    <tr><th>Tipe</th><td>Kawat Duri / Harmonika / Loket</td></tr>
                    <tr><th>Material</th><td>Baja galvanis / hitam</td></tr>
                    <tr><th>Panjang Roll</th><td>10m / 25m / 50m</td></tr>
                    <tr><th>Lebar</th><td>Berbagai ukuran</td></tr>
                </table>
                <a href="{{ url('/product/kawat') }}" class="catalog-card__cta">Selengkapnya →</a>
            </article>

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
const tabs = document.querySelectorAll('.filter-tab');
const cards = document.querySelectorAll('.catalog-card');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const filter = tab.dataset.filter;
        cards.forEach(card => {
            if (filter === 'all' || card.dataset.cat === filter) {
                card.style.display = '';
                card.style.animation = 'fadeInUp 0.35s ease forwards';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
@endpush