<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
        'progress',
        'total',
        'measure'
    ];

    protected function progress(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (float)$value ?? 0.00,
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (float)$value ?? 100.00,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
