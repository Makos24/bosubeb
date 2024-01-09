<table>
    <thead>
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
    <tbody>
    @foreach($payrolls as $payroll)

        
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $payroll->first()->lga->name }}</td>
            <td>{{ $payroll->count() }}</td>
            <td>{{ $payroll->sum('salary_basic') }}</td>
            <td>{{ $payroll->sum('salary_rent') }}</td>
            <td>{{ $payroll->sum('salary_transport') }}</td>
            <td>{{ $payroll->sum('salary_meals') }}</td>
            <td>{{ $payroll->sum('salary_utility') }}</td>
            <td>{{ $payroll->sum('salary_ent') }}</td>
            {{dd($payroll->sum('salary_basic'))}}
            <td>{{ $payroll->whereBetween('qualification', [1, 10])->sum('salary_ent') }}</td>
            <td>{{ $payroll->staff->name }}</td>
            <td>{{ $payroll->staff->gender }}</td>
            <td>{{ $payroll->staff->qualification }}</td>
            <td>{{ $payroll->staff->status }}</td>
            <td>{{ $payroll->staff->dob }}</td>
            <td>{{ $payroll->staff->dofa }}</td>
            <td>{{ $payroll->staff->dor }}</td>
            <td>{{ $payroll->month }}</td>
            <td>{{ $payroll->year }}</td>
            <td>{{ $payroll->current_salary }}</td>
        </tr>
    @endforeach
    </tbody>
</table>