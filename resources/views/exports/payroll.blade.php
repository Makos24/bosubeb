<table border="1" class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr>
            
        <th>S/No</th>
        <th>LGA</th>
        <th>School</th>
        <th>Name of Staff</th>
        <th>G/L</th>
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
        <th>NIN</th>
        <th>BVN</th>
        <th>Account Number</th>
        <th>Bank Name</th>
        <th>Date of 1st Appointment</th>
        <th>Date of Birth</th>
        <th>Date of Retirement</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

    @foreach($payrolls as $payroll)

    
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $payroll->lga->name }}</td>
            <td>{{ $payroll->school->name }}</td>
            <td>{{ $payroll->name }}</td>
            <td>{{ $payroll->salary_grade_level }}</td>
            <td>{{ $b = number_format($payroll->salary_data->basic) }}</td>
            <td>{{ $r = number_format($payroll->salary_data->rent) }}</td>
            <td>{{ $t = number_format($payroll->salary_data->transport) }}</td>
            <td>{{ $m = number_format($payroll->salary_data->meal) }}</td>
            <td>{{ $u = number_format($payroll->salary_data->utility) }}</td>
            <td>{{ $e = number_format($payroll->salary_data->ent) }}</td>
            <td>{{ $l = number_format($payroll->salary_data->ent) }}</td>
            <td>{{ $tf = number_format($payroll->salary_twenty_seven) }}</td>
            <td>{{ $ft = number_format($payroll->salary_fifteen) }}</td>
            <td>{{ $tw = number_format($payroll->salary_twelve) }}</td>
            <td>{{ $zr = number_format($payroll->salary_zero) }}</td>
            <td>{{ $g = number_format(array_sum(to_nums([$b, $r, $t, $m, $u, $e, $l, $tf, $ft, $tw, $zr]))) }}</td>
            <td>{{ number_format($payroll->salary_data->paye) }}</td>
            <td>{{ $nt = number_format($payroll->salary_nut) }}</td>
            <td>{{ $nl = number_format($payroll->salary_nulge) }}</td>
            <td>{{ number_format($d = array_sum(to_nums([$nt, $nl]))) }}</td>
            <td>{{ number_format(to_num($g) - to_num($d)) }}</td>
            <td>{{ $payroll->nin }}</td>
            <td>{{ $payroll->bvn }}</td>
            <td>{{ $payroll->account_number }}</td>
            <td>{{ $payroll->bank->name }}</td>
            <td>{{ $payroll->date_of_appointment }}</td>
            <td>{{ $payroll->date_of_birth }}</td>
            <td>{{ $payroll->expected_date_of_retirement }}</td>

        </tr>

@endforeach

          </tbody>

</table>