<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    // ── Index ─────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%");
            });
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
    // BUG FIX: method store() sebelumnya memanggil $product->deleteImage() padahal
    // variabel $product belum didefinisikan (ini create bukan edit).
    // Perbaikan: handle image upload langsung tanpa menyentuh $product.
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $data      = $this->prepareData($request, $validated);

        // Handle image upload — tidak ada $product di sini karena ini CREATE
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), $data['slug']);
        } else {
            $data['image'] = null;
        }

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
    // BUG FIX: Sebelumnya menggunakan Product::where('id', $id)->update($data)
    // yang merupakan mass update via Query Builder — ini BYPASS Eloquent model
    // events dan juga TIDAK bisa meng-cast JSON fields (fungsi, jenis, dll)
    // karena data array tidak di-serialize otomatis.
    // Perbaikan: gunakan $product->fill($data)->save() via Eloquent model instance.
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $validated = $this->validateProduct($request, $product->id);
        $data      = $this->prepareData($request, $validated);

        // Handle image upload/replace
        if ($request->hasFile('image')) {
            if ($product->hasUploadedImage()) {
                $product->deleteImage();
            }
            $data['image'] = $this->uploadImage($request->file('image'), $data['slug']);
        } elseif ($request->boolean('remove_image')) {
            if ($product->hasUploadedImage()) {
                $product->deleteImage();
            }
            $data['image'] = null;
        } else {
            // Tidak ada perubahan gambar — pertahankan gambar lama
            $data['image'] = $product->image;
        }

        // Gunakan Eloquent fill+save agar cast JSON (array) bekerja dengan benar
        $product->fill($data)->save();

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
        $product->delete(); // Model event 'deleting' akan hapus gambar otomatis

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus.");
    }

    // ── Private: Upload Image ─────────────────────────────────
    private function uploadImage($file, string $slug): string
    {
        $ext      = $file->getClientOriginalExtension();
        $filename = $slug . '-' . time() . '.' . $ext;

        $file->storeAs('products', $filename, 'public');

        return $filename;
    }

    // ── Private: Validate ─────────────────────────────────────
    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        if (!$request->filled('slug') && $request->filled('name')) {
            $request->merge(['slug' => Str::slug($request->input('name'))]);
        }
        $slugRule = 'required|string|max:120|unique:products,slug' . ($ignoreId ? ",{$ignoreId}" : '');

        return $request->validate([
            'name'         => 'required|string|max:150',
            'slug'         => $slugRule,
            'category'     => 'required|string|max:80',
            'subtitle'     => 'required|string|max:255',

            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'nullable|boolean',

            'intro'        => 'required|string',
            'pengertian'   => 'required|string',
            'kesimpulan'   => 'required|string',
            'ukuran_intro' => 'nullable|string|max:500',
            // BUG FIX: Sebelumnya 'nullable' saja — bermasalah ketika form mengirim
            // dua nilai is_active sekaligus (hidden "0" + checkbox "1").
            // Laravel's $request->boolean() di prepareData() sudah menangani ini
            // dengan benar, jadi validasi cukup menerima nilai yang masuk akal.
            'is_active'    => 'nullable|in:0,1',

            'fungsi'           => 'nullable|array|min:1',
            'fungsi.*.judul'   => 'nullable|string|max:200',
            'fungsi.*.isi'     => 'nullable|string',

            'jenis'              => 'nullable|array|min:1',
            'jenis.*.nama'       => 'nullable|string|max:200',
            'jenis.*.deskripsi'  => 'nullable|string',

            'keunggulan'   => 'nullable|array|min:1',
            'keunggulan.*' => 'nullable|string|max:300',

            'tabel_header'   => 'nullable|array|min:1',
            'tabel_header.*' => 'nullable|string|max:100',
            'tabel_data'     => 'nullable|array|min:1',

            'spesifikasi_key' => 'nullable|array',
            'spesifikasi_val' => 'nullable|array',
        ], [
            'name.required'         => 'Nama produk wajib diisi.',
            'slug.required'         => 'Slug wajib diisi.',
            'slug.unique'           => 'Slug sudah digunakan produk lain.',
            'category.required'     => 'Kategori wajib dipilih.',
            'subtitle.required'     => 'Subtitle wajib diisi.',
            'image.image'           => 'File harus berupa gambar.',
            'image.mimes'           => 'Format gambar harus JPG, PNG, atau WebP.',
            'image.max'             => 'Ukuran gambar maksimal 2 MB.',
            'intro.required'        => 'Paragraf intro wajib diisi.',
            'pengertian.required'   => 'Pengertian wajib diisi.',
            'kesimpulan.required'   => 'Kesimpulan wajib diisi.',
            'fungsi.nullable'       => 'Minimal satu fungsi harus diisi.',
            'jenis.nullable'        => 'Minimal satu jenis harus diisi.',
            'keunggulan.nullable'   => 'Minimal satu keunggulan harus diisi.',
            'tabel_header.nullable' => 'Header tabel harus diisi.',
            'tabel_data.nullable'   => 'Data tabel harus diisi.',
        ]);
    }

    // ── Private: Prepare Data ─────────────────────────────────
    private function prepareData(Request $request, array $validated): array
    {
        $slug = $validated['slug'] ?? Str::slug($validated['name']);

        // Spesifikasi key-value
        $specKeys    = $request->input('spesifikasi_key', []);
        $specVals    = $request->input('spesifikasi_val', []);
        $spesifikasi = [];
        foreach ($specKeys as $i => $key) {
            if (!empty(trim($key))) {
                $spesifikasi[trim($key)] = trim($specVals[$i] ?? '');
            }
        }

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
            'subtitle'     => $validated['subtitle'],
            // 'image' TIDAK di-set di sini — dihandle di store() dan update()
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
    public function toggleFeatured(Product $product)
    {
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        $status = $product->is_featured ? 'berhasil dijadikan produk unggulan' : 'dihapus dari produk unggulan';
        return redirect()->back()->with('success', "Produk {$product->name} {$status}.");
    }
}