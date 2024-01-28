<?php

namespace App\Filament\Resources\StaffResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'certificates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('school_attended')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('certificate')
                    ->label('Certificate Obtained')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('from')
                    ->label('From (Year)')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('to')
                    ->label('To (Year)')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('certificate')
            ->columns([
                Tables\Columns\TextColumn::make('certificate'),
            ])
            ->filters([
                //
            ])
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
