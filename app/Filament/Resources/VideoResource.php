<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Video';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->options([
                    1 => "Live",
                    2 => "Video",
                ])->required(true),
                TextInput::make('title')->required(true)->maxLength(255),
                TextInput::make('link')->required(true)->maxLength(150),
                FileUpload::make('thumbnail')->required(true)
                    ->directory('thumbnail')
                    ->image()
                    ->maxSize(2048),
                RichEditor::make('description')->required(true)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("title")->searchable(),
                SelectColumn::make("type")->options([
                    1 => "Live",
                    2 => "Video",
                ])->afterStateUpdated(function ($state, $record) {
                    Notification::make()
                        ->title('Update type successfully')
                        ->success()
                        ->send();
                })->rules(['required']),
                ImageColumn::make("thumbnail")->circular(),
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
                SelectFilter::make("type")
                    ->options([
                        1 => "Live",
                        2 => "Video",
                    ])
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
