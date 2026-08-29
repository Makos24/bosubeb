<?php

namespace App\Providers;

use App\Models\GradeBenefits;
use App\Models\Lga;
use App\Models\Loan;
use App\Models\Salary;
use App\Models\SalaryItem;
use App\Models\SalaryStructure;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use App\Policies\GradeBenefitsPolicy;
use App\Policies\LgaPolicy;
use App\Policies\LoanPolicy;
use App\Policies\SalaryItemPolicy;
use App\Policies\SalaryPolicy;
use App\Policies\SalaryStructurePolicy;
use App\Policies\SchoolPolicy;
use App\Policies\StaffPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Staff::class => StaffPolicy::class,
        Lga::class => LgaPolicy::class,
        School::class => SchoolPolicy::class,
        Salary::class => SalaryPolicy::class,
        GradeBenefits::class => GradeBenefitsPolicy::class,
        Loan::class => LoanPolicy::class,
        SalaryItem::class => SalaryItemPolicy::class,
        SalaryStructure::class => SalaryStructurePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
