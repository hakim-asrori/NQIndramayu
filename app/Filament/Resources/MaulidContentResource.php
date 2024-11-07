<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaulidContentResource\Pages;
use App\Filament\Resources\MaulidContentResource\RelationManagers;
use App\Models\MaulidContent;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaulidContentResource extends Resource
{
    protected static ?string $model = MaulidContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $maulidId = request()->maulid_id;

        return $form
            ->schema([
                Hidden::make("maulid_id")
                    ->required()
                    ->default($maulidId),
                Textarea::make("barrier")
                    ->default("-")
                    ->disabled(!$maulidId),
                Textarea::make("transliteration")
                    ->default("-")
                    ->disabled(!$maulidId),
                Textarea::make("latin")
                    ->default("-")
                    ->disabled(!$maulidId),
                Textarea::make("arabic")
                    ->default("-")
                    ->disabled(!$maulidId),
                Textarea::make("translation")
                    ->default("-")
                    ->disabled(!$maulidId)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $maulidId = request()->route("maulidId");

        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make("edit")->icon("heroicon-m-pencil-square")->url(fn(MaulidContent $record): string => route('filament.siteman.resources.maulid-contents.edit', [
                    "record" => $record,
                    "maulidId" => $maulidId
                ])),
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
            'index' => Pages\ListMaulidContents::route('/'),
            'create' => Pages\CreateMaulidContent::route('/create'),
            'edit' => Pages\EditMaulidContent::route('/{record}/edit'),
        ];
    }
}
