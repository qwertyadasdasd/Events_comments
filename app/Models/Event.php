<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'description', 'guests', 'start_date', 'end_date'];

    // Добавьте эту связь
    public function event()
    {
        return $this->hasMany(Comment::class);
    }
}
