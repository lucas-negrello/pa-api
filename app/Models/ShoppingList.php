<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date'
    ];

    protected $with = [
        'shoppingListItems'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingListItems()
    {
        return $this->hasMany(ShoppingListItem::class);
    }

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'user_users', 'resource_id', 'granted_user_id')
            ->where('resource_type', ShoppingList::class)
            ->withPivot('permission_id');
    }
}
