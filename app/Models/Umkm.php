<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'user_id',
        'nib',
        'business_name',
        'category',
        'kecamatan',
        'address',
        'description',
        'e_catalog_pemko',
        'is_published',
        'cover_image',
        'logo',
        'whatsapp',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'e_catalog_pemko' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(UmkmProduct::class);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->cover_image);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->imageUrl($this->logo);
    }

    private function imageUrl(?string $image): ?string
    {
        if (! $image) {
            return null;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return Storage::disk('public')->url($image);
    }
}
