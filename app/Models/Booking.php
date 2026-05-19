<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'booking_date',
        'location',
        'status',
        'payment_status',
        'notes',
    ];

    // Mengatur relasi balik ke model Client
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Mengatur relasi balik ke model Service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Mengatur hubungan bahwa satu pemesanan bisa melibatkan banyak kru tim
    public function crews(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Crew::class);
    }

    public function invoices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    // Mengatur hubungan bahwa satu pemesanan bisa meminjam banyak alat
    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Equipment::class);
    }
}