<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    //
    protected $table = 'goods';

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
