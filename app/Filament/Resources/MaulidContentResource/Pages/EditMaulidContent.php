<?php

namespace App\Filament\Resources\MaulidContentResource\Pages;

use App\Filament\Resources\MaulidContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaulidContent extends EditRecord
{
    protected static string $resource = MaulidContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
