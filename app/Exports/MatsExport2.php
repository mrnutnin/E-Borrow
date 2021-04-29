<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class MatsExport2 implements FromView
{

    use Exportable;


    public function __construct($bigData)
    {

        $this->bigData = $bigData;

    }

    public function view(): View
    {
        return view('admin.reports.mats.export2', ['bigData' => $this->bigData ]);
    }
}
