<?php

namespace App\Filament\Resources\SholawatResource\Pages;

use App\Filament\Resources\SholawatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSholawats extends ListRecords
{
    protected static string $resource = SholawatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
