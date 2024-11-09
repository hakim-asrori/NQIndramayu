<?php

namespace App\Filament\Resources\DoaCategoryResource\Pages;

use App\Filament\Resources\DoaCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoaCategories extends ListRecords
{
    protected static string $resource = DoaCategoryResource::class;

    protected static ?string $title = 'Doa Category';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label("New category"),
        ];
    }
}
