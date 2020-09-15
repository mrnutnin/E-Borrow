<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowMaterial extends Model
{
    //
    protected $table = 'borrow_materials';

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
