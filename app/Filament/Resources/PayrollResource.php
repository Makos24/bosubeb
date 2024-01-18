<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Models\Staff;
use App\Models\Staff\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'All Payroll';
    protected static ?string $navigationLabel = 'All Payroll';

    protected static ?string $navigationGroup = 'Payroll';
    protected static ?string $modelLabel = 'All Payroll';
    protected static ?int $navigationSort = 1;

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
                ->label('LGA')
                    ->searchable(),
                TextColumn::make('school.name')
                    ->label('School')
                        ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('salary_grade_level')
                ->label('G/L')
                    ->searchable(),
                TextColumn::make('salary_data.basic')
                ->label('Basic Salary'),
                TextColumn::make('salary_data.rent')
                ->label('Rent'),
                TextColumn::make('salary_data.transport')
                ->label('Transport'),
                TextColumn::make('salary_data.meal')
                ->label('Meal'),
                TextColumn::make('salary_data.utility')
                ->label('Utility'),
                TextColumn::make('salary_data.ent')
                ->label('Entertainment'),
                TextColumn::make('salary_data.ltg')
                ->label('LTG'),
                TextColumn::make('salary_twenty_seven')
                ->label('27.50%'),
                TextColumn::make('salary_fifteen')
                ->label('15.00%'),
                TextColumn::make('salary_twelve')
                ->label('12.50%'),
                TextColumn::make('salary_zero')
                ->label('0.00%'),
                TextColumn::make('salary_data.gross')
                ->label('Gross'),
                TextColumn::make('salary_data.paye')
                ->label('PAYE'),
                TextColumn::make('salary_nut')
                ->label('NUT Teacher'),
                TextColumn::make('salary_nulge')
                ->label('NULGE Admin'),
                TextColumn::make('salary_td')
                ->label('Total Deductions'),
                TextColumn::make('salary_net')
                ->label('Total Net'),
                TextColumn::make('nin')
                ->label('NIN')
                ->searchable(),
                TextColumn::make('bvn')
                ->label('BVN'),
                TextColumn::make('account_number')
                ->label('Account Number')
                ->searchable(),
                TextColumn::make('bank.name')
                ->label('Bank Name'),
                TextColumn::make('date_of_appointment')
                ->label('Date of 1st Appointment'),
                TextColumn::make('date_of_birth')
                ->label('Date of Birth'),
                TextColumn::make('expected_date_of_retirement')
                ->label('Date of Retirement'),
                
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('expected_date_of_retirement', '>=', \Carbon\Carbon::today());
    }

}
