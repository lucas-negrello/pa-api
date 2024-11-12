<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'tasks',
        'shoppingLists',
        'appointments',
        'goals',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the shopping lists for the user.
     */
    public function shoppingLists()
    {
        return $this->hasMany(ShoppingList::class);
    }

    /**
     * Get the appointments for the user.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the goals for the user.
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the task permissions for the user.
     */
    public function taskPermissions()
    {
        return $this->hasMany(TaskPermission::class);
    }

    /**
     * Get the shopping list permissions for the user.
     */
    public function shoppingListPermissions()
    {
        return $this->hasMany(ShoppingListPermission::class);
    }

    /**
     * Get the appointment permissions for the user.
     */
    public function appointmentPermissions()
    {
        return $this->hasMany(AppointmentPermission::class);
    }

    /**
     * Get the goal permissions for the user.
     */
    public function goalPermissions()
    {
        return $this->hasMany(GoalPermission::class);
    }
}
