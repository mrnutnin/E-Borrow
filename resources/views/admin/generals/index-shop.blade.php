
@extends('layouts.admin.app')

@section('title', 'Main page')

@section('content')
    <style>

        #container{ padding:20px; background:#ccc;display:none;}
        .sweet-overlay{z-index:5000;}
        .sweet-alert{z-index:5001;}

    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="pull-right">
                        <button type="button" id="addBtn" class="btn btn-primary" >
                            <i class="fa fa-plus"></i> เพิ่ม
                        </button>
                    </div>
                    <h3>รายการหน่วยนับ</h3>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered" id="item_list_table" style="width:100%" >
                        <thead>
                            <tr >
                                <th>ID</th>
                                <th>ชื่อ</th>
                                <th>สร้างเมื่อ</th>
                                <th>แก้ไขล่าสุดเมื่อ</th>
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



    {{-- modal --}}

      <div class="modal fade" id="addItemModal"  aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title" id="exampleModalCenterTitle"> เพิ่ม </h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                        <input type="hidden" id="id" class="form-control">
                        <label for="">ชื่อ : </label>
                         <input type="text" id="name" class="form-control">
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="storeBtn">บันทึก</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script> --}}

<script>

var item_list_table = ''

$("#item_list_table").ready(function () {
     item_list_table = $('#item_list_table').DataTable({
        "searching": true,
        "responsive": true,
        "pageLength": 10,
        "order": [
            [3, "desc"]
        ],
        "ajax": {
            "url": "/generals/manage-shops/show",
            "method": "POST",
            "data": {
                "_token": "{{ csrf_token()}}",
            },
        },
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4],
                "className": "",
            },
        ],
        "columns": [{
                "data": "id",
            },
            {
                "data": "name",
            },

            {
                "data": "created_at",
            },
            {
                "data": "updated_at",

            },

            {
                "render": function (data, type, full) {
                    var obj = JSON.stringify(full);
                    return `
                            <button class="btn btn-warning btn-sm" onclick='editItem(${obj})''> แก้ไข</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteItem(${full.id})"> ลบ</button>
                            `;
                }
            },
        ],
    });

});



$('#storeBtn').click(function(){
    var name = $('#name').val();
    var id = $('#id').val();
    if(name == ''){
        $('#addItemModal').modal('hide');
        Swal.fire('ผิดพลาด', 'กรุณากรอกข้อมูล !', 'warning');
    }else{
        $.post("/generals/manage-shops/store", data = {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    id: id,
            },
                function (res) {
                    $('#addItemModal').modal('hide');
                    Swal.fire(res.title, res.msg, res.status);
                    item_list_table.ajax.reload();
                },
            );
    }

});

function editItem(obj) {
    $('#name').val(obj.name);
    $('#id').val(obj.id);
    $('#addItemModal').modal('show');
}

function deleteItem(id) {
    Swal.fire({
        title: 'คุณมั่นใจหรือไม่ ?',
        text: "คุณค้องการลบการรายการนี้ใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7A7978',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ตกลง',
    }).then((result) => {
        if (result.value) {
            $.post("/generals/manage-shops/delete", data = {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                function (res) {
                    Swal.fire(res.title, res.msg, res.status);
                    item_list_table.ajax.reload();
                },
            );
        }
    });
}

$('#addBtn').click(function(){
    $('#name').val('');
    $('#id').val('');
    $('#addItemModal').modal('show');
});

</script>
@stop
