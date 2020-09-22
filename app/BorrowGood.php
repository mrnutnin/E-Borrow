<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowGood extends Model
{
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
