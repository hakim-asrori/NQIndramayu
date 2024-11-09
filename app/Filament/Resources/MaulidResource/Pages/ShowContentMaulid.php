<?php

namespace App\Filament\Resources\MaulidResource\Pages;

use App\Filament\Resources\MaulidResource;
use App\Models\Maulid;
use App\Models\MaulidContent;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ShowContentMaulid extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = MaulidResource::class;

    protected static string $view = 'filament.resources.maulid-resource.pages.show-content-maulid';

    protected static ?string $title = 'name';

    protected $recordId;

    public function mount(): void
    {
        $this->recordId = request()->route("record");

        $maulid = Maulid::find($this->recordId);
        self::$title = "Maulid $maulid->name";
    }

    protected function getHeaderActions(): array
    {
        return [
            // Action::make("New content")
            //     ->color('primary')
            //     ->url(fn(): string => route('filament.siteman.resources.maulids.add-content', $this->recordId)),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("arabic")
                    ->description(fn(MaulidContent $record): string => Str::limit($record->latin, 100, '...'))
                    ->formatStateUsing(fn(string $state): string => Str::limit($state, 100, "..."))
                    ->label("Text")
                    ->searchable(),
            ])
            ->actions([
                EditAction::make('edit')
                    ->url(fn(MaulidContent $record): string => route('filament.siteman.resources.maulids.edit-content', [
                        "record" => $this->recordId,
                        "content" => $record
                    ]))
            ])
            ->query(MaulidContent::query()->where("maulid_id", $this->recordId));
    }
}
