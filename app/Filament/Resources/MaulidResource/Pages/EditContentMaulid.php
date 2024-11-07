<?php

namespace App\Filament\Resources\MaulidResource\Pages;

use App\Filament\Resources\MaulidResource;
use App\Models\MaulidContent;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class EditContentMaulid extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MaulidResource::class;

    protected static string $view = 'filament.resources.maulid-resource.pages.edit-content-maulid';

    public array $data = [];

    protected $recordId = null;

    public function mount(): void
    {
        $this->recordId = request()->route("record");
        $contentId = request()->route("content");

        $content = MaulidContent::find($contentId);
        $this->form->fill($content->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make("id"),
                Hidden::make("maulid_id")
                    ->default($this->recordId),
                Textarea::make("barrier")
                    ->required()->default("-"),
                Textarea::make("transliteration")
                    ->required()->default("-"),
                Textarea::make("latin")
                    ->required()->default("-"),
                Textarea::make("arabic")
                    ->required()->default("-"),
                Textarea::make("translation")
                    ->required()->default("-")
                    ->columnSpanFull(),
            ])->statePath("data");
    }

    protected function getActions(): array
    {
        return [
            // DeleteAction::make()
            //     ->action(
            //         fn(MaulidContent $record) =>
            //         $record ? $record->delete() : null
            //     )
            //     ->record(new MaulidContent())
            //     ->successRedirectUrl(route("filament.siteman.resources.maulids.index"))
            //     ->successNotificationTitle('Data has been deleted'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make("edit")
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit("edit"),
            Action::make("cancel")
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.cancel.label'))
                ->color('secondary')
                ->url(route("filament.siteman.resources.maulids.view", $this->recordId))
        ];
    }

    public function save()
    {
        $data = $this->form->getState();

        MaulidContent::find($data['id'])->update($data);

        Notification::make()
            ->title('Data has been saved')
            ->success()
            ->send();

        return redirect()->route("filament.siteman.resources.maulids.view", $data["maulid_id"]);
    }
}
