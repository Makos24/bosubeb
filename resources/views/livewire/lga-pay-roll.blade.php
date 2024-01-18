<div>
<div>
<div class="flex items-center justify-end px-4 py-2 text-right sm:px-6">    
       
       <x-filament::button wire:click="downloadSummary">
             <span class="fi-btn-label">
                   Download Summary
               </span>
               </x-filament::button>
           </div>
    <div class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10 !border-t-0">
<table border="1" class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr>
            
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">S/No</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">LGA</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Name of School</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Number of Staff</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Basic Salary</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Rent</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Transport</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Meal</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Utility</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Entertainment</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">LG</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">27.50%</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">15.00%</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">12.00%</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">0.00%</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Gross</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">PAYE</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">NUT Teacher</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">NULGE Admin</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Total Deduction</span></th>
        <th class="w-1"> <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Total Net</span></th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

    @foreach($payrolls as $payroll)

    
        <tr>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $loop->iteration }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $payroll->first()->lga->name }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $payroll->first()->school->name }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $payroll->count() }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $b = number_format($payroll->sum('salary_data.basic')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $r = number_format($payroll->sum('salary_data.rent')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $t = number_format($payroll->sum('salary_data.transport')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $m = number_format($payroll->sum('salary_data.meals')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $u = number_format($payroll->sum('salary_data.utility')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $e = number_format($payroll->sum('salary_data.ent')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $l = number_format($payroll->sum('salary_data.ent')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $tf = number_format($payroll->where('status', 1)->whereBetween('qualification', [1, 10])->sum('salary_data.basic') * .275) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $ft = number_format($payroll->where('status', 1)->whereNotBetween('qualification', [1, 10])->sum('salary_data.basic') * .15) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $tw = number_format($payroll->where('status','<>', 1)->whereBetween('qualification', [1, 10])->sum('salary_data.basic') * .125) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $zr = number_format($payroll->where('status','<>', 1)->whereNotBetween('qualification', [1, 10])->sum('salary_data.basic') * 0) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $g = number_format(array_sum(to_nums([$b, $r, $t, $m, $u, $e, $l, $tf, $ft, $tw, $zr]))) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ number_format($payroll->sum('salary_data.paye')) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $nt = number_format($payroll->where('status', 1)->sum('salary_data.basic') * .03) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ $nl = number_format($payroll->where('status','<>', 1)->sum('salary_data.basic') * .03) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ number_format($d = array_sum(to_nums([$nt, $nl]))) }}</div></div></td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-transport"><div class="fi-ta-col-wrp"><div class="fi-ta-text grid gap-y-1 px-3 py-4">{{ number_format(to_num($g) - to_num($d)) }}</div></div></td>

        </tr>

@endforeach

          </tbody>

</table>
    </div>
</div>

</div>
