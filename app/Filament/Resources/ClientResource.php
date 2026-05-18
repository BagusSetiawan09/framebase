<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    // Mengatur ikon dan label pada menu navigasi
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Klien & Pelanggan';
    protected static ?string $pluralModelLabel = 'Klien & Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Profil')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap atau PIC')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Perusahaan atau Brand')
                            ->maxLength(255)
                            ->placeholder('Kosongkan jika klien personal'),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Alamat')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor WhatsApp')
                            ->required()
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->unique(Client::class, 'email', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('company_name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->default('Personal'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('WhatsApp')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Area untuk menambahkan filter tabel
            ])
            ->actions([
                // Mempertahankan desain tombol opsi yang sudah kita sepakati sebelumnya
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

    // Mengatur tampilan detail klien saat tombol View diklik
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Detail Profil Klien')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nama Lengkap')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('company_name')
                            ->label('Perusahaan atau Brand')
                            ->badge()
                            ->color('info')
                            ->default('Klien Personal'),
                    ])->columns(2),

                Infolists\Components\Section::make('Informasi Kontak dan Alamat')
                    ->schema([
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Nomor WhatsApp')
                            ->icon('heroicon-m-phone'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Alamat Email')
                            ->icon('heroicon-m-envelope'),

                        Infolists\Components\TextEntry::make('address')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                    ])->columns(2),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}