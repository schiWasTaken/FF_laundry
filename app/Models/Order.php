<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['selected_services', 'user_location', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
