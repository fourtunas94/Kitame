<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'user_id',
        'nik',
        'category',
        'kecamatan',
        'bio',
        'portfolio_url',
        'disnaker_certified',
        'is_published',
        'expertise',
    ];

    protected function casts(): array
    {
        return [
            'disnaker_certified' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolio()
    {
        return $this->hasMany(Portfolio::class);
    }
}
