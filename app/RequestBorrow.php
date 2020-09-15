<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestBorrow extends Model
{
    //
    public function borrowMaterials()
    {
        return $this->hasMany(BorrowMaterial::class, 'request_borrow_id', 'id');
    }
}
