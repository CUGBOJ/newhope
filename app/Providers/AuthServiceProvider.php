<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Topic;
use App\Models\User;

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
    public function boot()
    {
        $this->registerPolicies();
        try {
            foreach (\App\Models\Permission::all() as $permission) {
                Gate::define($permission['name'], function ($user) use ($permission) {
                    return in_array($user['role_id'], array_column($permission->Role->toArray(), 'id'));
                });
            }
        }
        catch(\Exception $e){
            return;
        }
    }
}
