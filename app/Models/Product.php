<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'icon',
        'subtitle',
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

    // ── Auto-generate slug ────────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ── Scopes ────────────────────────────────────────────────
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