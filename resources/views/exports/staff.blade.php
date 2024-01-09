<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>School</th>
        <th>Qualification</th>
        <th>Status</th>
        <th>Date of Birth</th>
        <th>Date of Appointment</th>
        <th>Date of Retirement</th>
        <th>Cadre</th>
        <th>Grade Level</th>
        <th>BVN</th>
        <th>NIN</th>
        <th>Salary</th>
        <th>Next of Kin Name</th>
        <th>Next of Kin Phone</th>
        <th>Relationship with Next of Kin</th>
    </tr>
    </thead>
    <tbody>
    @foreach($staffs as $staff)
        <tr>
            <td>{{ $staff->name }}</td>
            <td>{{ $staff->gender }}</td>
            <td>{{ $staff->school->name }}</td>
            <td>{{ $staff->qualification }}</td>
            <td>{{ $staff->remark }}</td>
            <td>{{ $staff->dob }}</td>
            <td>{{ $staff->dofa }}</td>
            <td>{{ $staff->dor }}</td>
            <td>{{ $staff->cadre }}</td>
            <td>{{ $staff->grade."/".$staff->step }}</td>
            <td>{{ $staff->bvn }}</td>
            <td>{{ $staff->nin }}</td>
            <td>{{ $staff->net_salary }}</td>
            <td>{{ $staff->next_of_kin_name }}</td>
            <td>{{ $staff->next_of_kin_phone }}</td>
            <td>{{ $staff->next_of_kin_relationship }}</td>
        </tr>
    @endforeach
    </tbody>
</table>