
<table border="1" class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr style="font: bold;">
          							
 
        <th>TRANSACTION REFERENCE NUMBER</th>
        <th>BENEFICIARY NAME</th>
        <th>PAYMENT AMOUNT</th>
        <th>PAYMENT DUE DATE</th>
        <th>BENEFICIARY CODE</th>
        <th>BENEFICIARY ACCOUNT NUMBER</th>
        <th>BENEFICIARY BANK SORT CODE</th>
        <th>DEBIT ACCOUNT NUMBER</th>
        
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

    @foreach($payments as $payment)

    
        <tr>
            <td>{{ $payment->payment_reference }}</td>
            <td>{{ $payment->staff->name }}</td>
            <td>{{ $payment->staff->net_salary }}</td>
            <td>{{ $payment->payment_due_date }}</td>
            <td>{{ $payment->payment_reference }}</td>
            <td>{{ $payment->staff->account_number }}</td>
            <td>{{ $payment->staff->bank->sort_code }}</td>
            <td>{{ "1229317425" }}</td>
            
            

        </tr>

@endforeach

          </tbody>

</table>