<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ReportToBandingRatioWidget extends BaseWidget
{
    // public int|string|array $columnSpan = 2;
    protected function getStats(): array

    {
        $totalReports = DB::table('reports')->count() +
            DB::table('reports_video')->count();

        $totalBandings = DB::table('bandings')->count() +
            DB::table('bandings_video')->count();

        $percentage = $totalReports > 0
            ? round(($totalBandings / $totalReports) * 100, 2)
            : 0;

        return [
            Stat::make('Persentase Banding', "{$percentage}%")
                ->description("Dari total $totalReports laporan")
                ->color($percentage > 30 ? 'danger' : ($percentage > 10 ? 'warning' : 'success')),
        ];
    }
}
