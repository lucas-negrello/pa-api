<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_list_id',
        'name',
        'quantity',
        'unit',
        'status'
    ];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
