<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Inventaris Alat';
    protected static ?string $pluralModelLabel = 'Inventaris Peralatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Spesifikasi Peralatan')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Alat atau Merek')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('category')
                            ->label('Kategori Alat')
                            ->options([
                                'Camera' => 'Kamera Utama',
                                'Lens' => 'Lensa Optik',
                                'Lighting' => 'Pencahayaan Studio',
                                'Audio' => 'Perekam Suara',
                                'Drone' => 'Pesawat Tanpa Awak',
                                'Accessories' => 'Aksesori Pendukung',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('serial_number')
                            ->label('Nomor Seri Pabrik')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Monitoring Kondisi')
                    ->schema([
                        Forms\Components\Select::make('condition')
                            ->label('Kondisi Fisik')
                            ->options([
                                'excellent' => 'Sangat Baik Mulus',
                                'good' => 'Baik Lecet Pemakaian',
                                'fair' => 'Cukup Butuh Perhatian',
                                'poor' => 'Buruk Rusak Ringan',
                            ])
                            ->default('excellent')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Ketersediaan')
                            ->options([
                                'available' => 'Tersedia di Gudang',
                                'maintenance' => 'Sedang Masa Perbaikan',
                                'broken' => 'Rusak Total',
                            ])
                            ->default('available')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Teknisi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Peralatan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('condition')
                    ->label('Kondisi Fisik')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'excellent' => 'success',
                        'good' => 'info',
                        'fair' => 'warning',
                        'poor' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Ketersediaan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'maintenance' => 'warning',
                        'broken' => 'danger',
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('Options')
                ->color('gray')
                ->icon('heroicon-m-chevron-down')
                ->button(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Aset Perusahaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Identitas Alat')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('category')
                            ->label('Jenis Kategori')
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('serial_number')
                            ->label('Nomor Seri Keamanan')
                            ->copyable()
                            ->icon('heroicon-m-qr-code'),
                    ])->columns(3),

                Infolists\Components\Section::make('Status Operasional')
                    ->schema([
                        Infolists\Components\TextEntry::make('condition')
                            ->label('Kondisi Fisik Saat Ini')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'excellent' => 'success',
                                'good' => 'info',
                                'fair' => 'warning',
                                'poor' => 'danger',
                            }),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Ketersediaan Gudang')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'available' => 'success',
                                'maintenance' => 'warning',
                                'broken' => 'danger',
                            }),

                        Infolists\Components\TextEntry::make('notes')
                            ->label('Catatan Riwayat Servis')
                            ->columnSpanFull()
                            ->default('Belum ada catatan masuk'),
                    ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}