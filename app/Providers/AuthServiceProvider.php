<?php

namespace App\Providers;

use App\Models\Lga;
use App\Models\Salary;
use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use App\Policies\LgaPolicy;
use App\Policies\SalaryPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Staff::class => StaffPolicy::class,
        Lga::class => LgaPolicy::class,
        School::class => SchoolPolicy::class,
        Salary::class => SalaryPolicy::class
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
