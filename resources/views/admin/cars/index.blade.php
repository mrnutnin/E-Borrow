
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
                        {{-- <button type="button" id="modal1Btn" class="btn btn-primary" >
                            <i class="fa fa-plus"></i> สร้างบิล
                        </button> --}}
                        <button type="button" id="modal2Btn" class="btn btn-primary">
                            <i class="fa fa-plus"></i> เพิ่มรถ
                        </button>
                    </div>
                    <h3>รายการรถ</h3>
                </div>

                <div class="ibox-content">


                    <table class="table table-bordered" id="item_list_table" style="width:100%" >
                        <thead>
                            <tr >
                                <th>ID</th>
                                <th>ชื่อรถ</th>
                                <th>ราคา</th>
                                <th>ราคาขาย</th>
                                <th>วันที่แก้ไขล่าสุด</th>
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

    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มรถ</h4>
                </div>
                <div class="modal-body">

                    {{-- <form action="{{ route('manage-materials.store') }}" id="addMaterialForm" method="POST">
                        @csrf --}}
                        <input type="hidden" class="form-control" id="id" name="id" >

                        <label>ชื่อรถ</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="car_name" name="car_name" placeholder="Ex 1235">
                        </div>

                        <label><span style="color:red">*</span>ราคา</label>
                        <div class="form-group">
                            <input type="number" step=0.01 class="form-control" id="car_price" name="car_price" placeholder="Ex 1235" required>
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">ยกเลิก</button>
                            <button type="button" id="saveCarBtn" class="btn btn-primary">บันทึก</button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script> --}}

<script>

var item_list_table = '';

$( "#modal2Btn" ).click(function() {
    $("#car_name").val('');
    $("#car_price").val('');
    $("#id").val('');
    $('#modal2').modal('show');
    $('#myModalLabel').text('เพิ่มรถ');
    // console.log('ok');
});

$( "#saveCarBtn" ).click(function() {
    var carName = $("#car_name").val();
    var carPrice = $("#car_price").val();
    var id = $("#id").val();

    if( carName != '' && carPrice != ''){

        $.post("/cars/save", data = {
                _token: '{{ csrf_token() }}',
                carName: carName,
                carPrice: carPrice,
                id: id,
            },
            function (res) {
                $('#modal2').modal('hide');
                Swal.fire(res.title, res.msg, res.status);

                item_list_table.ajax.reload();
            },
        );

    }else{
        $('#modal2').modal('hide');
        Swal.fire('ผิดพลาด', 'กรุณากรอกข้อมูลให้ครบทุกช่อง', 'error');
    }

});



$("#item_list_table").ready(function () {

    item_list_table = $('#item_list_table').DataTable({
        "searching": true,
        "responsive": true,
        "pageLength": 10,
        "order": [
            [0, "asc"]
        ],
        "ajax": {
            "url": "/cars/show",
            "method": "POST",
            "data": {
                "_token": "{{ csrf_token()}}",
            },
        },
        'columnDefs': [
            {
                "targets": [0, 1, 2,3,4],
                "className": "text-center",
            },
        ],
        "columns": [{
                "data": "id",
            },
            {
                "data": "name",
            },
            {
                "data": "price",
            },
            {
                "render": function (data, type, full) {
                    return full.price*2;
                }
            },
            {
                "render": function (data, type, full) {
                    return moment(full.updated_at).format('DD-MM-YYYY');
                }
            },

            {
                "render": function (data, type, full) {
                    var obj = JSON.stringify(full);
                    var text = '';
                    text = `<button type="button" onclick='showInfo(${obj})' class="btn btn-success btn-sm">ดูรายละเอียด</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCar(${full.id})"> ลบ</button>`;
                    return text;

                }
            },

        ],
    });
});

function showInfo(obj) {
    console.log('OK');
    $('#modal2').modal('show');
    $('#id').val(obj.id);
    $('#car_name').val(obj.name);
    $('#car_price').val(obj.price);
    $('#myModalLabel').text('รายละเอียดรถ');

}

function deleteCar(id) {

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
            $.post("/cars/delete", data = {
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




</script>
@stop
