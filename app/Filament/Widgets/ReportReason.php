<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ReportReason extends ChartWidget
{
    protected static ?string $heading = 'Alasan Laporan Terbanyak';
    // public int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        // Ambil data dari dua tabel dan gabungkan
        $bandings = DB::table('bandings')
            ->select('report_reason');

        $bandingsVideo = DB::table('bandings_video')
            ->select('report_reason');

        // Union data keduanya
        $combined = $bandings->unionAll($bandingsVideo);

        // Bungkus union sebagai subquery lalu hitung jumlahnya
        $data = DB::table(DB::raw("({$combined->toSql()}) as combined"))
            ->mergeBindings($combined) // Penting untuk binding param
            ->select('report_reason', DB::raw('count(*) as total'))
            ->groupBy('report_reason')
            ->orderByDesc('total')
            ->get();

        $labels = $data->pluck('report_reason');
        $counts = $data->pluck('total');

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Laporan',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#0C0950',
                        '#161179',
                        '#261FB3',
                        '#4D55CC',
                        '#FBE4D6',
                    ],
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected static ?string $pollingInterval = null;
}
