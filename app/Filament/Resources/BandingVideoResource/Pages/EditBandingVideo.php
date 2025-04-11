<?php

namespace App\Filament\Resources\BandingVideoResource\Pages;

use App\Filament\Resources\BandingVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBandingVideo extends EditRecord
{
    protected static string $resource = BandingVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
