<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LGAResource\Pages;
use App\Filament\Resources\LGAResource\RelationManagers;
use App\Models\Lga;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LGAResource extends Resource
{
    protected static ?string $model = Lga::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Main Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('name')
                    ->searchable(),
               TextColumn::make('state.name')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('state_id')
                ->label('State')
                ->options(State::get()->pluck("name", "id")->toArray()),
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
            'index' => Pages\ListLGAS::route('/'),
            'create' => Pages\CreateLGA::route('/create'),
            'edit' => Pages\EditLGA::route('/{record}/edit'),
        ];
    }
}
