<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingListPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_list_id',
        'user_id',
        'permission_type'
    ];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
