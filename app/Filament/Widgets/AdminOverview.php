<?php

namespace App\Filament\Widgets;

use App\Models\Banding;
use App\Models\Banding_Video;
use App\Models\Post;
use App\Models\Report;
use App\Models\Report_Video;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Jumlah User', User::where('role', 'user')->count())
                ->description('Total user yang terdaftar')
                ->icon('heroicon-o-users'),

            Card::make('Jumlah Admin', User::where('role', 'admin')->count())
                ->description('Total admin yang terdaftar')
                ->icon('heroicon-o-adjustments-horizontal'),

            Card::make('Total Konten Foto', Post::count())
                ->description('Total semua konten Foto')
                ->icon('heroicon-o-camera'),

            Card::make('Total Konten Video', Video::count())
                ->description('Total semua konten Video')
                ->icon('heroicon-o-video-camera'),

            Card::make('Total Tag Foto', Tag::count())
                ->description('Total semua tag foto')
                ->icon('heroicon-o-tag'),

            Card::make('Jumlah Report Foto', Report::count())
                ->description('Total Report dari Postingan Foto')
                ->icon('heroicon-o-flag')
                ->url('/admin/reports', true),

            Card::make('Jumlah Report Video', Report_Video::count())
                ->description('Total Report dari Postingan Video')
                ->icon('heroicon-o-flag')
                ->url('/admin/report-videos', true),

            Card::make('Jumlah Banding Foto', Banding::count())
                ->description('Total Banding dari Report Foto')
                ->icon('heroicon-o-wrench-screwdriver')
                ->url('/admin/bandings', true),

            Card::make('Jumlah Banding Video', Banding_Video::count())
                ->description('Total Banding dari Report Video')
                ->icon('heroicon-o-wrench-screwdriver')
                ->url('/admin/banding-videos', true),
        ];
    }
}
