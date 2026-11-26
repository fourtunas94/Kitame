<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UmkmProduct extends Model
{
    use HasFactory;

    protected $table = 'umkm_products';

    protected $fillable = [
        'umkm_id',
        'name',
        'description',
        'image',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }
}
