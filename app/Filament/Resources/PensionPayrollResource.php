<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PensionPayrollResource\Pages;
use App\Filament\Resources\PensionPayrollResource\RelationManagers;
use App\Models\Staff;
use App\Models\Staff\PensionPayroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PensionPayrollResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Payroll';
    protected static ?string $navigationLabel = 'Pension Payroll';
    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Pension Payroll';

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
                TextColumn::make('lga.name')
                    ->searchable()
                    ->label('LGA'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('staff_status')
                    ->label('Pensioners Status')
                    ->searchable(),
                TextColumn::make('salary_grade_level')
                    ->label('G/L')
                    ->searchable(),
                TextColumn::make('salary_data.gross')
                ->label('Gross Salary')
                    ->searchable(),
                TextColumn::make('salary_data.basic')
                ->label('Basic Salary')
                    ->searchable(),
                TextColumn::make('salary_data.paye')
                ->label('PAYE'),
                TextColumn::make('salary_nut')
                ->label('NUT'),
                TextColumn::make('salary_nulge')
                ->label('NULGE'),
                TextColumn::make('salary_td')
                ->label('Total Deduction'),
                TextColumn::make('salary_net')
                ->label('Net Salary'),
                TextColumn::make('annual_pension')
                ->label('Annual Pension'),
                TextColumn::make('monthly_pension')
                ->label('Monthly Pension'),
                TextColumn::make('difference')
                ->label('Difference'),
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
            'index' => Pages\ListPensionPayrolls::route('/'),
            'create' => Pages\CreatePensionPayroll::route('/create'),
            'edit' => Pages\EditPensionPayroll::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today());
    }
}
