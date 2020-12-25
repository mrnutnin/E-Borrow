<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowMaterial extends Model
{
    //
    use SoftDeletes;
    protected $table = 'borrow_materials';

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
