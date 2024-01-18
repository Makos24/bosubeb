<table border="1" class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr>
            
        <th>S/No</th>
        <th>LGA</th>
        <th>Number of Staff</th>
        <th>Basic Salary</th>
        <th>Rent</th>
        <th>Transport</th>
        <th>Meal</th>
        <th>Utility</th>
        <th>Entertainment</th>
        <th>LG</th>
        <th>27.50%</th>
        <th>15.00%</th>
        <th>12.00%</th>
        <th>0.00%</th>
        <th>Gross</th>
        <th>PAYE</th>
        <th>NUT Teacher</th>
        <th>NULGE Admin</th>
        <th>Total Deduction</th>
        <th>Total Net</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

    @foreach($payrolls as $payroll)

    
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $payroll->first()->lga->name }}</td>
            <td>{{ $payroll->count() }}</td>
            <td>{{ $b = number_format($payroll->sum('salary_data.basic')) }}</td>
            <td>{{ $r = number_format($payroll->sum('salary_data.rent')) }}</td>
            <td>{{ $t = number_format($payroll->sum('salary_data.transport')) }}</td>
            <td>{{ $m = number_format($payroll->sum('salary_data.meals')) }}</td>
            <td>{{ $u = number_format($payroll->sum('salary_data.utility')) }}</td>
            <td>{{ $e = number_format($payroll->sum('salary_data.ent')) }}</td>
            <td>{{ $l = number_format($payroll->sum('salary_data.ent')) }}</td>
            <td>{{ $tf = number_format($payroll->where('status', 1)->whereBetween('qualification', [1, 10])->sum('salary_data.basic') * .275) }}</td>
            <td>{{ $ft = number_format($payroll->where('status', 1)->whereNotBetween('qualification', [1, 10])->sum('salary_data.basic') * .15) }}</td>
            <td>{{ $tw = number_format($payroll->where('status','<>', 1)->whereBetween('qualification', [1, 10])->sum('salary_data.basic') * .125) }}</td>
            <td>{{ $zr = number_format($payroll->where('status','<>', 1)->whereNotBetween('qualification', [1, 10])->sum('salary_data.basic') * 0) }}</td>
            <td>{{ $g = number_format(array_sum(to_nums([$b, $r, $t, $m, $u, $e, $l, $tf, $ft, $tw, $zr]))) }}</td>
            <td>{{ number_format($payroll->sum('salary_data.paye')) }}</td>
            <td>{{ $nt = number_format($payroll->where('status', 1)->sum('salary_data.basic') * .03) }}</td>
            <td>{{ $nl = number_format($payroll->where('status','<>', 1)->sum('salary_data.basic') * .03) }}</td>
            <td>{{ number_format($d = array_sum(to_nums([$nt, $nl]))) }}</td>
            <td>{{ number_format(to_num($g) - to_num($d)) }}</td>

        </tr>

@endforeach

          </tbody>

</table>
