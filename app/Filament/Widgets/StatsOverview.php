<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Booking;
use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Mengurutkan widget ini agar tampil paling atas
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Menghitung akumulasi data dari database
        $revenue = Invoice::where('status', 'paid')->sum('amount');
        $pending = Invoice::where('status', 'unpaid')->sum('amount');
        $activeProjects = Booking::whereIn('status', ['confirmed', 'ongoing'])->count();
        $totalClients = Client::count();

        return [
            Stat::make('Total Pendapatan Bersih', 'Rp ' . number_format($revenue, 0, ',', '.'))
                ->description('Dari tagihan berstatus lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Piutang Tertunda', 'Rp ' . number_format($pending, 0, ',', '.'))
                ->description('Menunggu pembayaran klien')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
                
            Stat::make('Proyek Aktif', $activeProjects)
                ->description('Pemesanan sedang berjalan')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),
                
            Stat::make('Total Klien', $totalClients)
                ->description('Database pelanggan terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}