<table border="1" class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr>
            
        <th>S/No</th>
        <th>LGA</th>
        <th>Name of Pensioner</th>
        <th>Pensioner Status</th>
        <th>G/L</th>
        <th>Gross</th>
        <th>Basic Salary</th>
        <th>PAYE</th>
        <th>NUT Teacher</th>
        <th>NULGE Admin</th>
        <th>Total Deduction</th>
        <th>Net Salary</th>
        <th>Annual Pension</th>
        <th>Monthly Pension</th>
        <th>Difference</th>
        
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

    @foreach($payrolls as $payroll)

    
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $payroll->lga->name }}</td>
            <td>{{ $payroll->name }}</td>
            <td>{{ $payroll->staff_status }}</td>
            <td>{{ $payroll->salary_grade_level }}</td>
            <td>{{ $g = number_format($payroll->salary_data->gross) }}</td>
            <td>{{ $b = number_format($payroll->salary_data->basic) }}</td>
            <td>{{ $p = number_format($payroll->salary_data->paye) }}</td>
            <td>{{ $nt = number_format($payroll->salary_nut) }}</td>
            <td>{{ $nl = number_format($payroll->salary_nulge) }}</td>
            <td>{{ number_format($d = array_sum(to_nums([$nt, $nl, $p]))) }}</td>
            <td>{{ number_format(to_num($g) - to_num($d)) }}</td>
            <td>{{ $payroll->annual_pension }}</td>
            <td>{{ $payroll->monthly_pension }}</td>
            <td>{{ $payroll->salary_net - to_num($payroll->monthly_pension) }}</td>

        </tr>

@endforeach

          </tbody>

</table>