
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
                    <table class="table table-bordered" id="approve_list_table" style="width:100%" >
                        <thead>
                            <tr>

                                <th>ID</th>

                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                                <th>ประเภท</th>
                                <th>ชื่อผู้ยืม</th>
                                <th>วันที่ทำรายการ</th>
                                <th>สถานะ</th>
                                <th></th>
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

 var approve_list_table = $('#approve_list_table');

$("#approve_list_table").ready(function () {

    approve_list_table = $('#approve_list_table').DataTable({
    "searching": true,
    "responsive": true,
    "pageLength": 10,
    "order": [
        [0, "desc"]
    ],
    "ajax": {
        "url": "/manage-goods/show-histories",
        "method": "POST",
        "data": {
            "_token": "{{ csrf_token()}}",
        },
    },
    'columnDefs': [
        {
            "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
            "className": "text-center",
        },
    ],
    "columns": [
        {
            "data": "id",
        },
        {
            "data": "good.good_no",
        },
        {
            "data": "good.name",
        },
        {
            "data": "amount",
        },
        {
            "data": "good.unit.name",
        },
        {
            "data": "user.name",
        },
        {
        "render": function (data, type, full) {
            var text = moment(full.updated_at).format('DD/MM/YYYY');
                return  text;
            }
        },
        {
        "render": function (data, type, full) {
            var text = '';
                if(full.status == 0){
                    text = '<span class="badge badge-secondary">รอดำเนินการ</span>';
                }else if (full.status == 1){
                    text = '<span class="badge badge-warning">ยังไม่คืน</span>';
                }else if (full.status == 2){
                    text = '<span class="badge badge-danger">ไม่อนุมัติ</span>';
                }else if (full.status == 3){
                    text = '<span class="badge badge-primary">คืนแล้ว</span>';
                }
                return  text;
            }
        },
        {
        "render": function (data, type, full) {
            var text = '';
            if(full.status == 1){
                text = `<button class="btn btn-primary btn-sm" onclick="updateStatus(${full.id},3)"><i class="ri-checkbox-circle-fill"></i> คืน </button>`;
            }else if(full.status == 0 ){
                text = `<button class="btn btn-primary btn-sm" onclick="updateStatus(${full.id},1)"><i class="ri-checkbox-circle-fill"></i> อนุมัติ </button>
                        <button class="btn btn-danger btn-sm" onclick="updateStatus(${full.id},2)"><i class="ri-close-circle-fill"></i> ไม่อนุมัติ </button>
                        `;
            }else if (full.status == 2){
                text = `<span class="badge badge-danger">${moment(full.approve_date).format('DD MMMM YYYY')}</span>`;
            }else if (full.status == 3){
                text = `<span class="badge badge-primary">${moment(full.return_date).format('DD MMMM YYYY')}</span>`;
            }
            return  text;
            }
        },


    ],
    });
});


function updateStatus(id,status){
    Swal.fire({
            title: 'คุณมั่นใจหรือไม่ ?',
            text: "คุณมั่นใจที่จะดำเนินการต่อไปหรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#7A7978',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',

        }).then((result) => {
            if (result.value) {
                $.post("/manage-goods/approve-borrow", data = {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: status,
                    },
                    function (res) {
                        swal.fire(res.title, res.msg, res.status);
                        approve_list_table.ajax.reload();
                    },
                );

            }
        });

}
</script>
@stop

