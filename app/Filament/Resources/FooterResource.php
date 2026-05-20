<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterResource\Pages;
use App\Models\Footer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';
    
    // Gabungkan dengan grup yang sama
    protected static ?string $navigationGroup = 'Manage Landing Page';
    protected static ?string $navigationLabel = 'Footer & Kontak';
    protected static ?string $pluralModelLabel = 'Pengaturan Footer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Teks Utama')
                            ->description('Teks yang akan tampil di bagian paling bawah website.')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Teks Raksasa (Brand)')
                                    ->required()
                                    ->default('Frame Base')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Singkat')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('copyright')
                                    ->label('Teks Hak Cipta (Tanpa Tahun)')
                                    ->helperText('Contoh: Frame Base. Hak Cipta Dilindungi. (Tahun akan otomatis dibuat oleh sistem)')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Tautan Media Sosial')
                            ->description('Kosongkan jika tidak ingin menonaktifkan ikon di halaman depan.')
                            ->schema([
                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),
                                    
                                Forms\Components\TextInput::make('whatsapp_url')
                                    ->label('WhatsApp URL')
                                    ->url()
                                    ->helperText('Gunakan format wa.me/628xxx')
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('tiktok_url')
                                    ->label('TikTok URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->helperText('Contoh: halo@framebase.com')
                                    ->prefixIcon('heroicon-o-envelope'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Brand Name')
                    ->weight('bold')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            // Menghilangkan opsi delete massal agar footer utama tidak sengaja terhapus
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooters::route('/'),
            'create' => Pages\CreateFooter::route('/create'),
            'edit' => Pages\EditFooter::route('/{record}/edit'),
        ];
    }

    // TRIK SENIOR: Hanya izinkan tombol "Create" jika belum ada data Footer di database.
    public static function canCreate(): bool
    {
        return Footer::count() === 0;
    }
}