<?php

namespace App\Filament\Resources\ReportVideoResource\Pages;

use App\Filament\Resources\ReportVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportVideo extends EditRecord
{
    protected static string $resource = ReportVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
