<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Agency;
use App\Models\Category;
use App\Models\Lga;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255),
                TextInput::make('email')
                ->required()
                ->maxLength(255),
                Select::make('role_id')
                ->label("Role")
                ->placeholder('Select role')
                ->options(Role::get()->pluck("name", "id")->toArray())
                ->required()
                ->live(),
                Select::make('agency_id')
                ->label("MDA")
                ->placeholder('Select MDA')
                ->options(fn (Get $get): Collection => Agency::query()
                ->where('category_id', Role::find($get('role_id')) ? Role::find($get('role_id'))->agency_id : '')
                ->pluck('name', 'id')),
                Select::make('lga_id')
                ->label("LGA")
                ->placeholder('Select LGA')
                ->options(Lga::query()->where('state_id', 8)->pluck('name', 'id'))
                ->visible(fn (Get $get): bool => $get('role_id') == 2),
                TextInput::make('password')
                ->password()
                ->required()
                ->hiddenOn(['view']),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role.name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->slideOver()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['password'] = bcrypt($data['password']);
                    
                    return $data;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
