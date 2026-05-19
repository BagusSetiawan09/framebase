<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class ProjectStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Rasio Status Proyek';
    protected static ?int $sort = 3;
    
    // PERBAIKAN 1: Gunakan maxHeight untuk Filament v3
    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Proyek',
                    'data' => [
                        Booking::where('status', 'pending')->count(),
                        Booking::where('status', 'confirmed')->count(),
                        Booking::where('status', 'ongoing')->count(),
                        Booking::where('status', 'post_production')->count(),
                        Booking::where('status', 'completed')->count(),
                    ],
                    'backgroundColor' => [
                        '#9ca3af',
                        '#3b82f6',
                        '#f59e0b',
                        '#8b5cf6',
                        '#10b981',
                    ],
                ],
            ],
            'labels' => ['Pending DP', 'Terkonfirmasi', 'Pelaksanaan', 'Editing', 'Selesai'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    // PERBAIKAN 2: Matikan paksa garis sumbu X dan Y yang membuat chart meregang
    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }
}