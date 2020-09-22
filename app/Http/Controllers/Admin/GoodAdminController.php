<?php

namespace App\Http\Controllers\Admin;

use App\BorrowGood;
use App\Department;
use App\Good;
use App\Unit;
use App\ReceiptGood;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GoodAdminController extends Controller
{
    public function index(){
        $departments = Department::all();
        $units = Unit::all();
        $goods = Good::with('unit', 'department')->get();
        //dd($goods);
        return view('admin.goods.index', compact('goods', 'units', 'departments'));
    }

    public function showGood(){
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

    public function addAmount(Request $req){

        DB::beginTransaction();
        $good = Good::find($req->id);
        $good->amount += $req->amount;

        $receiptGood = new ReceiptGood;
        $receiptGood->good_id =  $req->id;
        $receiptGood->amount = $req->amount;

        if($good->save() && $receiptGood->save()){
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'เพิ่มจำนวนครุภัณฑ์สำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'เพิ่มจำนวนครุภัณฑ์ไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function history(){
        return view('admin.goods.history');
    }

    public function showHistory(){

        return datatables()->of(
            BorrowGood::query()->with('good.unit', 'user')->orderBy('updated_at', 'desc')
        )->toJson();

    }

    public function approve(){
        return view('admin.goods.approve');
    }

    public function approveBorrow(Request $req){
        $id = $req->id;
        $status = $req->status;

        if($status == 1){
            $borrowGood = BorrowGood::find($id);
            $borrowGood->status = $status;
            $borrowGood->approve_date = Carbon::now();
            $borrowGood->save();
        }

        if($status == 2){
            $borrowGood = BorrowGood::find($id);
            $borrowGood->status = $status;
            $borrowGood->approve_date = Carbon::now();
            $borrowGood->save();

            $good = Good::find($borrowGood->good_id);
            $good->amount += $borrowGood->amount;
            $good->save();
        }

        if($status == 3){
            $borrowGood = BorrowGood::find($id);
            $borrowGood->status = $status;
            $borrowGood->return_date = Carbon::now();
            $borrowGood->save();

            $good = Good::find($borrowGood->good_id);
            $good->amount += $borrowGood->amount;
            $good->save();
        }

        $data = [
            'title' => 'สำเร็จ',
            'msg' => 'ทำรายการสำเร็จแล้ว',
            'status' => 'success',
        ];
        return $data;
    }
}
