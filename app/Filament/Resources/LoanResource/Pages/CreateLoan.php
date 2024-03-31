<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use App\Models\Staff;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['staff_id'] = Staff::where('form_no', $data['staff_id'])->first()->id;
    $data['remaining_balance'] = $data['amount'];
 
    return $data;
}
}
