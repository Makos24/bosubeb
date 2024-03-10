<?php

namespace App\Filament\Imports;

use App\Models\SalaryItem;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class SalaryItemImporter extends Importer
{
    protected static ?string $model = SalaryItem::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
            ->requiredMapping()
            ->rules(['required', 'max:255']),
            ImportColumn::make('description')
            ->requiredMapping()
            ->rules(['required', 'max:255']),
            ImportColumn::make('taxable')
            ->requiredMapping()
            ->rules(['required', 'max:255']),
            ImportColumn::make('type')
            ->requiredMapping()
            ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?SalaryItem
    {
        // return SalaryItem::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new SalaryItem();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your salary item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
