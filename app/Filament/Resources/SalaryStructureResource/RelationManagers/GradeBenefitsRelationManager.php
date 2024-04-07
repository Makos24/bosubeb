<?php

namespace App\Filament\Resources\SalaryStructureResource\RelationManagers;

use App\Models\SalaryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradeBenefitsRelationManager extends RelationManager
{
    protected static string $relationship = 'grade_benefits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('salary_item_id')
                    ->options(SalaryItem::get()->pluck("name", "id")->toArray())
                    ->label('Salary Item')
                    ->required(),
                Forms\Components\TextInput::make('grade')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\TextInput::make('step')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('salary_item_id')
            ->columns([
                Tables\Columns\TextColumn::make('salary_item.name'),
                Tables\Columns\TextColumn::make('grade')->searchable(),
                Tables\Columns\TextColumn::make('step')->searchable(),
                Tables\Columns\TextColumn::make('amount'),
            ])
            ->filters([
                //
                SelectFilter::make('salary_item_id')
                ->label('Salary Item')
                ->options(SalaryItem::query()->pluck("name", "id")),
                
            ], layout: FiltersLayout::AboveContent)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
