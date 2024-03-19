<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers;
use App\Models\Agency;
use App\Models\Category;
use App\Models\SalaryStructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'MDAs';
    protected static ?string $navigationLabel = 'MDAs';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('acronymn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->options(Category::get()->pluck("name", "id")->toArray())
                    ->label('Category')
                    ->required(),
                Forms\Components\Select::make('salary_structure_id')
                    ->options(SalaryStructure::get()->pluck("name", "id")->toArray())
                    ->label('Salary Structure')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('acronymn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),
                Tables\Columns\TextColumn::make('salary_structure.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
            ])
            ->filters([
                //
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
            'index' => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (Auth::user()->role_id === 1) {
            return true;
        }
        return false;
    }
}
