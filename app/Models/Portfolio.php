<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    protected $fillable = [
        'talent_id',
        'title',
        'description',
        'link',
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
