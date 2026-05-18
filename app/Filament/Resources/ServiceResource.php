<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    // Mengatur ikon dan label pada menu navigasi samping
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Layanan & Paket';
    protected static ?string $pluralModelLabel = 'Layanan & Paket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Membagi form menjadi dua bagian utama yaitu kiri dan kanan
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Utama')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Paket')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    // Membuat slug otomatis setelah pengguna mengetik nama paket
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Service::class, 'slug', ignoreRecord: true),

                                Forms\Components\RichEditor::make('description')
                                    ->label('Deskripsi Layanan')
                                    ->toolbarButtons([
                                        'bold', 'italic', 'bulletList', 'orderedList', 'link', 'h2', 'h3',
                                    ])
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Detail Harga & Output')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga Paket')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp'),

                                Forms\Components\TagsInput::make('deliverables')
                                    ->label('Deliverables')
                                    ->placeholder('Ketik lalu tekan Enter')
                                    ->helperText('Daftar output yang akan diberikan kepada klien')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                // Bagian kanan untuk pengaturan visual dan status aktif
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Visual & Status')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->label('Cover Paket')
                                    ->image()
                                    ->directory('services')
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Cover')
                    ->circular()
                    // Menampilkan inisial otomatis dari layanan pihak ketiga jika gambar belum diunggah
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=random&color=fff&size=128'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Area untuk menambahkan filter tabel di masa depan
            ])
            ->actions([
                // Menggabungkan aksi menjadi satu tombol dropdown berwarna abu abu
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('Options')
                ->color('gray')
                ->icon('heroicon-m-chevron-down')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Mengatur tampilan detail atau infolist agar lebih elegan dan terstruktur
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Layanan')
                    ->schema([
                        // Membagi tata letak menjadi tiga kolom untuk bagian header
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\Group::make([
                                    Infolists\Components\ImageEntry::make('thumbnail')
                                        ->hiddenLabel()
                                        ->circular()
                                        ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=random&color=fff&size=256')
                                        ->size(120),
                                ])->columnSpan(1),

                                // Menampilkan nama harga dan status di sebelah kanan gambar
                                Infolists\Components\Group::make([
                                    Infolists\Components\TextEntry::make('name')
                                        ->hiddenLabel()
                                        ->weight('bold')
                                        ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                                    Infolists\Components\Grid::make(2)
                                        ->schema([
                                            Infolists\Components\TextEntry::make('price')
                                                ->label('Harga Paket')
                                                ->money('IDR', locale: 'id')
                                                ->badge()
                                                ->color('success'),

                                            Infolists\Components\IconEntry::make('is_active')
                                                ->label('Status Aktif')
                                                ->boolean(),
                                        ]),
                                ])->columnSpan(2),
                            ]),
                    ]),

                // Memisahkan deskripsi ke dalam blok tersendiri agar mudah dibaca
                Infolists\Components\Section::make('Deskripsi Tambahan')
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->hiddenLabel()
                            ->html()
                            ->columnSpanFull(),
                    ]),

                // Menampilkan daftar output klien menggunakan format list
                Infolists\Components\Section::make('Deliverables Output Client')
                    ->schema([
                        Infolists\Components\TextEntry::make('deliverables')
                            ->hiddenLabel()
                            ->bulleted()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tempat mendaftarkan relasi antar tabel
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}