<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //

    protected $table = 'materials';

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
