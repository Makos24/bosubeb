<?php

namespace App\Filament\Resources;

use App\Exports\LGAStaffExport;
use App\Exports\StaffExport;
use App\Filament\Resources\StaffResource\Pages;
use App\Filament\Resources\StaffResource\RelationManagers;
use App\Filament\Resources\StaffResource\RelationManagers\CertificatesRelationManager;
use App\Filament\Resources\StaffResource\RelationManagers\LoansRelationManager;
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
use Filament\Actions\Action;
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
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Infolists;
use Filament\Infolists\Infolist;

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
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            TextInput::make('middle_name')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            TextInput::make('last_name')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            Select::make('gender_id')
                            ->label("Gender")
                            ->placeholder('Select')
                            ->options([
                                '1' => 'Male',
                                '2' => 'Female',
                            ])
                            ,
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
                            ,
                            DatePicker::make('date_of_birth')
                            ->format('Y-m-d')
                            ,
                            Select::make('qualification')
                            ->label("Qualification")
                            ->placeholder('Select')
                            ->options(Qualification::all()->pluck("name", "id")->toArray())
                            ,
                            TextInput::make('phone')
                            
                            ->maxLength(255),
                            TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            TextInput::make('nin')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            Select::make('state_id')
                            ->label("State of Origin")
                            ->placeholder('Select state')
                            ->options(State::query()->pluck("name", "id"))
                            ->live()
                            ,
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
                            ->pluck('name', 'id'))
                            ->searchable(),
                            TextInput::make('form_no')
                            ->label('DP Number')
                            ->disabledOn(['edit'])
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                            Select::make('lga_id')
                            ->label("Duty Station")
                            ->placeholder('Select lga')
                            ->options(Lga::query()->where('state_id', 8)->pluck("name", "id"))
                            ->live()
                            ->searchable(),
                            // ->afterStateUpdated(fn (callable $set) => $set('school_id', null))
                            // ,
                            Select::make('school_id')
                            ->label("School")
                            ->placeholder('Select school')
                            ->options(fn (Get $get): Collection => School::query()
                            ->where('lga_id', $get('lga_id'))
                            ->pluck('name', 'id'))
                            ->live()
                            ->visible(fn (Get $get): bool => $get('category_id') == 2),
                            DatePicker::make('date_of_appointment')
                            ->format('Y-m-d')
                            ->label('Date of First Appointment'),
                            DatePicker::make('date_of_last_promotion')
                            ->format('Y-m-d'),
                            Select::make('cadre')
                            ->label("Present Rank/Designation")
                            ->placeholder('Select')
                            ->options(Cadre::query()->pluck("name", "id"))
                            ->searchable(),
                            Select::make('salary_structure_id')
                            ->label("Salary Structure")
                            ->placeholder('Select')
                            ->options(SalaryStructure::query()->pluck("name", "id"))
                            ->disabledOn(['edit']),
                            TextInput::make('net_salary')
                            ->label('Present Net Salary')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            TextInput::make('salary_grade_level')
                            ->label('Present Grade Level/Step (e.g 7/1)')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            TextInput::make('grade_level')
                            ->label('Highest Promotion/Grade Level/Step at Hand')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            
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
                                TextInput::make('certificate')
                                ->label('Qualification Obtained')
                                ->maxLength(255),
                                DatePicker::make('from')
                                ->format('Y-m-d')
                                ->label('From (Year)'),
                                DatePicker::make('to')
                                ->format('Y-m-d')
                                ->label('To (Year)'),
                               
                                
                                
                            ])->columns(2)
                        ]),
                       
                
                    Wizard\Step::make('Salary Bank Details')
                    ->columns(2)
                        ->schema([
                            // ...
                            Select::make('bank_id')
                            ->label("Bank Name")
                            ->placeholder('Select')
                            ->options(Bank::query()->pluck("name", "id"))
                            ->disabledOn(['edit']),
                            TextInput::make('account_name')
                            ->maxLength(255)
                            ->disabledOn(['edit']),
                            TextInput::make('account_number')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabledOn(['edit']),
                            TextInput::make('bvn')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            // ->disabledOn(['edit']),
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
                
                ])->skippable()
                ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('form_no')
                ->label('DP Number')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('lga.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('school.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('duty_stations.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('minimum_wage')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('marital_status.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('qualifications.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('nin')
                    ->searchable(),
                TextColumn::make('lga.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('lga.state.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('blood_group')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_appointment')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_of_last_promotion')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('expected_date_of_retirement')
                    ->date()
                    ->sortable(),
                ToggleColumn::make('status')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cadres.name')
                    ->sortable(),
                TextColumn::make('grade_level')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('salary_grade_level')
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('next_of_kin_relationship')
                    ->toggleable(isToggledHiddenByDefault: true),
                
            ])
            ->filters([
                SelectFilter::make('category_id')
                ->label('Category')
                ->options(Category::query()->pluck("name", "id"))
                ->hidden(auth()->user()->role_id != 1),
                // SelectFilter::make('status')
                // ->label('Status')
                // ->options([1 => "Teacher", 0 => "Non Teacher"]),
                SelectFilter::make('agency_id')
                ->label('MDA')
                ->multiple()
                ->options(Agency::query()->pluck("name", "id"))
                ->hidden(in_array(auth()->user()->role_id, [2, 4, 5, 6])),
                SelectFilter::make('lga_id')
                ->label('LGA')
                ->options(Lga::query()->pluck("name", "id"))
                ->hidden(in_array(auth()->user()->role_id, [3, 4])),
                SelectFilter::make('qualification')
                ->multiple()
                ->options(Qualification::query()->pluck("name", "id")),
                Filter::make('suspended')
                ->label('Suspended')
                ->query(fn (Builder $query): Builder => $query->where('suspended', 1)),
                Filter::make('retired')
                ->label('Pensioners')
                ->query(fn (Builder $query): Builder => $query->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())),
                Filter::make('deceased')
                ->label('Late Case')
                ->query(fn (Builder $query): Builder => $query->where('deceased', 1)),
                Filter::make('student')
                ->label('Students')
                ->query(fn (Builder $query): Builder => $query->where('student', 1)),
                Filter::make('senior_citizen')
                ->label('Senior Citizens')
                ->query(fn (Builder $query): Builder => $query->where('senior_citizen', 1)),               
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ], position: ActionsPosition::BeforeColumns)
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
            PromotionsRelationManager::class,
            PaymentsRelationManager::class,
            LoansRelationManager::class
            
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

//     public static function infolist(Infolist $infolist): Infolist
// {
//     return $infolist
//         ->schema([
//             Infolists\Components\TextEntry::make('middle_name'),
//             Infolists\Components\TextEntry::make('middle_name'),
//             Infolists\Components\TextEntry::make('last_name'),
//             Infolists\Components\Optio::make('gender_id'),
//             Infolists\Components\TextEntry::make('email'),
//             Infolists\Components\TextEntry::make('address')
//                 ->columnSpanFull(),

                
//         ]);
// }
    
}
