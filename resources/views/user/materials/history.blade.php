
@extends('layouts.home.app')

@section('title', 'Main page')

@section('content')
    <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    tr:hover {background-color:#f5f5f5;}
    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="pull-right">

                    </div>
                    <h3>ประวัติการเบิก - คืน วัสดุ</h3>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered" id="history_list_table" style="width:100%" >
                        <thead>
                            <tr>

                                <th>ID</th>
                                <th>วันที่ทำรายการ</th>
                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                                <th>ประเภท</th>
                                <th>action</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script> --}}

<script>

$("#history_list_table").ready(function () {

    var history_list_table = $('#history_list_table').DataTable({
    "searching": true,
    "responsive": true,
    "pageLength": 10,
    "order": [
        [0, "asc"]
    ],
    "ajax": {
        "url": "/materials/show-histories",
        "method": "POST",
        "data": {
            "_token": "{{ csrf_token()}}",
        },
    },
    'columnDefs': [
        {
            "targets": [0, 1, 2, 3, 4, 5, 6, 7],
            "className": "text-center",
        },
    ],
    "columns": [{
            "data": "id",
        },
        {
            "data": "updated_at",
        },
        {
            "data": "material.name",
        },
        {
            "data": "amount",
        },
        {
            "data": "material.unit.name",
        },
        {
            "data": "material.type.name",
        },
        {
        "render": function (data, type, full) {
            var text = '';
                if(full.action == 1){
                    text = 'ยืม';
                }else{
                    text = 'คืน';
                }
                return  text;
            }
        },
        {
            "render": function (data, type, full) {
            var text = '';
                if(full.status == 0){
                    text = '<span class="badge badge-secondary">รอดำเนินการ</span>';
                }else if (full.status == 1){
                    text = '<span class="badge badge-primary">อนุมัติแล้ว</span>';
                }else if (full.status == 2){
                    text = '<span class="badge badge-danger">ไม่อนุมัติ</span>';
                }
                return  text;
            }
        },

    ],
    });
});
</script>
@stop

