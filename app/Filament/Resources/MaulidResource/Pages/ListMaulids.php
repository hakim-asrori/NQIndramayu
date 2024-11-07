<?php

namespace App\Filament\Resources\MaulidResource\Pages;

use App\Filament\Resources\MaulidResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaulids extends ListRecords
{
    protected static string $resource = MaulidResource::class;

    protected static ?string $title = 'Maulid';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
