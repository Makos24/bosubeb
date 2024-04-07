<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeBenefitsResource\Pages;
use App\Filament\Resources\GradeBenefitsResource\RelationManagers;
use App\Models\GradeBenefits;
use App\Models\SalaryItem;
use App\Models\SalaryStructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class GradeBenefitsResource extends Resource
{
    protected static ?string $model = GradeBenefits::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';
    protected static ?string $navigationGroup = 'Salary Management';
    



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('salary_item_id')
                    ->label('Salary Item')
                    ->options(SalaryItem::get()->pluck("name", "id")->toArray())
                    ->required(),
                Forms\Components\Select::make('salary_structure_id')
                    ->label('Salary Structure')
                    ->options(SalaryStructure::get()->pluck("name", "id")->toArray())
                    ->required(),
                Forms\Components\TextInput::make('grade')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('salary_item.name')
                    ->label('Salary Item')
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary_structure.name')
                ->label('Salary Structure')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('step')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
                SelectFilter::make('salary_item_id')
                ->label('Salary Item')
                ->options(SalaryItem::query()->pluck("name", "id")),
                SelectFilter::make('salary_structure_id')
                ->label('Salary Structure')
                ->options(SalaryStructure::query()->pluck("name", "id"))
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
            'index' => Pages\ListGradeBenefits::route('/'),
            'create' => Pages\CreateGradeBenefits::route('/create'),
            'edit' => Pages\EditGradeBenefits::route('/{record}/edit'),
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
