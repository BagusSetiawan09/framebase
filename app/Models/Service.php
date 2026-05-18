<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'deliverables',
        'thumbnail',
        'is_active',
    ];

    protected $casts = [
        'deliverables' => 'array', // Casting JSON ke Array otomatis
    ];
}
