<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoaResource\Pages;
use App\Filament\Resources\DoaResource\RelationManagers;
use App\Models\Doa;
use App\Models\DoaCategory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoaResource extends Resource
{
    protected static ?string $model = Doa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Doa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make("category_id")
                    ->label("Category")
                    ->options(DoaCategory::all()->pluck("title", "id"))
                    ->searchable()
                    ->required(),
                TextInput::make("title")
                    ->required(),
                Textarea::make("arabic")
                    ->required(),
                Textarea::make("latin")
                    ->required(),
                Textarea::make("translation")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("title")
                    ->description(fn(Doa $record): string => "Category : " . $record->category->title)
                    ->searchable(),
                ToggleColumn::make("status")->afterStateUpdated(function ($state, $record) {
                    Notification::make()
                        ->title('Update status successfully')
                        ->success()
                        ->send();
                }),
            ])
            ->filters([
                SelectFilter::make("status")
                    ->options([
                        1 => 'Active',
                        0 => 'Non Active'
                    ]),
                SelectFilter::make("category")
                    ->options(DoaCategory::all()->pluck("title", "id"))
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDoas::route('/'),
            // 'create' => Pages\CreateDoa::route('/create'),
            // 'edit' => Pages\EditDoa::route('/{record}/edit'),
        ];
    }
}
