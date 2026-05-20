<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author', 'category', 'email', 'rating', 'event_id'];

    // Добавьте эту связь
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
