<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Staff;
use App\Models\Suspension;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class ViewStaff extends ViewRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        
        
        return [
            $this->record->suspended == 0 ? Action::make('Suspend')
            ->color('danger')
            ->form([
                Textarea::make('reason')
                ->label("Reason for Suspension")
                ->required(),
            ])
            ->action(function(Staff $record, $data) {
                $record->update(['suspended' => 1]);
                $record->suspensions()->create([
                    'suspension_reason' => $data['reason']
                ]);
            } )
            ->requiresConfirmation() : Action::make('Restore')
            ->color('success')
            ->form([
                Textarea::make('reason')
                ->label("Reason for Restoring")
                ->required(),
            ])
            ->action(function(Staff $record, $data) {
                $record->update(['suspended' => 0]);
                $record->suspensions()->latest()->first()->update([
                    'restore_reason' => $data['reason']
                ]);
            })
            ->requiresConfirmation(),
            Action::make('Retire')
            ->color('warning')
            ->action(fn (Staff $record) => $record->update(['expected_date_of_retirement' => Carbon::today()->toDateString()]))
            ->requiresConfirmation(),
            Action::make('Resign')
            ->color('info')
            ->action(fn (Staff $record) => $record->update(['expected_date_of_retirement' => Carbon::today()->toDateString()]))
            ->requiresConfirmation(),
            Action::make('Deceased')
            ->color('gray')
            ->form([
                DatePicker::make('died_on')
                ->label('Date of Death')
                ->format('Y-m-d')
                ->required()
            ])
            ->action(fn (Staff $record, $data) => $record->update(['deceased' => true, 'died_on' => $data['died_on']]))
            ->requiresConfirmation(),
            Action::make('Complain')
            ->color('primary')
            ->form([
                Select::make('type')
                ->label('Type of Issue')
                ->options([
                    'Salary not Paid' => 'Salary not Paid',
                    'Other Issue' => 'Other Issue'
                ])
                ->required(),
                DatePicker::make('issue_date')
                ->format('Y-m-d')
                ->label('When did Issue start')
                ->required(),
                Textarea::make('description')
                ->label('Describe Issue')
            ])
            ->action(fn (Staff $record, $data) => $record->update([
                                                    'issue_date' => $data['issue_date'], 
                                                    'type' => $data['type'], 
                                                    'description' => $data['description'], 
                                                    ]))
            ->requiresConfirmation(),
            
        ];
    }
}
