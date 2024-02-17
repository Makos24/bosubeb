<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Filament\Resources\SalaryResource\RelationManagers;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_method')
                    ->maxLength(255),
                Forms\Components\TextInput::make('grade')
                    ->numeric(),
                Forms\Components\TextInput::make('step')
                    ->numeric(),
                Forms\Components\TextInput::make('basic')
                    ->numeric(),
                Forms\Components\TextInput::make('rent')
                    ->numeric(),
                Forms\Components\TextInput::make('transport')
                    ->numeric(),
                Forms\Components\TextInput::make('utility')
                    ->numeric(),
                Forms\Components\TextInput::make('domestic_staff')
                    ->numeric(),
                Forms\Components\TextInput::make('ent')
                    ->numeric(),
                Forms\Components\TextInput::make('meals')
                    ->numeric(),
                Forms\Components\TextInput::make('paye')
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->numeric(),
                Forms\Components\TextInput::make('union')
                    ->numeric(),
                Forms\Components\TextInput::make('td')
                    ->numeric(),
                Forms\Components\TextInput::make('gross')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('step')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('basic')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rent')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transport')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('utility')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('domestic_staff')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ent')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('meals')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paye')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('union')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('td')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gross')
                    ->numeric()
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
