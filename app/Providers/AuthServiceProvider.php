<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Contest::class => \App\Policies\ContestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     $this->registerPolicies();
    //     try {
    //         \Horizon::auth(function ($request) {
    //             // 是否是站长
    //             return \Auth::user()->hasRole('root');
    //         });
    //     } catch (\Exception $e) {
    //         return;
    //     }
    // }
}
