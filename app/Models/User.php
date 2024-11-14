<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'roles',
        'permissions',
        'sharedPermissions'
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the shopping lists for the user.
     */
    public function shoppingLists(): HasMany
    {
        return $this->hasMany(ShoppingList::class);
    }

    /**
     * Get the appointments for the user.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the goals for the user.
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
        ->withTimestamps()->with('permissions');
    }

    // TODO - ESSA RELACAO ESTA RESULTANDO EM ALGO ESTRANHO (GERA UM SHARED ERRADO)
    public function sharedPermissions(): MorphMany
    {
        return $this->morphMany(UserUser::class, 'resource');
    }

    public function hasPermission($permission, $resource = null): bool
    {
        $hasGlobalPermission = $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();

        if($hasGlobalPermission){
            return true;
        }

        if ($resource) {
            return $this->sharedPermissions()
                ->where('granted_user_id', $this->id)
                ->where('resource_id', $resource->id)
                ->where('resource_type', get_class($resource))
                ->whereHas('permission', function ($query) use ($permission) {
                    $query->where('name', $permission);
                })
                ->exists();
        }

        return false;
    }


    public function hasRole(string $role)
    {
        return $this->roles->contains('name', $role);
    }

}
