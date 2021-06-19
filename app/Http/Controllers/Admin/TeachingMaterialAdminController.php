<?php

namespace App\Http\Controllers\Admin;

use App\Type;
use App\Material;
use App\Unit;
use App\ReceiptMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\BorrowMaterial;
use Carbon\Carbon;
use App\Shop;

class TeachingMaterialAdminController extends Controller
{

    public function index(){
        $types = Type::all();
        $units = Unit::all();
        $shops = Shop::all();
        return view('admin.teaching-materials.index', compact('types','units','shops'));
    }

    public function showMaterials(){
        return datatables()->of(
            Material::query()->with('unit', 'type','shop')->where('type_id', 1)->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeMaterial(Request $req){
        //dd($req->all());

        DB::beginTransaction();

        if($req->id){
            $material = Material::find($req->id);
        }else{
            $material = new Material;
        }
        $material->bill_no = $req->bill_no;
        $material->name = $req->name;
        $material->price_unit = $req->price_unit;
        $material->amount = $req->amount;
        // $material->total_price = $req->total_price;
        $material->place = $req->place;

        $material->ready_to_use = $req->ready_to_use;
        $material->defective = $req->defective;

        $material->shop_id = $req->shop;
        $material->unit_id = $req->unit;
        $material->type_id = 1;
        $material->save();

        DB::commit();
        return redirect(route('manage-teaching-materials.index'))->with('success', 'บันทึกข้อมูลสำเร็จ!');
    }

    public function deleteMaterial(Request $req){
        //dd($req->all());
        $borrowMaterial = BorrowMaterial::where('material_id', $req->id)->whereIn('status', [0])->first();
        if($borrowMaterial){
            $data = [
                'title' => 'ลบไม่สำเร็จ',
                'msg' => 'มีรายการรออนุมัติ โปรดอนุมัติหรือยกเลิกรายการก่อน',
                'status' => 'error',
            ];

            return $data;
        }

        DB::beginTransaction();

        $material = Material::find($req->id);
        if($material->delete()){
            $data = [
                'title' => 'ลบสำเร็จ',
                'msg' => 'ลบรายการสำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'ลบรายการไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function addAmount(Request $req){

        DB::beginTransaction();
        $material = Material::find($req->id);
        $material->amount += $req->amount;
        $material->ready_to_use += $req->amount;

        $receiptMaterial = new ReceiptMaterial;
        $receiptMaterial->material_id =  $req->id;
        $receiptMaterial->amount = $req->amount;

        if($material->save() && $receiptMaterial->save()){
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'เพิ่มจำนวนวัสดุสำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'เพิ่มจำนวนวัสดุไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function history(){
        return view('admin.teaching-materials.history');
    }

    public function showHistory(){

        return datatables()->of(
            BorrowMaterial::query()->with('material.type','material.unit', 'user')
            ->whereHas('material', function ($query) {
                $query->where('type_id', 1);
            })
            ->orderBy('updated_at', 'desc')
        )->toJson();

    }

    public function approve(){
        return view('admin.teaching-materials.approve');
    }

    public function approveBorrow(Request $req){
        $id = $req->id;
        $status = $req->status;
        $text = $req->text;
        //  dd($req->all());
        if($status == 1){
            $borrowMaterial = BorrowMaterial::find($id);
            $borrowMaterial->status = $status;
            $borrowMaterial->approve_date = Carbon::now();
            $borrowMaterial->save();
        }

        if($status == 2){
            $borrowMaterial = BorrowMaterial::find($id);
            $borrowMaterial->status = $status;
            $borrowMaterial->approve_date = Carbon::now();
            $borrowMaterial->note = $text;
            $borrowMaterial->save();

            $material = Material::find($borrowMaterial->material_id);
            $material->amount += $borrowMaterial->amount;
            $material->save();
        }

        if($status == 3){
            $borrowMaterial = BorrowMaterial::find($id);
            $borrowMaterial->status = $status;
            $borrowMaterial->return_date = Carbon::now();
            $borrowMaterial->save();

            $material = Material::find($borrowMaterial->material_id);
            $material->amount += $borrowMaterial->amount;
            $material->save();
        }

        $data = [
            'title' => 'สำเร็จ',
            'msg' => 'ทำรายการสำเร็จแล้ว',
            'status' => 'success',
        ];
        return $data;
    }



}
