<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Str;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Tagihan Keuangan';
    protected static ?string $pluralModelLabel = 'Tagihan Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Utama Tagihan')
                            ->schema([
                                Forms\Components\Select::make('booking_id')
                                    ->label('Pilih ID Pemesanan')
                                    ->relationship('booking', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "Pesanan #{$record->id} Klien " . ($record->client->name ?? 'Unknown'))
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\TextInput::make('invoice_number')
                                    ->label('Nomor Tagihan')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->default('INV' . strtoupper(Str::random(6))),

                                Forms\Components\TextInput::make('amount')
                                    ->label('Nominal Tagihan')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp'),
                            ])->columns(2),

                        Forms\Components\Section::make('Catatan Tambahan')
                            ->schema([
                                Forms\Components\Textarea::make('notes')
                                    ->label('Keterangan Pembayaran')
                                    ->placeholder('Misal Tagihan Uang Muka 30 Persen')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status dan Tanggal')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'unpaid' => 'Belum Dibayar',
                                        'paid' => 'Lunas Dibayar',
                                        'cancelled' => 'Dibatalkan',
                                    ])
                                    ->default('unpaid')
                                    ->required(),

                                Forms\Components\DatePicker::make('due_date')
                                    ->label('Tenggat Waktu')
                                    ->required(),

                                Forms\Components\FileUpload::make('payment_proof')
                                    ->label('Bukti Transfer')
                                    ->image()
                                    ->directory('invoices')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Nomor Tagihan')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('booking.client.name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_date')
                    ->label('Tenggat Waktu')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                        'cancelled' => 'gray',
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
                Infolists\Components\Section::make('Detail Tagihan Klien')
                    ->schema([
                        Infolists\Components\TextEntry::make('invoice_number')
                            ->label('Nomor Tagihan Resmi')
                            ->weight('bold')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('booking.client.name')
                            ->label('Tagihan Kepada')
                            ->icon('heroicon-m-user'),

                        Infolists\Components\TextEntry::make('amount')
                            ->label('Total Pembayaran')
                            ->money('IDR', locale: 'id')
                            ->badge()
                            ->color('success'),

                        Infolists\Components\TextEntry::make('status')
                            ->label('Status Saat Ini')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'unpaid' => 'danger',
                                'paid' => 'success',
                                'cancelled' => 'gray',
                            }),

                        Infolists\Components\TextEntry::make('due_date')
                            ->label('Jatuh Tempo Pada')
                            ->date('d F Y'),
                    ])->columns(2),

                Infolists\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Infolists\Components\ImageEntry::make('payment_proof')
                            ->hiddenLabel()
                            ->size(300)
                            ->defaultImageUrl('https://ui-avatars.com/api/?name=No+Proof&background=random&color=fff&size=300')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}