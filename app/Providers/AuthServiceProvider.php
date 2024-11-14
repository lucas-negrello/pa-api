<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Goal;
use App\Models\ShoppingList;
use App\Models\Task;
use App\Policies\AppointmentPolicy;
use App\Policies\GoalPolicy;
use App\Policies\ShoppingListPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
        Goal::class => GoalPolicy::class,
        ShoppingList::class => ShoppingListPolicy::class,
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('create-appointment', [AppointmentPolicy::class, 'create']);
        Gate::define('create-goal', [GoalPolicy::class, 'create']);
        Gate::define('create-shopping-list', [ShoppingListPolicy::class, 'create']);
        Gate::define('create-task', [TaskPolicy::class, 'create']);

        Gate::define('update-appointment', [AppointmentPolicy::class, 'update']);
        Gate::define('update-goal', [GoalPolicy::class, 'update']);
        Gate::define('update-shopping-list', [ShoppingListPolicy::class, 'update']);
        Gate::define('update-task', [TaskPolicy::class, 'update']);

        Gate::define('delete-appointment', [AppointmentPolicy::class, 'delete']);
        Gate::define('delete-goal', [GoalPolicy::class, 'delete']);
        Gate::define('delete-shopping-list', [ShoppingListPolicy::class, 'delete']);
        Gate::define('delete-task', [TaskPolicy::class, 'delete']);

        Gate::define('force-delete-appointment', [AppointmentPolicy::class, 'forceDelete']);
        Gate::define('force-delete-goal', [GoalPolicy::class, 'forceDelete']);
        Gate::define('force-delete-shopping-list', [ShoppingListPolicy::class, 'forceDelete']);
        Gate::define('force-delete-task', [TaskPolicy::class, 'forceDelete']);

        Gate::define('view-any-appointment', [AppointmentPolicy::class, 'viewAny']);
        Gate::define('view-any-goal', [GoalPolicy::class, 'viewAny']);
        Gate::define('view-any-shopping-list', [ShoppingListPolicy::class, 'viewAny']);
        Gate::define('view-any-task', [TaskPolicy::class, 'viewAny']);

        Gate::define('view-appointment', [AppointmentPolicy::class, 'view']);
        Gate::define('view-goal', [GoalPolicy::class, 'view']);
        Gate::define('view-shopping-list', [ShoppingListPolicy::class, 'view']);
        Gate::define('view-task', [TaskPolicy::class, 'view']);

        Gate::define('restore-appointment', [AppointmentPolicy::class, 'restore']);
        Gate::define('restore-goal', [GoalPolicy::class, 'restore']);
        Gate::define('restore-shopping-list', [ShoppingListPolicy::class, 'restore']);
        Gate::define('restore-task', [TaskPolicy::class, 'restore']);
    }
}
