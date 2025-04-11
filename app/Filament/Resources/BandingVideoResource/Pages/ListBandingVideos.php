<?php

namespace App\Filament\Resources\BandingVideoResource\Pages;

use App\Filament\Resources\BandingVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBandingVideos extends ListRecords
{
    protected static string $resource = BandingVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
