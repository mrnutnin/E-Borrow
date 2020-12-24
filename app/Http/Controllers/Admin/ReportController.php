<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Exports\GoodsExport;
use App\Exports\MatsExport;
use App\Material;
use App\Type;
use App\ReceiptMaterial;
use App\BorrowMaterial;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    public function index(){
        $types = Type::all();
        return view('admin.reports.index', compact('types'));
    }

    public function showGoodExcel(Request $req){

        $year = $req->year;
        $select = $req->select;


        $currentDate = date("d/m/Y", strtotime(Carbon::now()));
        $text = '';

        if($select == 1){
            $goods = Good::with('unit', 'department')
                ->orderBy('updated_at', 'desc')
                ->get();
            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->first();
        }else{
            $goods = Good::with('unit', 'department')
                ->where('price_unit' , '<=', 5000)
                ->orderBy('updated_at', 'desc')
                ->get();

            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->where('price_unit' , '<=', 5000)->first();

            $text = 'รายการครุภัณฑ์ที่มีมูลค่าต่ำกว่า 5,000 บาท';
        }

        $thead = [
            "currentDate" => $currentDate,
            "year" => $year,
            "i" => 1,
            "text" => $text,
        ];

        $bigData = [
            "thead" => $thead,
            "tbodies" => $goods,
            "tfoot" => $sum,
        ];
        //return $bigData ;
       return view('admin.reports.goods.show' ,compact('bigData'));
    }

    public function exportGoodExcel(Request $req){
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new GoodsExport($bigData), 'ExportExcel.xlsx');
    }

    public function showMatExcel(Request $req){

        $year = $req->year;
        $select = $req->select;


        $currentDate = date("d/m/Y", strtotime(Carbon::now()));
        $text = '';

        $type = Type::find($select);

        $mats = Material::with('unit', 'type')
                ->where('type_id', $select)
                ->orderBy('updated_at', 'desc')
                ->get();

        $sum = Material::select(DB::raw('sum(amount * price_unit) as total'))->first();

        $text = 'แบบฟอร์มการตรวจวัสดุ'.$type->name.'คงเหลือประจำปีงบประมาณ '.$year.' (ตรวจนับวัสดุคงเหลือ)';

        $tbodies = [];

        foreach($mats as $mat){
            $data = [];
            $remain = 0;
            $receive = 0;
            $spent = 0;
            $balance = 0;

            if($select == 2 || $select == '2'){
                $remain = ReceiptMaterial::where('material_id', $mat->id)->sum('amount') + BorrowMaterial::where('material_id', $mat->id)->where('status', 1)->sum('amount') + $mat->amount;
                $receive = ReceiptMaterial::where('material_id', $mat->id)->sum('amount') + BorrowMaterial::where('material_id', $mat->id)->where('status', 1)->sum('amount') + $mat->amount;
                $spent = BorrowMaterial::where('material_id', $mat->id)->where('status', 1)->sum('amount');
                $balance = BorrowMaterial::where('material_id', $mat->id)->where('status', 0)->sum('amount') + $mat->amount;

            }else{

                $remain = ReceiptMaterial::where('material_id', $mat->id)->sum('amount') + BorrowMaterial::where('material_id', $mat->id)->where('approve_date', '!=', null)->sum('amount') + $mat->amount;
                $receive = ReceiptMaterial::where('material_id', $mat->id)->sum('amount') + BorrowMaterial::where('material_id', $mat->id)->where('approve_date', '!=', null)->sum('amount')+ $mat->amount;
                $spent = BorrowMaterial::where('material_id', $mat->id)->where('approve_date', '!=', null)->sum('amount');
                $balance = $mat->amount;
            }




            $data = [
                "mat" => $mat,
                "remain" => $remain,
                "receive" => $receive,
                "spent" => $spent,
                "balance" => $balance,
            ];

            array_push($tbodies, $data);
        }



        $thead = [
            "currentDate" => $currentDate,
            "year" => $year,
            "i" => 1,
            "text" => $text,
        ];

        $bigData = [
            "thead" => $thead,
            "tbodies" => $tbodies,
            "tfoot" => $sum,
        ];

        return view('admin.reports.mats.show' ,compact('bigData'));
    }

    public function exportMatExcel(Request $req){
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new MatsExport($bigData), 'ExportExcel.xlsx');
    }
}
