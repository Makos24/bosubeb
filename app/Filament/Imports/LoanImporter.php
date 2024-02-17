<?php

namespace App\Filament\Imports;

use App\Models\Loan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class LoanImporter extends Importer
{
    protected static ?string $model = Loan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('staff')
            ->relationship(resolveUsing: ['form_no']),
            ImportColumn::make('amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'decimal:0,4']),
            ImportColumn::make('remaining_balance')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'decimal:0,4']),
            ImportColumn::make('deduction_amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'decimal:0,4']),
            ImportColumn::make('deduction_type')
                ->requiredMapping()
                ->rules(['required']),
            
        ];
    }

    public function resolveRecord(): ?Loan
    {
        // return Loan::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Loan();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your loan import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
