
@extends('layouts.admin.app')

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
                    <h3>อนุมัติการเบิก - คืน วัสดุ</h3>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered" id="approve_list_table" style="width:100%" >
                        <thead>
                            <tr>

                                <th>ID</th>
                                <th>วันที่ทำรายการ</th>
                                <th>รายการ</th>
                                <th>จำนวน</th>
                                <th>หน่วย</th>
                                {{-- <th>ประเภท</th> --}}
                                <th>ชื่อผู้ยืม</th>
                                {{-- <th>action</th> --}}
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

    <!-- Modal -->
<div class="modal fade" id="notemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h3 class="modal-title" id="exampleModalLabel">เหตุผลที่ไม่อนุมัติ</h3>
        </div>
        <div class="modal-body text-center" >
            <span style="font-size: 150%" class="notepreview"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        "url": "/manage-teaching-materials/show-histories",
        "method": "POST",
        "data": {
            "_token": "{{ csrf_token()}}",
        },
    },
    'columnDefs': [
        {
            "targets": [6, 7],
            "className": "text-center",
        },
    ],
    "columns": [
        {
            "data": "id",
        },
        {
        "render": function (data, type, full) {
            var text = moment(full.updated_at).format('DD/MM/YYYY');
                return  text;
            }
        },
        {
            "data": "name",
        },
        {
            "data": "amount",
        },
        {
            "data": "unit",
        },
        // {
        //     "data": "type",
        // },
        {
            "data": "user_name",
        },
        // {
        // "render": function (data, type, full) {
        //     var text = '';
        //         if(full.action == 1){
        //             text = 'ยืม';
        //         }else{
        //             text = 'คืน';
        //         }
        //         return  text;
        //     }
        // },
        {
        "render": function (data, type, full) {
            var text = '';
                if(full.status == 0){
                    text = '<span class="badge badge-warning">รอดำเนินการ</span>';
                }else if (full.status == 1){
                    text = '<span class="badge badge-warning">ยังไม่คืน</span>';
                }else if (full.status == 2){
                    text = '<span class="badge badge-danger">ไม่อนุมัติ</span>';
                }else if (full.status == 3){
                    text = '<span class="badge badge-primary">คืนแล้ว</span>';
                }
                if(full.status == 1 && full.type == 'สิ้นเปลือง' ){
                    text = '<span class="badge badge-success">ไม่ต้องคืน</span>';
                }

                return  text;
            }
        },
        {
        "render": function (data, type, full) {
            var text = '';
            if(full.status == 1){
                text = `<button class="btn btn-primary btn-xs" onclick="updateStatus(${full.id},3)"><i class="ri-checkbox-circle-fill"></i> คืน </button>`;
            }else if(full.status == 0 ){
                text = `<button class="btn btn-primary btn-xs" onclick="updateStatus(${full.id},1)"><i class="ri-checkbox-circle-fill"></i> อนุมัติ </button>
                        <button class="btn btn-danger btn-xs" onclick="updateStatus(${full.id},2)"><i class="ri-close-circle-fill"></i> ไม่อนุมัติ </button>
                        `;
            }else if (full.status == 2){
                text = `<span class="badge badge-danger" onclick="popNote('${full.note}')">${moment(full.approve_date).format('DD MMMM YYYY')}</span>`;
            }else if (full.status == 3){
                text = `<span class="badge badge-primary">${moment(full.return_date).format('DD MMMM YYYY')}</span>`;
            }
            if(full.status == 1 && full.type == 'สิ้นเปลือง' ){
                text = '';
            }

            return  text;
            }
        },


    ],
    });
});


function updateStatus(id,status){

        if(status == 2){
            var text = ''

            Swal.fire({
                title: "ไม่อนุมัติ!",
                text: "กรุณากรอกเหตุผลที่ไม่อนุมัติ:",
                input: 'text',
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    text = result.value;
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
                            $.post("/manage-teaching-materials/approve-borrow", data = {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    status: status,
                                    text: text,
                                },
                                function (res) {
                                    swal.fire(res.title, res.msg, res.status);
                                    approve_list_table.ajax.reload();
                                    countMatApprove();
                                },
                            );

                        }
                    });
                }
            });

        }else{
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
                    $.post("/manage-teaching-materials/approve-borrow", data = {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: status,
                        },
                        function (res) {
                            swal.fire(res.title, res.msg, res.status);
                            approve_list_table.ajax.reload();
                            countMatApprove();
                        },
                    );

                }
            });
        }




}

function popNote(text){
    console.log('OK');
    var note = 'ไม่พบข้อมูล'
    if(text  != null || text != undefined || text != '' || text.leght != 0){
        note = text;
        $('.notepreview').text(note);
    }else{
        note = 'ไม่พบข้อมูล'
         $('.notepreview').text(note);
    }
    console.log(note)

    $('#notemodal').modal('show');
}
</script>
@stop

