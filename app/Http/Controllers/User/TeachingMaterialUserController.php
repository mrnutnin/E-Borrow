<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Material;
use App\BorrowMaterial;

class TeachingMaterialUserController extends Controller
{
    //
    public function index()
    {
        return view('user.teaching-materials.index');
    }

    public function showMaterials()
    {

        return datatables()->of(
            Material::query()->with('unit', 'type', 'shop')->where('type_id', 1)->orderBy('updated_at', 'desc')
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
            $material = Material::with('type', 'unit')->where('id', $item['id'])->first();
            $material->amount -= $amounts[$i];
            $material->save();

            $borrow = new BorrowMaterial;
            $borrow->user_id = $user->id;
            $borrow->material_id = $item['id'];
            $borrow->amount = $amounts[$i];
            $borrow->name = $material->name;
            $borrow->type = $material->type->name;
            $borrow->unit = $material->unit->name;
            $borrow->user_name = $user->name;
            $borrow->action = 1;
            $borrow->save();


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
        return view('user.teaching-materials.history');
    }

    public function showHistory()
    {

        $user = Auth::user();

        return datatables()->of(
            BorrowMaterial::query()->with('material.type', 'material.unit', 'material.shop')
            ->whereHas('material', function ($query) {
                $query->where('type_id', 1);
            })
            ->where('user_id', $user->id)->orderBy('id', 'asc')
        )->toJson();
    }
}
