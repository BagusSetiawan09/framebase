<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Galeri Portofolio';
    protected static ?string $pluralModelLabel = 'Galeri Portofolio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Proyek Portofolio')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Karya Portofolio')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL Otomatis')
                                    ->required()
                                    ->unique(Portfolio::class, 'slug', ignoreRecord: true),

                                Forms\Components\RichEditor::make('description')
                                    ->label('Narasi atau Cerita di Balik Karya')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Aset Visual Resolusi Tinggi')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->label('Unggah Koleksi Foto Proyek')
                                    ->image()
                                    ->multiple() // Memungkinkan unggah banyak foto sekaligus
                                    ->reorderable()
                                    ->appendFiles()
                                    ->directory('portfolios')
                                    ->helperText('Unggah aset visual terbaik untuk ditampilkan di halaman depan'),

                                Forms\Components\TextInput::make('video_url')
                                    ->label('Tautan Video Portofolio')
                                    ->placeholder('Tautan YouTube atau Vimeo')
                                    ->url(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Klasifikasi Karya')
                            ->schema([
                                Forms\Components\Select::make('service_id')
                                    ->label('Kategori Layanan')
                                    ->relationship('service', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('client_id')
                                    ->label('Klien Terkait')
                                    ->relationship('client', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Opsional jika proyek ini adalah milik klien tertentu'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Preview')
                    ->circular()
                    ->stacked() // Menampilkan tumpukan gambar agar terlihat estetik di tabel
                    ->limit(3),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Proyek')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('Klien')
                    ->default('Internal Project'),
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
                Infolists\Components\Section::make('Detail Karya Visual')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->label('Judul Proyek Portofolio')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('service.name')
                            ->label('Kategori Layanan')
                            ->badge(),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi Karya')
                            ->html()
                            ->columnSpanFull(),
                    ])->columns(2),

                Infolists\Components\Section::make('Koleksi Aset Foto')
                    ->schema([
                        Infolists\Components\ImageEntry::make('images')
                            ->hiddenLabel()
                            ->size(200)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}