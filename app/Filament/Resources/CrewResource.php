<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewResource\Pages;
use App\Models\Crew;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class CrewResource extends Resource
{
    protected static ?string $model = Crew::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Kru & Fotografer';
    protected static ?string $pluralModelLabel = 'Kru & Fotografer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Biodata Anggota Tim')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Spesialisasi Peran')
                            ->options([
                                'Lead Photographer' => 'Lead Photographer',
                                'Assistant Photographer' => 'Assistant Photographer',
                                'Videographer Cinematic' => 'Videographer Cinematic',
                                'Drone Pilot' => 'Drone Pilot Aerial',
                                'Editor Visual' => 'Editor Visual Pasca Produksi',
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Otorisasi')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor WhatsApp Aktif')
                            ->required()
                            ->tel(),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Ketersediaan Tim')
                            ->default(true),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Spesialisasi')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('WhatsApp')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Tersedia')
                    ->boolean(),
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
                Infolists\Components\Section::make('Informasi Lengkap Anggota')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nama Lengkap')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('role')
                            ->label('Spesialisasi Kerja')
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('phone')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-m-phone'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Email Resmi')
                            ->icon('heroicon-m-envelope')
                            ->default('Tidak ada email terdaftar'),

                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Keaktifan')
                            ->boolean(),
                    ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCrews::route('/'),
            'create' => Pages\CreateCrew::route('/create'),
            'edit' => Pages\EditCrew::route('/{record}/edit'),
        ];
    }
}