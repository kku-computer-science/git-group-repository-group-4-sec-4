<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\ResearchGroup;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\ResearchProject;
use App\Policies\ResearchGroupPolicy;
use App\Policies\ResearchProjectPolicy;
use App\Policies\UploadfileGroupPolicy;
use App\Policies\SystemLogPolicy;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        ResearchProject::class => ResearchProjectPolicy::class,
        Product::class => UploadfileGroupPolicy::class,
        ResearchGroup::class => ResearchGroupPolicy::class,
        User::class => SystemLogPolicy::class,

        //ResearchGroup::class => UploadfiletoGroupPolicy::class,

        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('system-log-list', [SystemLogPolicy::class, 'viewAny']);

    }
}
