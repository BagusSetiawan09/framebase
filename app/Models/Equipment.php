<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'serial_number',
        'condition',
        'status',
        'notes',
    ];

    // Mengatur hubungan timbal balik ke model pemesanan
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }
}