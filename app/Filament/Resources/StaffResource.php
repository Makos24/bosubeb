<?php

namespace App\Filament\Resources;

use App\Exports\LGAStaffExport;
use App\Exports\StaffExport;
use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Filament\Resources\StaffResource\RelationManagers\CertificatesRelationManager;
use App\Filament\Resources\StaffResource\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\StaffResource\RelationManagers\PromotionsRelationManager;
use App\Models\Agency;
use App\Models\Bank;
use App\Models\Cadre;
use App\Models\Category;
use App\Models\DutyStation;
use App\Models\Lga;
use App\Models\Qualification;
use App\Models\SalaryStructure;
use App\Models\School;
use App\Models\Staff;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
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

                Wizard::make([
                    Wizard\Step::make('Personal Details')
                    ->columns(2)
                        ->schema([
                            // ...
                            
                            TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                            TextInput::make('middle_name')
                            ->maxLength(255),
                            TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
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
                            Select::make('qualification')
                            ->label("Qualification")
                            ->placeholder('Select')
                            ->options(Qualification::all()->pluck("name", "id")->toArray())
                            ->required(),
                            TextInput::make('phone')
                            ->required()
                            ->maxLength(255),
                            TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                            TextInput::make('nin')
                            ->required()
                            ->maxLength(255),
                            Select::make('state_id')
                            ->label("State of Origin")
                            ->placeholder('Select state')
                            ->options(State::query()->pluck("name", "id"))
                            ->live()
                            ->required(),
                            Select::make('lga_of_origin_id')
                            ->label("LGA of Origin")
                            ->placeholder('Select LGA')
                            ->options(fn (Get $get): Collection => Lga::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id')),
                            Textarea::make('address')
                            ->label('Home Address')
                            ->maxLength(255),
                            Select::make('blood_group')
                            ->label("Blood Group")
                            ->placeholder('Select')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                            ]),
                            
                        ]),
                    Wizard\Step::make('Employment Details')
                    ->columns(2)
                        ->schema([
                            // ...
                            Select::make('category_id')
                            ->label("Category")
                            ->placeholder('Select Category')
                            ->options(Category::query()->pluck("name", "id"))
                            ->live(),
                            Select::make('agency_id')
                            ->label("Ministry/Department/Agency")
                            ->placeholder('Select MDA')
                            ->options(fn (Get $get): Collection => Agency::query()
                            ->where('category_id', $get('category_id'))
                            ->pluck('name', 'id')),
                            TextInput::make('form_no')
                            ->label('DP Number')
                            ->required()
                            ->maxLength(255),
                            Select::make('lga_id')
                            ->label("Duty Station")
                            ->placeholder('Select lga')
                            ->options(Lga::query()->where('state_id', 8)->pluck("name", "id"))
                            ->live(),
                            // ->afterStateUpdated(fn (callable $set) => $set('school_id', null))
                            // ->required(),
                            Select::make('school_id')
                            ->label("School")
                            ->placeholder('Select school')
                            ->options(fn (Get $get): Collection => School::query()
                            ->where('lga_id', $get('lga_id'))
                            ->pluck('name', 'id'))
                            ->live()
                            ->visible(fn (Get $get): bool => $get('category_id') == 2),
                            DatePicker::make('date_of_appointment')
                            ->format('d/m/Y')
                            ->label('Date of First Appointment'),
                            DatePicker::make('date_of_last_promotion')
                            ->format('d/m/Y'),
                            Select::make('cadre')
                            ->label("Present Rank/Designation")
                            ->placeholder('Select')
                            ->options(Cadre::query()->pluck("name", "id")),
                            Select::make('salary_structure_id')
                            ->label("Salary Structure")
                            ->placeholder('Select')
                            ->options(SalaryStructure::query()->pluck("name", "id")),
                            TextInput::make('net_salary')
                            ->label('Present Net Salary')
                            ->maxLength(255),
                            TextInput::make('salary_grade_level')
                            ->label('Present Grade Level/Step (e.g 7/1)')
                            ->maxLength(255),
                            TextInput::make('grade_level')
                            ->label('Highest Promotion/Grade Level/Step at Hand')
                            ->maxLength(255),
                            
                        ]),
                    Wizard\Step::make('Educational Background')
                    ->columns(1)
                        ->schema([
                            // ...
                            Repeater::make('certificates')
                            ->label('Education')
                            ->relationship()
                            ->schema([
                                // ...
                                TextInput::make('school_attended')
                                ->maxLength(255),
                                DatePicker::make('from')
                                ->native(false)
                                ->format('YYYY')
                                ->label('From (Year)'),
                                DatePicker::make('to')
                                ->format('YYYY')
                                ->label('To (Year)'),
                                TextInput::make('certificate')
                                ->label('Qualification Obtained')
                                ->maxLength(255),
                                
                                
                            ])->columns(2)
                        ]),
                       
                
                    Wizard\Step::make('Salary Bank Details')
                    ->columns(2)
                        ->schema([
                            // ...
                            Select::make('bank_id')
                            ->label("Bank Name")
                            ->placeholder('Select')
                            ->options(Bank::query()->pluck("name", "id")),
                            TextInput::make('account_name')
                            ->maxLength(255),
                            TextInput::make('account_number')
                            ->maxLength(255),
                            TextInput::make('bvn')
                            ->maxLength(255),
                        ]),
                       
                
                        Wizard\Step::make('Next of Kin Details')
                        ->columns(2)
                        ->schema([
                            // ...
                            TextInput::make('next_of_kin_name')
                            ->label("Next of Kin Name")
                            ->maxLength(255),
                            TextInput::make('next_of_kin_phone')
                            ->label("Next of Kin Phone Number")
                            ->maxLength(255),
                            Textarea::make('next_of_kin_address')
                            ->maxLength(255),
                            TextInput::make('next_of_kin_relationship')
                            ->label("Relationship with Next of Kin")
                            ->maxLength(255),
                        ]),
                


                
                // ->columnSpan(3)
                // ->maxWidth("200px"),
                // TextInput::make('first_name')
                // ->required()
                // ->maxLength(255),
                // TextInput::make('middle_name')
                // ->maxLength(255),
                // TextInput::make('last_name')
                // ->required()
                // ->maxLength(255),
                // Select::make('category_id')
                // ->label("Category")
                // ->placeholder('Select Category')
                // ->options(Category::query()->pluck("name", "id"))
                // ->live(),
                // Select::make('agency_id')
                // ->label("Ministry/Department/Agency")
                // ->placeholder('Select MDA')
                // ->options(fn (Get $get): Collection => Agency::query()
                // ->where('category_id', $get('category_id'))
                // ->pluck('name', 'id')),
                // Select::make('lga_id')
                // ->label("LGA")
                // ->placeholder('Select lga')
                // ->options(Lga::query()->where('state_id', 8)->pluck("name", "id"))
                // ->live(),
                // // ->afterStateUpdated(fn (callable $set) => $set('school_id', null))
                // // ->required(),
                // Select::make('school_id')
                // ->label("School")
                // ->placeholder('Select school')
                // ->options(fn (Get $get): Collection => School::query()
                // ->where('lga_id', $get('lga_id'))
                // ->pluck('name', 'id'))
                // ->live()
                // ->visible(fn (Get $get): bool => $get('category_id') == 2),
                // ->required(),
                // Select::make('duty_station')
                // ->label("Duty Station")
                // ->placeholder('Select lga')
                // ->options(DutyStation::all()->pluck("name", "id")->toArray())
                // ->required(),
                // Select::make('minimum_wage')
                // ->label("Minimum Wage")
                // ->placeholder('Select')
                // ->options([
                //     'Qualified' => 'Qualified',
                //     'Not Qualified' => 'Not Qualified',
                // ])
                // ->required(),
                // Select::make('gender_id')
                // ->label("Gender")
                // ->placeholder('Select')
                // ->options([
                //     '1' => 'Male',
                //     '2' => 'Female',
                // ])
                // ->required(),
                // Select::make('marital_status_id')
                // ->label("Marital Status")
                // ->placeholder('Select')
                // ->options([
                //     '1' => 'Single',
                //     '2' => 'Married',
                //     '3' => 'Divorced',
                //     '4' => 'Widowed',
                //     '5' => 'Separated',
                // ])
                // ->required(),
                // DatePicker::make('date_of_birth')
                // ->format('d/m/Y')
                // ->required(),
                // Select::make('qualification')
                // ->label("Qualification")
                // ->placeholder('Select')
                // ->options(Qualification::all()->pluck("name", "id")->toArray())
                // ->required(),
                // TextInput::make('phone')
                // ->required()
                // ->maxLength(255),
                // TextInput::make('nin')
                // ->required()
                // ->maxLength(255),
                // Select::make('state_id')
                // ->label("State of Origin")
                // ->placeholder('Select state')
                // ->options(State::query()->pluck("name", "id"))
                // ->live()
                // ->required(),
                // Select::make('lga_of_origin_id')
                // ->label("LGA of Origin")
                // ->placeholder('Select LGA')
                // ->options(fn (Get $get): Collection => Lga::query()
                // ->where('state_id', $get('state_id'))
                // ->pluck('name', 'id')),
                // Select::make('blood_group')
                // ->label("Blood Group")
                // ->placeholder('Select')
                // ->options([
                //     'A+' => 'A+',
                //     'A-' => 'A-',
                //     'B+' => 'B+',
                //     'B-' => 'B-',
                //     'AB+' => 'AB+',
                //     'AB-' => 'AB-',
                //     'O+' => 'O+',
                //     'O-' => 'O-',
                // ]),
                // DatePicker::make('date_of_appointment')
                // ->format('d/m/Y')
                // ,
                // DatePicker::make('date_of_last_promotion')
                // ->format('d/m/Y')
                // ,
                // DatePicker::make('expected_date_of_retirement')
                // ->format('d/m/Y')
                // ,
                // Toggle::make('status'),
                // Select::make('cadre')
                // ->label("Cadre")
                // ->placeholder('Select')
                // ->options(Cadre::query()->pluck("name", "id"))
                // ,
                // Select::make('salary_id')
                // ->label("Salary Structure")
                // ->placeholder('Select')
                // ->options(SalaryStructure::query()->pluck("name", "id"))
                // ,
                // TextInput::make('grade_level')
                
                // ->maxLength(255),
                // TextInput::make('salary_grade_level')
                
                // ->maxLength(255),
                // TextInput::make('gross_salary')
                
                // ->maxLength(255),
                // TextInput::make('net_salary')
                
                // ->maxLength(255),
                // Select::make('bank_id')
                // ->label("Bank")
                // ->placeholder('Select')
                // ->options(Bank::all()->pluck("name", "id")->toArray())
                // ,
                // TextInput::make('account_name')
                
                // ->maxLength(255),
                // TextInput::make('account_number')
                
                // ->maxLength(255),
                // TextInput::make('bvn')
                //             ->maxLength(255),
                // TextInput::make('bvn')
                
                // ->maxLength(255),
                // Textarea::make('address')
                
                // ->maxLength(255),
                // TextInput::make('email')
                
                // ->maxLength(255),
                // TextInput::make('next_of_kin_name')
                // ->label("Name of Kin Name")
                // ->maxLength(255),
                // TextInput::make('next_of_kin_phone')
                // ->maxLength(255),
                // Textarea::make('next_of_kin_address')
                // ->maxLength(255),
                // TextInput::make('next_of_kin_relationship')
                // ->label("Relationship with Next of Kin")
                // ->maxLength(255),
                
                ])->skippable()
                ])->columns(1);
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
                Filter::make('suspended')
                ->label('Suspended')
                ->query(fn (Builder $query): Builder => $query->where('suspended', 1)),
                Filter::make('retired')
                ->label('Pensioners')
                ->query(fn (Builder $query): Builder => $query->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())),
                SelectFilter::make('lga_id')
                ->label('LGA')
                ->options(Lga::where('state_id', 8)->get()->pluck("name", "id")->toArray()),
                SelectFilter::make('status')
                ->label('Status')
                ->options([1 => "Teacher", 0 => "Non Teacher"]),
                SelectFilter::make('agency_id')
                ->label('Category')
                ->multiple()
                ->options(Agency::get()->pluck("name", "id")->toArray()),
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
            CertificatesRelationManager::class,
            PaymentsRelationManager::class,
            PromotionsRelationManager::class
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
