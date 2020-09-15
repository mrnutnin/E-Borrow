<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Good;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GoodAdminController extends Controller
{
    //
    public function index()
    {
        $departments = Department::all();
        $units = Unit::all();
        $goods = Good::with('unit', 'department')->get();
        //dd($goods);
        return view('goods.index', compact('goods', 'units', 'departments'));
    }

    public function showGood()
    {
        return datatables()->of(
            Good::query()->with('unit', 'department')->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeGood(Request $req){
        //dd($req->all());

        DB::beginTransaction();

        if($req->id){
            $good = Good::find($req->id);
        }else{
            $good = Good::where('good_no', $req->good_no)->first();
            if($good){
                return redirect('manage-goods')->with('error','หมายเลขครุภัณฑ์ซ้ำ กรุณากรอกข้อมูลใหม่ !');
            }
            $good = new Good;
        }
        $good->bill_no = $req->bill_no;
        $good->good_no = $req->good_no;
        $good->name = $req->name;
        $good->price_unit = $req->price_unit;
        $good->amount = $req->amount;
        // $good->total_price = $req->total_price;
        $good->department_id = $req->department;
        $good->unit_id = $req->unit;
        $good->place = $req->place;
        $good->status = $req->status;
        $good->buy_date = $req->buy_date;
        $good->save();

        DB::commit();
        return redirect('manage-goods')->with('success', 'บันทึกข้อมูลสำเร็จ!');
    }

    public function deleteGood(Request $req){
        //dd($req->all());
        DB::beginTransaction();
        $good = Good::find($req->id);
        if($good->delete()){
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
}
