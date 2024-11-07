<?php

namespace App\Filament\Resources\MaulidResource\Pages;

use App\Filament\Resources\MaulidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaulid extends EditRecord
{
    protected static string $resource = MaulidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
