<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Pemesanan Jasa';
    protected static ?string $pluralModelLabel = 'Pemesanan Jasa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hubungan Transaksi')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->label('Pilih Klien')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('service_id')
                            ->relationship('service', 'name')
                            ->label('Pilih Paket Layanan')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('crews')
                            ->relationship('crews', 'name')
                            ->label('Tugaskan Kru Lapangan')
                            ->multiple() // Mengizinkan memilih banyak kru sekaligus
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),

                        // Memilih inventaris alat yang akan digunakan ke lokasi
                        Forms\Components\Select::make('equipment')
                            ->relationship('equipment', 'name')
                            ->label('Booking Inventaris Alat')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pelaksanaan')
                    ->schema([
                        Forms\Components\DatePicker::make('booking_date')
                            ->label('Tanggal Acara')
                            ->required(),

                        Forms\Components\Textarea::make('location')
                            ->label('Lokasi Pelaksanaan')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Khusus'),
                    ])->columns(1),

                Forms\Components\Section::make('Status Keuangan dan Proyek')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Alur Kerja')
                            ->options([
                                'pending' => 'Pending Menunggu DP',
                                'confirmed' => 'Confirmed Jadwal Terkunci',
                                'ongoing' => 'On Going Pelaksanaan Lapangan',
                                'post_production' => 'Post Production Proses Editing',
                                'completed' => 'Completed Selesai Penyerahan',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Unpaid Belum Bayar',
                                'partial' => 'Partial Sudah DP',
                                'paid' => 'Paid Lunas',
                            ])
                            ->default('unpaid')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Paket Layanan')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

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

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        'paid' => 'success',
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    
                    // Tombol Kustom Follow Up WhatsApp (Versi Enterprise & Detail)
                    Tables\Actions\Action::make('whatsapp_followup')
                        ->label('Follow Up WA')
                        ->icon('heroicon-m-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(function (Booking $record) {
                            $phone = $record->client->phone ?? '';
                            
                            // Logika mengubah awalan 0 menjadi 62
                            if (str_starts_with($phone, '0')) {
                                $phone = '62' . substr($phone, 1);
                            }
                            
                            $clientName = $record->client->name ?? 'Bapak/Ibu';
                            $serviceName = $record->service->name ?? 'Layanan Visual';
                            
                            // Mengubah format tanggal menjadi rapi (Contoh: 15 Juni 2026)
                            $bookingDate = \Carbon\Carbon::parse($record->booking_date)->translatedFormat('d F Y');
                            
                            // Menerjemahkan status sistem menjadi bahasa manusia yang sopan
                            $statusMap = [
                                'pending' => 'Menunggu Pembayaran (DP)',
                                'confirmed' => 'Jadwal Terkonfirmasi',
                                'ongoing' => 'Persiapan / Pelaksanaan Lapangan',
                                'post_production' => 'Proses Editing (Post-Production)',
                                'completed' => 'Selesai & Penyerahan File',
                            ];
                            $statusText = $statusMap[$record->status] ?? 'Sedang Diproses';
                            
                            // Meracik kalimat korporat yang detail dan elegan (Versi Teks Aman)
                            $text = "Halo Bapak/Ibu {$clientName}, salam hangat dari FrameBase.\n\n"
                                  . "Perkenalkan, kami dari Tim Operasional. Kami ingin mengonfirmasi bahwa pesanan Anda telah terdaftar di sistem kami dengan rincian sebagai berikut:\n\n"
                                  . "- *Layanan*: {$serviceName}\n"
                                  . "- *Tanggal Acara*: {$bookingDate}\n"
                                  . "- *Status Saat Ini*: {$statusText}\n\n"
                                  . "Untuk memastikan kelancaran jalannya proyek, apakah ada *brief* khusus, referensi visual, atau detail teknis lain yang ingin didiskusikan lebih lanjut bersama tim kami?\n\n"
                                  . "Terima kasih atas kepercayaan Anda. Kami berkomitmen memberikan hasil visual yang maksimal.";
                            
                            return 'https://wa.me/' . $phone . '?text=' . urlencode($text);
                        })
                        ->openUrlInNewTab(),
                        
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('Options')
                ->color('gray')
                ->icon('heroicon-m-chevron-down')
                ->button(),
            ]);
    }

    // Mengatur tampilan View khusus menggunakan Infolist
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Inti Pesanan')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('client.name')
                                    ->label('Klien Pelanggan')
                                    ->weight('bold')
                                    ->icon('heroicon-m-user'),

                                Infolists\Components\TextEntry::make('service.name')
                                    ->label('Layanan Yang Dipilih')
                                    ->weight('bold')
                                    ->icon('heroicon-m-sparkles'),

                                Infolists\Components\TextEntry::make('booking_date')
                                    ->label('Tanggal Pelaksanaan')
                                    ->date('l, d F Y')
                                    ->color('primary'),

                                Infolists\Components\TextEntry::make('service.price')
                                    ->label('Nilai Kontrak')
                                    ->money('IDR', locale: 'id')
                                    ->badge()
                                    ->color('success'),

                                Infolists\Components\TextEntry::make('crews.name')
                                    ->label('Tim Kru Yang Bertugas')
                                    ->badge()
                                    ->color('gray')
                                    ->columnSpanFull(),

                                Infolists\Components\TextEntry::make('equipment.name')
                                    ->label('Peralatan Yang Dipinjam')
                                    ->badge()
                                    ->color('info')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Infolists\Components\Grid::make(3)
                    ->schema([
                        Infolists\Components\Section::make('Status Logistik')
                            ->schema([
                                Infolists\Components\TextEntry::make('location')
                                    ->label('Lokasi Detail')
                                    ->icon('heroicon-m-map-pin'),

                                Infolists\Components\TextEntry::make('notes')
                                    ->label('Catatan Brief')
                                    ->placeholder('Tidak ada catatan khusus'),
                            ])->columnSpan(2),

                        Infolists\Components\Section::make('Indikator Status')
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Proses Kerja')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'gray',
                                        'confirmed' => 'info',
                                        'ongoing' => 'warning',
                                        'post_production' => 'primary',
                                        'completed' => 'success',
                                    }),

                                Infolists\Components\TextEntry::make('payment_status')
                                    ->label('Kondisi Keuangan')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'unpaid' => 'danger',
                                        'partial' => 'warning',
                                        'paid' => 'success',
                                    }),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}