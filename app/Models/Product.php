<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'subtitle',
        'image',          // ← nama file, disimpan di storage/app/public/products/
        'intro',
        'pengertian',
        'kesimpulan',
        'ukuran_intro',
        'fungsi',
        'jenis',
        'keunggulan',
        'tabel_header',
        'tabel_data',
        'spesifikasi',
        'is_active',
    ];

    protected $casts = [
        'fungsi'       => 'array',
        'jenis'        => 'array',
        'keunggulan'   => 'array',
        'tabel_header' => 'array',
        'tabel_data'   => 'array',
        'spesifikasi'  => 'array',
        'is_active'    => 'boolean',
    ];

    // ── Boot: auto-generate slug ──────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        // Hapus file gambar lama saat produk dihapus
        static::deleting(function ($product) {
            $product->deleteImage();
        });
    }

    // ── Image Helpers ─────────────────────────────────────────

    /**
     * URL gambar produk.
     * Prioritas:
     *   1. Gambar upload dari storage (image field di DB)
     *   2. SVG ilustrasi default di public/images/products/{slug}.svg
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists('products/' . $this->image)) {
            return asset('storage/products/' . $this->image);
        }

        // Fallback ke SVG ilustrasi
        return asset('images/products/' . $this->slug . '.svg');
    }

    /**
     * Apakah produk punya gambar upload (bukan fallback SVG)?
     */
    public function hasUploadedImage(): bool
    {
        return $this->image && Storage::disk('public')->exists('products/' . $this->image);
    }

    /**
     * Hapus file gambar dari storage.
     */
    public function deleteImage(): void
    {
        if ($this->image) {
            Storage::disk('public')->delete('products/' . $this->image);
        }
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getUrlAttribute(): string
    {
        return url('/product/' . $this->slug);
    }
}