<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        \App\Models\User::class  => \App\Policies\UserPolicy::class,
        \App\Models\Problem::class  => \App\Policies\ProblemPolicy::class,
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
        \App\Models\Topic::class  => \App\Policies\TopicPolicy::class,
        \App\Models\Announcement::class  => \App\Policies\AnnouncementPolicy::class,
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
