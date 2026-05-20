<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    // INI YANG MEMBUAT DROPDOWN SEPERTI MASTER DATA
    protected static ?string $navigationGroup = 'Manage Landing Page';
    protected static ?string $navigationLabel = 'Hero';
    protected static ?string $pluralModelLabel = 'Pengaturan Hero';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Teks Hero / Header')
                    ->description('Sesuaikan kalimat headline utama untuk landing page Anda.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Headline Utama (Baris 1)')
                            ->required(),
                            
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Headline Sekunder (Baris 2)')
                            ->required(),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Subtitle')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Gambar Grid Masonry')
                    ->description('Unggah 4 foto terbaik untuk mengisi grid zig-zag di halaman depan.')
                    ->schema([
                        Forms\Components\FileUpload::make('image_1')
                            ->label('Gambar 1 (Kiri Atas)')
                            ->image()
                            ->directory('hero-images')
                            ->required(),
                            
                        Forms\Components\FileUpload::make('image_2')
                            ->label('Gambar 2 (Kiri Bawah)')
                            ->image()
                            ->directory('hero-images')
                            ->required(),
                            
                        Forms\Components\FileUpload::make('image_3')
                            ->label('Gambar 3 (Kanan Atas)')
                            ->image()
                            ->directory('hero-images')
                            ->required(),
                            
                        Forms\Components\FileUpload::make('image_4')
                            ->label('Gambar 4 (Kanan Bawah)')
                            ->image()
                            ->directory('hero-images')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_1')
                    ->label('Preview Grid 1')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Headline Utama')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Headline Sekunder')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->badge()
                    ->color('info'),
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

    // Menambahkan tampilan View yang elegan
    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Tipografi Hero')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('title')
                            ->label('Headline Utama')
                            ->weight('bold')
                            ->size(\Filament\Infolists\Components\TextEntry\TextEntrySize::Large),
                            
                        \Filament\Infolists\Components\TextEntry::make('subtitle')
                            ->label('Headline Sekunder')
                            ->color('gray'),
                            
                        \Filament\Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Infolists\Components\Section::make('Susunan Masonry Grid')
                    ->schema([
                        // Baris Pertama (Atas)
                        \Filament\Infolists\Components\ImageEntry::make('image_1')
                            ->label('Gambar 1 (Kiri Atas)')
                            ->extraImgAttributes(['class' => 'rounded-xl shadow-lg']),
                            
                        \Filament\Infolists\Components\ImageEntry::make('image_3')
                            ->label('Gambar 3 (Kanan Atas)')
                            ->extraImgAttributes(['class' => 'rounded-xl shadow-lg']),

                        // Baris Kedua (Bawah)
                        \Filament\Infolists\Components\ImageEntry::make('image_2')
                            ->label('Gambar 2 (Kiri Bawah)')
                            ->extraImgAttributes(['class' => 'rounded-xl shadow-lg']),
                            
                        \Filament\Infolists\Components\ImageEntry::make('image_4')
                            ->label('Gambar 4 (Kanan Bawah)')
                            ->extraImgAttributes(['class' => 'rounded-xl shadow-lg']),
                    ])->columns(4),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}