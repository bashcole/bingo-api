<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['score', 'cells'];

    protected function roulette(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => explode(',', $value),
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
