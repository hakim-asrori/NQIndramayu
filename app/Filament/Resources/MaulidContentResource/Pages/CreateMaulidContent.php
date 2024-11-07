<?php

namespace App\Filament\Resources\MaulidContentResource\Pages;

use App\Filament\Resources\MaulidContentResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CreateMaulidContent extends CreateRecord
{
    protected static string $resource = MaulidContentResource::class;

    public function mount(): void
    {
        if (!request()->has("maulid_id") || !request()->maulid_id) {
            Notification::make()
                ->warning()
                ->title('You don\'t have an select maulid!')
                ->body('Choose a maulid to continue.')
                ->persistent()
                ->actions([
                    Action::make('back')
                        ->button()
                        ->url(route('filament.siteman.resources.maulids.index'), shouldOpenInNewTab: false),
                ])
                ->send();
        }
    }
}
