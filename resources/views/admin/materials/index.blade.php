
@extends('layouts.admin.app')

@section('title', 'Main page')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="pull-right">
                        {{-- <button type="button" id="modal1Btn" class="btn btn-primary" >
                            <i class="fa fa-plus"></i> สร้างบิล
                        </button> --}}
                        <button type="button" id="modal2Btn" class="btn btn-primary">
                            <i class="fa fa-plus"></i> เพิ่มรายการวัสดุ
                        </button>
                    </div>
                    <h3>รายการวัสดุ</h3>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered" id="item_list_table" style="width:100%;" >
                        <thead>
                            <tr >

                                <th>ID</th>
                                <th>เลขที่บิล</th>
                                <th>ชื่อวัสดุ</th>
                                <th>ประเภทวัสดุ</th>
                                <th>ราคาต่อหน่วย</th>
                                <th>จำนวนคงเหลือ</th>
                                <th>หน่วยนับ</th>
                                {{-- <th>จำนวนเงิน</th> --}}
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
    {{-- add good modal --}}
    {{-- <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มบิล</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manage-materials.add-bill') }}" id="addMaterialForm" method="POST">
                        @csrf
                        <label><span style="color:red">*</span>เลขที่บิล</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="bill_code" name="bill_code" placeholder="Ex 1235" required>
                        </div>

                        <label><span style="color:red">*</span>วันที่ออกบิล</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="doc_date" name="doc_date"  required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">ยกเลิก</button>
                            <button type="submit"  class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- add good modal --}}
    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มรายการวัสดุ</h4>
                </div>
                <div class="modal-body">

                    <form action="{{ route('manage-materials.store') }}" id="addMaterialForm" method="POST">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" >

                        <label>เลขที่บิล</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="bill_no" name="bill_no" placeholder="Ex 1235">
                        </div>

                        <label><span style="color:red">*</span>ชื่อวัสดุ</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ex 1235" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label><span style="color:red">*</span>ราคาต่อหน่วย</label>
                                <div class="form-group">
                                    <input type="number" step="0.01" class="form-control" maxlength="8" id="price_unit" name="price_unit" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label><span style="color:red">*</span>จำนวน</label>
                                <div class="form-group">
                                        <input type="number" class="form-control" maxlength="8" id="amount" name="amount" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <label><span style="color:red">*</span>หน่วยนับ</label>
                                <div class="form-group">
                                    <select id="unit" name="unit" class="form-control" required>
                                        <option value="">กรุณาเลือก</option>
                                        @foreach ( $units as $unit)
                                            <option value={{$unit->id}}>{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label><span style="color:red">*</span>ประเภทวัสดุ</label>
                                <div class="form-group">
                                    <select id="type" name="type" class="form-control" required>
                                        <option value="">กรุณาเลือก</option>
                                        @foreach ( $types as $type)
                                            <option value={{$type->id}}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">ยกเลิก</button>
                            <button type="submit"  class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script> --}}

<script>


$( "#modal1Btn" ).click(function() {
    $('#modal1').modal('show');
    console.log('ok');
});


$( "#modal2Btn" ).click(function() {
    $('#modal2').modal('show');
    console.log('ok');
});
var item_list_table = '';

$("#item_list_table").ready(function () {

     item_list_table = $('#item_list_table').DataTable({
        "searching": true,
        "responsive": true,
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        // "pageLength": 10,
        "order": [
            [5, "asc"]
        ],
        "ajax": {
            "url": "/manage-materials/show-materials",
            "method": "POST",
            "data": {
                "_token": "{{ csrf_token()}}",
            },
        },
        'columnDefs': [
            {
                "targets": [0, 1, 2, 3, 4, 5, 6, 7,8],
                "className": "text-center",
            },
        ],
        "columns": [{
                "data": "id",
            },
            {
                "data": "bill_code",
            },
            {
                "data": "name",
            },
            {
                "data": "type.name",
            },
            {
                "render": function (data, type, full) {
                    return full.price_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            {
                "data": "amount",
                "render": function (data, type, full) {
                     var text = `<span style="color : green;"><b>${full.amount}</b></span>`;
                    if (full.amount == 0){
                        text = `<span style="color : red;"><b>${full.amount}</b></span>`;
                    }
                    return text;
                }
            },
            {
                "data": "unit.name",
            },
            {
                "render": function (data, type, full) {
                    return moment(full.updated_at).format('DD/MM/YYYY');
                }
            },
            {
                "render": function (data, type, full) {
                    var obj = JSON.stringify(full);
                    // <button type="button" onclick='infoMaterial(${obj})' class="btn btn-success btn-sm">ดูรายละเอียด</button>
                    return `
                            <button type="button" onclick='addAmount(${full.id})' class="btn btn-success btn-sm">เพิ่ม</button>
                            <button class="btn btn-warning btn-sm" onclick='editMaterial(${obj})'> แก้ไข</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteMaterial(${full.id})"> ลบ</button>
                            `;
                }
            },
        ],
    });
});

$('#price_unit, #amount').on('change keyup', function() {
    var priceUnit = $("#price_unit").val();
    var amount = $("#amount").val();
    console.log(priceUnit);
    console.log(amount);
    if(priceUnit && amount){
        var totalPrice = priceUnit * amount;
        $("#total_price").val(totalPrice);
        console.log('total_price : '+totalPrice);
    }
    if(priceUnit == undefined || amount == undefined || priceUnit == '' || amount == ''){
        $("#total_price").val('');
        console.log('total_price : '+totalPrice);
    }
});

function deleteMaterial(id) {
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
            $.post("/manage-materials/delete", data = {
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

$( "#addMaterialBtn" ).click(function() {

    $('.form-control').closest('form').find("input[type=text], input[type=number], input[type=date]").val("");
    // $('#amount').val('').attr('readonly', false);
    $('#addItemModal').modal('show');
    console.log('ok');
});

function editMaterial(material) {
    var id = $('#id').val(material.id);
    // var bill_no = $('#bill_no').val(material.bill_no);
    var name = $('#name').val(material.name);
    var price_unit = $('#price_unit').val(material.price_unit);
    // var amount = $('#amount').val(material.amount).attr('readonly', true);
    var amount = $('#amount').val(material.amount);
    var unit = $('#unit').val(material.unit.id);
    var total_price = $('#total_price').val(material.amount * material.price_unit);
    var type = $('#type').val(material.type.id);
    $('#modal2').modal('show');
    console.log('ok');
}

function infoMaterial(material) {
    console.log(material);
    $('#id_').text(material.id);
    $('#bill_no_').text(material.bill_no);
    $('#name_').text(material.name);;
    $('#price_unit_').text(material.price_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#amount_').text(material.amount);
    $('#unit_').text(material.unit.name);
    $('#total_price_').text(material.total_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $('#type_').text(material.type.name);
    $('#updated_at_').text(material.updated_at);
    $('#infoModal').modal('show');
    console.log('ok');
}

function addAmount(id){

    Swal.fire({
        title: "กรอกจำนวนที่ต้องการเพิ่ม",
        text: "กรอกเฉพาะตัวเลขเท่านั้น",
        input: 'number',
        showCancelButton: true,
        inputAttributes: {
            step: 0.01,
        }
    }).then((result) => {
        if (result.value) {
            console.log("Result: " + result.value);
            $.post("/manage-materials/add-amount", data = {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        amount: result.value,
                    },
                    function (res) {
                        swal.fire(res.title, res.msg, res.status);
                        item_list_table.ajax.reload(null, false);
                    },
            );
        }
    });
}


</script>
@stop
