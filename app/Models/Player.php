<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
protected $fillable = [
    'school_id',
    'nama_pemain',
    'posisi'
];

public function school()
{
    return $this->belongsTo(School::class);
}
}
