<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
protected $fillable = ['nama_sekolah'];

public function players()
{
    return $this->hasMany(Player::class);
}
}
