<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class FinancialChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pendapatan Bulanan';
    protected static ?int $sort = 2;
    
    // TAMBAHKAN BARIS INI: Mengatur tinggi kanvas chart agar seragam
    protected static ?string $chartHeight = '280px';

    protected function getData(): array
    {
        // ... (Kode untuk mengambil data tetap sama, tidak perlu diubah)
        $data = [];
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->translatedFormat('M');
            $data[] = Invoice::where('status', 'paid')
                             ->whereMonth('created_at', $i)
                             ->whereYear('created_at', date('Y'))
                             ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Lunas (Rp)',
                    'data' => $data,
                    'fill' => 'start',
                    'borderColor' => '#10b981', 
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                ],
            ],
            'labels' => $months,
        ];
        // ...
    }

    protected function getType(): string
    {
        return 'line';
    }
}