<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowGood extends Model
{
    use SoftDeletes;
    protected $table = 'borrow_goods';

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
