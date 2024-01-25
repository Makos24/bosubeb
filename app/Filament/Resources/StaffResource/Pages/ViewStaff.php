<?php

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Staff;
use Carbon\Carbon;

class ViewStaff extends ViewRecord
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        
        
        return [
            $this->record->suspended == 0 ? Action::make('Suspend Staff')
            ->color('danger')
            ->action(fn (Staff $record) => $record->update(['suspended' => 1]))
            ->requiresConfirmation() : Action::make('Restore Staff')
            ->color('success')
            ->action(fn (Staff $record) => $record->update(['suspended' => 0]))
            ->requiresConfirmation(),
            Action::make('Retire Staff')
            ->color('warning')
            ->action(fn (Staff $record) => $record->update(['expected_date_of_retirement' => Carbon::today()->toDateString()]))
            ->requiresConfirmation(),
            
            
        ];
    }
}
