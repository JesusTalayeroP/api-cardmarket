<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function cards()
    {
        return $this->belongsTo(Card::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
