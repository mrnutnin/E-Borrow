<?php

namespace App\Http\Controllers\Admin;

use App\BorrowGood;
use Carbon\Carbon;
use App\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Exports\GoodsExport;
use App\Exports\MatsExport;
use App\Exports\MatsExport2;
use App\Material;
use App\Type;
use App\ReceiptMaterial;
use App\BorrowMaterial;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

use function PHPSTORM_META\type;

class ReportController extends Controller
{
    //
    public function index(){
        $types = Type::all();
        return view('admin.reports.index', compact('types'));
    }

    public function indexGood()
    {
        $types = Type::all();
        return view('admin.reports.goods.index', compact('types'));
    }

    public function indexMaterial()
    {
        $types = Type::all();
        return view('admin.reports.mats.index', compact('types'));
    }

    public function showGoodReport(Request $req){

        $year = $req->year;
        $select = $req->select;


        $currentDate = date("d/m/Y", strtotime(Carbon::now()));
        $text = '';

        if($select == 1){
            $goods = Good::with('unit', 'department')
                ->orderBy('updated_at', 'desc')
                ->get();
            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->first();
        }else if($select == 2){
            $goods = Good::with('unit', 'department')
                ->where('price_unit' , '<', 5000)
                ->orderBy('updated_at', 'desc')
                ->get();

            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->where('price_unit' , '<=', 5000)->first();

            $text = 'รายการครุภัณฑ์ที่มีมูลค่าต่ำกว่า 5,000 บาท';

        }else{
            $goods = Good::with('unit', 'department')
                ->where('price_unit' , '>=', 5000)
                ->orderBy('updated_at', 'desc')
                ->get();

            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->where('price_unit' , '<=', 5000)->first();

            $text = 'รายการครุภัณฑ์ที่มีมูลค่ามากกว่า 5,000 บาท';
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
        if($req->type == 'excel'){
            return view('admin.reports.goods.show', compact('bigData'));
        }else{
            $pdf = PDF::loadView('admin.reports.goods.export', compact('bigData'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('report.pdf'); //แบบนี้จะ stream มา preview
        }

    }

    public function exportGoodExcel(Request $req){
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new GoodsExport($bigData), 'ExportExcel.xlsx');
    }

    public function showGoodReport2(Request $req)
    {
        $year = $req->year;
        $select = $req->select;


        $currentDate = date("d/m/Y", strtotime(Carbon::now()));
        $text = '';
        $text1 = '';
        $type = Type::find($select);
        if ($select == 1) {
            $goods = Good::with('unit', 'department')
            ->orderBy('updated_at', 'desc')
                ->get();
            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->first();
            $text1 = 'ทั้งหมด';
        } else if ($select == 2) {
            $goods = Good::with('unit', 'department')
            ->where('price_unit', '<', 5000)
            ->orderBy('updated_at', 'desc')
                ->get();

            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->where('price_unit', '<=', 5000)->first();

            $text1 = 'รายการครุภัณฑ์ที่มีมูลค่าต่ำกว่า 5,000 บาท';
        } else {
            $goods = Good::with('unit', 'department')
            ->where('price_unit', '>=', 5000)
            ->orderBy('updated_at', 'desc')
                ->get();

            $sum = Good::select(DB::raw('sum(amount * price_unit) as total'))->where('price_unit', '<=', 5000)->first();

            $text1 = 'รายการครุภัณฑ์ที่มีมูลค่ามากกว่า 5,000 บาท';
        }

        $text = 'แบบฟอร์มการตรวจครุภัณฑ์' . $type->name . 'คงเหลือประจำปีงบประมาณ ' . $year . ' ( '. $text1 .')';

        $tbodies = [];
        $goodIds = $goods->pluck('id');

        foreach ($goods as $mat) {
            $data = [];
            $remain = 0;
            $receive = 0;
            $spent = 0;
            $balance = 0;

            if ($select == 2 || $select == '2') {
                $remain =  BorrowGood::where('good_id', $mat->id)->whereIn('status', [0, 1])->sum('amount') + $mat->amount;
                $receive =  BorrowGood::where('good_id', $mat->id)->whereIn('status', [0, 1])->sum('amount') + $mat->amount;
                $spent = BorrowGood::where('good_id', $mat->id)->where('status', 1)->sum('amount');
                $balance = BorrowGood::where('good_id', $mat->id)->whereIn('status', [0])->sum('amount') + $mat->amount;
            } else {

                $remain =  BorrowGood::where('good_id', $mat->id)->whereIn('status', [0, 1])->sum('amount') + $mat->amount;
                $receive =  BorrowGood::where('good_id', $mat->id)->whereIn('status', [0, 1])->sum('amount') + $mat->amount;
                $spent = BorrowGood::where('good_id', $mat->id)->where('status', 1)->sum('amount');
                $balance = $receive - $spent;
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

        if ($req->type == 'excel') {
            return view('admin.reports.goods.show2', compact('bigData'));
        } else {
            $pdf = PDF::loadView('admin.reports.goods.export2', compact('bigData'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('report.pdf'); //แบบนี้จะ stream มา preview
        }

    }

    public function exportGoodExcel2(Request $req)
    {
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new GoodsExport($bigData), 'ExportExcel.xlsx');
    }



    public function showMatReport(Request $req){

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
                $remain =  BorrowMaterial::where('material_id', $mat->id)->whereIn('status', [0,1])->sum('amount') + $mat->amount;
                $receive =  BorrowMaterial::where('material_id', $mat->id)->whereIn('status', [0,1])->sum('amount') + $mat->amount;
                $spent = BorrowMaterial::where('material_id', $mat->id)->where('status', 1)->sum('amount');
                $balance = BorrowMaterial::where('material_id', $mat->id)->whereIn('status', [0])->sum('amount') + $mat->amount;

            }else{

                $remain =  BorrowMaterial::where('material_id', $mat->id)->whereIn('status', [0,1])->sum('amount') + $mat->amount;
                $receive =  BorrowMaterial::where('material_id', $mat->id)->whereIn('status', [0,1])->sum('amount')+ $mat->amount;
                $spent = BorrowMaterial::where('material_id', $mat->id)->where('status', 1)->sum('amount');
                $balance = $receive - $spent;
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

        if ($req->type == 'excel') {
            return view('admin.reports.mats.show', compact('bigData'));
        } else {
            $pdf = PDF::loadView('admin.reports.mats.export', compact('bigData'));
            $pdf->setPaper('A4', 'landscape');
           return $pdf->stream('report.pdf'); //แบบนี้จะ stream มา preview
        }

        //return view('admin.reports.mats.show' ,compact('bigData'));
    }

    public function exportMatExcel(Request $req){
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new MatsExport($bigData), 'ExportExcel.xlsx');
    }

    public function showMatReport2(Request $req)
    {

        $year = $req->year;
        $type = $req->type;
        $select = $req->select;


        $currentDate = date("d/m/Y", strtotime(Carbon::now()));


        $text = 'รายการวัสดุทั้งหมด';
        $mats = Material::with('unit', 'type')
            ->where('type_id', $select)
            ->orderBy('updated_at', 'desc')
            ->get();

        $sum = Material::where('type_id', $select)->select(DB::raw('sum(amount * price_unit) as total'))->first();
        // return $select;
        $type = Type::find($select);
        // return $type;
        $text = 'รายการวัสดุ' . $type->name;



        $thead = [
            "currentDate" => $currentDate,
            "year" => $year,
            "i" => 1,
            "text" => $text,
        ];

        $bigData = [
            "thead" => $thead,
            "tbodies" => $mats,
            "tfoot" => $sum,
        ];

        if ($req->type == 'excel') {
            return view('admin.reports.mats.show2', compact('bigData'));
        } else {
            $pdf = PDF::loadView('admin.reports.mats.export2', compact('bigData'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('report.pdf'); //แบบนี้จะ stream มา preview
        }

        //return view('admin.reports.mats.show' ,compact('bigData'));
    }

    public function exportMatExcel2(Request $req)
    {
        $bigData = json_decode($req->bigData, true);

        return Excel::download(new MatsExport2($bigData), 'ExportExcel.xlsx');
    }



}
