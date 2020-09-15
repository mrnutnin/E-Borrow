<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Material;
use App\BorrowMaterial;

class MaterialUserController extends Controller
{
    //
    public function index()
    {
        return view('user.materials.index');
    }

    public function showMaterials()
    {
        return datatables()->of(
            Material::query()->with('unit', 'type')->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function orderMaterial(Request $req)
    {
        $user = Auth::user();
        $items = $req->array_items;
        $amounts = $req->array_amounts;
        //dd($req->all());
        $i = 0;
        DB::beginTransaction();


        foreach ($items as $item) {
            $borrow = new BorrowMaterial;
            $borrow->user_id = $user->id;
            $borrow->material_id = $item['id'];
            $borrow->amount = $amounts[$i];
            $borrow->action = 1;
            $borrow->save();

            $material = Material::find($item['id']);
            $material->amount -= $amounts[$i];
            $material->save();

            $i++;
        }

        $data = [
            'title' => 'ทำรายการสำเร็จ',
            'msg' => 'ทำรายการยืมสำเร็จ',
            'status' => 'success',
        ];

        DB::commit();
        return $data;

    }

    public function history()
    {
        return view('user.materials.history');
    }

    public function showHistory(){

        $user = Auth::user();

        return datatables()->of(
            BorrowMaterial::query()->with('material.type', 'material.unit')->where('user_id', $user->id)->orderBy('updated_at', 'desc')
        )->toJson();

    }

}
