<?php

namespace App\Filament\Resources\BandingResource\Pages;

use App\Filament\Resources\BandingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBandings extends ListRecords
{
    protected static string $resource = BandingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
