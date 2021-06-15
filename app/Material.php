<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    //
    use SoftDeletes;
    protected $table = 'materials';

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function receiptMaterials()
    {
        return $this->hasMany(ReceiptMaterial::class, 'material_id');
    }
}
