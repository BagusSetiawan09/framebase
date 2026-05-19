<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookings extends BaseWidget
{
    protected static ?int $sort = 4;
    
    // Membuat tabel membentang memenuhi lebar layar
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            // Mengambil 5 data pemesanan terakhir yang masuk
            ->query(Booking::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Nama Klien')
                    ->weight('bold')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Paket Layanan')
                    ->limit(40),
                    
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y'),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Kerja')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'confirmed' => 'info',
                        'ongoing' => 'warning',
                        'post_production' => 'primary',
                        'completed' => 'success',
                    }),
            ])
            ->paginated(false); // Mematikan pagination karena hanya menampilkan 5 teratas
    }
}