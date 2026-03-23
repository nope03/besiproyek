<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    // ── Index ─────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%");
        }
        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', (bool) $request->get('status'));
        }

        $products     = $query->paginate(15);
        $categoryList = Product::distinct()->orderBy('category')->pluck('category');

        return view('admin.products.index', compact('products', 'categoryList'));
    }

    // ── Create Form ───────────────────────────────────────────
    public function create()
    {
        return view('admin.products.form');
    }

    // ── Store ─────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $data      = $this->prepareData($request, $validated);

        Product::create($data);

        if ($request->input('action') === 'save_and_new') {
            return redirect()->route('admin.products.create')
                ->with('success', "Produk \"{$data['name']}\" berhasil ditambahkan. Silakan tambah produk berikutnya.");
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$data['name']}\" berhasil ditambahkan.");
    }

    // ── Edit Form ─────────────────────────────────────────────
    public function edit(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('admin.products.form', compact('product'));
    }

    // ── Update ────────────────────────────────────────────────
    public function update(Request $request, int $id)
    {
        $product   = Product::findOrFail($id);
        $validated = $this->validateProduct($request, $product->id);
        $data      = $this->prepareData($request, $validated);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil diperbarui.");
    }

    // ── Toggle Active ─────────────────────────────────────────
    public function toggle(int $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Produk \"{$product->name}\" berhasil {$status}.");
    }

    // ── Destroy ───────────────────────────────────────────────
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $name    = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus.");
    }

    // ── Private: Validate ─────────────────────────────────────
    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'required|string|max:120|unique:products,slug' . ($ignoreId ? ",{$ignoreId}" : '');

        return $request->validate([
            'name'         => 'required|string|max:150',
            'slug'         => $slugRule,
            'category'     => 'required|string|max:80',
            'icon'         => 'nullable|string|max:10',
            'subtitle'     => 'required|string|max:255',
            'intro'        => 'required|string',
            'pengertian'   => 'required|string',
            'kesimpulan'   => 'required|string',
            'ukuran_intro' => 'nullable|string|max:500',
            'is_active'    => 'nullable',
            'fungsi'       => 'required|array|min:1',
            'fungsi.*.judul' => 'required|string|max:200',
            'fungsi.*.isi'   => 'required|string',
            'jenis'          => 'required|array|min:1',
            'jenis.*.nama'        => 'required|string|max:200',
            'jenis.*.deskripsi'   => 'required|string',
            'keunggulan'     => 'required|array|min:1',
            'keunggulan.*'   => 'required|string|max:300',
            'tabel_header'   => 'required|array|min:1',
            'tabel_header.*' => 'required|string|max:100',
            'tabel_data'     => 'required|array|min:1',
            'spesifikasi_key' => 'nullable|array',
            'spesifikasi_val' => 'nullable|array',
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'slug.required'        => 'Slug wajib diisi.',
            'slug.unique'          => 'Slug ini sudah digunakan produk lain. Gunakan slug yang berbeda.',
            'category.required'    => 'Kategori wajib dipilih.',
            'subtitle.required'    => 'Subtitle wajib diisi.',
            'intro.required'       => 'Paragraf intro wajib diisi.',
            'pengertian.required'  => 'Pengertian wajib diisi.',
            'kesimpulan.required'  => 'Kesimpulan wajib diisi.',
            'fungsi.required'      => 'Minimal satu fungsi harus diisi.',
            'jenis.required'       => 'Minimal satu jenis harus diisi.',
            'keunggulan.required'  => 'Minimal satu keunggulan harus diisi.',
            'tabel_header.required'=> 'Header tabel harus diisi.',
            'tabel_data.required'  => 'Data tabel harus diisi.',
        ]);
    }

    // ── Private: Prepare Data ─────────────────────────────────
    private function prepareData(Request $request, array $validated): array
    {
        // Build slug - auto-generate if empty
        $slug = $validated['slug']
            ?? Str::slug($validated['name']);

        // Build spesifikasi associative array
        $specKeys = $request->input('spesifikasi_key', []);
        $specVals = $request->input('spesifikasi_val', []);
        $spesifikasi = [];
        foreach ($specKeys as $i => $key) {
            if (!empty(trim($key))) {
                $spesifikasi[trim($key)] = trim($specVals[$i] ?? '');
            }
        }

        // Filter empty fungsi/jenis/keunggulan
        $fungsi = collect($validated['fungsi'] ?? [])
            ->filter(fn($f) => !empty(trim($f['judul'] ?? '')) && !empty(trim($f['isi'] ?? '')))
            ->values()->toArray();

        $jenis = collect($validated['jenis'] ?? [])
            ->filter(fn($j) => !empty(trim($j['nama'] ?? '')) && !empty(trim($j['deskripsi'] ?? '')))
            ->values()->toArray();

        $keunggulan = collect($validated['keunggulan'] ?? [])
            ->filter(fn($k) => !empty(trim($k)))
            ->values()->toArray();

        $tabelHeader = collect($validated['tabel_header'] ?? [])
            ->filter(fn($h) => !empty(trim($h)))
            ->values()->toArray();

        $tabelData = collect($request->input('tabel_data', []))
            ->map(fn($row) => collect($row)->map(fn($cell) => trim($cell ?? ''))->toArray())
            ->filter(fn($row) => collect($row)->filter(fn($c) => !empty($c))->isNotEmpty())
            ->values()->toArray();

        return [
            'name'         => trim($validated['name']),
            'slug'         => $slug,
            'category'     => $validated['category'],
            'icon'         => $validated['icon'] ?? null,
            'subtitle'     => $validated['subtitle'],
            'intro'        => $validated['intro'],
            'pengertian'   => $validated['pengertian'],
            'kesimpulan'   => $validated['kesimpulan'],
            'ukuran_intro' => $validated['ukuran_intro'] ?? null,
            'fungsi'       => $fungsi,
            'jenis'        => $jenis,
            'keunggulan'   => $keunggulan,
            'tabel_header' => $tabelHeader,
            'tabel_data'   => $tabelData,
            'spesifikasi'  => $spesifikasi,
            'is_active'    => $request->boolean('is_active'),
        ];
    }
}