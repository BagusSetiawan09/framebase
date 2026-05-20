<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    
    // Memasukkan ke dalam folder Manage Landing Page bersama Hero
    protected static ?string $navigationGroup = 'Manage Landing Page';
    protected static ?string $navigationLabel = 'Testimonial';
    protected static ?string $pluralModelLabel = 'Pengaturan Testimonial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Klien & Testimoni')
                    ->description('Pilih tipe klien untuk menyesuaikan tampilan kartu di halaman depan.')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipe Klien (Gaya Kartu)')
                            ->options([
                                'company' => 'Perusahaan B2B (Kartu Hitam)',
                                'personal' => 'Personal B2C (Kartu Putih)',
                            ])
                            ->required()
                            ->live() // Kunci agar form di bawahnya bisa bereaksi secara real-time
                            ->default('personal'),

                        // Kolom ini HANYA MUNCUL jika type = company
                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->placeholder('Contoh: ZEVAN SPAREPART')
                            ->visible(fn (Get $get) => $get('type') === 'company')
                            ->required(fn (Get $get) => $get('type') === 'company'),

                        Forms\Components\TextInput::make('client_name')
                            ->label('Nama Lengkap Klien')
                            ->placeholder('Contoh: Bagus Setiawan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('role')
                            ->label(fn (Get $get) => $get('type') === 'company' ? 'Jabatan di Perusahaan' : 'Layanan yang Dipesan')
                            ->placeholder(fn (Get $get) => $get('type') === 'company' ? 'Contoh: CEO, Zevan Sparepart' : 'Contoh: Wedding Royal Platinum')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('quote')
                            ->label('Isi Testimoni')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('Foto Klien (Avatar)')
                            ->image()
                            ->directory('testimonials')
                            ->avatar()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->client_name) . '&background=random'),
                
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->weight('bold'),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe Kartu')
                    ->colors([
                        'danger' => 'company',
                        'success' => 'personal',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'company' => 'Kartu Hitam',
                        'personal' => 'Kartu Putih',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('role')
                    ->label('Peran / Layanan')
                    ->searchable(),
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
                Infolists\Components\Section::make('Profil Klien')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                // Kolom Kiri: Menampilkan Avatar Besar
                                Infolists\Components\Group::make([
                                    Infolists\Components\ImageEntry::make('avatar')
                                        ->hiddenLabel()
                                        ->circular()
                                        ->size(120)
                                        ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->client_name) . '&background=random'),
                                ])->columnSpan(1),

                                // Kolom Kanan: Menampilkan Data Diri
                                Infolists\Components\Group::make([
                                    Infolists\Components\TextEntry::make('client_name')
                                        ->hiddenLabel()
                                        ->weight('bold')
                                        ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
                                        
                                    Infolists\Components\TextEntry::make('role')
                                        ->hiddenLabel()
                                        ->color('gray')
                                        ->extraAttributes(['class' => 'mb-4']),

                                    Infolists\Components\Grid::make(2)
                                        ->schema([
                                            Infolists\Components\TextEntry::make('type')
                                                ->label('Tipe Klien')
                                                ->badge()
                                                ->formatStateUsing(fn (string $state): string => match ($state) {
                                                    'company' => 'Perusahaan B2B',
                                                    'personal' => 'Personal B2C',
                                                    default => $state,
                                                })
                                                ->color(fn (string $state): string => match ($state) {
                                                    'company' => 'danger',
                                                    'personal' => 'success',
                                                    default => 'gray',
                                                }),

                                            Infolists\Components\TextEntry::make('company_name')
                                                ->label('Nama Perusahaan')
                                                ->visible(fn ($record) => $record->type === 'company')
                                                ->weight('bold')
                                                ->color('primary'),
                                        ]),
                                ])->columnSpan(2),
                            ]),
                    ]),

                Infolists\Components\Section::make('Isi Ulasan Testimoni')
                    ->schema([
                        Infolists\Components\TextEntry::make('quote')
                            ->hiddenLabel()
                            ->html() // Mengizinkan tag HTML agar bisa dimodifikasi
                            ->formatStateUsing(fn (string $state): string => '<span class="italic text-lg text-white leading-relaxed">" ' . $state . ' "</span>')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}