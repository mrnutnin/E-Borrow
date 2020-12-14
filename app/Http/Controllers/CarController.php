<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Car;

class CarController extends Controller
{
    //
    public function index()
    {
        return view('admin.cars.index');
    }

    public function saveCar(Request $req)
    {
        //return $req->all();
        $carName =  $req->carName;
        $carPrice =  $req->carPrice;
        $id =  $req->id;

        DB::beginTransaction();

        if($id == null || $id == ''){
            $car = new Car;
            $car->name = $carName;
            $car->price = $carPrice;
            $car->save();
        }else{
            $car = Car::find($id);
            $car->name = $carName;
            $car->price = $carPrice;
            $car->save();
        }


        DB::commit();

        $res = [
            'title' => 'สำเร็จ',
            'msg' => 'บันทึกสำเร็จ',
            'status' => 'success',
        ];

        return $res;
    }

    public function showCar()
    {
        return datatables()->of(
            Car::query()->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function deleteCar(Request $req)
    {
        $id =  $req->id;

        DB::beginTransaction();

        Car::find($id)->delete();

        DB::commit();

        $res = [
            'title' => 'สำเร็จ',
            'msg' => 'ลบข้อมูลสำเร็จ',
            'status' => 'success',
        ];

        return $res;

    }

}
