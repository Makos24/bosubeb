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
use Filament\Forms\Components\Textarea;

class ViewStaff extends ViewRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        
        
        return [
            $this->record->suspended == 0 ? Action::make('Suspend Staff')
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
            ->requiresConfirmation() : Action::make('Restore Staff')
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
            Action::make('Retire Staff')
            ->color('warning')
            ->action(fn (Staff $record) => $record->update(['expected_date_of_retirement' => Carbon::today()->toDateString()]))
            ->requiresConfirmation(),
            
            
        ];
    }
}
