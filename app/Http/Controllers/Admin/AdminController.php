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
        $count = BorrowMaterial::where('status', 0)->count();
        return $count;
    }
}
