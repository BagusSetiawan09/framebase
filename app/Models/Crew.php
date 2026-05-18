<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crew extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'phone',
        'email',
        'is_active',
    ];

    // Mengatur hubungan timbal balik ke model booking
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }
}