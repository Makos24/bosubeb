<?php

namespace App\Filament\Imports;

use App\Models\GradeBenefits;
use App\Models\SalaryItem;
use App\Models\SalaryStructure;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class GradeBenefitsImporter extends Importer
{
    protected static ?string $model = GradeBenefits::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('salary_item')
                ->relationship(resolveUsing: ['name']),
            ImportColumn::make('salary_structure')
                ->relationship(resolveUsing: ['name']),
            ImportColumn::make('grade')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('step')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'decimal:0,4']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): ?GradeBenefits
    {
        
        return GradeBenefits::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'salary_item_id' => SalaryItem::where('name',  $this->data['salary_item'])->first() ? SalaryItem::where('name',  $this->data['salary_item'])->first()->id : null,
            'salary_structure_id' => SalaryStructure::where('name', $this->data['salary_structure'])->first() ? SalaryStructure::where('name', $this->data['salary_structure'])->first()->id : null,
            'grade' => $this->data['grade'],
            'step' => $this->data['step'],
            
        ],[
            'amount' => $this->data['amount'],
            'status' => $this->data['status'],
        ]);

        //return new GradeBenefits();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your grade benefits import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
