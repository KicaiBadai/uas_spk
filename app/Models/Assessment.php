<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
    'player_id',
    'criterion_id',
    'nilai'
];
    public function player()
{
    return $this->belongsTo(Player::class);
}

public function criterion()
{
    return $this->belongsTo(Criterion::class);
}
}
