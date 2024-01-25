<?php

namespace App\Filament\Resources;

use App\Exports\LGAStaffExport;
use App\Exports\StaffExport;
use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Filament\Resources\StaffResource\RelationManagers\CertificatesRelationManager;
use App\Models\Bank;
use App\Models\Cadre;
use App\Models\DutyStation;
use App\Models\Lga;
use App\Models\Qualification;
use App\Models\School;
use App\Models\Staff;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Main Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('form_no')
                ->required()
                ->maxLength(255)
                ->columnSpan(3)
                ->maxWidth("200px"),
                TextInput::make('first_name')
                ->required()
                ->maxLength(255),
                TextInput::make('middle_name')
                ->maxLength(255),
                TextInput::make('last_name')
                ->required()
                ->maxLength(255),
                Select::make('lga_id')
                ->label("LGA")
                ->placeholder('Select lga')
                ->options(Lga::where('state_id', 8)->get()->pluck("name", "id")->toArray())
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('school_id', null))
                ->required(),
                Select::make('school_id')
                ->label("School")
                ->placeholder('Select school')
                ->options(function(callable $get){
                    $lga = Lga::find($get('lga_id'));

                    if(!$lga){
                        return [];
                    }

                    return $lga->schools->pluck("name", "id")->toArray();
                })
                ->required(),
                Select::make('duty_station')
                ->label("Duty Station")
                ->placeholder('Select lga')
                ->options(DutyStation::all()->pluck("name", "id")->toArray())
                ->required(),
                Select::make('minimum_wage')
                ->label("Minimum Wage")
                ->placeholder('Select')
                ->options([
                    '1' => 'Qualified',
                    '0' => 'Not Qualified',
                ])
                ->required(),
                Select::make('gender_id')
                ->label("Gender")
                ->placeholder('Select')
                ->options([
                    '1' => 'Male',
                    '2' => 'Female',
                ])
                ->required(),
                Select::make('marital_status_id')
                ->label("Marital Status")
                ->placeholder('Select')
                ->options([
                    '1' => 'Single',
                    '2' => 'Married',
                    '3' => 'Divorced',
                    '4' => 'Widowed',
                    '5' => 'Separated',
                ])
                ->required(),
                DatePicker::make('date_of_birth')
                ->format('d/m/Y')
                ->required(),
                Select::make('qualification_id')
                ->label("Qualification")
                ->placeholder('Select')
                ->options(Qualification::all()->pluck("name", "id")->toArray())
                ->required(),
                TextInput::make('phone')
                ->required()
                ->maxLength(255),
                TextInput::make('nin')
                ->required()
                ->maxLength(255),
                Select::make('state_id')
                ->label("State of Origin")
                ->placeholder('Select state')
                ->options(State::all()->pluck("name", "id")->toArray())
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('lga_of_origin_id', null))
                ->required(),
                Select::make('lga_of_origin_id')
                ->label("LGA of Origin")
                ->placeholder('Select LGA')
                ->options(function(callable $get){
                    $state = State::find($get('state_id'));

                    if(!$state){
                        return [];
                    }

                    return $state->lgas->pluck("name", "id")->toArray();
                })
                ->required(),
                Select::make('blood_group')
                ->label("Blood Group")
                ->placeholder('Select')
                ->options([
                    'a' => 'A',
                    'b' => 'B',
                    'ab' => 'AB',
                    'O' => 'O',
                ])
                ->required(),
                DatePicker::make('date_of_appointment')
                ->format('d/m/Y')
                ->required(),
                DatePicker::make('date_of_last_promotion')
                ->format('d/m/Y')
                ->required(),
                DatePicker::make('expected_date_of_retirement')
                ->format('d/m/Y')
                ->required(),
                Toggle::make('status')->required(),
                Select::make('cadre')
                ->label("Cadre")
                ->placeholder('Select')
                ->options(Cadre::all()->pluck("name", "id")->toArray())
                ->required(),
                Select::make('salary_id')
                ->label("Salary Structure")
                ->placeholder('Select')
                ->options([
                    '1' => '15% CPSSS',
                    '2' => '30% NMW',
                   
                ])
                ->required(),
                TextInput::make('grade_level')
                ->required()
                ->maxLength(255),
                TextInput::make('salary_grade_level')
                ->required()
                ->maxLength(255),
                TextInput::make('gross_salary')
                ->required()
                ->maxLength(255),
                TextInput::make('net_salary')
                ->required()
                ->maxLength(255),
                Select::make('bank_id')
                ->label("Bank")
                ->placeholder('Select')
                ->options(Bank::all()->pluck("name", "id")->toArray())
                ->required(),
                TextInput::make('account_name')
                ->required()
                ->maxLength(255),
                TextInput::make('account_number')
                ->required()
                ->maxLength(255),
                TextInput::make('bvn')
                ->required()
                ->maxLength(255),
                Textarea::make('address')
                ->required()
                ->maxLength(255),
                TextInput::make('email')
                ->required()
                ->maxLength(255),
                TextInput::make('next_of_kin_name')
                ->label("Name of Kin Name")
                ->required()
                ->maxLength(255),
                TextInput::make('next_of_kin_phone')
                ->required()
                ->maxLength(255),
                Textarea::make('next_of_kin_address')
                ->required()
                ->maxLength(255),
                TextInput::make('next_of_kin_relationship')
                ->label("Relationship with Next of Kin")
                ->required()
                ->maxLength(255),
                
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form_no')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('lga.name')
                    ->sortable(),
                TextColumn::make('school.name')
                    ->sortable(),
                TextColumn::make('duty_stations.name')
                    ->sortable(),
                TextColumn::make('minimum_wage')
                    ->searchable(),
                TextColumn::make('gender.name')
                    ->sortable(),
                TextColumn::make('marital_status.name')
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('qualifications.name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('nin')
                    ->searchable(),
                TextColumn::make('lga.name')
                    ->sortable(),
                TextColumn::make('lga.state.name')
                    ->sortable(),
                TextColumn::make('blood_group')
                    ->searchable(),
                TextColumn::make('date_of_appointment')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_of_last_promotion')
                    ->date()
                    ->sortable(),
                TextColumn::make('expected_date_of_retirement')
                    ->date()
                    ->sortable(),
                ToggleColumn::make('status')
                    ->sortable(),
                TextColumn::make('cadres.name')
                    ->sortable(),
                TextColumn::make('grade_level')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('salary_grade_level')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gross_salary')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('net_salary')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bank.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('account_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('account_number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bvn')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('next_of_kin_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('next_of_kin_phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('next_of_kin_address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('next_of_kin_relationship')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
            ])
            ->filters([
                SelectFilter::make('lga_id')
                ->label('LGA')
                ->options(Lga::where('state_id', 8)->get()->pluck("name", "id")->toArray()),
                SelectFilter::make('status')
                ->label('Status')
                ->options([1 => "Teacher", 0 => "Non Teacher"]),
                SelectFilter::make('qualification')
                ->multiple()
                ->options(Qualification::get()->pluck("name", "id")->toArray()),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                    //BulkAction::make('export')->action(fn() => (Excel::download(new LGAStaffExport(), 'allstaff.xlsx'))),

                ]),
                
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CertificatesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
            'view' => Pages\ViewStaff::route('/{record}'),
        ];
    }
}
