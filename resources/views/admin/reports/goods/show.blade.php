<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>exeport-excel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }


        th {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        td {
            border: 1px solid #dddddd;
            padding: 8px;
        }


        tr:nth-child(even) {}

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="center">
                {{-- <h3>Export Excel</h3> --}}
                {{-- <h5>สรุปแต้มและผลประโยชน์ของสมาชิก ของ {{$thead['memberType']}} สาขา {{$thead['warehouse']}}</h5> --}}
                <br>
                <br>
                <br>
                <form action="{{ route('reports.goods.export')}}" method="POST">
                    @csrf
                    <input type="hidden" name="bigData" value="{{ json_encode($bigData) }}">
                    <button type="submit" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i> Export Excel </button>
                </form><br>

            </div>
            <span class="pull-right">
                <a href=" {{ route('reports.goods.index')}}" class="btn btn-info" > ย้อนกลับ </a>
            </span>
            <br><br><br>

            <table class="display nowrap" style="width:100%" id="simple_table">
                <thead>
                    <tr style="text-algin:center; ">
                        <th style="border: none;" colspan="13">รายการครุภัณฑ์ ประจำปีงบประมาณ  {{$bigData['thead']['year'] }}</th>
                    </tr>
                    <tr style="text-algin:center;">
                        <th style="border: none;" colspan="13">สาขาวิชาวิศวกรรมคอมพิวเตอร์ มหาวิทยาลัยเทคโนโลยีราชมงตลอีสาน วิทยาเขตขอนแก่น</th>
                    </tr>
                    @if($bigData['thead']['text'] != '')
                    <tr style="text-algin:center;">
                        <th style="border: none;" colspan="13">{{$bigData['thead']['text'] }}</th>
                    </tr>
                    @endif
                    <tr style="text-algin:center;">
                        <th rowspan="2">ที่</th>
                        <th rowspan="2">หน่วยงาน</th>
                        <th rowspan="2">วันที่ซื้อ</th>
                        <th rowspan="2">หมายเลขครุภัณฑ์</th>
                        <th rowspan="2">รายการ</th>
                        <th rowspan="2">จำนวน</th>
                        <th rowspan="2">หน่วยนับ</th>
                        <th rowspan="2">ราคาต่อหน่วย</th>
                        <th rowspan="2">ราคารวม</th>
                        <th colspan="2">สภาพ</th>
                        <th rowspan="2">สถานที่เก็บ</th>
                        <th rowspan="2">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <th>ปกติ</th>
                        <th>ชำรุด</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($bigData['tbodies'] as $row)
                    <tr>
                        <td> {{ $bigData['thead']['i'] ++ }} </td>
                        <td> {{ $row['department']['name'] }} </td>
                        <td style="text-align: center;"> {{ date("d/m/Y", strtotime($row['buy_date']))}} </td>
                        <td> {{ $row['good_no'] }} </td>
                        <td> {{ $row['name'] }} </td>
                        <td style="text-align: center;"> {{ $row['amount'] }} </td>
                        <td style="text-align: center;"> {{ $row['unit']['name'] }} </td>
                        <td style="text-align: right;"> {{ number_format($row['price_unit'], 2) }} </td>
                        <td style="text-align: right;"> {{ number_format($row['price_unit'] *  $row['amount'], 2) }} </td>
                        {{-- @if( $row['status'] == 1 )
                        <td style="text-align: center;">  </td>
                        <td>  </td>
                        @else
                        <td>  </td>
                        <td style="text-align: center;">  </td>
                        @endif --}}
                        <td style="text-align: center;"> {{ $row['ready_to_use'] }} </td>
                        <td style="text-align: center;"> {{ $row['defective'] }} </td>
                        <td> {{ $row['place'] }} </td>
                        <td> {{ $row['remark'] }} </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7"></th>
                        <th>รวม</th>
                        <th style="text-align: right;"> {{ number_format($bigData['tfoot']['total'], 2) }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</body>
</html>
