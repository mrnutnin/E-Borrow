<?php

namespace App\Http\Controllers\Admin;

use App\Type;
use App\Unit;
use App\Department;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    //Setting units
    public function indexUnit(){
        return view('admin.generals.index-unit');
    }

    public function showUnits(){
        return datatables()->of(
            Unit::query()->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeUnit(Request $req){


        DB::beginTransaction();

        if($req->id){
            $unit = Unit::find($req->id);
        }else{
            $unit = new Unit;
        }
        $unit->name = $req->name;
        if( $unit->save()){
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'บันทึกรายการสำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'บันทึกรายการไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function deleteUnit(Request $req){
        //dd($req->all());
        DB::beginTransaction();
        $unit = Unit::find($req->id);
        if($unit->delete()){
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

    //Setting types
    public function indexType(){
        return view('admin.generals.index-type');
    }

    public function showTypes(){
        return datatables()->of(
            Type::query()->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeType(Request $req){
        DB::beginTransaction();

        if($req->id){
            $type = Type::find($req->id);
        }else{
            $type = new Type;
        }
        $type->name = $req->name;
        if( $type->save()){
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'บันทึกรายการสำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'บันทึกรายการไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function deleteType(Request $req){
        //dd($req->all());
        DB::beginTransaction();
        $type = Type::find($req->id);
        if($type->delete()){
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

    //Setting departments
    public function indexDepartment(){
        return view('admin.generals.index-department');
    }

    public function showDepartments(){
        return datatables()->of(
            Department::query()->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeDepartment(Request $req){
        //dd($req->all());
        DB::beginTransaction();

        if($req->id){
            $department = Department::find($req->id);
        }else{
            $department = new Department;
        }
        $department->name = $req->name;
        if( $department->save()){
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'บันทึกรายการสำเร็จ',
                'status' => 'success',
            ];
        }else{
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'บันทึกรายการไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function deleteDepartment(Request $req){
        //dd($req->all());
        DB::beginTransaction();
        $department = Department::find($req->id);
        if($department->delete()){
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

    //Setting Shops
    public function indexShop()
    {
        return view('admin.generals.index-shop');
    }

    public function showShops()
    {
        return datatables()->of(
            Shop::query()->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function storeShop(Request $req)
    {
        //dd($req->all());
        DB::beginTransaction();

        if ($req->id) {
            $department = Shop::find($req->id);
        } else {
            $department = new Shop;
        }
        $department->name = $req->name;
        if ($department->save()) {
            $data = [
                'title' => 'บันทึกสำเร็จ',
                'msg' => 'บันทึกรายการสำเร็จ',
                'status' => 'success',
            ];
        } else {
            $data = [
                'title' => 'เกิดข้อผิดพลาด',
                'msg' => 'บันทึกรายการไม่สำเร็จ',
                'status' => 'error',
            ];
        }
        DB::commit();

        return $data;
    }

    public function deleteShop(Request $req)
    {
        //dd($req->all());
        DB::beginTransaction();
        $department = Shop::find($req->id);
        if ($department->delete()) {
            $data = [
                'title' => 'ลบสำเร็จ',
                'msg' => 'ลบรายการสำเร็จ',
                'status' => 'success',
            ];
        } else {
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
