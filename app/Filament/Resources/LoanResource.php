<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanPaymentResource\RelationManagers\LoanRelationManager;
use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Filament\Resources\LoanResource\RelationManagers\PaymentsRelationManager;
use App\Http\Livewire\Staff;
use App\Models\Loan;
use App\Models\Staff as ModelsStaff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Main Menu';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('staff_id')
                ->label('DP Number')
                    ->required()
                    ->maxLength(255)
                    ->exists(table: ModelsStaff::class, column: 'form_no')
                    ->hiddenOn(['view', 'edit']),
                Forms\Components\TextInput::make('amount')
                    ->label('Loan Amount')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\Select::make('deduction_type')
                    ->options(['Percentage' => 'Percentage', 'Fixed' => "Fixed"])
                    ->required(),
                    Forms\Components\TextInput::make('deduction_amount')
                    ->label('Deduction Amount')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deduction_type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deduction_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remaining_balance')
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            PaymentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'view' => Pages\ViewLoan::route('/{record}'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
