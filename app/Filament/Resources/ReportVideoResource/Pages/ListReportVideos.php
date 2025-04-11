<?php

namespace App\Filament\Resources\ReportVideoResource\Pages;

use App\Filament\Resources\ReportVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportVideos extends ListRecords
{
    protected static string $resource = ReportVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
