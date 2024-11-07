<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaulidResource\Pages;
use App\Filament\Resources\MaulidResource\RelationManagers;
use App\Models\Maulid;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaulidResource extends Resource
{
    protected static ?string $model = Maulid::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationLabel = 'Maulid';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")->label("Latin Name")->required()->maxLength(255),
                TextInput::make("arabic")->label("Arabic Name")->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")->label("Latin Name"),
                TextColumn::make("arabic")->label("Arabic Name"),
                ToggleColumn::make("status")->afterStateUpdated(function ($state, $record) {
                    Notification::make()
                        ->title('Update status successfully')
                        ->success()
                        ->send();
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make("Show")
                    ->icon("heroicon-m-eye")
                    ->color('info')
                    ->url(fn(Maulid $record): string => route('filament.siteman.resources.maulids.view', $record)),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaulids::route('/'),
            'view' => Pages\ShowContentMaulid::route('/{record}'),
            'add-content' => Pages\AddContentMaulid::route('/{record}/add-content'),
            'edit-content' => Pages\EditContentMaulid::route('/{record}/{content}/edit-content'),
            // 'edit' => Pages\EditMaulid::route('/{record}/edit'),
        ];
    }
}
