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
        'is_featured',
    ];

    protected $casts = [
        'fungsi'       => 'array',
        'jenis'        => 'array',
        'keunggulan'   => 'array',
        'tabel_header' => 'array',
        'tabel_data'   => 'array',
        'spesifikasi'  => 'array',
        'is_active'    => 'boolean',
        'is_featured' => 'boolean',
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
        if ($this->hasUploadedImage()) {
            return asset('storage/products/' . $this->image);
        }
        
        // Fallback ke SVG default
        return asset('images/products/' . $this->slug . '.svg');
    }

    /**
     * Apakah produk punya gambar upload (bukan fallback SVG)?
     */
    // app/Models/Product.php
    public function hasUploadedImage(): bool
    {
        if (empty($this->image)) {
            return false;
        }
        
        $path = storage_path('app/public/products/' . $this->image);
        return file_exists($path);
    }

    public function deleteImage(): void
    {
        if ($this->hasUploadedImage()) {
            $path = storage_path('app/public/products/' . $this->image);
            if (file_exists($path)) {
                unlink($path);
                \Log::info('Image deleted: ' . $path);
            }
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