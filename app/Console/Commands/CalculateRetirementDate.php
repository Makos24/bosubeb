<?php

namespace App\Console\Commands;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateRetirementDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-retirement-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Fetch staff records
         $staffRecords = Staff::all();

         // Loop through each staff record
         foreach ($staffRecords as $staff) {
             // Get date of birth and date of appointment
             $dateOfBirth = $staff->date_of_birth;
             $dateOfAppointment = $staff->date_of_appointment;
             $status = $staff->status;
             $categoryId = $staff->category_id;
 
             // Skip if both dates are missing
             if (empty($dateOfBirth) && empty($dateOfAppointment)) {
                 continue;
             }
 
             // Calculate retirement date based on status and category_id
             if ($status == 1 || $categoryId == 3) {
                 $retirementDate = $this->calculateRetirementDateSpecial($dateOfBirth, $dateOfAppointment);
             } else {
                 $retirementDate = $this->calculateRetirementDate($dateOfBirth, $dateOfAppointment);
             }
 
             // Update staff record with retirement date
             $staff->expected_date_of_retirement = $retirementDate;
             $staff->save();

         }

 
         $this->info('Date of retirement has been calculated and populated for staff.');
 
    }

    private function calculateRetirementDate($dateOfBirth, $dateOfAppointment)
    {
        // Convert string dates to Carbon instances
        $dateOfBirth = $dateOfBirth ? Carbon::parse($dateOfBirth) : null;
        $dateOfAppointment = $dateOfAppointment ? Carbon::parse($dateOfAppointment) : null;

        // Ensure both dates are not null before proceeding
        if ($dateOfBirth && $dateOfAppointment) {
            // Calculate retirement date based on the earlier of adding 35 years to appointment date or 60 years to date of birth
            $retirementDate = $dateOfAppointment->copy()->addYears(35)->min($dateOfBirth->copy()->addYears(60));
        } elseif ($dateOfBirth) {
            // If date of appointment is null, use 60 years from date of birth
            $retirementDate = $dateOfBirth->copy()->addYears(60);
        } elseif ($dateOfAppointment) {
            // If date of birth is null, use 35 years from date of appointment
            $retirementDate = $dateOfAppointment->copy()->addYears(35);
        } else {
            // If both dates are null, return null
            $retirementDate = null;
        }

        return $retirementDate;
    }

    private function calculateRetirementDateSpecial($dateOfBirth, $dateOfAppointment)
{
    // Convert string dates to Carbon instances
    $dateOfBirth = $dateOfBirth ? Carbon::parse($dateOfBirth) : null;
    $dateOfAppointment = $dateOfAppointment ? Carbon::parse($dateOfAppointment) : null;

    // Ensure both dates are not null before proceeding
    if ($dateOfBirth && $dateOfAppointment) {
        // Calculate retirement date based on the earlier of adding 35 years to appointment date or 60 years to date of birth
        $retirementDate = $dateOfAppointment->copy()->addYears(40)->min($dateOfBirth->copy()->addYears(65));
    } elseif ($dateOfBirth) {
        // If date of appointment is null, use 60 years from date of birth
        $retirementDate = $dateOfBirth->copy()->addYears(65);
    } elseif ($dateOfAppointment) {
        // If date of birth is null, use 35 years from date of appointment
        $retirementDate = $dateOfAppointment->copy()->addYears(40);
    } else {
        // If both dates are null, return null
        $retirementDate = null;
    }
    return $retirementDate;
}
}
