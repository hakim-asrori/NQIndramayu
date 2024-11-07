<?php

namespace App\Filament\Resources\MaulidResource\Pages;

use App\Filament\Resources\MaulidResource;
use App\Models\Maulid;
use App\Models\MaulidContent;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class AddContentMaulid extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = MaulidResource::class;

    protected static string $view = 'filament.resources.maulid-resource.pages.add-content-maulid';

    protected $recordId = null;

    public array $data = [];

    protected static ?string $title = 'name';

    public function mount(): void
    {
        $this->recordId = request()->route("record");

        $maulid = Maulid::find($this->recordId);
        self::$title = "Add Content Maulid $maulid->name";

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    protected function getFormActions(): array
    {
        return [
            Action::make("create")
                ->label(__('filament-panels::resources/pages/create-record.form.actions.create.label'))
                ->submit("create"),
            Action::make("cancel")
                ->label(__('filament-panels::resources/pages/create-record.form.actions.cancel.label'))
                ->color('secondary')
                ->url(route("filament.siteman.resources.maulids.view", $this->recordId))
        ];
    }

    public function create()
    {
        $data = $this->form->getState();

        MaulidContent::create($data);

        Notification::make()
            ->title('Data has been created')
            ->success()
            ->send();

        return redirect()->route("filament.siteman.resources.maulids.view", $data["maulid_id"]);
    }
}
