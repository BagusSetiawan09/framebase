<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionSettingResource\Pages;
use App\Models\SectionSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectionSettingResource extends Resource
{
    protected static ?string $model = SectionSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    // Gabungkan dengan grup Manage Landing Page
    protected static ?string $navigationGroup = 'Manage Landing Page';
    protected static ?string $navigationLabel = 'Teks Section';
    protected static ?string $pluralModelLabel = 'Pengaturan Teks Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan Teks per Seksi')
                    ->tabs([
                        // Tab Layanan
                        Forms\Components\Tabs\Tab::make('Seksi Layanan')
                            ->icon('heroicon-m-squares-2x2')
                            ->schema([
                                Forms\Components\TextInput::make('services_title')
                                    ->label('Judul Layanan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('services_subtitle')
                                    ->label('Sub-judul Layanan')
                                    ->rows(3)
                                    ->required(),
                            ]),
                            
                        // Tab Portofolio
                        Forms\Components\Tabs\Tab::make('Seksi Portofolio')
                            ->icon('heroicon-m-camera')
                            ->schema([
                                Forms\Components\TextInput::make('portfolio_title_white')
                                    ->label('Judul Utama (Teks Hitam Tebal)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('portfolio_title_gray')
                                    ->label('Judul Sekunder (Teks Abu-abu)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('portfolio_subtitle')
                                    ->label('Sub-judul Portofolio')
                                    ->rows(3)
                                    ->required(),
                            ]),

                        // Tab Testimonial
                        Forms\Components\Tabs\Tab::make('Seksi Testimonial')
                            ->icon('heroicon-m-chat-bubble-bottom-center-text')
                            ->schema([
                                Forms\Components\TextInput::make('testimonial_title')
                                    ->label('Judul Testimonial')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Gunakan tag <br> jika ingin teks turun ke baris bawah.'),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('services_title')
                    ->label('Judul Layanan'),
                Tables\Columns\TextColumn::make('portfolio_title_white')
                    ->label('Judul Portofolio'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSectionSettings::route('/'),
            'create' => Pages\CreateSectionSetting::route('/create'),
            'edit' => Pages\EditSectionSetting::route('/{record}/edit'),
        ];
    }

    // TRIK SENIOR: Hanya bisa create jika tabel masih kosong
    public static function canCreate(): bool
    {
        return SectionSetting::count() === 0;
    }
}