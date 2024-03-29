<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class GoodsExport2 implements FromView
{

    use Exportable;


    public function __construct($bigData)
    {

        $this->bigData = $bigData;

    }

    public function view(): View
    {
        return view('admin.reports.goods.export', ['bigData' => $this->bigData ]);
    }
}
