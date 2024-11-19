<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserUser extends Model
{
    protected $fillable = [
        'user_id',
        'granted_user_id',
        'permission_id',
        'resource_id',
        'resource_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grantedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'granted_user_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function resource(): MorphTo
    {
        return $this->morphTo();
    }
}
