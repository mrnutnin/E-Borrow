<?php

namespace App\Http\Controllers\Admin;

use App\BorrowMaterial;
use App\BorrowGood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
     public function index()
    {
        return view('admin/home');
    }

    public function countGoodApprove()
    {

        $count = BorrowGood::where('status', 0)->count();
        return $count;
    }

    public function countMatApprove()
    {
        $count = BorrowMaterial::with('material')->where('status', 0)
        ->whereHas('material', function ($query) {
                $query->where('type_id', 2);
        })
        ->count();
        return $count;
    }


    public function countTeachingMatApprove()
    {
        $count = BorrowMaterial::with('material')->where('status', 0)
            ->whereHas('material', function ($query) {
                $query->where('type_id', 1);
            })
        ->count();
        return $count;
    }
}
