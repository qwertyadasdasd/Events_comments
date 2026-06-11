<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'address', 'location', 'start_date', 'guests', 'color', 'sort_order'];

    // Добавьте эту связь
    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }
}
