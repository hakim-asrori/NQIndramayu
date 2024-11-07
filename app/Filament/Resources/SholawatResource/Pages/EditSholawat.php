<?php

namespace App\Filament\Resources\SholawatResource\Pages;

use App\Filament\Resources\SholawatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSholawat extends EditRecord
{
    protected static string $resource = SholawatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
