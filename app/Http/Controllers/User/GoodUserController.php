<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Good;
use App\BorrowGood;

class GoodUserController extends Controller
{
    public function index()
    {
        return view('user.goods.index');
    }

    public function showGoods()
    {
        return datatables()->of(
            Good::query()->with('unit', 'department')->orderBy('updated_at', 'desc')
        )->toJson();
    }

    public function orderGood(Request $req)
    {
        $user = Auth::user();
        $items = $req->array_items;
        $amounts = $req->array_amounts;
        $i = 0;
        DB::beginTransaction();

        foreach ($items as $item) {
            $borrow = new BorrowGood;
            $borrow->user_id = $user->id;
            $borrow->good_id = $item['id'];
            $borrow->amount = $amounts[$i];
            $borrow->action = 1;
            $borrow->save();

            $material = Good::find($item['id']);
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
        return view('user.goods.history');
    }

    public function showHistory(){

        $user = Auth::user();

        return datatables()->of(
            BorrowGood::query()->with('good.unit')->where('user_id', $user->id)->orderBy('id', 'asc')
        )->toJson();

    }

}
