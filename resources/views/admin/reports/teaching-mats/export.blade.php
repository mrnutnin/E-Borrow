<!DOCTYPE html>
{{-- <html lang="th"> --}}
<head>
    {{-- <meta http-equiv=”Content-Language” content=”th” /> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{-- <meta charset="utf-8"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>exeport-excel</title>
    <style>
          @font-face {
                font-family: 'THSarabunNew';
                font-style: normal;
                font-weight: normal;
                src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: normal;
                font-weight: bold;
                src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: italic;
                font-weight: normal;
                src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
            }
            @font-face {
                font-family: 'THSarabunNew';
                font-style: italic;
                font-weight: bold;
                src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
            }

        body {
            font-family: "THSarabunNew";
        }
        table {
            border-collapse: collapse;
            width: 100%;

        }


        th {
            border: 1px solid #dddddd;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        td {
            border: 1px solid #dddddd;
            padding: 3px;
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

                <table class="display nowrap" style="width:100%" id="simple_table">
                    <thead>
                        <tr style="text-algin:center; ">
                            <th style="border: none;" colspan="13"> {{ $bigData['thead']['text']}}  </th>
                        </tr>
                        <tr style="text-algin:center;">
                            <th style="border: none;" colspan="13">สาขาวิชาวิศวกรรมคอมพิวเตอร์ คณะวิศวกรรมศาสตร์ มหาวิทยาลัยเทคโนโลยีราชมงตลอีสาน วิทยาเขตขอนแก่น</th>
                        </tr>
                        {{-- @if($bigData['thead']['text'] != '')
                        <tr style="text-algin:center;">
                            <th style="border: none;" colspan="13">{{$bigData['thead']['text'] }}</th>
                        </tr>
                        @endif --}}
                        <tr style="text-algin:center;">
                            <th rowspan="2">ที่</th>
                            <th rowspan="2">รายการวัสดุ</th>
                            <th rowspan="2">หน่วย</th>
                            <th rowspan="2">ราคาต่อหน่วย</th>
                            <th colspan="2">คงเหลือยกมา</th>
                            <th colspan="2">รับ</th>
                            <th colspan="2">จ่าย</th>
                            <th colspan="2">คงเหลือ</th>
                            <th rowspan="2">หมายเหตุ</th>

                        </tr>
                        <tr style="text-algin:center;">
                            <th>จำนวน</th>
                            <th>จำนวนเงิน</th>
                            <th>จำนวน</th>
                            <th>จำนวนเงิน</th>
                            <th>จำนวน</th>
                            <th>จำนวนเงิน</th>
                            <th>จำนวน</th>
                            <th>จำนวนเงิน</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bigData['tbodies'] as $row)
                        <tr>
                            <td style="text-align: center;"> {{ $bigData['thead']['i'] ++ }}</td>
                            <td> {{ $row['mat']['name'] }} </td>
                            <td style="text-align: center;"> {{ $row['mat']['unit']['name'] }} </td>
                            <td style="text-align: right;"> {{ $row['mat']['price_unit'] }} </td>
                            <td style="text-align: right;"> {{ $row['remain'] }} </td>
                            <td style="text-align: right;"> {{ number_format($row['remain'] * $row['mat']['price_unit'], 2) }} </td>
                            <td style="text-align: right;"> {{ $row['receive'] }} </td>
                            <td style="text-align: right;"> {{ number_format($row['receive'] * $row['mat']['price_unit'], 2) }} </td>
                            <td style="text-align: right;"> {{ $row['spent'] }} </td>
                            <td style="text-align: right;"> {{ number_format($row['spent'] * $row['mat']['price_unit'], 2) }} </td>
                            <td style="text-align: right;"> {{ $row['balance'] }} </td>
                            <td style="text-align: right;"> {{ number_format($row['balance'] * $row['mat']['price_unit'], 2) }}  </td>
                            @if($row['mat']['amount'] == 0 )
                            <td> หมดสต๊อก </td>
                            @else
                            <td> </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        {{-- <tr>
                            <th colspan="7"></th>
                            <th>รวม</th>
                            <th style="text-align: right;"> </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr> --}}
                    </tfoot>
                </table>
        </div>
    </div>
</body>
</html>
