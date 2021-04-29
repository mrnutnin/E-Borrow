
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

    .my-swal {
        z-index: 99999!impotant;
    }
    </style>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="pull-right">


                        <button type="button" class="btn btn-primary" id="cartBtn" >รายการ (<span class="total-count"></span>)</button>
                        <button class="clear-cart btn btn-danger"><i class="ri-delete-bin-6-fill"></i></button>

                        {{-- <button type="button" id="modal2Btn" class="btn btn-primary">
                            <i class="fa fa-plus"></i> สร้างรายการเบิกวัสดุ
                        </button> --}}
                    </div>
                    <h3>รายการวัสดุ</h3>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered" id="material_list_table" style="width:100%" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ชื่อวัสดุ</th>
                                <th>ประเภทวัสดุ</th>
                                <th>จำนวนคงเหลือ</th>
                                <th>หน่วยนับ</th>
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
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          <h5 class="modal-title" id="exampleModalLabel">รายการเบิกวัสดุ</h5>

        </div>
        <div class="modal-body">
            {{-- <form action=""> --}}

                    <table id="table1"  style="width:100%" class="text-center">

                    </table>
                {{-- <div class="row text-center">
                    <div class="col-md-6" id="test1">

                    </div>
                    <div class="col-md-6" id="test2">

                    </div>
                </div> --}}

            {{-- </form> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="order" class="btn btn-primary">Order now</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script> --}}

<script>
var count = 0;
var array_items = [];
var array_amounts = [];

$( "#cartBtn" ).click(function() {
    blah();
    console.log(array_items);
    console.log(array_amounts);
    $('#cart').modal('show');
    var no = 1;
    count = 0;

    var table = document.getElementById("table1");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "no";
    cell2.innerHTML = "รายการ";
    cell3.innerHTML = "จำนวน";
    cell4.innerHTML = "หน่วยนับ";
    cell5.innerHTML = "";

    var index = '';
    array_items.forEach(function(o) {
        row = table.insertRow(-1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell3 = row.insertCell(2);
        cell4 = row.insertCell(3);
        cell5 = row.insertCell(4);
        cell1.innerHTML = no;
        cell2.innerHTML = o.name;
        cell3.innerHTML = array_amounts[count];
        cell4.innerHTML = o.unit.name;

        cell5.innerHTML = `<button class="btn btn-danger btm-sm" onclick="deleteItem(${count})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>`

        count++;
        no++;
    });
    console.log('ok');
});

$( "#order" ).click(function() {
    if(array_items.length > 0 && array_amounts.length > 0){
        $.post("/materials/order", data = {
            _token: '{{ csrf_token() }}',
            array_items: array_items,
            array_amounts: array_amounts,
         },
            function (res) {
                $('#cart').modal('hide');
                Swal.fire(res.title, res.msg, res.status);
                material_list_table.ajax.reload();
            },
        );
    }
});

function blah() {
        document.getElementById("table1").innerHTML = "";
        // document.getElementById("test2").innerHTML = "";
 }

 function deleteItem(index) {
     var id = array_items[index].id;
     console.log(id);
    $('#m'+id).text('');
    array_items.splice(index,1);
    array_amounts.splice(index,1);
    showCount(array_items.length);
    document.getElementById("table1").deleteRow(index+1);
 }

$( document ).ready(function() {
    $('.total-count').text(count);
});

async function addToList(item){

    await Swal.fire({
        title: 'กรุณากรอกจำนวน',
        input: 'number',
        showCancelButton: true,
        showConfirmButton: true,
        inputValidator: (value) => {
            if (!value || value == 0) {
                return 'กรุณากรอกจำนวน!';
            }else if(value > item.amount){
                return 'วัสดุไม่เพียงพอ!';
            }else{

                var found = findObjectByKey(array_items, 'id', item.id);
                console.log(found);
                if(found == 'f'){
                    array_items.push(item);
                    array_amounts.push(value);
                    showCount(array_items.length);
                    console.log(array_items);
                    // console.log(array_amounts);
                    console.log('case : false');
                }else{
                    console.log('case : true');
                    array_amounts[found] = value;
                    console.log(array_amounts);
                }
                var id = item.id.toString();
                $('#m'+id).text(value);

            }
        }
    });
}

function showCount(count){
    $('.total-count').text(count);
}

$('.clear-cart').click(function () {
    // count = 0;
    swal.fire('ลบรายการทั้งหมดแล้ว!!', '', 'success')
    $('.btn-sm').attr("disabled", false);
    array_items = [];
    console.log(array_items);
    $('.total-count').text(array_items.length);
});

function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return i;
        }
    }
    return 'f';
}

$("#material_list_table").ready(function () {

    material_list_table = $('#material_list_table').DataTable({
    "searching": true,
    "responsive": true,
    "pageLength": 10,
    "order": [
        [3, "desc"]
    ],
    "ajax": {
        "url": "/materials/show-materials",
        "method": "POST",
        "data": {
            "_token": "{{ csrf_token()}}",
        },
    },
    'columnDefs': [
        {
            "targets": [0, 1, 2, 3, 4, 5],
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
            "data": "type.name",
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
                var obj = JSON.stringify(full);
                var button = `<button type="button" onclick='addToList(${obj})' class="btn btn-primary btn-sm"> <i class="ri-add-fill"></i> เบิก <span class="badge badge-light" id="m${full.id}"></span></button>`;
                if(full.amount == 0){
                    button = `<span class="badge badge-danger">หมดสต๊อก</span>`;
                }
                return  button;
            }
        },
    ],
});
});



</script>
@stop

