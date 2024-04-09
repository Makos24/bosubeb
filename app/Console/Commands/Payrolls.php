<?php

namespace App\Console\Commands;

use App\Models\Payroll;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Payrolls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:payrolls {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Monthly Payrolls';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //check if payroll exists for current month
        //$payrolls = Payroll::where('year', date('Y'))->where('month', date('n'))->count();
        
        //if($payrolls == 0){
            $i = 0;
            foreach(Staff::all() as $staff){
                //if(!$staff->payroll()->where('year', date('Y'))->where('month', date('n'))){
                     $staff->payroll()->firstOrCreate([
                    'month' => $this->argument('month'),
                    'year' => date('Y'),
                     ],
                     [
                        'current_salary' => $staff->net_salary,
                        'grade_salary' => $staff->salary_data() ? $staff->salary_data()->total : $staff->net_salary,
                        'difference' => $staff->salary_data() ? $staff->salary_data()->total - $staff->net_salary : 0,
                        // 'current_salary' => $staff->net_salary,
                        // 'grade_salary' => $staff->salary_data()->total,
                        // 'difference' => $staff->salary_data()->total - $staff->net_salary,
                        'type' => Carbon::parse($staff->dor)->gte(now()) ? 2 : 1,
                    
                ]);
                //}

                
            
                echo $i++; 
            }
        }
    //}
}
