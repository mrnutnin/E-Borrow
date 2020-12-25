<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    //
    use SoftDeletes;
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
